<?php
/**
 * Common utility functions.
 * 
 * @since 1.0
 */
if (!defined('ABSPATH')) {
    exit;
}

/**
 * Main class for utility.
 *
 * @class   CBDB_Utility
 * @since 1.0
 */
class CBDB_Utility {

    /**
     * Initialize an array of all recognized font faces.
     *
     * @since 1.0
     * 
     * @param void
     * 
     * @return type array $default font face All font family
     */
    public static function default_recognized_font_faces() {
        $default = array(
            // Serif Fonts.
            array(
                'type' => 'websafe',
                'version' => esc_html__('Serif Fonts', CBDB_TEXTDOMAIN),
                'label' => 'Georgia, serif',
            ),
            array(
                'type' => 'websafe',
                'version' => esc_html__('Serif Fonts', CBDB_TEXTDOMAIN),
                'label' => '"Palatino Linotype", "Book Antiqua", Palatino, serif',
            ),
            array(
                'type' => 'websafe',
                'version' => esc_html__('Serif Fonts', CBDB_TEXTDOMAIN),
                'label' => '"Times New Roman", Times, serif',
            ),
            // Sans-Serif Fonts.
            array(
                'type' => 'websafe',
                'version' => esc_html__('Sans-Serif Fonts', CBDB_TEXTDOMAIN),
                'label' => 'Arial, Helvetica, sans-serif',
            ),
            array(
                'type' => 'websafe',
                'version' => esc_html__('Sans-Serif Fonts', CBDB_TEXTDOMAIN),
                'label' => '"Arial Black", Gadget, sans-serif',
            ),
            array(
                'type' => 'websafe',
                'version' => esc_html__('Sans-Serif Fonts', CBDB_TEXTDOMAIN),
                'label' => '"Comic Sans MS", cursive, sans-serif',
            ),
            array(
                'type' => 'websafe',
                'version' => esc_html__('Sans-Serif Fonts', CBDB_TEXTDOMAIN),
                'label' => 'Impact, Charcoal, sans-serif',
            ),
            array(
                'type' => 'websafe',
                'version' => esc_html__('Sans-Serif Fonts', CBDB_TEXTDOMAIN),
                'label' => '"Lucida Sans Unicode", "Lucida Grande", sans-serif',
            ),
            array(
                'type' => 'websafe',
                'version' => esc_html__('Sans-Serif Fonts', CBDB_TEXTDOMAIN),
                'label' => 'Tahoma, Geneva, sans-serif',
            ),
            array(
                'type' => 'websafe',
                'version' => esc_html__('Sans-Serif Fonts', CBDB_TEXTDOMAIN),
                'label' => '"Trebuchet MS", Helvetica, sans-serif',
            ),
            array(
                'type' => 'websafe',
                'version' => esc_html__('Sans-Serif Fonts', CBDB_TEXTDOMAIN),
                'label' => 'Verdana, Geneva, sans-serif',
            ),
            // Monospace Fonts.
            array(
                'type' => 'websafe',
                'version' => esc_html__('Monospace Fonts', CBDB_TEXTDOMAIN),
                'label' => '"Courier New", Courier, monospace',
            ),
            array(
                'type' => 'websafe',
                'version' => esc_html__('Monospace Fonts', CBDB_TEXTDOMAIN),
                'label' => '"Lucida Console", Monaco, monospace',
            ),
        );
        // Include Google fonts array
        include('cbdb-google-fonts.php');
        foreach ($google_fonts_arr as $f => $val) {
            $default[] = array(
                'type' => 'googlefont',
                'version' => esc_html__('Google Fonts', CBDB_TEXTDOMAIN),
                'label' => $f,
                'variants' => $val['variants'],
                'subsets' => $val['subsets'],
            );
        }
        return $default;
    }

    /**
     * Initialize layout preview options.
     * 
     * @since 1.0
     * 
     * @param string $layout_type    Selected layout type
     * @param string $layout_preview Selected layout preview
     * 
     * @return string $layoutHTML    Relevant layout options HTML
     */
    public static function layout_preview_options($layout_type = '', $layout_preview = '') {
        $layoutHTML = '';
        $layout_arr = array('grid' => 5, 'list' => 3, 'masonry' => 2, 'slider' => 2);
        if ($layout_type) {
            for ($i = 1; $i <= $layout_arr[$layout_type]; $i++) {
                $selected = '';
                if ($layout_preview == 'layout-' . $i) {
                    $selected = ' selected="selected"';
                }
                $layoutHTML .= '<option class="cbdb-option" value="layout-' . $i . '" ' . $selected . '>' . esc_html__('Layout ' . $i, CBDB_TEXTDOMAIN) . '</option>';
            }
        }
        return $layoutHTML;
    }

    /**
     * Initialize post enable/disable.
     * 
     * @since 1.0
     * 
     * @param string $name     Field name attribute
     * @param string $id       Field id attribute
     * @param string $meta_val Field value attribute
     * 
     * @return string          Post enable/disable HTML
     */
    public static function post_enable_disable($name, $id, $meta_val) {
        $enable_disable_arr = array(1 => 'Enable', 0 => 'Disable');
        $no_switch_arr = array('post_image_link');
        $switch_class = '';
        if (!in_array($name, $no_switch_arr)) {
            $switch_class = 'cbdb-post-switch';
        }
        foreach ($enable_disable_arr as $key => $value) {
            $key_text = ($key == 1) ? 'enable' : 'disable';
            ?>
            <input type="radio" name="<?php esc_attr_e('cbdb_' . $name); ?>" id="<?php esc_attr_e('cbdb-' . $id . '-' . $key_text); ?>" class="<?php esc_attr_e($switch_class . ' cbdb-d-none'); ?>" value="<?php esc_attr_e($key); ?>" <?php checked($meta_val, $key); ?>>
            <label for="<?php esc_attr_e('cbdb-' . $id . '-' . $key_text); ?>" class="<?php esc_attr_e('cbdb-units-choices-' . $key_text); ?>"><?php esc_html_e($value, CBDB_TEXTDOMAIN); ?></label>
            <?php
        }
    }

    /**
     * Initialize post link yes/no.
     * 
     * @since 1.0
     * 
     * @param string $name     Field name attribute
     * @param string $id       Field id attribute
     * @param string $meta_val Field value attribute
     * 
     * @return string          Post link yes/no HTML
     */
    public static function post_link_yes_no($name, $id, $meta_val) {
        $yes_no_arr = array('yes' => 'Yes', 'no' => 'No');
        foreach ($yes_no_arr as $key => $value) {
            ?>
            <input type="radio" name="<?php esc_attr_e('cbdb_' . $name); ?>" id="<?php esc_attr_e('cbdb-' . $id . '-' . $key); ?>" class="cbdb-post-data-switch cbdb-d-none" value="<?php esc_attr_e($key); ?>" <?php checked($meta_val, $key); ?>>
            <label for="<?php esc_attr_e('cbdb-' . $id . '-' . $key); ?>" class="<?php esc_attr_e('cbdb-units-choices-' . $key); ?>"><?php esc_html_e($value, CBDB_TEXTDOMAIN); ?></label>
            <?php
        }
    }

    /**
     * Initialize range slider.
     * 
     * @since 1.0
     * 
     * @param string $name     Field name attribute
     * @param string $class    Slider class attribute
     * @param string $meta_val Field value attribute
     * 
     * @return string          Input slider HTML
     */
    public static function load_range_slider($name, $class = '', $meta_val = '') {
        $id = str_replace('_', '-', $name);
        $meta_val_color = $meta_val;
        if ($meta_val == '') {
            $meta_val_color = 0;
        }
        ?>
        <div class="cbdb-slider <?php echo $class; ?>">
            <input type="range" class="cbdb-slider-output" value="<?php esc_attr_e($meta_val_color); ?>">
            <input type="hidden" name="<?php esc_attr_e('cbdb_' . $name); ?>" id="<?php esc_attr_e('cbdb-' . $id); ?>" value="<?php esc_attr_e($meta_val); ?>">
            <div class="cbdb-slider-val">
                <span></span>
                <input type="number" min="0" max="100" class="range-slider__value" value="<?php esc_attr_e($meta_val); ?>" autocomplete="off">
            </div>
        </div>
        <?php
    }

    /**
     * Initialize an array of all font weight.
     * 
     * @since 1.0
     * 
     * @param string $font_weight Selected font weight
     * 
     * @return string             Font weight dropdown options HTML
     */
    public static function load_font_weight($font_weight) {
        $font_weight_arr = array('' => '--Select--', '100' => '100', '200' => '200', '300' => '300', '400' => '400', '500' => '500', '600' => '600',
            '700' => '700', '800' => '800', '900' => '900', 'normal' => 'Normal', 'bold' => 'Bold', 'bolder' => 'Bolder', 'lighter' => 'Lighter');
        foreach ($font_weight_arr as $key => $value) {
            ?>
            <option class="cbdb-option" value="<?php esc_attr_e($key); ?>" <?php selected($font_weight, $key); ?>><?php esc_html_e($value, CBDB_TEXTDOMAIN); ?></option>
            <?php
        }
    }

    /**
     * Initialize an array of all font style.
     * 
     * @since 1.0
     * 
     * @param string $font_style Selected font style
     * 
     * @return string            Font style dropdown options HTML
     */
    public static function load_font_style($font_style) {
        $font_style_arr = array('' => '--Select--', 'normal' => 'Normal', 'italic' => 'Italic', 'oblique' => 'Oblique');
        foreach ($font_style_arr as $key => $value) {
            ?>
            <option class="cbdb-option" value="<?php esc_attr_e($key); ?>" <?php selected($font_style, $key); ?>><?php esc_html_e($value, CBDB_TEXTDOMAIN); ?></option>
            <?php
        }
    }

    /**
     * Initialize an array of all text transform.
     * 
     * @since 1.0
     * 
     * @param string $text_transform Selected text transform
     * 
     * @return string                Text transform dropdown options HTML
     */
    public static function load_text_transform($text_transform) {
        $text_transform_arr = array('' => '--Select--', 'none' => 'None', 'capitalize' => 'Capitalize', 'uppercase' => 'Uppercase', 'lowercase' => 'Lowercase');
        foreach ($text_transform_arr as $key => $value) {
            ?>
            <option class="cbdb-option" value="<?php esc_attr_e($key); ?>" <?php selected($text_transform, $key); ?>><?php esc_html_e($value, CBDB_TEXTDOMAIN); ?></option>
            <?php
        }
    }

    /**
     * Initialize an array of all text decoration.
     * 
     * @since 1.0
     * 
     * @param string $text_decoration Selected text decoration
     * 
     * @return string                 Text decoration dropdown options HTML
     */
    public static function load_text_decoration($text_decoration) {
        $text_decoration_arr = array('' => '--Select--', 'none' => 'None', 'overline' => 'Overline', 'line-through' => 'Line Through', 'underline' => 'Underline', 'underline overline' => 'Underline Overline');
        foreach ($text_decoration_arr as $key => $value) {
            ?>
            <option class="cbdb-option" value="<?php esc_attr_e($key); ?>" <?php selected($text_decoration, $key); ?>><?php esc_html_e($value, CBDB_TEXTDOMAIN); ?></option>
            <?php
        }
    }

    /**
     * Initialize input type number field.
     * @since 1.0
     * 
     * @param array $input Contains input class, step, min, max
     * 
     * @return string      Input field number HTML
     */
    public static function load_input_number_field($input) {
        $class = $step = $min = $max = '';
        if (isset($input['class']) && trim($input['class']) != '') {
            $class = 'class="' . esc_attr($input['class']) . '"';
        }
        if (isset($input['step']) && trim($input['step']) != '') {
            $step = 'step="' . esc_attr($input['step']) . '"';
        }
        if (isset($input['min']) && trim($input['min']) != '') {
            $min = 'min="' . esc_attr($input['min']) . '"';
        }
        if (isset($input['max']) && trim($input['max']) != '') {
            $max = 'max="' . esc_attr($input['max']) . '"';
        }
        ?>
        <div class="cbdb-minus-plus-wrapper">
            <input type="number" name="<?php esc_attr_e('cbdb_' . $input['name']); ?>" id="<?php esc_attr_e('cbdb-' . $input['id']); ?>" <?php echo $class . ' ' . $step . ' ' . $min . ' ' . $max; ?> value="<?php esc_attr_e($input['value']); ?>">
            <div class="cbdb-minus-plus">
                <span class="cbdb-plus">+</span>
                <span class="cbdb-minus">-</span>
            </div>
        </div>
        <?php
    }

    /**
     * Initialize an array of all date formats.
     * 
     * @since 1.0
     * 
     * @param string $date_format Selected date format
     * 
     * @return string             Date format dropdown options HTML
     */
    public static function load_date_format($date_format) {
        $text_decoration_arr = array('M j, Y' => 'M j, Y', 'Y-m-d' => 'Y-m-d', 'm/d/Y' => 'm/d/Y', 'd/m/Y' => 'd/m/Y');
        foreach ($text_decoration_arr as $key => $value) {
            ?>
            <option class="cbdb-option" value="<?php esc_attr_e($key); ?>" <?php selected($date_format, $key); ?>>
                <?php echo current_time($key) . ' (' . esc_html($value) . ')'; ?>
            </option>
            <?php
        }
    }

    /**
     * Initialize spacing unit. Margin, padding, border units px, em, %, rem.
     * 
     * @since 1.0
     * 
     * @param string $name     Field name attribute
     * @param string $space    Space type for name attribute
     * @param string $meta_val Field value attribute
     * 
     * @return string          Margin, padding, border units HTML
     */
    public static function load_spacing_unit($name, $space, $meta_val) {
        $space_arr = array('px' => 'px', 'em' => 'em', '%' => 'per', 'rem' => 'rem');
        $id = str_replace('_', '-', $name);
        foreach ($space_arr as $key => $value) {
            ?>
            <input type="radio" name="<?php esc_attr_e('cbdb_' . $name . '_' . $space . '_unit'); ?>" id="<?php esc_attr_e('cbdb-' . $id . '-' . $space . '-' . $key); ?>" class="cbdb-d-none" value="<?php esc_attr_e($key); ?>" <?php checked($meta_val, $key); ?>>
            <label for="<?php esc_attr_e('cbdb-' . $id . '-' . $space . '-' . $key); ?>" class="<?php esc_attr_e('cbdb-' . $key . '-label'); ?>"><?php esc_html_e($key, CBDB_TEXTDOMAIN); ?></label>
            <?php
        }
    }

    /**
     * Initialize spacing values. Margin, padding, border direction top, right, bottom, left.
     * 
     * @since 1.0
     * 
     * @param string $name      Field name attribute
     * @param string $space     Space type for name attribute
     * @param string $space_val Field value attribute
     * 
     * @return string          Margin, padding, border direction HTML
     */
    public static function load_spacing_val($name, $space, $space_val) {
        $space_type_arr = array('top' => 'Top', 'right' => 'Right', 'bottom' => 'Bottom', 'left' => 'Left');
        $id = str_replace('_', '-', $name);
        $min = '';
        if ($space == 'border') {
            $min = 'min="' . esc_attr(0) . '"';
        }
        foreach ($space_type_arr as $key => $value) {
            ?>
            <li class="cbdb-dimension">
                <input type="number" name="<?php esc_attr_e('cbdb_' . $name . '_' . $space . '_' . $key); ?>" id="<?php esc_attr_e('cbdb-' . $id . '-' . $space . '-' . $key); ?>" step="1" <?php echo $min; ?> value="<?php esc_attr_e($space_val[$key]); ?>">
                <label for="<?php esc_attr_e('cbdb-' . $id . '-' . $space . '-' . $key); ?>" class="<?php esc_attr_e('cbdb-' . $key . '-label'); ?>"><?php esc_html_e($value, CBDB_TEXTDOMAIN); ?></label>
            </li>
            <?php
        }
    }

    /**
     * Initialize color field.
     * @since 1.0
     * 
     * @param array $colors Field name attribute (name, id, color value, default color)
     * 
     * @return string       Input field color HTML
     */
    public static function load_color_field($colors) {
        ?>
        <input type="text" name="<?php esc_attr_e('cbdb_' . $colors['name'] . '_color'); ?>" id="<?php esc_attr_e('cbdb-' . $colors['id'] . '-color'); ?>" class="cbdb-color-field" value="<?php esc_attr_e($colors['val']); ?>" data-default-color="<?php esc_attr_e($colors['default']); ?>">
        <?php
    }

    /**
     * Initialize box shadow field.
     * 
     * @since 1.0
     * 
     * @param string $name      Field name attribute
     * @param string $id        Field id attribute
     * @param array  $positions Field value attribute for positions
     * 
     * @return string           Input field box shadow HTML
     */
    public static function load_box_shadow_field($name, $id, $positions) {
        $positions_arr = array('h-offset' => 'H-Offset', 'v-offset' => 'V-Offset', 'blur' => 'Blur');
        foreach ($positions_arr as $key => $value) {
            $key_name = str_replace('-', '_', $key);
            ?>
            <div class="cbdb-line-height cbdb-box-shadow-width">
                <label class="cbdb-typography-settings-label" for="<?php esc_attr_e('cbdb-' . $id . '-box-shadow-position-' . $key); ?>"><?php esc_html_e($value . ' (px)', CBDB_TEXTDOMAIN); ?></label>
                <div class="cbdb-minus-plus-wrapper">
                    <input type="number" name="<?php esc_attr_e('cbdb_' . $name . '_box_shadow_position_' . $key_name); ?>" class="cbdb-input-number" id="<?php esc_attr_e('cbdb-' . $id . '-box-shadow-position-' . $key); ?>" value="<?php esc_attr_e($positions[$key_name]); ?>" step="1">
                    <div class="cbdb-minus-plus">
                        <span class="cbdb-plus">+</span>
                        <span class="cbdb-minus">-</span>
                    </div>
                </div>
            </div>
            <?php
        }
    }

    /**
     * Initialize color field.
     * 
     * @since 1.0
     * 
     * @param string $border_style Selected border style
     * 
     * @return string              Border style options HTML
     */
    public static function load_border_style($border_style) {
        $border_style_arr = array('' => '--Select--', 'none' => 'None', 'hidden' => 'Hidden', 'dotted' => 'Dotted', 'dashed' => 'Dashed', 'solid' => 'Solid',
            'double' => 'Double', 'groove' => 'Groove', 'ridge' => 'Ridge', 'inset' => 'Inset', 'outset' => 'Outset');
        foreach ($border_style_arr as $key => $value) {
            ?>
            <option class="cbdb-option" value="<?php esc_attr_e($key); ?>" <?php selected($border_style, $key); ?>><?php esc_html_e($value, CBDB_TEXTDOMAIN); ?></option>
            <?php
        }
    }

}
