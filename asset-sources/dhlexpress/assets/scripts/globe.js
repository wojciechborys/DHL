(function ($) {
    $('.places-list--dropdown').click(function () {
        $(this).parents('.globe-text').toggleClass('globe-text__slide-down');
    });

    function getInfoAboutCountries(place) {
        return $.get('/wp-json/ecommerce/globe/', {
            airport: place
        });
    }

    function selectFrom() {
        // var index = document.getElementById('from').selectedIndex;
        // var index = $('.places-list').find('.active').index();
        // var index = 1;
        // console.log(index);
        // if (index === 0) {
        //     return;
        // }
        // markers[index - 1].dispatchEvent({type: 'click'});
    }

    function selectTo() {
        var index = $('.places-list').find('.active').index();
        getInfoAboutCountries($('.places-list').find('.active').data('place')).done(function (res) {
            $('.globe-about-place .globe-about-place__image img').attr('src', res.data[0]['image_url']);
            if (Array.isArray(res.data[0]['curiosities'])) {
                for (var i = 0; i < res.data[0]['curiosities'].length; i++) {
                    $('.globe-about-place .globe-about-place__text').append('<p class="globe-about-place__info">' + res.data[0]['curiosities'][i]['text'] + '</p>');
                }
            }
            else {
                $('.globe-about-place .globe-about-place__text').empty();
            }
        });
        $('.globe').addClass('globe-made-choice');
        $('.globe-text').removeClass('globe-text__slide-down');
        markers[index].dispatchEvent({type: 'click'});
    }

    function reset() {
        $('.globe').removeClass('globe-made-choice');
        flying = false;

        document.getElementsByClassName("globe")[0].classList.remove('config-start');
        document.getElementById('tip-layer').style.opacity = 0;

        // document.getElementById('from').selectedIndex = 0;
        // document.getElementById('from').removeAttribute('disabled');
        // document.getElementById('to').setAttribute('disabled', true);
        // document.getElementById('to').selectedIndex = 0;

        if (plane) {
            plane.animate('scale', 0.01, {
                complete: function () {
                    plane.remove();
                }
            });
        }
        if (X) {
            X.animate('scale', 0.01, {
                complete: function () {
                    X.remove();
                }
            });
        }
        if (dashedLine) {
            dashedLine.animate('width', 0.01, {
                complete: function () {
                    dashedLine.remove();
                }
            });
        }
        if (solidLine) {
            solidLine.animate('width', 0.01, {
                complete: function () {
                    solidLine.remove();
                }
            });
        }

        startMarker = false;
        endMarker = false;

        restorePins();
    }

    $('.info-back').click(function () {
        $('.places-list').children('.places-list__item').removeClass('active');
        reset();
    });

    window.addEventListener("earthjsload", function () {
        // parse plane mesh from string

        Earth.addMesh(airplaneMesh);

        myearth = new Earth(document.getElementById('myearth'), {
            location: {lat: 20, lng: 10},
            light: 'none',
            mapLandColor: '#fff',
            mapSeaColor: '#66d8ff',
            mapBorderColor: '#66d8ff',
            mapBorderWidth: 0.4,
            quality: (window.innerWidth < 1000) ? 3 : 4

        });

        myearth.addEventListener("ready", function () {

            // var fromSelect = document.getElementById('from');
            // var toSelect = document.getElementById('to');


            // add airport pins
            //
            var warsawMarker = this.addMarker({
                mesh: ["Pin", "Needle"],
                color: '#00a8ff',
                color2: '#9f9f9f',
                offset: -0.2,
                location: {lat: startMarkerTab[2], lng: startMarkerTab[3]},
                scale: 0.01,
                visible: false,
                hotspotRadius: 0.4,
                hotspotHeight: 1.5,

                // custom propertie
                airportCode: startMarkerTab[0],
                airportName: startMarkerTab[1]

            });
            // console.log('warsaw point', startMarkerTab);

            for (var i = 0; i < airports.length; i++) {
                var marker = this.addMarker({
                    mesh: ["Pin", "Needle"],
                    color: '#00a8ff',
                    color2: '#9f9f9f',
                    offset: -0.2,
                    location: {lat: airports[i][2], lng: airports[i][3]},
                    scale: 0.01,
                    visible: false,
                    hotspotRadius: 0.4,
                    hotspotHeight: 1.5,

                    // custom properties
                    index: i,
                    airportCode: airports[i][0],
                    airportName: airports[i][1]

                });

                // if (i == 0) warsawMarker = marker


                // pin events

                marker.addEventListener('mouseover', function () {

                    document.getElementById('tip-layer').style.opacity = 1;
                    // document.getElementById('tip-big').innerHTML = this.airportCode;
                    // document.getElementById('tip-big').innerHTML = this.airportName.split(',').join('<br>');
                    document.getElementById('tip-small').innerHTML = this.airportName.split(',').join('<br>');

                    this.color = 'red';

                });

                marker.addEventListener('mouseout', function () {

                    if (this !== startMarker && this !== endMarker) {
                        this.color = '#00a8ff';
                    }
                    document.getElementById('tip-layer').style.opacity = 0;

                });

                marker.addEventListener('click', function () {
                    selectStartMarker(warsawMarker);

                    // if (!startMarker) {
                    //     selectStartMarker(this);
                    // } else {
                    selectEndMarker(this);
                    // }

                });

                markers.push(marker);
                // var countryElement = i + 1;
                // if (countryElement < airports.length) {
                //     console.log('countryEl: ' + countryElement + ' airports: ' + airports.length);
                //     console.log(airports[countryElement][0]);
                var element = document.createElement("LI");
                element.className = "places-list__item";
                element.setAttribute('data-place', airports[i][0]);
                var link = document.createElement("A");
                link.className = "places-list__link";
                link.setAttribute('href', "#");
                var linkText = document.createTextNode(airports[i][1]);
                element.appendChild(link);
                link.appendChild(linkText);
                document.getElementById("list").appendChild(element);
                // }

                // var option = document.createElement("option");
                // console.log(airports);
                // option.text = airports[i][0] + ' | ' + airports[i][1];
                // fromSelect.add(option);
                //
                // var option = document.createElement("option");
                // option.text = airports[i][0] + ' | ' + airports[i][1];
                // toSelect.add(option);
                if (i === airports.length - 1) {
                    // console.log('after last');
                    $('.places-list__link').on('click', function (e) {
                        e.preventDefault();
                        $(this).parents('.places-list__item').addClass('active');
                        $(this).parents('.places-list__item').siblings().removeClass('active');
                        selectFrom();
                        selectTo();
                    });
                }
            }

            restorePins();

        });
    });
    markers = [];

    flying = false;
    plane, X;
    startMarker, endMarker;
    dashedLine, solidLine;
    flightScale = 1;

    function startFlight() {

        flying = true;

        shrinkPins();

        var distance = Earth.getDistance(startMarker.location, endMarker.location);
        flightScale = 1;


        // shrink plane for short flights
        if (distance < 3000) {
            flightScale = 0.6 + flightScale / 3000 * 0.4;
            plane.animate('scale', 1.2 * flightScale);
        }

        var flightTime = 2000 + distance;


        // add target X

        X = myearth.addMarker({
            mesh: "X",
            color: '#fdcf03',

            location: endMarker.location,
            scale: 0.01,
            offset: 0,
            hotspot: false
        });


        // add lines

        dashedLine = myearth.addLine({
            locations: [startMarker.location, endMarker.location],
            color: "red",
            width: 1.25 * flightScale,
            offsetFlow: flightScale,
            dashed: true,
            dashSize: 0.25 * flightScale,
            dashRatio: 0.5,
            clip: 0,
            alwaysBehind: true
        });

        dashedLine.animate('clip', 1, {duration: 1000 + distance / 10});


        solidLine = myearth.addLine({
            locations: [startMarker.location, endMarker.location],
            color: "red",
            width: 1.25 * flightScale,
            offsetFlow: flightScale,
            clip: 0,
            alwaysBehind: true
        });


        // flight

        plane.animate('lookAt', Earth.lerp(startMarker.location, endMarker.location, 1.0001), {
            duration: 200,
            relativeDuration: 100
        });

        plane.animate('offset', flightScale * 0.75, {duration: flightTime, easing: 'arc'});
        plane.animate('location', endMarker.location, {
            duration: flightTime, easing: 'linear', complete: function () {

                dashedLine.remove();
                flying = false;

            }
        });

        plane.animate('rotationZ', 15 * flightScale, {
            duration: flightTime / 2, easing: 'arc', complete: function () {

                if (!flying) {
                    return;
                }

                plane.animate('rotationZ', -15 * flightScale, {duration: flightTime / 2, easing: 'arc'});
                X.animate('scale', 0.01, {
                    duration: flightTime / 2, easing: 'in-quart', complete: function () {
                        X.remove();
                    }
                });

                // document.getElementById('tip-big').innerHTML = Math.ceil(distance / 500) / 2 + 'h';
                // document.getElementById('tip-small').innerHTML = startMarker.airportCode + ' - ' + endMarker.airportCode;
                // document.getElementById('tip-layer').style.opacity = 1;

            }
        });


        var syncLineToPlane = function () {

            if (!flying) {
                solidLine.clip = 1;
                myearth.removeEventListener("update", syncLineToPlane);
                return;
            }

            dashedLine.dashOffset -= 0.001; // animate dashed line

            // calc flight progress and set line clipping

            var from = startMarker.object3d.position;
            var to = endMarker.object3d.position;
            var mid = plane.object3d.position;

            var before = from.distanceTo(mid);
            var after = to.distanceTo(mid);

            var t = before / (before + after);

            solidLine.clip = t;

        };

        myearth.addEventListener("update", syncLineToPlane);

    }

    function selectStartMarker(marker) {
        document.getElementsByClassName("globe")[0].classList.add('config-start');

        // document.getElementById('from').setAttribute('disabled', true);
        // document.getElementById('from').selectedIndex = marker.index + 1;
        // document.getElementById('to').removeAttribute('disabled');

        // shrink selected marker
        startMarker = marker;
        startMarker.dispatchEvent({type: 'mouseout'});
        startMarker.hotspot = false;
        startMarker.animate('scale', 0.01, {
            easing: 'in-quad', complete: function () {

                startMarker.visible = false;
                plane.animate('scale', 1.2, {easing: 'out-back'});

            }
        });


        // add plane

        plane = myearth.addMarker({
            mesh: "plane",
            color: '#fdcf03',

            location: marker.location,
            scale: 0.01,
            offset: 0,
            lookAt: {lat: 0, lng: 0},
            hotspot: false,
            transparent: true
        });


        // approach marker location

        myearth.goTo(marker.location, {duration: 200, relativeDuration: 300, approachAngle: 20});

    }

    function selectEndMarker(marker) {

        // document.getElementById('to').setAttribute('disabled', true);
        // document.getElementById('to').selectedIndex = marker.index + 1;

        // shrink marker
        endMarker = marker;
        endMarker.dispatchEvent({type: 'mouseout'});
        endMarker.hotspot = false;
        endMarker.animate('scale', 0.01, {
            easing: 'in-quad', complete: function () {

                endMarker.visible = false;
                X.animate('scale', 0.8 * flightScale, {easing: 'out-back'});

            }
        });


        myearth.goTo(marker.location, {duration: 200, relativeDuration: 300, approachAngle: 20});
        $('.globe').addClass('globe-made-choice');
        startFlight();

    }


    var pinIndex = 0;
    var pinTime = 0;
    var pinsPerSec = 1000 / 18;

    function shrinkPins() {

        pinIndex = 0;

        var shrinkOnePin = function () {

            markers[pinIndex].animate('scale', 0.01, {
                complete: function () {
                    this.target.visible = false;
                }
            });

            if (++pinIndex >= markers.length) {
                myearth.removeEventListener("update", shrinkOnePin);
            }

        };

        myearth.addEventListener("update", shrinkOnePin);

    }

    function restorePins() {

        pinIndex = 0;
        pinTime = myearth.deltaTime;

        var restoreOnePin = function () {

            pinTime += myearth.deltaTime;
            if (pinTime > pinsPerSec) {
                pinTime -= pinsPerSec;
            } else {
                return;
            }

            if (!markers[pinIndex].visible) {

                markers[pinIndex].visible = true;
                markers[pinIndex].hotspot = true;
                markers[pinIndex].animate('scale', 1, {duration: 560, easing: 'out-back'});

            } else {

                // skip wait time
                pinTime = pinsPerSec;

            }

            if (++pinIndex >= markers.length) {
                myearth.removeEventListener("update", restoreOnePin);
            }

        };

        myearth.addEventListener("update", restoreOnePin);

    }

    // function toggleSidebar() {
    //     document.getElementsByClassName("globe")[0].classList.toggle('sidebar-open');
    // }
})(jQuery);

