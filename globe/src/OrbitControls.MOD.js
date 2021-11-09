// Adaption of THREE.OrbitControls

// Orbit - left mouse / touch: one-finger move
// Zoom - middle mouse, or mousewheel / touch: two-finger spread or squish

THREE.OrbitControlsMod = function ( object, domElement, earth ) {

	this.object = object;
	this.domElement = domElement;
	this.earth = earth;

	// Set to false to disable this control
	this.enabled = true;

	// "target" sets the location of focus, where the object orbits around
	this.target = new THREE.Vector3();

	// How far you can dolly in and out ( PerspectiveCamera only )
	this.minDistance = 0;
	this.maxDistance = Infinity;

	// How far you can orbit vertically, upper and lower limits.
	// Range is 0 to Math.PI radians.
	this.minPolarAngle = 0; // radians
	this.maxPolarAngle = Math.PI; // radians

	// This option actually enables dollying in and out; left as "zoom" for backwards compatibility.
	// Set to false to disable zooming
	this.enableZoom = true;
	this.zoomSpeed = 1.0;

	// Set to false to disable rotating
	this.enableRotate = true;
	this.rotateSpeed = 0.7;

	// automatically rotate
	this.autoRotateSpeed = 0; // 30 seconds per round when fps is 60
	this.autoRotateSpeedUp = 0; // 30 seconds per round when fps is 60

	// Mouse buttons
	this.mouseButtons = { LEFT: THREE.MOUSE.LEFT, MIDDLE: THREE.MOUSE.MIDDLE, RIGHT: THREE.MOUSE.RIGHT };


	// public methods

	this.setPosition = function ( pos ) {
		
		scope.object.position.copy( pos );

		scope.object.updateProjectionMatrix();
		scope.update();
		
		state = STATE.NONE;
		
		scope.dispatchEvent( changeEvent );

	};
	
	
	this.update = function ( ) {

		var offset = new THREE.Vector3();

		// so camera.up is the orbit axis
		var quat = new THREE.Quaternion().setFromUnitVectors( object.up, new THREE.Vector3( 0, 1, 0 ) );
		var quatInverse = quat.clone().inverse();

		var lastPosition = new THREE.Vector3();
		var lastQuaternion = new THREE.Quaternion();
		

		return function update( ) {

			var position = scope.object.position;

			offset.copy( position ).sub( scope.target );

			// rotate offset to "y-axis-is-up" space
			offset.applyQuaternion( quat );

			// angle from z-axis around y-axis
			spherical.setFromVector3( offset );

			if ( state == STATE.NONE && scope.autoRotateSpeed != 0 ) {
				rotateLeft( getAutoRotationAngle() );
			}
			
			if ( state == STATE.NONE && scope.autoRotateSpeedUp != 0 ) {
				rotateUp( getAutoRotationAngleY() );
			}

			spherical.theta += sphericalDelta.theta;
			spherical.phi += sphericalDelta.phi;

			// restrict phi to be between desired limits
			spherical.phi = Math.max( scope.minPolarAngle, Math.min( scope.maxPolarAngle, spherical.phi ) );

			spherical.makeSafe();

			spherical.radius *= scale;

			// restrict radius to be between desired limits
			spherical.radius = Math.max( scope.minDistance, Math.min( scope.maxDistance, spherical.radius ) );

			offset.setFromSpherical( spherical );

			// rotate offset back to "camera-up-vector-is-up" space
			offset.applyQuaternion( quatInverse );

			position.copy( scope.target ).add( offset );

			scope.object.lookAt( scope.target );

			sphericalDelta.set( 0, 0, 0 );

			scale = 1;
			

			// has changed?

			if ( zoomChanged ||
				lastPosition.distanceToSquared( scope.object.position ) > EPS ||
				8 * ( 1 - lastQuaternion.dot( scope.object.quaternion ) ) > EPS ) {

				scope.dispatchEvent( changeEvent );

				lastPosition.copy( scope.object.position );
				lastQuaternion.copy( scope.object.quaternion );
				zoomChanged = false;

				return true;

			}

			return false;

		};

	}();

	this.dispose = function () {

		scope.domElement.removeEventListener( 'mousedown', onMouseDown, false );
		scope.domElement.removeEventListener( 'wheel', onMouseWheel, false );

		scope.domElement.removeEventListener( 'touchstart', onTouchStart, false );
		scope.domElement.removeEventListener( 'touchend', onTouchEnd, false );
		scope.domElement.removeEventListener( 'touchmove', onTouchMove, false );

		document.removeEventListener( 'mousemove', onMouseMove, false );
		document.removeEventListener( 'mouseup', onMouseUp, false );

	};

	
	// internals

	var scope = this;

	var changeEvent = { type: 'change' };
	var startEvent = { type: 'start' };
	var endEvent = { type: 'end' };

	var STATE = { NONE: - 1, ROTATE: 0, DOLLY: 1, TOUCH_ROTATE: 3, TOUCH_DOLLY_PAN: 4 };

	var state = STATE.NONE;

	var EPS = 0.000001;

	// current position in spherical coordinates
	var spherical = new THREE.Spherical();
	var sphericalDelta = new THREE.Spherical();

	var scale = 1;
	var zoomChanged = false;

	var rotateStart = new THREE.Vector2();
	var rotateEnd = new THREE.Vector2();
	var rotateDelta = new THREE.Vector2();
	
	var startLocation;
	var startEarthLocation;
	var camClone;

	var dollyStart = new THREE.Vector2();
	var dollyEnd = new THREE.Vector2();
	var dollyDelta = new THREE.Vector2();

	
	function getAutoRotationAngle() {
		return 2 * Math.PI / 60 / 60 * scope.autoRotateSpeed;
	}
	function getAutoRotationAngleY() {
		return 2 * Math.PI / 60 / 60 * scope.autoRotateSpeedUp;
	}
	
	function getZoomScale() {
		return Math.pow( 0.95, scope.zoomSpeed );
	}

	function rotateLeft( angle ) {
		sphericalDelta.theta -= angle;
	}
	function rotateUp( angle ) {
		sphericalDelta.phi -= angle;
	}

	function dollyIn( dollyScale ) {
		scale /= dollyScale;
	}
	function dollyOut( dollyScale ) {
		scale *= dollyScale;
	}

	
	
	// event callbacks - update the object state

	function handleMouseDownRotate( event ) {
		
		rotateStart = Earth.positionOfEvent( event );
		
	}

	function handleMouseMoveRotate( event ) {

		rotateEnd = Earth.positionOfEvent( event );
		var earthRadiusPx = scope.earth.getRadius(); // cache!
		
		var mouseCenterOffset = Earth.mouseCenterOffset( rotateEnd, scope.earth.element, earthRadiusPx );
		mouseCenterOffset = Earth.Animation.Easing['in-cubic']( mouseCenterOffset );
	
	
		var speed = 0.61 / earthRadiusPx;
		
		// compensate zoom
		speed *= 1 + ((1.5 - Math.max(0.5, Math.min( 1.5, scope.earth.zoom))) / 3);
		
		// compensate earth's curvature 
		speed *= 1 + mouseCenterOffset * 0.85;
		
		
		rotateDelta.subVectors( rotateEnd, rotateStart ).multiplyScalar( speed );
		rotateLeft( rotateDelta.x );
		rotateUp( rotateDelta.y );

		rotateStart.copy( rotateEnd );
		scope.update();

	}
	

	function handleMouseDownDolly( event ) {
		dollyStart.set( event.clientX, event.clientY );
	}

	function handleMouseMoveDolly( event ) {

		dollyEnd.set( event.clientX, event.clientY );
		dollyDelta.subVectors( dollyEnd, dollyStart );

		if ( dollyDelta.y > 0 ) {
			dollyIn( getZoomScale() );
		} else if ( dollyDelta.y < 0 ) {
			dollyOut( getZoomScale() );
		}

		dollyStart.copy( dollyEnd );
		scope.update();

	}

	function handleMouseWheel( event ) {

		if ( event.deltaY < 0 ) {
			dollyOut( getZoomScale() );
		} else if ( event.deltaY > 0 ) {
			dollyIn( getZoomScale() );
		}

		scope.update();

	}

	
	function handleTouchStartRotate( event ) {

		handleMouseDownRotate( event );

	}

	function handleTouchMoveRotate( event ) {

		handleMouseMoveRotate( event );

	}

	
	function handleTouchStartDollyPan( event ) {

		if ( scope.enableZoom ) {

			var dx = event.touches[ 0 ].pageX - event.touches[ 1 ].pageX;
			var dy = event.touches[ 0 ].pageY - event.touches[ 1 ].pageY;
			var distance = Math.sqrt( dx * dx + dy * dy );
			dollyStart.set( 0, distance );

		}

	}
	
	function handleTouchMoveDollyPan( event ) {

		if ( scope.enableZoom ) {

			var dx = event.touches[ 0 ].pageX - event.touches[ 1 ].pageX;
			var dy = event.touches[ 0 ].pageY - event.touches[ 1 ].pageY;
			var distance = Math.sqrt( dx * dx + dy * dy );

			dollyEnd.set( 0, distance );
			dollyDelta.set( 0, Math.pow( dollyEnd.y / dollyStart.y, scope.zoomSpeed ) );
			dollyIn( dollyDelta.y );
			dollyStart.copy( dollyEnd );
			scope.update();
		
		}

	}


	// event handlers

	function onMouseDown( event ) {

		if ( scope.enabled === false ) return;

		event.preventDefault();

		switch ( event.button ) {

			case scope.mouseButtons.LEFT:

				if ( scope.enableRotate === false ) return;
				handleMouseDownRotate( event );
				state = STATE.ROTATE;
				break;

			case scope.mouseButtons.MIDDLE:

				if ( scope.enableZoom === false ) return;
				handleMouseDownDolly( event );
				state = STATE.DOLLY;
				break;

		}

		if ( state !== STATE.NONE ) {
			document.addEventListener( 'mousemove', onMouseMove, false );
			document.addEventListener( 'mouseup', onMouseUp, false );
			scope.dispatchEvent( startEvent );
		}

	}

	function onMouseMove( event ) {

		if ( scope.enabled === false ) return;

		event.preventDefault();

		switch ( state ) {

			case STATE.ROTATE:

				if ( scope.enableRotate === false ) return;
				handleMouseMoveRotate( event );
				break;

			case STATE.DOLLY:

				if ( scope.enableZoom === false ) return;
				handleMouseMoveDolly( event );
				break;

		}

	}

	function onMouseUp( event ) {

		if ( scope.enabled === false ) return;

		document.removeEventListener( 'mousemove', onMouseMove, false );
		document.removeEventListener( 'mouseup', onMouseUp, false );
		scope.dispatchEvent( endEvent );
		state = STATE.NONE;

	}

	function onMouseWheel( event ) {

		if ( scope.enabled === false || scope.enableZoom === false || ( state !== STATE.NONE && state !== STATE.ROTATE ) ) return;

		event.preventDefault();
		event.stopPropagation();

		//scope.dispatchEvent( startEvent );
		handleMouseWheel( event );
		//scope.dispatchEvent( endEvent );

	}

	function onTouchStart( event ) {

		if ( scope.enabled === false ) return;

		event.preventDefault();

		switch ( event.touches.length ) {

			case 1:	// one-fingered touch: rotate

				if ( scope.enableRotate === false ) return;
				handleTouchStartRotate( event );
				state = STATE.TOUCH_ROTATE;
				break;

			case 2:	// two-fingered touch: dolly-pan

				if ( scope.enableZoom === false ) return;
				handleTouchStartDollyPan( event );
				state = STATE.TOUCH_DOLLY_PAN;
				break;

			default:
				state = STATE.NONE;

		}

		if ( state !== STATE.NONE ) {
			scope.dispatchEvent( startEvent );
		}

	}

	function onTouchMove( event ) {

		if ( scope.enabled === false ) return;

		event.preventDefault();
		event.stopPropagation();

		switch ( event.touches.length ) {

			case 1: // one-fingered touch: rotate

				if ( scope.enableRotate === false ) return;
				if ( state !== STATE.TOUCH_ROTATE ) return; // is this needed?

				handleTouchMoveRotate( event );
				break;

			case 2: // two-fingered touch: dolly-pan

				if ( scope.enableZoom === false ) return;
				if ( state !== STATE.TOUCH_DOLLY_PAN ) return; // is this needed?

				handleTouchMoveDollyPan( event );
				break;

			default:

				state = STATE.NONE;

		}

	}

	function onTouchEnd( event ) {

		if ( scope.enabled === false ) return;
		scope.dispatchEvent( endEvent );
		state = STATE.NONE;

	}

	
	scope.domElement.addEventListener( 'mousedown', onMouseDown, false );
	scope.domElement.addEventListener( 'wheel', onMouseWheel, false );

	scope.domElement.addEventListener( 'touchstart', onTouchStart, false );
	scope.domElement.addEventListener( 'touchend', onTouchEnd, false );
	scope.domElement.addEventListener( 'touchmove', onTouchMove, false );

	// force an update at start
	this.update();

};

Object.assign( THREE.OrbitControlsMod.prototype, THREE.EventDispatcher.prototype );
