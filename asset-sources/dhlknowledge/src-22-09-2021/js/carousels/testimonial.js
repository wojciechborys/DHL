import $ from 'jquery';

$(document).ready(function () {
    $('.testimonial-slider').slick({
        arrows: false,
        infinite: true,
        autoplay: true,
        autoplaySpeed: 5000,
        slidesToShow: 1,
        slidesToScroll: 1,
        adaptiveHeight: false,
        dots: true,
        appendDots: $('.testimonial-slide__dots-container')
    });
    $('.testimonial-slider').on('afterChange', function (e, slick, currentSlide) {
        currentSlide += 1;
        $('.slick-dots').find('.slick-active').removeClass('slick-active');
        $('.slick-dots').find('li:nth-of-type(' + currentSlide + ')').addClass('slick-active');
    });
});