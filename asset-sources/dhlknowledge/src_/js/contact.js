jQuery(document).ready(function ($) {
  var recipment_email = "";

  function submit_form_contact(recipment_email, event) {

    event.preventDefault();

    if ($('#file_contact').val()) {
      var file = $('#file_contact')[0];
      var fileSize = ($('#file_contact')[0].files[0].size) / 1024 / 1024;
      if (fileSize > 8) {
        $('.error--file').text("Waga załącznika przekracza dopuszczalne 8MB");
        return;
      } else {
        $('.error--file').text("");
      }
    }

    var form = $("#contact-new").serializeArray();
    var formdata = new FormData(document.getElementById("contact-new"));
    var data = (formdata !== null) ? formdata : form.serialize();
    data.append("action", "contact_form");

    $('#contact-new input').parent().removeClass('error');
    $('#contact-new').addClass('waiting');
    $('#contact-new .lds-ripple').addClass('active');
    $.ajax({
      url: contactUs.ajax_url,
      data: data,
      contentType: false,
      processData: false,
      method: 'POST',
    }).done(function (response) {
      $('#contact-new').removeClass('waiting');
      $('#contact-new .lds-ripple').removeClass('active');
      if (response.success === false) {
        $('.contact_error').addClass('d-none');
        Object.keys(response.data).forEach(function (key) {
          $(`#${key}`).parent().addClass('error');
        });
      } else {
        $('.contact_error').addClass('d-none');
        $('.contact__form--thanks').removeClass('d-none').addClass('d-flex');
        $('#contact-new').addClass('d-none');
        $('.contact__form--title').removeClass('d-block').addClass('d-none');
      }
    }).fail(function (error) {
      $('.contact_error').removeClass('d-none');
      $('#contact-new').removeClass('waiting');
      $('#contact-new .lds-ripple').removeClass('active');
      console.log(error);
    });
  }

  $('#contact-new').on('change', '#subject_recipient', function () {
    $('#recipment-email').attr('value', $(this).find('option:selected').attr('data-recipment'));
    if ($(this).find('option:selected').attr('data-display-additional-input') === '1') {
      $('.tracking-number-container').removeClass('d-none');
    }
    else {
      $('.tracking-number-container').addClass('d-none');
    }
  });
  $('.form-new-send').on('click', function (event) {
    submit_form_contact(recipment_email, event);
  });

});

