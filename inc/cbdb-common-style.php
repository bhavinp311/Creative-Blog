<?php
/**
 * Common layout CSS
 * 
 * @since 1.0
 */
if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

// Import Google fonts for post title, content, date, category, tag, and read more text
$cbdb_font_faces = array($cbdb_settings['cbdb_post_title_font_family'], $cbdb_settings['cbdb_post_content_font_family'], $cbdb_settings['cbdb_post_date_font_family'], $cbdb_settings['cbdb_post_cat_font_family'], $cbdb_settings['cbdb_post_tag_font_family'], $cbdb_settings['cbdb_post_meta_font_family'], $cbdb_settings['cbdb_read_more_font_family']);
foreach ($cbdb_font_faces as $font_face) {
    $cbdb_font_family = str_replace(' ', '+', $font_face);
    $cbdb_apiUrl = esc_url('https://fonts.googleapis.com/css2?family=' . $cbdb_font_family . '&display=swap');
    $cbdb_response = wp_remote_get($cbdb_apiUrl);
    // If we get response code 200 otherwise it throws an error in console
    if (!is_wp_error($cbdb_response) && is_array($cbdb_response['response']) && $cbdb_response['response']['code'] == 200) {
        // Import font link tag
        ?>
        <link href="<?php echo $cbdb_apiUrl; ?>" rel="stylesheet">
        <?php
    }
}

$cbdb_post_title_margin_unit = isset($cbdb_settings['cbdb_post_title_margin_unit']) ? $cbdb_settings['cbdb_post_title_margin_unit'] : 'px';
$cbdb_post_title_padding_unit = isset($cbdb_settings['cbdb_post_title_padding_unit']) ? $cbdb_settings['cbdb_post_title_padding_unit'] : 'px';
$cbdb_post_content_margin_unit = isset($cbdb_settings['cbdb_post_content_margin_unit']) ? $cbdb_settings['cbdb_post_content_margin_unit'] : 'px';
$cbdb_post_content_padding_unit = isset($cbdb_settings['cbdb_post_content_padding_unit']) ? $cbdb_settings['cbdb_post_content_padding_unit'] : 'px';
$cbdb_post_date_margin_unit = isset($cbdb_settings['cbdb_post_date_margin_unit']) ? $cbdb_settings['cbdb_post_date_margin_unit'] : 'px';
$cbdb_post_date_padding_unit = isset($cbdb_settings['cbdb_post_date_padding_unit']) ? $cbdb_settings['cbdb_post_date_padding_unit'] : 'px';
$cbdb_post_cat_margin_unit = isset($cbdb_settings['cbdb_post_cat_margin_unit']) ? $cbdb_settings['cbdb_post_cat_margin_unit'] : 'px';
$cbdb_post_cat_padding_unit = isset($cbdb_settings['cbdb_post_cat_padding_unit']) ? $cbdb_settings['cbdb_post_cat_padding_unit'] : 'px';
$cbdb_post_tag_margin_unit = isset($cbdb_settings['cbdb_post_tag_margin_unit']) ? $cbdb_settings['cbdb_post_tag_margin_unit'] : 'px';
$cbdb_post_tag_padding_unit = isset($cbdb_settings['cbdb_post_tag_padding_unit']) ? $cbdb_settings['cbdb_post_tag_padding_unit'] : 'px';
$cbdb_post_meta_margin_unit = isset($cbdb_settings['cbdb_post_meta_margin_unit']) ? $cbdb_settings['cbdb_post_meta_margin_unit'] : 'px';
$cbdb_post_meta_padding_unit = isset($cbdb_settings['cbdb_post_meta_padding_unit']) ? $cbdb_settings['cbdb_post_meta_padding_unit'] : 'px';
$cbdb_read_more_margin_unit = isset($cbdb_settings['cbdb_read_more_margin_unit']) ? $cbdb_settings['cbdb_read_more_margin_unit'] : 'px';
$cbdb_read_more_padding_unit = isset($cbdb_settings['cbdb_read_more_padding_unit']) ? $cbdb_settings['cbdb_read_more_padding_unit'] : 'px';

$cbdb_main_container_border_unit = isset($cbdb_settings['cbdb_main_container_border_unit']) ? $cbdb_settings['cbdb_main_container_border_unit'] : '';
$cbdb_read_more_btn_border_unit = isset($cbdb_settings['cbdb_read_more_btn_border_unit']) ? $cbdb_settings['cbdb_read_more_btn_border_unit'] : '';

// Set up some blank variables
$cbdb_main_container_box_shadow_color = $cbdb_main_container_box_shadow_position_h_offset = $cbdb_main_container_box_shadow_position_v_offset = $cbdb_main_container_box_shadow_position_blur = $cbdb_read_more_box_shadow_color = $cbdb_read_more_box_shadow_position_h_offset = $cbdb_read_more_box_shadow_position_v_offset = $cbdb_read_more_box_shadow_position_blur = '';
?>
<style>
    /* Main section */
    .cbdb-main-section-<?php echo $cbdb_id_class; ?> {
        <?php if ($cbdb_main_container_bg_image_id) { ?>
            background-image: url('<?php echo esc_url(wp_get_attachment_url($cbdb_main_container_bg_image_id)); ?>');
            background-repeat: no-repeat;
            background-size: cover;
            background-position: center;
            <?php
        }
        if (isset($cbdb_settings['cbdb_main_container_color']) && trim($cbdb_settings['cbdb_main_container_color']) != '') {
            ?>
            background-color: <?php echo $cbdb_settings['cbdb_main_container_color']; ?>;
            <?php
        }
        ?>
        border-style: <?php echo $cbdb_settings['cbdb_main_container_border_style']; ?>;
        <?php if (isset($cbdb_settings['cbdb_main_container_border_color']) && trim($cbdb_settings['cbdb_main_container_border_color']) != '') {
            ?>
            border-color: <?php echo $cbdb_settings['cbdb_main_container_border_color']; ?>;
            <?php
        }
        if (isset($cbdb_settings['cbdb_main_container_border_radius']) && trim($cbdb_settings['cbdb_main_container_border_radius']) != '') {
            ?>
            border-radius: <?php echo $cbdb_settings['cbdb_main_container_border_radius']; ?>px;
            <?php
        }
        if (isset($cbdb_settings['cbdb_main_container_border_top']) && trim($cbdb_settings['cbdb_main_container_border_top']) != '') {
            ?>
            border-top-width: <?php echo $cbdb_settings['cbdb_main_container_border_top'] . $cbdb_main_container_border_unit; ?>;
            <?php
        }
        if (isset($cbdb_settings['cbdb_main_container_border_right']) && trim($cbdb_settings['cbdb_main_container_border_right']) != '') {
            ?>
            border-right-width: <?php echo $cbdb_settings['cbdb_main_container_border_right'] . $cbdb_main_container_border_unit; ?>;
            <?php
        }
        if (isset(($cbdb_settings['cbdb_main_container_border_bottom'])) && trim($cbdb_settings['cbdb_main_container_border_bottom']) != '') {
            ?>
            border-bottom-width: <?php echo $cbdb_settings['cbdb_main_container_border_bottom'] . $cbdb_main_container_border_unit; ?>;
            <?php
        }
        if (isset($cbdb_settings['cbdb_main_container_border_left']) && trim($cbdb_settings['cbdb_main_container_border_left']) != '') {
            ?>
            border-left-width: <?php echo $cbdb_settings['cbdb_main_container_border_left'] . $cbdb_main_container_border_unit; ?>;
            <?php
        }
        if (isset($cbdb_settings['cbdb_main_container_box_shadow_position_h_offset']) && trim($cbdb_settings['cbdb_main_container_box_shadow_position_h_offset']) != '') {
            $cbdb_main_container_box_shadow_position_h_offset = $cbdb_settings['cbdb_main_container_box_shadow_position_h_offset'] . 'px';
        }
        if (isset($cbdb_settings['cbdb_main_container_box_shadow_position_v_offset']) && trim($cbdb_settings['cbdb_main_container_box_shadow_position_v_offset']) != '') {
            $cbdb_main_container_box_shadow_position_v_offset = $cbdb_settings['cbdb_main_container_box_shadow_position_v_offset'] . 'px';
        }
        if (isset($cbdb_settings['cbdb_main_container_box_shadow_position_blur']) && trim($cbdb_settings['cbdb_main_container_box_shadow_position_blur']) != '') {
            $cbdb_main_container_box_shadow_position_blur = $cbdb_settings['cbdb_main_container_box_shadow_position_blur'] . 'px';
        }
        if (isset($cbdb_settings['cbdb_main_container_box_shadow_color']) && trim($cbdb_settings['cbdb_main_container_box_shadow_color']) != '') {
            $cbdb_main_container_box_shadow_color = ' ' . $cbdb_settings['cbdb_main_container_box_shadow_color'];
        }
        ?>
        box-shadow: <?php echo $cbdb_main_container_box_shadow_position_h_offset . ' ' . $cbdb_main_container_box_shadow_position_v_offset . ' ' . $cbdb_main_container_box_shadow_position_blur . $cbdb_main_container_box_shadow_color; ?>;
    }

    /* Main container grid spacing */
    <?php echo $cbdb_combine; ?>.cbdb-main-container.cbdb-grid-layout {
        <?php
        if (trim($cbdb_grid_gap) != '') {
            ?>
            grid-column-gap: <?php echo $cbdb_grid_gap . $cbdb_grid_gap_layout_unit; ?>;
            <?php
        }
        if (trim($cbdb_row_gap) != '') {
            ?>
            grid-row-gap: <?php echo $cbdb_row_gap . $cbdb_row_gap_layout_unit; ?>;
        <?php } ?>
    }

    /* Main container list spacing */
    <?php echo $cbdb_combine; ?>.cbdb-main-container .cbdb-list-layout {
        <?php
        if (trim($cbdb_row_gap) != '') {
            ?>
            margin-bottom: <?php echo $cbdb_row_gap . $cbdb_row_gap_layout_unit; ?>;
        <?php } ?>
    }

    /* Post title */
    <?php echo $cbdb_combine; ?> .cbdb-title {
        <?php if (isset($cbdb_settings['cbdb_post_title_font_family']) && trim($cbdb_settings['cbdb_post_title_font_family']) != '') { ?>
            font-family: <?php echo $cbdb_settings['cbdb_post_title_font_family']; ?>;
            <?php
        }
        if (isset($cbdb_settings['cbdb_post_title_font_size']) && trim($cbdb_settings['cbdb_post_title_font_size']) != '') {
            ?>
            font-size: <?php echo $cbdb_settings['cbdb_post_title_font_size']; ?>px;
            <?php
        }
        if (isset($cbdb_settings['cbdb_post_title_font_weight']) && trim($cbdb_settings['cbdb_post_title_font_weight']) != '') {
            ?>
            font-weight: <?php echo $cbdb_settings['cbdb_post_title_font_weight']; ?>;
            <?php
        }
        if (isset($cbdb_settings['cbdb_post_title_font_style']) && trim($cbdb_settings['cbdb_post_title_font_style']) != '') {
            ?>
            font-style: <?php echo $cbdb_settings['cbdb_post_title_font_style']; ?>;
            <?php
        }
        if (isset($cbdb_settings['cbdb_post_title_text_transform']) && trim($cbdb_settings['cbdb_post_title_text_transform']) != '') {
            ?>
            text-transform: <?php echo $cbdb_settings['cbdb_post_title_text_transform']; ?>;
            <?php
        }
        if (isset($cbdb_settings['cbdb_post_title_text_decoration']) && trim($cbdb_settings['cbdb_post_title_text_decoration']) != '') {
            ?>
            text-decoration: <?php echo $cbdb_settings['cbdb_post_title_text_decoration']; ?>;
            <?php
        }
        if (isset($cbdb_settings['cbdb_post_title_line_height']) && trim($cbdb_settings['cbdb_post_title_line_height']) != '') {
            ?>
            line-height: <?php echo $cbdb_settings['cbdb_post_title_line_height']; ?>px;
            <?php
        }
        if (isset($cbdb_settings['cbdb_post_title_letter_spacing']) && trim($cbdb_settings['cbdb_post_title_letter_spacing']) != '') {
            ?>
            letter-spacing: <?php echo $cbdb_settings['cbdb_post_title_letter_spacing']; ?>px;
            <?php
        }
        if (isset($cbdb_settings['cbdb_post_title_color']) && trim($cbdb_settings['cbdb_post_title_color']) != '') {
            ?>
            color: <?php echo $cbdb_settings['cbdb_post_title_color']; ?>;
            <?php
        }
        if (isset($cbdb_settings['cbdb_post_title_margin_top']) && trim($cbdb_settings['cbdb_post_title_margin_top']) != '') {
            ?>
            margin-top: <?php echo $cbdb_settings['cbdb_post_title_margin_top'] . $cbdb_post_title_margin_unit; ?>;
            <?php
        }
        if (isset($cbdb_settings['cbdb_post_title_margin_right']) && trim($cbdb_settings['cbdb_post_title_margin_right']) != '') {
            ?>
            margin-right: <?php echo $cbdb_settings['cbdb_post_title_margin_right'] . $cbdb_post_title_margin_unit; ?>;
            <?php
        }
        if (isset($cbdb_settings['cbdb_post_title_margin_bottom']) && trim($cbdb_settings['cbdb_post_title_margin_bottom']) != '') {
            ?>
            margin-bottom: <?php echo $cbdb_settings['cbdb_post_title_margin_bottom'] . $cbdb_post_title_margin_unit; ?>;
            <?php
        }
        if (isset($cbdb_settings['cbdb_post_title_margin_left']) && trim($cbdb_settings['cbdb_post_title_margin_left']) != '') {
            ?>
            margin-left: <?php echo $cbdb_settings['cbdb_post_title_margin_left'] . $cbdb_post_title_margin_unit; ?>;
            <?php
        }
        if (isset($cbdb_settings['cbdb_post_title_padding_top']) && trim($cbdb_settings['cbdb_post_title_padding_top']) != '') {
            ?>
            padding-top: <?php echo $cbdb_settings['cbdb_post_title_padding_top'] . $cbdb_post_title_padding_unit; ?>;
            <?php
        }
        if (isset($cbdb_settings['cbdb_post_title_padding_right']) && trim($cbdb_settings['cbdb_post_title_padding_right']) != '') {
            ?>
            padding-right: <?php echo $cbdb_settings['cbdb_post_title_padding_right'] . $cbdb_post_title_padding_unit; ?>;
            <?php
        }
        if (isset($cbdb_settings['cbdb_post_title_padding_bottom']) && trim($cbdb_settings['cbdb_post_title_padding_bottom']) != '') {
            ?>
            padding-bottom: <?php echo $cbdb_settings['cbdb_post_title_padding_bottom'] . $cbdb_post_title_padding_unit; ?>;
            <?php
        }
        if (isset($cbdb_settings['cbdb_post_title_padding_left']) && trim($cbdb_settings['cbdb_post_title_padding_left']) != '') {
            ?>
            padding-left: <?php echo $cbdb_settings['cbdb_post_title_padding_left'] . $cbdb_post_title_padding_unit; ?>;
        <?php } ?>
    }

    /* Post title link */
    <?php echo $cbdb_combine; ?> .cbdb-title a {
        <?php if (isset($cbdb_settings['cbdb_post_title_color']) && trim($cbdb_settings['cbdb_post_title_color']) != '') { ?>
            color: <?php echo $cbdb_settings['cbdb_post_title_color']; ?>;
            <?php
        }
        ?>
    }

    <?php echo $cbdb_combine; ?> .cbdb-title a:hover {
        <?php if (isset($cbdb_settings['cbdb_post_title_link_hover_color']) && trim($cbdb_settings['cbdb_post_title_link_hover_color']) != '') { ?>
            color: <?php echo $cbdb_settings['cbdb_post_title_link_hover_color']; ?>;
        <?php } ?>
    }

    /* Post content */
    <?php echo $cbdb_combine; ?> .cbdb-description {
        <?php if (isset($cbdb_settings['cbdb_post_content_font_family']) && trim($cbdb_settings['cbdb_post_content_font_family']) != '') { ?>
            font-family: <?php echo $cbdb_settings['cbdb_post_content_font_family']; ?>;
            <?php
        }
        if (isset($cbdb_settings['cbdb_post_content_font_size']) && trim($cbdb_settings['cbdb_post_content_font_size']) != '') {
            ?>
            font-size: <?php echo $cbdb_settings['cbdb_post_content_font_size']; ?>px;
            <?php
        }
        if (isset($cbdb_settings['cbdb_post_content_font_weight']) && trim($cbdb_settings['cbdb_post_content_font_weight']) != '') {
            ?>
            font-weight: <?php echo $cbdb_settings['cbdb_post_content_font_weight']; ?>;
            <?php
        }
        if (isset($cbdb_settings['cbdb_post_content_font_style']) && trim($cbdb_settings['cbdb_post_content_font_style']) != '') {
            ?>
            font-style: <?php echo $cbdb_settings['cbdb_post_content_font_style']; ?>;
            <?php
        }
        if (isset($cbdb_settings['cbdb_post_content_text_transform']) && trim($cbdb_settings['cbdb_post_content_text_transform']) != '') {
            ?>
            text-transform: <?php echo $cbdb_settings['cbdb_post_content_text_transform']; ?>;
            <?php
        }
        if (isset($cbdb_settings['cbdb_post_content_text_decoration']) && trim($cbdb_settings['cbdb_post_content_text_decoration']) != '') {
            ?>
            text-decoration: <?php echo $cbdb_settings['cbdb_post_content_text_decoration']; ?>;
            <?php
        }
        if (isset($cbdb_settings['cbdb_post_content_line_height']) && trim($cbdb_settings['cbdb_post_content_line_height']) != '') {
            ?>
            line-height: <?php echo $cbdb_settings['cbdb_post_content_line_height']; ?>px;
            <?php
        }
        if (isset($cbdb_settings['cbdb_post_content_letter_spacing']) && trim($cbdb_settings['cbdb_post_content_letter_spacing']) != '') {
            ?>
            letter-spacing: <?php echo $cbdb_settings['cbdb_post_content_letter_spacing']; ?>px;
            <?php
        }
        if (isset($cbdb_settings['cbdb_post_content_color']) && trim($cbdb_settings['cbdb_post_content_color']) != '') {
            ?>
            color: <?php echo $cbdb_settings['cbdb_post_content_color']; ?>;
            <?php
        }
        if (isset($cbdb_settings['cbdb_post_content_margin_top']) && trim($cbdb_settings['cbdb_post_content_margin_top']) != '') {
            ?>
            margin-top: <?php echo $cbdb_settings['cbdb_post_content_margin_top'] . $cbdb_post_content_margin_unit; ?>;
            <?php
        }
        if (isset($cbdb_settings['cbdb_post_content_margin_right']) && trim($cbdb_settings['cbdb_post_content_margin_right']) != '') {
            ?>
            margin-right: <?php echo $cbdb_settings['cbdb_post_content_margin_right'] . $cbdb_post_content_margin_unit; ?>;
            <?php
        }
        if (isset($cbdb_settings['cbdb_post_content_margin_bottom']) && trim($cbdb_settings['cbdb_post_content_margin_bottom']) != '') {
            ?>
            margin-bottom: <?php echo $cbdb_settings['cbdb_post_content_margin_bottom'] . $cbdb_post_content_margin_unit; ?>;
            <?php
        }
        if (isset($cbdb_settings['cbdb_post_content_margin_left']) && trim($cbdb_settings['cbdb_post_content_margin_left']) != '') {
            ?>
            margin-left: <?php echo $cbdb_settings['cbdb_post_content_margin_left'] . $cbdb_post_content_margin_unit; ?>;
            <?php
        }
        if (isset($cbdb_settings['cbdb_post_content_padding_top']) && trim($cbdb_settings['cbdb_post_content_padding_top']) != '') {
            ?>
            padding-top: <?php echo $cbdb_settings['cbdb_post_content_padding_top'] . $cbdb_post_content_padding_unit; ?>;
            <?php
        }
        if (isset($cbdb_settings['cbdb_post_content_padding_right']) && trim($cbdb_settings['cbdb_post_content_padding_right']) != '') {
            ?>
            padding-right: <?php echo $cbdb_settings['cbdb_post_content_padding_right'] . $cbdb_post_content_padding_unit; ?>;
            <?php
        }
        if (isset($cbdb_settings['cbdb_post_content_padding_bottom']) && trim($cbdb_settings['cbdb_post_content_padding_bottom']) != '') {
            ?>
            padding-bottom: <?php echo $cbdb_settings['cbdb_post_content_padding_bottom'] . $cbdb_post_content_padding_unit; ?>;
            <?php
        }
        if (isset($cbdb_settings['cbdb_post_content_padding_left']) && trim($cbdb_settings['cbdb_post_content_padding_left']) != '') {
            ?>
            padding-left: <?php echo $cbdb_settings['cbdb_post_content_padding_left'] . $cbdb_post_content_padding_unit; ?>;
        <?php } ?>
    }

    /* Post date */
    <?php echo $cbdb_combine; ?> .cbdb-date {
        <?php if (isset($cbdb_settings['cbdb_post_date_font_family']) && trim($cbdb_settings['cbdb_post_date_font_family']) != '') { ?>
            font-family: <?php echo $cbdb_settings['cbdb_post_date_font_family']; ?>;
            <?php
        }
        if (isset($cbdb_settings['cbdb_post_date_font_size']) && trim($cbdb_settings['cbdb_post_date_font_size']) != '') {
            ?>
            font-size: <?php echo $cbdb_settings['cbdb_post_date_font_size']; ?>px;
            <?php
        }
        if (isset($cbdb_settings['cbdb_post_date_font_weight']) && trim($cbdb_settings['cbdb_post_date_font_weight']) != '') {
            ?>
            font-weight: <?php echo $cbdb_settings['cbdb_post_date_font_weight']; ?>;
            <?php
        }
        if (isset($cbdb_settings['cbdb_post_date_font_style']) && trim($cbdb_settings['cbdb_post_date_font_style']) != '') {
            ?>
            font-style: <?php echo $cbdb_settings['cbdb_post_date_font_style']; ?>;
            <?php
        }
        if (isset($cbdb_settings['cbdb_post_date_text_transform']) && trim($cbdb_settings['cbdb_post_date_text_transform']) != '') {
            ?>
            text-transform: <?php echo $cbdb_settings['cbdb_post_date_text_transform']; ?>;
            <?php
        }
        if (isset($cbdb_settings['cbdb_post_date_text_decoration']) && trim($cbdb_settings['cbdb_post_date_text_decoration']) != '') {
            ?>
            text-decoration: <?php echo $cbdb_settings['cbdb_post_date_text_decoration']; ?>;
            <?php
        }
        if (isset($cbdb_settings['cbdb_post_date_line_height']) && trim($cbdb_settings['cbdb_post_date_line_height']) != '') {
            ?>
            line-height: <?php echo $cbdb_settings['cbdb_post_date_line_height']; ?>px;
            <?php
        }
        if (isset($cbdb_settings['cbdb_post_date_letter_spacing']) && trim($cbdb_settings['cbdb_post_date_letter_spacing']) != '') {
            ?>
            letter-spacing: <?php echo $cbdb_settings['cbdb_post_date_letter_spacing']; ?>px;
            <?php
        }
        if (isset($cbdb_settings['cbdb_post_date_color']) && trim($cbdb_settings['cbdb_post_date_color']) != '') {
            ?>
            color: <?php echo $cbdb_settings['cbdb_post_date_color']; ?>;
            <?php
        }
        if (isset($cbdb_settings['cbdb_post_date_margin_top']) && trim($cbdb_settings['cbdb_post_date_margin_top']) != '') {
            ?>
            margin-top: <?php echo $cbdb_settings['cbdb_post_date_margin_top'] . $cbdb_post_date_margin_unit; ?>;
            <?php
        }
        if (isset($cbdb_settings['cbdb_post_date_margin_right']) && trim($cbdb_settings['cbdb_post_date_margin_right']) != '') {
            ?>
            margin-right: <?php echo $cbdb_settings['cbdb_post_date_margin_right'] . $cbdb_post_date_margin_unit; ?>;
            <?php
        }
        if (isset($cbdb_settings['cbdb_post_date_margin_bottom']) && trim($cbdb_settings['cbdb_post_date_margin_bottom']) != '') {
            ?>
            margin-bottom: <?php echo $cbdb_settings['cbdb_post_date_margin_bottom'] . $cbdb_post_date_margin_unit; ?>;
            <?php
        }
        if (isset($cbdb_settings['cbdb_post_date_margin_left']) && trim($cbdb_settings['cbdb_post_date_margin_left']) != '') {
            ?>
            margin-left: <?php echo $cbdb_settings['cbdb_post_date_margin_left'] . $cbdb_post_date_margin_unit; ?>;
            <?php
        }
        if (isset($cbdb_settings['cbdb_post_date_padding_top']) && trim($cbdb_settings['cbdb_post_date_padding_top']) != '') {
            ?>
            padding-top: <?php echo $cbdb_settings['cbdb_post_date_padding_top'] . $cbdb_post_date_padding_unit; ?>;
            <?php
        }
        if (isset($cbdb_settings['cbdb_post_date_padding_right']) && trim($cbdb_settings['cbdb_post_date_padding_right']) != '') {
            ?>
            padding-right: <?php echo $cbdb_settings['cbdb_post_date_padding_right'] . $cbdb_post_date_padding_unit; ?>;
            <?php
        }
        if (isset($cbdb_settings['cbdb_post_date_padding_bottom']) && trim($cbdb_settings['cbdb_post_date_padding_bottom']) != '') {
            ?>
            padding-bottom: <?php echo $cbdb_settings['cbdb_post_date_padding_bottom'] . $cbdb_post_date_padding_unit; ?>;
            <?php
        }
        if (isset($cbdb_settings['cbdb_post_date_padding_left']) && trim($cbdb_settings['cbdb_post_date_padding_left']) != '') {
            ?>
            padding-left: <?php echo $cbdb_settings['cbdb_post_date_padding_left'] . $cbdb_post_date_padding_unit; ?>;
        <?php } ?>
    }

    /* Post date link */
    <?php echo $cbdb_combine; ?> .cbdb-date a {
        <?php if (isset($cbdb_settings['cbdb_post_date_color']) && trim($cbdb_settings['cbdb_post_date_color']) != '') { ?>
            color: <?php echo $cbdb_settings['cbdb_post_date_color']; ?>;
        <?php }
        ?>
    }

    <?php echo $cbdb_combine; ?> .cbdb-date a:hover {
        <?php if (isset($cbdb_settings['cbdb_post_date_link_hover_color']) && trim($cbdb_settings['cbdb_post_date_link_hover_color']) != '') { ?>
            color: <?php echo $cbdb_settings['cbdb_post_date_link_hover_color']; ?>;
        <?php }
        ?>
    }

    /* Post category */
    <?php echo $cbdb_combine; ?> .cbdb-category {
        <?php if (isset($cbdb_settings['cbdb_post_cat_font_family']) && trim($cbdb_settings['cbdb_post_cat_font_family']) != '') { ?>
            font-family: <?php echo $cbdb_settings['cbdb_post_cat_font_family']; ?>;
            <?php
        }
        if (isset($cbdb_settings['cbdb_post_cat_font_size']) && trim($cbdb_settings['cbdb_post_cat_font_size']) != '') {
            ?>
            font-size: <?php echo $cbdb_settings['cbdb_post_cat_font_size']; ?>px;
            <?php
        }
        if (isset($cbdb_settings['cbdb_post_cat_font_weight']) && trim($cbdb_settings['cbdb_post_cat_font_weight']) != '') {
            ?>
            font-weight: <?php echo $cbdb_settings['cbdb_post_cat_font_weight']; ?>;
            <?php
        }
        if (isset($cbdb_settings['cbdb_post_cat_font_style']) && trim($cbdb_settings['cbdb_post_cat_font_style']) != '') {
            ?>
            font-style: <?php echo $cbdb_settings['cbdb_post_cat_font_style']; ?>;
            <?php
        }
        if (isset($cbdb_settings['cbdb_post_cat_text_transform']) && trim($cbdb_settings['cbdb_post_cat_text_transform']) != '') {
            ?>
            text-transform: <?php echo $cbdb_settings['cbdb_post_cat_text_transform']; ?>;
            <?php
        }
        if (isset($cbdb_settings['cbdb_post_cat_text_decoration']) && trim($cbdb_settings['cbdb_post_cat_text_decoration']) != '') {
            ?>
            text-decoration: <?php echo $cbdb_settings['cbdb_post_cat_text_decoration']; ?>;
            <?php
        }
        if (isset($cbdb_settings['cbdb_post_cat_line_height']) && trim($cbdb_settings['cbdb_post_cat_line_height']) != '') {
            ?>
            line-height: <?php echo $cbdb_settings['cbdb_post_cat_line_height']; ?>px;
            <?php
        }
        if (isset($cbdb_settings['cbdb_post_cat_letter_spacing']) && trim($cbdb_settings['cbdb_post_cat_letter_spacing']) != '') {
            ?>
            letter-spacing: <?php echo $cbdb_settings['cbdb_post_cat_letter_spacing']; ?>px;
            <?php
        }
        if (isset($cbdb_settings['cbdb_post_cat_color']) && trim($cbdb_settings['cbdb_post_cat_color']) != '') {
            ?>
            color: <?php echo $cbdb_settings['cbdb_post_cat_color']; ?>;
            <?php
        }
        if (isset($cbdb_settings['cbdb_post_cat_margin_top']) && trim($cbdb_settings['cbdb_post_cat_margin_top']) != '') {
            ?>
            margin-top: <?php echo $cbdb_settings['cbdb_post_cat_margin_top'] . $cbdb_post_cat_margin_unit; ?>;
            <?php
        }
        if (isset($cbdb_settings['cbdb_post_cat_margin_right']) && trim($cbdb_settings['cbdb_post_cat_margin_right']) != '') {
            ?>
            margin-right: <?php echo $cbdb_settings['cbdb_post_cat_margin_right'] . $cbdb_post_cat_margin_unit; ?>;
            <?php
        }
        if (isset($cbdb_settings['cbdb_post_cat_margin_bottom']) && trim($cbdb_settings['cbdb_post_cat_margin_bottom']) != '') {
            ?>
            margin-bottom: <?php echo $cbdb_settings['cbdb_post_cat_margin_bottom'] . $cbdb_post_cat_margin_unit; ?>;
            <?php
        }
        if (isset($cbdb_settings['cbdb_post_cat_margin_left']) && trim($cbdb_settings['cbdb_post_cat_margin_left']) != '') {
            ?>
            margin-left: <?php echo $cbdb_settings['cbdb_post_cat_margin_left'] . $cbdb_post_cat_margin_unit; ?>;
            <?php
        }
        if (isset($cbdb_settings['cbdb_post_cat_padding_top']) && trim($cbdb_settings['cbdb_post_cat_padding_top']) != '') {
            ?>
            padding-top: <?php echo $cbdb_settings['cbdb_post_cat_padding_top'] . $cbdb_post_cat_padding_unit; ?>;
            <?php
        }
        if (isset($cbdb_settings['cbdb_post_cat_padding_right']) && trim($cbdb_settings['cbdb_post_cat_padding_right']) != '') {
            ?>
            padding-right: <?php echo $cbdb_settings['cbdb_post_cat_padding_right'] . $cbdb_post_cat_padding_unit; ?>;
            <?php
        }
        if (isset($cbdb_settings['cbdb_post_cat_padding_bottom']) && trim($cbdb_settings['cbdb_post_cat_padding_bottom']) != '') {
            ?>
            padding-bottom: <?php echo $cbdb_settings['cbdb_post_cat_padding_bottom'] . $cbdb_post_cat_padding_unit; ?>;
            <?php
        }
        if (isset($cbdb_settings['cbdb_post_cat_padding_left']) && trim($cbdb_settings['cbdb_post_cat_padding_left']) != '') {
            ?>
            padding-left: <?php echo $cbdb_settings['cbdb_post_cat_padding_left'] . $cbdb_post_cat_padding_unit; ?>;
        <?php } ?>
    }

    /* Post category link */
    <?php echo $cbdb_combine; ?> .cbdb-category a {
        <?php if (isset($cbdb_settings['cbdb_post_cat_color']) && trim($cbdb_settings['cbdb_post_cat_color']) != '') { ?>
            color: <?php echo $cbdb_settings['cbdb_post_cat_color']; ?>;
            <?php
        }
        if (isset($cbdb_settings['cbdb_post_cat_text_decoration']) && trim($cbdb_settings['cbdb_post_cat_text_decoration']) != '') {
            ?>
            text-decoration: <?php echo $cbdb_settings['cbdb_post_cat_text_decoration']; ?>;
        <?php } ?>
    }

    <?php echo $cbdb_combine; ?> .cbdb-category a:hover {
        <?php if (isset($cbdb_settings['cbdb_post_cat_link_hover_color']) && trim($cbdb_settings['cbdb_post_cat_link_hover_color']) != '') { ?>
            color: <?php echo $cbdb_settings['cbdb_post_cat_link_hover_color']; ?>;
        <?php } ?>
    }

    /* Post tag */
    <?php echo $cbdb_combine; ?> .cbdb-tags {
        <?php if (isset($cbdb_settings['cbdb_post_tag_font_family']) && trim($cbdb_settings['cbdb_post_tag_font_family']) != '') { ?>
            font-family: <?php echo $cbdb_settings['cbdb_post_tag_font_family']; ?>;
            <?php
        }
        if (isset($cbdb_settings['cbdb_post_tag_font_size']) && trim($cbdb_settings['cbdb_post_tag_font_size']) != '') {
            ?>
            font-size: <?php echo $cbdb_settings['cbdb_post_tag_font_size']; ?>px;
            <?php
        }
        if (isset($cbdb_settings['cbdb_post_tag_font_weight']) && trim($cbdb_settings['cbdb_post_tag_font_weight']) != '') {
            ?>
            font-weight: <?php echo $cbdb_settings['cbdb_post_tag_font_weight']; ?>;
            <?php
        }
        if (isset($cbdb_settings['cbdb_post_tag_font_style']) && trim($cbdb_settings['cbdb_post_tag_font_style']) != '') {
            ?>
            font-style: <?php echo $cbdb_settings['cbdb_post_tag_font_style']; ?>;
            <?php
        }
        if (isset($cbdb_settings['cbdb_post_tag_text_transform']) && trim($cbdb_settings['cbdb_post_tag_text_transform']) != '') {
            ?>
            text-transform: <?php echo $cbdb_settings['cbdb_post_tag_text_transform']; ?>;
            <?php
        }
        if (isset($cbdb_settings['cbdb_post_tag_text_decoration']) && trim($cbdb_settings['cbdb_post_tag_text_decoration']) != '') {
            ?>
            text-decoration: <?php echo $cbdb_settings['cbdb_post_tag_text_decoration']; ?>;
            <?php
        }
        if (isset($cbdb_settings['cbdb_post_tag_line_height']) && trim($cbdb_settings['cbdb_post_tag_line_height']) != '') {
            ?>
            line-height: <?php echo $cbdb_settings['cbdb_post_tag_line_height']; ?>px;
            <?php
        }
        if (isset($cbdb_settings['cbdb_post_tag_letter_spacing']) && trim($cbdb_settings['cbdb_post_tag_letter_spacing']) != '') {
            ?>
            letter-spacing: <?php echo $cbdb_settings['cbdb_post_tag_letter_spacing']; ?>px;
            <?php
        }
        if (isset($cbdb_settings['cbdb_post_tag_color']) && trim($cbdb_settings['cbdb_post_tag_color']) != '') {
            ?>
            color: <?php echo $cbdb_settings['cbdb_post_tag_color']; ?>;
            <?php
        }
        if (isset($cbdb_settings['cbdb_post_tag_margin_top']) && trim($cbdb_settings['cbdb_post_tag_margin_top']) != '') {
            ?>
            margin-top: <?php echo $cbdb_settings['cbdb_post_tag_margin_top'] . $cbdb_post_tag_margin_unit; ?>;
            <?php
        }
        if (isset($cbdb_settings['cbdb_post_tag_margin_right']) && trim($cbdb_settings['cbdb_post_tag_margin_right']) != '') {
            ?>
            margin-right: <?php echo $cbdb_settings['cbdb_post_tag_margin_right'] . $cbdb_post_tag_margin_unit; ?>;
            <?php
        }
        if (isset($cbdb_settings['cbdb_post_tag_margin_bottom']) && trim($cbdb_settings['cbdb_post_tag_margin_bottom']) != '') {
            ?>
            margin-bottom: <?php echo $cbdb_settings['cbdb_post_tag_margin_bottom'] . $cbdb_post_tag_margin_unit; ?>;
            <?php
        }
        if (isset($cbdb_settings['cbdb_post_tag_margin_left']) && trim($cbdb_settings['cbdb_post_tag_margin_left']) != '') {
            ?>
            margin-left: <?php echo $cbdb_settings['cbdb_post_tag_margin_left'] . $cbdb_post_tag_margin_unit; ?>;
            <?php
        }
        if (isset($cbdb_settings['cbdb_post_tag_padding_top']) && trim($cbdb_settings['cbdb_post_tag_padding_top']) != '') {
            ?>
            padding-top: <?php echo $cbdb_settings['cbdb_post_tag_padding_top'] . $cbdb_post_tag_padding_unit; ?>;
            <?php
        }
        if (isset($cbdb_settings['cbdb_post_tag_padding_right']) && trim($cbdb_settings['cbdb_post_tag_padding_right']) != '') {
            ?>
            padding-right: <?php echo $cbdb_settings['cbdb_post_tag_padding_right'] . $cbdb_post_tag_padding_unit; ?>;
            <?php
        }
        if (isset($cbdb_settings['cbdb_post_tag_padding_bottom']) && trim($cbdb_settings['cbdb_post_tag_padding_bottom']) != '') {
            ?>
            padding-bottom: <?php echo $cbdb_settings['cbdb_post_tag_padding_bottom'] . $cbdb_post_tag_padding_unit; ?>;
            <?php
        }
        if (isset($cbdb_settings['cbdb_post_tag_padding_left']) && trim($cbdb_settings['cbdb_post_tag_padding_left']) != '') {
            ?>
            padding-left: <?php echo $cbdb_settings['cbdb_post_tag_padding_left'] . $cbdb_post_tag_padding_unit; ?>;
        <?php } ?>
    }

    /* Post tag link */
    <?php echo $cbdb_combine; ?> .cbdb-tags a {
        <?php if (isset($cbdb_settings['cbdb_post_tag_color']) && trim($cbdb_settings['cbdb_post_tag_color']) != '') { ?>
            color: <?php echo $cbdb_settings['cbdb_post_tag_color']; ?>;
            <?php
        }
        ?>
    }

    <?php echo $cbdb_combine; ?> .cbdb-tags a:hover {
        <?php if (isset($cbdb_settings['cbdb_post_tag_link_hover_color']) && trim($cbdb_settings['cbdb_post_tag_link_hover_color']) != '') { ?>
            color: <?php echo $cbdb_settings['cbdb_post_tag_link_hover_color']; ?>;
        <?php }
        ?>
    }

    /* Post meta */
    <?php echo $cbdb_combine; ?> .cbdb-meta {
        <?php if (isset($cbdb_settings['cbdb_post_meta_font_family']) && trim($cbdb_settings['cbdb_post_meta_font_family']) != '') { ?>
            font-family: <?php echo $cbdb_settings['cbdb_post_meta_font_family']; ?>;
            <?php
        }
        if (isset($cbdb_settings['cbdb_post_meta_font_size']) && trim($cbdb_settings['cbdb_post_meta_font_size']) != '') {
            ?>
            font-size: <?php echo $cbdb_settings['cbdb_post_meta_font_size']; ?>px;
            <?php
        }
        if (isset($cbdb_settings['cbdb_post_meta_font_weight']) && trim($cbdb_settings['cbdb_post_meta_font_weight']) != '') {
            ?>
            font-weight: <?php echo $cbdb_settings['cbdb_post_meta_font_weight']; ?>;
            <?php
        }
        if (isset($cbdb_settings['cbdb_post_meta_font_style']) && trim($cbdb_settings['cbdb_post_meta_font_style']) != '') {
            ?>
            font-style: <?php echo $cbdb_settings['cbdb_post_meta_font_style']; ?>;
            <?php
        }
        if (isset($cbdb_settings['cbdb_post_meta_text_transform']) && trim($cbdb_settings['cbdb_post_meta_text_transform']) != '') {
            ?>
            text-transform: <?php echo $cbdb_settings['cbdb_post_meta_text_transform']; ?>;
            <?php
        }
        if (isset($cbdb_settings['cbdb_post_meta_text_decoration']) && trim($cbdb_settings['cbdb_post_meta_text_decoration']) != '') {
            ?>
            text-decoration: <?php echo $cbdb_settings['cbdb_post_meta_text_decoration']; ?>;
            <?php
        }
        if (isset($cbdb_settings['cbdb_post_meta_line_height']) && trim($cbdb_settings['cbdb_post_meta_line_height']) != '') {
            ?>
            line-height: <?php echo $cbdb_settings['cbdb_post_meta_line_height']; ?>px;
            <?php
        }
        if (isset($cbdb_settings['cbdb_post_meta_letter_spacing']) && trim($cbdb_settings['cbdb_post_meta_letter_spacing']) != '') {
            ?>
            letter-spacing: <?php echo $cbdb_settings['cbdb_post_meta_letter_spacing']; ?>px;
            <?php
        }
        if (isset($cbdb_settings['cbdb_post_meta_color']) && trim($cbdb_settings['cbdb_post_meta_color']) != '') {
            ?>
            color: <?php echo $cbdb_settings['cbdb_post_meta_color']; ?>;
            <?php
        }
        if (isset($cbdb_settings['cbdb_post_meta_margin_top']) && trim($cbdb_settings['cbdb_post_meta_margin_top']) != '') {
            ?>
            margin-top: <?php echo $cbdb_settings['cbdb_post_meta_margin_top'] . $cbdb_post_meta_margin_unit; ?>;
            <?php
        }
        if (isset($cbdb_settings['cbdb_post_meta_margin_right']) && trim($cbdb_settings['cbdb_post_meta_margin_right']) != '') {
            ?>
            margin-right: <?php echo $cbdb_settings['cbdb_post_meta_margin_right'] . $cbdb_post_meta_margin_unit; ?>;
            <?php
        }
        if (isset($cbdb_settings['cbdb_post_meta_margin_bottom']) && trim($cbdb_settings['cbdb_post_meta_margin_bottom']) != '') {
            ?>
            margin-bottom: <?php echo $cbdb_settings['cbdb_post_meta_margin_bottom'] . $cbdb_post_meta_margin_unit; ?>;
            <?php
        }
        if (isset($cbdb_settings['cbdb_post_meta_margin_left']) && trim($cbdb_settings['cbdb_post_meta_margin_left']) != '') {
            ?>
            margin-left: <?php echo $cbdb_settings['cbdb_post_meta_margin_left'] . $cbdb_post_meta_margin_unit; ?>;
            <?php
        }
        if (isset($cbdb_settings['cbdb_post_meta_padding_top']) && trim($cbdb_settings['cbdb_post_meta_padding_top']) != '') {
            ?>
            padding-top: <?php echo $cbdb_settings['cbdb_post_meta_padding_top'] . $cbdb_post_meta_padding_unit; ?>;
            <?php
        }
        if (isset($cbdb_settings['cbdb_post_meta_padding_right']) && trim($cbdb_settings['cbdb_post_meta_padding_right']) != '') {
            ?>
            padding-right: <?php echo $cbdb_settings['cbdb_post_meta_padding_right'] . $cbdb_post_meta_padding_unit; ?>;
            <?php
        }
        if (isset($cbdb_settings['cbdb_post_meta_padding_bottom']) && trim($cbdb_settings['cbdb_post_meta_padding_bottom']) != '') {
            ?>
            padding-bottom: <?php echo $cbdb_settings['cbdb_post_meta_padding_bottom'] . $cbdb_post_meta_padding_unit; ?>;
            <?php
        }
        if (isset($cbdb_settings['cbdb_post_meta_padding_left']) && trim($cbdb_settings['cbdb_post_meta_padding_left']) != '') {
            ?>
            padding-left: <?php echo $cbdb_settings['cbdb_post_meta_padding_left'] . $cbdb_post_meta_padding_unit; ?>;
        <?php }
        ?>
    }

    /* Post meta link */
    <?php echo $cbdb_combine; ?> .cbdb-meta a {
        <?php if (isset($cbdb_settings['cbdb_post_meta_color']) && trim($cbdb_settings['cbdb_post_meta_color']) != '') { ?>
            color: <?php echo $cbdb_settings['cbdb_post_meta_color']; ?>;
            <?php
        }
        ?>
    }

    <?php echo $cbdb_combine; ?> .cbdb-meta a:hover {
        <?php if (isset($cbdb_settings['cbdb_post_meta_link_hover_color']) && trim($cbdb_settings['cbdb_post_meta_link_hover_color']) != '') { ?>
            color: <?php echo $cbdb_settings['cbdb_post_meta_link_hover_color']; ?>;
        <?php } ?>
    }

    <?php echo $cbdb_combine; ?> .cbdb-meta i.fas {
        <?php if (isset($cbdb_settings['cbdb_post_meta_icon_color']) && trim($cbdb_settings['cbdb_post_meta_icon_color']) != '') { ?>
            color: <?php echo $cbdb_settings['cbdb_post_meta_icon_color']; ?>;
        <?php } ?>
    }

    /* Read more */
    <?php echo $cbdb_combine; ?> .cbdb-read-more {
        <?php if (isset($cbdb_settings['cbdb_read_more_font_family']) && trim($cbdb_settings['cbdb_read_more_font_family']) != '') { ?>
            font-family: <?php echo $cbdb_settings['cbdb_read_more_font_family']; ?>;
            <?php
        }
        if (isset($cbdb_settings['cbdb_read_more_font_size']) && trim($cbdb_settings['cbdb_read_more_font_size']) != '') {
            ?>
            font-size: <?php echo $cbdb_settings['cbdb_read_more_font_size']; ?>px;
            <?php
        }
        if (isset($cbdb_settings['cbdb_read_more_font_weight']) && trim($cbdb_settings['cbdb_read_more_font_weight']) != '') {
            ?>
            font-weight: <?php echo $cbdb_settings['cbdb_read_more_font_weight']; ?>;
            <?php
        }
        if (isset($cbdb_settings['cbdb_read_more_font_style']) && trim($cbdb_settings['cbdb_read_more_font_style']) != '') {
            ?>
            font-style: <?php echo $cbdb_settings['cbdb_read_more_font_style']; ?>;
            <?php
        }
        if (isset($cbdb_settings['cbdb_read_more_text_transform']) && trim($cbdb_settings['cbdb_read_more_text_transform']) != '') {
            ?>
            text-transform: <?php echo $cbdb_settings['cbdb_read_more_text_transform']; ?>;
            <?php
        }
        if (isset($cbdb_settings['cbdb_read_more_text_decoration']) && trim($cbdb_settings['cbdb_read_more_text_decoration']) != '') {
            ?>
            text-decoration: <?php echo $cbdb_settings['cbdb_read_more_text_decoration']; ?>;
            <?php
        }
        if (isset($cbdb_settings['cbdb_read_more_letter_spacing']) && trim($cbdb_settings['cbdb_read_more_letter_spacing']) != '') {
            ?>
            letter-spacing: <?php echo $cbdb_settings['cbdb_read_more_letter_spacing']; ?>px;
            <?php
        }
        if (isset($cbdb_settings['cbdb_read_more_text_color']) && trim($cbdb_settings['cbdb_read_more_text_color']) != '') {
            ?>
            color: <?php echo $cbdb_settings['cbdb_read_more_text_color']; ?>;
            <?php
        }
        if (isset($cbdb_settings['cbdb_read_more_btn']) && $cbdb_settings['cbdb_read_more_btn'] == 'yes') {
            ?>
            display: inline-block;
            padding: 5px 10px;
            <?php
            if (isset($cbdb_settings['cbdb_read_more_border_style']) && trim($cbdb_settings['cbdb_read_more_border_style']) != '') {
                ?>
                border-style: <?php echo $cbdb_settings['cbdb_read_more_border_style']; ?>;
                <?php
            }
            if (trim($cbdb_settings['cbdb_read_more_bg_color']) != '') {
                ?>
                background-color: <?php echo $cbdb_settings['cbdb_read_more_bg_color']; ?>;
                <?php
            }
            if (isset($cbdb_settings['cbdb_read_more_border_color']) && trim($cbdb_settings['cbdb_read_more_border_color']) != '') {
                ?>
                border-color: <?php echo $cbdb_settings['cbdb_read_more_border_color']; ?>;
                <?php
            }
            if (isset($cbdb_settings['cbdb_read_more_border_radius']) && trim($cbdb_settings['cbdb_read_more_border_radius']) != '') {
                ?>
                border-radius: <?php echo $cbdb_settings['cbdb_read_more_border_radius']; ?>px;
                <?php
            }
            if (isset($cbdb_settings['cbdb_read_more_margin_top']) && trim($cbdb_settings['cbdb_read_more_margin_top']) != '') {
                ?>
                margin-top: <?php echo $cbdb_settings['cbdb_read_more_margin_top'] . $cbdb_read_more_margin_unit; ?>;
                <?php
            }
            if (isset($cbdb_settings['cbdb_read_more_margin_right']) && trim($cbdb_settings['cbdb_read_more_margin_right']) != '') {
                ?>
                margin-right: <?php echo $cbdb_settings['cbdb_read_more_margin_right'] . $cbdb_read_more_margin_unit; ?>;
                <?php
            }
            if (isset($cbdb_settings['cbdb_read_more_margin_bottom']) && trim($cbdb_settings['cbdb_read_more_margin_bottom']) != '') {
                ?>
                margin-bottom: <?php echo $cbdb_settings['cbdb_read_more_margin_bottom'] . $cbdb_read_more_margin_unit; ?>;
                <?php
            }
            if (isset($cbdb_settings['cbdb_read_more_margin_left']) && trim($cbdb_settings['cbdb_read_more_margin_left']) != '') {
                ?>
                margin-left: <?php echo $cbdb_settings['cbdb_read_more_margin_left'] . $cbdb_read_more_margin_unit; ?>;
                <?php
            }
            if (isset($cbdb_settings['cbdb_read_more_padding_top']) && trim($cbdb_settings['cbdb_read_more_padding_top']) != '') {
                ?>
                padding-top: <?php echo $cbdb_settings['cbdb_read_more_padding_top'] . $cbdb_read_more_padding_unit; ?>;
                <?php
            }
            if (isset($cbdb_settings['cbdb_read_more_padding_right']) && trim($cbdb_settings['cbdb_read_more_padding_right']) != '') {
                ?>
                padding-right: <?php echo $cbdb_settings['cbdb_read_more_padding_right'] . $cbdb_read_more_padding_unit; ?>;
                <?php
            }
            if (isset($cbdb_settings['cbdb_read_more_padding_bottom']) && trim($cbdb_settings['cbdb_read_more_padding_bottom']) != '') {
                ?>
                padding-bottom: <?php echo $cbdb_settings['cbdb_read_more_padding_bottom'] . $cbdb_read_more_padding_unit; ?>;
                <?php
            }
            if (isset($cbdb_settings['cbdb_read_more_padding_left']) && trim($cbdb_settings['cbdb_read_more_padding_left']) != '') {
                ?>
                padding-left: <?php echo $cbdb_settings['cbdb_read_more_padding_left'] . $cbdb_read_more_padding_unit; ?>;
                <?php
            }
            if (isset($cbdb_settings['cbdb_read_more_btn_border_top']) && trim($cbdb_settings['cbdb_read_more_btn_border_top']) != '') {
                ?>
                border-top-width: <?php echo $cbdb_settings['cbdb_read_more_btn_border_top'] . $cbdb_read_more_btn_border_unit; ?>;
                <?php
            }
            if (isset($cbdb_settings['cbdb_read_more_btn_border_right']) && trim($cbdb_settings['cbdb_read_more_btn_border_right']) != '') {
                ?>
                border-right-width: <?php echo $cbdb_settings['cbdb_read_more_btn_border_right'] . $cbdb_read_more_btn_border_unit; ?>;
                <?php
            }
            if (isset($cbdb_settings['cbdb_read_more_btn_border_bottom']) && trim($cbdb_settings['cbdb_read_more_btn_border_bottom']) != '') {
                ?>
                border-bottom-width: <?php echo $cbdb_settings['cbdb_read_more_btn_border_bottom'] . $cbdb_read_more_btn_border_unit; ?>;
                <?php
            }
            if (isset($cbdb_settings['cbdb_read_more_btn_border_left']) && trim($cbdb_settings['cbdb_read_more_btn_border_left']) != '') {
                ?>
                border-left-width: <?php echo $cbdb_settings['cbdb_read_more_btn_border_left'] . $cbdb_read_more_btn_border_unit; ?>;
                <?php
            }
            if (isset($cbdb_settings['cbdb_read_more_box_shadow_position_h_offset']) && trim($cbdb_settings['cbdb_read_more_box_shadow_position_h_offset']) != '') {
                $cbdb_read_more_box_shadow_position_h_offset = $cbdb_settings['cbdb_read_more_box_shadow_position_h_offset'] . 'px';
            }
            if (isset($cbdb_settings['cbdb_read_more_box_shadow_position_blur']) && trim($cbdb_settings['cbdb_read_more_box_shadow_position_blur']) != '') {
                $cbdb_read_more_box_shadow_position_blur = $cbdb_settings['cbdb_read_more_box_shadow_position_blur'] . 'px';
            }
            if (isset($cbdb_settings['cbdb_read_more_box_shadow_position_v_offset']) && trim($cbdb_settings['cbdb_read_more_box_shadow_position_v_offset']) != '') {
                $cbdb_read_more_box_shadow_position_v_offset = $cbdb_settings['cbdb_read_more_box_shadow_position_v_offset'] . 'px';
            }
            if (isset($cbdb_settings['cbdb_read_more_box_shadow_color']) && trim($cbdb_settings['cbdb_read_more_box_shadow_color']) != '') {
                $cbdb_read_more_box_shadow_color = ' ' . $cbdb_settings['cbdb_read_more_box_shadow_color'];
            }
            ?>
            box-shadow: <?php echo $cbdb_read_more_box_shadow_position_h_offset . ' ' . $cbdb_read_more_box_shadow_position_v_offset . ' ' . $cbdb_read_more_box_shadow_position_blur . $cbdb_read_more_box_shadow_color; ?>;
            <?php
        }
        ?>
    }

    /* Read more link */
    <?php echo $cbdb_combine; ?> .cbdb-read-more:hover {
        <?php if (isset($cbdb_settings['cbdb_read_more_text_hover_color']) && trim($cbdb_settings['cbdb_read_more_text_hover_color']) != '') {
            ?>
            color: <?php echo $cbdb_settings['cbdb_read_more_text_hover_color']; ?>;
            <?php
        }
        if (isset($cbdb_settings['cbdb_read_more_btn']) && $cbdb_settings['cbdb_read_more_btn'] == 'yes') {
            ?>
            background-color: <?php echo $cbdb_settings['cbdb_read_more_bg_hover_color']; ?>;
        <?php } ?>
    }
</style>