import $ from 'jquery';
window.$ = window.jQuery = $;
import 'slick-carousel'


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


  $('body').on('click', '.slider_image_text_container .carousel-item', function(event) {
    $('html,body').animate({scrollTop: $('#contact-us-form').offset().top - 80 },'slow');
    event.preventDefault();
  });



  $('[data-toggle="tooltip"]').tooltip();

  $('body').on('click', '.to_form', function(event) {
    if (window.location.hash == "#contactForm") {
      $('html,body').animate({scrollTop: $('#contactF').offset().top - 120 },'slow');
      event.preventDefault();
    }
  });

  if(window.location.hash) {
    if (window.location.hash == "#contactForm") {
      $('html,body').animate({scrollTop: $('#contactF').offset().top - 120 },'slow');
      return false;
    }
  }


  $('body').on('click', '.hash_menu', function(event) {
    var th = $(this);
    var elem = th.attr('href');
    $('.hash_menu').removeClass('active')
    th.addClass('active');
    $('html,body').animate({scrollTop: $(elem).offset().top - 150 },'slow');
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
  function checkPosition() {
    $('.nav-toggle').click(function(){
    	if (window.matchMedia('(max-width: 576px)').matches) {
        $('.nav-items').removeClass('active');
        $(this).parent().find('.nav-items').toggleClass('active');
  			return false;
  		}
	   });
  }

  $('body').on('click', 'a.show_section', function(event) {

    var th = $(this).attr('data-id');

    if ($(this).hasClass('active')) {
      $(this).removeClass('active').html($(this).attr('data-text-open'));
    } else {
      $(this).addClass('active').html($(this).attr('data-text-close'));
    }
    $('#'+th).slideToggle("slow");

    event.preventDefault();
  });

});

