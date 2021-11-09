import $ from 'jquery';

$(document).ready(function () {
    let accordion_el = $('#accordion').find('.collapse.show');
    for (let i = 0; i <= accordion_el.length; i++) {
        $(accordion_el[i]).removeClass('show');
    }
});