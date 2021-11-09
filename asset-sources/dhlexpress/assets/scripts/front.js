(function ($, Config, Calc) {

    "use strict";

    var $contactForm = $('#contact-us-form');

    var resultsTimeout;
    var popoverOpts = {
        content: '',
        title: '',
        html: true,
        trigger: 'manual',
        placement: 'bottom'
    };

    var calcFields = $('[data-calc-field]');

    calcFields.filter('[data-calc-field="country"]').combobox({
        inputClass: 'form-control'
    });

    calcFields.filter('[data-calc-field="calculate"]').on('click', function (evt) {
        var calc = {};
        var fields = calcFields;
        var resultsWrapper = $('[data-calc-results]');
        var results = $('[data-calc-result]', resultsWrapper);
        var valid = 1; // bo button to też 'data-calc-field'
        var resultsAppend, visible, cost, vals, transitTime;
        var dimensionsEventSent = false;

        var country = $('.content-calc__calculator .content-calc__input--country').val();
        var postalCode = $('.content-calc__calculator .content-calc__input--postal').val();
        var weight = $('.content-calc__calculator .content-calc__input--weight').val();

        evt.preventDefault();

        results.removeClass('content-calc__result--visible');

        fields.not('button').each(function () {
            var $t = $(this);
            var attr = this.getAttribute('data-calc-field');
            var invalidationType = false;
            var max_range, min_range, value;

            if ('country' === attr) {
                value = $(this).val();

                calc.code = value;

                if (value) {
                    calc[attr] = Calc.countryUtil.code2country(calc.code);

                    if (calc[attr]) {
                        ++valid;
                    } else {
                        invalidationType = 'invalid';
                    }

                    calc.zone = Calc.countryUtil.code2zone(calc.code);

                    transitTime = Calc.getTransitTime(calc.code);
                } else {
                    invalidationType = 'empty';

                    calc[attr] = false;
                    calc.zone = false;

                    transitTime = false;
                }
            } else if ('postal' === attr) {
                ++valid;
                calc[attr] = $(this).val();
            } else {
                value = window.parseFloat($(this).val());
                min_range = Calc.config.ranges[attr].min || 0.1;
                max_range = Calc.config.ranges[attr].max || 120;

                if (value >= min_range && value <= max_range) {
                    ++valid;
                } else {
                    invalidationType = (value > max_range) ? 'over' : 'below';

                    if ('weight' === attr) {
                        triggerAnalyticsEvent('Calculator', 'calculate', 'fail_weight');
                    } else if (!dimensionsEventSent) {
                        triggerAnalyticsEvent('Calculator', 'calculate', 'fail_dimension');
                        dimensionsEventSent = true;
                    }
                }

                calc[attr] = value;
            }

            if (invalidationType) {
                if ('country' === attr) {
                    $t.closest('label').find('.ui-autocomplete-input').addClass('content-calc__input--invalid');
                } else {
                    $t.addClass('content-calc__input--invalid');
                }

                if ($t.parent().data('hasPopover')) {
                    $t.parent().popover('dispose').data('hasPopover', false);
                }

                $t.parent().one('input autocompleteselect', function (evt) {
                    var $this = $(this).off('input').off('autocompleteselect');
                    var $target = evt.target.className.indexOf('ui-autocomplete-input') !== -1 ? $(evt.target) : $this.children();

                    $target.removeClass('content-calc__input--invalid');

                    if ($this.data('hasPopover')) {
                        $this.popover('dispose').data('hasPopover', false);
                    }
                }).popover($.extend({}, popoverOpts, {
                    content: Config.calcValidation[attr][invalidationType]
                })).data('hasPopover', true).popover('show');
            } else {
                if ('country' === attr) {
                    $t.closest('label').find('.ui-autocomplete-input').removeClass('content-calc__input--invalid');
                } else {
                    $t.removeClass('content-calc__input--invalid');
                }
            }
        });

        if (valid !== fields.length) {
            resultsWrapper.removeClass('content-calc__results--has-results');
            return;
        }

        vals = new Calc.CalcValues(calc);
        cost = Calc.getCost(vals);

        if (Calc.postalUtil.byCode(calc.postal)) {
            $('.content-calc__result').show().eq(2).hide();
        } else {
            $('.content-calc__result').show().eq(2).show();
        }
        // console.log('strefa:', calc.zone, ' podatek:', vatRate);

        visible = resultsWrapper.hasClass('content-calc__results--has-results');

        if (!visible) {
            resultsWrapper.addClass('content-calc__results--has-results');
        }

        resultsAppend = function () {
            var prop, result, time, timeInfo, zl, gr, els, el, ei, txt;

            for (prop in cost) {
                result = $('[data-calc-result="' + prop + '"]', resultsWrapper).removeClass('content-calc__result--visible');

                if (transitTime) {
                    time = $('[data-shipment-time]', result);

                    timeInfo = transitTime + ' ';

                    if (transitTime.trim() === '1') {
                        timeInfo += time.attr('data-singular');
                    } else {
                        timeInfo += time.attr('data-plural');
                    }

                    time.text(timeInfo);
                }

                cost[prop] *= 100;

                gr = cost[prop] % 100;

                zl = gr > 0 ? parseInt(cost[prop] - gr) : cost[prop];
                zl = zl / 100;

                if (0 === gr) {
                    gr = '00';
                } else {
                    if (gr < 10) {
                        gr = '0' + gr.toString().substr(0, 1);
                    } else {
                        gr = gr.toString().substr(0, 2);
                    }
                }

                // console.log(gr);

                if (!zl) {
                    if (result.attr('data-result-version') !== 'alt') {
                        result.attr('data-result-version', 'alt');

                        if (result.attr('data-alt-class')) {
                            result.addClass(result.attr('data-alt-class'));
                        }

                        els = $('[data-alt-text]', result);

                        for (ei = 0; ei < els.length; ++ei) {
                            el = els.get(ei);
                            txt = el.getAttribute('data-alt-text');

                            if (!txt.length) {
                                continue;
                            }

                            el.setAttribute('data-alt-text', els.eq(ei).text());
                            el.innerHTML = txt;
                        }
                    }

                    zl = gr = '--';
                } else {
                    if (result.attr('data-result-version') !== 'normal') {
                        result.attr('data-result-version', 'normal');

                        if (result.attr('data-alt-class')) {
                            result.removeClass(result.attr('data-alt-class'));
                        }

                        els = $('[data-alt-text]', result);

                        for (ei = 0; ei < els.length; ++ei) {
                            el = els.get(ei);
                            txt = el.getAttribute('data-alt-text');

                            if (!txt.length) {
                                continue;
                            }

                            el.setAttribute('data-alt-text', els.eq(ei).html());
                            el.innerHTML = txt;
                        }
                    }
                }

                result.find('[data-price="zl"]').text(zl);
                result.find('[data-price="gr"]').text(gr);
            }

            results.addClass('content-calc__result--visible');

            $('html,body').animate({
                scrollTop: resultsWrapper.offset().top
            }, 600);
        };

        if (visible) {
            window.clearTimeout(resultsTimeout);
            resultsTimeout = window.setTimeout(resultsAppend, 1000);
        } else {
            resultsAppend();
        }
        if ($('.content-calc__results').hasClass('content-calc__results--has-results')) {
            var dataLayer = window.dataLayer || [];
            dataLayer.push({
                'event': 'calculate',
                'kraj': country,
                'waga': weight,
                'kod-pocztowy': postalCode
            });
            console.log(dataLayer);
        }
        // triggerAnalyticsEvent('Calculator', 'calculate', 'positve');

        // console.log(cost);
        // console.log('---------------');
    });

    $('[data-offer-btn]').on('click', function (evt) {
        switch (this.getAttribute('data-offer-btn')) {
            case 'walk':
                triggerAnalyticsEvent('Offer', 'click', 'Walk');
                break;

            case 'click':
                triggerAnalyticsEvent('Offer', 'click', 'Click');
                break;

            case 'call':
                if (this.getAttribute('data-tel').length) {
                    triggerAnalyticsEvent('Offer', 'click', 'Call');
                }
                break;

            case 'sign':
                triggerAnalyticsEvent('Form', 'open', 'Offer');
                break;
        }
    });

    $('[data-advantages-btn]').on('click', function (evt) {
        switch (this.getAttribute('data-advantages-btn')) {
            case 'walk':
                triggerAnalyticsEvent('Profits', 'click', 'Walk');
                break;

            case 'click':
                triggerAnalyticsEvent('Profits', 'click', 'Click');
                break;

            case 'call':
                if (this.getAttribute('data-tel').length) {
                    triggerAnalyticsEvent('Profits', 'click', 'Call');
                }
                break;
        }
    });

    $('[data-document-link]').on('click', function (evt) {
        triggerAnalyticsEvent('Documents', 'click', this.getAttribute('data-document-link'));
    });

    $('[data-toggle-form]').on('click', function (evt) {
        evt.preventDefault();

        $("html,body").animate({
            scrollTop: 0
        }, 600);
    });

    // telefon
    $('[data-tel]').on('mouseover', function (evt) {
        if (!this.getAttribute('data-tel').length) {
            return;
        }

        evt.preventDefault();

        $(this).text('tel:' + this.getAttribute('data-tel')).attr('data-tel', '').addClass('btn--phone-icon');
    });

    $('[data-tel]').on('mouseout', function (evt) {
        evt.preventDefault();
        $(this).attr('data-tel', $(this).text().substr(4)).text($(this).data('cta')).removeClass('btn--phone-icon');
    });

})(jQuery, DhlFrontConfig, window.shipmentCalc);
