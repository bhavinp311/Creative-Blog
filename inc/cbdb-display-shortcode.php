<?php
/**
 * Display shortcode
 * 
 * @since 1.0
 */
if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

/**
 * Function that runs when shortcode is called
 * 
 * @param type $atts
 * @param type $content
 * @return type string shortcode html
 * 
 * @since 1.0
 */
function creative_blog_handler($atts, $content = null) {
    // Define global DB object
    global $wpdb;

    // Define DB table name
    $cbdb_dbtable = $wpdb->prefix . 'creative_blog_shortcodes';

    // Default parameters
    extract(shortcode_atts(array(
        'id' => ''
                    ), $atts));

    // Get shortcode id
    $cbdb_id = $id;

    // Fire a database query
    $cbdb_rowdata = $wpdb->get_row($wpdb->prepare("SELECT * FROM {$cbdb_dbtable} WHERE cbdb_id = %d LIMIT %d", array($cbdb_id, 1)), 'ARRAY_A');
    // Check if data is empty
    if (!empty($cbdb_rowdata)) {
        // Get all settings
        $cbdb_settings = unserialize($cbdb_rowdata['cbdb_settings']);

        // Frontend common data file
        include(CBDB_DIR . 'inc/cbdb-front-common-data.php');

        // Enqueue relevant layout CSS file
        wp_enqueue_style("{$cbdb_layout_type}-layout-style");

        // Viewport columns for grid layout only
        if ($cbdb_layout_type == 'grid') {
            if (str_contains($_SERVER['HTTP_USER_AGENT'], 'iPhone')) {
                // Class for mobile
                for ($i = 1; $i <= 6; $i++) {
                    if ($cbdb_mobile_col == $i) {
                        $cbdb_grid_column = "cbdb-grid-col-{$i}";
                    }
                }
            } else if (str_contains($_SERVER['HTTP_USER_AGENT'], 'iPad')) {
                // Class for iPad/tablet
                for ($i = 1; $i <= 6; $i++) {
                    if ($cbdb_ipad_tab_col == $i) {
                        $cbdb_grid_column = "cbdb-grid-col-{$i}";
                    }
                }
            } else {
                // Class for desktop
                for ($i = 1; $i <= 6; $i++) {
                    if ($cbdb_desktop_col == $i) {
                        $cbdb_grid_column = "cbdb-grid-col-{$i}";
                    }
                }
            }
        }

        // Prepare arguments
        $args = array(
            'post_type' => $cbdb_post_type,
            'posts_per_page' => $cbdb_number_post,
            'post_status' => 'publish',
            'orderby' => $cbdb_settings['cbdb_order_by'],
            'order' => $cbdb_settings['cbdb_order']
        );

        // Exclude IN or NOT IN
        $cbdb_post_cats = 'IN';
        if (isset($cbdb_settings['cbdb_exclude_categories']) && !empty($cbdb_settings['cbdb_exclude_categories'])) {
            $cbdb_post_cats = 'NOT IN';
        }
        $cbdb_post_tags = 'IN';
        if (isset($cbdb_settings['cbdb_exclude_tags']) && !empty($cbdb_settings['cbdb_exclude_tags'])) {
            $cbdb_post_tags = 'NOT IN';
        }
        $cbdb_authors = 'author__in';
        if (isset($cbdb_settings['cbdb_exclude_authors']) && !empty($cbdb_settings['cbdb_exclude_authors'])) {
            $cbdb_authors = 'author__not_in';
        }

        // Get taxonomies name based on post type
        $cbdb_post_taxonomies = get_object_taxonomies($cbdb_post_type);
        // Query check all display category, tags and author
        if ((isset($cbdb_settings['cbdb_post_categories']) && !empty($cbdb_settings['cbdb_post_categories'])) || (isset($cbdb_settings['cbdb_post_tags']) && !empty($cbdb_settings['cbdb_post_tags']))) {
            $cbdb_cat_arr = $cbdb_tag_arr = array();
            $args['tax_query'] = array(
                'relation' => 'AND',
            );
            if ((isset($cbdb_settings['cbdb_post_categories']) && !empty($cbdb_settings['cbdb_post_categories']))) {
                $cbdb_cat_arr = array(
                    'taxonomy' => $cbdb_post_taxonomies[0],
                    'field' => 'slug',
                    'terms' => $cbdb_settings['cbdb_post_categories'],
                    'operator' => $cbdb_post_cats
                );
                array_push($args['tax_query'], $cbdb_cat_arr);
            }
            if ((isset($cbdb_settings['cbdb_post_tags']) && !empty($cbdb_settings['cbdb_post_tags']))) {
                $cbdb_tag_arr = array(
                    'taxonomy' => $cbdb_post_taxonomies[1],
                    'field' => 'slug',
                    'terms' => $cbdb_settings['cbdb_post_tags'],
                    'operator' => $cbdb_post_tags
                );
                array_push($args['tax_query'], $cbdb_tag_arr);
            }
        }
        if ((isset($cbdb_settings['cbdb_post_authors']) && !empty($cbdb_settings['cbdb_post_authors']))) {
            $args[$cbdb_authors] = $cbdb_settings['cbdb_post_authors'];
        }

        // Fire a database query
        $get_posts = new WP_Query($args);

        // Check if posts exists
        if ($get_posts->have_posts()) {
            // Shortcode id class
            $cbdb_id_class = 'cbdb-sc-' . $cbdb_id;

            // Section class
            $section_class = 'cbdb-main-section-' . $cbdb_id_class;

            // Layout class
            $layout_class = 'cbdb-' . $cbdb_layout_type . '-' . $cbdb_layout_preview;

            // Shortcode and layout combined class
            $cbdb_combine = '.' . $section_class . ' .' . $cbdb_id_class . '.' . $layout_class;

            // Layout and column classes
            $cbdb_custom_class = ' ' . $cbdb_id_class . ' cbdb-' . $cbdb_layout_type . '-' . $cbdb_layout_preview;

            // If layout is grid add grid column class
            if ($cbdb_layout_type == 'grid') {
                $cbdb_custom_class .= ' cbdb-grid-layout ' . $cbdb_grid_column;
            }
            if ($cbdb_layout_type == 'masonry') {
                $cbdb_custom_class .= ' cbdb-masonry-layout';
                // Default Masonry script registered by WordPress
                wp_enqueue_script('masonry');
            }
            wp_localize_script('frontend-script', 'front_ajax_object', array('ajaxurl' => admin_url('admin-ajax.php'), 'pluginurl' => CBDB_URL, 'masonryGutter' => $cbdb_grid_gap));
            wp_enqueue_script('frontend-script');

            // Include common CSS file
            include('cbdb-common-style.php');
            ?>
            <section class="<?php echo $section_class; ?>">
                <div class="cbdb-main-container <?php esc_attr_e($cbdb_main_container_class_name . $cbdb_custom_class); ?>">
                    <?php
                    // Loop through all posts
                    while ($get_posts->have_posts()) {
                        $get_posts->the_post();
                        $cbdb_post_id = get_the_ID();
                        $cbdb_content = get_the_content();

                        // Get selected layout type and check if the template file exists
                        $cbdb_template_file = CBDB_DIR . "templates/{$cbdb_layout_type}/{$cbdb_layout_type}-{$cbdb_layout_preview}.php";
                        if (file_exists($cbdb_template_file)) {
                            //  If the template file exists include it
                            include($cbdb_template_file);
                        } else {
                            // Else no template file found
                            echo '<p>' . esc_html__('Sorry, ' . $cbdb_layout_type . '-' . $cbdb_layout_preview . ' template file does not exist.', CBDB_TEXTDOMAIN) . '</p>';
                            exit();
                        }
                    }
                    // Reset post data
                    wp_reset_postdata();
                    ?>
                </div>
                <?php
                // If pagination is enabled
                if (file_exists($cbdb_template_file) && isset($cbdb_settings['cbdb_post_pagination']) && $cbdb_settings['cbdb_post_pagination']) {
                    ?>
                    <div class="cbdb-pagination-wrapper" id="cbdb-pagination-wrapper-<?php echo $cbdb_id; ?>">
                        <nav class="cbdb-pagination <?php echo $cbdb_settings['cbdb_pagination_preview']; ?>" id="cbdb_pagination" data-sc-id="<?php echo $cbdb_id; ?>">
                            <?php
                            $big = 999999999; // need an unlikely integer
                            $cbdb_paginate_links = array(
                                'base' => str_replace($big, '%#%', esc_url(get_pagenum_link($big))),
                                'format' => '?paged=%#%',
                                'current' => max(1, get_query_var('paged')),
                                'total' => $get_posts->max_num_pages,
                                'prev_text' => __('&laquo; Previous', CBDB_TEXTDOMAIN),
                                'next_text' => __('Next &raquo;', CBDB_TEXTDOMAIN)
                            );
                            if (isset($cbdb_settings['cbdb_pagination_prev_text']) && !empty($cbdb_settings['cbdb_pagination_prev_text'])) {
                                $cbdb_paginate_links['prev_text'] = __($cbdb_settings['cbdb_pagination_prev_text'], CBDB_TEXTDOMAIN);
                            }
                            if (isset($cbdb_settings['cbdb_pagination_next_text']) && !empty($cbdb_settings['cbdb_pagination_next_text'])) {
                                $cbdb_paginate_links['next_text'] = __($cbdb_settings['cbdb_pagination_next_text'], CBDB_TEXTDOMAIN);
                            }
                            echo paginate_links($cbdb_paginate_links);
                            ?>
                        </nav>
                    </div>
                    <?php
                }
                ?>
                <script>
                    jQuery(document).ready(function () {
                        // Custom CSS
                        jQuery('head').append('<style type="text/css"><?php echo $cbdb_custom_css; ?></style>');
                    });
                </script>
            </section>
            <?php
        } else {
            // Else no posts found
            echo '<p>' . esc_html__('Sorry, no posts found.', CBDB_TEXTDOMAIN) . '</p>';
        }
    } else {
        // Else no layout found
        echo '<p>' . esc_html__('Sorry, no layout found.', CBDB_TEXTDOMAIN) . '</p>';
    }
}

// Register shortcode
add_shortcode('creative_blog', 'creative_blog_handler');
