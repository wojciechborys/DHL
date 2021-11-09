import $ from 'jquery';
var Cookies = require('js-cookie');
window.$ = window.jQuery = $;
// import 'slick-carousel'


$('.slick-slider').slick({
    dots: false,
    infinite: false,
    arrows: true,
    slidesToShow: 3,
    slidesToScroll: 3,
    responsive: [
        {
            breakpoint: 1280,
            settings: {
                slidesToShow: 2,
                slidesToScroll: 2,
                infinite: true
            }
        },
        {
            breakpoint: 992,
            settings: {
                slidesToShow: 2,
                slidesToScroll: 2
            }
        },
        {
            breakpoint: 768,
            settings: {
                slidesToShow: 1,
                slidesToScroll: 1,
                dots: false
            }
        }
    ]
});


$('.slick-slider-fw').slick({
    centerMode: true,
    centerPadding: '30px',
    slidesToShow: 1,
    arrows: false,
    dots: true,
    responsive: [
        {
            breakpoint: 1600,
            centerPadding: '20px',
            settings: {
                slidesToShow: 1,
                slidesToScroll: 1,
                infinite: true
            }
        },
        {
            breakpoint: 1280,
            settings: {
                slidesToShow: 1,
                slidesToScroll: 1,
                infinite: true
            }
        },
        {
            breakpoint: 992,
            settings: {
                slidesToShow: 1,
                slidesToScroll: 1
            }
        },
        {
            breakpoint: 425,
            settings: {
                slidesToShow: 1,
                centerMode: false,
                slidesToScroll: 1,
                dots: false
            }
        }
    ]
});

jQuery(document).ready(function () {


    $('body').on('click', '.slider_image_text_container .carousel-item', function (event) {
        $('html,body').animate({scrollTop: $('#contact-us-form').offset().top - 80}, 'slow');
        event.preventDefault();
    });


    $('[data-toggle="tooltip"]').tooltip();

    $('body').on('click', '.to_form', function (event) {
        if (window.location.hash == "#contactForm") {
            $('html,body').animate({scrollTop: $('#contactF').offset().top - 120}, 'slow');
            event.preventDefault();
        }
    });

    if (window.location.hash) {
        if (window.location.hash == "#contactForm") {
            $('html,body').animate({scrollTop: $('#contactF').offset().top - 120}, 'slow');
            return false;
        }
    }


    $('body').on('click', '.hash_menu', function (event) {
        var th = $(this);
        var elem = th.attr('href');
        $('.hash_menu').removeClass('active')
        th.addClass('active');
        $('html,body').animate({scrollTop: $(elem).offset().top - 150}, 'slow');
        event.preventDefault();
    });

  $('body').on('click', '.click-hash', function (event) {
    var th = $(this);
    var elem = th.attr('href');
    $('html,body').animate({scrollTop: $(elem).offset().top - 150}, 'slow');
    event.preventDefault();
  });

    $('.js-hamburger').on('click', function (e) {
        $(this).toggleClass('open');
        $(this).parent().parent().parent().toggleClass('mobile-open');
        $(this).parent().parent().parent().parent().toggleClass('mobile-open');
    });

    $('.js-toggle-lang').on('click', function (e) {
        $(this).toggleClass('active');
        $('.js-banner__language-switch').toggleClass('active');
    });

    checkPosition();

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

    function checkPosition() {
        $('.nav-toggle').click(function () {
            if (window.matchMedia('(max-width: 576px)').matches) {
                $('.nav-items').removeClass('active');
                $(this).parent().find('.nav-items').toggleClass('active');
                return false;
            }
        });
    }

    $('body').on('click', 'a.show_section', function (event) {

        var th = $(this).attr('data-id');

        if ($(this).hasClass('active')) {
            $(this).removeClass('active').html($(this).attr('data-text-open'));
        } else {
            $(this).addClass('active').html($(this).attr('data-text-close'));
        }
        $('#' + th).slideToggle("slow");

        event.preventDefault();
    });

  $(window).scroll(function() {
    var scroll = $(window).scrollTop();
    if($('.banner__header').hasClass('js-header')) {
      if (scroll > 0) {
        $(".banner__header").removeClass("header_top_enable");
      } else {
        $(".banner__header").addClass("header_top_enable");
      }
    }
  });
//   console.log("test2");
  if ( ($('#footerPopup').length > 0) ) {
    let name_cookie = $('#footerPopup').data('cookie');
    // console.log("test1");
    if( Cookies.get(name_cookie) != '1' ) {
        // console.log("test");
      $("#footerPopup").fadeIn(300, function () {
        $(this).focus();
      });
    }
    $(".footer__popup__close").on('click', function () {
      Cookies.set(name_cookie, '1');
      $('#footerPopup').fadeOut(300);
    });
    $(".js-popup-link").on('click', function () {
      Cookies.set(name_cookie, '1');
      let link = $(this).attr("href");
      window.parent.location = link;
    });
  }

});
