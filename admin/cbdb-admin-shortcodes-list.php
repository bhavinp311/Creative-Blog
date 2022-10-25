<?php
/**
 * Include WP native list table file
 *
 * @since 1.0
 */
if (!class_exists('WP_List_Table')) {
    require_once ABSPATH . 'wp-admin/includes/class-wp-list-table.php';
}

class CBDB_Shortcode_List extends WP_List_Table
{

    /**
     * List class constructor
     *
     * @since 1.0
     */
    public function __construct()
    {
        parent::__construct([
            'singular' => __('Layout', CBDB_TEXTDOMAIN), // Singular name of the listed records
            'plural' => __('Layouts', CBDB_TEXTDOMAIN), // Plural name of the listed records
            'ajax' => false, // Should this table support ajax?
        ]);
    }

    /**
     * Retrieve layout list table data from the database custom table
     *
     * @since 1.0
     *
     * @param int $per_page    Records per page
     * @param int $page_number Records page number
     *
     * @return mixed           Database result
     */
    public static function get_layout_list($per_page = 5, $page_number = 1)
    {
        global $wpdb;

        $sql = "SELECT * FROM {$wpdb->prefix}creative_blog_shortcodes";

        if (!empty($_REQUEST['orderby'])) {
            $sql .= ' ORDER BY ' . esc_sql($_REQUEST['orderby']);
            $sql .= !empty($_REQUEST['order']) ? ' ' . esc_sql($_REQUEST['order']) : ' ASC';
        } else {
            $sql .= ' ORDER BY cbdb_registered DESC';
        }

        $sql .= ' LIMIT %d OFFSET %d';
        $result = $wpdb->get_results($wpdb->prepare($sql, array($per_page, ($page_number - 1) * $per_page)), 'ARRAY_A');

        return $result;
    }

    /**
     * Delete a layout record.
     *
     * @param int $id Layout id
     */
    public static function delete_layout($id)
    {
        global $wpdb;

        $wpdb->delete(
            "{$wpdb->prefix}creative_blog_shortcodes",
            ['cbdb_id' => esc_sql($id)],
            ['%d']
        );
    }

    /**
     * Returns the count of records in the database.
     *
     * @return null|string Records count
     */
    public static function record_count()
    {
        global $wpdb;

        $sql = "SELECT COUNT(*) FROM {$wpdb->prefix}creative_blog_shortcodes";

        return $wpdb->get_var($sql);
    }

    /**
     * Text displayed when no layout data is available.
     */
    public function no_items()
    {
        esc_html_e('No layouts found.', CBDB_TEXTDOMAIN);
    }

    /**
     * Method for layout name column.
     *
     * @param array $item an array of Database data
     *
     * @return string Row actions HTML
     */
    public function column_cbdb_sc_name($item)
    {
        // Create a nonce
        $cbdb_nonce = wp_create_nonce('cbdb_delete_layout');

        $title = sprintf('<a href="?page=%s&action=%s&cbdb_id=%s&_wpnonce=%s"><strong>' . $item['cbdb_sc_name'] . '</strong></a>', esc_attr('cbdb_add_shortcode'), 'edit', esc_attr(absint($item['cbdb_id'])), esc_attr($cbdb_nonce));

        $actions = [
            'edit' => sprintf('<a href="?page=%s&action=%s&cbdb_id=%s&_wpnonce=%s">%s</a>', esc_attr('cbdb_add_shortcode'), 'edit', esc_attr(absint($item['cbdb_id'])), esc_attr($cbdb_nonce), esc_html__('Edit', CBDB_TEXTDOMAIN)),
            'delete' => sprintf('<a href="?page=%s&action=%s&cbdb_id=%s&_wpnonce=%s">%s</a>', esc_attr($_REQUEST['page']), 'delete', esc_attr(absint($item['cbdb_id'])), esc_attr($cbdb_nonce), esc_html__('Delete', CBDB_TEXTDOMAIN)),
        ];

        return $title . $this->row_actions($actions);
    }

    /**
     * Render a column when no column specific method exists.
     *
     * @param array  $item        Column fields array
     * @param string $column_name Column name
     *
     * @return mixed
     */
    public function column_default($item, $column_name)
    {
        switch ($column_name) {
            case 'cbdb_sc_name':
                return $item[$column_name];
            case 'cbdb_id':
                return sprintf('<input type="text" readonly="readonly" onclick="this.select()" class="copy_shortcode" title="%s" value=\'[creative_blog id="%s"]\' />', esc_html__('Copy Shortcode', CBDB_TEXTDOMAIN), esc_attr(absint($item[$column_name])));
            case 'cbdb_registered':
                return $item[$column_name];
            default:
                return print_r($item, true); // Show the whole array for troubleshooting purposes.
        }
        exit;
    }

    /**
     * Render the bulk edit checkbox.
     *
     * @param array $item Column fields array
     *
     * @return string     Bulk action checkbox HTML
     */
    public function column_cb($item)
    {
        return sprintf(
            '<input type="checkbox" name="bulk-delete[]" value="%s" />', esc_attr($item['cbdb_id'])
        );
    }

    /**
     * Associative array of columns.
     *
     * @return array
     */
    public function get_columns()
    {
        $columns = [
            'cb' => '<input type="checkbox" />',
            'cbdb_sc_name' => __('Layout Name', CBDB_TEXTDOMAIN),
            'cbdb_id' => __('Shortocode', CBDB_TEXTDOMAIN),
            'cbdb_registered' => __('Date', CBDB_TEXTDOMAIN),
        ];

        return $columns;
    }

    /**
     * Columns to make sortable.
     *
     * @return array
     */
    public function get_sortable_columns()
    {
        $sortable_columns = array(
            'cbdb_sc_name' => array('cbdb_sc_name', true),
            'cbdb_id' => array('cbdb_id', false),
            'cbdb_registered' => array('cbdb_registered', false),
        );

        return $sortable_columns;
    }

    /**
     * Returns an associative array containing the bulk action.
     *
     * @return array
     */
    public function get_bulk_actions()
    {
        $actions = [
            'bulk-delete' => __('Delete', CBDB_TEXTDOMAIN),
        ];

        return $actions;
    }

    /**
     * Handles data query and filter, sorting, and pagination.
     */
    public function prepare_items()
    {

        $this->_column_headers = $this->get_column_info();

        // Process bulk action
        $this->process_bulk_action();

        $per_page = $this->get_items_per_page('layouts_per_page', 5);
        $current_page = $this->get_pagenum();
        $total_items = self::record_count();

        $this->set_pagination_args([
            'total_items' => $total_items, // We have to calculate the total number of items
            'per_page' => $per_page, // We have to determine how many items to show on a page
        ]);

        $this->items = self::get_layout_list($per_page, $current_page);
    }

    /**
     * Bulk and row delete action.
     */
    public function process_bulk_action()
    {

        // Detect when a delete action is being triggered.
        if ('delete' === $this->current_action()) {
            // In our file that handles the request, verify the nonce.
            $nonce = esc_attr($_REQUEST['_wpnonce']);

            if (!wp_verify_nonce($nonce, 'cbdb_delete_layout')) {
                die(esc_html__('Go get a life script kiddies', CBDB_TEXTDOMAIN));
            } else {
                self::delete_layout(absint($_REQUEST['cbdb_id']));

                $redirect_to = esc_url(home_url() . '/wp-admin/admin.php?page=cbdb-layouts');
                echo '<script>window.location.href="' . $redirect_to . '"</script>';
            }
        }

        // If the delete bulk action is triggered.
        if ((isset($_POST['action']) && $_POST['action'] == 'bulk-delete') || (isset($_POST['action2']) && $_POST['action2'] == 'bulk-delete')
        ) {

            $delete_ids = esc_sql($_POST['bulk-delete']);

            // Loop over the array of record IDs and delete them.
            foreach ($delete_ids as $id) {
                self::delete_layout($id);
            }

            $redirect_to = esc_url(home_url() . '/wp-admin/admin.php?page=cbdb-layouts');
            echo '<script>window.location.href="' . $redirect_to . '"</script>';
        }
    }

}

/**
 * Admin menu page and screen options.
 */
class CBDB_Listing
{

    // class instance
    static $instance;
    // customer WP_List_Table object
    public $customers_obj;

    // class constructor
    public function __construct()
    {
        add_filter('set-screen-option', [__CLASS__, 'set_screen'], 10, 3);
        add_action('admin_menu', [$this, 'cbdb_layout_admin_menu']);
    }

    public static function set_screen($status, $option, $value)
    {
        return $value;
    }

    public function cbdb_layout_admin_menu()
    {

        $hook = add_menu_page(
            __('Creative Blog', CBDB_TEXTDOMAIN),
            __('Creative Blog', CBDB_TEXTDOMAIN),
            'manage_options',
            'cbdb-layouts',
            [$this, 'cbdb_layouts_listing_callback'],
            'dashicons-welcome-widgets-menus',
            59
        );

        add_action("load-$hook", [$this, 'screen_option']);

        add_submenu_page(
            'cbdb-layouts',
            __('Create New Layout', CBDB_TEXTDOMAIN),
            __('Create New Layout', CBDB_TEXTDOMAIN),
            'manage_options',
            'cbdb_add_shortcode',
            [$this, 'cbdb_new_layout_callback']
        );
    }

    /**
     * Screen options.
     */
    public function screen_option()
    {

        $option = 'per_page';
        $args = [
            'label' => __('Layouts', CBDB_TEXTDOMAIN),
            'default' => 5,
            'option' => 'layouts_per_page',
        ];

        add_screen_option($option, $args);

        $this->customers_obj = new CBDB_Shortcode_List();
    }

    /**
     * Layouts listing callback.
     */
    public function cbdb_layouts_listing_callback()
    {
        ?>
        <div class="wrap">
            <h1>
                <?php esc_html_e('Layouts', CBDB_TEXTDOMAIN);?>
                <a class="page-title-action" href="?page=cbdb_add_shortcode"><?php esc_html_e('Create New Layout', CBDB_TEXTDOMAIN);?></a>
            </h1>
            <div id="poststuffwrap">
                <div id="post-body" class="metabox-holder columns-2">
                    <div id="post-body-content">
                        <div class="meta-box-sortables ui-sortable">
                            <form method="post">
                                <?php
$this->customers_obj->prepare_items();
        $this->customers_obj->display();
        ?>
                            </form>
                        </div>
                    </div>
                </div>
                <br class="clear">
            </div>
        </div>
        <?php
}

    /**
     * New layout callback.
     */
    public function cbdb_new_layout_callback()
    {
        require_once 'cbdb-add-shortcode.php';
    }

    // Singleton instance
    public static function get_instance()
    {
        if (!isset(self::$instance)) {
            self::$instance = new self();
        }

        return self::$instance;
    }

}
