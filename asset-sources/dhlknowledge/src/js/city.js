import $ from 'jquery';

$(document).ready(function () {

  $('body').on('click', '.js-click-city', function() {
    console.log("here");
    if($(this).hasClass('active')) {
      $(this).removeClass('active');
      $(this).find('span').text($(this).data('text-more'));
    } else {
      $(this).addClass('active');
      $(this).find('span').text($(this).data('text-less'));
    }
    $( ".city__bottom" ).slideToggle();
  });

});
