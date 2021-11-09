(function($, Config) {
    "use strict";

    var transEndEventNames = {
    	'transition': 'transitionend',
    	'WebkitTransition': 'webkitTransitionEnd',
    	'MozTransition': 'transitionend',
    	'OTransition': 'oTransitionEnd',
    	'msTransition': 'MSTransitionEnd'
    },
    support = {},
    div = document.createElement('div'),
    transEndEventName, t;

    for (t in transEndEventNames) {
        if (typeof div.style[t] !== 'undefined') {
            transEndEventName = transEndEventNames[t];
            support.transitions = true;
            break;
        }
    }

    var $body = $('body'),
        $document = $(document),
        $window = $(window),
        $banner = $('[data-banner]'),
        $contactContainer = $('[data-form-container="contact-us"]');

    // ramka
    // var iframe = document.getElementById('dhl-express-form-iframe');

    window.triggerAnalyticsEvent = function(eventCategory, eventAction, eventLabel){
        if (typeof dataLayer === 'undefined') {
            return false;
        }

        dataLayer.push({
            "event":eventAction,
            "event_category":eventCategory,
            "event_label":eventLabel
        });
    };

    function createForm(path, params, method, target){
        var form = $(document.createElement("form"))
                .attr({"method": method || "post", "action": path, target: target});

        $.each(params, function(key,value){
            $.each(value instanceof Array ? value : [value], function(i,val){
                $(document.createElement("input"))
                    .attr({"type": "hidden", "name": key, "value": val})
                    .appendTo(form);
            });
        });

        return form.appendTo($body);
    }

    function validateNIP(value){
        var verificator_nip = new Array(6,5,7,2,3,4,5,6,7);
        var nip = value.replace(/[\ \-]/gi, '');

        if (nip.length !== 10)  {
            return false;
        } else {
            var n = 0;

            for (var i=0; i<9; i++) {
                n += nip[i] * verificator_nip[i];
            }

            n %= 11;

            if (n !== parseInt(nip[9], 10)) {
                return false;
            }
        }

        return true;
    }

    // // fixed navbar
    // var FixedNavbar = function(selector, reference) {
    // 	var self = this;
    //
    // 	this.$navbar = $(selector);
    //
    //     this.setReference(reference);
    //
    // 	this.calculate();
    // 	this.maybeChange();
    //
    // 	$window.on('resize', function() {
    // 		self.calculate();
    // 		self.maybeChange();
    // 	})
    // 	.on('scroll', function() {
    // 		self.maybeChange();
    // 	});
    // };
    //
    // FixedNavbar.prototype.calculate = function() {
    // 	this.distance = this.$navbar.offset().top;
    //     this.navbarHeight = this.$navbar.height();
    // };
    //
    // FixedNavbar.prototype.setReference = function(reference) {
    //     if (typeof reference === "number") {
    //         this.refDistance = reference;
    //     } else {
    //         reference = reference.jquery ? reference : $(reference);
    //         this.refDistance = reference.offset().top;
    //     }
    // };
    //
    // FixedNavbar.prototype.shouldStick = function() {
    // 	return ($document.scrollTop() >= this.refDistance);
    // };
    //
    // FixedNavbar.prototype.maybeChange = function() {
    //     var sticky = this.isSticky();
    //
    // 	if (this.shouldStick()) {
    // 		if (!sticky) {
    // 			this.makeSticky();
    // 		}
    // 	} else {
    // 		if (sticky) {
    // 			this.unMakeSticky();
    // 		}
    // 	}
    // };
    //
    // FixedNavbar.prototype.isSticky = function() {
    //     return this.$navbar.hasClass('banner--fixed');
    // };
    //
    // FixedNavbar.prototype.makeSticky = function() {
    //     var self = this;
    //     var $submitButton = $('[data-submit]', $contactContainer);
    //
    //     if ('contact' === $submitButton.attr('data-submit')){
    //         $submitButton.attr('data-submit', 'toggle');
    //     }
    //
    // 	this.$navbar.one(transEndEventName, function(evt){
    //         $submitButton.removeClass('btn-secondary').addClass('btn-primary');
    //         $body.removeClass("doc-body--banner-transitioning");
    //     }).addClass('banner--fixed');
    //
    // 	$body.addClass("doc-body--fixed-banner doc-body--banner-transitioning");
    // };
    //
    // FixedNavbar.prototype.unMakeSticky = function() {
    //     var self = this;
    //     var $submitButton = $('[data-submit]', $contactContainer);
    //
    // 	this.$navbar.one(transEndEventName, function(evt){
    //         if (this === evt.target) {
    //             self.$navbar.removeClass('banner--hiding banner--fixed');
    //             $submitButton.removeClass('btn-primary').addClass('btn-secondary');
    //
    //             if ('toggle' === $submitButton.attr('data-submit') && Config.isFrontPage){
    //                 $submitButton.attr('data-submit', 'contact');
    //             }
    //
    //             $body.removeClass("doc-body--fixed-banner");
    //         }
    //     }).addClass('banner--hiding');
    // };

    function exchangeFsPlaceholders($form) {
        $form.find('[data-fs-placeholder]').each(function(){
            var $t, input;
            var attr = this.getAttribute('data-fs-placeholder');

            if (!attr.length) {
                return;
            }

            input = $(this).parent().find('input[type="text"],input[type="email"],input[type="number"],textarea');
            this.setAttribute('data-fs-placeholder', input.attr('placeholder'));
            input.attr('placeholder', attr);
        });
    }

    // var fNavbar;
    //
    // if ($body.hasClass('home')) {
    //     var contactForm = $('#contact-us-form');
    //     var winW = $window.width();
    //     var nvref;
    //
    //     if (winW > 991) {
    //         nvref = 720;
    //     } else if (winW > 576) {
    //         nvref = 1100;
    //     } else {
    //         nvref = 1300;
    //     }
    //
    //     fNavbar = new FixedNavbar('[data-banner]', nvref);
    //
    //     $window.on('resize', function(){
    //         var winW = $window.width();
    //         var nvref;
    //
    //         if (winW > 991) {
    //             nvref = 720;
    //         } else if (winW > 576) {
    //             nvref = 1100;
    //         } else {
    //             nvref = 1300;
    //         }
    //
    //         fNavbar.setReference(nvref);
    //     });
    // } else {
    //     fNavbar = new FixedNavbar('[data-banner]', ($window.width() > 991 ? 290 : 360));
    //
    //     $window.on('resize', function(){
    //         if ($window.width() > 991) {
    //             fNavbar.setReference(290);
    //         } else {
    //             fNavbar.setReference(360);
    //         }
    //     });
    // }

    // cookies
    if ($.cookie('_cookie-policy-consent') === '1') {
        $('[data-cookie-consent]').addClass('cookie-consent--accepted');
    }

    $document.on('click', '[data-close-cookies]', function(){
        $(this).closest('[data-cookie-consent]').addClass('cookie-consent--accepted');
        $.cookie('_cookie-policy-consent', '1', { expires: 30, path: '/' });
    });

    $('[data-back]').pin({
		containerSelector: ".single-article",
		minWidth: 767,
        activeClass: 'single-article__back-btn--active',
        padding: {
            top:120,
            bottom: 80
        }
	});

    $('[data-tooltip]').each(function(){
        var title;

        if (!this.hasAttribute('title') || !this.title.length) {
            return;
        }

        $(this).tooltip();
    });

    $('.js-toggle-lang').on('click', function (e) {
        $(this).toggleClass('active');
        $('.js-banner__language-switch').toggleClass('active');
    });

    $('.js-hamburger').on('click', function (e) {
        $(this).toggleClass('open');
        $(this).parent().parent().parent().toggleClass('mobile-open');
        $(this).parent().parent().parent().parent().toggleClass('mobile-open');
    });

    // kontakt
    $document.on('click', 'a', function(evt){
        if (evt.target.hash === '#contact-us-form') {
            evt.preventDefault();

            $(evt.target).trigger('blur');
            $('[data-submit]', evt.target.hash).trigger('click');
        }
    })
    .on('click', '[data-submit]', function(evt){
        evt.preventDefault();

        if (Config.isFrontPage) {
            $("html,body").animate({
                scrollTop:($window.width() < 992 ? 660 : 0)
            }, 600);
        } else {
            window.location = Config.home_url;
        }

    })
    .on('click', '[data-scroller]', function(evt){
        var $t = $(this);
        var target = this.hash.length ? $(this.hash) : false;

        if (target && target.length) {
            evt.preventDefault();

            $('html,body').animate({
                scrollTop: target.offset().top
            }, 500, 'swing');
        }

        switch (this.id) {
            case 'button-top-check-calculator':
                triggerAnalyticsEvent('Calculator', 'goto', 'Top');
                break;

            case 'button-footer-check-calculator':
                triggerAnalyticsEvent('Calculator', 'goto', 'Bottom');
                break;
        }
    })
    .on('click', '[data-trigger-contact]', function(evt){
        evt.preventDefault();
        $contactContainer.find('[data-submit="toggle"]').trigger('click');
        $(this).trigger('blur');
    });

    $(document).ready(function () {
        $('.content-calc__input--postal').mask('00-000');
    });

    var originalPos;
    var elem = $('.banner__header');
    $(document).on("scroll", function(e){
        if(elem.offset().top > 1){
            elem.addClass("affixed");
        }

        if(elem.hasClass("affixed")){
            if(elem.offset().top <= 1) {
                elem.removeClass("affixed");
            }
            return;
        }

        if((originalPos = elem.offset().top) > 1){
            elem.addClass("affixed");
        }

    });

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
    };

    var addNewletterInputValidationError = function(){
        $(this).addClass('newsletter__input--has-error');
    };

    var removeNewletterInputValidationError = function(){
        $(this).removeClass('newsletter__input--has-error');
    };

    // newsletter
    $(document).on('click', '[data-access-submit]', function(evt){
        var $t = $(this);
        var form = $t.closest('form');

        var $email = form.find('[name="email"]'),
            email = $.trim($email.val()),
            emailRegex = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/,
            isEmail = emailRegex.test(email.toLowerCase());

        var $termsConsent = form.find('[name="terms-consent"]'),
            termsConsent = $termsConsent.is(':checked');

        var relatedPost = form.find('[name="related-post"]').val();

        var messages = [];

        evt.preventDefault();

        closeNewsletterTooltip($t);

        removeNewletterInputValidationError.apply($email.get(0));

        if (!isEmail) {
            addNewletterInputValidationError.apply($email.get(0));
            $email.one('input', removeNewletterInputValidationError);
        }

        if (!isEmail) {
            messages.push('Uzupełnij dane w prawidłowy sposób.');
        }

        if (!termsConsent) {
            messages.push('Wyrażenie zgody jest obowiązkowe.');
        }

        if (messages.length) {
            openNewsletterTooltip($t, messages, true);
            return;
        }

        $.ajax({
            url: MmConfig.ajax_url,
            data: {
                email: email,
                'related-post': $.trim(relatedPost),
                'terms-consent': termsConsent,
                'terms-consent-statement': $.trim($termsConsent.parent().text()),
                action: 'access_submission_homepage'
            },
            method: 'POST'
        }).done(function(response) {
            // console.log(response);
            // alert('success');
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
            //     sendSignupSuccess();
            }
        }).failed(function (error) {
            // console.log(error);
        });

    });
})(jQuery, MmConfig);
