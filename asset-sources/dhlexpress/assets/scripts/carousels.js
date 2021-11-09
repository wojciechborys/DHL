// import jQuery from 'jquery'
// window.jQuery = window.$ = jQuery;

(function ($) {

    $(document).ready(function () {
        $('.about-dhl__slider').owlCarousel({
            margin: 10,
            loop: false,
            dots: false,
            nav: true,
            navText: [
                "<img src='/wp-content/themes/dhl/asset-sources/dhlexpress/dist/images/arrow-left.png' alt=''>",
                "<img src='/wp-content/themes/dhl/asset-sources/dhlexpress/dist/images/arrow-right.png' alt=''>"
            ],
            navContainer: '.about-dhl .customNavigation',
            responsive: {
                0: {
                    items: 1
                },
                600: {
                    items: 2
                },
                1000: {
                    items: 3
                }
            }
        });
        $('.dhl-slider-1').owlCarousel({
            margin: 10,
            loop: false,
            dots: false,
            nav: false,
            responsive: {
                0: {
                    items: 1
                },
                600: {
                    items: 2
                },
                1000: {
                    items: 3
                }
            }
        });

        function owlInitialize() {
            if ($(window).width() < 991) {
                $('.like-others__mobile-carousel').addClass("owl-carousel-2");
                $('.owl-carousel-2').owlCarousel({
                    margin: 10,
                    loop: false,
                    dots: false,
                    nav: false,
                    responsive: {
                        0: {
                            items: 1,
                            dots: false,
                            nav: false,
                            margin: 10,
                        },
                        800: {
                            items: 2,
                            dots: false,
                            nav: false
                        }
                    }
                });
                var indexToRemove = 0;
                $('.owl-carousel-2').owlCarousel('remove', indexToRemove).owlCarousel('update');
            } else {
                $('.owl-carousel-2').owlCarousel('destroy');
                $('.like-others__mobile-carousel').removeClass("owl-carousel-2");
                var title = '<div class="col-12 col-lg-6 text-center text-lg-left prependedTitle">' +
                    '<div class="like-others__headers">' +
                    '<h2 class="like-others__title">Zobacz, że inni robiąto z powodzeniem' +
                    '</h2>' +
                    '<p class="like-others__desc">' +
                    'Jakie szanse daje międzynarodowy e-commerce?' +
                    'Jak zacząć? Poznaj historie sukcesu!' +
                    '</p>' +
                    '</div>' +
                    '</div>';
                if ($('.like-others__mobile-carousel .prependedTitle').length === 0 && $('.like-others__mobile-carousel .like-others__headers').length === 0) {
                    $('.like-others__mobile-carousel').prepend(title);
                }
                // if($('.like-others__mobile-carousel').find('.prependedTitle'))
            }
        }

        $(document).ready(function (e) {
            owlInitialize();
        });
        $(window).resize(function () {
            owlInitialize();
        });
        
    });
})(jQuery);
