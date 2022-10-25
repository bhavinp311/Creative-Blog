jQuery(function ($) {
    // on upload button click
    $('body').on('click', '.cbdb-media-upload', function (event) {
        event.preventDefault(); // prevent default link click and page refresh

        const button = $(this);
        const imageId = button.next().next().val();

        const customUploader = wp.media({
            title: 'Insert Image', // modal window title
            library: {
                // uploadedTo : wp.media.view.settings.post.id, // attach to the current post?
                type: 'image'
            },
            button: {
                text: 'Use this image' // button label text
            },
            multiple: false
        }).on('select', function () { // it also has "open" and "close" events
            const attachment = customUploader.state().get('selection').first().toJSON();
            console.log(attachment);
            button.removeClass('button').html('<img src="' + attachment.url + '" width="400" height="300">'); // add image instead of "Upload Image"
            button.next().show(); // show "Remove image" link
            button.next().next().val(attachment.id); // Populate the hidden field with image ID
        });

        // already selected images
        customUploader.on('open', function () {

            if (imageId) {
                const selection = customUploader.state().get('selection')
                attachment = wp.media.attachment(imageId);
                attachment.fetch();
                selection.add(attachment ? [attachment] : []);
            }

        });

        customUploader.open();

    });
    // on remove button click
    $('body').on('click', '.cbdb-media-remove', function (event) {
        event.preventDefault();
        const button = $(this);
        button.next().val(''); // emptying the hidden field
        button.hide().prev().addClass('button').html('Upload Image'); // replace the image with text
    });
});