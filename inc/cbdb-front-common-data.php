<?php

/**
 * Frontend common data for layout shortcode
 *
 * @since      1.0
 */
if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

// Extract data
$cbdb_read_more = '';
$cbdb_layout_type = (isset($cbdb_settings['cbdb_layout_type']) && trim($cbdb_settings['cbdb_layout_type']) != '') ? $cbdb_settings['cbdb_layout_type'] : '';
$cbdb_layout_preview = (isset($cbdb_settings['cbdb_layout_preview']) && trim($cbdb_settings['cbdb_layout_preview']) != '') ? $cbdb_settings['cbdb_layout_preview'] : '';
$cbdb_number_post = (isset($cbdb_settings['cbdb_number_post']) && trim($cbdb_settings['cbdb_number_post']) != '') ? $cbdb_settings['cbdb_number_post'] : '-1';
$cbdb_desktop_col = (isset($cbdb_settings['cbdb_desktop_col']) && trim($cbdb_settings['cbdb_desktop_col']) != '') ? $cbdb_settings['cbdb_desktop_col'] : 3;
$cbdb_ipad_tab_col = (isset($cbdb_settings['cbdb_ipad_tab_col']) && trim($cbdb_settings['cbdb_ipad_tab_col']) != '') ? $cbdb_settings['cbdb_ipad_tab_col'] : 2;
$cbdb_mobile_col = (isset($cbdb_settings['cbdb_mobile_col']) && trim($cbdb_settings['cbdb_mobile_col']) != '') ? $cbdb_settings['cbdb_mobile_col'] : 1;
$cbdb_grid_gap = isset($cbdb_settings['cbdb_grid_gap']) ? $cbdb_settings['cbdb_grid_gap'] : '';
$cbdb_grid_gap_layout_unit = (isset($cbdb_settings['cbdb_grid_gap_layout_unit']) && trim($cbdb_settings['cbdb_grid_gap_layout_unit']) != '') ? $cbdb_settings['cbdb_grid_gap_layout_unit'] : 'px';
$cbdb_row_gap = isset($cbdb_settings['cbdb_row_gap']) ? $cbdb_settings['cbdb_row_gap'] : '';
$cbdb_row_gap_layout_unit = (isset($cbdb_settings['cbdb_row_gap_layout_unit']) && trim($cbdb_settings['cbdb_row_gap_layout_unit']) != '') ? $cbdb_settings['cbdb_row_gap_layout_unit'] : 'px';
$cbdb_post_type = (isset($cbdb_settings['cbdb_post_type']) && !empty($cbdb_settings['cbdb_post_type'])) ? $cbdb_settings['cbdb_post_type'] : '';
$cbdb_post_title_tag = (isset($cbdb_settings['cbdb_heading_tag']) && !empty($cbdb_settings['cbdb_heading_tag'])) ? $cbdb_settings['cbdb_heading_tag'] : 'h2';
$cbdb_post_title_link = (isset($cbdb_settings['cbdb_post_title_link']) && !empty($cbdb_settings['cbdb_post_title_link'])) ? $cbdb_settings['cbdb_post_title_link'] : 'yes';
$cbdb_post_title_open_link = (isset($cbdb_settings['cbdb_post_title_open_link']) && !empty($cbdb_settings['cbdb_post_title_open_link'])) ? $cbdb_settings['cbdb_post_title_open_link'] : '_self';
$cbdb_post_content_length = (isset($cbdb_settings['cbdb_post_content_length']) && !empty($cbdb_settings['cbdb_post_content_length'])) ? $cbdb_settings['cbdb_post_content_length'] : 25;
$cbdb_post_date_link = (isset($cbdb_settings['cbdb_post_date_link']) && !empty($cbdb_settings['cbdb_post_date_link'])) ? $cbdb_settings['cbdb_post_date_link'] : 'yes';
$cbdb_post_date_format = (isset($cbdb_settings['cbdb_post_date_format']) && !empty($cbdb_settings['cbdb_post_date_format'])) ? $cbdb_settings['cbdb_post_date_format'] : 'M j, Y';
$cbdb_post_cat_link = (isset($cbdb_settings['cbdb_post_cat_link']) && !empty($cbdb_settings['cbdb_post_cat_link'])) ? $cbdb_settings['cbdb_post_cat_link'] : 'yes';
$cbdb_post_tag_link = (isset($cbdb_settings['cbdb_post_tag_link']) && !empty($cbdb_settings['cbdb_post_tag_link'])) ? $cbdb_settings['cbdb_post_tag_link'] : 'yes';
$cbdb_read_more_text = (isset($cbdb_settings['cbdb_read_more_text']) && !empty($cbdb_settings['cbdb_read_more_text'])) ? $cbdb_settings['cbdb_read_more_text'] : 'Read More';
$cbdb_read_more_open_link = (isset($cbdb_settings['cbdb_read_more_open_link']) && !empty($cbdb_settings['cbdb_read_more_open_link'])) ? $cbdb_settings['cbdb_read_more_open_link'] : '_self';
$cbdb_post_media_size = isset($cbdb_settings['cbdb_post_media_size']) ? $cbdb_settings['cbdb_post_media_size'] : 'full';
$cbdb_add_custom_size_width = isset($cbdb_settings['cbdb_add_custom_size_width']) ? $cbdb_settings['cbdb_add_custom_size_width'] : 300;
$cbdb_add_custom_size_height = isset($cbdb_settings['cbdb_add_custom_size_height']) ? $cbdb_settings['cbdb_add_custom_size_height'] : 200;
$cbdb_main_container_bg_image_id = isset($cbdb_settings['cbdb_main_container_bg_image_id']) ? $cbdb_settings['cbdb_main_container_bg_image_id'] : '';
$cbdb_social_share_style = (isset($cbdb_settings['cbdb_social_share_style']) && !empty($cbdb_settings['cbdb_social_share_style'])) ? $cbdb_settings['cbdb_social_share_style'] : 'round';
$cbdb_main_container_class_name = (isset($cbdb_settings['cbdb_main_container_class_name']) && !empty($cbdb_settings['cbdb_main_container_class_name'])) ? $cbdb_settings['cbdb_main_container_class_name'] : '';
$cbdb_custom_title_class_name = (isset($cbdb_settings['cbdb_custom_title_class_name']) && !empty($cbdb_settings['cbdb_custom_title_class_name'])) ? $cbdb_settings['cbdb_custom_title_class_name'] : '';
$cbdb_custom_content_class_name = (isset($cbdb_settings['cbdb_custom_content_class_name']) && !empty($cbdb_settings['cbdb_custom_content_class_name'])) ? $cbdb_settings['cbdb_custom_content_class_name'] : '';
$cbdb_custom_css = (isset($cbdb_settings['cbdb_custom_css']) && !empty($cbdb_settings['cbdb_custom_css'])) ? trim(preg_replace('/[\t\n\r\s]+/', ' ', str_replace(array('\n', '\r'), '', $cbdb_settings['cbdb_custom_css']))) : '';
$cbdb_custom_css = str_replace(';', ' !important;', $cbdb_custom_css);