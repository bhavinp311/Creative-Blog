<?php

/**
 * Plugin Name:       Creative Blog Designer Bundle
 * Plugin URI:        https://www.techeshta.com/product/creative-blog-for-wordpress/
 * Description:       Creative Blog Designer Bundle for WordPress.
 * Version:           1.0
 * Author:            Techeshta
 * Author URI:        https://www.techeshta.com
 * Text Domain:       creative-blog
 */
if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

/**
 * Define some constant.
 * Plugin URL and Directory Path.
 */
define('CBDB_URL', plugins_url('/', __FILE__));  // Define Plugin URL.
define('CBDB_DIR', plugin_dir_path(__FILE__));  // Define Plugin Directory Path.
define('CBDB_TEXTDOMAIN', 'creative-blog');    // Define Plugin Textdomain.

/**
 * Plugin's main class.
 */
class Creative_Blog {

    /**
     * Main constructor.
     * The main plugin actions registered for WordPress.
     * 
     * @since 1.0
     */
    public function __construct() {
        $this->hooks();
        register_activation_hook(__FILE__, array($this, 'cbdb_function_to_run'));
        add_action('init', array($this, 'cbdb_include_files'));
    }

    /**
     * Hooks initialization.
     * 
     * @since 1.0
     */
    public function hooks() {
        add_action('plugins_loaded', array($this, 'cbdb_load_language_files'));
        add_action('admin_enqueue_scripts', array($this, 'cbdb_admin_scripts'));
        add_action('wp_enqueue_scripts', array($this, 'cbdb_frontend_scripts'));
        add_action('wp_ajax_nopriv_get_pagination_posts', array($this, 'get_pagination_posts_handler'));
        add_action('wp_ajax_get_pagination_posts', array($this, 'get_pagination_posts_handler'));
    }

    /**
     * Create a new database table on plugin activation.
     * 
     * @since 1.0
     */
    public function cbdb_function_to_run() {
        global $wpdb;

        $charset_collate = $wpdb->get_charset_collate();
        $table_name = $wpdb->prefix . "creative_blog_shortcodes";

        $sql = "CREATE TABLE IF NOT EXISTS $table_name (
          cbdb_id mediumint(9) NOT NULL AUTO_INCREMENT,
          cbdb_sc_name tinytext NOT NULL,
          cbdb_settings text NOT NULL,
          cbdb_registered datetime DEFAULT '0000-00-00 00:00:00' NOT NULL,
          PRIMARY KEY  (cbdb_id)
        ) $charset_collate;";

        require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
        dbDelta($sql);
    }

    /**
     * Load necessary files.
     * 
     * @since 1.0
     */
    public function cbdb_include_files() {
        if (is_admin()) { // Add backend action hooks
            // Include shortcode list file
            require_once(CBDB_DIR . 'admin/cbdb-admin-shortcodes-list.php');
            CBDB_Listing::get_instance(); // Get shortcode listing.
            // Include utility functions file
            require_once(CBDB_DIR . 'admin/cbdb-utility.php');
            // Include ajax actions file
            require_once(CBDB_DIR . 'admin/cbdb-admin-ajax-actions.php');
        } else { // Add non-Ajax frontend action hooks
            // Frontend include files
            // Frontend common functions file
            include(CBDB_DIR . 'inc/cbdb-common-functions.php');
            // Load shortcode file
            include(CBDB_DIR . 'inc/cbdb-display-shortcode.php');
        }
    }

    /**
     * Load plugin textdomain.
     * 
     * @since 1.0
     */
    public function cbdb_load_language_files() {
        load_plugin_textdomain(CBDB_TEXTDOMAIN, false, dirname(plugin_basename(__FILE__)) . '/languages');
    }

    /**
     * Register/Enqueue backend required css/js on plugin screens.
     * 
     * @param int $hook Hook suffix for the plugin screens.
     * @since 1.0
     */
    public function cbdb_admin_scripts($hook) {
        if ($hook == 'toplevel_page_cbdb-layouts' || $hook == 'creative-blog_page_cbdb_add_shortcode') {
            // Enqueue multiple selection dropdown style/script (select2 lib)
            wp_register_style('select2-min-style', CBDB_URL . 'admin/assets/css/select2.min.css', array(), time(), false);
            wp_enqueue_style('select2-min-style');
            wp_register_script('select2-min-script', CBDB_URL . 'admin/assets/js/select2.min.js', array('jquery'), time(), true);
            wp_enqueue_script('select2-min-script');

            // Enqueue ColorPicker style
            wp_enqueue_style('wp-color-picker');

            // Enqueue Font Awesome lib
            wp_register_script('fontawesome-icon', CBDB_URL . 'admin/assets/js/fontawesome-icon.js', array(), time(), true);
            wp_enqueue_script('fontawesome-icon');

            // WordPress media uploader scripts
            if (!did_action('wp_enqueue_media')) {
                wp_enqueue_media();
            }

            // Enqueue assets code editor for custom css
            if (function_exists('wp_enqueue_code_editor')) {
                wp_enqueue_code_editor(array('type' => 'text/css'));
            }

            // Custom media script
            wp_register_script('custom-media-script', CBDB_URL . 'admin/assets/js/custom-media-script.js', array('jquery'), time(), true);
            wp_enqueue_script('custom-media-script');

            // Backend style
            wp_register_style('admin-style', CBDB_URL . 'admin/assets/css/admin-style.css', array(), time(), false);
            wp_enqueue_style('admin-style');

            // Backend script
            wp_register_script('admin-script', CBDB_URL . 'admin/assets/js/admin-script.js', array('jquery', 'wp-color-picker'), time(), true);
            wp_localize_script('admin-script', 'admin_ajax_object', array('ajaxurl' => admin_url('admin-ajax.php'), 'pluginurl' => CBDB_URL));
            wp_enqueue_script('admin-script');
        }
    }

    /**
     * Register front end required css/js.
     * 
     * @since 1.0
     */
    public function cbdb_frontend_scripts() {
        global $post;

        // Determine whether this page contains "creative_blog" shortcode
        if (has_shortcode($post->post_content, 'creative_blog')) {
            // Load Font Awesome lib
            wp_register_script('fontawesome-icon', CBDB_URL . 'assets/js/fontawesome-icon.js', array(), time(), true);
            wp_enqueue_script('fontawesome-icon');

            // Frontend style
            // Common style
            wp_register_style('front-common-style', CBDB_URL . 'assets/css/front-common-style.css', array(), time(), false);
            wp_enqueue_style('front-common-style');

            // Grid layout style
            wp_register_style('grid-layout-style', CBDB_URL . 'assets/css/grid-layout-style.css', array(), time(), false);

            // List layout style
            wp_register_style('list-layout-style', CBDB_URL . 'assets/css/list-layout-style.css', array(), time(), false);

            // Masonry layout style
            wp_register_style('masonry-layout-style', CBDB_URL . 'assets/css/masonry-layout-style.css', array(), time(), false);

            // Slider layout style
            wp_register_style('slider-layout-style', CBDB_URL . 'assets/css/slider-layout-style.css', array(), time(), false);

            // Frontend script
            wp_register_script('frontend-script', CBDB_URL . 'assets/js/frontend-script.js', array('jquery'), time(), true);
        }
    }

    /**
     * Get more posts pagination via ajax frontend.
     * 
     * @since 1.0
     */
    public function get_pagination_posts_handler() {
        // Load front ajax action file
        require_once(CBDB_DIR . 'inc/cbdb-front-ajax-actions.php');
    }

}

/*
 * Starts our plugin class, easy!
 */
new Creative_Blog();
