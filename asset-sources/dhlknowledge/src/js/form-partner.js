jQuery(document).ready(function ($) {


  function submit_form_partner(event) {

    event.preventDefault();

    var form = $("#partnerForm").serializeArray();
    var formdata = new FormData(document.getElementById("partnerForm"));
    var data = (formdata !== null) ? formdata : form.serialize();
    data.append("action", "partner_form");

    $('#partnerForm input').parent().removeClass('error');
    $('#partnerForm').addClass('waiting');
    $('#partnerForm .lds-ripple').addClass('active');
    $.ajax({
      url: contactUs.ajax_url,
      data: data,
      contentType: false,
      processData: false,
      method: 'POST',
    }).done(function (response) {
      $('#partnerForm').removeClass('waiting');
      $('#partnerForm .lds-ripple').removeClass('active');
      if (response.success === false) {
        $('.contact_error').addClass('d-none');
        Object.keys(response.data).forEach(function (key) {
          $(`#${key}`).parent().addClass('error');
        });
      } else {
        $('.contact_error').addClass('d-none');
        $('.contact__form--thanks').removeClass('d-none').addClass('d-flex');
        $('#partnerForm').addClass('d-none');
      }
    }).fail(function (error) {
      $('.contact_error').removeClass('d-none');
      $('#partnerForm').removeClass('waiting');
      $('#partnerForm .lds-ripple').removeClass('active');
      console.log(error);
    });
  }

  $('.form-partner-send').on('click', function (event) {
    submit_form_partner(event);
  });

});

