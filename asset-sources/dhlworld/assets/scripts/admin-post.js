jQuery(function($){
    var uploader;

    function uploaderInit(){
        return wp.media({
            title: 'Wstaw obraz',
            library : {
            //    uploadedTo: wp.media.view.settings.post.id,
                type: 'image'
            },
            button: {
                text: 'Uzyj obrazu' // button label text
            },
            multiple: false
		});
    }

    function createImage(src){
        return $('<img />').attr('src', src).attr('class', 'ap-image').attr('data-choose-image', '');
    }

	$('body').on('click', '[data-choose-image]', function(evt){
        var button = $(this),
            preview = button.closest('[data-image-box]').find('[data-image-preview]'),
            imageID = button.closest('[data-image-box]').find('[data-image-id]');

        evt.preventDefault();

        if (!uploader) {
            uploader = uploaderInit();

            uploader.on('select', function(){ // it also has "open" and "close" events
                var attachment = uploader.state().get('selection').first().toJSON();
                var image = createImage(attachment.url);

                preview.find('[data-choose-image]').remove();

                image.appendTo(preview);
                imageID.val(attachment.id);

                button.parent().find('[data-remove-image]').removeClass('hidden');
    		});
        }

		uploader.open();
	}).on('click', '[data-remove-image]', function(evt){
        var button = $(this);

        evt.preventDefault();

        button.addClass('hidden').closest('[data-image-box]').find('[data-image-preview]').children().remove();
        button.closest('[data-image-box]').find('[data-image-id]').val('');
    });

});
