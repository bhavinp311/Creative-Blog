jQuery(document).ready(function () {
    // Set up some blank variable
    var page, cbdb_id, masonryGutter;

    // Masonry layout gutter
    masonryGutter = front_ajax_object.masonryGutter ? Number(front_ajax_object.masonryGutter) : "";
    
    // If masonry layout
    initMasonry();
    

    // Pagination click event
    if (jQuery('.cbdb-pagination a').length) {
        jQuery('.cbdb-pagination-wrapper').on('click', '.cbdb-pagination a', function (e) {
            e.preventDefault();
            page = jQuery(this).html();
            if (jQuery(this).hasClass('prev')) {
                page = jQuery(this).parent().find('span.current').html();
                page = parseInt(page) - 1;
            } else if (jQuery(this).hasClass('next')) {
                page = jQuery(this).parent().find('span.current').html();
                page = parseInt(page) + 1;
            }
            cbdb_id = jQuery(this).parent().attr('data-sc-id');
            cbdb_get_posts(cbdb_id);
        });
    }

    // Masonry function
    function initMasonry() {
        if (jQuery('.cbdb-masonry-layout').length) {
            // Init Masonry
            var $masonry = jQuery('.cbdb-masonry-layout').masonry({
                // Options
                itemSelector: '.cbdb-masonry-item',
                columnWidth: 200,
                gutter: masonryGutter
            });
            // Masonry layout after each image loads
            $masonry.imagesLoaded().progress(function () {
                $masonry.masonry('layout');
            });
        }
    }

    // Pagination function
    function cbdb_get_posts(cbdb_id) {
        var resArr = [];
        if (cbdb_id) {
            jQuery.ajax({
                method: 'POST',
                url: front_ajax_object.ajaxurl,
                dataType: 'html',
                data: {
                    page_number: page,
                    cbdb_id: cbdb_id,
                    action: 'get_pagination_posts'
                },
                success: function (response) {
                    if (response != '') {
                        // Empty old previous page posts and add next page posts
                        resArr = response.split('<nav ');
                        jQuery('.cbdb-sc-' + cbdb_id).html('').html(resArr[0]);
                        // If masonry layout
                        if (jQuery('.cbdb-masonry-layout').length) {
                            jQuery('.cbdb-sc-' + cbdb_id).masonry('destroy');
                            initMasonry();
                        }
                        jQuery('#cbdb-pagination-wrapper-' + cbdb_id).html('').html('<nav ' + resArr[1]);

                        jQuery('html, body').animate({
                            scrollTop: jQuery('.cbdb-sc-' + cbdb_id).offset().top - 100
                        }, 500);
                    }
                },
                error: function (jqXHR, exception) {
                    console.log(jqXHR.status);
                    console.log(jqXHR.statusCode);
                    console.log(exception);
                }
            });
        }
    }
});