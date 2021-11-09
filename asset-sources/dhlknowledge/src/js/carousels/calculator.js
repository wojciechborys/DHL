import $ from 'jquery';

$(document).ready(function () {
  var item_length = $('.calculator__slider > div').length - 1;
  $('.calculator__slider').slick({
    dots: false,
    arrows: false,
    infinite: false,
    autoplay: false,
    slidesToShow: 1,
    slidesToScroll: 1,
    swipe: false,
    swipeToSlide: false,
    touchMove: false,
    draggable: false,
    // onAfterChange: function(slide, index){
    //   console.log(slide);
    //   console.log(index)
    //   if( item_length == index ){
    //     alert("Slide 2");
    //   };
    // }
  });

  $('body').on('click', '.calculator__slider__arrow__prev.active', function() {
    $(".calculator__slider").slick('slickPrev');
  });
  $('body').on('click', '.calculator__slider__arrow__next.active', function() {
    $(".calculator__slider").slick('slickNext');
  });
  $('.calculator__slider').on('afterChange', function(event, slick, currentSlide) {
    var weight = $('.slick-active .calculator__slider__item').data('weight');
    var length = $('.slick-active .calculator__slider__item').data('length');
    var height = $('.slick-active .calculator__slider__item').data('height');
    var width = $('.slick-active .calculator__slider__item').data('width');

    $('.content-calc__input--weight').val(weight);
    $('.content-calc__input--length').val(length);
    $('.content-calc__input--width').val(width);
    $('.content-calc__input--height').val(height);

    if (currentSlide == 0) {
      $('.calculator__slider__arrow__prev').removeClass('active');
    }
    else if(slick.$slides.length-1 == currentSlide) {
      $('.calculator__slider__arrow__next').removeClass('active');
    } else {
      $('.calculator__slider__arrow__prev').addClass('active');
      $('.calculator__slider__arrow__next').addClass('active');
    }
    $("#calculatorSend").trigger("click");
  })

});

