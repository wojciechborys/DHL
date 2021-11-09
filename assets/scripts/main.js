/* ========================================================================
 * DOM-based Routing
 * Based on http://goo.gl/EUTi53 by Paul Irish
 *
 * Only fires on body classes that match. If a body class contains a dash,
 * replace the dash with an underscore when adding it to the object below.
 *
 * .noConflict()
 * The routing is enclosed within an anonymous function so that you can
 * always reference jQuery with $, even when in .noConflict() mode.
 * ======================================================================== */

(function($) {
	
    $.fn.carouselHeights = function() {

        var items = $(this), //grab all slides
            heights = [], //create empty array to store height values
            tallest; //create variable to make note of the tallest slide

        var normalizeHeights = function() {

            items.each(function() { //add heights to array
                heights.push($(this).height());
            });
            tallest = Math.max.apply(null, heights); //cache largest value
            items.each(function() {
                $(this).css('min-height',tallest + 'px');
            });
        };

        normalizeHeights();

        $(window).on('resize orientationchange', function () {
            //reset vars
            tallest = 0;
            heights.length = 0;

            items.each(function() {
                $(this).css('min-height','0'); //reset min-height
            });
            normalizeHeights(); //run it again
        });

    };

    var searchFormToggler = function($hovered){
        var timeout;

        var self = this;

        var clear = function(){
            window.clearTimeout(timeout);
        };

        var show = function(){
            clear();

            self.el.addClass('nav-primary__item--hovered');
            self.form.addClass('nav-primary__form--active');
        };

        var hide = function(){
            clear();

            timeout = window.setTimeout(function(){
                self.el.removeClass('nav-primary__item--hovered');
                self.form.removeClass('nav-primary__form--active').find('input,button').trigger('blur');
            }, 6000);
        };

        this.el = $hovered;
        this.form = this.el.find('[data-search-form]');

        this.el.on('mouseenter', show).on('mouseleave', hide).find('a').on('click', function(evt){
            evt.preventDefault();
        });

        this.form.on('mouseenter', show).on('mouseleave', hide)
                 .find('input[name="s"]').on('focus', show).on('blur', hide).on('keydown', hide);
    };

    var sendSignupSuccess = function(){
        if ($('body').hasClass('single-post')) {
            typeof gtag === 'undefined' || gtag('event', 'generate_lead', {
                'event_category': 'engagement',
                'event_label': 'lock'
            });

            typeof fbq === 'undefined' || fbq('track', 'CompleteRegistration');
        } else {
            typeof gtag === 'undefined' || gtag('event', 'generate_lead', {
                'event_category': 'engagement',
                'event_label': 'form'
            });

            typeof fbq === 'undefined' || fbq('track', 'CompleteRegistration');
        }

        typeof gtag === 'undefined' || gtag('event', 'conversion', {'send_to': 'AW-820830062/0xSeCPSAt34Q7r6zhwM'});
    };

    var setCookie = function(name,value,days){
        var expires = "";
        if (days) {
            var date = new Date();
            date.setTime(date.getTime() + (days*24*60*60*1000));
            expires = "; expires=" + date.toUTCString();
        }
        document.cookie = name + "=" + (value || "")  + expires + "; path=/";
    };

    var getCookie = function(name){
        var nameEQ = name + "=";
        var ca = document.cookie.split(';');
        for(var i=0;i < ca.length;i++) {
            var c = ca[i];
            while (c.charAt(0)==' ') c = c.substring(1,c.length);
            if (c.indexOf(nameEQ) == 0) return c.substring(nameEQ.length,c.length);
        }
        return null;
    };

    new window.FixedNavbar($('[data-banner]'), 250);

  // Use this variable to set up the common and page specific functions. If you
  // rename this variable, you will also need to rename the namespace below.
  var Sage = {
    // All pages
    'common': {
      init: function() {
        // cookies
        if (getCookie('_cookie-policy-consent') === '1') {
          $('[data-cookie-consent]').addClass('cookie-consent--accepted');
        }

        $(document).on('click', '[data-close-cookies]', function(){
          $(this).closest('[data-cookie-consent]').addClass('cookie-consent--accepted');
          setCookie('_cookie-policy-consent', '1', 30);
        });
      },
      finalize: function() {
        // JavaScript to be fired on all pages, after page specific JS is fired
        var newsletterValidationTooltipTimeout;

        var openNewsletterTooltip = function(element, messagesArr, useTimeout){
            var el = element.jquery ? element : $(element);

            closeNewsletterTooltip(el);

            el.attr('title', messagesArr.join(' '))
              .tooltip({trigger:'manual'})
              .tooltip('show')
              .data('hasTooltip', true)
              .trigger("blur");

            if (useTimeout) {
                newsletterValidationTooltipTimeout = window.setTimeout(function(){
                    closeNewsletterTooltip(el);
                }, 10000);

                $(document).one("click", function(evt){
                    if (el.get(0) !== evt.target) {
                        closeNewsletterTooltip(el);
                    }
                });
            }
        }

        var closeNewsletterTooltip = function(element){
            var el = element.jquery ? element : $(element);

            window.clearTimeout(newsletterValidationTooltipTimeout);

            if (el.data("hasTooltip")) {
                el.tooltip("dispose").data("hasTooltip", false);
            }
        }

        var addNewletterInputValidationError = function(){
            $(this).addClass('newsletter__input--has-error');
        };

        var removeNewletterInputValidationError = function(){
            $(this).removeClass('newsletter__input--has-error');
        };

        searchFormToggler($('[data-search-trigger]'));

        $('.love-button').on('click', function(){

            var $button = $(this),
                postId = $(this).attr('data-postid');

            $.ajax({
              url: sd_config.ajax_url,
              data: {
                  postid: postId,
                  action: 'love_action'
              },
              method: 'POST'
            }).done(function(response) {

                if( typeof(response.likes) !== "undefined") {
                    $('.likes', $button).html(response.likes);
                }
            });
            return false;
        });

        $(window).on('load', function(){
            $('.archive-slider .carousel-item').carouselHeights();
        });

        $('.button-load-more').on('click', function() {

            var $mainContentsLastElement = $('.main-contents .col-12:last-child');

            var data = {
                page: new Number(this.hasAttribute('data-page') ? this.getAttribute('data-page') : 1)+1,
                type: 'post',
                action: 'load_action',
            };

            if (this.hasAttribute('data-tags')) {
                data.tags = this.getAttribute('data-tags');
            }

            if (this.hasAttribute('data-phrase')) {
                data.search = this.getAttribute('data-phrase');
            }

            this.setAttribute('data-page', data.page);

            $.ajax({
                url: sd_config.ajax_url,
                data: data,
                method: 'POST'
            }).done(function(response) {

                if(typeof(response.next) !== "undefined") {
                    if(response.next === 0) {
                        $mainContentsLastElement.addClass('d-none');
                    }
                }

                if(typeof(response.posts) !== "undefined") {
                    for(var i=0; i<response.posts.length;i++) {
                        // wstaw nowy artykuł tuż przed ostatnim elementem w treści (ostatni to button "Zobacz więcej")
                        $('<div></div>').addClass('col-12 col-sm-6').append(response.posts[i]).insertBefore($mainContentsLastElement);
                    }
                }

            });

            return false;
        });

        $(document).on('click', '[data-btn-signin]', function(evt){
            var target = this.hash && this.hash.length > 1 ? $(this.hash) : false;

            if (target && target.length) {
                evt.preventDefault();

                $('html,body').animate({
                    scrollTop:target.offset().top - 50
                }, 600);
            }
        })
        .on('click', '[data-access-submit]', function(evt){
            var $t = $(this);
            var form = $t.closest('form');

            var $name = form.find('[name="name"]'),
                name = $.trim($name.val()),
                nameRegex = /^[a-zA-ZąćęłńóśżźĄĆĘŁŃÓŚŻŹ ]{2,50}$/,
                isName = nameRegex.test(name);

            var $email = form.find('[name="email"]'),
                email = $.trim($email.val()),
                emailRegex = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/,
                isEmail = emailRegex.test(email.toLowerCase());

            // var $consentReceiving = form.find('[name="electronic-information-consent"]'),
            //     consentReceiving = $consentReceiving.is(':checked');

            // var $consentProcessing = form.find('[name="data-processing-consent"]'),
            //     consentProcessing = $consentProcessing.is(':checked');

            var $termsConsent = form.find('[name="terms-consent"]'),
                termsConsent = $termsConsent.is(':checked');

            var relatedPost = form.find('[name="related-post"]').val();

            var messages = [];

            evt.preventDefault();

            closeNewsletterTooltip($t);

            removeNewletterInputValidationError.apply($name.get(0));
            removeNewletterInputValidationError.apply($email.get(0));

            if (!isName) {
                addNewletterInputValidationError.apply($name.get(0));
                $name.one('input', removeNewletterInputValidationError);
            }

            if (!isEmail) {
                addNewletterInputValidationError.apply($email.get(0));
                $email.one('input', removeNewletterInputValidationError);
            }

            if (!isName || !isEmail) {
                messages.push('Uzupełnij dane w prawidłowy sposób.');
            }

            // if (!consentReceiving || !consentProcessing) {
            //     messages.push('Wyrażenie wszystkich zgód jest obowiązkowe.');
            // }

            if (!termsConsent) {
                messages.push('Wyrażenie zgody jest obowiązkowe.');
            }

            if (messages.length) {
                openNewsletterTooltip($t, messages, true);
                return;
            }

            $.ajax({
                url: sd_config.ajax_url,
                data: {
                    name: name,
                    email: email,
                    'related-post': $.trim(relatedPost),
                    'terms-consent': termsConsent,
                    'terms-consent-statement': $.trim($termsConsent.parent().text()),
                    // 'data-processing-consent-statement': consentReceiving ? 'tak' : 'nie',
                    // 'electronic-information-consent': $.trim($consentProcessing.parent().text()),
                    // 'electronic-information-consent-statement': consentProcessing ? 'tak' : 'nie',
                    action: 'access_submission'
                },
                method: 'POST'
            }).done(function(response) {
                if (response.data && response.data.message) {
                    openNewsletterTooltip($t, [data.message], true);
                }

                if (response.success) {
                    $t.closest("[data-newsletter-step]").removeClass("newsletter__step--current").addClass("newsletter__step--prev")
                      .next("[data-newsletter-step]").addClass("newsletter__step--current").removeClass("newsletter__step--next");

                    window.setTimeout(function(){
                        $t.closest("[data-newsletter-step]").addClass("newsletter__step--current").removeClass("newsletter__step--prev")
                          .next("[data-newsletter-step]").removeClass("newsletter__step--current").addClass("newsletter__step--next");
                    }, 30000);

                    if (response.reload) {
                        window.setTimeout(function(){
                            window.location.reload();
                        }, 5000);
                    }

                    form.get(0).reset();
                    sendSignupSuccess();
                }
            });

        });

      }
    },
    // Home page
    'home': {
      init: function() {
        // JavaScript to be fired on the home page
      },
      finalize: function() {
        // JavaScript to be fired on the home page, after the init JS

        var mainSlider = $('.main-slider').owlCarousel({
            loop:true,
            autoplay:true,
            margin: 0,
            nav: true,
            dots: false,
            items:1,
            center: true,
            navSpeed: 600
        });

        var mainSliderCarousel = $('.main-slider__carousel .owl-carousel').owlCarousel({
            loop:false,
            margin: 30,
            nav: false,
            responsive: {
                0: {
                    items:1,
                    center: true
                },
                445: {
                    items: 2,
                    center: false
                },
                768: {
                    items: 3,
                    center: false
                }
            }
        });

        $('.main-slider__carousel-prev').click(function(){
            mainSliderCarousel.trigger('prev.owl.carousel');
            return false;
        });

        $('.main-slider__carousel-next').click(function(){
            mainSliderCarousel.trigger('next.owl.carousel');
            return false;
        });

      }
    },
    // About us page, note the change from about-us to about_us.
    'about_us': {
      init: function() {
        // JavaScript to be fired on the about us page
      }
    }
  };

  // The routing fires all common scripts, followed by the page specific scripts.
  // Add additional events for more control over timing e.g. a finalize event
  var UTIL = {
    fire: function(func, funcname, args) {
      var fire;
      var namespace = Sage;
      funcname = (funcname === undefined) ? 'init' : funcname;
      fire = func !== '';
      fire = fire && namespace[func];
      fire = fire && typeof namespace[func][funcname] === 'function';

      if (fire) {
        namespace[func][funcname](args);
      }
    },
    loadEvents: function() {
      // Fire common init JS
      UTIL.fire('common');

      // Fire page-specific init JS, and then finalize JS
      $.each(document.body.className.replace(/-/g, '_').split(/\s+/), function(i, classnm) {
        UTIL.fire(classnm);
        UTIL.fire(classnm, 'finalize');
      });

      // Fire common finalize JS
      UTIL.fire('common', 'finalize');
    }
  };

  // Load Events
  $(document).ready(UTIL.loadEvents);

})(jQuery); // Fully reference jQuery after this point.
