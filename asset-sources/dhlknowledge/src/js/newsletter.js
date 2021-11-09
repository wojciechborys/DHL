jQuery(document).ready(function ($) {

  $('#formNewsletter').submit(function (e) {

    e.preventDefault();
    var form = $('#formNewsletter');
    var $email = form.find('[name="email"]'),
      email = $.trim($email.val()),
      emailRegex = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/,
      isEmail = emailRegex.test(email.toLowerCase());

    var $termsConsent = form.find('[name="terms-consent"]'),
      termsConsent = $termsConsent.is(':checked');

    if (!isEmail) {
      $('.newsletter_thx').addClass('d-none');
      $('.newsletter_error').removeClass('d-none');
      $('.newsletter_error span').html(sd_config.newsletter_error_email);
      return;
    }
    if (!termsConsent) {
      $('.newsletter_thx').addClass('d-none');
      $('.newsletter_error').removeClass('d-none');
      $('.newsletter_error span').html(sd_config.newsletter_error_terms);
      return;
    }
    $.ajax({
      url: sd_config.ajax_url,
      data: {
        email: email,
        'terms-consent': termsConsent,
        action: 'access_submission_knowledge'
      },
      method: 'POST',
      beforeSend: function beforeSend() {
        //show loading indicator
      },
      success: function (data) {
          //console.log(data);
          if(data.success) {
             $('.newsletter_error').addClass('d-none');
             $('.newsletter_thx').removeClass('d-none');
          } else {
            $('.newsletter_thx').addClass('d-none');
            $('.newsletter_error').removeClass('d-none');
            $('.newsletter_error span').html(sd_config.newsletter_error_default);
          }
      },
      async: true
    });
  });

});