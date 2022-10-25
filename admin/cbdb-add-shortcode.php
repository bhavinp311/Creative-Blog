<?php
/**
 * New layout admin setting options
 *
 * @since 1.0
 */
if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

/**
 * We're creating admin settings using HTML
 */
if (isset($_REQUEST['page']) && $_REQUEST['page'] == 'cbdb_add_shortcode') {
    // Define global WPDB object
    global $wpdb;

    // Define WPDB table name
    $cbdb_dbtable = $wpdb->prefix . 'creative_blog_shortcodes';

    // Get shortcode id
    $cbdb_id = isset($_REQUEST['cbdb_id']) ? intval($_REQUEST['cbdb_id']) : '';

    // Save/Get data
    require_once(CBDB_DIR . 'admin/cbdb-save-data.php');
    ?>
    <div class="cbdb-admin-container">
        <div class="cbdb-heading-wrapper">
            <h1 class="cbdb-main-heading">
                <?php
                echo (isset($_REQUEST['action']) && $_REQUEST['action'] == 'edit' && isset($cbdb_id)) ?
                        esc_html__('Edit Layout', CBDB_TEXTDOMAIN) : esc_html__('Add New Layout', CBDB_TEXTDOMAIN);
                ?>
            </h1>
            <?php
            if (isset($_REQUEST['action']) && $_REQUEST['action'] == 'edit' && isset($cbdb_id)) {
                ?>
                <a href="?page=cbdb_add_shortcode" target="_blank" class="cbdb-button cbdb-small-btn"><?php esc_html_e('Create New Layout', CBDB_TEXTDOMAIN); ?></a>
                <?php
            }
            ?>
        </div>
        <?php
        if (isset($_REQUEST['layout'])) {
            ?>
            <!-- Notification message -->
            <div class="cbdb-notice cbdb-notice-success cbdb-dismissible">
                <button type="button" class="cbdb-close" onclick="jQuery(this).parent().fadeOut();">&times;</button>
                <?php printf(esc_html__('Layout %s successfully.', CBDB_TEXTDOMAIN), $_REQUEST['layout']); ?>
            </div>
            <?php
        }

        // If action is add shortcode then fetch last inserted id
        if (empty($cbdb_id)) {
            $last_id = $wpdb->get_var($wpdb->prepare("SELECT cbdb_id FROM {$cbdb_dbtable} ORDER BY cbdb_id DESC LIMIT %d", 1));
            $cbdb_id = $last_id + 1;
        }

        // Get all fonts
        $font_family = CBDB_Utility::default_recognized_font_faces();
        ?>

        <!-- START form -->
        <form action="" id="cbdb-layout-form" method="post" novalidate>
            <div class="cbdb-creative-blog" id="cbdb-header">
                <!-- START title and shortcode field -->
                <div class="cbdb-container">
                    <div class="cbdb-form">
                        <h3><?php esc_html_e('Creative Blog Settings', CBDB_TEXTDOMAIN); ?></h3>
                        <div class="cbdb-form-field">
                            <?php if (isset($_REQUEST['action']) && $_REQUEST['action'] == 'edit') { ?>
                                <div class="cbdb-input-group">
                                    <input class="cbdb-code" id="cbdb-sc-field" type="text" title="<?php esc_attr_e('Copy Shortcode', CBDB_TEXTDOMAIN); ?>" value='[creative_blog id="<?php esc_attr_e($cbdb_id); ?>"]' onclick="this.select();" readonly="readonly">
                                    <div class="cbdb-input-group-btn cbdb-tooltip">
                                        <button class="cbdb-button" id="cbdb-click-copy" type="button">
                                            <span class="cbdb-tooltiptext" id="cbdb-sp-tooltip"><?php esc_html_e('Copy to clipboard', CBDB_TEXTDOMAIN); ?></span>
                                            <i class="fas fa-copy" aria-hidden="true"></i>
                                        </button>
                                    </div>
                                </div>
                            <?php } ?>
                            <button class="cbdb-button" name="cbdb_savedata" type="submit"><?php esc_html_e('Save', CBDB_TEXTDOMAIN); ?></button>
                        </div>
                    </div>
                </div>
                <!-- END title and shortcode field -->
            </div>

            <!-- START dashboard -->
            <div class="cbdb-dashboard">
                <div class="cbdb-container">
                    <div class="cbdb-tabs">
                        <!-- START left part -->
                        <nav>
                            <div class="cbdb-button-wrapper">
                                <a>
                                    <svg class="cbdb-icon-tab" width="18" height="16" viewBox="0 0 18 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M0.666687 2.16667C0.666687 1.24619 1.41288 0.5 2.33335 0.5H15.6667C16.5872 0.5 17.3334 1.24619 17.3334 2.16667V6.33333V13.8333C17.3334 14.7538 16.5872 15.5 15.6667 15.5H6.50002H2.33335C2.32976 15.5 2.32617 15.5 2.32258 15.5C1.40706 15.4942 0.666687 14.7502 0.666687 13.8333V6.33333V2.16667ZM2.33335 5.5H6.50002H15.6667V2.16667H2.33335V5.5ZM5.66669 7.16667H2.33335V13.8333H5.66669V7.16667ZM7.33335 13.8333H15.6667V7.16667H7.33335V13.8333Z" fill="black" />
                                    </svg>
                                    <span><?php esc_html_e('Layout Settings', CBDB_TEXTDOMAIN); ?></span>
                                </a>
                                <a>
                                    <svg class="cbdb-icon-tab" width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M0.5 2.06001C0.5 1.1631 1.24619 0.436005 2.16667 0.436005H5.5C6.42047 0.436005 7.16667 1.1631 7.16667 2.06001V5.30801C7.16667 6.20492 6.42047 6.93201 5.5 6.93201H2.16667C1.24619 6.93201 0.5 6.20492 0.5 5.30801V2.06001ZM5.5 2.06001H2.16667V5.30801H5.5V2.06001ZM8.83333 2.06001C8.83333 1.1631 9.57952 0.436005 10.5 0.436005H13.8333C14.7538 0.436005 15.5 1.1631 15.5 2.06001V5.30801C15.5 6.20492 14.7538 6.93201 13.8333 6.93201H10.5C9.57952 6.93201 8.83333 6.20492 8.83333 5.30801V2.06001ZM13.8333 2.06001H10.5V5.30801H13.8333V2.06001ZM0.5 10.18C0.5 9.28311 1.24619 8.55602 2.16667 8.55602H5.5C6.42047 8.55602 7.16667 9.28311 7.16667 10.18V13.428C7.16667 14.3249 6.42047 15.052 5.5 15.052H2.16667C1.24619 15.052 0.5 14.3249 0.5 13.428V10.18ZM5.5 10.18H2.16667V13.428    H5.5V10.18ZM8.83333 10.18C8.83333 9.28311 9.57952 8.55602 10.5 8.55602H13.8333C14.7538 8.55602 15.5 9.28311 15.5 10.18V13.428C15.5 14.3249 14.7538 15.052 13.8333 15.052H10.5C9.57952 15.052 8.83333 14.3249 8.83333 13.428V10.18ZM13.8333 10.18H10.5V13.428H13.8333V10.18Z" fill="black" />
                                    </svg>
                                    <span><?php esc_html_e('Post Settings', CBDB_TEXTDOMAIN); ?></span>
                                </a>
                                <a>
                                    <svg class="cbdb-icon-tab" width="18" height="18" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M9.00002 2.33333C8.53978 2.33333 8.16669 2.70643 8.16669 3.16667C8.16669 4.57688 6.46168 5.28312 5.46451 4.28595C5.13907 3.96051 4.61143 3.96051 4.286 4.28595C3.96056 4.61139 3.96056 5.13902 4.286 5.46446C5.28321 6.46167 4.57688 8.16667 3.16669 8.16667C2.70645 8.16667 2.33335 8.53976 2.33335 9C2.33335 9.46024 2.70645 9.83333 3.16669 9.83333C4.57699 9.83333 5.28305 11.5384 4.28594 12.5355C3.9605 12.861 3.9605 13.3886 4.28594 13.7141C4.61138 14.0395 5.13902 14.0395 5.46445 13.7141C6.46161 12.7169 8.16669 13.4231 8.16669 14.8333C8.16669 15.2936 8.53978 15.6667 9.00002 15.6667C9.46026 15.6667 9.83335 15.2936 9.83335 14.8333C9.83335 13.4231 11.5384 12.7169 12.5356 13.714C12.861 14.0395 13.3886 14.0395 13.7141 13.714C14.0395 13.3886 14.0395 12.861 13.7141 12.5355C12.7169 11.5384 13.4231 9.83333 14.8334 9.83333C15.2936 9.83333 15.6667 9.46024 15.6667 9C15.6667 8.53976 15.2936 8.16667 14.8334 8.16667C13.4232 8.16667 12.7168 6.46171 13.714 5.46447C14.0395 5.13904 14.0395 4.6114 13.714 4.28596C13.3886 3.96053 12.861 3.96053 12.5355 4.28596C11.5383 5.28316 9.83335 4.57683 9.83335 3.16667C9.83335 2.70643 9.46026 2.33333 9.00002 2.33333ZM6.50682 2.98086C6.60189 1.68692 7.68181 0.666668 9.00002 0.666668C10.3182 0.666668 11.3982 1.68692 11.4932 2.98086C12.4754 2.13314 13.9604 2.17534 14.8925 3.10745C15.8247 4.03957 15.8669 5.52462 15.0191 6.5068C16.3131 6.60184 17.3334 7.68177 17.3334 9C17.3334 10.3182 16.3131 11.3981 15.0192 11.4932C15.8669 12.4754 15.8247 13.9604 14.8926 14.8925C13.9605 15.8247 12.4754 15.8669 11.4932 15.0191C11.3982 16.3131 10.3182 17.3333 9.00002 17.3333C7.68179 17.3333 6.60186 16.3131 6.50682 15.0191C5.52464 15.8669 4.03956 15.8247 3.10743 14.8926C2.17531 13.9604 2.13312 12.4754 2.98087 11.4932C1.68694 11.3981 0.666687 10.3182 0.666687 9C0.666687 7.68177 1.68696 6.60184 2.98093 6.5068C2.13317 5.52462 2.17536 4.03956 3.10748 3.10744C4.0396 2.17532 5.52465 2.13313 6.50682 2.98086Z" fill="black" />
                                    <path d="M9.00002 7.33333C8.55799 7.33333 8.13407 7.50893 7.82151 7.82149C7.50895 8.13405 7.33335 8.55797 7.33335 9C7.33335 9.44203 7.50895 9.86595 7.82151 10.1785C8.13407 10.4911 8.55799 10.6667 9.00002 10.6667C9.44205 10.6667 9.86597 10.4911 10.1785 10.1785C10.4911 9.86595 10.6667 9.44203 10.6667 9C10.6667 8.55797 10.4911 8.13405 10.1785 7.82149C9.86597 7.50893 9.44205 7.33333 9.00002 7.33333ZM6.643 6.64298C7.26812 6.01786 8.11597 5.66667 9.00002 5.66667C9.88407 5.66667 10.7319 6.01786 11.357 6.64298C11.9822 7.2681 12.3334 8.11595 12.3334 9C12.3334 9.88406 11.9822 10.7319 11.357 11.357C10.7319 11.9821 9.88407 12.3333 9.00002 12.3333C8.11597 12.3333 7.26812 11.9821 6.643 11.357C6.01788 10.7319 5.66669 9.88406 5.66669 9C5.66669 8.11595 6.01788 7.2681 6.643 6.64298Z" fill="black" />
                                    </svg>
                                    <span><?php esc_html_e('General Settings', CBDB_TEXTDOMAIN); ?></span>
                                </a>
                                <a>
                                    <svg class="cbdb-icon-tab" width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M10.9167 6.33333C11.607 6.33333 12.1667 5.77369 12.1667 5.08333C12.1667 4.39298 11.607 3.83333 10.9167 3.83333C10.2263 3.83333 9.66667 4.39298 9.66667 5.08333C9.66667 5.77369 10.2263 6.33333 10.9167 6.33333Z" fill="#0D0D0D" />
                                    <path d="M0.5 2.16667C0.5 1.24619 1.24619 0.5 2.16667 0.5H13.8333C14.7538 0.5 15.5 1.24619 15.5 2.16667V13.8333C15.5 14.7538 14.7538 15.5 13.8333 15.5H2.16667C1.24619 15.5 0.5 14.7538 0.5 13.8333V2.16667ZM13.8333 2.16667H2.16667V8.76617L4.97945 6.51594C5.2838 6.27246 5.71626 6.27246 6.02061 6.51594L9.60485 9.38334L10.7441 8.24408C11.0695 7.91864 11.5972 7.91864 11.9226 8.24408L13.8333 10.1548V2.16667ZM2.16667 13.8333H13.8333V12.5118L11.3334 10.0118L10.256 11.0893C9.9557 11.3895 9.47769 11.416 9.14612 11.1507L5.50003 8.23385L2.16667 10.9005V13.8333Z" fill="#0D0D0D" />
                                    </svg>
                                    <span><?php esc_html_e('Media Settings', CBDB_TEXTDOMAIN); ?></span>
                                </a>
                                <a>
                                    <svg class="cbdb-icon-tab" width="18" height="18" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M0.666687 2.33333C0.666687 1.41286 1.41288 0.666664 2.33335 0.666664H10.6667C11.5872 0.666664 12.3334 1.41286 12.3334 2.33333V5.66666H15.6667C16.5872 5.66666 17.3334 6.41286 17.3334 7.33333V15.6667C17.3334 16.5871 16.5872 17.3333 15.6667 17.3333H7.33335C6.41288 17.3333 5.66669 16.5871 5.66669 15.6667V12.3333H2.33335C1.41288 12.3333 0.666687 11.5871 0.666687 10.6667V2.33333ZM7.33335 12.3333V15.6667H15.6667V7.33333H12.3334V10.6667C12.3334 11.5871 11.5872 12.3333 10.6667 12.3333H7.33335ZM10.6667 10.6667V2.33333L2.33335 2.33333V10.6667H10.6667Z" fill="black" />
                                    </svg>
                                    <span><?php esc_html_e('Style Settings', CBDB_TEXTDOMAIN); ?></span>
                                </a>
                                <a>
                                    <svg class="cbdb-icon-tab" width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M9.66667 2.16667C9.20643 2.16667 8.83333 1.79357 8.83333 1.33333C8.83333 0.873096 9.20643 0.5 9.66667 0.5H14.6667C14.8877 0.5 15.0996 0.587797 15.2559 0.744078C15.4122 0.900358 15.5 1.11232 15.5 1.33333L15.5 6.33333C15.5 6.79357 15.1269 7.16667 14.6667 7.16667C14.2064 7.16667 13.8333 6.79357 13.8333 6.33333L13.8333 3.34518L6.08926 11.0893C5.76382 11.4147 5.23618 11.4147 4.91074 11.0893C4.58531 10.7638 4.58531 10.2362 4.91074 9.91074L12.6548 2.16667H9.66667ZM0.5 3.83333C0.5 2.91286 1.24619 2.16667 2.16667 2.16667H6.33333C6.79357 2.16667 7.16667 2.53976 7.16667 3C7.16667 3.46024 6.79357 3.83333 6.33333 3.83333H2.16667V13.8333H12.1667V9.66667C12.1667 9.20643 12.5398 8.83333 13 8.83333C13.4602 8.83333 13.8333 9.20643 13.8333 9.66667V13.8333C13.8333 14.7538 13.0871 15.5 12.1667 15.5H2.16667C1.24619 15.5 0.5 14.7538 0.5 13.8333V3.83333Z" fill="black" />
                                    </svg>
                                    <span><?php esc_html_e('Social Share Settings', CBDB_TEXTDOMAIN); ?></span>
                                </a>
                                <a>
                                    <svg class="cbdb-icon-tab" width="14" height="4" viewBox="0 0 14 4" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M6.99998 3.66666C7.92045 3.66666 8.66665 2.92047 8.66665 1.99999C8.66665 1.07952 7.92045 0.333328 6.99998 0.333328C6.0795 0.333328 5.33331 1.07952 5.33331 1.99999C5.33331 2.92047 6.0795 3.66666 6.99998 3.66666Z" fill="#0D0D0D" />
                                    <path d="M1.99998 3.66666C2.92045 3.66666 3.66665 2.92047 3.66665 1.99999C3.66665 1.07952 2.92045 0.333328 1.99998 0.333328C1.07951 0.333328 0.333313 1.07952 0.333313 1.99999C0.333313 2.92047 1.07951 3.66666 1.99998 3.66666Z" fill="#0D0D0D" />
                                    <path d="M12 3.66666C12.9205 3.66666 13.6666 2.92047 13.6666 1.99999C13.6666 1.07952 12.9205 0.333328 12 0.333328C11.0795 0.333328 10.3333 1.07952 10.3333 1.99999C10.3333 2.92047 11.0795 3.66666 12 3.66666Z" fill="#0D0D0D" />
                                    </svg>
                                    <span><?php esc_html_e('Pagination Settings', CBDB_TEXTDOMAIN); ?></span>
                                </a>
                                <a>
                                    <svg class="cbdb-icon-tab" width="14" height="10" viewBox="0 0 14 10" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M13.6666 5.00004C13.6666 5.22106 13.5788 5.43302 13.4225 5.5893L10.0892 8.92263C9.76378 9.24807 9.23614 9.24807 8.9107 8.92263C8.58527 8.59719 8.58527 8.06956 8.9107 7.74412L11.6548 5.00004L8.9107 2.25596C8.58527 1.93053 8.58527 1.40289 8.9107 1.07745C9.23614 0.752015 9.76378 0.752015 10.0892 1.07745L13.4225 4.41079C13.5788 4.56707 13.6666 4.77903 13.6666 5.00004ZM5.08921 1.07745C5.41465 1.40289 5.41465 1.93053 5.08921 2.25596L2.34513 5.00004L5.08921 7.74412C5.41465 8.06956 5.41465 8.59719 5.08921 8.92263C4.76377 9.24807 4.23614 9.24807 3.9107 8.92263L0.577365 5.5893C0.251928 5.26386 0.251928 4.73622 0.577365 4.41078L3.9107 1.07745C4.23614 0.752015 4.76377 0.752015 5.08921 1.07745Z" fill="#0D0D0D" />
                                    </svg>
                                    <span><?php esc_html_e('Custom Settings', CBDB_TEXTDOMAIN); ?></span>
                                </a>
                            </div>
                            <input type="hidden" name="cbdb_tab_index">
                        </nav>
                        <!-- END left part -->

                        <!-- START right part -->
                        <div class="cbdb-content-wrapper">
                            <!-- START Layout Settings -->
                            <div class="cbdb-content">
                                <div class="cbdb-field cbdb-flex">
                                    <div class="cbdb-field-label cbdb-w-20">
                                        <label class="cbdb-layout-label" for="cbdb-layout-name"><?php esc_html_e('Layout Name', CBDB_TEXTDOMAIN); ?></label>
                                    </div>
                                    <div class="cbdb-minus-plus-wrapper cbdb-w-80">
                                        <input type="text" name="cbdb_layout_name" id="cbdb-layout-name" placeholder="<?php esc_html_e('Layout Name', CBDB_TEXTDOMAIN); ?>" value="<?php esc_attr_e($cbdb_layout_name); ?>">
                                    </div>
                                </div>
                                <div class="cbdb-select-wrapper cbdb-select-icon cbdb-flex">
                                    <div class="cbdb-field-label cbdb-w-20">
                                        <label class="cbdb-layout-label" for="cbdb-layout-type"><?php esc_html_e('Layout Type', CBDB_TEXTDOMAIN); ?></label>
                                    </div>
                                    <div class="cbdb-w-80">
                                        <select class="cbdb-section-width f-control f-dropdown" name="cbdb_layout_type" id="cbdb-layout-type" placeholder="<?php esc_html_e('Please properly choose layout type', CBDB_TEXTDOMAIN); ?>">
                                            <option class="cbdb-option" value="grid" data-image="<?php echo esc_url(CBDB_URL . 'admin/assets/images/grid.png'); ?>" <?php selected($cbdb_layout_type, 'grid'); ?>><?php esc_html_e('Grid', CBDB_TEXTDOMAIN); ?></option>
                                            <option class="cbdb-option" value="list" data-image="<?php echo esc_url(CBDB_URL . 'admin/assets/images/list.png'); ?>" <?php selected($cbdb_layout_type, 'list'); ?>><?php esc_html_e('List', CBDB_TEXTDOMAIN); ?></option>
                                            <option class="cbdb-option" value="masonry" data-image="<?php echo esc_url(CBDB_URL . 'admin/assets/images/masonry.png'); ?>" <?php selected($cbdb_layout_type, 'masonry'); ?>><?php esc_html_e('Masonry', CBDB_TEXTDOMAIN); ?></option>
                                            <option class="cbdb-option" value="slider" data-image="<?php echo esc_url(CBDB_URL . 'admin/assets/images/slider.png'); ?>" <?php selected($cbdb_layout_type, 'slider'); ?>><?php esc_html_e('Slider', CBDB_TEXTDOMAIN); ?></option>
                                        </select>
                                        <input type="hidden" name="cbdb_layout_type_title" id="cbdb-layout-type_label" value="<?php esc_html_e($cbdb_layout_type); ?>">
                                    </div>
                                </div>
                                <div class="cbdb-select-wrapper cbdb-flex">
                                    <div class="cbdb-field-label cbdb-w-20">
                                        <label class="cbdb-layout-label" for="cbdb-layout-preview"><?php esc_html_e('Layout with Preview', CBDB_TEXTDOMAIN); ?></label>
                                    </div>
                                    <div class="cbdb-w-80">
                                        <select class="cbdb-section-layout cbdb-section-width" name="cbdb_layout_preview" id="cbdb-layout-preview">
                                            <?php echo CBDB_Utility::layout_preview_options($cbdb_layout_type, $cbdb_layout_preview); ?>
                                        </select>
                                        <input type="hidden" name="cbdb_layout_preview_title" id="cbdb-layout-preview_label" value="<?php esc_html_e($cbdb_layout_preview); ?>">
                                    </div>
                                </div>

                                <div class="cbdb-blog-wrapper">
                                    <div class="cbdb-blog cbdb-w-20"></div>
                                    <div class="cbdb-layout-screenshots cbdb-w-80">
                                        <img class="cbdb-blog-image" src="<?php echo esc_url(CBDB_URL . 'admin/assets/images/layouts/' . $cbdb_layout_type . '/' . $cbdb_layout_preview . '.jpg'); ?>" alt="<?php esc_attr_e($cbdb_layout_type . '-' . $cbdb_layout_preview); ?>">
                                    </div>
                                </div>
                                <div class="cbdb-field cbdb-flex">
                                    <div class="cbdb-field-label cbdb-w-20">
                                        <label class="cbdb-layout-label" for="cbdb-number-post"><?php esc_html_e('Display Number of Post', CBDB_TEXTDOMAIN); ?></label>
                                    </div>
                                    <div class="cbdb-w-80">
                                        <?php CBDB_Utility::load_input_number_field(array('name' => 'number_post', 'id' => 'number-post', 'class' => 'cbdb-input-width', 'step' => 1, 'min' => 1, 'max' => 100, 'value' => $cbdb_number_post)); ?>
                                        <span class="cbdb-field-description"><?php esc_html_e('Leave blank if you want to display all posts.', CBDB_TEXTDOMAIN); ?></span>
                                    </div>
                                </div>

                                <div class="cbdb-field cbdb-flex">
                                    <div class="cbdb-field-label cbdb-w-20">
                                        <label class="cbdb-layout-label" for="cbdb-desktop-col"><?php esc_html_e('Desktop Column', CBDB_TEXTDOMAIN); ?></label>
                                    </div>
                                    <div class="cbdb-w-80">
                                        <?php CBDB_Utility::load_input_number_field(array('name' => 'desktop_col', 'id' => 'desktop-col', 'class' => 'cbdb-input-width', 'step' => 1, 'min' => 1, 'max' => 6, 'value' => $cbdb_desktop_col)); ?>
                                    </div>
                                </div>

                                <div class="cbdb-field cbdb-flex">
                                    <div class="cbdb-field-label cbdb-w-20">
                                        <label class="cbdb-layout-label" for="cbdb-ipad-tab-col"><?php esc_html_e('iPad/Tablet Column', CBDB_TEXTDOMAIN); ?></label>
                                    </div>
                                    <div class="cbdb-w-80">
                                        <?php CBDB_Utility::load_input_number_field(array('name' => 'ipad_tab_col', 'id' => 'ipad-tab-col', 'class' => 'cbdb-input-width', 'step' => 1, 'min' => 1, 'max' => 6, 'value' => $cbdb_ipad_tab_col)); ?>
                                    </div>
                                </div>

                                <div class="cbdb-field cbdb-flex">
                                    <div class="cbdb-field-label cbdb-w-20">
                                        <label class="cbdb-layout-label" for="cbdb-mobile-col"><?php esc_html_e('Mobile Column', CBDB_TEXTDOMAIN); ?></label>
                                    </div>
                                    <div class="cbdb-w-80">
                                        <?php CBDB_Utility::load_input_number_field(array('name' => 'mobile_col', 'id' => 'mobile-col', 'class' => 'cbdb-input-width', 'step' => 1, 'min' => 1, 'max' => 3, 'value' => $cbdb_mobile_col)); ?>
                                    </div>
                                </div>

                                <div class="cbdb-separator cbdb-flex">
                                    <div class="cbdb-field-label cbdb-w-20">
                                        <label class="cbdb-layout-label" for="cbdb-grid-layout"><?php esc_html_e('Layout Gap', CBDB_TEXTDOMAIN); ?></label>
                                    </div>
                                    <div class="cbdb-control-field cbdb-w-80">
                                        <div class="cbdb-control-wrapper cbdb-row-wrapper <?php if ($cbdb_layout_type == 'masonry') echo 'cbdb-d-none'; ?>">
                                            <div class="cbdb-title-text">
                                                <label for="title" class="cbdb-control-title"><?php esc_html_e('Row Gap', CBDB_TEXTDOMAIN); ?></label>
                                                <div class="cbdb-units-choices">
                                                    <?php CBDB_Utility::load_spacing_unit('row_gap', 'layout', $cbdb_row_gap_layout_unit); ?>
                                                </div>
                                            </div>
                                            <div class="cbdb-block">
                                                <?php CBDB_Utility::load_range_slider('row_gap', '', $cbdb_row_gap); ?>
                                            </div>
                                        </div>
                                        <div class="cbdb-control-wrapper cbdb-grid-wrapper <?php if ($cbdb_layout_type == 'list') echo 'cbdb-d-none'; ?>">
                                            <div class="cbdb-title-text">
                                                <label for="title" class="cbdb-control-title"><?php esc_html_e('Column Gap', CBDB_TEXTDOMAIN); ?></label>
                                                <div class="cbdb-advanced-wrapper">
                                                    <?php CBDB_Utility::load_spacing_unit('grid_gap', 'layout', $cbdb_grid_gap_layout_unit); ?>
                                                </div>
                                            </div>
                                            <div class="cbdb-block">
                                                <?php CBDB_Utility::load_range_slider('grid_gap', '', $cbdb_grid_gap); ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- END Layout Settings -->

                            <!-- START Post Settings -->
                            <div class="cbdb-content">
                                <div class="cbdb-select-wrapper cbdb-flex">
                                    <div class="cbdb-field-label cbdb-w-20">
                                        <label class="cbdb-layout-label" for="cbdb-post-type"><?php esc_html_e('Post Type', CBDB_TEXTDOMAIN); ?></label>
                                    </div>
                                    <div class="cbdb-w-80">
                                        <select class="cbdb-section-layout" name="cbdb_post_type" id="cbdb-post-type" data-id="<?php echo esc_attr(isset($_REQUEST['cbdb_id']) ? $_REQUEST['cbdb_id'] : ''); ?>">
                                            <?php
                                            $args = array('public' => true);
                                            $post_types = get_post_types($args, 'objects');
                                            // Remove page and media post types
                                            unset($post_types['page'], $post_types['attachment']);
                                            if ($post_types) {
                                                foreach ($post_types as $post_type_obj) {
                                                    $labels = get_post_type_labels($post_type_obj);
                                                    ?>
                                                    <option class="cbdb-option" value="<?php esc_attr_e($post_type_obj->name); ?>" <?php selected($cbdb_post_type, $post_type_obj->name); ?>>
                                                        <?php esc_html_e($labels->name, CBDB_TEXTDOMAIN); ?></option>
                                                    <?php
                                                }
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>

                                <div class="cbdb-select-wrapper cbdb-select-margin cbdb-flex">
                                    <div class="cbdb-field-label cbdb-w-20">
                                        <label class="cbdb-layout-label" for="cbdb-post-categories"><?php esc_html_e('Post Categories', CBDB_TEXTDOMAIN); ?></label>
                                    </div>
                                    <div class="cbdb-w-80">
                                        <select multiple class="chosen-select cbdb-select2" name="cbdb_post_categories[]" id="cbdb-post-categories">
                                            <?php
                                            // Get a list of available taxonomies for a post type
                                            $taxonomies = get_taxonomies(['object_type' => [$cbdb_post_type]]);
                                            // Set category and tag index
                                            $catIndex = 1;
                                            if ($cbdb_post_type == 'product') {
                                                $catIndex = 2;
                                            }
                                            $cnt = 1;
                                            // Loop over your taxonomies
                                            foreach ($taxonomies as $taxonomy) {
                                                if ($cnt == $catIndex) { // For category
                                                    // Retrieve all available terms, including those not yet used
                                                    $terms = get_terms(['taxonomy' => $taxonomy, 'hide_empty' => false]);
                                                    foreach ($terms as $term) {
                                                        $selected = '';
                                                        // For category
                                                        if (is_array($cbdb_post_categories) && in_array($term->slug, $cbdb_post_categories)) {
                                                            $selected = 'selected="selected"';
                                                        }
                                                        echo '<option value="' . $term->slug . '" ' . $selected . '>' . esc_html($term->name, CBDB_TEXTDOMAIN) . '</option>';
                                                    }
                                                }
                                                $cnt++;
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>

                                <div class="cbdb-checkbox-wrapper cbdb-flex">
                                    <div class="cbdb-checkbox-width cbdb-field-label cbdb-w-20"></div>
                                    <div class="cbdb-checkbox cbdb-w-80">
                                        <input type="checkbox" id="cbdb-exclude-categories" name="cbdb_exclude_categories" value="yes" <?php checked($cbdb_exclude_categories, 'yes'); ?>>
                                        <label class="text-typography" for="cbdb-exclude-categories"><?php esc_html_e('Exclude Selected Categories', CBDB_TEXTDOMAIN); ?></label>
                                    </div>
                                </div>

                                <div class="cbdb-select-wrapper cbdb-select-margin cbdb-flex">
                                    <div class="cbdb-field-label cbdb-w-20">
                                        <label class="cbdb-layout-label" for="cbdb-post-tags"><?php esc_html_e('Post Tags', CBDB_TEXTDOMAIN); ?></label>
                                    </div>
                                    <div class="cbdb-w-80">
                                        <select multiple class="chosen-select cbdb-select2" name="cbdb_post_tags[]" id="cbdb-post-tags">
                                            <?php
                                            // Get a list of available taxonomies for a post type
                                            $taxonomies = get_taxonomies(['object_type' => [$cbdb_post_type]]);
                                            // Set category and tag index
                                            $tagIndex = 2;
                                            if ($cbdb_post_type == 'product') {
                                                $tagIndex = 3;
                                            }
                                            $cnt = 1;
                                            // Loop over your taxonomies
                                            foreach ($taxonomies as $taxonomy) {
                                                if ($cnt == $tagIndex) { // For tag
                                                    // Retrieve all available terms, including those not yet used
                                                    $terms = get_terms(['taxonomy' => $taxonomy, 'hide_empty' => false]);
                                                    foreach ($terms as $term) {
                                                        $selected = '';
                                                        // For category
                                                        if (is_array($cbdb_post_tags) && in_array($term->slug, $cbdb_post_tags)) {
                                                            $selected = 'selected="selected"';
                                                        }
                                                        echo '<option value="' . $term->slug . '" ' . $selected . '>' . esc_html($term->name, CBDB_TEXTDOMAIN) . '</option>';
                                                    }
                                                }
                                                $cnt++;
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>

                                <div class="cbdb-checkbox-wrapper cbdb-flex">
                                    <div class="cbdb-checkbox-width cbdb-field-label cbdb-w-20"></div>
                                    <div class="cbdb-checkbox bdb-w-80">
                                        <input type="checkbox" id="cbdb-exclude-tags" name="cbdb_exclude_tags" value="yes" <?php checked($cbdb_exclude_tags, 'yes'); ?>>
                                        <label class="text-typography" for="cbdb-exclude-tags"><?php esc_html_e('Exclude Selected Tags', CBDB_TEXTDOMAIN); ?></label>
                                    </div>
                                </div>

                                <div class="cbdb-select-wrapper cbdb-select-margin cbdb-flex">
                                    <div class="cbdb-field-label cbdb-w-20">
                                        <label class="cbdb-layout-label" for="cbdb-post-authors"><?php esc_html_e('Post Authors', CBDB_TEXTDOMAIN); ?></label>
                                    </div>
                                    <div class="cbdb-w-80">
                                        <select multiple class="chosen-select cbdb-select2" name="cbdb_post_authors[]" id="cbdb-post-authors">
                                            <?php
                                            $blogusers = get_users('orderby=nicename&order=asc');
                                            foreach ($blogusers as $user) {
                                                ?>
                                                <option value="<?php esc_attr_e($user->ID); ?>"
                                                <?php
                                                if (isset($cbdb_post_authors) && !empty($cbdb_post_authors) && in_array($user->ID, $cbdb_post_authors)) {
                                                    echo 'selected="selected"';
                                                }
                                                ?>>
                                                            <?php esc_html_e($user->display_name); ?>
                                                </option>
                                                <?php
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>

                                <div class="cbdb-checkbox-wrapper cbdb-flex">
                                    <div class="cbdb-checkbox-width cbdb-field-label cbdb-w-20"></div>
                                    <div class="cbdb-checkbox cbdb-w-80">
                                        <input type="checkbox" id="cbdb-exclude-authors" name="cbdb_exclude_authors" value="yes" <?php checked($cbdb_exclude_authors, 'yes'); ?>>
                                        <label class="text-typography" for="cbdb-exclude-authors"><?php esc_html_e('Exclude Selected Authors', CBDB_TEXTDOMAIN); ?></label>
                                    </div>
                                </div>

                                <div class="cbdb-select-wrapper cbdb-flex">
                                    <div class="cbdb-field-label cbdb-w-20">
                                        <label class="cbdb-layout-label" for="cbdb-order-by"><?php esc_html_e('Order By', CBDB_TEXTDOMAIN); ?></label>
                                    </div>
                                    <div class="cbdb-w-80">
                                        <select class="cbdb-section-layout" name="cbdb_order_by" id="cbdb-order-by">
                                            <option value="rand" <?php selected($cbdb_order_by, 'rand'); ?>><?php esc_html_e('Random', CBDB_TEXTDOMAIN); ?></option>
                                            <option value="ID" <?php selected($cbdb_order_by, 'ID'); ?>><?php esc_html_e('Post ID', CBDB_TEXTDOMAIN); ?></option>
                                            <option value="author" <?php selected($cbdb_order_by, 'author'); ?>><?php esc_html_e('Author', CBDB_TEXTDOMAIN); ?></option>
                                            <option value="title" <?php selected($cbdb_order_by, 'title'); ?>><?php esc_html_e('Post Title', CBDB_TEXTDOMAIN); ?></option>
                                            <option value="name" <?php selected($cbdb_order_by, 'name'); ?>><?php esc_html_e('Post Slug', CBDB_TEXTDOMAIN); ?></option>
                                            <option value="date" <?php selected($cbdb_order_by, 'date'); ?>><?php esc_html_e('Publish Date', CBDB_TEXTDOMAIN); ?></option>
                                            <option value="modified" <?php selected($cbdb_order_by, 'modified'); ?>><?php esc_html_e('Modified Date', CBDB_TEXTDOMAIN); ?></option>
                                        </select>
                                    </div>
                                </div>
                                <div class="cbdb-select-wrapper cbdb-flex">
                                    <div class="cbdb-field-label cbdb-w-20">
                                        <label class="cbdb-layout-label" for="cbdb-order">Order</label>
                                    </div>
                                    <div class="cbdb-w-80">
                                        <select class="cbdb-section-layout" name="cbdb_order" id="cbdb-order">
                                            <option class="cbdb-option" value="ASC" <?php selected($cbdb_order, 'ASC'); ?>><?php esc_html_e('Ascending', CBDB_TEXTDOMAIN); ?></option>
                                            <option class="cbdb-option" value="DESC" <?php selected($cbdb_order, 'DESC'); ?>><?php esc_html_e('Descending', CBDB_TEXTDOMAIN); ?></option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <!-- END Post Settings -->

                            <!-- START General Settings -->
                            <div class="cbdb-content">
                                <!-- START Post Title Settings -->
                                <h3 class="cbdb-post-title"><?php esc_html_e('Post Title Settings', CBDB_TEXTDOMAIN); ?></h3>
                                <div class="cbdb-select-wrapper cbdb-flex">
                                    <div class="cbdb-field-label cbdb-w-20">
                                        <label class="cbdb-layout-label" for="cbdb-post-title"><?php esc_html_e('Post Title', CBDB_TEXTDOMAIN); ?></label>
                                    </div>
                                    <div class="cbdb-enable-disable cbdb-w-80">
                                        <?php CBDB_Utility::post_enable_disable('post_title', 'post-title', $cbdb_post_title); ?>
                                    </div>
                                </div>

                                <div class="cbdb-post-title-switch <?php if ($cbdb_post_title == 0) echo 'cbdb-d-none'; ?>">
                                    <div class="cbdb-select-wrapper cbdb-flex">
                                        <div class="cbdb-field-label cbdb-w-20">
                                            <label class="cbdb-layout-label" for="cbdb-heading-tag"><?php esc_html_e('Heading Tag', CBDB_TEXTDOMAIN); ?></label>
                                        </div>
                                        <div class="cbdb-w-80">
                                            <select class="cbdb-section-layout cbdb-section-minus-width" name="cbdb_heading_tag" id="cbdb-heading-tag">
                                                <option class="cbdb-option" value="h1" <?php selected($cbdb_heading_tag, 'h1'); ?>><?php esc_html_e('H1', CBDB_TEXTDOMAIN); ?></option>
                                                <option class="cbdb-option" value="h2" <?php selected($cbdb_heading_tag, 'h2'); ?>><?php esc_html_e('H2', CBDB_TEXTDOMAIN); ?></option>
                                                <option class="cbdb-option" value="h3" <?php selected($cbdb_heading_tag, 'h3'); ?>><?php esc_html_e('H3', CBDB_TEXTDOMAIN); ?></option>
                                                <option class="cbdb-option" value="h4" <?php selected($cbdb_heading_tag, 'h4'); ?>><?php esc_html_e('H4', CBDB_TEXTDOMAIN); ?></option>
                                                <option class="cbdb-option" value="h5" <?php selected($cbdb_heading_tag, 'h5'); ?>><?php esc_html_e('H5', CBDB_TEXTDOMAIN); ?></option>
                                                <option class="cbdb-option" value="h6" <?php selected($cbdb_heading_tag, 'h6'); ?>><?php esc_html_e('H6', CBDB_TEXTDOMAIN); ?></option>
                                            </select>
                                        </div>
                                    </div>

                                    <h4 class="cbdb-typography-settings-title"><?php esc_html_e('Typography Settings', CBDB_TEXTDOMAIN); ?></h4>
                                    <div class="cbdb-select-wrapper cbdb-typography-wrapper cbdb-flex">
                                        <div class="cbdb-font-family-wrapper">
                                            <div class="cbdb-field-label">
                                                <label class="cbdb-typography-settings-label" for="cbdb-post-title-font-family"><?php esc_html_e('Font Family', CBDB_TEXTDOMAIN); ?></label>
                                            </div>
                                            <div class="select cbdb-width-family">
                                                <select class="chosen-select cbdb-select2" name="cbdb_post_title_font_family" id="cbdb-post-title-font-family">
                                                    <option value=""><?php esc_html_e('--Select--', CBDB_TEXTDOMAIN); ?></option>
                                                    <?php
                                                    $old_version = '';
                                                    $cnt = 0;
                                                    foreach ($font_family as $key => $value) {
                                                        if ($value['version'] != $old_version) {
                                                            if ($cnt > 0) {
                                                                echo '</optgroup>';
                                                            }
                                                            echo '<optgroup label="' . esc_attr($value['version']) . '">';
                                                            $old_version = $value['version'];
                                                        }
                                                        echo "<option value='" . esc_attr(str_replace('"', '', $value['label'])) . "'";
                                                        if ('' != $cbdb_post_title_font_family && ( str_replace('"', '', $cbdb_post_title_font_family) == str_replace('"', '', $value['label']) )) {
                                                            echo ' selected="selected"';
                                                        }
                                                        echo '>' . esc_html__($value['label'], CBDB_TEXTDOMAIN) . '</option>';
                                                        $cnt++;
                                                    }
                                                    if ($cnt == count($font_family)) {
                                                        echo '</optgroup>';
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="cbdb-font-size-wrapper">
                                            <div class="cbdb-title-text cbdb-margin-right cbdb-field-label">
                                                <label for="cbdb-post-title-font-size" class="cbdb-typography-settings-label"><?php esc_html_e('Font Size (px)', CBDB_TEXTDOMAIN); ?></label>
                                            </div>
                                            <div class="cbdb-block">
                                                <?php CBDB_Utility::load_range_slider('post_title_font_size', 'cbdb-slider-right', $cbdb_post_title_font_size); ?>
                                            </div>
                                        </div>

                                        <div class="cbdb-typography-wrapper">
                                            <div class="cbdb-field-label">
                                                <label class="cbdb-typography-settings-label" for="cbdb-post-title-font-weight"><?php esc_html_e('Font Weight', CBDB_TEXTDOMAIN); ?></label>
                                            </div>
                                            <select class="cbdb-section-layout" name="cbdb_post_title_font_weight" id="cbdb-post-title-font-weight">
                                                <?php CBDB_Utility::load_font_weight($cbdb_post_title_font_weight); ?>
                                            </select>
                                        </div>

                                        <div class="cbdb-line-height">
                                            <div class="cbdb-field-label">
                                                <label class="cbdb-typography-settings-label" for="cbdb-post-title-line-height"><?php esc_html_e('Line Height (px)', CBDB_TEXTDOMAIN); ?></label>
                                            </div>
                                            <?php CBDB_Utility::load_input_number_field(array('name' => 'post_title_line_height', 'id' => 'post-title-line-height', 'class' => 'cbdb-input-number', 'step' => 1, 'min' => 0, 'max' => '', 'value' => $cbdb_post_title_line_height)); ?>
                                        </div>
                                    </div>

                                    <div class="cbdb-select-wrapper cbdb-typography-wrapper cbdb-flex">
                                        <div class="cbdb-font-family-wrapper">
                                            <div class="cbdb-field-label">
                                                <label class="cbdb-typography-settings-label" for="cbdb-post-title-font-style"><?php esc_html_e('Font Style', CBDB_TEXTDOMAIN); ?></label>
                                            </div>
                                            <select class="cbdb-section-layout" name="cbdb_post_title_font_style" id="cbdb-post-title-font-style">
                                                <?php CBDB_Utility::load_font_style($cbdb_post_title_font_style); ?>
                                            </select>
                                        </div>

                                        <div class="cbdb-typography-wrapper">
                                            <div class="cbdb-field-label">
                                                <label class="cbdb-typography-settings-label" for="cbdb-post_title-text-transform"><?php esc_html_e('Text Transform', CBDB_TEXTDOMAIN); ?></label>
                                            </div>
                                            <select class="cbdb-section-layout" name="cbdb_post_title_text_transform" id="cbdb-post_title-text-transform">
                                                <?php CBDB_Utility::load_text_transform($cbdb_post_title_text_transform); ?>
                                            </select>
                                        </div>

                                        <div class="cbdb-typography-wrapper">
                                            <div class="cbdb-field-label">
                                                <label class="cbdb-typography-settings-label" for="cbdb-post-title-text-decoration"><?php esc_html_e('Text Decoration', CBDB_TEXTDOMAIN); ?></label>
                                            </div>
                                            <select class="cbdb-section-layout" name="cbdb_post_title_text_decoration" id="cbdb-post-title-text-decoration">
                                                <?php CBDB_Utility::load_text_decoration($cbdb_post_title_text_decoration); ?>
                                            </select>
                                        </div>

                                        <div class="cbdb-line-height">
                                            <div class="cbdb-field-label">
                                                <label class="cbdb-typography-settings-label" for="cbdb-post-title-letter-spacing"><?php esc_html_e('Letter Spacing (px)', CBDB_TEXTDOMAIN); ?></label>
                                            </div>
                                            <?php CBDB_Utility::load_input_number_field(array('name' => 'post_title_letter_spacing', 'id' => 'post-title-letter-spacing', 'class' => 'cbdb-input-number', 'step' => 1, 'min' => '', 'max' => '', 'value' => $cbdb_post_title_letter_spacing)); ?>
                                        </div>
                                    </div>

                                    <div class="cbdb-select-wrapper cbdb-flex">
                                        <div class="cbdb-field-label cbdb-w-20">
                                            <label class="cbdb-layout-label" for="cbdb-post-title-link"><?php esc_html_e('Post Title Link', CBDB_TEXTDOMAIN); ?></label>
                                        </div>
                                        <div class="cbdb-yes-no cbdb-w-80">
                                            <?php CBDB_Utility::post_link_yes_no('post_title_link', 'post-title-link', $cbdb_post_title_link); ?>
                                        </div>
                                    </div>

                                    <div class="cbdb-select-wrapper cbdb-flex cbdb-post-title-switch <?php if ($cbdb_post_title_link == 'no') echo 'cbdb-d-none'; ?>">
                                        <div class="cbdb-field-label cbdb-w-20">
                                            <label class="cbdb-layout-label" for="cbdb-post-title-open-link"><?php esc_html_e('Post Title Open Link', CBDB_TEXTDOMAIN); ?></label>
                                        </div>
                                        <div class="cbdb-current-tab-new-tab cbdb-w-80">
                                            <input id="cbdb-post-title-current-tab" class="cbdb-d-none" type="radio" name="cbdb_post_title_open_link" value="_self" <?php checked($cbdb_post_title_open_link, '_self'); ?>>
                                            <label class="cbdb-units-choices-current-tab" for="cbdb-post-title-current-tab"><?php esc_html_e('Current Tab', CBDB_TEXTDOMAIN); ?></label>

                                            <input id="cbdb-post-title-new-tab" class="cbdb-d-none" type="radio" name="cbdb_post_title_open_link" value="_blank" <?php checked($cbdb_post_title_open_link, '_blank'); ?>>
                                            <label class="cbdb-units-choices-new-tab" for="cbdb-post-title-new-tab"><?php esc_html_e('New Tab', CBDB_TEXTDOMAIN); ?></label>
                                        </div>
                                    </div>

                                    <div class="cbdb-margin-control-field-wrapper cbdb-flex">
                                        <div class="cbdb-margin-control-field">
                                            <div class="cbdb-margin-control-wrapper">
                                                <div class="cbdb-advanced-wrapper">
                                                    <?php CBDB_Utility::load_spacing_unit('post_title', 'margin', $cbdb_post_title_margin_unit); ?>
                                                </div>
                                            </div>
                                            <div class="cbdb-control-input-wrapper">
                                                <label
                                                    class="cbdb-margin-control-title"><?php esc_html_e('Margin', CBDB_TEXTDOMAIN); ?></label>
                                                <ul class="cbdb-control-dimensions">
                                                    <?php CBDB_Utility::load_spacing_val('post_title', 'margin', $cbdb_post_title_margin_arr); ?>
                                                </ul>
                                            </div>
                                        </div>

                                        <div class="cbdb-margin-control-field">
                                            <div class="cbdb-margin-control-wrapper">
                                                <div class="cbdb-advanced-wrapper">
                                                    <?php CBDB_Utility::load_spacing_unit('post_title', 'padding', $cbdb_post_title_padding_unit); ?>
                                                </div>
                                            </div>

                                            <div class="cbdb-control-input-wrapper">
                                                <label class="cbdb-margin-control-title"><?php esc_html_e('Padding', CBDB_TEXTDOMAIN); ?></label>
                                                <ul class="cbdb-control-dimensions">
                                                    <?php CBDB_Utility::load_spacing_val('post_title', 'padding', $cbdb_post_title_padding_arr); ?>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- END Post Title Settings -->
                                <hr class="cbdb-section-separator">
                                <!-- START Post Content Settings -->
                                <h3 class="cbdb-post-title"><?php esc_html_e('Post Content Settings', CBDB_TEXTDOMAIN); ?></h3>
                                <div class="cbdb-select-wrapper cbdb-flex">
                                    <div class="cbdb-field-label cbdb-w-20">
                                        <label class="cbdb-layout-label" for="cbdb-post-content"><?php esc_html_e('Post Content', CBDB_TEXTDOMAIN); ?></label>
                                    </div>
                                    <div class="cbdb-enable-disable cbdb-w-80">
                                        <?php CBDB_Utility::post_enable_disable('post_content', 'post-content', $cbdb_post_content); ?>
                                    </div>
                                </div>

                                <div class="cbdb-post-content-switch <?php if ($cbdb_post_content == 0) echo 'cbdb-d-none'; ?>">
                                    <h4 class="cbdb-typography-settings-title"><?php esc_html_e('Typography Settings', CBDB_TEXTDOMAIN); ?></h4>
                                    <div class="cbdb-select-wrapper cbdb-typography-wrapper cbdb-flex">
                                        <div class="cbdb-font-family-wrapper">
                                            <div class="cbdb-field-label">
                                                <label class="cbdb-typography-settings-label" for="cbdb-post-content-font-family"><?php esc_html_e('Font Family', CBDB_TEXTDOMAIN); ?></label>
                                            </div>
                                            <div class="select">
                                                <select class="chosen-select cbdb-select2" name="cbdb_post_content_font_family" id="cbdb-post-content_font-family">
                                                    <option value=""><?php esc_html_e('--Select--', CBDB_TEXTDOMAIN); ?></option>
                                                    <?php
                                                    $old_version = '';
                                                    $cnt = 0;
                                                    foreach ($font_family as $key => $value) {
                                                        if ($value['version'] != $old_version) {
                                                            if ($cnt > 0) {
                                                                echo '</optgroup>';
                                                            }
                                                            echo '<optgroup label="' . esc_attr($value['version']) . '">';
                                                            $old_version = $value['version'];
                                                        }
                                                        echo "<option value='" . esc_attr(str_replace('"', '', $value['label'])) . "'";
                                                        if ('' != $cbdb_post_content_font_family && ( str_replace('"', '', $cbdb_post_content_font_family) == str_replace('"', '', $value['label']) )) {
                                                            echo ' selected="selected"';
                                                        }
                                                        echo '>' . esc_html__($value['label'], CBDB_TEXTDOMAIN) . '</option>';
                                                        $cnt++;
                                                    }
                                                    if ($cnt == count($font_family)) {
                                                        echo '</optgroup>';
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="cbdb-font-size-wrapper">
                                            <div class="cbdb-title-text cbdb-margin-right cbdb-field-label">
                                                <label for="cbdb-post-content-font-size" class="cbdb-typography-settings-label"><?php esc_html_e('Font Size (px)', CBDB_TEXTDOMAIN); ?></label>
                                            </div>
                                            <div class="cbdb-block">
                                                <?php CBDB_Utility::load_range_slider('post_content_font_size', 'cbdb-slider-right', $cbdb_post_content_font_size); ?>
                                            </div>
                                        </div>
                                        <div class="cbdb-typography-wrapper">
                                            <div class="cbdb-field-label">
                                                <label class="cbdb-typography-settings-label" for="cbdb-post-content-font-weight"><?php esc_html_e('Font Weight', CBDB_TEXTDOMAIN); ?></label>
                                            </div>
                                            <select class="cbdb-section-layout" name="cbdb_post_content_font_weight" id="cbdb-post-content-font-weight">
                                                <?php CBDB_Utility::load_font_weight($cbdb_post_content_font_weight); ?>
                                            </select>
                                        </div>
                                        <div class="cbdb-line-height">
                                            <div class="cbdb-field-label">
                                                <label class="cbdb-typography-settings-label" for="cbdb-post-content-line-height"><?php esc_html_e('Line Height (px)', CBDB_TEXTDOMAIN); ?></label>
                                            </div>
                                            <?php CBDB_Utility::load_input_number_field(array('name' => 'post_content_line_height', 'id' => 'post-content-line-height', 'class' => 'cbdb-input-number', 'step' => 1, 'min' => 0, 'max' => '', 'value' => $cbdb_post_content_line_height)); ?>
                                        </div>
                                    </div>

                                    <div class="cbdb-select-wrapper cbdb-typography-wrapper cbdb-flex">
                                        <div class="cbdb-font-family-wrapper">
                                            <div class="cbdb-field-label">
                                                <label class="cbdb-typography-settings-label" for="cbdb-post-content-font-style"><?php esc_html_e('Font Style', CBDB_TEXTDOMAIN); ?></label>
                                            </div>
                                            <select class="cbdb-section-layout" name="cbdb_post_content_font_style" id="cbdb-post-content-font-style">
                                                <?php CBDB_Utility::load_font_style($cbdb_post_content_font_style); ?>
                                            </select>
                                        </div>
                                        <div class="cbdb-typography-wrapper">
                                            <div class="cbdb-field-label">
                                                <label class="cbdb-typography-settings-label" for="cbdb-post-content-text-transform"><?php esc_html_e('Text Transform', CBDB_TEXTDOMAIN); ?></label>
                                            </div>
                                            <select class="cbdb-section-layout" name="cbdb_post_content_text_transform" id="cbdb-post-content-text-transform">
                                                <?php CBDB_Utility::load_text_transform($cbdb_post_content_text_transform); ?>
                                            </select>
                                        </div>
                                        <div class="cbdb-typography-wrapper">
                                            <div class="cbdb-field-label">
                                                <label class="cbdb-typography-settings-label" for="cbdb-post-content-text-decoration"><?php esc_html_e('Text Decoration', CBDB_TEXTDOMAIN); ?></label>
                                            </div>
                                            <select class="cbdb-section-layout" name="cbdb_post_content_text_decoration" id="cbdb-post-content-text-decoration">
                                                <?php CBDB_Utility::load_text_decoration($cbdb_post_content_text_decoration); ?>
                                            </select>
                                        </div>
                                        <div class="cbdb-line-height">
                                            <div class="cbdb-field-label">
                                                <label class="cbdb-typography-settings-label" for="cbdb-post-content-letter-spacing"><?php esc_html_e('Letter Spacing (px)', CBDB_TEXTDOMAIN); ?></label>
                                            </div>
                                            <?php CBDB_Utility::load_input_number_field(array('name' => 'post_content_letter_spacing', 'id' => 'post-content-letter-spacing', 'class' => 'cbdb-input-number', 'step' => 1, 'min' => '', 'max' => '', 'value' => $cbdb_post_content_letter_spacing)); ?>
                                        </div>
                                    </div>
                                    <div class="cbdb-field cbdb-flex">
                                        <div class="cbdb-field-label cbdb-w-20">
                                            <label class="cbdb-typography-settings-label" for="cbdb-post-content-length"><?php _e('Post Content Length (In Words)', CBDB_TEXTDOMAIN); ?></label>
                                        </div>
                                        <div class="cbdb-w-80">
                                            <?php CBDB_Utility::load_input_number_field(array('name' => 'post_content_length', 'id' => 'post-content-length', 'class' => 'cbdb-input-number', 'step' => 10, 'min' => 10, 'max' => '', 'value' => $cbdb_post_content_length)); ?>
                                        </div>
                                    </div>

                                    <div class="cbdb-margin-control-field-wrapper cbdb-flex">
                                        <div class="cbdb-margin-control-field">
                                            <div class="cbdb-margin-control-wrapper">
                                                <div class="cbdb-advanced-wrapper">
                                                    <?php CBDB_Utility::load_spacing_unit('post_content', 'margin', $cbdb_post_content_margin_unit); ?>
                                                </div>
                                            </div>

                                            <div class="cbdb-control-input-wrapper">
                                                <label class="cbdb-margin-control-title"><?php esc_html_e('Margin', CBDB_TEXTDOMAIN); ?></label>
                                                <ul class="cbdb-control-dimensions">
                                                    <?php CBDB_Utility::load_spacing_val('post_content', 'margin', $cbdb_post_content_margin_arr); ?>
                                                </ul>
                                            </div>
                                        </div>

                                        <div class="cbdb-margin-control-field">
                                            <div class="cbdb-margin-control-wrapper">
                                                <div class="cbdb-advanced-wrapper">
                                                    <?php CBDB_Utility::load_spacing_unit('post_content', 'padding', $cbdb_post_content_padding_unit); ?>
                                                </div>
                                            </div>

                                            <div class="cbdb-control-input-wrapper">
                                                <label class="cbdb-margin-control-title"><?php esc_html_e('Padding', CBDB_TEXTDOMAIN); ?></label>
                                                <ul class="cbdb-control-dimensions">
                                                    <?php CBDB_Utility::load_spacing_val('post_content', 'padding', $cbdb_post_content_padding_arr); ?>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- END Post Content Settings -->
                                <hr class="cbdb-section-separator">
                                <!-- START Post Date Settings -->
                                <h3 class="cbdb-post-title"><?php esc_html_e('Post Date Settings', CBDB_TEXTDOMAIN); ?></h3>
                                <div class="cbdb-select-wrapper cbdb-flex">
                                    <div class="cbdb-field-label cbdb-w-20">
                                        <label class="cbdb-layout-label" for="cbdb-post-date"><?php esc_html_e('Post Date', CBDB_TEXTDOMAIN); ?></label>
                                    </div>
                                    <div class="cbdb-enable-disable cbdb-w-80">
                                        <?php CBDB_Utility::post_enable_disable('post_date', 'post-date', $cbdb_post_date); ?>
                                    </div>
                                </div>

                                <div class="cbdb-post-date-switch <?php if ($cbdb_post_date == 0) echo 'cbdb-d-none'; ?>">
                                    <div class="cbdb-select-wrapper cbdb-flex">
                                        <div class="cbdb-field-label cbdb-w-20">
                                            <label class="cbdb-layout-label" for="cbdb-post-date-format"><?php esc_html_e('Post Date Format', CBDB_TEXTDOMAIN); ?></label>
                                        </div>
                                        <div class="cbdb-w-80">
                                            <select class="cbdb-section-layout cbdb-section-minus-width" name="cbdb_post_date_format" id="cbdb-post-date-format">
                                                <?php CBDB_Utility::load_date_format($cbdb_post_date_format); ?>
                                            </select>
                                        </div>
                                    </div>

                                    <h4 class="cbdb-typography-settings-title"><?php esc_html_e('Typography Settings', CBDB_TEXTDOMAIN); ?></h4>
                                    <div class="cbdb-select-wrapper cbdb-typography-wrapper cbdb-flex">
                                        <div class="cbdb-font-family-wrapper">
                                            <div class="cbdb-field-label">
                                                <label class="cbdb-typography-settings-label" for="cbdb-post-date-font-family"><?php esc_html_e('Font Family', CBDB_TEXTDOMAIN); ?></label>
                                            </div>
                                            <div class="select">
                                                <select class="chosen-select cbdb-select2" name="cbdb_post_date_font_family" id="cbdb-post-date-font-family">
                                                    <option value=""><?php esc_html_e('--Select--', CBDB_TEXTDOMAIN); ?></option>
                                                    <?php
                                                    $old_version = '';
                                                    $cnt = 0;
                                                    foreach ($font_family as $key => $value) {
                                                        if ($value['version'] != $old_version) {
                                                            if ($cnt > 0) {
                                                                echo '</optgroup>';
                                                            }
                                                            echo '<optgroup label="' . esc_attr($value['version']) . '">';
                                                            $old_version = $value['version'];
                                                        }
                                                        echo "<option value='" . esc_attr(str_replace('"', '', $value['label'])) . "'";
                                                        if ('' != $cbdb_post_date_font_family && ( str_replace('"', '', $cbdb_post_date_font_family) == str_replace('"', '', $value['label']) )) {
                                                            echo ' selected="selected"';
                                                        }
                                                        echo '>' . esc_html__($value['label'], CBDB_TEXTDOMAIN) . '</option>';
                                                        $cnt++;
                                                    }
                                                    if ($cnt == count($font_family)) {
                                                        echo '</optgroup>';
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="cbdb-font-size-wrapper">
                                            <div class="cbdb-title-text cbdb-margin-right cbdb-field-label">
                                                <label for="cbdb-post-date-font-size" class="cbdb-typography-settings-label"><?php esc_html_e('Font Size (px)', CBDB_TEXTDOMAIN); ?></label>
                                            </div>
                                            <div class="cbdb-block">
                                                <?php CBDB_Utility::load_range_slider('post_date_font_size', 'cbdb-slider-right', $cbdb_post_date_font_size); ?>
                                            </div>
                                        </div>

                                        <div class="cbdb-typography-wrapper">
                                            <div class="cbdb-field-label">
                                                <label class="cbdb-typography-settings-label" for="cbdb-post-date-font-weight"><?php esc_html_e('Font Weight', CBDB_TEXTDOMAIN); ?></label>
                                            </div>
                                            <select class="cbdb-section-layout" name="cbdb_post_date_font_weight" id="cbdb-post-date-font-weight">
                                                <?php CBDB_Utility::load_font_weight($cbdb_post_date_font_weight); ?>
                                            </select>
                                        </div>

                                        <div class="cbdb-line-height">
                                            <div class="cbdb-field-label">
                                                <label class="cbdb-typography-settings-label" for="cbdb-post-date-line-height"><?php esc_html_e('Line Height (px)', CBDB_TEXTDOMAIN); ?></label>
                                            </div>
                                            <?php CBDB_Utility::load_input_number_field(array('name' => 'post_date_line_height', 'id' => 'post-date-line-height', 'class' => 'cbdb-input-number', 'step' => 1, 'min' => 0, 'max' => '', 'value' => $cbdb_post_date_line_height)); ?>
                                        </div>
                                    </div>

                                    <div class="cbdb-select-wrapper cbdb-typography-wrapper cbdb-flex">
                                        <div class="cbdb-font-family-wrapper">
                                            <div class="cbdb-field-label">
                                                <label class="cbdb-typography-settings-label" for="cbdb-post-date-font-style"><?php esc_html_e('Font Style', CBDB_TEXTDOMAIN); ?></label>
                                            </div>
                                            <select class="cbdb-section-layout" name="cbdb_post_date_font_style" id="cbdb-post-date-font-style">
                                                <?php CBDB_Utility::load_font_style($cbdb_post_date_font_style); ?>
                                            </select>
                                        </div>

                                        <div class="cbdb-typography-wrapper">
                                            <div class="cbdb-field-label">
                                                <label class="cbdb-typography-settings-label" for="cbdb-post-date-text-transform"><?php esc_html_e('Text Transform', CBDB_TEXTDOMAIN); ?></label>
                                            </div>
                                            <select class="cbdb-section-layout" name="cbdb_post_date_text_transform" id="cbdb-post-date-text-transform">
                                                <?php CBDB_Utility::load_text_transform($cbdb_post_date_text_transform); ?>
                                            </select>
                                            </select>
                                        </div>

                                        <div class="cbdb-typography-wrapper">
                                            <div class="cbdb-field-label">
                                                <label class="cbdb-typography-settings-label" for="cbdb-post-date-text-decoration"><?php esc_html_e('Text Decoration', CBDB_TEXTDOMAIN); ?></label>
                                            </div>
                                            <select class="cbdb-section-layout" name="cbdb_post_date_text_decoration" id="cbdb-post-date-text-decoration">
                                                <?php CBDB_Utility::load_text_decoration($cbdb_post_date_text_decoration); ?>
                                            </select>
                                        </div>

                                        <div class="cbdb-line-height">
                                            <div class="cbdb-field-label">
                                                <label class="cbdb-typography-settings-label" for="cbdb-post-date-letter-spacing"><?php esc_html_e('Letter Spacing (px)', CBDB_TEXTDOMAIN); ?></label>
                                            </div>
                                            <?php CBDB_Utility::load_input_number_field(array('name' => 'post_date_letter_spacing', 'id' => 'post-date-letter-spacing', 'class' => 'cbdb-input-number', 'step' => 1, 'min' => '', 'max' => '', 'value' => $cbdb_post_date_letter_spacing)); ?>
                                        </div>
                                    </div>

                                    <div class="cbdb-select-wrapper cbdb-flex">
                                        <div class="cbdb-field-label cbdb-w-20">
                                            <label class="cbdb-layout-label" for="cbdb-post-date-link"><?php esc_html_e('Post Date Link', CBDB_TEXTDOMAIN); ?></label>
                                        </div>
                                        <div class="cbdb-yes-no cbdb-w-80">
                                            <?php CBDB_Utility::post_link_yes_no('post_date_link', 'post-date-link', $cbdb_post_date_link); ?>
                                        </div>
                                    </div>

                                    <div class="cbdb-margin-control-field-wrapper cbdb-flex">
                                        <div class="cbdb-margin-control-field">
                                            <div class="cbdb-margin-control-wrapper">
                                                <div class="cbdb-advanced-wrapper">
                                                    <?php CBDB_Utility::load_spacing_unit('post_date', 'margin', $cbdb_post_date_margin_unit); ?>
                                                </div>
                                            </div>

                                            <div class="cbdb-control-input-wrapper">
                                                <div class="cbdb-field-label">
                                                    <label class="cbdb-margin-control-title"><?php esc_html_e('Margin', CBDB_TEXTDOMAIN); ?></label>
                                                </div>
                                                <ul class="cbdb-control-dimensions">
                                                    <?php CBDB_Utility::load_spacing_val('post_date', 'margin', $cbdb_post_date_margin_arr); ?>
                                                </ul>
                                            </div>
                                        </div>

                                        <div class="cbdb-margin-control-field">
                                            <div class="cbdb-margin-control-wrapper">
                                                <div class="cbdb-advanced-wrapper">
                                                    <?php CBDB_Utility::load_spacing_unit('post_date', 'padding', $cbdb_post_date_padding_unit); ?>
                                                </div>
                                            </div>

                                            <div class="cbdb-control-input-wrapper">
                                                <div class="cbdb-field-label">
                                                    <label class="cbdb-margin-control-title"><?php esc_html_e('Padding', CBDB_TEXTDOMAIN); ?></label>
                                                </div>
                                                <ul class="cbdb-control-dimensions">
                                                    <?php CBDB_Utility::load_spacing_val('post_date', 'padding', $cbdb_post_date_padding_arr); ?>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- END Post Date Settings -->
                                <hr class="cbdb-section-separator">
                                <!-- START Post Category Settings -->
                                <h3 class="cbdb-post-title"><?php esc_html_e('Post Category Settings', CBDB_TEXTDOMAIN); ?></h3>
                                <div class="cbdb-select-wrapper cbdb-flex">
                                    <div class="cbdb-field-label cbdb-w-20">
                                        <label class="cbdb-layout-label" for="cbdb-post-cat"><?php esc_html_e('Post Category', CBDB_TEXTDOMAIN); ?></label>
                                    </div>
                                    <div class="cbdb-enable-disable cbdb-w-80">
                                        <?php CBDB_Utility::post_enable_disable('post_cat', 'post-cat', $cbdb_post_cat); ?>
                                    </div>
                                </div>

                                <div class="cbdb-post-cat-switch <?php if ($cbdb_post_cat == 0) echo 'cbdb-d-none'; ?>">
                                    <h4 class="cbdb-typography-settings-title"><?php esc_html_e('Typography Settings', CBDB_TEXTDOMAIN); ?></h4>
                                    <div class="cbdb-select-wrapper cbdb-typography-wrapper cbdb-flex">
                                        <div class="cbdb-font-family-wrapper">
                                            <div class="cbdb-field-label">
                                                <label class="cbdb-typography-settings-label" for="cbdb-post-cat-font-family"><?php esc_html_e('Font Family', CBDB_TEXTDOMAIN); ?></label>
                                            </div>
                                            <div class="select">
                                                <select class="chosen-select cbdb-select2" name="cbdb_post_cat_font_family" id="cbdb-post-cat-font-family">
                                                    <option value=""><?php esc_html_e('--Select--', CBDB_TEXTDOMAIN); ?></option>
                                                    <?php
                                                    $old_version = '';
                                                    $cnt = 0;
                                                    foreach ($font_family as $key => $value) {
                                                        if ($value['version'] != $old_version) {
                                                            if ($cnt > 0) {
                                                                echo '</optgroup>';
                                                            }
                                                            echo '<optgroup label="' . esc_attr($value['version']) . '">';
                                                            $old_version = $value['version'];
                                                        }
                                                        echo "<option value='" . esc_attr(str_replace('"', '', $value['label'])) . "'";
                                                        if ('' != $cbdb_post_cat_font_family && ( str_replace('"', '', $cbdb_post_cat_font_family) == str_replace('"', '', $value['label']) )) {
                                                            echo ' selected="selected"';
                                                        }
                                                        echo '>' . esc_html__($value['label'], CBDB_TEXTDOMAIN) . '</option>';
                                                        $cnt++;
                                                    }
                                                    if ($cnt == count($font_family)) {
                                                        echo '</optgroup>';
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="cbdb-font-size-wrapper">
                                            <div class="cbdb-title-text cbdb-margin-right cbdb-field-label">
                                                <label for="cbdb-post-cat-font-size" class="cbdb-typography-settings-label"><?php esc_html_e('Font Size (px)', CBDB_TEXTDOMAIN); ?></label>
                                            </div>
                                            <div class="cbdb-block">
                                                <?php CBDB_Utility::load_range_slider('post_cat_font_size', 'cbdb-slider-right', $cbdb_post_cat_font_size); ?>
                                            </div>
                                        </div>

                                        <div class="cbdb-typography-wrapper">
                                            <div class="cbdb-field-label">
                                                <label class="cbdb-typography-settings-label"
                                                       for="cbdb-post-cat-font-weight"><?php esc_html_e('Font Weight', CBDB_TEXTDOMAIN); ?></label>
                                            </div>
                                            <select class="cbdb-section-layout" name="cbdb_post_cat_font_weight" id="cbdb-post-cat-font-weight">
                                                <?php CBDB_Utility::load_font_weight($cbdb_post_cat_font_weight); ?>
                                            </select>
                                        </div>

                                        <div class="cbdb-line-height">
                                            <div class="cbdb-field-label">
                                                <label class="cbdb-typography-settings-label" for="cbdb-post-cat-line-height"><?php esc_html_e('Line Height (px)', CBDB_TEXTDOMAIN); ?></label>
                                            </div>
                                            <?php CBDB_Utility::load_input_number_field(array('name' => 'post_cat_line_height', 'id' => 'post-cat-line-height', 'class' => 'cbdb-input-number', 'step' => 1, 'min' => 0, 'max' => '', 'value' => $cbdb_post_cat_line_height)); ?>
                                        </div>
                                    </div>

                                    <div class="cbdb-select-wrapper cbdb-typography-wrapper cbdb-flex">
                                        <div class="cbdb-font-family-wrapper">
                                            <div class="cbdb-field-label">
                                                <label class="cbdb-typography-settings-label" for="cbdb-post-cat-font-style"><?php esc_html_e('Font Style', CBDB_TEXTDOMAIN); ?></label>
                                            </div>
                                            <select class="cbdb-section-layout" name="cbdb_post_cat_font_style" id="cbdb-post-cat-font-style">
                                                <?php CBDB_Utility::load_font_style($cbdb_post_cat_font_style); ?>
                                            </select>
                                        </div>

                                        <div class="cbdb-typography-wrapper">
                                            <div class="cbdb-field-label">
                                                <label class="cbdb-typography-settings-label" for="cbdb-post-cat-text-transform"><?php esc_html_e('Text Transform', CBDB_TEXTDOMAIN); ?></label>
                                            </div>
                                            <select class="cbdb-section-layout" name="cbdb_post_cat_text_transform" id="cbdb-post-cat-text-transform">
                                                <?php CBDB_Utility::load_text_transform($cbdb_post_cat_text_transform); ?>
                                            </select>
                                            </select>
                                        </div>

                                        <div class="cbdb-typography-wrapper">
                                            <div class="cbdb-field-label">
                                                <label class="cbdb-typography-settings-label" for="cbdb-post-cat-text-decoration"><?php esc_html_e('Text Decoration', CBDB_TEXTDOMAIN); ?></label>
                                            </div>
                                            <select class="cbdb-section-layout" name="cbdb_post_cat_text_decoration" id="cbdb-post-cat-text-decoration">
                                                <?php CBDB_Utility::load_text_decoration($cbdb_post_cat_text_decoration); ?>
                                            </select>
                                        </div>

                                        <div class="cbdb-line-height">
                                            <div class="cbdb-field-label">
                                                <label class="cbdb-typography-settings-label" for="cbdb-post-cat-letter-spacing"><?php esc_html_e('Letter Spacing (px)', CBDB_TEXTDOMAIN); ?></label>
                                            </div>
                                            <?php CBDB_Utility::load_input_number_field(array('name' => 'post_cat_letter_spacing', 'id' => 'post-cat-letter-spacing', 'class' => 'cbdb-input-number', 'step' => 1, 'min' => '', 'max' => '', 'value' => $cbdb_post_cat_letter_spacing)); ?>
                                        </div>
                                    </div>
                                    <div class="cbdb-select-wrapper cbdb-flex">
                                        <div class="cbdb-field-label cbdb-w-20">
                                            <label class="cbdb-layout-label" for="cbdb-post-cat-link"><?php esc_html_e('Post Category Link', CBDB_TEXTDOMAIN); ?></label>
                                        </div>
                                        <div class="cbdb-yes-no cbdb-w-80">
                                            <?php CBDB_Utility::post_link_yes_no('post_cat_link', 'post-cat-link', $cbdb_post_cat_link); ?>
                                        </div>
                                    </div>

                                    <div class="cbdb-margin-control-field-wrapper cbdb-flex">
                                        <div class="cbdb-margin-control-field">
                                            <div class="cbdb-margin-control-wrapper">
                                                <div class="cbdb-advanced-wrapper">
                                                    <?php CBDB_Utility::load_spacing_unit('post_cat', 'margin', $cbdb_post_cat_margin_unit); ?>
                                                </div>
                                            </div>

                                            <div class="cbdb-control-input-wrapper">
                                                <div class="cbdb-field-label">
                                                    <label class="cbdb-margin-control-title"><?php esc_html_e('Margin', CBDB_TEXTDOMAIN); ?></label>
                                                </div>
                                                <ul class="cbdb-control-dimensions">
                                                    <?php CBDB_Utility::load_spacing_val('post_cat', 'margin', $cbdb_post_cat_margin_arr); ?>
                                                </ul>
                                            </div>
                                        </div>

                                        <div class="cbdb-margin-control-field">
                                            <div class="cbdb-margin-control-wrapper">
                                                <div class="cbdb-advanced-wrapper">
                                                    <?php CBDB_Utility::load_spacing_unit('post_cat', 'padding', $cbdb_post_cat_padding_unit); ?>
                                                </div>
                                            </div>

                                            <div class="cbdb-control-input-wrapper">
                                                <div class="cbdb-field-label">
                                                    <label class="cbdb-margin-control-title"><?php esc_html_e('Padding', CBDB_TEXTDOMAIN); ?></label>
                                                </div>
                                                <ul class="cbdb-control-dimensions">
                                                    <?php CBDB_Utility::load_spacing_val('post_cat', 'padding', $cbdb_post_cat_padding_arr); ?>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- END Post Category Settings -->
                                <hr class="cbdb-section-separator">
                                <!-- START Post Tag Settings -->
                                <h3 class="cbdb-post-title"><?php esc_html_e('Post Tag Settings', CBDB_TEXTDOMAIN); ?></h3>
                                <div class="cbdb-select-wrapper cbdb-flex">
                                    <div class="cbdb-field-label cbdb-w-20">
                                        <label class="cbdb-layout-label" for="cbdb-post-tag"><?php esc_html_e('Post Tag', CBDB_TEXTDOMAIN); ?></label>
                                    </div>
                                    <div class="cbdb-enable-disable  cbdb-w-80">
                                        <?php CBDB_Utility::post_enable_disable('post_tag', 'post-tag', $cbdb_post_tag); ?>
                                    </div>
                                </div>

                                <div class="cbdb-post-tag-switch <?php if ($cbdb_post_tag == 0) echo 'cbdb-d-none'; ?>">
                                    <h4 class="cbdb-typography-settings-title"><?php esc_html_e('Typography Settings', CBDB_TEXTDOMAIN); ?></h4>
                                    <div class="cbdb-select-wrapper cbdb-typography-wrapper cbdb-flex">
                                        <div class="cbdb-font-family-wrapper">
                                            <div class="cbdb-field-label">
                                                <label class="cbdb-typography-settings-label" for="cbdb-post-tag-font-family"><?php esc_html_e('Font Family', CBDB_TEXTDOMAIN); ?></label>
                                            </div>
                                            <div class="select">
                                                <select class="chosen-select cbdb-select2" name="cbdb_post_tag_font_family" id="cbdb-post-tag-font-family">
                                                    <option value=""><?php esc_html_e('--Select--', CBDB_TEXTDOMAIN); ?></option>
                                                    <?php
                                                    $old_version = '';
                                                    $cnt = 0;
                                                    foreach ($font_family as $key => $value) {
                                                        if ($value['version'] != $old_version) {
                                                            if ($cnt > 0) {
                                                                echo '</optgroup>';
                                                            }
                                                            echo '<optgroup label="' . esc_attr($value['version']) . '">';
                                                            $old_version = $value['version'];
                                                        }
                                                        echo "<option value='" . esc_attr(str_replace('"', '', $value['label'])) . "'";
                                                        if ('' != $cbdb_post_tag_font_family && ( str_replace('"', '', $cbdb_post_tag_font_family) == str_replace('"', '', $value['label']) )) {
                                                            echo ' selected="selected"';
                                                        }
                                                        echo '>' . esc_html__($value['label'], CBDB_TEXTDOMAIN) . '</option>';
                                                        $cnt++;
                                                    }
                                                    if ($cnt == count($font_family)) {
                                                        echo '</optgroup>';
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="cbdb-font-size-wrapper">
                                            <div class="cbdb-title-text cbdb-margin-right cbdb-field-label">
                                                <label for="cbdb-post-tag-font-size" class="cbdb-typography-settings-label"><?php esc_html_e('Font Size (px)', CBDB_TEXTDOMAIN); ?></label>
                                            </div>
                                            <div class="cbdb-block">
                                                <?php CBDB_Utility::load_range_slider('post_tag_font_size', 'cbdb-slider-right', $cbdb_post_tag_font_size); ?>
                                            </div>
                                        </div>

                                        <div class="cbdb-typography-wrapper">
                                            <div class="cbdb-field-label">
                                                <label class="cbdb-typography-settings-label" for="cbdb-post-tag-font-weight"><?php esc_html_e('Font Weight', CBDB_TEXTDOMAIN); ?></label>
                                            </div>
                                            <select class="cbdb-section-layout" name="cbdb_post_tag_font_weight" id="cbdb-post-tag-font-weight">
                                                <?php CBDB_Utility::load_font_weight($cbdb_post_tag_font_weight); ?>
                                            </select>
                                        </div>

                                        <div class="cbdb-line-height">
                                            <div class="cbdb-field-label">
                                                <label class="cbdb-typography-settings-label" for="cbdb-post-tag-line-height"><?php esc_html_e('Line Height (px)', CBDB_TEXTDOMAIN); ?></label>
                                            </div>
                                            <?php CBDB_Utility::load_input_number_field(array('name' => 'post_tag_line_height', 'id' => 'post-tag-line-height', 'class' => 'cbdb-input-number', 'step' => 1, 'min' => 0, 'max' => '', 'value' => $cbdb_post_tag_line_height)); ?>
                                        </div>
                                    </div>

                                    <div class="cbdb-select-wrapper cbdb-typography-wrapper cbdb-flex">
                                        <div class="cbdb-font-family-wrapper">
                                            <div class="cbdb-field-label">
                                                <label class="cbdb-typography-settings-label" for="cbdb-post-tag-font-style"><?php esc_html_e('Font Style', CBDB_TEXTDOMAIN); ?></label>
                                            </div>
                                            <select class="cbdb-section-layout" name="cbdb_post_tag_font_style" id="cbdb-post-tag-font-style">
                                                <?php CBDB_Utility::load_font_style($cbdb_post_tag_font_style); ?>
                                            </select>
                                        </div>

                                        <div class="cbdb-typography-wrapper">
                                            <div class="cbdb-field-label">
                                                <label class="cbdb-typography-settings-label" for="cbdb-post-tag-text-transform"><?php esc_html_e('Text Transform', CBDB_TEXTDOMAIN); ?></label>
                                            </div>
                                            <select class="cbdb-section-layout" name="cbdb_post_tag_text_transform" id="cbdb-post-tag-text-transform">
                                                <?php CBDB_Utility::load_text_transform($cbdb_post_tag_text_transform); ?>
                                            </select>
                                        </div>

                                        <div class="cbdb-typography-wrapper">
                                            <div class="cbdb-field-label">
                                                <label class="cbdb-typography-settings-label" for="cbdb-post-tag-text-decoration"><?php esc_html_e('Text Decoration', CBDB_TEXTDOMAIN); ?></label>
                                            </div>
                                            <select class="cbdb-section-layout" name="cbdb_post_tag_text_decoration" id="cbdb-post-tag-text-decoration">
                                                <?php CBDB_Utility::load_text_decoration($cbdb_post_tag_text_decoration); ?>
                                            </select>
                                        </div>

                                        <div class="cbdb-line-height">
                                            <div class="cbdb-field-label">
                                                <label class="cbdb-typography-settings-label" for="cbdb-post-tag-letter-spacing"><?php esc_html_e('Letter Spacing (px)', CBDB_TEXTDOMAIN); ?></label>
                                            </div>
                                            <?php CBDB_Utility::load_input_number_field(array('name' => 'post_tag_letter_spacing', 'id' => 'post-tag-letter-spacing', 'class' => 'cbdb-input-number', 'step' => 1, 'min' => '', 'max' => '', 'value' => $cbdb_post_tag_letter_spacing)); ?>
                                        </div>
                                    </div>
                                    <div class="cbdb-select-wrapper cbdb-flex">
                                        <div class="cbdb-field-label cbdb-w-20">
                                            <label class="cbdb-layout-label" for="cbdb-post-tag-link"><?php esc_html_e('Post Tag Link', CBDB_TEXTDOMAIN); ?></label>
                                        </div>
                                        <div class="cbdb-yes-no cbdb-w-80">
                                            <?php CBDB_Utility::post_link_yes_no('post_tag_link', 'post-tag-link', $cbdb_post_tag_link); ?>
                                        </div>
                                    </div>

                                    <div class="cbdb-margin-control-field-wrapper cbdb-flex">
                                        <div class="cbdb-margin-control-field">
                                            <div class="cbdb-margin-control-wrapper">
                                                <div class="cbdb-advanced-wrapper">
                                                    <?php CBDB_Utility::load_spacing_unit('post_tag', 'margin', $cbdb_post_tag_margin_unit); ?>
                                                </div>

                                            </div>

                                            <div class="cbdb-control-input-wrapper">
                                                <div class="cbdb-field-label">
                                                    <label class="cbdb-margin-control-title"><?php esc_html_e('Margin', CBDB_TEXTDOMAIN); ?></label>
                                                </div>
                                                <ul class="cbdb-control-dimensions">
                                                    <?php CBDB_Utility::load_spacing_val('post_tag', 'margin', $cbdb_post_tag_margin_arr); ?>
                                                </ul>
                                            </div>
                                        </div>

                                        <div class="cbdb-margin-control-field">
                                            <div class="cbdb-margin-control-wrapper">
                                                <div class="cbdb-advanced-wrapper">
                                                    <?php CBDB_Utility::load_spacing_unit('post_tag', 'padding', $cbdb_post_tag_padding_unit); ?>
                                                </div>
                                            </div>

                                            <div class="cbdb-control-input-wrapper">
                                                <div class="cbdb-field-label">
                                                    <label
                                                        class="cbdb-margin-control-title"><?php esc_html_e('Padding', CBDB_TEXTDOMAIN); ?></label>
                                                </div>
                                                <ul class="cbdb-control-dimensions">
                                                    <?php CBDB_Utility::load_spacing_val('post_tag', 'padding', $cbdb_post_tag_padding_arr); ?>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- END Post Tag Settings -->
                                <hr class="cbdb-section-separator">
                                <!-- START Post Meta Settings -->
                                <h3 class="cbdb-post-title"><?php esc_html_e('Post Meta Settings', CBDB_TEXTDOMAIN); ?></h3>
                                <div class="cbdb-select-wrapper cbdb-flex">
                                    <div class="cbdb-field-label cbdb-w-20">
                                        <label class="cbdb-layout-label" for="cbdb-post-meta"><?php esc_html_e('Post Meta', CBDB_TEXTDOMAIN); ?></label>
                                    </div>
                                    <div class="cbdb-enable-disable cbdb-w-80">
                                        <?php CBDB_Utility::post_enable_disable('post_meta', 'post-meta', $cbdb_post_meta); ?>
                                    </div>
                                </div>

                                <div class="cbdb-post-meta-switch <?php if ($cbdb_post_meta == 0) echo 'cbdb-d-none'; ?>">
                                    <h4 class="cbdb-typography-settings-title"><?php esc_html_e('Typography Settings', CBDB_TEXTDOMAIN); ?></h4>
                                    <div class="cbdb-select-wrapper cbdb-typography-wrapper cbdb-flex">
                                        <div class="cbdb-font-family-wrapper">
                                            <div class="cbdb-field-label">
                                                <label class="cbdb-typography-settings-label" for="cbdb-post-meta-font-family"><?php esc_html_e('Font Family', CBDB_TEXTDOMAIN); ?></label>
                                            </div>
                                            <div class="select">
                                                <select class="chosen-select cbdb-select2" name="cbdb_post_meta_font_family" id="cbdb-post-meta-font-family">
                                                    <option value=""><?php esc_html_e('--Select--', CBDB_TEXTDOMAIN); ?></option>
                                                    <?php
                                                    $old_version = '';
                                                    $cnt = 0;
                                                    foreach ($font_family as $key => $value) {
                                                        if ($value['version'] != $old_version) {
                                                            if ($cnt > 0) {
                                                                echo '</optgroup>';
                                                            }
                                                            echo '<optgroup label="' . esc_attr($value['version']) . '">';
                                                            $old_version = $value['version'];
                                                        }
                                                        echo "<option value='" . esc_attr(str_replace('"', '', $value['label'])) . "'";
                                                        if ('' != $cbdb_post_meta_font_family && ( str_replace('"', '', $cbdb_post_meta_font_family) == str_replace('"', '', $value['label']) )) {
                                                            echo ' selected="selected"';
                                                        }
                                                        echo '>' . esc_html__($value['label'], CBDB_TEXTDOMAIN) . '</option>';
                                                        $cnt++;
                                                    }
                                                    if ($cnt == count($font_family)) {
                                                        echo '</optgroup>';
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="cbdb-font-size-wrapper">
                                            <div class="cbdb-title-text cbdb-margin-right cbdb-field-label">
                                                <label for="cbdb-post-meta-font-size" class="cbdb-typography-settings-label"><?php esc_html_e('Font Size (px)', CBDB_TEXTDOMAIN); ?></label>
                                            </div>
                                            <div class="cbdb-block">
                                                <?php CBDB_Utility::load_range_slider('post_meta_font_size', 'cbdb-slider-right', $cbdb_post_meta_font_size); ?>
                                            </div>
                                        </div>

                                        <div class="cbdb-typography-wrapper">
                                            <div class="cbdb-field-label">
                                                <label class="cbdb-typography-settings-label" for="cbdb-post-meta-font-weight"><?php esc_html_e('Font Weight', CBDB_TEXTDOMAIN); ?></label>
                                            </div>
                                            <select class="cbdb-section-layout" name="cbdb_post_meta_font_weight" id="cbdb-post-meta-font-weight">
                                                <?php CBDB_Utility::load_font_weight($cbdb_post_meta_font_weight); ?>
                                            </select>
                                        </div>

                                        <div class="cbdb-line-height">
                                            <div class="cbdb-field-label">
                                                <label class="cbdb-typography-settings-label" for="cbdb-post-meta-line-height"><?php esc_html_e('Line Height (px)', CBDB_TEXTDOMAIN); ?></label>
                                            </div>
                                            <?php CBDB_Utility::load_input_number_field(array('name' => 'post_meta_line_height', 'id' => 'post-meta-line-height', 'class' => 'cbdb-input-number', 'step' => 1, 'min' => 0, 'max' => '', 'value' => $cbdb_post_meta_line_height)); ?>
                                        </div>
                                    </div>

                                    <div class="cbdb-select-wrapper cbdb-typography-wrapper cbdb-flex">
                                        <div class="cbdb-font-family-wrapper">
                                            <div class="cbdb-field-label">
                                                <label class="cbdb-typography-settings-label" for="cbdb-post-meta-font-style"><?php esc_html_e('Font Style', CBDB_TEXTDOMAIN); ?></label>
                                            </div>
                                            <select class="cbdb-section-layout" name="cbdb_post_meta_font_style" id="cbdb-post-meta-font-style">
                                                <?php CBDB_Utility::load_font_style($cbdb_post_meta_font_style); ?>
                                            </select>
                                        </div>

                                        <div class="cbdb-typography-wrapper">
                                            <div class="cbdb-field-label">
                                                <label class="cbdb-typography-settings-label" for="cbdb-post-meta-text-transform"><?php esc_html_e('Text Transform', CBDB_TEXTDOMAIN); ?></label>
                                            </div>
                                            <select class="cbdb-section-layout" name="cbdb_post_meta_text_transform" id="cbdb-post-meta-text-transform">
                                                <?php CBDB_Utility::load_text_transform($cbdb_post_meta_text_transform); ?>
                                            </select>
                                            </select>
                                        </div>

                                        <div class="cbdb-typography-wrapper">
                                            <div class="cbdb-field-label">
                                                <label class="cbdb-typography-settings-label" for="cbdb-post-meta-text-decoration"><?php esc_html_e('Text Decoration', CBDB_TEXTDOMAIN); ?></label>
                                            </div>
                                            <select class="cbdb-section-layout" name="cbdb_post_meta_text_decoration" id="cbdb-post-meta-text-decoration">
                                                <?php CBDB_Utility::load_text_decoration($cbdb_post_meta_text_decoration); ?>
                                            </select>
                                        </div>

                                        <div class="cbdb-line-height">
                                            <div class="cbdb-field-label">
                                                <label class="cbdb-typography-settings-label" for="cbdb-post-meta-letter-spacing"><?php esc_html_e('Letter Spacing (px)', CBDB_TEXTDOMAIN); ?></label>
                                            </div>
                                            <?php CBDB_Utility::load_input_number_field(array('name' => 'post_meta_letter_spacing', 'id' => 'post-meta-letter-spacing', 'class' => 'cbdb-input-number', 'step' => 1, 'min' => '', 'max' => '', 'value' => $cbdb_post_meta_letter_spacing)); ?>
                                        </div>
                                    </div>

                                    <div class="cbdb-margin-control-field-wrapper cbdb-flex">
                                        <div class="cbdb-margin-control-field">
                                            <div class="cbdb-margin-control-wrapper">
                                                <div class="cbdb-advanced-wrapper">
                                                    <?php CBDB_Utility::load_spacing_unit('post_meta', 'margin', $cbdb_post_meta_margin_unit); ?>
                                                </div>
                                            </div>

                                            <div class="cbdb-control-input-wrapper">
                                                <div class="cbdb-field-label">
                                                    <label class="cbdb-margin-control-title"><?php esc_html_e('Margin', CBDB_TEXTDOMAIN); ?></label>
                                                </div>
                                                <ul class="cbdb-control-dimensions">
                                                    <?php CBDB_Utility::load_spacing_val('post_meta', 'margin', $cbdb_post_meta_margin_arr); ?>
                                                </ul>
                                            </div>
                                        </div>

                                        <div class="cbdb-margin-control-field">
                                            <div class="cbdb-margin-control-wrapper">
                                                <div class="cbdb-advanced-wrapper">
                                                    <?php CBDB_Utility::load_spacing_unit('post_meta', 'padding', $cbdb_post_meta_padding_unit); ?>
                                                </div>
                                            </div>

                                            <div class="cbdb-control-input-wrapper">
                                                <div class="cbdb-field-label">
                                                    <label class="cbdb-margin-control-title"><?php esc_html_e('Padding', CBDB_TEXTDOMAIN); ?></label>
                                                </div>
                                                <ul class="cbdb-control-dimensions">
                                                    <?php CBDB_Utility::load_spacing_val('post_meta', 'padding', $cbdb_post_meta_padding_arr); ?>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- END Post Meta Settings -->
                                <hr class="cbdb-section-separator">
                                <!-- START Read More Settings -->
                                <h3 class="cbdb-post-title"><?php esc_html_e('Read More Settings', CBDB_TEXTDOMAIN); ?></h3>
                                <div class="cbdb-select-wrapper cbdb-flex">
                                    <div class="cbdb-field-label cbdb-w-20">
                                        <label class="cbdb-layout-label" for="cbdb-read-more"><?php esc_html_e('Read More', CBDB_TEXTDOMAIN); ?></label>
                                    </div>
                                    <div class="cbdb-enable-disable cbdb-w-80">
                                        <?php CBDB_Utility::post_enable_disable('read_more', 'read-more', $cbdb_read_more); ?>
                                    </div>
                                </div>

                                <div class="cbdb-read-more-switch <?php if ($cbdb_read_more == 0) echo 'cbdb-d-none'; ?>">
                                    <div class="cbdb-field cbdb-flex">
                                        <div class="cbdb-field-label cbdb-w-20">
                                            <label class="cbdb-layout-label" for="cbdb-read-more-text"><?php esc_html_e('Read More Text', CBDB_TEXTDOMAIN); ?></label>
                                        </div>
                                        <div class="cbdb-w-80">
                                            <input class="cbdb-input-minus-width" type="text" name="cbdb_read_more_text" id="cbdb-read-more-text" value="<?php esc_attr_e($cbdb_read_more_text, CBDB_TEXTDOMAIN); ?>">
                                        </div>
                                    </div>
                                    <h4 class="cbdb-typography-settings-title"><?php esc_html_e('Typography Settings', CBDB_TEXTDOMAIN); ?></h4>
                                    <div class="cbdb-select-wrapper cbdb-typography-wrapper cbdb-flex">
                                        <div class="cbdb-font-family-wrapper">
                                            <div class="cbdb-field-label">
                                                <label class="cbdb-typography-settings-label" for="cbdb-read-more-font-family"><?php esc_html_e('Font Family', CBDB_TEXTDOMAIN); ?></label>
                                            </div>
                                            <div class="select">
                                                <select class="chosen-select cbdb-select2" name="cbdb_read_more_font_family" id="cbdb-read-more-font-family">
                                                    <option value=""><?php esc_html_e('--Select--', CBDB_TEXTDOMAIN); ?></option>
                                                    <?php
                                                    $old_version = '';
                                                    $cnt = 0;
                                                    foreach ($font_family as $key => $value) {
                                                        if ($value['version'] != $old_version) {
                                                            if ($cnt > 0) {
                                                                echo '</optgroup>';
                                                            }
                                                            echo '<optgroup label="' . esc_attr($value['version']) . '">';
                                                            $old_version = $value['version'];
                                                        }
                                                        echo "<option value='" . esc_attr(str_replace('"', '', $value['label'])) . "'";
                                                        if ('' != $cbdb_read_more_font_family && ( str_replace('"', '', $cbdb_read_more_font_family) == str_replace('"', '', $value['label']) )) {
                                                            echo ' selected="selected"';
                                                        }
                                                        echo '>' . esc_html__($value['label'], CBDB_TEXTDOMAIN) . '</option>';
                                                        $cnt++;
                                                    }
                                                    if ($cnt == count($font_family)) {
                                                        echo '</optgroup>';
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="cbdb-font-size-wrapper">
                                            <div class="cbdb-title-text cbdb-margin-right cbdb-field-label">
                                                <label for="cbdb-read-more-font-size" class="cbdb-typography-settings-label"><?php esc_html_e('Font Size (px)', CBDB_TEXTDOMAIN); ?></label>
                                            </div>
                                            <div class="cbdb-block">
                                                <?php CBDB_Utility::load_range_slider('read_more_font_size', 'cbdb-slider-right', $cbdb_read_more_font_size); ?>
                                            </div>
                                        </div>

                                        <div class="cbdb-typography-wrapper">
                                            <div class="cbdb-field-label">
                                                <label class="cbdb-typography-settings-label" for="cbdb-read-more-font-weight"><?php esc_html_e('Font Weight', CBDB_TEXTDOMAIN); ?></label>
                                            </div>
                                            <select class="cbdb-section-layout" name="cbdb_read_more_font_weight" id="cbdb-read-more-font-weight">
                                                <?php CBDB_Utility::load_font_weight($cbdb_read_more_font_weight); ?>
                                            </select>
                                        </div>

                                        <div class="cbdb-line-height">
                                            <div class="cbdb-field-label">
                                                <label class="cbdb-typography-settings-label" for="cbdb-read-more-line-height"><?php esc_html_e('Line Height (px)', CBDB_TEXTDOMAIN); ?></label>
                                            </div>
                                            <?php CBDB_Utility::load_input_number_field(array('name' => 'read_more_line_height', 'id' => 'read-more-line-height', 'class' => 'cbdb-input-number', 'step' => 1, 'min' => 0, 'max' => '', 'value' => $cbdb_read_more_line_height)); ?>
                                        </div>
                                    </div>

                                    <div class="cbdb-select-wrapper cbdb-typography-wrapper  cbdb-flex">
                                        <div class="cbdb-font-family-wrapper">
                                            <div class="cbdb-field-label">
                                                <label class="cbdb-typography-settings-label" for="cbdb-read-more-font-style"><?php esc_html_e('Font Style', CBDB_TEXTDOMAIN); ?></label>
                                            </div>
                                            <select class="cbdb-section-layout" name="cbdb_read_more_font_style" id="cbdb-read-more-font-style">
                                                <?php CBDB_Utility::load_font_style($cbdb_read_more_font_style); ?>
                                            </select>
                                        </div>
                                        <div class="cbdb-typography-wrapper">
                                            <div class="cbdb-field-label">
                                                <label class="cbdb-typography-settings-label" for="cbdb-read-more-text-transform"><?php esc_html_e('Text Transform', CBDB_TEXTDOMAIN); ?></label>
                                            </div>
                                            <select class="cbdb-section-layout" name="cbdb_read_more_text_transform" id="cbdb-read-more-text-transform">
                                                <?php CBDB_Utility::load_text_transform($cbdb_read_more_text_transform); ?>
                                            </select>
                                            </select>
                                        </div>
                                        <div class="cbdb-typography-wrapper">
                                            <div class="cbdb-field-label">
                                                <label class="cbdb-typography-settings-label" for="cbdb-read-more-text-decoration"><?php esc_html_e('Text Decoration', CBDB_TEXTDOMAIN); ?></label>
                                            </div>
                                            <select class="cbdb-section-layout" name="cbdb_read_more_text_decoration" id="cbdb-read-more-text-decoration">
                                                <?php CBDB_Utility::load_text_decoration($cbdb_read_more_text_decoration); ?>
                                            </select>
                                        </div>
                                        <div class="cbdb-line-height">
                                            <div class="cbdb-field-label">
                                                <label class="cbdb-typography-settings-label" for="cbdb-read-more-letter-spacing"><?php esc_html_e('Letter Spacing (px)', CBDB_TEXTDOMAIN); ?></label>
                                            </div>
                                            <?php CBDB_Utility::load_input_number_field(array('name' => 'read_more_letter_spacing', 'id' => 'read-more-letter-spacing', 'class' => 'cbdb-input-number', 'step' => 1, 'min' => '', 'max' => '', 'value' => $cbdb_read_more_letter_spacing)); ?>
                                        </div>
                                    </div>
                                    <div class="cbdb-select-wrapper cbdb-flex">
                                        <div class="cbdb-field-label cbdb-w-20">
                                            <label class="cbdb-layout-label" for="cbdb-read-more-link"><?php esc_html_e('Read More as Button', CBDB_TEXTDOMAIN); ?></label>
                                        </div>
                                        <div class="cbdb-yes-no cbdb-w-80">
                                            <?php CBDB_Utility::post_link_yes_no('read_more_btn', 'read-more-btn', $cbdb_read_more_btn); ?>
                                        </div>
                                    </div>
                                    <div class="cbdb-select-wrapper cbdb-flex cbdb-read-more-switch <?php if ($cbdb_read_more_btn == 'no') echo 'cbdb-d-none'; ?>">
                                        <div class="cbdb-field-label cbdb-w-20">
                                            <label class="cbdb-layout-label" for="cbdb-read-more-open-link"><?php esc_html_e('Read More Open Link', CBDB_TEXTDOMAIN); ?></label>
                                        </div>
                                        <div class="cbdb-current-tab-new-tab cbdb-w-80">
                                            <input id="cbdb-read-more-current-tab" class="cbdb-d-none" type="radio" name="cbdb_read_more_open_link" value="_self" <?php checked($cbdb_read_more_open_link, '_self'); ?>>
                                            <label class="cbdb-units-choices-current-tab" for="cbdb-read-more-current-tab"><?php esc_html_e('Current Tab', CBDB_TEXTDOMAIN); ?></label>

                                            <input id="cbdb-read-more-new-tab" class="cbdb-d-none" type="radio" name="cbdb_read_more_open_link" value="_blank" <?php checked($cbdb_read_more_open_link, '_blank'); ?>>
                                            <label class="cbdb-units-choices-new-tab" for="cbdb-read-more-new-tab"><?php esc_html_e('New Tab', CBDB_TEXTDOMAIN); ?></label>
                                        </div>
                                    </div>
                                    <div class="cbdb-margin-control-field-wrapper cbdb-flex">
                                        <div class="cbdb-margin-control-field">
                                            <div class="cbdb-margin-control-wrapper">
                                                <div class="cbdb-advanced-wrapper">
                                                    <?php CBDB_Utility::load_spacing_unit('read_more', 'margin', $cbdb_read_more_margin_unit); ?>
                                                </div>
                                            </div>
                                            <div class="cbdb-control-input-wrapper">
                                                <div class="cbdb-field-label">
                                                    <label class="cbdb-margin-control-title"><?php esc_html_e('Margin', CBDB_TEXTDOMAIN); ?></label>
                                                </div>
                                                <ul class="cbdb-control-dimensions">
                                                    <?php CBDB_Utility::load_spacing_val('read_more', 'margin', $cbdb_read_more_margin_arr); ?>
                                                </ul>
                                            </div>
                                        </div>
                                        <div class="cbdb-margin-control-field">
                                            <div class="cbdb-margin-control-wrapper">
                                                <div class="cbdb-advanced-wrapper">
                                                    <?php CBDB_Utility::load_spacing_unit('read_more', 'padding', $cbdb_read_more_padding_unit); ?>
                                                </div>
                                            </div>
                                            <div class="cbdb-control-input-wrapper">
                                                <div class="cbdb-field-label">
                                                    <label class="cbdb-margin-control-title"><?php esc_html_e('Padding', CBDB_TEXTDOMAIN); ?></label>
                                                </div>
                                                <ul class="cbdb-control-dimensions">
                                                    <?php CBDB_Utility::load_spacing_val('read_more', 'padding', $cbdb_read_more_padding_arr); ?>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- END Read More Settings -->
                            </div>
                            <!-- END General Settings -->

                            <!-- START Media Setting -->
                            <div class="cbdb-content">
                                <div class="cbdb-select-wrapper cbdb-flex">
                                    <div class="cbdb-field-label cbdb-w-20">
                                        <label class="cbdb-layout-label" for="cbdb-post-image"><?php esc_html_e('Post Image', CBDB_TEXTDOMAIN); ?></label>
                                    </div>
                                    <div class="cbdb-enable-disable cbdb-w-80">
                                        <?php CBDB_Utility::post_enable_disable('post_image', 'post-image', $cbdb_post_image); ?>
                                    </div>
                                </div>

                                <div class="cbdb-post-image-switch <?php if ($cbdb_post_image == 0) echo 'cbdb-d-none'; ?>">
                                    <div class="cbdb-select-wrapper cbdb-flex">
                                        <div class="cbdb-field-label cbdb-w-20">
                                            <label class="cbdb-layout-label" for="cbdb-post-image-link"><?php esc_html_e('Post Image Link', CBDB_TEXTDOMAIN); ?></label>
                                        </div>
                                        <div class="cbdb-yes-no cbdb-w-80">
                                            <?php CBDB_Utility::post_link_yes_no('post_image_link', 'post-image-link', $cbdb_post_image_link); ?>
                                        </div>
                                    </div>
                                    <div class="cbdb-select-wrapper cbdb-flex">
                                        <div class="cbdb-field-label cbdb-w-20">
                                            <label class="cbdb-layout-label" for="cbdb-post-media-size"><?php esc_html_e('Post Media Size', CBDB_TEXTDOMAIN); ?></label>
                                        </div>
                                        <div class="cbdb-w-80">
                                            <select class="cbdb-section-layout cbdb-section-minus-width" name="cbdb_post_media_size" id="cbdb-post-media-size">
                                                <option class="cbdb-option" value="thumbnail" <?php selected($cbdb_post_media_size, 'thumbnail'); ?>><?php esc_html_e('Thumbnail Size (150 x 150 px)', CBDB_TEXTDOMAIN); ?></option>
                                                <option class="cbdb-option" value="medium" <?php selected($cbdb_post_media_size, 'medium'); ?>><?php esc_html_e('Medium Size (300 x 300 px)', CBDB_TEXTDOMAIN); ?></option>
                                                <option class="cbdb-option" value="medium_large" <?php selected($cbdb_post_media_size, 'medium_large'); ?>><?php esc_html_e('Medium Large Size (768 x 0 infinite height)', CBDB_TEXTDOMAIN); ?></option>
                                                <option class="cbdb-option" value="large" <?php selected($cbdb_post_media_size, 'large'); ?>><?php esc_html_e('Large Size (1024 x 1024 px)', CBDB_TEXTDOMAIN); ?></option>
                                                <option class="cbdb-option" value="full" <?php selected($cbdb_post_media_size, 'full'); ?>><?php esc_html_e('Full Size (Original Size of the Image)', CBDB_TEXTDOMAIN); ?></option>
                                                <option class="cbdb-option" value="custom" <?php selected($cbdb_post_media_size, 'custom'); ?>><?php esc_html_e('Custom Size', CBDB_TEXTDOMAIN); ?></option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="cbdb-add-custom-size-wrapper <?php if ($cbdb_post_media_size != 'custom') echo 'cbdb-d-none'; ?>">
                                        <label class="cbdb-layout-label" for="cbdb-add-custom-size"><?php esc_html_e('Add Custom Size', CBDB_TEXTDOMAIN); ?></label>
                                        <div class="cbdb-width-height">
                                            <div class="cbdb-add-custom-size">
                                                <label class="cbdb-size-label" for="cbdb-add-custom-size-width"><?php esc_html_e('Width (px)', CBDB_TEXTDOMAIN); ?></label>
                                                <?php CBDB_Utility::load_input_number_field(array('name' => 'add_custom_size_width', 'id' => 'add-custom-size-width', 'class' => 'cbdb-input-number', 'step' => 10, 'min' => 1, 'max' => '', 'value' => $cbdb_add_custom_size_width)); ?>
                                            </div>
                                            <div class="cbdb-add-custom-size">
                                                <label class="cbdb-size-label" for="cbdb-add-custom-size-height" id="height_px"><?php esc_html_e('Height (px)', CBDB_TEXTDOMAIN); ?></label>
                                                <?php CBDB_Utility::load_input_number_field(array('name' => 'add_custom_size_height', 'id' => 'add-custom-size-height', 'class' => 'cbdb-input-number', 'step' => 10, 'min' => 1, 'max' => '', 'value' => $cbdb_add_custom_size_height)); ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="cbdb-field cbdb-flex">
                                    <div class="cbdb-field-label cbdb-w-20">
                                        <label class="cbdb-layout-label" for="cbdb-main-container-bg-image-id"><?php esc_html_e('Main Container Background Image', CBDB_TEXTDOMAIN); ?></label>
                                    </div>
                                    <div class="cbdb-main-wrapper cbdb-w-80">
                                        <div class="cbdb-upload-main-wrapper">
                                            <?php
                                            $bg_image = wp_get_attachment_image_url($cbdb_main_container_bg_image_id, array(400, 300));
                                            if ($bg_image) {
                                                ?>
                                                <div id="cbdb-image-wrapper">
                                                    <img src="<?php echo esc_url($bg_image); ?>" alt="<?php esc_attr_e('Main Container Background Image'); ?>" width="400" height="300">
                                                </div>
                                                <a href="#" class="button cbdb-media-remove"><?php esc_html_e('Remove Image', CBDB_TEXTDOMAIN); ?></a>
                                                <input type="hidden" name="cbdb_main_container_bg_image_id" value="<?php esc_attr_e(absint($cbdb_main_container_bg_image_id)); ?>">
                                            <?php } else { ?>
                                                <a href="#" class="button cbdb-media-upload"><?php esc_html_e('Upload Image', CBDB_TEXTDOMAIN); ?></a>
                                                <a href="#" class="button cbdb-media-remove" style="display:none"><?php esc_html_e('Remove Image', CBDB_TEXTDOMAIN); ?></a>
                                                <input type="hidden" name="cbdb_main_container_bg_image_id" value="">
                                            <?php } ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- END Media Settings -->

                            <!-- START Style Settings -->
                            <div class="cbdb-content">
                                <!-- START Main Container Style -->
                                <h3 class="cbdb-post-title"><?php esc_html_e('Main Container Style', CBDB_TEXTDOMAIN); ?></h3>
                                <div class="cbdb-select-wrapper cbdb-flex">
                                    <div class="cbdb-field-label cbdb-w-20">
                                        <label class="cbdb-layout-label" for="cbdb-main-container-color"><?php esc_html_e('Main Container Color', CBDB_TEXTDOMAIN); ?></label>
                                    </div>
                                    <div class="cbdb-color-picker-wrapper cbdb-w-80">
                                        <?php CBDB_Utility::load_color_field($cbdb_main_container_colors_arr); ?>
                                    </div>
                                </div>

                                <div class="cbdb-select-wrapper cbdb-flex">
                                    <div class="cbdb-field-label cbdb-w-20">
                                        <label class="cbdb-layout-label" for="cbdb-main-container-box-shadow-color"><?php esc_html_e('Box Shadow Color', CBDB_TEXTDOMAIN); ?></label>
                                    </div>
                                    <div class="cbdb-color-picker-wrapper cbdb-w-80">
                                        <?php CBDB_Utility::load_color_field($cbdb_main_container_box_shadow_color_arr); ?>
                                    </div>
                                </div>

                                <div class="cbdb-shadow-position cbdb-field-label">
                                    <label class="cbdb-box-shadow"for="cbdb-main-container-box-shadow-position"><?php esc_html_e('Box Shadow Position', CBDB_TEXTDOMAIN); ?></label>
                                </div>
                                <div class="cbdb-select-wrapper cbdb-typography-wrapper cbdb-flex">
                                    <?php CBDB_Utility::load_box_shadow_field('main_container', 'main-container', $cbdb_main_container_box_shadow_position_arr); ?>
                                </div>

                                <div class="cbdb-select-wrapper cbdb-typography-wrapper cbdb-flex">
                                    <div class="cbdb-color-picker-wrapper cbdb-typography-wrapper">
                                        <div class="cbdb-field-label">
                                            <label class="cbdb-typography-settings-label" for="cbdb-main-container-border-color"><?php esc_html_e('Border Color', CBDB_TEXTDOMAIN); ?></label>
                                        </div>
                                        <div class="cbdb-color-picker">
                                            <?php CBDB_Utility::load_color_field($cbdb_main_container_border_color_arr); ?>
                                        </div>
                                    </div>

                                    <div class="cbdb-typography-wrapper">
                                        <div class="cbdb-field-label">
                                            <label class="cbdb-typography-settings-label" for="cbdb-main-container-border-style"><?php esc_html_e('Border Style', CBDB_TEXTDOMAIN); ?></label>
                                        </div>
                                        <select class="cbdb-section-layout" name="cbdb_main_container_border_style" id="cbdb-main-container-border-style">
                                            <?php CBDB_Utility::load_border_style($cbdb_main_container_border_style); ?>
                                        </select>
                                    </div>
                                    <div class="cbdb-line-height cbdb-box-shadow-width">
                                        <div class="cbdb-field-label">
                                            <label class="cbdb-typography-settings-label" for="cbdb-main-container-border-radius"><?php esc_html_e('Border Radius (px)', CBDB_TEXTDOMAIN); ?></label>
                                        </div>
                                        <?php CBDB_Utility::load_input_number_field(array('name' => 'main_container_border_radius', 'id' => 'main-container-border-radius', 'class' => 'cbdb-input-number', 'step' => 1, 'min' => 0, 'max' => '', 'value' => $cbdb_main_container_border_radius)); ?>
                                    </div>
                                </div>

                                <div class="cbdb-margin-control-field-wrapper">
                                    <div class="cbdb-margin-control-field">
                                        <div class="cbdb-margin-control-wrapper">
                                            <div class="cbdb-advanced-wrapper">
                                                <?php CBDB_Utility::load_spacing_unit('main_container', 'border', $cbdb_main_container_border_unit); ?>
                                            </div>
                                        </div>

                                        <div class="cbdb-control-input-wrapper">
                                            <label class="cbdb-margin-control-title"><?php esc_html_e('Border Width', CBDB_TEXTDOMAIN); ?></label>
                                            <ul class="cbdb-control-dimensions">
                                                <?php CBDB_Utility::load_spacing_val('main_container', 'border', $cbdb_main_container_border_arr); ?>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                                <!-- END Main Container Style -->

                                <hr class="cbdb-section-separator">

                                <div class="cbdb-post-title-switch <?php if ($cbdb_post_title == 0) echo 'cbdb-d-none'; ?>">
                                    <!-- START Post Title Color -->
                                    <h3 class="cbdb-post-title"><?php esc_html_e('Post Title Color', CBDB_TEXTDOMAIN); ?></h3>
                                    <div class="cbdb-select-wrapper cbdb-flex">
                                        <div class="cbdb-field-label cbdb-w-20">
                                            <label class="cbdb-layout-label" for="cbdb-post-title-color"><?php esc_html_e('Post Title Color', CBDB_TEXTDOMAIN); ?></label>
                                        </div>
                                        <div class="cbdb-color-picker-wrapper cbdb-w-80">
                                            <?php CBDB_Utility::load_color_field($cbdb_post_title_color_arr); ?>
                                        </div>
                                    </div>

                                    <div class="cbdb-select-wrapper cbdb-flex cbdb-post-title-switch <?php if ($cbdb_post_title_link == 'no') echo 'cbdb-d-none'; ?>">
                                        <div class="cbdb-field-label cbdb-w-20">
                                            <label class="cbdb-layout-label" for="cbdb-post-title-link-hover-color"><?php esc_html_e('Post Title Link Hover Color', CBDB_TEXTDOMAIN); ?></label>
                                        </div>
                                        <div class="cbdb-color-picker-wrapper cbdb-w-80">
                                            <?php CBDB_Utility::load_color_field($cbdb_post_title_link_hover_color_arr); ?>
                                        </div>
                                    </div>
                                    <!-- END Post Title Color -->
                                    <hr class="cbdb-section-separator">
                                </div>

                                <div class="cbdb-post-content-switch <?php if ($cbdb_post_content == 0) echo 'cbdb-d-none'; ?>">
                                    <!-- START Post Content Color -->
                                    <h3 class="cbdb-post-title"><?php esc_html_e('Post Content Color', CBDB_TEXTDOMAIN); ?></h3>
                                    <div class="cbdb-select-wrapper cbdb-flex">
                                        <div class="cbdb-field-label cbdb-w-20">
                                            <label class="cbdb-layout-label" for="cbdb-post-content-color"><?php esc_html_e('Post Content Color', CBDB_TEXTDOMAIN); ?></label>
                                        </div>
                                        <div class="cbdb-color-picker-wrapper cbdb-w-80">
                                            <?php CBDB_Utility::load_color_field($cbdb_post_content_color_arr); ?>
                                        </div>
                                    </div>
                                    <!-- END Post Content Color -->
                                    <hr class="cbdb-section-separator">
                                </div>

                                <div class="cbdb-post-date-switch <?php if ($cbdb_post_date == 0) echo 'cbdb-d-none'; ?>">
                                    <!-- START Post Date Color -->
                                    <h3 class="cbdb-post-title"><?php esc_html_e('Post Date Color', CBDB_TEXTDOMAIN); ?></h3>
                                    <div class="cbdb-select-wrapper cbdb-flex">
                                        <div class="cbdb-field-label cbdb-w-20">
                                            <label class="cbdb-layout-label" for="cbdb-post-date-color"><?php esc_html_e('Post Date Color', CBDB_TEXTDOMAIN); ?></label>
                                        </div>
                                        <div class="cbdb-color-picker-wrapper cbdb-w-80">
                                            <?php CBDB_Utility::load_color_field($cbdb_post_date_color_arr); ?>
                                        </div>
                                    </div>

                                    <div class="cbdb-select-wrapper cbdb-flex cbdb-post-date-switch <?php if ($cbdb_post_date_link == 'no') echo 'cbdb-d-none'; ?>">
                                        <div class="cbdb-field-label cbdb-w-20">
                                            <label class="cbdb-layout-label" for="cbdb-post-date-link-hover-color"><?php esc_html_e('Post Date Link Hover Color', CBDB_TEXTDOMAIN); ?></label>
                                        </div>
                                        <div class="cbdb-color-picker-wrapper cbdb-w-80">
                                            <?php CBDB_Utility::load_color_field($cbdb_post_date_link_hover_color_arr); ?>
                                        </div>
                                    </div>
                                    <!-- END Post Date Color -->
                                    <hr class="cbdb-section-separator">
                                </div>

                                <div class="cbdb-post-cat-switch <?php if ($cbdb_post_cat == 0) echo 'cbdb-d-none'; ?>">
                                    <!-- START Post Cat Color -->
                                    <h3 class="cbdb-post-title"><?php esc_html_e('Post Category Color', CBDB_TEXTDOMAIN); ?></h3>
                                    <div class="cbdb-select-wrapper cbdb-flex">
                                        <div class="cbdb-field-label cbdb-w-20">
                                            <label class="cbdb-layout-label" for="cbdb-post-cat-color"><?php esc_html_e('Post Category Color', CBDB_TEXTDOMAIN); ?></label>
                                        </div>
                                        <div class="cbdb-color-picker-wrapper cbdb-w-80">
                                            <?php CBDB_Utility::load_color_field($cbdb_post_cat_color_arr); ?>
                                        </div>
                                    </div>

                                    <div class="cbdb-select-wrapper cbdb-flex cbdb-post-cat-switch <?php if ($cbdb_post_cat_link == 'no') echo 'cbdb-d-none'; ?>">
                                        <div class="cbdb-field-label cbdb-w-20">
                                            <label class="cbdb-layout-label" for="cbdb-post-cat-link-hover-color"><?php esc_html_e('Post Category Link Hover Color', CBDB_TEXTDOMAIN); ?></label>
                                        </div>
                                        <div class="cbdb-color-picker-wrapper cbdb-w-80">
                                            <?php CBDB_Utility::load_color_field($cbdb_post_cat_link_hover_color_arr); ?>
                                        </div>
                                    </div>
                                    <!-- END Post Cat Color -->
                                    <hr class="cbdb-section-separator">
                                </div>

                                <div class="cbdb-post-tag-switch <?php if ($cbdb_post_tag == 0) echo 'cbdb-d-none'; ?>">
                                    <!-- START Post Tag Color -->
                                    <h3 class="cbdb-post-title"><?php esc_html_e('Post Tag Color', CBDB_TEXTDOMAIN); ?></h3>
                                    <div class="cbdb-select-wrapper cbdb-flex">
                                        <div class="cbdb-field-label cbdb-w-20">
                                            <label class="cbdb-layout-label" for="cbdb-post-tag-color"><?php esc_html_e('Post Tag Color', CBDB_TEXTDOMAIN); ?></label>
                                        </div>
                                        <div class="cbdb-color-picker-wrapper cbdb-w-80">
                                            <?php CBDB_Utility::load_color_field($cbdb_post_tag_color_arr); ?>
                                        </div>
                                    </div>

                                    <div class="cbdb-select-wrapper cbdb-flex cbdb-post-tag-switch <?php if ($cbdb_post_tag_link == 'no') echo 'cbdb-d-none'; ?>">
                                        <div class="cbdb-field-label cbdb-w-20">
                                            <label class="cbdb-layout-label" for="cbdb-post-tag-link-hover-color"><?php esc_html_e('Post Tag Link Hover Color', CBDB_TEXTDOMAIN); ?></label>
                                        </div>
                                        <div class="cbdb-color-picker-wrapper cbdb-w-80">
                                            <?php CBDB_Utility::load_color_field($cbdb_post_tag_link_hover_color_arr); ?>
                                        </div>
                                    </div>
                                    <!-- END Post Tag Color -->
                                    <hr class="cbdb-section-separator">
                                </div>

                                <div class="cbdb-post-meta-switch <?php if ($cbdb_post_meta == 0) echo 'cbdb-d-none'; ?>">
                                    <!-- START Post Meta Color -->
                                    <h3 class="cbdb-post-title"><?php esc_html_e('Post Meta Color', CBDB_TEXTDOMAIN); ?></h3>
                                    <div class="cbdb-select-wrapper cbdb-flex">
                                        <div class="cbdb-field-label cbdb-w-20">
                                            <label class="cbdb-layout-label" for="cbdb-post-meta-icon-color"><?php esc_html_e('Post Meta Icon Color', CBDB_TEXTDOMAIN); ?></label>
                                        </div>
                                        <div class="cbdb-color-picker-wrapper cbdb-w-80">
                                            <?php CBDB_Utility::load_color_field($cbdb_post_meta_icon_color_arr); ?>
                                        </div>
                                    </div>

                                    <div class="cbdb-select-wrapper cbdb-flex">
                                        <div class="cbdb-field-label cbdb-w-20">
                                            <label class="cbdb-layout-label" for="cbdb-post-meta-color"><?php esc_html_e('Post Meta Color', CBDB_TEXTDOMAIN); ?></label>
                                        </div>
                                        <div class="cbdb-color-picker-wrapper cbdb-w-80">
                                            <?php CBDB_Utility::load_color_field($cbdb_post_meta_color_arr); ?>
                                        </div>
                                    </div>

                                    <div class="cbdb-select-wrapper cbdb-flex">
                                        <div class="cbdb-field-label cbdb-w-20">
                                            <label class="cbdb-layout-label" for="cbdb-post-meta-link-hover-color"><?php esc_html_e('Post Meta Link Hover Color', CBDB_TEXTDOMAIN); ?></label>
                                        </div>
                                        <div class="cbdb-color-picker-wrapper cbdb-w-80">
                                            <?php CBDB_Utility::load_color_field($cbdb_post_meta_link_hover_color_arr); ?>
                                        </div>
                                    </div>
                                    <!-- END Post Meta Color -->
                                    <hr class="cbdb-section-separator">
                                </div>

                                <div class="cbdb-read-more-switch <?php if ($cbdb_read_more == 0) echo 'cbdb-d-none'; ?>">
                                    <!-- START Read More Color -->
                                    <h3 class="cbdb-post-title"><?php esc_html_e('Read More Color', CBDB_TEXTDOMAIN); ?></h3>
                                    <div class="cbdb-select-wrapper cbdb-flex">
                                        <div class="cbdb-field-label cbdb-w-20">
                                            <label class="cbdb-layout-label" for="cbdb-read-more-text-color"><?php esc_html_e('Read More Text Color', CBDB_TEXTDOMAIN); ?></label>
                                        </div>
                                        <div class="cbdb-color-picker-wrapper cbdb-w-80">
                                            <?php CBDB_Utility::load_color_field($cbdb_read_more_text_color_arr); ?>
                                        </div>
                                    </div>

                                    <div class="cbdb-select-wrapper cbdb-flex">
                                        <div class="cbdb-field-label cbdb-w-20">
                                            <label class="cbdb-layout-label" for="cbdb-read-more-text-hover-color"><?php esc_html_e('Read More Text Hover Color', CBDB_TEXTDOMAIN); ?></label>
                                        </div>
                                        <div class="cbdb-color-picker-wrapper cbdb-w-20">
                                            <?php CBDB_Utility::load_color_field($cbdb_read_more_text_hover_color_arr); ?>
                                        </div>
                                    </div>

                                    <div class="cbdb-read-more-switch <?php if ($cbdb_read_more_btn == 'no') echo 'cbdb-d-none'; ?>">
                                        <div class="cbdb-select-wrapper cbdb-flex">
                                            <div class="cbdb-field-label cbdb-w-20">
                                                <label class="cbdb-layout-label" for="cbdb-read-more-bg-color"><?php esc_html_e('Read More Background Color', CBDB_TEXTDOMAIN); ?></label>
                                            </div>
                                            <div class="cbdb-color-picker-wrapper cbdb-w-80">
                                                <?php CBDB_Utility::load_color_field($cbdb_read_more_bg_color_arr); ?>
                                            </div>
                                        </div>

                                        <div class="cbdb-select-wrapper cbdb-flex">
                                            <div class="cbdb-field-label cbdb-w-20">
                                                <label class="cbdb-layout-label" for="cbdb-read-more-bg-hover-color"><?php esc_html_e('Read More Background Hover Color', CBDB_TEXTDOMAIN); ?></label>
                                            </div>
                                            <div class="cbdb-color-picker-wrapper cbdb-w-80">
                                                <?php CBDB_Utility::load_color_field($cbdb_read_more_bg_hover_color_arr); ?>
                                            </div>
                                        </div>

                                        <div class="cbdb-select-wrapper cbdb-flex">
                                            <div class="cbdb-field-label cbdb-w-20">
                                                <label class="cbdb-layout-label" for="cbdb-read-more-box-shadow-color"><?php esc_html_e('Box Shadow Color', CBDB_TEXTDOMAIN); ?></label>
                                            </div>
                                            <div class="cbdb-color-picker-wrapper cbdb-w-80">
                                                <?php CBDB_Utility::load_color_field($cbdb_read_more_box_shadow_color_arr); ?>
                                            </div>
                                        </div>

                                        <div class="cbdb-shadow-position">
                                            <label class="cbdb-box-shadow" for="cbdb-read-more-box-shadow-position"><?php esc_html_e('Box Shadow Position', CBDB_TEXTDOMAIN); ?></label>
                                        </div>
                                        <div class="cbdb-select-wrapper cbdb-typography-wrapper cbdb-flex">
                                            <?php CBDB_Utility::load_box_shadow_field('read_more', 'read-more', $cbdb_read_more_box_shadow_position_arr); ?>
                                        </div>

                                        <div class="cbdb-select-wrapper cbdb-typography-wrapper cbdb-flex">
                                            <div class="cbdb-color-picker-wrapper cbdb-typography-wrapper">
                                                <div class="cbdb-field-label">
                                                    <label class="cbdb-typography-settings-label" for="cbdb-read-more-border-color"><?php esc_html_e('Border Color', CBDB_TEXTDOMAIN); ?></label>
                                                </div>
                                                <div class="cbdb-color-picker">
                                                    <?php CBDB_Utility::load_color_field($cbdb_read_more_border_color_arr); ?>
                                                </div>
                                            </div>

                                            <div class="cbdb-typography-wrapper">
                                                <div class="cbdb-field-label">
                                                    <label class="cbdb-typography-settings-label" for="cbdb-read-more-border-style"><?php esc_html_e('Border Style', CBDB_TEXTDOMAIN); ?></label>
                                                </div>
                                                <select class="cbdb-section-layout" name="cbdb_read_more_border_style" id="cbdb-read-more-border-style">
                                                    <?php CBDB_Utility::load_border_style($cbdb_read_more_border_style); ?>
                                                </select>
                                            </div>
                                            <div class="cbdb-line-height cbdb-box-shadow-width">
                                                <div class="cbdb-field-label">
                                                    <label class="cbdb-typography-settings-label" for="cbdb-read-more-border-radius"><?php esc_html_e('Border Radius (px)', CBDB_TEXTDOMAIN); ?></label>
                                                </div>
                                                <?php CBDB_Utility::load_input_number_field(array('name' => 'read_more_border_radius', 'id' => 'read-more-border-radius', 'class' => 'cbdb-input-number', 'step' => 1, 'min' => 0, 'max' => '', 'value' => $cbdb_read_more_border_radius)); ?>
                                            </div>
                                        </div>

                                        <div class="cbdb-margin-control-field-wrapper cbdb-flex">
                                            <div class="cbdb-margin-control-field">
                                                <div class="cbdb-margin-control-wrapper">
                                                    <div class="cbdb-advanced-wrapper">
                                                        <?php CBDB_Utility::load_spacing_unit('read_more_btn', 'border', $cbdb_read_more_btn_border_unit); ?>
                                                    </div>
                                                </div>

                                                <div class="cbdb-control-input-wrapper">
                                                    <div class="cbdb-field-label">
                                                        <label class="cbdb-margin-control-title"><?php esc_html_e('Border Width', CBDB_TEXTDOMAIN); ?></label>
                                                    </div>
                                                    <ul class="cbdb-control-dimensions">
                                                        <?php CBDB_Utility::load_spacing_val('read_more_btn', 'border', $cbdb_read_more_btn_border_arr); ?>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- END Read More Color -->
                                </div>

                            </div>
                            <!-- END Style Settings -->

                            <!-- START Social Share Settings -->
                            <div class="cbdb-content">
                                <div class="cbdb-select-wrapper cbdb-flex">
                                    <div class="cbdb-field-label cbdb-w-20">
                                        <label class="cbdb-layout-label" for="cbdb-social-share-icon"><?php esc_html_e('Social Share Icon', CBDB_TEXTDOMAIN); ?></label>
                                    </div>
                                    <div class="cbdb-enable-disable cbdb-w-80">
                                        <?php CBDB_Utility::post_enable_disable('social_share_icon', 'social-share-icon', $cbdb_social_share_icon); ?>
                                    </div>
                                </div>
                                <div class="cbdb-social-share-switch <?php if ($cbdb_social_share_icon == 0) echo 'cbdb-d-none'; ?>">
                                    <div class="cbdb-select-wrapper cbdb-flex">
                                        <div class="cbdb-field-label cbdb-w-20">
                                            <label class="cbdb-layout-label" for="cbdb-social-share-style"><?php esc_html_e('Social Share Style', CBDB_TEXTDOMAIN); ?></label>
                                        </div>
                                        <div class="cbdb-enable-disable cbdb-w-80">
                                            <input type="radio" name="cbdb_social_share_style" class="cbdb-d-none" id="cbdb-social-share-style-square" value="square" <?php checked($cbdb_social_share_style, 'square'); ?>>
                                            <label class="cbdb-units-choices-enable" for="cbdb-social-share-style-square"><?php esc_html_e('Square', CBDB_TEXTDOMAIN); ?></label>

                                            <input type="radio" name="cbdb_social_share_style" class="cbdb-d-none" id="cbdb-social-share-style-round" value="round" <?php checked($cbdb_social_share_style, 'round'); ?>>
                                            <label class="cbdb-units-choices-disable" for="cbdb-social-share-style-round"><?php esc_html_e('Round', CBDB_TEXTDOMAIN); ?></label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- END Social Share Settings -->

                            <!-- START Pagination Settings -->
                            <div class="cbdb-content">
                                <div class="cbdb-select-wrapper cbdb-flex">
                                    <div class="cbdb-field-label cbdb-w-20">
                                        <label class="cbdb-layout-label" for="cbdb-pagination"><?php esc_html_e('Pagination', CBDB_TEXTDOMAIN); ?></label>
                                    </div>
                                    <div class="cbdb-enable-disable cbdb-w-80">
                                        <?php CBDB_Utility::post_enable_disable('post_pagination', 'post-pagination', $cbdb_pagination); ?>
                                    </div>
                                </div>
                                <div class="cbdb-post-pagination-switch <?php if ($cbdb_pagination == 0) echo 'cbdb-d-none'; ?>">
                                    <div class="cbdb-select-wrapper cbdb-flex">
                                        <div class="cbdb-field-label cbdb-w-20">
                                            <label class="cbdb-layout-label" for="cbdb-pagination-preview"><?php esc_html_e('Layout with Preview', CBDB_TEXTDOMAIN); ?></label>
                                        </div>
                                        <div class="cbdb-w-80">
                                            <select class="cbdb-section-layout cbdb-section-minus-width" name="cbdb_pagination_preview" id="cbdb-pagination-preview">
                                                <option class="cbdb-option" value="layout-1" <?php selected($cbdb_pagination_preview, 'layout-1'); ?>><?php esc_html_e('Layout 1', CBDB_TEXTDOMAIN); ?></option>
                                                <option class="cbdb-option" value="layout-2" <?php selected($cbdb_pagination_preview, 'layout-2'); ?>><?php esc_html_e('Layout 2', CBDB_TEXTDOMAIN); ?></option>
                                                <option class="cbdb-option" value="layout-3" <?php selected($cbdb_pagination_preview, 'layout-3'); ?>><?php esc_html_e('Layout 3', CBDB_TEXTDOMAIN); ?></option>
                                                <option class="cbdb-option" value="layout-4" <?php selected($cbdb_pagination_preview, 'layout-4'); ?>><?php esc_html_e('Layout 4', CBDB_TEXTDOMAIN); ?></option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="cbdb-blog-wrapper cbdb-flex">
                                        <div class="cbdb-blog cbdb-w-20"></div>
                                        <div class="cbdb-pagination-screenshots cbdb-w-80">
                                            <img class="cbdb-blog-image" src="<?php echo esc_url(CBDB_URL . 'admin/assets/images/pagination/pagination-' . $cbdb_pagination_preview . '.jpg'); ?>" alt="<?php esc_attr_e($cbdb_pagination_preview); ?>">
                                        </div>
                                    </div>
                                    <div class="cbdb-field cbdb-flex">
                                        <div class="cbdb-field-label cbdb-w-20">
                                            <label class="cbdb-layout-label" for="cbdb-pagination-prev-text"><?php esc_html_e('Pagination Prev Text', CBDB_TEXTDOMAIN); ?></label>
                                        </div>
                                        <div class="cbdb-w-80">
                                            <input class="cbdb-input-width-two" type="text" name="cbdb_pagination_prev_text" id="cbdb-pagination-prev-text" value="<?php esc_attr_e($cbdb_pagination_prev_text); ?>">
                                        </div>
                                    </div>
                                    <div class="cbdb-field cbdb-flex">
                                        <div class="cbdb-field-label cbdb-w-20">
                                            <label class="cbdb-layout-label" for="cbdb-pagination-next-text"><?php esc_html_e('Pagination Next Text', CBDB_TEXTDOMAIN); ?></label>
                                        </div>
                                        <div class="cbdb-w-80">
                                            <input class="cbdb-input-width-two" type="text" name="cbdb_pagination_next_text" id="cbdb-pagination-next-text" value="<?php esc_attr_e($cbdb_pagination_next_text); ?>">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- END Pagination Settings -->

                            <!-- START Custom Settings -->
                            <div class="cbdb-content">
                                <div class="cbdb-field cbdb-flex">
                                    <div class="cbdb-field-label cbdb-w-20">
                                        <label class="cbdb-layout-label" for="cbdb-main-container-class-name"><?php esc_html_e('Main Container Class Name', CBDB_TEXTDOMAIN); ?></label>
                                    </div>
                                    <div class="cbdb-w-80">
                                        <input type="text" name="cbdb_main_container_class_name" id="cbdb-main-container-class-name" value="<?php esc_attr_e($cbdb_main_container_class_name); ?>">
                                    </div>
                                </div>
                                <div class="cbdb-field cbdb-flex">
                                    <div class="cbdb-field-label cbdb-w-20">
                                        <label class="cbdb-layout-label" for="cbdb-custom-title-class-name"><?php esc_html_e('Custom Title Class Name', CBDB_TEXTDOMAIN); ?></label>
                                    </div>
                                    <div class="cbdb-w-80">
                                        <input type="text" name="cbdb_custom_title_class_name" id="cbdb-custom-title-class-name" value="<?php esc_attr_e($cbdb_custom_title_class_name); ?>">
                                    </div>
                                </div>
                                <div class="cbdb-field cbdb-flex">
                                    <div class="cbdb-field-label cbdb-w-20">
                                        <label class="cbdb-layout-label" for="cbdb-custom-content-class-name"><?php esc_html_e('Custom Content Class Name', CBDB_TEXTDOMAIN); ?></label>
                                    </div>
                                    <div class="cbdb-w-80">
                                        <input type="text" name="cbdb_custom_content_class_name" id="cbdb-custom-content-class-name" value="<?php esc_attr_e($cbdb_custom_content_class_name); ?>">
                                    </div>
                                </div>
                                <div class="cbdb-field cbdb-field_css cbdb-flex">
                                    <div class="cbdb-field-label cbdb-w-20">
                                        <label class="cbdb-layout-label" for="cbdb-custom-css"><?php esc_html_e('Custom CSS', CBDB_TEXTDOMAIN); ?></label>
                                    </div>
                                    <div class="cbdb_custom_css_wrapper cbdb-w-80">
                                        <textarea name="cbdb_custom_css" class="widefat textarea" id="cbdb-custom-css" placeholder="<?php esc_attr_e('.class_name{color:#ffffff}'); ?>" rows="12"><?php echo wp_unslash($cbdb_custom_css); ?></textarea>
                                        <p class="cbdb-description"><strong><?php esc_html_e('Example', CBDB_TEXTDOMAIN); ?>:</strong> <?php echo '.class_name{ color:#ffffff }'; ?></p>
                                    </div>
                                </div>
                            </div>
                            <!-- START Custom Settings -->
                        </div>
                        <!-- END right part -->
                    </div>
                </div>
            </div>
            <!-- END dashboard -->
        </form>
        <!-- END form -->
    </div>
    <?php
}