<?php

/**
 * Frontend API: Core Ajax handlers
 *
 * @since      1.0
 */
if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

/**
 * Get more posts via pagination
 * 
 * @since 1.0
 */
if ($_REQUEST['action'] && $_REQUEST['action'] == 'get_pagination_posts') {
    // Define global DB object
    global $wpdb;

    // Define DB table name
    $cbdb_dbtable = $wpdb->prefix . 'creative_blog_shortcodes';

    // Frontend common functions file
    include(CBDB_DIR . 'inc/cbdb-common-functions.php');

    $cbdb_paged = isset($_POST['page_number']) ? $_POST['page_number'] : '';
    $cbdb_id = isset($_POST['cbdb_id']) ? $_POST['cbdb_id'] : '';

    // Fire a database query
    $cbdb_rowdata = $wpdb->get_row($wpdb->prepare("SELECT * FROM {$cbdb_dbtable} WHERE cbdb_id = %d LIMIT %d", array($cbdb_id, 1)), 'ARRAY_A');

    // Check if data is empty
    if (!empty($cbdb_rowdata)) {
        // Get all settings
        $cbdb_settings = unserialize($cbdb_rowdata['cbdb_settings']);

        // Frontend common data file
        include(CBDB_DIR . 'inc/cbdb-front-common-data.php');

        // Prepare arguments
        $args = array(
            'post_type' => $cbdb_post_type,
            'posts_per_page' => $cbdb_number_post,
            'paged' => $cbdb_paged,
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

        // Start output buffer
        ob_start();
        // Check if posts exists
        if ($get_posts->have_posts()) {
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
                }
            }
            wp_reset_postdata();

            // If pagination is enabled
            if (isset($cbdb_settings['cbdb_post_pagination']) && $cbdb_settings['cbdb_post_pagination']) {
                $big = 999999999; // need an unlikely integer
                echo '<nav class="cbdb-pagination ' . $cbdb_settings['cbdb_pagination_preview'] . '" id="cbdb_pagination" data-sc-id="' . $cbdb_id . '">';
                $cbdb_paginate_links = array(
                    'base' => str_replace($big, '%#%', esc_url(get_pagenum_link($big))),
                    'format' => '?paged=%#%',
                    'current' => max(1, $cbdb_paged),
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
                echo '</nav>';
            }
        } else {
            // Else no posts found
            echo '<p>' . esc_html__('Sorry, no posts found.', CBDB_TEXTDOMAIN) . '</p>';
        }
    }
    // Reset post data
    wp_reset_postdata();

    // Clean output buffer
    $post_data = ob_get_clean();

    // Echo out post data
    echo $post_data;
    wp_die();
}
