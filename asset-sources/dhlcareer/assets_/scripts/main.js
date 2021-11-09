(function($) {
    "use strict";

    // $('.main-video-slider .owl-carousel .item-video').find('video').each(function() {
    //     this.get(0).play();
    //     this.next().get(0).play();
    // });

    var docElem = window.document.documentElement,
        $window = $(window),
        $body = $('body'),
        doc = document.documentElement,
        viewport = {},
        docHeight, didScroll, scrollPosition;

    function setDocHeight(){
        docHeight = Math.max(document.body.scrollHeight, document.body.offsetHeight, docElem.clientHeight, docElem.scrollHeight, docElem.offsetHeight);
        viewport.width = Math.max(docElem.clientWidth, window.innerWidth || 0);
        viewport.height = Math.max(docElem.clientHeight, window.innerHeight || 0);
    }

    // trick to prevent scrolling when opening/closing button
    function noScrollFn() {
        window.scrollTo( scrollPosition ? scrollPosition.x : 0, scrollPosition ? scrollPosition.y : 0 );
    }

    function scrollPage() {
        scrollPosition = { x : window.pageXOffset || docElem.scrollLeft, y : window.pageYOffset || docElem.scrollTop };
        didScroll = false;
    }

    function scrollHandler() {
        if( !didScroll ) {
            didScroll = true;
            window.setTimeout( function() { scrollPage(); }, 60 );
        }
    }

    function noScroll() {
        window.removeEventListener( 'scroll', scrollHandler );
        window.addEventListener( 'scroll', noScrollFn );
    }

    function scrollFn() {
        window.addEventListener( 'scroll', scrollHandler );
    }

    function canScroll() {
        window.removeEventListener( 'scroll', noScrollFn );
        scrollFn();
    }

    scrollFn();
    setDocHeight();

    var hideAlert = function($container, timeout){
        var $alert;
        var dfd = $.Deferred();
        dfd.promise();

        if ($container.is('[data-form-message="message"]')) {
            $alert = $container;
        } else {
            $alert = $('[data-form-message="message"]', $container);
        }

        timeout = timeout ? window.parseInt(timeout, 10) : 3000;

        window.setTimeout(function(){
            $alert.removeClass('alert alert-success alert-danger').html('').fadeOut(300, 'swing', function(){
                $alert.closest('[data-form-message="wrapper"]').addClass('alert-message--no-message');
                dfd.resolve();
            });
        },
        timeout);

        return dfd;
    };

    var showAlert = function($container, response, hideTimeout){
        var $alert;

        if (typeof(hideTimeout) === "undefined") {
            hideTimeout = 0;
        }

        if ($container.is('[data-form-message="message"]')) {
            $alert = $container;
        } else {
            $alert = $('[data-form-message="message"]', $container);
        }

        $alert.hide()
            .removeClass('alert-danger alert-success')
            .addClass(response.status === 'success' ? 'alert-success' : 'alert-danger')
            .addClass('alert')
            .html(response.data.message)
            .closest('[data-form-message="wrapper"]').removeClass('alert-message--no-message');

        if (hideTimeout) {
            hideAlert($alert, hideTimeout);
        }

        return $alert.fadeIn(300, 'swing');
    };

    var windowReload = function(evt){
        window.location.reload();

        if (evt) {
            evt.preventDefault();
            return false;
        }
    };

    // nawigacja strony
    new window.FixedNavbar($('[data-banner]'), 250);

    $('[data-nav-link],[data-toggle="collapse"],[data-scroll],[data-btn-slider="section"]').on('click', function(evt){
        var target, winLoc, animate, t;

        if (this.hasAttribute('data-noscroll')) {
            return;
        }

        winLoc = window.location;

        t = {
            hn: this.hostname,
            pn: this.pathname,
            tag: this.tagName.toLowerCase(),
        };

        if (t.tag === 'a' && (t.hn !== winLoc.hostname || (t.pn !== winLoc.pathname && t.pn+'/' !== winLoc.pathname))) {
            return;
        }

        if (this.hasAttribute('data-scroll')) {
            target = this.hasAttribute('data-scroll') ? $(this.getAttribute('data-scroll')) : false;
        }

        if (!target || !target.length) {
            target = this.hasAttribute('data-target') ? $(this.getAttribute('data-target')) : false;
        }

        if (!target || !target.length) {
            target = this.hash ? $(this.hash) : false;
        }

        animate = target && target.length;

        if (this.hasAttribute('data-toggle')) {
            animate = animate && !target.hasClass('show');
            target = target.parent();
        }

        if (this.hasAttribute("data-nav-link")) {
            $(this).closest(".navbar-collapse").collapse("hide");
        }

        if (animate) {
            evt.preventDefault();

            $('html,body').animate({
                scrollTop:target.offset().top - 150
            }, 600);
        }
    });

    // morph
    var $morph = $('[data-morph="wrapper"]');

    var morpher = new UIMorphingButton( $morph, {
        //		closeEl : '.icon-close',
        activeClass: 'contact-form__morph-wrapper--active',
        openClass: 'contact-form__morph-wrapper--open',
        noTransitionClass: 'contact-form__morph-wrapper--no-transition',
        scrollClass: 'contact-form__morph-wrapper--scroll',
        onBeforeOpen : function(){
            $body.addClass('body--contact-visible');
            // don't allow to scroll
            noScroll();
        },
        onAfterOpen : function(){
            // can scroll again
            canScroll();
        },
        onBeforeClose : function(){
            // don't allow to scroll
            noScroll();
        },
        onAfterClose : function(){
            $body.removeClass('body--contact-visible');
            // can scroll again
            canScroll();
        }
    } );

    $('#contactform-form').on('submit', function(evt){
        var $form = $(this);

        evt.preventDefault();

        $form.closest('.contact-form').addClass('contact-form--submitting');
        hideAlert($form);

        $form.ajaxSubmit({ // jquery.form
            url: dhlConfig.ajaxUrl,
            method: 'post',
            success: function(response){
                var i, input, cls;

                $form.closest('.contact-form').removeClass('contact-form--submitting');

                if (response.success) {
                    $form.get(0).reset();
                    $form.closest('[data-contact-form="form"]').addClass('contact-form__form-wrapper--hidden');
                    $('[data-contact-form="thankyou"]').removeClass('contact-form__thanks-wrapper--hidden');
                } else {
                    if (response.data.invalid && response.data.invalid.length) {
                        for (i = 0; i < response.data.invalid.length; ++i) {
                            input = $('[name="'+response.data.invalid[i]+'"]', $form);

                            if (input.attr('type') === 'file') {
                                input = input.closest('.contact-form__input-group');
                                cls = 'contact-form__input-group--invalid';
                            } else {
                                cls = 'contact-form__input--invalid';
                            }

                            input.addClass(cls).one('focus change', function(){
                                $(this).removeClass('contact-form__input-group--invalid contact-form__input--invalid');
                            });
                        }
                    }

                    showAlert($form, response);
                }
            }
        });
    });

    $('[data-thanks-confirm]').on('click', function(evt){
       evt.preventDefault();

       $('[data-contact-form="form"]').toggleClass('contact-form__form-wrapper--hidden');
       $('[data-contact-form="thankyou"]').toggleClass('contact-form__thanks-wrapper--hidden');

       morpher.toggle();
       return false;
   });

   // pliki w formularzach
   $(document).on('change', ':file', function(){
       var input = $(this),
       numFiles = input.get(0).files ? input.get(0).files.length : 1,
       label = input.val().replace(/\\/g, '/').replace(/.*\//, '');

       input.trigger('fileselect', [numFiles, label]);
   });

   $(':file').on('fileselect', function(event, numFiles, label){
       var input = $(this).parents('.input-group').find(':text'),
       log = numFiles > 1 ? numFiles + ' files selected' : label;

       if (input.length) {
           input.val(log);
       }
   });

    // pin
    $('[data-back]').pin({
        containerSelector:".single-article",
        minWidth:767,
        activeClass:'single-article__back-btn--active',
        padding:{
            top:86,
            bottom:120
        }
    });

    // karuzele
    $('[data-owl-carousel]').each(function(){
        var opts = {
            margin:this.hasAttribute("data-margin") ? parseInt(this.getAttribute("data-margin")) : 22,
            navText:['',''],
            dots:false,
        };

        if (this.hasAttribute("data-stage-padding")) {
            opts.stagePadding = parseInt(this.getAttribute("data-stage-padding"));
        }

        if (this.hasAttribute("data-autoplay")) {
            opts.autoplay = true;

            if (this.hasAttribute("data-autoplay-timeout")) {
                opts.autoplayTimeout = parseInt(this.getAttribute("data-autoplay-timeout"));
            } else {
                opts.autoplayTimeout = 3000;
            }

            if (this.hasAttribute("data-autoplay-hoverpause")) {
                opts.autoplayHoverPause = parseInt(this.getAttribute("data-autoplay-timeout")) ? true : false;
            }
        }

        if (this.hasAttribute("data-loop")) {
            opts.loop = parseInt(this.getAttribute("data-loop")) ? true : false;
        } else {
            opts.loop = false;
        }

        if (this.hasAttribute("data-nav")) {
            opts.nav = parseInt(this.getAttribute("data-nav")) > 0 ? true : false;
        }

        if (this.hasAttribute("data-center")) {
            opts.center = parseInt(this.getAttribute("data-center"))  > 0 ? true : false;
        }

        if (this.getAttribute("data-owl-carousel")  === "videos-carousel") {
            opts.responsive = {
                0:{
                    items:1,
                    center:true,
                    stagePadding:20
                },
                445:{
                    items:2,
                    center:false,
                },
                768:{
                    items:3,
                    center:false,
                    stagePadding:0,
                }
            };
        } else if (this.getAttribute("data-owl-carousel")  === "discover-articles") {
            opts.responsive = {
                0:{
                    items:1,
                    margin:15,
                    stagePadding:30
                },
                576:{
                    items:2,
                    margin:20,
                    stagePadding:20
                },
                992:{
                    items:3,
                    margin:20,
                    stagePadding:20
                },
                1200:{
                    margin:30,
                    stagePadding:0
                }
            };
        } else {
            opts.responsive = {
                0:{
                    items:1,
                },
                576:{
                    items:2,
                },
                992:{
                    items:3,
                }
            };
        }

        $(this).owlCarousel(opts);
    });

    // główny slider: symulowany autoplay, zdarzenia typu drag itd
    var ms = $('.main-video-slider .owl-carousel');
    var msDrag = {
        evt: 0,
        pageX: 0,
    };
    var msCurrentIndex = 0;
    var msAutoplayTimeout = 5000;
    var msTimeout;

    var msImages = $("img", ms);
    var msLoaded = 0;

    var msGo = function(direction) {
        var slides, currentSlide, ci, ni;

        slides = ms.find('.owl-item');
        currentSlide = slides.filter('.active');
        ci = currentSlide.index();

        if (ci === 0) {
            ni = (direction === "left") ? slides.length - 1 : 1;
            // nextSlide = (direction === "left") ? slides.last() : slides.eq(1);
        } else if (ci === (slides.length - 1)) {
            ni = (direction === "right") ? 0 : ci - 1;
            // nextSlide = (direction === "right") ? slides.first() : slides.eq(ci + 1);
        } else {
            ni = (direction === "left") ? ci - 1 : ci + 1;
            // nextSlide = (direction === "left") ? slides.eq(ci - 1) : slides.eq(ci + 1);
        }

        ms.trigger("to.owl.carousel", [ni]);
    };

    msImages.on("load", function(){
        ++msLoaded;

        if (msLoaded === msImages.length) {
            ms.trigger("refresh.owl.carousel");
        }
    });

    ms.on("mousedown touchstart", function(evt){
        msDrag.evt = 0;
        msDrag.pageX = evt.pageX;
    }).on("mousemove touchmove", function(evt){
        msDrag.evt = 1;
    }).on("mouseup touchend", function(evt){
        var dir;

        if (msDrag.evt === 0) { // click
            msDrag.pageX = evt.pageX;
        } else if (msDrag.evt === 1) { // drag
            dir = evt.pageX < msDrag.pageX ? "left" : "right";

            if (Math.abs(evt.pageX - msDrag.pageX) > 40) {
                msGo(dir);
            }
        }
    }).on("mouseenter", function(){
        window.clearTimeout(msTimeout);
    }).on("mouseleave", function(){
        window.clearTimeout(msTimeout);

        if (!ms.find(".owl-item:eq("+msCurrentIndex+")").find("[data-yt-video]").length) {
            msTimeout = window.setTimeout(function(){
                msGo("right");
            }, msAutoplayTimeout);
        }
    }).one("initialized.yt.player", function(evt){
        msCurrentIndex = evt.item ? evt.item.index : 0;

        window.clearTimeout(msTimeout);

        if (!ms.find(".owl-item:eq("+msCurrentIndex+")").find("[data-yt-video]").length) {
            msTimeout = window.setTimeout(function(){
                msGo("right");
            }, msAutoplayTimeout);
        }
    }).on("translate.owl.carousel", function(evt){
        window.clearTimeout(msTimeout);
    }).on("translated.owl.carousel", function(evt){
        var ytVideo = ms.find(".owl-item:eq("+evt.item.index+")").find("[data-yt-video]");

        msCurrentIndex = evt.item.index;

        window.clearTimeout(msTimeout);

        if (!ms.find(".owl-item:eq("+evt.item.index+")").find("[data-yt-video]").length) {
            msTimeout = window.setTimeout(function(){
                msGo("right");
            }, msAutoplayTimeout);
        }
    }).owlCarousel({
        items:1,
        loop:false,
        margin:0,
        // video:true,
        // lazyLoad:true,
        center:true,
        nav:false,
        dots:false,
        singleItem:true,
        mouseDrag:false,
        touchDrag:false,
        pullDrag:false,
        animateIn:'fadeIn',
        animateOut:'fadeOut',
        autoHeight:true,
        // autoplay:true,
        // autoplayTimeout:msAutoplayTimeout,
        // autoplayHoverPause:true,
    });

    // video
    var videos = $('[data-yt-video]');
    var didCarousels = [];

    window.onYouTubePlayerAPIReady = function() {
        videos.each(function(){
            var $this = $(this);
            var id = this.id;
            var carousel = $this.closest('.owl-carousel');
            var modal = $this.closest('.modal');
            var playerOpts = {};
            var player, play;

            if (carousel.length) {
                var slide = $this.closest('.owl-item');

                if (carousel.closest('.main-video-slider').length) {
                    playerOpts.events = {
                        onReady: function(evt) {
                            if (slide.hasClass('active')) {
                                evt.target.playVideo(evt);
                            }

                            carousel.trigger("initialized.yt.player", evt.target);
                        },
                        onStateChange: function(evt){
                            if (evt.data === YT.PlayerState.ENDED && slide.hasClass('active')) {
                                // player.playVideo();
								msGo("right");
                            }

                            carousel.trigger("state-changed.yt.player", evt.target);
                        }
                    };
                } // else {
                //     playerOpts.events = {
                //         onStateChange: function(evt){
                //             if (evt.data === YT.PlayerState.PLAYING || evt.data === YT.PlayerState.BUFFERING || evt.data === YT.PlayerState.CUED) {
                //                 carousel.trigger('stop.owl.autoplay');
                //             } else if (carousel.find('.owl-item').not('.cloned').length === 1) {
                //                 player.playVideo();
                //             } else if (carousel.attr('data-autoplay') && evt.data === 0) {
                //                 carousel.trigger('next.owl.carousel');
                //             }
                //         }
                //     };
                // }

                // if (slide.hasClass('active') && didCarousels.indexOf(carousel.get(0)) === -1) {
                //     if (carousel.attr('data-autoplay')) {
                //         carousel.trigger('stop.owl.autoplay');
                //     }
                //
                //     didCarousels.push(carousel.get(0));
                //
                //     playerOpts.events.onReady = function(){
                //         player.playVideo();
                //     };
                // }

                player = new YT.Player(this, playerOpts);

                carousel.on("translate.owl.carousel", function(evt){
                    var pState = player.getPlayerState();

                    if (slide.index() === evt.item.index) {
                        if (pState === YT.PlayerState.ENDED || pState === YT.PlayerState.PAUSED || pState === YT.PlayerState.UNSTARTED || pState === YT.PlayerState.CUED) {
                            player.playVideo();
                        }
                    }
                }).on("translated.owl.carousel", function(evt){
                    var pState = player.getPlayerState();

                    if (slide.index() !== evt.item.index) {
                        if (pState === YT.PlayerState.PLAYING || pState === YT.PlayerState.BUFFERING || pState === YT.PlayerState.CUED) {
                            player.pauseVideo();
                        }
                    }
                });
            } else {
                player = new YT.Player(this);

                play = $('[data-btn="play"]').filter(function(){
                    return (this.hasAttribute('href') && this.getAttribute('href').indexOf(id) !== -1) ||
                           (this.hasAttribute('data-play') && this.getAttribute('data-play') === '#'+id);
                });

                play.on('click', function(evt){
                    var $this = $(this),
                        pState = player ? player.getPlayerState() : false;

                    evt.preventDefault();

                    $this.trigger('blur');

                    // -1 – UNSTARTED (nie uruchomiono)
                    // 0  – ENDED (zakończono)
                    // 1  – PLAYING (odtwarzanie)
                    // 2  – PAUSED (wstrzymano)
                    // 3  – BUFFERING (buforowanie)
                    // 5  – video CUED (film został wskazany)
                    if ($this.attr('data-dismiss')) {
                        if (pState === YT.PlayerState.PLAYING || pState === YT.PlayerState.BUFFERING || pState === YT.PlayerState.CUED) {
                            player.pauseVideo();
                        }
                    } else {
                        // if (pState === -1 || pState === 0 || pState === 1 || pState === 2 || pState === 5) {
                        if (pState === YT.PlayerState.UNSTARTED || pState === YT.PlayerState.ENDED || pState === YT.PlayerState.PLAYING || pState === YT.PlayerState.PAUSED || pState === YT.PlayerState.CUED) {
                            player.playVideo();
                        }
                    }
                });

                modal.on('shown.bs.modal', function(){
                    window.clearTimeout(msTimeout);

                    $('[data-yt-video]', ms).each(function(){
                        var $this = $(this);
                        var player = $this.data('ytPlayer');
                        var pState = player ? player.getPlayerState() : false;

                        if (pState === YT.PlayerState.PLAYING || pState === YT.PlayerState.BUFFERING || pState === YT.PlayerState.CUED) {
                            player.pauseVideo();
                        }
                    });
                }).on('hidden.bs.modal', function(evt){
                    var activeMsVideo = $('.owl-item.active [data-yt-video]', ms);
                    var activeVideoPlayer = activeMsVideo.data('ytPlayer');

                    if (player.getPlayerState() === YT.PlayerState.PLAYING || player.getPlayerState() === YT.PlayerState.BUFFERING) {
                        player.pauseVideo();
                    }

                    if (activeVideoPlayer) {
                        activeVideoPlayer.playVideo();
                    }

                    msTimeout = window.setTimeout(function(){
                        msGo("right");
                    }, msAutoplayTimeout);
                });
            }

            $this.data('ytPlayer', player);
        });
    };

    if (videos.length) {
        $.getScript('//www.youtube.com/iframe_api');
    }

})(jQuery);
