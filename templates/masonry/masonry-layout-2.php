<?php
// Load masonry layout functions file
include(CBDB_DIR . 'templates/masonry/functions-masonry.php');
?>

<!-- Start Masonry Layout -->
<article class="cbdb-masonry-item">
    <!-- Start Top Part -->
    <?php
    // If post title is enabled
    if (isset($cbdb_settings['cbdb_post_title']) && $cbdb_settings['cbdb_post_title']) {
        echo cbdb_post_title_tag($cbdb_post_title_tag, $cbdb_post_title_link, $cbdb_post_title_open_link, $cbdb_custom_title_class_name);
    }

    // If a post image is enabled
    if (isset($cbdb_settings['cbdb_post_image']) && $cbdb_settings['cbdb_post_image']) {
        if ($cbdb_post_media_size == 'custom') {
            $cbdb_post_media_size = array($cbdb_add_custom_size_width, $cbdb_add_custom_size_height);
        }
        ?>
        <div class="cbdb-masonry-image">
            <?php
            // If post image link enabled
            if (isset($cbdb_settings['cbdb_post_image_link']) && $cbdb_settings['cbdb_post_image_link'] == 'yes') {
                ?>
                <a href="<?php echo esc_url(get_the_permalink()); ?>">
                    <?php
                }
                if (has_post_thumbnail()) {
                    // Display a post thumbnail
                    the_post_thumbnail($cbdb_post_media_size);
                } else {
                    // Display a post placeholder
                    echo cbdb_get_placeholder_post_image($cbdb_post_media_size);
                }
                // If post image link enabled
                if (isset($cbdb_settings['cbdb_post_image_link']) && $cbdb_settings['cbdb_post_image_link'] == 'yes') {
                    ?>
                </a>
            <?php } ?>
        </div>
        <?php
    }
    ?>
    <!-- End Top Part -->

    <!-- Start Bottom Part -->
    <div class="cbdb-masonry-wrapper">
        <div class="cbdb-metadatabox">
            <?php
            // If post meta is enabled and meta exists (Author)
            $cbdb_posted_by = cbdb_posted_by();
            if (isset($cbdb_settings['cbdb_post_meta']) && $cbdb_settings['cbdb_post_meta'] && !empty($cbdb_posted_by)) {
                echo $cbdb_posted_by;
            }
            // If post date is enabled
            if (isset($cbdb_settings['cbdb_post_date']) && $cbdb_settings['cbdb_post_date']) {
                echo cbdb_post_date($cbdb_post_date_link, $cbdb_post_date_format, '', true, '');
            }
            // If post meta is enabled (Comment)
            if (isset($cbdb_settings['cbdb_post_meta']) && $cbdb_settings['cbdb_post_meta']) {
                cbdb_comment_count();
            }

            $cbdb_posted_tags = cbdb_posted_tags($cbdb_post_id, $cbdb_post_tag_link, ',', true);
            if ((isset($cbdb_settings['cbdb_post_tag']) && $cbdb_settings['cbdb_post_tag'] && !empty($cbdb_posted_tags)) || (isset($cbdb_settings['cbdb_social_share_icon']) && $cbdb_settings['cbdb_social_share_icon'])) {
                // If post tag is enabled
                if (isset($cbdb_settings['cbdb_post_tag']) && $cbdb_settings['cbdb_post_tag'] && !empty($cbdb_posted_tags)) {
                    echo $cbdb_posted_tags;
                }
                // If post category is enabled
                if (isset($cbdb_settings['cbdb_post_cat']) && $cbdb_settings['cbdb_post_cat']) {
                    echo cbdb_posted_categories($cbdb_post_id, $cbdb_post_cat_link, ',', true);
                }
                ?>
            </div>
            <?php
            // If read more is enabled
            if (isset($cbdb_settings['cbdb_read_more']) && $cbdb_settings['cbdb_read_more']) {
                $cbdb_read_more = ' <a href="' . esc_url(get_permalink()) . '" target="' . esc_attr($cbdb_read_more_open_link) . '" class="cbdb-read-more">' . esc_html__($cbdb_read_more_text, CBDB_TEXTDOMAIN) . '</a>';
            }
            // If post content is enabled
            if (isset($cbdb_settings['cbdb_post_content']) && $cbdb_settings['cbdb_post_content']) {
                ?>
                <div class="cbdb-description <?php esc_attr_e($cbdb_custom_content_class_name); ?>">
                    <?php echo wp_trim_words($cbdb_content, $cbdb_post_content_length, $cbdb_read_more); ?>
                </div>
                <?php
            }

            // If social share is enabled
            if (isset($cbdb_settings['cbdb_social_share_icon']) && $cbdb_settings['cbdb_social_share_icon']) {
                echo cbdb_social_share($cbdb_social_share_style);
            }
            ?>
            <?php
        }
        ?>
    </div>
    <!-- End Bottom Part -->
</article>
<!-- End Masonry Layout -->