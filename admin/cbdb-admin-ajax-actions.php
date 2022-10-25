<?php

/**
 * Admin API: Core Ajax handlers
 *
 * @since      1.0
 */
if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

/**
 * Get taxonomies list
 * @since 1.0.0
 */
add_action('wp_ajax_nopriv_get_tax_list', 'get_tax_list_handler');
add_action('wp_ajax_get_tax_list', 'get_tax_list_handler');

function get_tax_list_handler() {
    header('Content-Type: application/json');
    $response = array();
    $catHTML = $tagHTML = '';

    $cbdb_post_type = isset($_POST['post_type']) ? sanitize_text_field($_POST['post_type']) : '';

    if (!empty($cbdb_post_type)) {
        // Get a list of available taxonomies for a post type
        $taxonomies = get_taxonomies(['object_type' => [$cbdb_post_type]]);

        // Set category and tag index
        $catIndex = 1;
        $tagIndex = 2;
        if ($cbdb_post_type == 'product') {
            $catIndex = 2;
            $tagIndex = 3;
        }

        $outerCnt = 1;
        // Loop over your taxonomies
        foreach ($taxonomies as $taxonomy) {
            // Retrieve all available terms, including those not yet used
            $terms = get_terms(['taxonomy' => $taxonomy, 'hide_empty' => false]);

            $innerCnt = 1;
            foreach ($terms as $term) {
                // For category
                if ($outerCnt == $catIndex) {
                    $catHTML .= '<option value="' . $term->slug . '">' . esc_html($term->name, CBDB_TEXTDOMAIN) . '</option>';
                    $innerCnt++;
                }
                // For tag
                if ($outerCnt == $tagIndex) {
                    $tagHTML .= '<option value="' . $term->slug . '">' . esc_html($term->name, CBDB_TEXTDOMAIN) . '</option>';
                    $innerCnt++;
                }
            }
            $outerCnt++;
        }
    }

    $response['catHTML'] = $catHTML;
    $response['tagHTML'] = $tagHTML;

    echo wp_json_encode($response);
    wp_die();
}

/**
 * Get layouts list
 * @since 1.0.0
 */
add_action('wp_ajax_nopriv_get_layout_list', 'get_layout_list_handler');
add_action('wp_ajax_get_layout_list', 'get_layout_list_handler');

function get_layout_list_handler() {
    header('Content-Type: application/json');
    $response = array();
    $optionsHTML = '';

    $cbdb_layout_type = isset($_POST['layout_type']) ? sanitize_text_field($_POST['layout_type']) : '';

    if ($cbdb_layout_type) {
        $optionsHTML = CBDB_Utility::layout_preview_options($cbdb_layout_type, 'layout-1');
    }

    $response['optionsHTML'] = $optionsHTML;

    echo wp_json_encode($response);
    wp_die();
}
