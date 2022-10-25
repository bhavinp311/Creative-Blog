<?php

/**
 * Save/Get data
 *
 * @since 1.0
 */
if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

// Save button click
if (isset($_POST['cbdb_savedata'])) {
    $noti_message = '';
    if (isset($_POST['cbdb_layout_type_title'])) {
        $cbdb_layout_type_title = sanitize_text_field($_POST['cbdb_layout_type_title']);
        $_POST['cbdb_layout_type'] = $cbdb_layout_type_title;
    }
    if (isset($_POST['cbdb_layout_preview_title'])) {
        $cbdb_layout_preview_title = sanitize_text_field($_POST['cbdb_layout_preview_title']);
        $_POST['cbdb_layout_preview'] = $cbdb_layout_preview_title;
    }
    $cbdb_settings = $_POST;
    if (isset($cbdb_settings) && !empty($cbdb_settings)) {
        foreach ($cbdb_settings as $single_key => $single_val) {
            // Sanitization of fields
            if (is_array($single_val)) {
                foreach ($single_val as $s_key => $s_val) {
                    $cbdb_settings[$single_key][$s_key] = sanitize_text_field($s_val);
                }
            } else {
                if ('cbdb_custom_css' === $single_key) {
                    $cbdb_settings[$single_key] = wp_strip_all_tags($single_val);
                } else {
                    $cbdb_settings[$single_key] = sanitize_text_field($single_val);
                }
            }
        }

        // Don't save tab index
        unset($cbdb_settings['cbdb_tab_index']);
        $cbdb_settings = serialize($cbdb_settings);

        // Set default layout name
        $cbdb_layout_name = (isset($_POST['cbdb_layout_name']) && !empty($_POST['cbdb_layout_name'])) ? __($_POST['cbdb_layout_name'], CBDB_TEXTDOMAIN) : __('(no title)', CBDB_TEXTDOMAIN);
        // Prepare data
        $data = array(
            'cbdb_sc_name' => sanitize_text_field($cbdb_layout_name),
            'cbdb_settings' => $cbdb_settings,
            'cbdb_registered' => current_time('Y-m-d H:i:s')
        );
        // Data format
        $format = array('%s', '%s', '%s');
        // Check add or edit action
        if (isset($_REQUEST['action']) && $_REQUEST['action'] == 'edit' && isset($cbdb_id)) {
            $where = array('cbdb_id' => $cbdb_id);
            $where_format = array('%d');
            $wpdb->update($cbdb_dbtable, $data, $where, $format);
            $noti_message = 'updated';
        } else {
            $wpdb->insert($cbdb_dbtable, $data, $format);
            $last_inserted_id = $wpdb->insert_id;
            $cbdb_id = $last_inserted_id;
            $noti_message = 'added';
        }
        // Redirect to relevant page
        $cbdb_tab_index = (isset($_POST['cbdb_tab_index'])) ? $_POST['cbdb_tab_index'] : '';
        $redirect_url = admin_url('admin.php?page=cbdb_add_shortcode&action=edit&cbdb_id=' . $cbdb_id . '&layout=' . $noti_message . '&tab=' . $cbdb_tab_index);
        echo '<script>window.location.href="' . $redirect_url . '"</script>';
    }
}

// Set up some blank variables
// Layout Settings variables
$cbdb_layout_name = '';
$cbdb_layout_type = 'grid';
$cbdb_layout_preview = 'layout-1';
$cbdb_number_post = 6;
$cbdb_desktop_col = 3;
$cbdb_ipad_tab_col = 2;
$cbdb_mobile_col = 1;
$cbdb_grid_gap_layout_unit = 'px';
$cbdb_grid_gap = 30;
$cbdb_row_gap_layout_unit = 'px';
$cbdb_row_gap = 30;

// Post Settings variables
$cbdb_post_type = 'post';
$cbdb_post_categories = array();
$cbdb_exclude_categories = '';
$cbdb_post_tags = array();
$cbdb_exclude_tags = '';
$cbdb_post_authors = array();
$cbdb_exclude_authors = '';
$cbdb_order_by = 'date';
$cbdb_order = 'DESC';

// General Settings variables
$cbdb_post_title = 1;
$cbdb_heading_tag = 'h2';
$cbdb_post_title_font_family = '';
$cbdb_post_title_font_size = '';
$cbdb_post_title_font_weight = '';
$cbdb_post_title_line_height = '';
$cbdb_post_title_font_style = '';
$cbdb_post_title_text_transform = '';
$cbdb_post_title_text_decoration = '';
$cbdb_post_title_letter_spacing = '';
$cbdb_post_title_link = 'yes';
$cbdb_post_title_open_link = '_self';
$cbdb_post_title_margin_unit = 'px';
$cbdb_post_title_margin_arr = array('top' => '', 'right' => '', 'bottom' => '', 'left' => '');
$cbdb_post_title_padding_unit = 'px';
$cbdb_post_title_padding_arr = array('top' => '', 'right' => '', 'bottom' => '', 'left' => '');

$cbdb_post_content = 1;
$cbdb_post_content_font_family = '';
$cbdb_post_content_font_size = '';
$cbdb_post_content_font_weight = '';
$cbdb_post_content_line_height = '';
$cbdb_post_content_font_style = '';
$cbdb_post_content_text_transform = '';
$cbdb_post_content_text_decoration = '';
$cbdb_post_content_letter_spacing = '';
$cbdb_post_content_length = 25;
$cbdb_post_content_margin_unit = 'px';
$cbdb_post_content_margin_arr = array('top' => '', 'right' => '', 'bottom' => '', 'left' => '');
$cbdb_post_content_padding_unit = 'px';
$cbdb_post_content_padding_arr = array('top' => '', 'right' => '', 'bottom' => '', 'left' => '');

$cbdb_post_date = 1;
$cbdb_post_date_format = 'F j, Y';
$cbdb_post_date_font_family = '';
$cbdb_post_date_font_size = '';
$cbdb_post_date_font_weight = '';
$cbdb_post_date_line_height = '';
$cbdb_post_date_font_style = '';
$cbdb_post_date_text_transform = '';
$cbdb_post_date_text_decoration = '';
$cbdb_post_date_letter_spacing = '';
$cbdb_post_date_link = 'yes';
$cbdb_post_date_margin_unit = 'px';
$cbdb_post_date_margin_arr = array('top' => '', 'right' => '', 'bottom' => '', 'left' => '');
$cbdb_post_date_padding_unit = 'px';
$cbdb_post_date_padding_arr = array('top' => '', 'right' => '', 'bottom' => '', 'left' => '');

$cbdb_post_cat = 1;
$cbdb_post_cat_font_family = '';
$cbdb_post_cat_font_size = '';
$cbdb_post_cat_font_weight = '';
$cbdb_post_cat_line_height = '';
$cbdb_post_cat_font_style = '';
$cbdb_post_cat_text_transform = '';
$cbdb_post_cat_text_decoration = '';
$cbdb_post_cat_letter_spacing = '';
$cbdb_post_cat_link = 'yes';
$cbdb_post_cat_margin_unit = 'px';
$cbdb_post_cat_margin_arr = array('top' => '', 'right' => '', 'bottom' => '', 'left' => '');
$cbdb_post_cat_padding_unit = 'px';
$cbdb_post_cat_padding_arr = array('top' => '', 'right' => '', 'bottom' => '', 'left' => '');

$cbdb_post_tag = 1;
$cbdb_post_tag_font_family = '';
$cbdb_post_tag_font_size = '';
$cbdb_post_tag_font_weight = '';
$cbdb_post_tag_line_height = '';
$cbdb_post_tag_font_style = '';
$cbdb_post_tag_text_transform = '';
$cbdb_post_tag_text_decoration = '';
$cbdb_post_tag_letter_spacing = '';
$cbdb_post_tag_link = 'yes';
$cbdb_post_tag_margin_unit = 'px';
$cbdb_post_tag_margin_arr = array('top' => '', 'right' => '', 'bottom' => '', 'left' => '');
$cbdb_post_tag_padding_unit = 'px';
$cbdb_post_tag_padding_arr = array('top' => '', 'right' => '', 'bottom' => '', 'left' => '');

$cbdb_post_meta = 1;
$cbdb_post_meta_font_family = '';
$cbdb_post_meta_font_size = '';
$cbdb_post_meta_font_weight = '';
$cbdb_post_meta_line_height = '';
$cbdb_post_meta_font_style = '';
$cbdb_post_meta_text_transform = '';
$cbdb_post_meta_text_decoration = '';
$cbdb_post_meta_letter_spacing = '';
$cbdb_post_meta_link = 'yes';
$cbdb_post_meta_margin_unit = 'px';
$cbdb_post_meta_margin_arr = array('top' => '', 'right' => '', 'bottom' => '', 'left' => '');
$cbdb_post_meta_padding_unit = 'px';
$cbdb_post_meta_padding_arr = array('top' => '', 'right' => '', 'bottom' => '', 'left' => '');

$cbdb_read_more = 1;
$cbdb_read_more_text = 'Read More &raquo;';
$cbdb_read_more_font_family = '';
$cbdb_read_more_font_size = '';
$cbdb_read_more_font_weight = '';
$cbdb_read_more_line_height = '';
$cbdb_read_more_font_style = '';
$cbdb_read_more_text_transform = '';
$cbdb_read_more_text_decoration = '';
$cbdb_read_more_letter_spacing = '';
$cbdb_read_more_btn = 'no';
$cbdb_read_more_open_link = '_self';
$cbdb_read_more_margin_unit = 'px';
$cbdb_read_more_margin_arr = array('top' => '', 'right' => '', 'bottom' => '', 'left' => '');
$cbdb_read_more_padding_unit = 'px';
$cbdb_read_more_padding_arr = array('top' => '', 'right' => '', 'bottom' => '', 'left' => '');

// Media Settings variables
$cbdb_post_image = 1;
$cbdb_post_image_link = 'yes';
$cbdb_post_media_size = 'full';
$cbdb_add_custom_size_width = 300;
$cbdb_add_custom_size_height = 200;
$cbdb_main_container_bg_image_id = '';

// Style Settings variables
$cbdb_main_container_colors_arr = array('name' => 'main_container', 'id' => 'main-container', 'val' => '', 'default' => '');
$cbdb_main_container_box_shadow_color_arr = array('name' => 'main_container_box_shadow', 'id' => 'main-container-box-shadow', 'val' => '', 'default' => '');
$cbdb_main_container_box_shadow_position_arr = array('h_offset' => '', 'v_offset' => '', 'blur' => '');
$cbdb_main_container_border_color_arr = array('name' => 'main_container_border', 'id' => 'main-container-border', 'val' => '', 'default' => '');
$cbdb_main_container_border_style = '';
$cbdb_main_container_border_radius = '';
$cbdb_main_container_border_unit = 'px';
$cbdb_main_container_border_arr = array('top' => '', 'right' => '', 'bottom' => '', 'left' => '');

$cbdb_post_title_color_arr = array('name' => 'post_title', 'id' => 'post-title', 'val' => '', 'default' => '');
$cbdb_post_title_link_hover_color_arr = array('name' => 'post_title_link_hover', 'id' => 'post-title-link-hover', 'val' => '', 'default' => '');

$cbdb_post_content_color_arr = array('name' => 'post_content', 'id' => 'post-content', 'val' => '', 'default' => '');

$cbdb_post_date_color_arr = array('name' => 'post_date', 'id' => 'post-date', 'val' => '', 'default' => '');
$cbdb_post_date_link_hover_color_arr = array('name' => 'post_date_link_hover', 'id' => 'post-date-link-hover', 'val' => '', 'default' => '');

$cbdb_post_cat_color_arr = array('name' => 'post_cat', 'id' => 'post-cat', 'val' => '', 'default' => '');
$cbdb_post_cat_link_hover_color_arr = array('name' => 'post_cat_link_hover', 'id' => 'post-cat-link-hover', 'val' => '', 'default' => '');

$cbdb_post_tag_color_arr = array('name' => 'post_tag', 'id' => 'post-tag', 'val' => '', 'default' => '');
$cbdb_post_tag_link_hover_color_arr = array('name' => 'post_tag_link_hover', 'id' => 'post-tag-link-hover', 'val' => '', 'default' => '');

$cbdb_post_meta_icon_color_arr = array('name' => 'post_meta_icon', 'id' => 'post-meta-icon', 'val' => '', 'default' => '');
$cbdb_post_meta_color_arr = array('name' => 'post_meta', 'id' => 'post-meta', 'val' => '', 'default' => '');
$cbdb_post_meta_link_hover_color_arr = array('name' => 'post_meta_link_hover', 'id' => 'post-meta-link-hover', 'val' => '', 'default' => '');

$cbdb_read_more_text_color_arr = array('name' => 'read_more_text', 'id' => 'read-more-text', 'val' => '', 'default' => '');
$cbdb_read_more_text_hover_color_arr = array('name' => 'read_more_text_hover', 'id' => 'read-more-text-hover', 'val' => '', 'default' => '');
$cbdb_read_more_bg_color_arr = array('name' => 'read_more_bg', 'id' => 'read-more-bg', 'val' => '', 'default' => '');
$cbdb_read_more_bg_hover_color_arr = array('name' => 'read_more_bg_hover', 'id' => 'read-more-bg-hover', 'val' => '', 'default' => '');
$cbdb_read_more_box_shadow_color_arr = array('name' => 'read_more_box_shadow', 'id' => 'read-more-box-shadow', 'val' => '', 'default' => '');
$cbdb_read_more_box_shadow_position_arr = array('h_offset' => '', 'v_offset' => '', 'blur' => '');
$cbdb_read_more_border_color_arr = array('name' => 'read_more_border', 'id' => 'read-more-border', 'val' => '', 'default' => '');
$cbdb_read_more_border_style = '';
$cbdb_read_more_border_radius = '';
$cbdb_read_more_btn_border_unit = 'px';
$cbdb_read_more_btn_border_arr = array('top' => '', 'right' => '', 'bottom' => '', 'left' => '');

// Social Share Settings variables
$cbdb_social_share_icon = 0;
$cbdb_social_share_style = 'round';

// Pagination Settings variables
$cbdb_pagination = 0;
$cbdb_pagination_preview = 'layout-1';
//$cbdb_posts_per_page = 6;
$cbdb_pagination_prev_text = 'Previous';
$cbdb_pagination_next_text = 'Next';

// Custom Settings variables
$cbdb_main_container_class_name = '';
$cbdb_custom_title_class_name = '';
$cbdb_custom_content_class_name = '';
$cbdb_custom_css = '';

// Get data if the action is edit
if (isset($_REQUEST['action']) && $_REQUEST['action'] == 'edit' && isset($cbdb_id)) {
    $cbdb_rowdata = $wpdb->get_row($wpdb->prepare("SELECT * FROM {$cbdb_dbtable} WHERE cbdb_id = %d LIMIT %d", array($cbdb_id, 1)), 'ARRAY_A');
    // Redirect to relevant page if not layout found
    if ($cbdb_rowdata == null) {
        echo '<script>window.location.href="' . admin_url('admin.php?page=cbdb_add_shortcode') . '"</script>';
    }
    // Get all settings
    $cbdb_settings = unserialize($cbdb_rowdata['cbdb_settings']);

    // Get Layout Settings variables
    $cbdb_layout_name = ($cbdb_settings['cbdb_layout_name'] != '(no title)') ? $cbdb_settings['cbdb_layout_name'] : '';
    $cbdb_layout_type = $cbdb_settings['cbdb_layout_type'];
    $cbdb_layout_preview = $cbdb_settings['cbdb_layout_preview'];
    $cbdb_number_post = isset($cbdb_settings['cbdb_number_post']) ? $cbdb_settings['cbdb_number_post'] : '';
    $cbdb_desktop_col = isset($cbdb_settings['cbdb_desktop_col']) ? $cbdb_settings['cbdb_desktop_col'] : '';
    $cbdb_ipad_tab_col = isset($cbdb_settings['cbdb_ipad_tab_col']) ? $cbdb_settings['cbdb_ipad_tab_col'] : '';
    $cbdb_mobile_col = isset($cbdb_settings['cbdb_mobile_col']) ? $cbdb_settings['cbdb_mobile_col'] : '';
    $cbdb_grid_gap_layout_unit = isset($cbdb_settings['cbdb_grid_gap_layout_unit']) ? $cbdb_settings['cbdb_grid_gap_layout_unit'] : 'px';
    $cbdb_grid_gap = isset($cbdb_settings['cbdb_grid_gap']) ? $cbdb_settings['cbdb_grid_gap'] : '';
    $cbdb_row_gap = isset($cbdb_settings['cbdb_row_gap']) ? $cbdb_settings['cbdb_row_gap'] : '';
    $cbdb_row_gap_layout_unit = isset($cbdb_settings['cbdb_row_gap_layout_unit']) ? $cbdb_settings['cbdb_row_gap_layout_unit'] : 'px';

    // Get Post Settings variables
    $cbdb_post_type = $cbdb_settings['cbdb_post_type'];
    $cbdb_post_categories = (isset($cbdb_settings['cbdb_post_categories']) && !empty($cbdb_settings['cbdb_post_categories'])) ? $cbdb_settings['cbdb_post_categories'] : array();
    $cbdb_exclude_categories = isset($cbdb_settings['cbdb_exclude_categories']) ? $cbdb_settings['cbdb_exclude_categories'] : '';
    $cbdb_post_tags = (isset($cbdb_settings['cbdb_post_tags']) && !empty($cbdb_settings['cbdb_post_tags'])) ? $cbdb_settings['cbdb_post_tags'] : array();
    $cbdb_exclude_tags = isset($cbdb_settings['cbdb_exclude_tags']) ? $cbdb_settings['cbdb_exclude_tags'] : '';
    $cbdb_post_authors = (isset($cbdb_settings['cbdb_post_authors']) && !empty($cbdb_settings['cbdb_post_authors'])) ? $cbdb_settings['cbdb_post_authors'] : array();
    $cbdb_exclude_authors = isset($cbdb_settings['cbdb_exclude_authors']) ? $cbdb_settings['cbdb_exclude_authors'] : '';
    $cbdb_order_by = $cbdb_settings['cbdb_order_by'];
    $cbdb_order = $cbdb_settings['cbdb_order'];

    // General Settings variables
    $cbdb_post_title = isset($cbdb_settings['cbdb_post_title']) ? $cbdb_settings['cbdb_post_title'] : 1;
    $cbdb_heading_tag = $cbdb_settings['cbdb_heading_tag'];
    $cbdb_post_title_font_family = $cbdb_settings['cbdb_post_title_font_family'];
    $cbdb_post_title_font_size = isset($cbdb_settings['cbdb_post_title_font_size']) ? $cbdb_settings['cbdb_post_title_font_size'] : 20;
    $cbdb_post_title_font_weight = $cbdb_settings['cbdb_post_title_font_weight'];
    $cbdb_post_title_line_height = isset($cbdb_settings['cbdb_post_title_line_height']) ? $cbdb_settings['cbdb_post_title_line_height'] : '';
    $cbdb_post_title_font_style = $cbdb_settings['cbdb_post_title_font_style'];
    $cbdb_post_title_text_transform = $cbdb_settings['cbdb_post_title_text_transform'];
    $cbdb_post_title_text_decoration = $cbdb_settings['cbdb_post_title_text_decoration'];
    $cbdb_post_title_letter_spacing = isset($cbdb_settings['cbdb_post_title_letter_spacing']) ? $cbdb_settings['cbdb_post_title_letter_spacing'] : '';
    $cbdb_post_title_link = isset($cbdb_settings['cbdb_post_title_link']) ? $cbdb_settings['cbdb_post_title_link'] : 'yes';
    $cbdb_post_title_open_link = isset($cbdb_settings['cbdb_post_title_open_link']) ? $cbdb_settings['cbdb_post_title_open_link'] : '_self';
    $cbdb_post_title_margin_unit = isset($cbdb_settings['cbdb_post_title_margin_unit']) ? $cbdb_settings['cbdb_post_title_margin_unit'] : 'px';
    $cbdb_post_title_margin_arr = array(
        'top' => isset($cbdb_settings['cbdb_post_title_margin_top']) ? $cbdb_settings['cbdb_post_title_margin_top'] : '',
        'right' => isset($cbdb_settings['cbdb_post_title_margin_right']) ? $cbdb_settings['cbdb_post_title_margin_right'] : '',
        'bottom' => isset($cbdb_settings['cbdb_post_title_margin_bottom']) ? $cbdb_settings['cbdb_post_title_margin_bottom'] : '',
        'left' => isset($cbdb_settings['cbdb_post_title_margin_left']) ? $cbdb_settings['cbdb_post_title_margin_left'] : '',
    );
    $cbdb_post_title_padding_unit = isset($cbdb_settings['cbdb_post_title_padding_unit']) ? $cbdb_settings['cbdb_post_title_padding_unit'] : 'px';
    $cbdb_post_title_padding_arr = array(
        'top' => isset($cbdb_settings['cbdb_post_title_padding_top']) ? $cbdb_settings['cbdb_post_title_padding_top'] : '',
        'right' => isset($cbdb_settings['cbdb_post_title_padding_right']) ? $cbdb_settings['cbdb_post_title_padding_right'] : '',
        'bottom' => isset($cbdb_settings['cbdb_post_title_padding_bottom']) ? $cbdb_settings['cbdb_post_title_padding_bottom'] : '',
        'left' => isset($cbdb_settings['cbdb_post_title_padding_left']) ? $cbdb_settings['cbdb_post_title_padding_left'] : '',
    );

    $cbdb_post_content = isset($cbdb_settings['cbdb_post_content']) ? $cbdb_settings['cbdb_post_content'] : 1;
    $cbdb_post_content_font_family = $cbdb_settings['cbdb_post_content_font_family'];
    $cbdb_post_content_font_size = isset($cbdb_settings['cbdb_post_content_font_size']) ? $cbdb_settings['cbdb_post_content_font_size'] : 16;
    $cbdb_post_content_font_weight = $cbdb_settings['cbdb_post_content_font_weight'];
    $cbdb_post_content_line_height = isset($cbdb_settings['cbdb_post_content_line_height']) ? $cbdb_settings['cbdb_post_content_line_height'] : '';
    $cbdb_post_content_font_style = $cbdb_settings['cbdb_post_content_font_style'];
    $cbdb_post_content_text_transform = $cbdb_settings['cbdb_post_content_text_transform'];
    $cbdb_post_content_text_decoration = $cbdb_settings['cbdb_post_content_text_decoration'];
    $cbdb_post_content_letter_spacing = isset($cbdb_settings['cbdb_post_content_letter_spacing']) ? $cbdb_settings['cbdb_post_content_letter_spacing'] : '';
    $cbdb_post_content_length = isset($cbdb_settings['cbdb_post_content_length']) ? $cbdb_settings['cbdb_post_content_length'] : '';
    $cbdb_post_content_margin_unit = isset($cbdb_settings['cbdb_post_content_margin_unit']) ? $cbdb_settings['cbdb_post_content_margin_unit'] : 'px';
    $cbdb_post_content_margin_arr = array(
        'top' => isset($cbdb_settings['cbdb_post_content_margin_top']) ? $cbdb_settings['cbdb_post_content_margin_top'] : '',
        'right' => isset($cbdb_settings['cbdb_post_content_margin_right']) ? $cbdb_settings['cbdb_post_content_margin_right'] : '',
        'bottom' => isset($cbdb_settings['cbdb_post_content_margin_bottom']) ? $cbdb_settings['cbdb_post_content_margin_bottom'] : '',
        'left' => isset($cbdb_settings['cbdb_post_content_margin_left']) ? $cbdb_settings['cbdb_post_content_margin_left'] : '',
    );
    $cbdb_post_content_padding_unit = isset($cbdb_settings['cbdb_post_content_padding_unit']) ? $cbdb_settings['cbdb_post_content_padding_unit'] : 'px';
    $cbdb_post_content_padding_arr = array(
        'top' => isset($cbdb_settings['cbdb_post_content_padding_top']) ? $cbdb_settings['cbdb_post_content_padding_top'] : '',
        'right' => isset($cbdb_settings['cbdb_post_content_padding_right']) ? $cbdb_settings['cbdb_post_content_padding_right'] : '',
        'bottom' => isset($cbdb_settings['cbdb_post_content_padding_bottom']) ? $cbdb_settings['cbdb_post_content_padding_bottom'] : '',
        'left' => isset($cbdb_settings['cbdb_post_content_padding_left']) ? $cbdb_settings['cbdb_post_content_padding_left'] : '',
    );

    $cbdb_post_date = isset($cbdb_settings['cbdb_post_date']) ? $cbdb_settings['cbdb_post_date'] : 1;
    $cbdb_post_date_format = $cbdb_settings['cbdb_post_date_format'];
    $cbdb_post_date_font_family = $cbdb_settings['cbdb_post_date_font_family'];
    $cbdb_post_date_font_size = isset($cbdb_settings['cbdb_post_date_font_size']) ? $cbdb_settings['cbdb_post_date_font_size'] : 14;
    $cbdb_post_date_font_weight = $cbdb_settings['cbdb_post_date_font_weight'];
    $cbdb_post_date_line_height = isset($cbdb_settings['cbdb_post_date_line_height']) ? $cbdb_settings['cbdb_post_date_line_height'] : '';
    $cbdb_post_date_font_style = $cbdb_settings['cbdb_post_date_font_style'];
    $cbdb_post_date_text_transform = $cbdb_settings['cbdb_post_date_text_transform'];
    $cbdb_post_date_text_decoration = $cbdb_settings['cbdb_post_date_text_decoration'];
    $cbdb_post_date_letter_spacing = isset($cbdb_settings['cbdb_post_date_letter_spacing']) ? $cbdb_settings['cbdb_post_date_letter_spacing'] : '';
    $cbdb_post_date_link = isset($cbdb_settings['cbdb_post_date_link']) ? $cbdb_settings['cbdb_post_date_link'] : 'yes';
    $cbdb_post_date_margin_unit = isset($cbdb_settings['cbdb_post_date_margin_unit']) ? $cbdb_settings['cbdb_post_date_margin_unit'] : 'px';
    $cbdb_post_date_margin_arr = array(
        'top' => isset($cbdb_settings['cbdb_post_date_margin_top']) ? $cbdb_settings['cbdb_post_date_margin_top'] : '',
        'right' => isset($cbdb_settings['cbdb_post_date_margin_right']) ? $cbdb_settings['cbdb_post_date_margin_right'] : '',
        'bottom' => isset($cbdb_settings['cbdb_post_date_margin_bottom']) ? $cbdb_settings['cbdb_post_date_margin_bottom'] : '',
        'left' => isset($cbdb_settings['cbdb_post_date_margin_left']) ? $cbdb_settings['cbdb_post_date_margin_left'] : '',
    );
    $cbdb_post_date_padding_unit = isset($cbdb_settings['cbdb_post_date_padding_unit']) ? $cbdb_settings['cbdb_post_date_padding_unit'] : 'px';
    $cbdb_post_date_padding_arr = array(
        'top' => isset($cbdb_settings['cbdb_post_date_padding_top']) ? $cbdb_settings['cbdb_post_date_padding_top'] : '',
        'right' => isset($cbdb_settings['cbdb_post_date_padding_right']) ? $cbdb_settings['cbdb_post_date_padding_right'] : '',
        'bottom' => isset($cbdb_settings['cbdb_post_date_padding_bottom']) ? $cbdb_settings['cbdb_post_date_padding_bottom'] : '',
        'left' => isset($cbdb_settings['cbdb_post_date_padding_left']) ? $cbdb_settings['cbdb_post_date_padding_left'] : '',
    );

    $cbdb_post_cat = isset($cbdb_settings['cbdb_post_cat']) ? $cbdb_settings['cbdb_post_cat'] : 1;
    $cbdb_post_cat_font_family = $cbdb_settings['cbdb_post_cat_font_family'];
    $cbdb_post_cat_font_size = isset($cbdb_settings['cbdb_post_cat_font_size']) ? $cbdb_settings['cbdb_post_cat_font_size'] : 14;
    $cbdb_post_cat_font_weight = $cbdb_settings['cbdb_post_cat_font_weight'];
    $cbdb_post_cat_line_height = isset($cbdb_settings['cbdb_post_cat_line_height']) ? $cbdb_settings['cbdb_post_cat_line_height'] : '';
    $cbdb_post_cat_font_style = $cbdb_settings['cbdb_post_cat_font_style'];
    $cbdb_post_cat_text_transform = $cbdb_settings['cbdb_post_cat_text_transform'];
    $cbdb_post_cat_text_decoration = $cbdb_settings['cbdb_post_cat_text_decoration'];
    $cbdb_post_cat_letter_spacing = isset($cbdb_settings['cbdb_post_cat_letter_spacing']) ? $cbdb_settings['cbdb_post_cat_letter_spacing'] : '';
    $cbdb_post_cat_link = isset($cbdb_settings['cbdb_post_cat_link']) ? $cbdb_settings['cbdb_post_cat_link'] : 'yes';
    $cbdb_post_cat_margin_unit = isset($cbdb_settings['cbdb_post_cat_margin_unit']) ? $cbdb_settings['cbdb_post_cat_margin_unit'] : 'px';
    $cbdb_post_cat_margin_arr = array(
        'top' => isset($cbdb_settings['cbdb_post_cat_margin_top']) ? $cbdb_settings['cbdb_post_cat_margin_top'] : '',
        'right' => isset($cbdb_settings['cbdb_post_cat_margin_right']) ? $cbdb_settings['cbdb_post_cat_margin_right'] : '',
        'bottom' => isset($cbdb_settings['cbdb_post_cat_margin_bottom']) ? $cbdb_settings['cbdb_post_cat_margin_bottom'] : '',
        'left' => isset($cbdb_settings['cbdb_post_cat_margin_left']) ? $cbdb_settings['cbdb_post_cat_margin_left'] : '',
    );
    $cbdb_post_cat_padding_unit = isset($cbdb_settings['cbdb_post_cat_padding_unit']) ? $cbdb_settings['cbdb_post_cat_padding_unit'] : 'px';
    $cbdb_post_cat_padding_arr = array(
        'top' => isset($cbdb_settings['cbdb_post_cat_padding_top']) ? $cbdb_settings['cbdb_post_cat_padding_top'] : '',
        'right' => isset($cbdb_settings['cbdb_post_cat_padding_right']) ? $cbdb_settings['cbdb_post_cat_padding_right'] : '',
        'bottom' => isset($cbdb_settings['cbdb_post_cat_padding_bottom']) ? $cbdb_settings['cbdb_post_cat_padding_bottom'] : '',
        'left' => isset($cbdb_settings['cbdb_post_cat_padding_left']) ? $cbdb_settings['cbdb_post_cat_padding_left'] : '',
    );

    $cbdb_post_tag = isset($cbdb_settings['cbdb_post_tag']) ? $cbdb_settings['cbdb_post_tag'] : 1;
    $cbdb_post_tag_font_family = $cbdb_settings['cbdb_post_tag_font_family'];
    $cbdb_post_tag_font_size = isset($cbdb_settings['cbdb_post_tag_font_size']) ? $cbdb_settings['cbdb_post_tag_font_size'] : 14;
    $cbdb_post_tag_font_weight = $cbdb_settings['cbdb_post_tag_font_weight'];
    $cbdb_post_tag_line_height = isset($cbdb_settings['cbdb_post_tag_line_height']) ? $cbdb_settings['cbdb_post_tag_line_height'] : '';
    $cbdb_post_tag_font_style = $cbdb_settings['cbdb_post_tag_font_style'];
    $cbdb_post_tag_text_transform = $cbdb_settings['cbdb_post_tag_text_transform'];
    $cbdb_post_tag_text_decoration = $cbdb_settings['cbdb_post_tag_text_decoration'];
    $cbdb_post_tag_letter_spacing = isset($cbdb_settings['cbdb_post_tag_letter_spacing']) ? $cbdb_settings['cbdb_post_tag_letter_spacing'] : '';
    $cbdb_post_tag_link = isset($cbdb_settings['cbdb_post_tag_link']) ? $cbdb_settings['cbdb_post_tag_link'] : 'yes';
    $cbdb_post_tag_margin_unit = isset($cbdb_settings['cbdb_post_tag_margin_unit']) ? $cbdb_settings['cbdb_post_tag_margin_unit'] : 'px';
    $cbdb_post_tag_margin_arr = array(
        'top' => isset($cbdb_settings['cbdb_post_tag_margin_top']) ? $cbdb_settings['cbdb_post_tag_margin_top'] : '',
        'right' => isset($cbdb_settings['cbdb_post_tag_margin_right']) ? $cbdb_settings['cbdb_post_tag_margin_right'] : '',
        'bottom' => isset($cbdb_settings['cbdb_post_tag_margin_bottom']) ? $cbdb_settings['cbdb_post_tag_margin_bottom'] : '',
        'left' => isset($cbdb_settings['cbdb_post_tag_margin_left']) ? $cbdb_settings['cbdb_post_tag_margin_left'] : '',
    );
    $cbdb_post_tag_padding_unit = isset($cbdb_settings['cbdb_post_tag_padding_unit']) ? $cbdb_settings['cbdb_post_tag_padding_unit'] : 'px';
    $cbdb_post_tag_padding_arr = array(
        'top' => isset($cbdb_settings['cbdb_post_tag_padding_top']) ? $cbdb_settings['cbdb_post_tag_padding_top'] : '',
        'right' => isset($cbdb_settings['cbdb_post_tag_padding_right']) ? $cbdb_settings['cbdb_post_tag_padding_right'] : '',
        'bottom' => isset($cbdb_settings['cbdb_post_tag_padding_bottom']) ? $cbdb_settings['cbdb_post_tag_padding_bottom'] : '',
        'left' => isset($cbdb_settings['cbdb_post_tag_padding_left']) ? $cbdb_settings['cbdb_post_tag_padding_left'] : '',
    );

    $cbdb_post_meta = isset($cbdb_settings['cbdb_post_meta']) ? $cbdb_settings['cbdb_post_meta'] : 1;
    $cbdb_post_meta_font_family = $cbdb_settings['cbdb_post_meta_font_family'];
    $cbdb_post_meta_font_size = isset($cbdb_settings['cbdb_post_meta_font_size']) ? $cbdb_settings['cbdb_post_meta_font_size'] : 14;
    $cbdb_post_meta_font_weight = $cbdb_settings['cbdb_post_meta_font_weight'];
    $cbdb_post_meta_line_height = isset($cbdb_settings['cbdb_post_meta_line_height']) ? $cbdb_settings['cbdb_post_meta_line_height'] : '';
    $cbdb_post_meta_font_style = $cbdb_settings['cbdb_post_meta_font_style'];
    $cbdb_post_meta_text_transform = $cbdb_settings['cbdb_post_meta_text_transform'];
    $cbdb_post_meta_text_decoration = $cbdb_settings['cbdb_post_meta_text_decoration'];
    $cbdb_post_meta_letter_spacing = isset($cbdb_settings['cbdb_post_meta_letter_spacing']) ? $cbdb_settings['cbdb_post_meta_letter_spacing'] : '';
    $cbdb_post_meta_margin_unit = isset($cbdb_settings['cbdb_post_meta_margin_unit']) ? $cbdb_settings['cbdb_post_meta_margin_unit'] : 'px';
    $cbdb_post_meta_margin_arr = array(
        'top' => isset($cbdb_settings['cbdb_post_meta_margin_top']) ? $cbdb_settings['cbdb_post_meta_margin_top'] : '',
        'right' => isset($cbdb_settings['cbdb_post_meta_margin_right']) ? $cbdb_settings['cbdb_post_meta_margin_right'] : '',
        'bottom' => isset($cbdb_settings['cbdb_post_meta_margin_bottom']) ? $cbdb_settings['cbdb_post_meta_margin_bottom'] : '',
        'left' => isset($cbdb_settings['cbdb_post_meta_margin_left']) ? $cbdb_settings['cbdb_post_meta_margin_left'] : '',
    );
    $cbdb_post_meta_padding_unit = isset($cbdb_settings['cbdb_post_meta_padding_unit']) ? $cbdb_settings['cbdb_post_meta_padding_unit'] : 'px';
    $cbdb_post_meta_padding_arr = array(
        'top' => isset($cbdb_settings['cbdb_post_meta_padding_top']) ? $cbdb_settings['cbdb_post_meta_padding_top'] : '',
        'right' => isset($cbdb_settings['cbdb_post_meta_padding_right']) ? $cbdb_settings['cbdb_post_meta_padding_right'] : '',
        'bottom' => isset($cbdb_settings['cbdb_post_meta_padding_bottom']) ? $cbdb_settings['cbdb_post_meta_padding_bottom'] : '',
        'left' => isset($cbdb_settings['cbdb_post_meta_padding_left']) ? $cbdb_settings['cbdb_post_meta_padding_left'] : '',
    );

    $cbdb_read_more = isset($cbdb_settings['cbdb_read_more']) ? $cbdb_settings['cbdb_read_more'] : 1;
    $cbdb_read_more_text = isset($cbdb_settings['cbdb_read_more_text']) ? $cbdb_settings['cbdb_read_more_text'] : '';
    $cbdb_read_more_font_family = $cbdb_settings['cbdb_read_more_font_family'];
    $cbdb_read_more_font_size = isset($cbdb_settings['cbdb_read_more_font_size']) ? $cbdb_settings['cbdb_read_more_font_size'] : 16;
    $cbdb_read_more_font_weight = $cbdb_settings['cbdb_read_more_font_weight'];
    $cbdb_read_more_line_height = isset($cbdb_settings['cbdb_read_more_line_height']) ? $cbdb_settings['cbdb_read_more_line_height'] : '';
    $cbdb_read_more_font_style = $cbdb_settings['cbdb_read_more_font_style'];
    $cbdb_read_more_text_transform = $cbdb_settings['cbdb_read_more_text_transform'];
    $cbdb_read_more_text_decoration = $cbdb_settings['cbdb_read_more_text_decoration'];
    $cbdb_read_more_letter_spacing = isset($cbdb_settings['cbdb_read_more_letter_spacing']) ? $cbdb_settings['cbdb_read_more_letter_spacing'] : '';
    $cbdb_read_more_btn = isset($cbdb_settings['cbdb_read_more_btn']) ? $cbdb_settings['cbdb_read_more_btn'] : 'no';
    $cbdb_read_more_open_link = isset($cbdb_settings['cbdb_read_more_open_link']) ? $cbdb_settings['cbdb_read_more_open_link'] : '_self';
    $cbdb_read_more_margin_unit = isset($cbdb_settings['cbdb_read_more_margin_unit']) ? $cbdb_settings['cbdb_read_more_margin_unit'] : 'px';
    $cbdb_read_more_margin_arr = array(
        'top' => isset($cbdb_settings['cbdb_read_more_margin_top']) ? $cbdb_settings['cbdb_read_more_margin_top'] : '',
        'right' => isset($cbdb_settings['cbdb_read_more_margin_right']) ? $cbdb_settings['cbdb_read_more_margin_right'] : '',
        'bottom' => isset($cbdb_settings['cbdb_read_more_margin_bottom']) ? $cbdb_settings['cbdb_read_more_margin_bottom'] : '',
        'left' => isset($cbdb_settings['cbdb_read_more_margin_left']) ? $cbdb_settings['cbdb_read_more_margin_left'] : '',
    );
    $cbdb_read_more_padding_unit = isset($cbdb_settings['cbdb_read_more_padding_unit']) ? $cbdb_settings['cbdb_read_more_padding_unit'] : 'px';
    $cbdb_read_more_padding_arr = array(
        'top' => isset($cbdb_settings['cbdb_read_more_padding_top']) ? $cbdb_settings['cbdb_read_more_padding_top'] : '',
        'right' => isset($cbdb_settings['cbdb_read_more_padding_right']) ? $cbdb_settings['cbdb_read_more_padding_right'] : '',
        'bottom' => isset($cbdb_settings['cbdb_read_more_padding_bottom']) ? $cbdb_settings['cbdb_read_more_padding_bottom'] : '',
        'left' => isset($cbdb_settings['cbdb_read_more_padding_left']) ? $cbdb_settings['cbdb_read_more_padding_left'] : '',
    );

    // Media Settings variables
    $cbdb_post_image = isset($cbdb_settings['cbdb_post_image']) ? $cbdb_settings['cbdb_post_image'] : 1;
    $cbdb_post_image_link = isset($cbdb_settings['cbdb_post_image_link']) ? $cbdb_settings['cbdb_post_image_link'] : 'yes';
    $cbdb_post_media_size = $cbdb_settings['cbdb_post_media_size'];
    $cbdb_add_custom_size_width = isset($cbdb_settings['cbdb_add_custom_size_width']) ? $cbdb_settings['cbdb_add_custom_size_width'] : '';
    $cbdb_add_custom_size_height = isset($cbdb_settings['cbdb_add_custom_size_height']) ? $cbdb_settings['cbdb_add_custom_size_height'] : '';
    $cbdb_main_container_bg_image_id = isset($cbdb_settings['cbdb_main_container_bg_image_id']) ? $cbdb_settings['cbdb_main_container_bg_image_id'] : '';

    // Style Settings variables
    $cbdb_main_container_colors_arr['val'] = isset($cbdb_settings['cbdb_main_container_color']) ? $cbdb_settings['cbdb_main_container_color'] : '';
    $cbdb_main_container_colors_arr['default'] = '';
    $cbdb_main_container_box_shadow_color_arr['val'] = isset($cbdb_settings['cbdb_main_container_box_shadow_color']) ? $cbdb_settings['cbdb_main_container_box_shadow_color'] : '';
    $cbdb_main_container_box_shadow_color_arr['default'] = '';
    $cbdb_main_container_box_shadow_position_arr = array(
        'h_offset' => isset($cbdb_settings['cbdb_main_container_box_shadow_position_h_offset']) ? $cbdb_settings['cbdb_main_container_box_shadow_position_h_offset'] : '',
        'v_offset' => isset($cbdb_settings['cbdb_main_container_box_shadow_position_v_offset']) ? $cbdb_settings['cbdb_main_container_box_shadow_position_v_offset'] : '',
        'blur' => isset($cbdb_settings['cbdb_main_container_box_shadow_position_blur']) ? $cbdb_settings['cbdb_main_container_box_shadow_position_blur'] : '',
    );
    $cbdb_main_container_border_color_arr['val'] = isset($cbdb_settings['cbdb_main_container_border_color']) ? $cbdb_settings['cbdb_main_container_border_color'] : '';
    $cbdb_main_container_border_color_arr['default'] = '';
    $cbdb_main_container_border_style = $cbdb_settings['cbdb_main_container_border_style'];
    $cbdb_main_container_border_radius = isset($cbdb_settings['cbdb_main_container_border_radius']) ? $cbdb_settings['cbdb_main_container_border_radius'] : '';
    $cbdb_main_container_border_unit = isset($cbdb_settings['cbdb_main_container_btn_border_unit']) ? $cbdb_settings['cbdb_main_container_btn_border_unit'] : 'px';
    $cbdb_main_container_border_arr = array(
        'top' => isset($cbdb_settings['cbdb_main_container_border_top']) ? $cbdb_settings['cbdb_main_container_border_top'] : '',
        'right' => isset($cbdb_settings['cbdb_main_container_border_right']) ? $cbdb_settings['cbdb_main_container_border_right'] : '',
        'bottom' => isset($cbdb_settings['cbdb_main_container_border_bottom']) ? $cbdb_settings['cbdb_main_container_border_bottom'] : '',
        'left' => isset($cbdb_settings['cbdb_main_container_border_left']) ? $cbdb_settings['cbdb_main_container_border_left'] : '',
    );

    $cbdb_post_title_color_arr['val'] = isset($cbdb_settings['cbdb_post_title_color']) ? $cbdb_settings['cbdb_post_title_color'] : '';
    $cbdb_post_title_color_arr['default'] = '';
    $cbdb_post_title_link_hover_color_arr['val'] = isset($cbdb_settings['cbdb_post_title_link_hover_color']) ? $cbdb_settings['cbdb_post_title_link_hover_color'] : '';
    $cbdb_post_title_link_hover_color_arr['default'] = '';

    $cbdb_post_content_color_arr['val'] = isset($cbdb_settings['cbdb_post_content_color']) ? $cbdb_settings['cbdb_post_content_color'] : '';
    $cbdb_post_content_color_arr['default'] = '';

    $cbdb_post_date_color_arr['val'] = isset($cbdb_settings['cbdb_post_date_color']) ? $cbdb_settings['cbdb_post_date_color'] : '';
    $cbdb_post_date_color_arr['default'] = '';
    $cbdb_post_date_link_hover_color_arr['val'] = isset($cbdb_settings['cbdb_post_date_link_hover_color']) ? $cbdb_settings['cbdb_post_date_link_hover_color'] : '';
    $cbdb_post_date_link_hover_color_arr['default'] = '';

    $cbdb_post_cat_color_arr['val'] = isset($cbdb_settings['cbdb_post_cat_color']) ? $cbdb_settings['cbdb_post_cat_color'] : '';
    $cbdb_post_cat_color_arr['default'] = '';
    $cbdb_post_cat_link_hover_color_arr['val'] = isset($cbdb_settings['cbdb_post_cat_link_hover_color']) ? $cbdb_settings['cbdb_post_cat_link_hover_color'] : '';
    $cbdb_post_cat_link_hover_color_arr['default'] = '';

    $cbdb_post_tag_color_arr['val'] = isset($cbdb_settings['cbdb_post_tag_color']) ? $cbdb_settings['cbdb_post_tag_color'] : '';
    $cbdb_post_tag_color_arr['default'] = '';
    $cbdb_post_tag_link_hover_color_arr['val'] = isset($cbdb_settings['cbdb_post_tag_link_hover_color']) ? $cbdb_settings['cbdb_post_tag_link_hover_color'] : '';
    $cbdb_post_tag_link_hover_color_arr['default'] = '';

    $cbdb_post_meta_icon_color_arr['val'] = isset($cbdb_settings['cbdb_post_meta_icon_color']) ? $cbdb_settings['cbdb_post_meta_icon_color'] : '';
    $cbdb_post_meta_icon_color_arr['default'] = '';
    $cbdb_post_meta_color_arr['val'] = isset($cbdb_settings['cbdb_post_meta_color']) ? $cbdb_settings['cbdb_post_meta_color'] : '';
    $cbdb_post_meta_color_arr['default'] = '';
    $cbdb_post_meta_link_hover_color_arr['val'] = isset($cbdb_settings['cbdb_post_meta_link_hover_color']) ? $cbdb_settings['cbdb_post_meta_link_hover_color'] : '';
    $cbdb_post_meta_link_hover_color_arr['default'] = '';

    $cbdb_read_more_text_color_arr['val'] = isset($cbdb_settings['cbdb_read_more_text_color']) ? $cbdb_settings['cbdb_read_more_text_color'] : '';
    $cbdb_read_more_text_color_arr['default'] = '';
    $cbdb_read_more_text_hover_color_arr['val'] = isset($cbdb_settings['cbdb_read_more_text_hover_color']) ? $cbdb_settings['cbdb_read_more_text_hover_color'] : '';
    $cbdb_read_more_text_hover_color_arr['default'] = '';
    $cbdb_read_more_bg_color_arr['val'] = isset($cbdb_settings['cbdb_read_more_bg_color']) ? $cbdb_settings['cbdb_read_more_bg_color'] : '';
    $cbdb_read_more_bg_color_arr['default'] = '';
    $cbdb_read_more_bg_hover_color_arr['val'] = isset($cbdb_settings['cbdb_read_more_bg_hover_color']) ? $cbdb_settings['cbdb_read_more_bg_hover_color'] : '';
    $cbdb_read_more_bg_hover_color_arr['default'] = '';
    $cbdb_read_more_box_shadow_color_arr['val'] = isset($cbdb_settings['cbdb_read_more_box_shadow_color']) ? $cbdb_settings['cbdb_read_more_box_shadow_color'] : '';
    $cbdb_read_more_box_shadow_color_arr['default'] = '';
    $cbdb_read_more_box_shadow_position_arr = array(
        'h_offset' => isset($cbdb_settings['cbdb_read_more_box_shadow_position_h_offset']) ? $cbdb_settings['cbdb_read_more_box_shadow_position_h_offset'] : '',
        'v_offset' => isset($cbdb_settings['cbdb_read_more_box_shadow_position_v_offset']) ? $cbdb_settings['cbdb_read_more_box_shadow_position_v_offset'] : '',
        'blur' => isset($cbdb_settings['cbdb_read_more_box_shadow_position_blur']) ? $cbdb_settings['cbdb_read_more_box_shadow_position_blur'] : '',
    );
    $cbdb_read_more_border_color_arr['val'] = isset($cbdb_settings['cbdb_read_more_border_color']) ? $cbdb_settings['cbdb_read_more_border_color'] : '';
    $cbdb_read_more_border_color_arr['default'] = '';
    $cbdb_read_more_border_style = $cbdb_settings['cbdb_read_more_border_style'];
    $cbdb_read_more_border_radius = isset($cbdb_settings['cbdb_read_more_border_radius']) ? $cbdb_settings['cbdb_read_more_border_radius'] : '';
    $cbdb_read_more_btn_border_unit = isset($cbdb_settings['cbdb_read_more_btn_border_unit']) ? $cbdb_settings['cbdb_read_more_btn_border_unit'] : 'px';
    $cbdb_read_more_btn_border_arr = array(
        'top' => isset($cbdb_settings['cbdb_read_more_btn_border_top']) ? $cbdb_settings['cbdb_read_more_btn_border_top'] : '',
        'right' => isset($cbdb_settings['cbdb_read_more_btn_border_right']) ? $cbdb_settings['cbdb_read_more_btn_border_right'] : '',
        'bottom' => isset($cbdb_settings['cbdb_read_more_btn_border_bottom']) ? $cbdb_settings['cbdb_read_more_btn_border_bottom'] : '',
        'left' => isset($cbdb_settings['cbdb_read_more_btn_border_left']) ? $cbdb_settings['cbdb_read_more_btn_border_left'] : '',
    );

    // Social Share Settings variables
    $cbdb_social_share_icon = isset($cbdb_settings['cbdb_social_share_icon']) ? $cbdb_settings['cbdb_social_share_icon'] : 1;
    $cbdb_social_share_style = isset($cbdb_settings['cbdb_social_share_style']) ? $cbdb_settings['cbdb_social_share_style'] : 'round';

    // Pagination Settings variables
    $cbdb_pagination = isset($cbdb_settings['cbdb_post_pagination']) ? $cbdb_settings['cbdb_post_pagination'] : 1;
    $cbdb_pagination_preview = $cbdb_settings['cbdb_pagination_preview'];
    //$cbdb_posts_per_page = isset($cbdb_settings['cbdb_posts_per_page']) ? $cbdb_settings['cbdb_posts_per_page'] : '';
    $cbdb_pagination_prev_text = isset($cbdb_settings['cbdb_pagination_prev_text']) ? $cbdb_settings['cbdb_pagination_prev_text'] : '';
    $cbdb_pagination_next_text = isset($cbdb_settings['cbdb_pagination_next_text']) ? $cbdb_settings['cbdb_pagination_next_text'] : '';

    // Custom Settings variables
    $cbdb_main_container_class_name = isset($cbdb_settings['cbdb_main_container_class_name']) ? $cbdb_settings['cbdb_main_container_class_name'] : '';
    $cbdb_custom_title_class_name = isset($cbdb_settings['cbdb_custom_title_class_name']) ? $cbdb_settings['cbdb_custom_title_class_name'] : '';
    $cbdb_custom_content_class_name = isset($cbdb_settings['cbdb_custom_content_class_name']) ? $cbdb_settings['cbdb_custom_content_class_name'] : '';
    $cbdb_custom_css = isset($cbdb_settings['cbdb_custom_css']) ? $cbdb_settings['cbdb_custom_css'] : '';
}
?>