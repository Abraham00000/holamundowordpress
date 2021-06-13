<?php
namespace WishSuite\Admin;
/**
 * Dashboard handlers class
 */
class Dashboard {

    /**
     * Menu capability
     */
    const MENU_CAPABILITY = 'manage_options';

    /**
     * Parent Menu Page Slug
     */
    const MENU_PAGE_SLUG = 'wishsuite';

    /**
     * [$parent_menu_hook] Parent Menu Hook
     * @var string
     */
    static $parent_menu_hook = '';

    /**
     * [$_instance]
     * @var null
     */
    private static $_instance = null;

    /**
     * [instance] Initializes a singleton instance
     * @return [Admin]
     */
    public static function instance() {
        if ( is_null( self::$_instance ) ) {
            self::$_instance = new self();
        }
        return self::$_instance;
    }

    /**
     * Initialize the class
     */
    private function __construct() {

        Admin_Fields::instance();

        add_action( 'admin_menu', [ $this, 'add_menu' ], 20 );

        add_filter('plugin_action_links_'.WISHSUITE_BASE, [ $this, 'action_links' ] );

        // Add a post display state for special WishSuite page.
        add_filter( 'display_post_states', [ $this, 'add_display_post_states' ], 10, 2 );

        // Redirect Option page
        $this->redirect_option_page();

        // Recommended plugin
        $this->plugin_recommendations();

    }

    /**
    * [action_links] add plugin action link
    * @param  [array] $links default plugin action link
    * @return [array] plugin action link
    */
    public function action_links( $links ) {

        if ( ! current_user_can( self::MENU_CAPABILITY ) ) {
            return $links;
        }

        $settings_link = '<a href="'.admin_url( 'admin.php?page='.self::MENU_PAGE_SLUG ).'">'.esc_html__( 'Settings', 'wishsuite' ).'</a>'; 

        array_unshift( $links, $settings_link );

        return $links; 
    }

    /**
     * [add_menu] Admin Menu
     */
    public function add_menu(){

        global $submenu;

        self::$parent_menu_hook = add_menu_page(
            esc_html__( 'WishSuite', 'wishsuite' ), 
            esc_html__( 'WishSuite', 'wishsuite' ), 
            self::MENU_CAPABILITY,
            self::MENU_PAGE_SLUG,
            [ $this,'dashboard' ],
            'dashicons-heart',
            59
        );

        if ( current_user_can( self::MENU_CAPABILITY ) ) {

            foreach ( $this->sub_menu_nav() as $menukey => $menu ) {

                $page_slug = !empty( $menu['page_slug'] ) ? $menu['page_slug'] : self::MENU_PAGE_SLUG;

                $submenu[ self::MENU_PAGE_SLUG ][] = array(
                    esc_html__( $menu['title'], 'wishsuite' ),
                    self::MENU_CAPABILITY,
                    'admin.php?page='.$page_slug.'#'.$menukey,
                );

            }

        }

        add_action( 'load-' . self::$parent_menu_hook, [ $this, 'init_hooks'] );
        

    }

    /**
     * Initialize our hooks for the admin page
     *
     * @return void
     */
    public function init_hooks() {
        add_action( 'admin_enqueue_scripts', [ $this, 'enqueue_scripts' ] );
    }

    /**
     * [enqueue_scripts] Add Scripts Base Menu Slug
     * @param  [string] $hook
     * @return [void]
     */
    public function enqueue_scripts() {
        wp_enqueue_style( 'wishsuite-admin' );
        wp_enqueue_script( 'wishsuite-admin' );
    }

    /**
     * [dashboard] Dashboard plugin page
     * @return [HTML]
     */
    public function dashboard(){
        Admin_Fields::instance()->plugin_page();
    }

    /**
     * [plugin_recommendations]
     * @return [void]
     */
    public function plugin_recommendations(){

        $get_instance = Recommended_Plugins::instance( 
            array( 
                'text_domain'       => 'wishsuite', 
                'parent_menu_slug'  => self::MENU_PAGE_SLUG, 
                'menu_capability'   => self::MENU_CAPABILITY, 
                'menu_page_slug'    => 'recommendations',
                'priority'          => 25,
                'assets_url'        => WISHSUITE_ASSETS,
                'hook_suffix'       => 'wishsuite_page_recommendations'
            )
        );

        $get_instance->add_new_tab( array(

            'title' => esc_html__( 'Recommended', 'wishsuite' ),
            'active' => true,
            'plugins' => array(
                array(
                    'slug'      => 'woolentor-addons',
                    'location'  => 'woolentor_addons_elementor.php',
                    'name'      => esc_html__( 'WooLentor', 'wishsuite' )
                ),
                array(
                    'slug'      => 'wc-builder',
                    'location'  => 'wc-builder.php',
                    'name'      => esc_html__( 'WC Builder', 'wishsuite' )
                ),
                array(
                    'slug'      => 'ever-compare',
                    'location'  => 'ever-compare.php',
                    'name'      => esc_html__( 'EverCompare', 'wishsuite' )
                ),
                array(
                    'slug'      => 'quickswish',
                    'location'  => 'quickswish.php',
                    'name'      => esc_html__( 'QuickSwish', 'wishsuite' )
                ),
                array(
                    'slug'      => 'whols',
                    'location'  => 'whols.php',
                    'name'      => esc_html__( 'Whols', 'wishsuite' )
                ),
                array(
                    'slug'      => 'just-tables',
                    'location'  => 'just-tables.php',
                    'name'      => esc_html__( 'JustTables', 'wishsuite' )
                ),
                array(
                    'slug'      => 'wc-multi-currency',
                    'location'  => 'wcmilticurrency.php',
                    'name'      => esc_html__( 'Multi Currency', 'wishsuite' )
                )
            )

        ) );

        $get_instance->add_new_tab(array(
            'title' => esc_html__( 'You May Also Like', 'wishsuite' ),
            'plugins' => array(

                array(
                    'slug'      => 'woolentor-addons-pro',
                    'location'  => 'woolentor_addons_pro.php',
                    'name'      => esc_html__( 'WooLentor Pro', 'wishsuite' ),
                    'link'      => 'https://hasthemes.com/plugins/woolentor-pro-woocommerce-page-builder/',
                    'author_link'=> 'https://hasthemes.com/',
                    'description'=> esc_html__( 'WooLentor is one of the most popular WooCommerce Elementor Addons on WordPress.org. It has been downloaded more than 672,148 times and 60,000 stores are using WooLentor plugin. Why not you?', 'wishsuite' ),
                ),

                array(
                    'slug'      => 'just-tables-pro',
                    'location'  => 'just-tables-pro.php',
                    'name'      => esc_html__( 'JustTables Pro', 'wishsuite' ),
                    'link'      => 'https://hasthemes.com/wp/justtables/',
                    'author_link'=> 'https://hasthemes.com/',
                    'description'=> esc_html__( 'JustTables is an incredible WordPress plugin that lets you showcase all your WooCommerce products in a sortable and filterable table view. It allows your customers to easily navigate through different attributes of the products and compare them on a single page. This plugin will be of great help if you are looking for an easy solution that increases the chances of landing a sale on your online store.', 'wishsuite' ),
                ),

                array(
                    'slug'      => 'whols-pro',
                    'location'  => 'whols-pro.php',
                    'name'      => esc_html__( 'Whols Pro', 'wishsuite' ),
                    'link'      => 'https://hasthemes.com/plugins/whols-woocommerce-wholesale-prices/',
                    'author_link'=> 'https://hasthemes.com/',
                    'description'=> esc_html__( 'Whols is an outstanding WordPress plugin for WooCommerce that allows store owners to set wholesale prices for the products of their online stores. This plugin enables you to show special wholesale prices to the wholesaler. Users can easily request to become a wholesale customer by filling out a simple online registration form. Once the registration is complete, the owner of the store will be able to review the request and approve the request either manually or automatically.', 'wishsuite' ),
                ),

                array(
                    'slug'      => 'multicurrencypro',
                    'location'  => 'multicurrencypro.php',
                    'name'      => esc_html__( 'Multi Currency Pro for WooCommerce', 'wishsuite' ),
                    'link'      => 'https://hasthemes.com/plugins/multi-currency-pro-for-woocommerce/',
                    'author_link'=> 'https://hasthemes.com/',
                    'description'=> esc_html__( 'Multi-Currency Pro for WooCommerce is a prominent currency switcher plugin for WooCommerce. This plugin allows your website or online store visitors to switch to their preferred currency or their country’s currency.', 'wishsuite' ),
                ),

                array(
                    'slug'      => 'email-candy-pro',
                    'location'  => 'email-candy-pro.php',
                    'name'      => esc_html__( 'Email Candy Pro', 'wishsuite' ),
                    'link'      => 'https://hasthemes.com/plugins/email-candy-pro/',
                    'author_link'=> 'https://hasthemes.com/',
                    'description'=> esc_html__( 'Email Candy is an outstanding WordPress plugin that allows you to customize the default WooCommerce email templates and give a professional look to your WooCommerce emails. If you are tired of using the boring design of WooCommerce emails and want to create customized emails, then this plugin will come in handy.', 'wishsuite' ),
                ),
            )
        ));

        $get_instance->add_new_tab(array(
            'title' => esc_html__( 'Others', 'wishsuite' ),
            'plugins' => array(

                array(
                    'slug'      => 'ht-mega-for-elementor',
                    'location'  => 'htmega_addons_elementor.php',
                    'name'      => esc_html__( 'HT Mega', 'wishsuite' )
                ),

                array(
                    'slug'      => 'ht-slider-for-elementor',
                    'location'  => 'ht-slider-for-elementor.php',
                    'name'      => esc_html__( 'HT Slider For Elementor', 'wishsuite' )
                ),

                array(
                    'slug'      => 'wp-plugin-manager',
                    'location'  => 'plugin-main.php',
                    'name'      => esc_html__( 'WP Plugin Manager', 'wishsuite' )
                ),

                array(
                    'slug'      => 'ht-contactform',
                    'location'  => 'contact-form-widget-elementor.php',
                    'name'      => esc_html__( 'HT Contact Form 7', 'wishsuite' )
                ),

                array(
                    'slug'      => 'ht-wpform',
                    'location'  => 'wpform-widget-elementor.php',
                    'name'      => esc_html__( 'HT WPForms', 'wishsuite' )
                ),

                array(
                    'slug'      => 'hashbar-wp-notification-bar',
                    'location'  => 'init.php',
                    'name'      => esc_html__( 'HashBar', 'wishsuite' )
                ),

                array(
                    'slug'      => 'ht-menu-lite',
                    'location'  => 'ht-mega-menu.php',
                    'name'      => esc_html__( 'HT Menu', 'wishsuite' )
                ),

                array(
                    'slug'      => 'htmega-pro',
                    'location'  => 'htmega_pro.php',
                    'name'      => esc_html__( 'HT Mega Pro', 'wishsuite' ),
                    'link'      => 'https://hasthemes.com/plugins/ht-mega-pro/',
                    'author_link'=> 'https://hasthemes.com/',
                    'description'=> esc_html__( 'HTMega is an absolute addon for elementor that includes 80+ elements & 360 Blocks with unlimited variations. HT Mega brings limitless possibilities. Embellish your site with the elements of HT Mega.', 'wishsuite' ),
                ),

                array(
                    'slug'      => 'hashbar-pro',
                    'location'  => 'init.php',
                    'name'      => esc_html__( 'HashBar Pro', 'wishsuite' ),
                    'link'      => 'https://hasthemes.com/plugins/wordpress-notification-bar-plugin/',
                    'author_link'=> 'https://hasthemes.com/',
                    'description'=> esc_html__( 'HashBar is a WordPress Notification / Alert / Offer Bar plugin which allows you to create unlimited notification bars to notify your customers. This plugin has option to show email subscription form (sometimes it increases up to 500% email subscriber), Offer text and buttons about your promotions. This plugin has the options to add unlimited background colors and images to make your notification bar more professional.', 'wishsuite' ),
                ),

            )
        ));


    }

    /**
     * [sub_menu_nav]
     * @return [array]
     */
    public function sub_menu_nav() {

        $submenu = [
            'settings' => [
                'title'     => esc_html__( 'Settings', 'wishsuite' ),
                'subtitle'  => esc_html__( 'Settings', 'wishsuite' ),
                'icon'      => '',
                'class'     => '',
            ],
        ];

        return apply_filters( 'wishsuite_dashboard_submenu', $submenu );

    }

    /**
     * [redirect_option_page] After Active the plugin then redirect to option page
     * @return [void]
     */
    public function redirect_option_page() {
        if ( get_option( 'wishsuite_do_activation_redirect', FALSE ) ) {
            delete_option('wishsuite_do_activation_redirect');
            if( !isset( $_GET['activate-multi'] ) ){
                wp_redirect( admin_url( "admin.php?page=".self::MENU_PAGE_SLUG ) );
            }
        }
    }

    /**
     * Add a post display state for special WishSuite page in the page list table.
     *
     * @param array   $post_states An array of post display states.
     * @param WP_Post $post  The current post object.
     */
    public function add_display_post_states( $post_states, $post ){
        if ( (int)wishsuite_get_option( 'wishlist_page', 'wishsuite_table_settings_tabs' ) === $post->ID ) {
            $post_states['wishsuite_page_for_wishlist_table'] = __( 'WishSuite', 'wishsuite' );
        }
        return $post_states;
    }
    

}