(function ($) {

    $(document).ready(function () {

        function submit_form_contact() {
            var form = $("#contact-new").serializeArray();
            var formdata = new FormData(document.getElementById("contact-new"));
            var data = (formdata !== null) ? formdata : form.serialize();
            data.append("action", "contact_form");
            $.ajax({
                type: 'POST',
                url: window.global.ajax,
                contentType: false,
                processData: false,
                dataType: 'JSON',
                status: 200,
                data: data,
                beforeSend: function beforeSend() {
                    //show loading indicator
                    // $('.contact-form').addClass('waiting');
                    // $('#ripple-contact').addClass('active');
                },
                success: function success(response) {
                    if (response.data) {
                        console.log(response.data);
                        // $('#thankYou').removeClass('d-none');
                        // $('.contact-form').removeClass('waiting');
                        // $('#ripple-contact').removeClass('active');
                    }
                },
                async: true
            });
        }

        $('.form-new-send').on('click', function () {
            submit_form_contact();
        });
    });
})(jQuery);
