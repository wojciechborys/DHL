function Earth( element, options ) {

	if ( typeof element == "string" ) {
		element = document.getElementById( element );
	}
	
	// check webgl support
	
	if ( ! Earth.isSupported( options.legacySupportIE11 ) ) {		
		element.classList.add( 'earth-show-fallback' );
		return false;
	}
	
	
	// remove fallback
	
	var fallback = element.querySelector( ".earth-fallback" );
	if ( fallback ) fallback.style.display = "none";
	
	
	// add default css
	
	if ( ! Earth.defaultCss && Earth.css ) {
		
		Earth.appendCss();
		Earth.defaultCss = true;
		
	}
	
	
	// add default meshes
	
	if ( ! Earth.defaultMesh && Earth.markerObj ) {
		
		Earth.addMesh( Earth.markerObj );
		Earth.defaultMesh = true;
		
	}
	
	
	element.classList.add( 'earth-js' );

	
	// reference to Earth
	element.earth = this;
	
	// reference to dom element
	this.element = element;
	
	// default options
	
	var defaults = {
		
		location: { lat: 10, lng: -80 },

		quality: 3,
		
		mapLandColor : '#44cc44',
		mapSeaColor : '#3399ff',
		mapBorderColor : '',
		mapBorderWidth : 0.3,
		mapStyles : '',
		
		texture : '',
		textureBlending : 'source-over',
		
		draggable : true,
		grabCursor : true,
		dragMomentum : 1,
		dragDamping : 0.7,
		dragPolarLimit : 0.3,
		
		polarLimit : 0.3,
		
		autoRotate : false,
		autoRotateSpeed : 1,
		autoRotateSpeedUp : 0,
		autoRotateDelay : 1000,
		autoRotateStart : 1000,
		autoRotateEasing : 'in-quad',
		
		zoom: 1,
		zoomable : false,
		zoomMin: 0.5,
		zoomMax: 1.25,
		zoomSpeed : 1,
		
		light: 'simple', // none, simple, sun
		lightAmbience: ( options.light == 'none' ) ? 1 : 0.5,
		lightIntensity: 0.5,
		lightColor: '#FFFFFF',
		lightGroundColor: '#999999',
		sunLocation : { lat: 0, lng: 0 },
		shadows: ( options.light == 'sun' ),
		
		shininess: 0.1,
		flatShading: false,
		transparent : false,
		
		paused : false,
		showHotspots : false,
		mapHitTest : false,

	};
	
	this.options = Object.assign(defaults, options);
	
	this.updateLatMinMax();
	
	
	this.overlays = [];
	
	this.ready = false;
	this.deltaTime = 0;
	
	this.goAnimation = null;
	this.zoomAnimation = null;
	
	this.dragging = false;
	
	this.autoRotating = false;
	this.autoRotateTime = 0;

	this.mouseOver = false;
	this.mouseOverEarth = false;
	this.mouseOverMarker = null;	

	this.mousePosition = false;
	this.lastMousePosition = false;
	this.lastMouseTime = 0;
	this.mouseVelocity = new THREE.Vector2();
	
	this.momentum = new THREE.Vector2();
	
	this.elementSize = new THREE.Vector2();

	this.init();
	
	return this;
	
}


Object.assign( Earth.prototype, THREE.EventDispatcher.prototype );


	
Earth.prototype.init = function() {
	
	this.clock = new THREE.Clock();
	this.raycaster = new THREE.Raycaster();

	// scene
	
	this.scene = new THREE.Scene();
	
	// camera
	
	this.camera = new THREE.PerspectiveCamera( 50, 1, 1, 2000 );
	this.camera.position.z = Earth.camDistance;
	this.scene.add( this.camera );
	
	this.radiusCamera = this.camera.clone();
	this.scene.add( this.radiusCamera );
	
	// renderer
	
	var webglContextAttr = {
		alpha: true,
		antialias: true,
	};
	
	if ( this.options.preserveDrawingBuffer ) webglContextAttr.preserveDrawingBuffer = true;
	
	this.renderer = new THREE.WebGLRenderer( webglContextAttr );
	
	if ( this.options.shadows ) {
		this.renderer.shadowMap.enabled = true;
		this.renderer.shadowMap.type = THREE.PCFSoftShadowMap;
	}
	
	this.renderer.setPixelRatio( window.devicePixelRatio );
	this.element.appendChild( this.renderer.domElement );
	
	
	// orbit controls
	
	this.controls = new THREE.OrbitControlsMod( this.camera, this.renderer.domElement, this );
	
	this.controls.addEventListener( "start", (function() {

		this.dragging = true;
		document.documentElement.classList.add( 'earth-dragging' );
		
		if ( this.goAnimation ) {
			this.goAnimation.stop();
		}
		
		if ( this.ready ) this.dispatchEvent( { type: 'dragstart' } );
		
	}).bind( this ) );
	
	this.controls.addEventListener( "change", (function( event ) {
		
		// adjust control rotate speed to zoom level
		//this.rotateSpeed = this.camera.position.length() / 65;
		
		this.needsUpdate = true;
		
		if ( this.ready ) this.dispatchEvent( { type: 'change' } );

	}).bind( this ) );

	this.controls.addEventListener( "end", (function() {
		
		this.momentum.copy( this.mouseVelocity );
		this.dragging = false;
		document.documentElement.classList.remove( 'earth-dragging' );
		
		if ( this.ready ) this.dispatchEvent( { type: 'dragend' } );
		
	}).bind( this ) );
	
	

	// earth
	
	this.sphere = new THREE.Mesh(
		new THREE.SphereBufferGeometry( Earth.earthRadius, this.options.quality*16, this.options.quality*12 ),
		new THREE.MeshBasicMaterial( { visible: false } )
	);
	this.sphere.renderOrder = -2;
	if ( this.options.shadows ) {
		this.sphere.receiveShadow = true;
		this.sphere.castShadow = true;
	}
	this.scene.add( this.sphere );
	this.loadTexture();
	
	
	// light
	
	this.ambientLight = new THREE.AmbientLight( 0xFFFFFF, this.options.lightAmbience );
	this.scene.add( this.ambientLight );
	
	
	if ( this.options.light == 'simple' ) {
		
		this.primaryLight = new THREE.HemisphereLight( new THREE.Color(this.options.lightColor), new THREE.Color(this.options.lightGroundColor), this.options.lightIntensity );
		this.scene.add( this.primaryLight );
		
	} else if ( this.options.light == 'sun' ) {
		
		this.primaryLight = new THREE.DirectionalLight( new THREE.Color(this.options.lightColor), this.options.lightIntensity );
		
		if ( this.options.shadows ) {
			this.primaryLight.castShadow = true;
			
			this.primaryLight.shadow.mapSize.width =
			this.primaryLight.shadow.mapSize.height = Earth.shadowSize[ this.options.quality ];
			
			var d = 25;
			this.primaryLight.shadow.camera.left = -d;
			this.primaryLight.shadow.camera.right = d;
			this.primaryLight.shadow.camera.top = d;
			this.primaryLight.shadow.camera.bottom = -d;
			this.primaryLight.shadow.camera.far = 3000;
			this.primaryLight.shadow.bias = 0.0001;
			//this.primaryLight.shadow.radius = 1.25;
		}
		
		this.scene.add( this.primaryLight );
	
	}
	
	
	// set properties
	
	Object.assign( this, this.options );
	
	
	// events
	
	var lastTouchStart;
	
	var mouseEventHandler = (function( event ){
		
		if ( this.paused ) return;
		
		
		// touch to mousevents
		
		var touchEndClick = false;
		
		if ( event.type == 'touchstart' ||  event.type == 'touchend' ) {
		
			if ( event.touches.length > 1 ) return;

			var x = event.changedTouches[0].clientX, y = event.changedTouches[0].clientY;
		
			if ( event.type == 'touchstart' ) {
				
				var type = 'mousedown';
				lastTouchStart = new THREE.Vector2( x, y );
				
			} else if ( event.type == 'touchend' ) {
				
				var type = 'mouseup';
				touchEndClick = lastTouchStart && lastTouchStart.distanceTo( new THREE.Vector2( x, y ) ) < Earth.maxTouchDistance;
				
			}
			
		} else {
			
			var type = event.type;
			var x = event.clientX, y = event.clientY;
			
		}
		

		var mouse = Earth.normalizeMouse( this.element, x, y );
		var intersects = this.raycast( mouse );
		
		for ( var i = 0; i < intersects.length; i++ ) {
			
			if ( intersects[ i ].object == this.sphere ) {
				var uv = intersects[ i ].uv;
				intersects[ i ].object.material.map.transformUv( uv );
				
				var mouseEvent = { type: type, x : mouse.x, y : mouse.y, location : Earth.uvToLatLng( uv ) };
				
				if ( this.mapHitTest ) {
					mouseEvent.id = this.hitTestMap( uv );
				}
				
				this.dispatchEvent( mouseEvent );
				
				if ( touchEndClick ) {
					mouseEvent.type = 'click';
					this.dispatchEvent( mouseEvent );
				}
				
				break;

			} else if ( ( type == 'click' || touchEndClick ) && intersects[ i ].object.userData.marker && intersects[ i ].object.userData.marker.hotspot && Earth.hasAnyEvent( intersects[ i ].object.userData.marker, 'click' ) ) {

				intersects[ i ].object.userData.marker.dispatchEvent( { type: "click" } );
				break;
				
			}
			
		}

	}).bind( this );
	
	this.element.addEventListener( 'click', mouseEventHandler );
	this.element.addEventListener( 'mousedown', mouseEventHandler );
	this.element.addEventListener( 'mouseup', mouseEventHandler );
	
	this.element.addEventListener( 'touchstart', mouseEventHandler );
	this.element.addEventListener( 'touchend', mouseEventHandler );
	
	
	
	this.element.addEventListener( 'mouseover', (function(event){
		
		if ( this.paused ) return;
		
		this.mouseOver = true;
		
	}).bind( this ) );
	
	this.element.addEventListener( 'mouseout', (function(event){
		
		if ( this.paused ) return;
		
		this.mouseOver = false;
		this.mouseOverEarth = false;
		
		if ( this.mouseOverMarker ) {
			this.mouseOverMarker.dispatchEvent( { type: "mouseout" } );
			this.mouseOverMarker = null;
		}
		
	}).bind( this ) );
	
	this.element.addEventListener( 'mousemove', (function(event) {
		
		if ( this.paused ) return;
		
		this.mousePosition = Earth.normalizeMouse( this.element, event.clientX, event.clientY );
	
	}).bind( this ) );
	
	this.renderer.domElement.addEventListener( 'touchmove', (function(event) {
		
		if ( this.paused ) return;
		
		this.mousePosition = Earth.normalizeMouse( this.element, event.touches[0].clientX, event.touches[0].clientY );

	}).bind( this ) );
	
	
	this.update();
	

	setTimeout( (function() {
		this.ready = true;
		this.element.classList.add( 'earth-ready' );
		this.dispatchEvent( { type: 'ready' } );	
	}).bind( this ) );
	
};




// properties

Object.defineProperties( Earth.prototype, {

	location : {
		get: function() {
			
			return Earth.worldToLatLng( this.camera.position );			
			
		},
		set: function( v ) {
			var latlng = Object.assign( {}, v );
			
			if ( ! this.goAnimation ) { // no limits during rotation animation
				// limit lat
				latlng.lat = Math.min( this.maxLat, Math.max( this.minLat, latlng.lat ) );
			}
			
			this.controls.setPosition( Earth.latLngToWorld( latlng, this.camera.position.length() ) );
			this.resetAutoRotate();
			
		}
	},
	
	paused : {
		get: function() {
			return this.options.paused;
		},
		set: function( v ) {
			if ( v ) {
				this.options.paused = true;
				
			} else if ( this.options.paused ) { // resume if paused
				this.options.paused = false;
				
				if ( this.ready ) { // if not ready, update will be called when ready
					this.update();
				}
				
			}
		}
	},
	
	draggable : {
		get: function() {
			return this.controls.enableRotate;
		},
		set: function( v ) {
			this.controls.enableRotate = v;
		}
	},

	dragPolarLimit : {
		get: function() {
			return this.options.dragPolarLimit;
		},
		set: function( v ) {
			this.options.dragPolarLimit = Math.max( 0, Math.min( 1, v ) );
			this.controls.minPolarAngle = this.options.dragPolarLimit/2 * Math.PI; // radians
			this.controls.maxPolarAngle = (1-this.options.dragPolarLimit/2) * Math.PI; // radians
		}
	},
	
	polarLimit : {
		get: function() {
			return this.options.polarLimit;
		},
		set: function( v ) {
			this.options.polarLimit = Math.max( 0, Math.min( 1, v ) );
			this.updateLatMinMax();
		}
	},
	
	
	autoRotate : {
		get: function() {
			return this.options.autoRotate;
		},
		set: function( v ) {
			this.options.autoRotate = v;
			if ( ! v ) {
				this.resetAutoRotate();
			}
		}
	},


	zoom : {
		get: function() {
			return Earth.camDistance / this.camera.position.length();
		},
		set: function( v ) {
			this.controls.setPosition( this.camera.position.normalize().multiplyScalar( Earth.camDistance / v ) );
		}
	},
	zoomable : {
		get: function() {
			return this.controls.enableZoom;
		},
		set: function( v ) {
			this.controls.enableZoom = v;
		}
	},
	zoomMin : {
		get: function() {
			return 1 / (this.controls.maxDistance / Earth.camDistance);
		},
		set: function( v ) {
			this.controls.maxDistance = Earth.camDistance * (1/v);
		}
	},
	zoomMax : {
		get: function() {
			return 1 / (this.controls.minDistance / Earth.camDistance);
		},
		set: function( v ) {
			this.controls.minDistance = Earth.camDistance * (1/v);
		}
	},
	zoomSpeed : {
		get: function() {
			return this.controls.zoomSpeed;
		},
		set: function( v ) {
			this.controls.zoomSpeed = v;
		}
	},
	
	
	lightAmbience : {
		get: function() {
			return this.ambientLight.intensity;
		},
		set: function( v ) {
			this.ambientLight.intensity = v;
		}
	},
	
	lightIntensity : {
		get: function() {
			if ( ! this.primaryLight ) return 1;
			return this.primaryLight.intensity;
		},
		set: function( v ) {
			if ( ! this.primaryLight ) return;
			this.primaryLight.intensity = v;
		}
	},	
	lightColor : {
		get: function() {
			if ( ! this.primaryLight ) return '#FFFFFF';
			return '#' + this.primaryLight.color.getHexString();
		},
		set: function( v ) {
			if ( ! this.primaryLight ) return;
			this.primaryLight.color = new THREE.Color(v);
		}
	},
	lightGroundColor : {
		get: function() {
			if ( ! this.primaryLight || ! this.primaryLight.isHemisphereLight ) return '#FFFFFF';
			return '#' + this.primaryLight.groundColor.getHexString();
		},
		set: function( v ) {
			if ( ! this.primaryLight || ! this.primaryLight.isHemisphereLight ) return;
			this.primaryLight.groundColor = new THREE.Color(v);
		}
	},
	
	sunLocation : {
		get: function() {
			if ( ! this.primaryLight || ! this.primaryLight.isDirectionalLight ) return { lat: 0, lng: 0 };
			return Earth.worldToLatLng( this.primaryLight.position );	
		},
		set: function( v ) {
			if ( ! this.primaryLight || ! this.primaryLight.isDirectionalLight ) return;
			this.primaryLight.position.copy( Earth.latLngToWorld( v, Earth.camDistance ) );
		}
	},
	

} );


Earth.prototype.updateLatMinMax = function() {
	this.minLat = (1 - this.options.polarLimit) * -90;
	this.maxLat = (1 - this.options.polarLimit) * 90;	
};


Earth.prototype.updateAutoRotate = function() {
	
	this.autoRotateTime += this.deltaTime;
	
	if ( this.autoRotateTime > this.autoRotateDelay ) {
		
		if ( ! this.autoRotate ) { // start autoRotate
			this.dispatchEvent( { type: 'autorotate' } );
			this.autoRotate = true;
		}
		
		var t = ( this.autoRotateTime - this.autoRotateDelay ) / this.autoRotateStart;
		
		if ( t > 1 ) {
			this.controls.autoRotateSpeed = this.autoRotateSpeed;
			this.controls.autoRotateSpeedUp = this.autoRotateSpeedUp;
		} else {
			this.controls.autoRotateSpeed = THREE.Math.lerp( 0, this.autoRotateSpeed, Earth.Animation.Easing[ this.autoRotateEasing ](t) );
			this.controls.autoRotateSpeedUp = THREE.Math.lerp( 0, this.autoRotateSpeedUp, Earth.Animation.Easing[ this.autoRotateEasing ](t) );
		}
	
	} else {

		this.controls.autoRotateSpeed = 0;
		this.controls.autoRotateSpeedUp = 0;
	
	}
	
};



Earth.prototype.startAutoRotate = function( easeIn ) {
	this.autoRotateTime = this.autoRotateDelay + ( ( easeIn ) ? 0 : this.autoRotateStart );
	this.autoRotate = true;
	this.autoRotating = true;
};

Earth.prototype.resetAutoRotate = function() {
	this.autoRotateTime = 0;
	this.autoRotating = false;
};


Earth.prototype.updateMomentum = function() {
	
	if ( this.dragging ) {
		
		this.resetAutoRotate();
		this.controls.autoRotateSpeed = 0;
		this.controls.autoRotateSpeedUp = 0;
		this.momentum.set( 0, 0 );
		
		return;
		
	}
	
	if ( this.momentum.equals( Earth.zeroMomentum ) ) {
		
		if ( this.autoRotate ) {
			
			this.updateAutoRotate();
			
		} else {
			
			this.controls.autoRotateSpeed = 0;
			this.controls.autoRotateSpeedUp = 0;
			
		}
		
		return;
		
	}
	
	this.resetAutoRotate();
	
	this.controls.autoRotateSpeed = this.momentum.x * 10000;
	this.controls.autoRotateSpeedUp = this.momentum.y * 10000;
	
	this.momentum.set(
		THREE.Math.lerp( this.momentum.x, 0, this.deltaTime / (2000 - (this.dragDamping*1999)) ),
		THREE.Math.lerp( this.momentum.y, 0, this.deltaTime / (2000 - (this.dragDamping*1999)) )
	);
	
	
	if ( Math.abs(this.momentum.x) < 0.00005 ) {
		this.momentum.x = 0;
	}
	if ( Math.abs(this.momentum.y) < 0.00005 ) {
		this.momentum.y = 0;
	}	
	
};


Earth.prototype.updateMouse = function() {
	
	if ( this.dragging && this.dragMomentum && this.mousePosition && this.lastMousePosition ) {
		/*
		var moveVelocity = Earth.normalizeElement( this.mousePosition, this.elementSize ).sub(
			Earth.normalizeElement(this.lastMousePosition, this.elementSize)
		).multiplyScalar( 200 * this.dragMomentum );*/
		
		var moveVelocity = this.mousePosition.clone().sub(
			this.lastMousePosition
		).multiplyScalar( 0.1 * this.dragMomentum );
		
		this.mouseVelocity.lerp( moveVelocity, this.deltaTime/100 );
		
	} else {
		
		this.mouseVelocity.set( 0, 0 );
		
	}
	
	this.lastMousePosition = ( this.mousePosition ) ? this.mousePosition.clone() : false;
	
	
	// mouse over / out
	
	var overMarker = false;
	this.mouseOverEarth = false;
	
	
	if ( this.mouseOver && ! this.dragging ) {
	
		var intersects = this.raycast( this.mousePosition );
		
		for ( var i = 0; i < intersects.length; i++ ) {
			
			var obj = intersects[ i ].object;
			
			if ( obj == this.sphere ) {
				this.mouseOverEarth = true;
				break;
			
			} else if ( ! overMarker && obj.userData.marker && obj.userData.marker.hotspot && (
							Earth.hasAnyEvent( obj.userData.marker, 'click' ) ||
							Earth.hasAnyEvent( obj.userData.marker, 'mouseover' ) ||
							Earth.hasAnyEvent( obj.userData.marker, 'mouseout' )
						) ) {
				overMarker = intersects[ i ].object.userData.marker;
				
			}
		}
		
	}
	
	
	if ( overMarker ) {
		
		if ( this.mouseOverMarker && this.mouseOverMarker != overMarker ) {
			this.mouseOverMarker.dispatchEvent( { type: "mouseout" } );
		}
		
		this.mouseOverMarker = overMarker;
		this.mouseOverMarker.dispatchEvent( { type: "mouseover" } ); 
		
	} else if ( this.mouseOverMarker ) {
		
		this.mouseOverMarker.dispatchEvent( { type: "mouseout" } );
		this.mouseOverMarker = null;
		
	}
	
	
	if ( this.mouseOverMarker && Earth.hasAnyEvent( this.mouseOverMarker, 'click' ) ) {
		this.element.classList.add( 'earth-clickable' );
	} else {
		this.element.classList.remove( 'earth-clickable' );
	}
	
	
	if ( this.draggable && this.grabCursor && this.mouseOverEarth ) {
		this.element.classList.add( 'earth-draggable' );
	} else {
		this.element.classList.remove( 'earth-draggable' );
	}
	
};

	
Earth.prototype.hitTestMap = function( uv ) {
	
	if ( ! Earth.mapSvg ) return '';
	
	var hitTester = document.getElementById('earth-js-hittest');
	
	if ( ! hitTester ) {
		hitTester = document.createElement( 'div' );
		document.body.appendChild( hitTester );
		hitTester.id = 'earth-js-hittest';
		hitTester.innerHTML = Earth.mapSvg;
	}
	
	hitTester.style.display = 'block';
	
	var w = hitTester.offsetWidth, h = hitTester.offsetHeight;
	var elem = document.elementFromPoint( uv.x * w, uv.y * h );
	
	hitTester.style.display = 'none';

	if ( elem && elem.nodeName.toUpperCase() == 'PATH' && elem.id ) {
		return elem.id;
	} else {
		return '';
	}
	
};


Earth.prototype.raycast = function( mouse ) {
	
	this.raycaster.setFromCamera( Earth.normalizeRaycast(mouse), this.camera );
	return this.raycaster.intersectObjects( this.scene.children );
	
};


Earth.prototype.loadTexture = function() {
	
	if ( Earth.mapSvg ) {
		
		if ( this.options.legacySupportIE11 && Earth.isIE11() ) {
			
			if ( this.options.fallbackMapUrlIE11  ) {
				
				this.mapImage = document.createElement("img");
				this.mapImage.setAttribute( "src", this.options.fallbackMapUrlIE11 );
				this.mapImage.onload = this.drawTexture.bind( this );
				
			} else {
				
				setTimeout( this.drawTexture.bind( this ), 1 );
				
			}
			
			
		} else {
		
			var style = '<style type="text/css">';
			
			style += '#SEA { fill:'+ this.options.mapSeaColor +'; }';
			
			style += 'path { fill:'+ this.options.mapLandColor +'; ';
			style += 'stroke:'+ ( this.options.mapBorderColor ? this.options.mapBorderColor : this.options.mapLandColor ) +'; ';
			style += 'stroke-width:'+ this.options.mapBorderWidth +'; stroke-miterlimit:1; }';
			
			style += this.options.mapStyles;
			
			style += '</style>';
			
			var svg = Earth.mapSvg;
			svg = svg.replace( /(<svg[^>]+>)/i, '$1 ' + style );

			this.mapImage = document.createElement("img");
			this.mapImage.setAttribute( "src", "data:image/svg+xml;base64," + btoa(unescape(encodeURIComponent(svg))) );
			this.mapImage.onload = this.drawTexture.bind( this );
		
		}
		
	} else {
		
		setTimeout( this.drawTexture.bind( this ), 1 );
		
	}
	
};


Earth.prototype.drawTexture = function() {
	
	this.mapCanvas = document.createElement( "canvas" );
	this.mapCanvas.width = Earth.textureSize[ this.quality ];
	this.mapCanvas.height = Earth.textureSize[ this.quality ] / 2;
	
	this.mapContext = this.mapCanvas.getContext("2d");
	
	if ( this.mapImage ) {
		this.mapContext.drawImage( this.mapImage, 0, 0, this.mapImage.width, this.mapImage.height, 0, 0, this.mapCanvas.width, this.mapCanvas.height );
	}
	
	// texture overlay
	
	if ( this.texture ) {
		
		var overlayImg = ( typeof this.texture == 'string' ) ? document.getElementById( this.texture ) : this.texture;
			
		this.mapContext.globalCompositeOperation = this.textureBlending;
		this.mapContext.drawImage( overlayImg, 0, 0, overlayImg.width, overlayImg.height, 0, 0, this.mapCanvas.width, this.mapCanvas.height );
		this.mapContext.globalCompositeOperation = 'source-over';
		
	}
	
	
	this.dispatchEvent( { type: 'drawtexture', canvas: this.mapCanvas, context : this.mapContext } );
	
	
	this.mapTexture = new THREE.CanvasTexture( this.mapCanvas );
	this.mapTexture.wrapS = this.mapTexture.wrapT = THREE.RepeatWrapping;
	this.mapTexture.anisotropy = 16;
	this.mapTexture.offset = new THREE.Vector2( -0.25, 0 );
		
	
	var earthMaterial = {
		map: this.mapTexture,
		shininess: this.shininess * 100,
		flatShading: this.flatShading
	};
	
	
	if ( this.transparent ) {
		
		//earthMaterial.side = THREE.FrontSide;
		earthMaterial.transparent = true;
		earthMaterial.depthWrite = false;
		
		// inner earth
		
		this.innerSphere = new THREE.Mesh(
			new THREE.SphereBufferGeometry( Earth.earthRadius - 0.001, this.options.quality*16, this.options.quality*12 ),
			new THREE.MeshBasicMaterial( {
				transparent : true,
				side: THREE.BackSide,
				depthWrite : false,
				map: this.mapTexture,
				flatShading: this.flatShading
			} )
		);
		this.innerSphere.renderOrder = -3;
		
		this.sphere.add( this.innerSphere );

	}

	this.sphere.material = new THREE.MeshPhongMaterial( earthMaterial );		
	
};


Earth.prototype.resize = function() {
	
	if ( this.elementSize.x == this.element.offsetWidth && this.elementSize.y == this.element.offsetHeight ) return; // not resized
	
	this.elementSize.set( this.element.offsetWidth, this.element.offsetHeight );
	
	this.camera.aspect = this.element.offsetWidth / this.element.offsetHeight;
	this.camera.updateProjectionMatrix();
	this.renderer.setSize( this.element.offsetWidth, this.element.offsetHeight );
	
	this.needsUpdate = true;
	
};


Earth.prototype.update = function() {
	
	if ( this.paused ) return;
	
	requestAnimationFrame( this.update.bind(this) );
	
	if ( ! this.ready ) return;
	
	this.resize();
	
	this.deltaTime = Math.min( 100, this.clock.getDelta() * 1000 );
	
	this.updateMouse();
	this.updateMomentum();
	this.controls.update();

	Earth.Animation.update( this.deltaTime );
	
	this.dispatchEvent( { type: "update" } );
	
	this.renderer.render( this.scene, this.camera );
	
	this.updateOverlays();
	this.needsUpdate = false;
	
};



Earth.prototype.addMarker = function( options ) {
	return new Earth.Marker( options, this );
};

Earth.prototype.addLine = function( options ) {
	return new Earth.Line( options, this );
};

Earth.prototype.addOverlay = function( options ) {
	return new Earth.Overlay( options, this );
};


Earth.prototype.updateOverlays = function() {
	
	var updateOrder = false;
	var camDistance = this.camera.position.length();
	var elementScale = Math.min( this.elementSize.x, this.elementSize.y ) / 1000;
	
	for (var i=0; i < this.overlays.length; i++) {
		
		var overlay = this.overlays[i];
		if ( ! overlay.visible || ( ! this.needsUpdate && ! overlay.needsUpdate ) ) continue;
		
		updateOrder = true;
	
		var worldPos = Earth.latLngToWorld( overlay.location, Earth.earthRadius + overlay.offset );
		var elementPos = Earth.worldToElement( worldPos, this.elementSize, this.camera );
		
		overlay.distance = this.camera.position.distanceTo( worldPos );
		
		
		// occlusion
		if ( overlay.occlude && overlay.isOccluded( elementPos, overlay.distance, camDistance ) ) {
			overlay.element.classList.add('earth-occluded');
		} else {
			overlay.element.classList.remove('earth-occluded');
		}		
		
		
		// scaling
		var scale = 1;
		
		if ( overlay.depthScale ) {
			scale *= Math.max( 0, 1 - overlay.depthScale + (camDistance-overlay.distance) / Earth.earthRadius * overlay.depthScale );
		}		
		if ( overlay.zoomScale ) {
			scale *= THREE.Math.lerp( 1, this.zoom, overlay.zoomScale );
		}
		if ( overlay.elementScale ) {
			scale *= THREE.Math.lerp( 1, elementScale, overlay.elementScale );
		}
		
		scale = Math.max(0, scale);
		var scaleTransform = ( scale!=1 ) ? ' scale('+ scale +')' : '';
		
		
		// apply transform
		overlay.element.style.transform = overlay.transform + ' translate('+ elementPos.x +'px, '+ elementPos.y +'px)' + scaleTransform;
		
		
		overlay.needsUpdate = false;
		
	}
	
	
	if ( updateOrder ) {
	
		// sort by cam distance for z-index
		
		this.overlays.sort( function(a, b) {
			return b.distance - a.distance;
		} );
	
		for (var i=0; i < this.overlays.length; i++) {
			this.overlays[i].element.style.zIndex = this.overlays[i].zIndex + i;
		}
		
	}
	
};


// PUBLIC
// special options: zoom, approachAngle
// returns false or aniInstance
	
Earth.prototype.goTo = function( location, options ) {
	
	if ( ! options ) options = {};
	
	if ( options.approachAngle ) {
	
		var toPos = Earth.latLngToWorld( location, Earth.earthRadius );
		var camPos = this.camera.position.clone().normalize().multiplyScalar( Earth.earthRadius );
		
		if ( THREE.Math.radToDeg( toPos.angleTo( camPos ) ) > options.approachAngle ) {
			
			for ( var i=1; i <= 32; i++ ) {
				
				var midPos = new THREE.Vector3().lerpVectors( camPos, toPos, i/32 ).normalize().multiplyScalar( Earth.earthRadius );
				
				if ( THREE.Math.radToDeg( toPos.angleTo( midPos ) ) <= options.approachAngle ) {
					
					location = Earth.worldToLatLng( midPos );
					break;
					
				}
				
			}
			
		} else {
		
			return false;
			
		}
		
	}
	
	
	// cancel previous animation
	
	if ( this.goAnimation ) {
		this.goAnimation.stop();
	}
	
	
	var to = Object.assign( {}, location );	
	
	// limit lat
	to.lat = Math.min( this.maxLat, to.lat );
	to.lat = Math.max( this.minLat, to.lat );
	
	
	var thisEarth = this;

	var ani = {
		_end : function() {
			thisEarth.goAnimation = null;
			if ( thisEarth.zoomAnimation ) thisEarth.zoomAnimation.stop();
			thisEarth.zoomAnimation = null;
		},
		lerpLatLng : true
	};
	
	Object.assign( ani, options );
	
	this.goAnimation = this.animate( 'location', to, ani );
	
	
	if ( options.zoom ) {
		
		this.zoomAnimation = this.animate( 'zoom', options.zoom, {
			duration : this.goAnimation.duration
		} );
		
	}
	
	return this.goAnimation;
	
};


// PUBLIC

Earth.prototype.getPoint = function( location, offset ) {
	
	if ( ! offset ) offset = 0;
	
	var worldPos = Earth.latLngToWorld( location, Earth.earthRadius + offset );
	
	return Earth.worldToElement( worldPos, this.elementSize, this.camera );	
	
};


// PUBLIC

Earth.prototype.getLocation = function( point ) {
	
	var mouse = Earth.normalizeMouse( this.element, point.x, point.y );
	
	this.raycaster.setFromCamera( Earth.normalizeRaycast(mouse), this.camera );
	var intersects = this.raycaster.intersectObjects( [this.sphere] );
	
	for ( var i = 0; i < intersects.length; i++ ) {
		
		var uv = intersects[ i ].uv;
		intersects[ i ].object.material.map.transformUv( uv );
		
		return Earth.uvToLatLng( uv );
		
	}
	
	return false;
	
};


// PUBLIC

Earth.prototype.getRadius = function() {
	
	this.radiusCamera.position.z = this.camera.position.length();
	return 	this.elementSize.y / 2 -
			Earth.worldToElement( new THREE.Vector3( 0, Earth.earthRadius, 0 ), this.elementSize, this.radiusCamera ).y;
	
};


	
// static const

Earth.earthRadius = 8;
Earth.camDistance = 24;
Earth.textureSize = [ 0, 512, 1024, 2048, 4096, 8192 ];
Earth.shadowSize  = [ 0, 512, 512, 1024, 2048, 4096 ];

Earth.invisibleMaterial = new THREE.MeshBasicMaterial( {visible: false} );
Earth.hotspotMaterial = new THREE.MeshBasicMaterial( {color: 0x00ff00, wireframe: true} );

Earth.up = new THREE.Vector3( 0, 1, 0 );
Earth.left = new THREE.Vector3( 1, 0, 0 );
Earth.back = new THREE.Vector3( 0, 0, 1 );
Earth.zero = new THREE.Vector3( 0, 0, 0 );

Earth.zeroMomentum = new THREE.Vector2();

Earth.maxTouchDistance = 10;


// static vars

Earth.defaultCss = false;
Earth.defaultMesh = false;
Earth.meshes = {};



// static functions

Earth.dispatchLoadedEvent = function() {
	
	if ( typeof window.CustomEvent === "function" ) {
		var loadedEvent = new CustomEvent( "earthjsload" );	
	} else {
		var loadedEvent = document.createEvent( "CustomEvent" );
		loadedEvent.initCustomEvent( "earthjsload", false, false, undefined );
	}
	
	window.dispatchEvent( loadedEvent );
	
};


Earth.appendCss = function() {

		Earth.styleElement = document.createElement('style');

		if ( Earth.styleElement.styleSheet ) {
			Earth.styleElement.styleSheet.cssText = Earth.css;
		} else {
			Earth.styleElement.appendChild( document.createTextNode( Earth.css ) );
		}
		
		document.getElementsByTagName("head")[0].appendChild( Earth.styleElement );

};


// parse meshes from obj file string

Earth.addMesh = function( objString ) {
	
	var loader = new THREE.OBJLoader();
	var lib = loader.parse( objString );
	
	lib.traverse( function ( child ) {
		
		if ( ! child.name ) return;
		
		Earth.meshes[ child.name.split('_')[0] ] = child;
		child.material = new THREE.MeshPhongMaterial( { color: 0xFF0000, shininess: 0.3, flatShading: false } );
		
	} );
	
};


// check for webgl support

Earth.isSupported = function( supportIE11 ) {
	
	try {
		
		if ( ! supportIE11 && Earth.isIE11() ) return false;
		
		var canvas = document.createElement( 'canvas' );
		return window.WebGLRenderingContext && ( canvas.getContext( 'webgl' ) || canvas.getContext( 'experimental-webgl' ) );

	} catch ( e ) {
		
		return false;

	}
	
};

Earth.isIE11 = function( ) {
	return !! window.MSInputMethodContext && !! document.documentMode;	
};


Earth.getPathPoints = function( fromPos, toPos, subdevisions, offset, offsetFlow, offsetEasing ) {
	
	offset += Earth.earthRadius;	
	
	var points = [ fromPos, toPos ];
	
	for (var i=0; i < subdevisions; i++) {
		points = Earth.subdividePath( points, offset );
	}
	
	
	if ( offsetFlow ) {
		for (var i=0; i < points.length; i++) {
			points[i].multiplyScalar( 1 + Earth.Animation.Easing[ offsetEasing ]( i / (points.length-1) ) * offsetFlow/10 );
		}
	}
	
	return points;
	
};

Earth.subdividePath = function( points, offset ) {

	if ( points.length < 2 ) return [];

	var new_points = [];
	
	new_points.push( points[0] );
	
	// from point
	var fromPoint = points[0];
	
	for (var i=1; i < points.length; i++) {
		
		// to point
		toPoint = points[i];
		
		// mid point
		new_points.push(
			new THREE.Vector3().lerpVectors( fromPoint, toPoint, 0.5 ).normalize().multiplyScalar( offset )
		);
		
		new_points.push( toPoint );
		
		fromPoint = toPoint;
		
	}
	
	return new_points;
	
};



Earth.mouseCenterOffset = function( mouse, element, radius ) {
	var rect = element.getBoundingClientRect();
	var relMouse = new THREE.Vector2( mouse.x - rect.left - rect.width/2 , mouse.y - rect.top - rect.height/2 );
	return Math.min( 1, relMouse.length() / radius );
};

Earth.normalizeMouse = function( element, x, y ) {
	var rect = element.getBoundingClientRect();
	return  new THREE.Vector2( ( x - rect.left ) / rect.width, ( y - rect.top ) / rect.height );
};


Earth.normalizeElement = function( v2, element ) {
	return new THREE.Vector2( v2.x / element.x, v2.y / element.y );
};

Earth.normalizeRaycast = function( v2 ) {
	return new THREE.Vector2( ( v2.x * 2 ) - 1, - ( v2.y * 2 ) + 1 );
};



Earth.latLngToWorld = function( location, radius ){
	
	var phi   = THREE.Math.degToRad( -location.lat + 90 );
	var theta = THREE.Math.degToRad( location.lng + 180 );
   
   return new THREE.Vector3().setFromSphericalCoords( radius, phi, theta );
   
};

Earth.worldToLatLng = function( pos ) {
	
	var s = new THREE.Spherical().setFromVector3 ( pos );
	   
	var loc = {
		lat: THREE.Math.radToDeg( -s.phi ) + 90,
		lng: THREE.Math.radToDeg( s.theta ) + 180
	};
	
	Earth.wrapLatLng( loc );
   
	return loc;
   
};

Earth.uvToLatLng = function( uv ) {
	
	return {
		lat: (0.5 - uv.y) * 180,
		lng: (uv.x - 0.5) * 360
	};
	
};

Earth.latLngToUv = function( latlng ) {
	
	return new THREE.Vector2(
		latlng.lng / -360 + 0.5,
		0.5 + latlng.lat / -180
	);
	
};


Earth.wrapLatLng = function( latlng ) {
	/*
	if ( latlng.lat >  90 ) latlng.lat -= 180;
	else if ( latlng.lat <  -90 ) latlng.lat += 180;
	
	if ( latlng.lng >  180 ) latlng.lng -= 360;
	else if ( latlng.lng <  -180 ) latlng.lng += 360;
	*/
	
	latlng.lat = Earth.wrap( latlng.lat, -90, 90 );
	latlng.lng = Earth.wrap( latlng.lng, -180, 180 );
	
	return latlng;
	
};

Earth.wrapLngForLerp = function( fromLng, toLng ) {
	
	if ( Math.abs( toLng - fromLng ) > 180 ) {
		toLng = ( toLng < 0 ) ? toLng + 360 : toLng - 360;
	}
	
	return toLng;
	
};


Earth.worldToElement = function( position, element, camera ) {
	
	var w = element.x / 2;
	var h = element.y / 2;

	var pos = position.clone().project( camera );
	
	return new THREE.Vector2(
		( pos.x * w ) + w,
		- ( pos.y * h ) + h
	);
	
};


Earth.hasAnyEvent = function( obj, type ) {
	
	return obj._listeners && obj._listeners[type] && obj._listeners[type].length;
	
};


Earth.positionOfEvent = function( event ) {
	
	if ( event.type == 'touchstart' || event.type == 'touchmove' ) {

		return new THREE.Vector2( event.touches[0].clientX, event.touches[0].clientY );
	
	} else if ( event.type == 'touchend' ) {
	
		return new THREE.Vector2( event.changedTouches[0].clientX, event.changedTouches[0].clientY );
		
	} else {
		
		return new THREE.Vector2(  event.clientX, event.clientY );
		
	}
	
};


Earth.latLngDifference = function( start, end ) {
	
	var endLng = Earth.wrapLngForLerp( start.lng, end.lng );
	
	return {
		lat: start.lat - end.lat,
		lng: start.lng - endLng
	};
	
};


Earth.getLineDistance = function( points ) {
	
	var distance = 0;
	var from = points[0];
	
	for ( var i = 1; i < points.length; i++ ) {
		var to = points[i];
		distance += from.distanceTo( to );
		from = to;
	} 
	
	return distance;
	
};

Earth.lerpAngle = function( fromA, toA, t ) {
    var fullA = Math.PI * 2;
    var a = (toA - fromA) % fullA;
    return fromA + ( 2 * a % fullA - a ) * t;
};

Earth.wrap = function( val, min, max ) {
	var range = max - min;
	return min + ( ( ( (val - min) % range ) + range ) % range );
};


// PUBLIC

Earth.getDistance = function( from, to ) {
	
	var degLat = THREE.Math.degToRad( to.lat - from.lat );
	var degLng = THREE.Math.degToRad( to.lng - from.lng );
	
	var a = Math.sin(degLat / 2) * Math.sin(degLat / 2) +
	Math.cos( THREE.Math.degToRad( from.lat ) ) * Math.cos( THREE.Math.degToRad( to.lat ) ) *
	Math.sin( degLng / 2 ) * Math.sin( degLng / 2 );
	
	var c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1 - a));
	
	return  6378.137 * c; // mean radius in km
	
};


// PUBLIC

Earth.getAngle = function( from, to ) {
	
	var fromPos = Earth.latLngToWorld( from, Earth.earthRadius );
	var toPos = Earth.latLngToWorld( to, Earth.earthRadius );
	
	return THREE.Math.radToDeg( fromPos.angleTo( toPos ) );
	
};


// PUBLIC		lerp latlng location
// from			latlng
// to			latlng
// t			time 0-1
// lerpLatLng	lerp latlng values or 3d position

Earth.lerp = function( from, to, t, lerpLatLng ) {

	if ( lerpLatLng ) {
		
		return Earth.wrapLatLng( {
			lat: THREE.Math.lerp( from.lat, to.lat, t ),
			lng: THREE.Math.lerp( from.lng, Earth.wrapLngForLerp( from.lng, to.lng ), t )
		} );
		
	} else {

		return Earth.worldToLatLng(
			Earth.latLngToWorld( from, Earth.earthRadius ).lerp( Earth.latLngToWorld( to, Earth.earthRadius ), t )
		);
	
	}
	
};



/* MARKER */

Earth.Marker = function( initOptions, thisEarth ) {
	
	// default options
	
	var defaults = {
		
		earth : thisEarth,
		
		location : { lat : 0, lng : 0 },

		offset: 0,
		
		mesh: ["Pin", "Needle"],
		color: '#FF0000',
		color2: '#AAAAAA',
		color3: '#AAAAAA',
		color4: '#AAAAAA',
		color5: '#AAAAAA',
		
		scale : 1,
		visible : true,
		
		hotspot : true,
		hotspotRadius : 0.5,
		hotspotHeight : 1.6,

		align : true,
		rotationX : 0,
		rotationY : 0,
		rotationZ : 0,		
		lookAt : false,
		lookAngle: 0, // private
		useLookAngle : false, // private
		
		shininess: 0.3,
		flatShading: false,
		castShadow: thisEarth.shadows,
		receiveShadow : false,
		alwaysBehind : false,
		alwaysOnTop : false,
		transparent : ( typeof initOptions.opacity != 'undefined' ),
		
	};
	
	this.options = Object.assign(defaults, initOptions);
	
	
	// create object
	
	if ( this.options.hotspot ) {
	
		var bufferGeo = new THREE.CylinderBufferGeometry( this.options.hotspotRadius, this.options.hotspotRadius*0.66, this.options.hotspotHeight, 5 );
		bufferGeo.translate( 0, this.options.hotspotHeight/2, 0 );
		this.object3d = new THREE.Mesh( bufferGeo, (thisEarth.showHotspots) ? Earth.hotspotMaterial : Earth.invisibleMaterial );
	
	} else {

		this.object3d = new THREE.Object3D();
		
	}
	
	// add meshes
	
	if ( typeof this.options.mesh == "string" ) {
		var meshes = ( this.options.mesh ) ? [ this.options.mesh ] : [];
	} else {
		var meshes = this.options.mesh;
	}
	
	for ( var i = 0; i < meshes.length; i++ ) {
		
		var meshClone = Earth.meshes[ meshes[i] ].clone();
		meshClone.material = meshClone.material.clone();
		this.object3d.add( meshClone );
		
	}
	
	this.object3d.userData.marker = this;	
	thisEarth.scene.add( this.object3d );
	
	// set props
	Object.assign( this, this.options );

	this.ready = true;
	this.update();
	
	return this;
	
};

Object.assign( Earth.Marker.prototype, THREE.EventDispatcher.prototype );


// properties

Object.defineProperties( Earth.Marker.prototype, {
	
	color: {
		get: function() {
			if ( ! this.object3d.children[0] ) return '#FFFFFF';
			return '#' + this.object3d.children[0].material.color.getHexString();
		},
		set: function( v ) {
			if ( ! this.object3d.children[0] ) return;
			this.object3d.children[0].material.color.set( v );
		}
	},
	color2: {
		get: function() {
			if ( ! this.object3d.children[1] ) return '#FFFFFF';
			return '#' + this.object3d.children[1].material.color.getHexString();
		},
		set: function( v ) {
			if ( ! this.object3d.children[1] ) return;
			this.object3d.children[1].material.color.set( v );
		}
	},
	color3: {
		get: function() {
			if ( ! this.object3d.children[2] ) return '#FFFFFF';
			return '#' + this.object3d.children[2].material.color.getHexString();
		},
		set: function( v ) {
			if ( ! this.object3d.children[2] ) return;
			this.object3d.children[2].material.color.set( v );
		}
	},
	color4: {
		get: function() {
			if ( ! this.object3d.children[3] ) return '#FFFFFF';
			return '#' + this.object3d.children[3].material.color.getHexString();
		},
		set: function( v ) {
			if ( ! this.object3d.children[3] ) return;
			this.object3d.children[3].material.color.set( v );
		}
	},
	color5: {
		get: function() {
			if ( ! this.object3d.children[4] ) return '#FFFFFF';
			return '#' + this.object3d.children[4].material.color.getHexString();
		},
		set: function( v ) {
			if ( ! this.object3d.children[4] ) return;
			this.object3d.children[4].material.color.set( v );
		}
	},
	
	shininess: {
		get: function() {
			if ( ! this.object3d.children[0] ) return 0.3;
			return this.object3d.children[0].material.shininess / 100;
		},
		set: function( v ) {
			for ( var i=0; i < this.object3d.children.length; i++ ) {
				this.object3d.children[i].material.shininess = v * 100;
			}
		}
	},	
	flatShading: {
		get: function() {
			if ( ! this.object3d.children[0] ) return 0.3;
			return this.object3d.children[0].material.flatShading;
		},
		set: function( v ) {
			for ( var i=0; i < this.object3d.children.length; i++ ) {
				this.object3d.children[i].material.flatShading = v;
			}
		}
	},
	castShadow : {
		get: function() {
			if ( ! this.object3d.children[0] ) return false;
			return this.object3d.children[0].castShadow;
		},
		set: function( v ) {
			for ( var i=0; i < this.object3d.children.length; i++ ) {
				this.object3d.children[i].castShadow = v;
			}
		}
	},
	receiveShadow: {
		get: function() {
			if ( ! this.object3d.children[0] ) return false;
			return this.object3d.children[0].receiveShadow;
		},
		set: function( v ) {
			for ( var i=0; i < this.object3d.children.length; i++ ) {
				this.object3d.children[i].receiveShadow = v;
			}
		}
	},
	alwaysBehind: {
		get: function() {
			if ( ! this.object3d.children[0] ) return false;
			return ! this.object3d.children[0].material.depthWrite;
		},
		set: function( v ) {
			for ( var i=0; i < this.object3d.children.length; i++ ) {
				this.object3d.children[i].material.depthWrite = ! v;
				this.object3d.children[i].renderOrder = ( v ) ? -1 : 0;
			}
		}
	},
	alwaysOnTop: {
		get: function() {
			if ( ! this.object3d.children[0] ) return false;
			return ! this.object3d.children[0].material.depthTest;
		},
		set: function( v ) {
			for ( var i=0; i < this.object3d.children.length; i++ ) {
				this.object3d.children[i].material.depthTest = ! v;
			}
		}
	},
	
	transparent : {
		get: function() {
			if ( ! this.object3d.children[0] ) return false;
			return this.object3d.children[0].material.transparent;
		},
		set: function( v ) {
			for ( var i=0; i < this.object3d.children.length; i++ ) {
				this.object3d.children[i].material.transparent = v;
			}
		}
	},
	
	opacity : {
		get: function() {
			if ( ! this.object3d.children[0] ) return 1;
			return this.object3d.children[0].material.opacity;
		},
		set: function( v ) {
			for ( var i=0; i < this.object3d.children.length; i++ ) {
				this.object3d.children[i].material.opacity = v;
			}
		}
	},

	visible : {
		get: function() {
			return this.object3d.visible;
		},
		set: function(state) {
			this.object3d.visible = state;
		}
	},

	scale : {
		get: function() {
			return this.object3d.scale.x;
		},
		set: function( v ) {
			this.object3d.scale.set( v, v, v );
		}
	},
	
	align : {
		get: function() {
			return this.options.align;
		},
		set: function( v ) {
			this.options.align = v;
			if ( this.ready ) this.update();
		}
	},	
	rotationX : {
		get: function() {
			return this.options.rotationX;
		},
		set: function( v ) {
			this.options.rotationX = v;
			if ( this.ready ) this.update();
		}
	},
	rotationY : {
		get: function() {
			return this.options.rotationY;
		},
		set: function( v ) {
			this.options.rotationY = v;
			if ( this.ready ) this.update();
		}
	},
	rotationZ : {
		get: function() {
			return this.options.rotationZ;
		},
		set: function( v ) {
			this.options.rotationZ = v;
			if ( this.ready ) this.update();
		}
	},
	lookAt : {
		get: function() {
			return this.options.lookAt;
		},
		set: function( v ) {
			this.useLookAngle = false;
			this.options.lookAt = v;
			if ( this.ready ) this.update();
		}
	},
	lookAngle : {
		get: function() {
			return this.options.lookAngle;
		},
		set: function( v ) {
			this.options.lookAngle = v;
			if ( this.ready ) this.update();
		}
	},
	
	offset : {
		get: function() {
			return this.options.offset;
		},
		set: function( v ) {
			this.options.offset = v;
			if ( this.ready ) this.update();
		}
	},
	
	location : {
		get: function() {
			return this.options.location;
		},
		set: function( v ) {
			this.options.location = v;
			if ( this.ready ) this.update();
		}
	}
	
});





// methods

Earth.Marker.prototype.remove = function() {
	
	if ( this == this.earth.mouseOverMarker ) {
		this.earth.mouseOverMarker.dispatchEvent( { type: "mouseout" } );
		this.earth.mouseOverMarker = null;
	}
	
	for ( var i=0; i < this.object3d.children.length; i++ ) {
		if ( this.object3d.children[i].material ) {
			this.object3d.children[i].material.dispose();
		}
		if ( this.object3d.children[i].geometry ) {
			this.object3d.children[i].geometry.dispose();
		}
	}
	
	if ( this.object3d.geometry ) {
		this.object3d.geometry.dispose();
	}
	
	this.earth.scene.remove( this.object3d );
	
	this.removed = true;
	
};


Earth.Marker.prototype.getQuaternion = function() {
	
	if ( this.align ) { // rotate to world center

		var qt = new THREE.Quaternion().setFromRotationMatrix(
			new THREE.Matrix4().lookAt( this.object3d.position, Earth.zero, Earth.up )
		);
		qt.multiply(  new THREE.Quaternion().setFromAxisAngle( Earth.left, 1.5707963267948966 ) );  // 90deg
		
	} else {
		
		var qt = new THREE.Quaternion();
		
	}
	
	return qt;
	
};

Earth.Marker.prototype.update = function() {
	
	var p = Earth.latLngToWorld( this.location, Earth.earthRadius + this.offset );
	this.object3d.position.copy( p );
	
	
	var qt = this.getQuaternion();
	
	if ( this.lookAt ) {
		if ( ! this.useLookAngle ) {	
			this.options.lookAngle = this.getLocalAngle( p, qt, Earth.latLngToWorld( this.lookAt, Earth.earthRadius ) );
		}
		qt.multiply(  new THREE.Quaternion().setFromAxisAngle( Earth.up, this.options.lookAngle ) );
	}
	
	if ( this.rotationX ) {
		qt.multiply(  new THREE.Quaternion().setFromAxisAngle( Earth.left, THREE.Math.degToRad(this.rotationX) ) );
	}
	if ( this.rotationY ) {
		qt.multiply(  new THREE.Quaternion().setFromAxisAngle( Earth.up, THREE.Math.degToRad(this.rotationY) ) );
	}
	if ( this.rotationZ ) {
		qt.multiply(  new THREE.Quaternion().setFromAxisAngle( Earth.back, THREE.Math.degToRad(this.rotationZ) ) );
	}
	
	this.object3d.setRotationFromQuaternion( qt );
	
};



Earth.Marker.prototype.getLocalAngle = function( p, qt, lookP ) {

	var startAngle = 0;
	var angle = Math.PI / 2;
	var tests = 9;
	var testPoint = new THREE.Vector3( 0.01, 0, 0 );
	var distP, distM, prevDist;
	
	for ( var i = 0; i < tests; i++ ) {
		
		var rotP = p.clone().add( testPoint.clone().applyQuaternion(
			qt.clone().multiply(  new THREE.Quaternion().setFromAxisAngle( Earth.up, startAngle + angle ) )
		) );
		distP = lookP.distanceToSquared( rotP );
		
		var rotM = p.clone().add( testPoint.clone().applyQuaternion(
			qt.clone().multiply(  new THREE.Quaternion().setFromAxisAngle( Earth.up, startAngle - angle ) )
		) );
		distM = lookP.distanceToSquared( rotM );
		
		
		if ( ! prevDist || distP < prevDist || distM < prevDist ) {  // one tested point is closer
		
			if ( distP < distM ) {
				startAngle += angle;
				prevDist = distP;
			} else {
				startAngle -= angle;
				prevDist = distM;				
			}
			
		}
	
		angle /= 2;
	
	}
	
	return startAngle;

};



/* LINE */

Earth.Line = function( initOptions, thisEarth ) {
	
	// default options
	
	var defaults = {
		
		earth : thisEarth,
		
		locations : [],
		
		offset : 0.01,
		offsetFlow : 0,
		offsetEasing : 'arc',

		hairline: false,
		width: 1,
		endWidth : -1,
		clip: 1,
		
		dashed : false,
		dashSize : 0.5,
		dashRatio : 0.5,
		dashOffset: 0,
		
		color: '#FF0000',
		opacity: 1,
		visible : true,
		alwaysBehind : false,
		alwaysOnTop : false,
		transparent: ( ( ! initOptions.hairline && initOptions.dashed ) || typeof initOptions.opacity != 'undefined' ) ,
		
	};
	
	this.options = Object.assign(defaults, initOptions);
	this.lineLength = 0;
	
	// create object

	if ( this.options.hairline ) { // native gl line	
	
		this.object3d = new THREE.Line();
		this.object3d.material  = new THREE[ ( this.options.dashed ) ? 'LineDashedMaterial' : 'LineBasicMaterial' ]();
	
	} else {
		
		this.object3d = new THREE.Mesh();
		this.meshLine = new THREE.MeshLineMod();
		this.object3d.geometry = this.meshLine.geometry;
		this.lineGeometry = new THREE.Geometry();
		this.object3d.material = new THREE.MeshLineMaterialMod();
	
	}
	

	thisEarth.scene.add( this.object3d );
	
	
	// set props
	
	Object.assign( this, this.options );
	
	
	this.ready = true;
	this.updatePoints();

	return this;
	
};


// properties

Object.defineProperties( Earth.Line.prototype, {
	
	width : {
		get: function() {
			return this.options.width;
		},
		set: function( v ) {
			this.options.width = v;
			if ( ! this.options.hairline ) {
				this.object3d.material.uniforms.lineWidth.value = v / 10;
				if ( this.ready ) this.updateGeometry();
			}
		}
	},
	endWidth : {
		get: function() {
			return ( this.options.endWidth == -1 ) ? this.options.width : this.options.endWidth;
		},
		set: function( v ) {
			this.options.endWidth = v;
			if ( ! this.options.hairline ) {
				if ( this.ready ) this.updateGeometry();
			}
		}
	},
	

	dashSize : {
		get: function() {
			return this.options.dashSize;
		},
		set: function( v ) {
			this.options.dashSize = v;
			if ( this.options.hairline ) {
				this.object3d.material.dashSize = v;
			} else {
				if ( this.ready ) this.updateDash();
			}
		}
	},
	dashRatio : {
		get: function() {
			return this.options.dashRatio;
		},
		set: function( v ) {
			this.options.dashRatio = Math.min(1, Math.max(0, v));
			if ( this.options.hairline ) {
				this.object3d.material.gapSize = this.options.dashSize * v * 2;
			} else {
				this.object3d.material.uniforms.dashRatio.value = v;
			}
		}
	},	
	dashOffset : {
		get: function() {
			return this.options.dashOffset;
		},
		set: function( v ) {
			this.options.dashOffset = v;
			if ( ! this.options.hairline ) {
				this.object3d.material.uniforms.dashOffset.value = v;
			}
		}
	},
	
	color : {
		get: function() {
			return this.options.color;
		},
		set: function( v ) {
			if ( this.options.hairline ) {
				this.object3d.material.color = new THREE.Color( v );
			} else {
				this.object3d.material.uniforms.color.value = new THREE.Color( v );
			}
		}
	},	
	opacity : {
		get: function() {
			return this.options.opacity;
		},
		set: function( v ) {
			this.options.opacity = v;
			if ( this.options.hairline ) {
				this.object3d.material.opacity = v;
			} else {
				this.object3d.material.uniforms.opacity.value = v;
			}
		}
	},
	visible : {
		get: function() {
			return this.object3d.visible;
		},
		set: function( v ) {
			this.object3d.visible = v;
		}
	},

	alwaysBehind: {
		get: function() {
			return ! this.object3d.material.depthWrite;
		},
		set: function( v ) {
			this.object3d.material.depthWrite = ! v;
			this.object3d.renderOrder = ( v ) ? -1 : 0;
		}
	},
	alwaysOnTop: {
		get: function() {
			return ! this.object3d.material.depthTest;
		},
		set: function( v ) {
			this.object3d.material.depthTest = ! v;
		}
	},
	transparent : {
		get: function() {
			return this.object3d.material.transparent;
		},
		set: function( v ) {
			this.object3d.material.transparent = v;
		}
	},
	
	clip : {
		get: function() {
			return this.options.clip;
		},
		set: function( v ) {
			this.options.clip = Math.min(1, Math.max(0, v));
			if ( this.ready ) this.updateClip();
		}
	},
	
	offset : {
		get: function() {
			return this.options.offset;
		},
		set: function( v ) {
			this.options.offset = v;
			if ( this.ready ) this.updatePoints();
		}
	},
	offsetFlow : {
		get: function() {
			return this.options.offsetFlow;
		},
		set: function( v ) {
			this.options.offsetFlow = v;
			if ( this.ready ) this.updatePoints();
		}
	},
	
	locations : {
		get: function() {
			return this.options.locations;
		},
		set: function( v ) {
			this.options.locations = v;
			if ( this.ready ) this.updatePoints();
		}
	},
	
});



// methods

Earth.Line.prototype.updatePoints = function() {
	
	this.points = [];
	
	if (  this.locations.length ) {
		var fromPos = Earth.latLngToWorld( this.locations[0], Earth.earthRadius + this.offset );
		
		for ( var i = 1; i < this.locations.length; i++ ) {
		
			var toPos = Earth.latLngToWorld( this.locations[i], Earth.earthRadius + this.offset );

			var subdevisions = Math.ceil( Math.sqrt( ( 1 + fromPos.distanceTo(toPos) ) * this.earth.quality ) );

			this.points.pop();
			this.points = this.points.concat( Earth.getPathPoints( fromPos, toPos, subdevisions, this.offset, this.offsetFlow, this.offsetEasing ) );
			
			fromPos = toPos;
			
		}
	}
	
	this.updateGeometry();
	
};



Earth.Line.prototype.updateGeometry = function() {
	
	if ( this.hairline ) {
		
		this.object3d.geometry.setFromPoints( this.points );
	
	} else {
		
		this.lineGeometry.vertices = this.points;
		
		var thisLine = this;
		this.meshLine.setGeometry( this.lineGeometry, function( p ) {
			if ( thisLine.endWidth == -1 ) return 1;
			p *= thisLine.clip; // to complete path
			return THREE.Math.lerp( thisLine.width, thisLine.endWidth, p ) / thisLine.width;
		} );
		
		if ( this.dashed ) this.lineLength = Earth.getLineDistance( this.points );
		
	}
	
	this.updateClip();
	
	this.updateDash();

};


Earth.Line.prototype.updateClip = function() {
	
	if ( this.clip < 1 ) {
		this.object3d.geometry.setDrawRange( 0, Math.round( this.points.length * this.clip ) * ( this.hairline ? 1 : 6 ) );
	} else {
		this.object3d.geometry.setDrawRange( 0, Infinity );
	}
	
};


Earth.Line.prototype.updateDash = function( options ) {
	
	if ( ! this.dashed ) return;
	
	if ( this.hairline ) {
		this.object3d.computeLineDistances();
	} else {
		this.object3d.material.uniforms.useDash.value = 1;
		this.object3d.material.uniforms.dashArray.value = 1 / this.lineLength * this.dashSize * 3;
	}
	
};



Earth.Line.prototype.remove = function() {
	
	if ( this.object3d.material ) {
		this.object3d.material.dispose();
	}
	if ( this.object3d.geometry ) {
		this.object3d.geometry.dispose();
	}
	this.earth.scene.remove( this.object3d );
	this.removed = true;
	
};



/* OVERLAY */

Earth.Overlay = function( initOptions, thisEarth ) {
	
	// default options
	
	var defaults = {
		
		earth: thisEarth,
		
		location : { lat : 0, lng : 0 },
		offset : 0,
		transform: 'translate(-50%, -100%)',
		
		content : '',
		className : '',
		
		events : false,
		
		visible : true,
		occlude : true,
		zIndex : 20,
		
		elementScale : 0,
		zoomScale : 1,
		depthScale : 0
		
	};
	
	this.options = Object.assign(defaults, initOptions);
	
	// create overlay
	
	var div = document.createElement( 'div' );	
	thisEarth.element.appendChild( div );
	div.overlay = this;
	this.element = div;
	
	thisEarth.overlays.push( this );
	
	// set props
	Object.assign(this, this.options);

	return this;
	
};


// properties

Object.defineProperties( Earth.Overlay.prototype, {
	
	content : {
		get: function() {
			return this.element.innerHTML;
		},
		set: function( v ) {
			this.element.innerHTML = v;
			this.needsUpdate = true;
		}
	},
	className : {
		get: function() {
			return this.options.className;
		},
		set: function( v ) {
			this.options.className = v;
			this.element.className = 'earth-overlay';
			if ( v ) this.element.className += ' ' + v;
			this.needsUpdate = true;
		}
	},
	
	visible : {
		get: function() {
			return this.element.style.display != 'none';
		},
		set: function( v ) {
			this.element.style.display = ( v ) ? '' : 'none';
			this.needsUpdate = true;
		}
	},
	events : {
		get: function() {
			return this.element.style.pointerEvents != 'none';
		},
		set: function( v ) {
			this.element.style.pointerEvents = ( v ) ? '' : 'none';
		}
	},
	
	occlude : {
		get: function() {
			return this.options.occlude;
		},
		set: function( v ) {
			this.options.occlude = v;
			this.needsUpdate = true;
		}
	},
	zIndex : {
		get: function() {
			return this.options.zIndex;
		},
		set: function( v ) {
			this.options.zIndex = v;
			this.needsUpdate = true;
		}
	},
	
	elementScale : {
		get: function() {
			return this.options.elementScale;
		},
		set: function( v ) {
			this.options.elementScale = v;
			this.needsUpdate = true;
		}
	},	
	zoomScale : {
		get: function() {
			return this.options.zoomScale;
		},
		set: function( v ) {
			this.options.zoomScale = v;
			this.needsUpdate = true;
		}
	},	
	depthScale : {
		get: function() {
			return this.options.depthScale;
		},
		set: function( v ) {
			this.options.depthScale = v;
			this.needsUpdate = true;
		}
	},
	
	transform : {
		get: function() {
			return this.options.transform;
		},
		set: function( v ) {
			this.options.transform = v;
			this.needsUpdate = true;
		}
	},	
	offset : {
		get: function() {
			return this.options.offset;
		},
		set: function( v ) {
			this.options.offset = v;
			this.needsUpdate = true;
		}
	},
	location : {
		get: function() {
			return this.options.location;
		},
		set: function( v ) {
			this.options.location = v;
			this.needsUpdate = true;
		}
	},
	
});


// methods

Earth.Overlay.prototype.remove = function() {
	
	var objIndex = this.earth.overlays.indexOf( this );
	if ( objIndex == -1 ) return; // already removed
	
	this.earth.overlays.splice( objIndex , 1 );
	
	this.earth.element.removeChild( this.element );
	
	this.removed = true;
	
};

Earth.Overlay.prototype.isOccluded = function( elementPos, distance, camDistance ) {
	
	if ( distance < camDistance ) { // between earth and camera
		
		return false;
		
	} else {
		
		this.earth.raycaster.setFromCamera( Earth.normalizeRaycast( Earth.normalizeElement(elementPos, this.earth.elementSize) ), this.earth.camera );
		var intersection = this.earth.raycaster.intersectObjects( [this.earth.sphere] );
		
		return intersection.length != 0;
		
	}
	
};





/* ANIMATION */

Earth.Animation = function( options ) {
	
	Object.assign(this, options);	
	Earth.Animation.animations.push( this );
	return this;

};

Earth.Animation.prototype.stop = function( dispatchComplete, jumpToEnd ) {
	
	if ( jumpToEnd ) {
		this.t = this.duration;
		this.step( 1 );
	}
	
	if ( this._end ) {
		this._end();
	}
	if ( this.end ) {
		this.end();
	}
	
	if ( dispatchComplete && this.complete && ! this.target.removed ) {
		this.complete();
	}
	
	var aniIndex = Earth.Animation.animations.indexOf( this );
	if ( aniIndex == -1 ) return; // not found
	
	Earth.Animation.animations.splice( aniIndex , 1 );
	
};

Earth.Animation.update = function( delta ) {
	
	var complete_animations = [];
	
	for ( var i in Earth.Animation.animations ) {
		var ani = Earth.Animation.animations[i];
		
		if ( ani.target.removed ) {
			complete_animations.push( ani );
			continue;
		}
		
		
		ani.t += delta;
		var p = ani.t / ani.duration; // progress 0-1
		
		ani.step( Math.min( p, 1 ) );
		
		if ( p >= 1 ) { // end of animation
		
			if ( ani.loop ) {
				
				if ( ani.oscillate ) {
					ani.t = Math.max( 0, ani.duration - ani.t );
					var current = ani.to;
					ani.to = ani.from;
					ani.from = current;
				} else {
					ani.t = Math.max( 0, ani.duration - ani.t );
				}
				
			} else {
				complete_animations.push( ani );
			}
			
		}
		
	}
	
	for ( var i in complete_animations ) {
		complete_animations[i].stop( true );
	}
	
};


Earth.Animation.animations = [];


Earth.Animation.Easing = {
	
	linear : 		function (t) { return t },
	
	'in-quad' : 	function (t) { return t*t },
	'out-quad' : 	function (t) { return t*(2-t); },
	'in-out-quad' : function (t) { return t<.5 ? 2*t*t : -1+(4-2*t)*t },
	
	'in-cubic' : 	function (t) { return t*t*t },
	'out-cubic' : 	function (t) { return (--t)*t*t+1 },
	'in-out-cubic' :function (t) { return t<.5 ? 4*t*t*t : (t-1)*(2*t-2)*(2*t-2)+1 },
	
	'in-quart' :	function (t) { return t*t*t*t },
	'out-quart' :	function (t) { return 1-(--t)*t*t*t },
	'in-out-quart': function (t) { return t<.5 ? 8*t*t*t*t : 1-8*(--t)*t*t*t },
	
	'in-back' :		function (t) { return t*t*(2.70158*t - 1.70158); },
	'out-back' :	function (t) { return (t=t-1)*t*(2.70158*t + 1.70158) + 1; },
	'in-out-back' :	function (t) {
		var s = 1.70158;
		if ((t/=0.5) < 1) return 0.5*(t*t*(((s*=(1.525))+1)*t - s));
		return 0.5*((t-=2)*t*(((s*=(1.525))+1)*t + s) + 2);
	},
	
	elastic : function (t) {
		var p=.3;
		if (t==0) return 0; if (t==1) return 1;
		var s = p/(2*Math.PI) * Math.asin (1);
		return Math.pow(2,-10*t) * Math.sin( (t-s)*(2*Math.PI)/p ) + 1;
	},
	
	bounce : function (t) {
		if (t < (1/2.75)) {
			return (7.5625*t*t);
		} else if (t < (2/2.75)) {
			return (7.5625*(t-=(1.5/2.75))*t + .75);
		} else if (t < (2.5/2.75)) {
			return (7.5625*(t-=(2.25/2.75))*t + .9375);
		} else {
			return (7.5625*(t-=(2.625/2.75))*t + .984375);
		}
	},
	
	arc : function(t) {
		return t<.5 ? this['out-quad'](t*2) : this['out-quad'](2 - t*2);
	}
	
};





/* ANIMATABLE */

Earth.Animatable = function() {};

Earth.Animatable.colorProp  = [ 'color', 'color2', 'color3', 'color4', 'color5', 'lightColor', 'lightGroundColor' ];
Earth.Animatable.latlngProp = [ 'location', 'sunLocation' ];
Earth.Animatable.angleProp  = [ 'lookAt' ];


Earth.Animatable.prototype.animate = function( prop, val, options ) {
	
	var ani = {
		target: this,
		prop: prop,
		val: val,
		t : 0,
		duration : 400,
		easing : 'in-out-quad',
		lerpLatLng : false,
		loop : false,
		oscillate : false
	};
	
	Object.assign( ani , options );
	
	
	// value type for lerp
	
	if ( Earth.Animatable.colorProp.indexOf( ani.prop ) != -1  ) {
		ani.type = 'color';
		ani.from = new THREE.Color( this[ ani.prop ] );
		ani.to = new THREE.Color( ani.val );
		
	} else if ( Earth.Animatable.latlngProp.indexOf( ani.prop ) != -1 ) {
		ani.type = 'latlng';
		ani.from = Object.assign( {}, this[ ani.prop ] );
		ani.to = Object.assign( {}, ani.val );		
		
	} else if ( Earth.Animatable.angleProp.indexOf( ani.prop ) != -1 ) {
		ani.type = 'angle';
		ani.from = this.lookAngle;
		ani.to = this.getLocalAngle( this.object3d.position, this.getQuaternion(), Earth.latLngToWorld( ani.val, Earth.earthRadius ) );
		ani.prop = 'lookAngle';
		this.options.lookAt = Object.assign( {}, ani.val );
		this.useLookAngle = true;
		
	} else {
		ani.type = 'number';
		ani.from = this[ ani.prop ];
		ani.to = ani.val;
		
	}
	
	
	// ani duration
	
	if ( ani.relativeDuration ) {
		
		if ( ani.type == 'number' ) {
			ani.duration += Math.abs( ani.from - ani.to ) * ani.relativeDuration;
			
		} else if ( ani.type == 'color' ) {
			ani.duration += ( Math.abs( ani.from.r - ani.to.r ) + Math.abs( ani.from.g - ani.to.g ) + Math.abs( ani.from.b - ani.to.b ) ) / 3 * ani.relativeDuration;
			
		} else if ( ani.type == 'latlng' ) {
			ani.duration += Earth.getDistance( ani.from, ani.to ) / 1000 * ani.relativeDuration;
			
		} else if ( ani.type == 'angle' ) {
			ani.duration += Math.abs( Earth.wrap( ani.from, 0, 2 * Math.PI ) - Earth.wrap( ani.to, 0, 2 * Math.PI ) ) * ani.relativeDuration;
			
		}
		
	}
	

	ani.step = function( t ) {
			
		t = Earth.Animation.Easing[ this.easing ]( t );
		
		if ( this.type == 'number' ) {
			ani.target[ this.prop ] = THREE.Math.lerp( this.from, this.to, t );
			
		} else if ( this.type == 'color' ) {
			ani.target[ this.prop ] = this.from.clone().lerp( this.to, t );	
			
		} else if ( this.type == 'latlng' ) {
			ani.target[ this.prop ] = Earth.lerp( this.from, this.to, t, ani.lerpLatLng );
			
		} else if ( this.type == 'angle' ) {
			ani.target[ this.prop ] = Earth.lerpAngle( this.from, this.to, t );
		}
		
	};

	
	if ( ani.prop == 'lookAngle' ) {
		
		ani._end = function() {
			ani.target.useLookAngle = false;
		};
		
	}
	
	
	return new Earth.Animation( ani );

};

Object.assign( Earth.prototype, Earth.Animatable.prototype );
Object.assign( Earth.Marker.prototype, Earth.Animatable.prototype );
Object.assign( Earth.Line.prototype, Earth.Animatable.prototype );
Object.assign( Earth.Overlay.prototype, Earth.Animatable.prototype );



/* Earth INIT */

if ( document.readyState == 'loading' ) {
	
	document.addEventListener( "DOMContentLoaded", function() {
		Earth.dispatchLoadedEvent();
	} );
	
} else { // async load
	
	setTimeout( function(){
		Earth.dispatchLoadedEvent();
	}, 1 );
	
}