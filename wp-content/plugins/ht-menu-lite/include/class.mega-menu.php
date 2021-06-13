<?php

namespace HTMegaMenuLite;
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class HTMega_Menu_Elementor {

    private static $_instance = null;
    public static function instance() {
        if ( is_null( self::$_instance ) ) {
            self::$_instance = new self();
        }
        return self::$_instance;
    }

    public function __construct() {
        if ( ! function_exists('is_plugin_active')){ include_once( ABSPATH . 'wp-admin/includes/plugin.php' ); }
        add_action( 'init', [ $this, 'i18n' ] );
        add_action( 'plugins_loaded', [ $this, 'init' ] );

        // Body Class
        add_filter( 'body_class', [ $this, 'body_classes' ] );

        // Register Plugin Active Hook
        register_activation_hook( HTMEGA_MENU_PL_ROOT, [ $this, 'plugin_activate_hook' ] );

        // Ajax Callback
        add_action( 'wp_ajax_HT_Mega_Menu_Panels_ajax_requests', [ $this, 'panel_ajax_requests' ] );
    }

    public function i18n() {
        load_plugin_textdomain( 'htmega-menu' );
    }

    protected function setMode() {
        if ( is_admin() ) {
            $this->mode = 'admin';
        } else {
            $this->mode = 'frontend';
        }
    }

    // Body Class
    public function body_classes( $classes ){
        $classes[] = 'htmega-menu-active';
        return $classes;
    }

    public function init() {
        // Set current mode
        $this->setMode();

        // Menu Lite Plugin
        if( is_plugin_active('ht-menu/ht-mega-menu.php') ) {
            add_action( 'admin_init', [ $this, 'plugins_deactivate' ] );
            add_action( 'admin_notices', [ $this, 'menu_pro_notice' ] );
            return;
        }

        // Check if Elementor installed and activated
        if ( ! did_action( 'elementor/loaded' ) ) {
            add_action( 'admin_notices', array( $this, 'admin_notice_missing_main_plugin' ) );
            return;
        }

        // Plugins Required File
        $this->includes();

        // After Active Plugin then redirect to setting page
        $this->plugin_redirect_option_page();

        if( $this->mode === 'admin' ) {
            // If the user can manage options, let the fun begin!
            if ( current_user_can( 'manage_options' ) ) {
                add_action( 'admin_init', array( $this, 'register_nav_meta_box' ), 9 );
            }
        }

         // Plugins Setting Page
        add_filter('plugin_action_links_'.HTMEGA_MENU_PLUGIN_BASE, [ $this, 'plugins_setting_links' ] );

        // Add Plugin actions
        add_action( 'elementor/widgets/widgets_registered', [ $this, 'init_widgets' ] );

        // Admin Scripts
        add_action('admin_enqueue_scripts', array( $this, 'htmega_megamenu_admin_scripts_method' ) );

        add_action( 'admin_footer', array( $this, 'htmega_menu_pop_up_content' ) );

        // Frontend Scripts
        add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_frontend_scripts' ) );
        add_action( 'wp_enqueue_scripts', array( $this, 'htmega_menu_styles_inline' ) );

    }

    public function is_plugins_active( $pl_file_path = NULL ){
        $installed_plugins_list = get_plugins();
        return isset( $installed_plugins_list[$pl_file_path] );
    }

    public function admin_notice_missing_main_plugin() {

        if ( isset( $_GET['activate'] ) ) unset( $_GET['activate'] );

        $elementor = 'elementor/elementor.php';
        if( $this->is_plugins_active( $elementor ) ) {

            if( ! current_user_can( 'activate_plugins' ) ) { return; }

            $activation_url = wp_nonce_url( 'plugins.php?action=activate&amp;plugin=' . $elementor . '&amp;plugin_status=all&amp;paged=1&amp;s', 'activate-plugin_' . $elementor );

            $message = '<p>' . __( 'HT Mega Menu not Working because you need to activate the Elementor plugin.', 'htmega-menu' ) . '</p>';
            $message .= '<p>' . sprintf( '<a href="%s" class="button-primary">%s</a>', $activation_url, __( 'Activate Now', 'htmega-menu' ) ) . '</p>';

        } else {
            if ( ! current_user_can( 'install_plugins' ) ) { return; }

            $install_url = wp_nonce_url( self_admin_url( 'update.php?action=install-plugin&plugin=elementor' ), 'install-plugin_elementor' );

            $message = '<p>' . __( 'HT Mega Menu not Working because you need to install the Elementor plugin.', 'htmega-menu' ) . '</p>';

            $message .= '<p>' . sprintf( '<a href="%s" class="button-primary">%s</a>', $install_url, __( 'Install Now', 'htmega-menu' ) ) . '</p>';
        }
        echo '<div class="error"><p>' . $message . '</p></div>';
    }

    // Menu Lite Notice
    public function menu_pro_notice() {
        echo '<div class="notice notice-warning"><p>' . esc_html__( 'Please deactivate HT Menu Lite before activating HT Menu.', 'htmega-menu' ) . '</p></div>';
        if ( isset( $_GET['activate'] ) ) {
            unset( $_GET['activate'] );
        }
    }

    // Plugins Deactive
    public function plugins_deactivate() {
        deactivate_plugins( 'ht-menu/ht-mega-menu.php' );
    }

    // Add settings link on plugin page.
    public function plugins_setting_links( $links ) {
        $settings_link = '<a href="'.admin_url('admin.php?page=htmegamenu').'">'.esc_html__( 'Settings', 'htmega-menu' ).'</a>'; 
        array_unshift( $links, $settings_link );
        $links['htmegamenu_pro'] = sprintf('<a href="https://hasthemes.com/ht-mega-menu-for-elementor-page-builder/" target="_blank" style="color: #39b54a; font-weight: bold;">' . esc_html__('Go Pro','htmega-menu') . '</a>');
        return $links; 
    }

    /* 
    * Plugins After Install
    * Redirect Setting page
    */
    public function plugin_activate_hook() {
        add_option('htmegamenu_do_activation_redirect', TRUE);
    }
    public function plugin_redirect_option_page() {
        if ( get_option( 'htmegamenu_do_activation_redirect', FALSE ) ) {
            delete_option('htmegamenu_do_activation_redirect');
            if( !isset( $_GET['activate-multi'] ) ){
                wp_redirect( admin_url("admin.php?page=htmegamenu") );
            }
        }
    }

    // Meta Box Field render
    public function register_nav_meta_box() {
        global $pagenow;
        if ( 'nav-menus.php' == $pagenow ) {
            add_meta_box(
                'HT_Mega_Menu_meta_box',
                __("Mega menu Settings", ""),
                array( $this, 'metabox_contents' ),
                'nav-menus',
                'side',
                'core'
            );
        }
    }

    public function metabox_contents(){
        // Get recently edited nav menu.
        $recently_edited = absint( get_user_option( 'nav_menu_recently_edited' ) );
        $nav_menu_selected_id = isset( $_REQUEST['menu'] ) ? absint( $_REQUEST['menu'] ) : 0;
        if ( empty( $recently_edited ) && is_nav_menu( $nav_menu_selected_id ) )
            $recently_edited = $nav_menu_selected_id;
        
        // Use $recently_edited if none are selected.
        if ( empty( $nav_menu_selected_id ) && ! isset( $_GET['menu'] ) && is_nav_menu( $recently_edited ) )
            $nav_menu_selected_id = $recently_edited;
        
        $options = get_option( "ht_menu_options_" . $nav_menu_selected_id );

    ?>
        <div id="htmegamenu-menu-metabox">

            <?php wp_nonce_field( basename( __FILE__ ), 'htmegamenu_menu_metabox_noce' ); ?>
            <input type="hidden" value="<?php echo esc_attr( $nav_menu_selected_id ); ?>" id="htmegamenu-metabox-input-menu-id" />
            <p>
                <label><strong><?php esc_html_e( "Enable megamenu?", 'htmega-menu' ); ?></strong></label>
                <input type="checkbox" class="alignright pull-right-input" id="htmegamenu-menu-metabox-input-is-enabled" <?php echo isset($options['enable_menu']) && $options['enable_menu'] == 'on' ? 'checked="true"' : '' ?>>
            </p>
            <p>
                <?php echo get_submit_button( esc_html__('Save', 'htmega-menu'), 'htmegamenu-menu-settings-save button-primary alignright','', false); ?>
                <span class='spinner'></span>
            </p>

        </div>

    <?php
    }

    public function panel_ajax_requests(){

        $action = isset( $_REQUEST['sub_action'] ) ? $_REQUEST['sub_action'] : '';
        
        if( $action === 'save_menu_settings' ){
            $this->menu_item_id = absint( $_REQUEST['menu_item_id'] );
            update_post_meta( $this->menu_item_id, 'ht_menu_settings', array(
                'type' => isset( $_REQUEST['menu_type'] ) ? sanitize_text_field( $_REQUEST['menu_type'] ) : ''
            ) );
            die('valid');
        }
        
        if( $action === 'save_menu_options' ){
            $settings = isset($_REQUEST['settings']) ? $_REQUEST['settings'] : array();
            $menu_id = absint( $_REQUEST['menu_id'] );
            update_option( 'ht_menu_options_' . $menu_id, $settings );
            die('valid');
        } 
    }

    public function init_widgets() {
        require_once ( HTMEGA_MENU_PL_PATH.'include/widgets/inline-mega-menu.php' );
        require_once ( HTMEGA_MENU_PL_PATH.'include/widgets/verticle-mega-menu.php' );
    }

    public function includes() {
        // Include files
        require_once ( HTMEGA_MENU_PL_PATH . 'include/helper-function.php' );
        require_once ( HTMEGA_MENU_PL_PATH . 'include/admin/admin-init.php' );
        require_once ( HTMEGA_MENU_PL_PATH . 'include/menu/htmenu_menu.php' );
    }

    // enqueue frontend scripts
    public function enqueue_frontend_scripts(){
        
        // CSS File
        wp_enqueue_style(  'htmega-menu',  HTMEGA_MENU_PL_URL . 'assets/css/mega-menu-style.css', array(), HTMEGA_MENU_VERSION );

        // JS File
        wp_enqueue_script( 'htmegamenu-main', HTMEGA_MENU_PL_URL . 'assets/js/htmegamenu-main.js', array('jquery') );

    }

    public function htmega_megamenu_admin_scripts_method($hook){

        wp_enqueue_script('fonticonpicker.js', HTMEGA_MENU_PL_URL . 'include/admin/assets/js/jquery.fonticonpicker.min.js',
            array('jquery'));

        wp_enqueue_style( 'fonticonpicker', HTMEGA_MENU_PL_URL . 'include/admin/assets/css/jquery.fonticonpicker.min.css' );
        
        wp_enqueue_style( 'fonticonpicker-bootstrap', HTMEGA_MENU_PL_URL . 'include/admin/assets/css/jquery.fonticonpicker.bootstrap.min.css');

        $icons = $this->htmega_menu_get_icon_sets();
        wp_add_inline_script('htmegamenu-admin', $icons);

    }

    public function htmega_menu_get_icon_sets(){

        $icon_set = array();
        $icon_set['FontAwesome'][] = 'Pro';
           
        ob_start(); ?>
        <script type="text/javascript">
            var htmegaIconsSet = <?php echo json_encode($icon_set); ?>;

            ( function( $ ) {
                    
                $(function() {
                    $( '.htmegamenu-pro' ).click(function() {
                        $( "#htmegapro-dialog" ).dialog({
                            modal: true,
                            minWidth: 500,
                            buttons: {
                                Ok: function() {
                                  $( this ).dialog( "close" );
                                }
                            }
                        });
                    });
                    $(".htmegamenu-pro .wp-picker-container .wp-color-result,.htmegamenu-pro input").attr("disabled", true);
                });

            } )( jQuery );
        </script>
        <?php
        $r = ob_get_clean();
        $remove = array('<script type="text/javascript">', '</script>');
        $r = str_replace($remove, '', $r);
        return $r;
    }

    public function htmega_menu_pop_up_content(){
        ob_start();
        ?>
            <div id="htmegapro-dialog" title="<?php esc_html_e( 'Go Premium', 'htmega-menu' ); ?>" style="display: none;">
                <div class="htmega-dialog-content">
                    <span><i class="dashicons dashicons-warning"></i></span>
                    <p>
                        <?php
                            echo __('Purchase our','htmega-menu').' <strong><a href="'.esc_url( 'https://hasthemes.com/ht-mega-menu-for-elementor-page-builder/' ).'" target="_blank" rel="nofollow">'.__( 'premium version', 'htmega-menu' ).'</a></strong> '.__('to unlock these pro options!','htmega-menu');
                        ?>
                    </p>
                </div>
            </div>
        <?php
        echo ob_get_clean();
    }

    /**
    * Add Inline CSS.
    */
    public function htmega_menu_styles_inline() {

        $menu_item_color = $menu_item_hover_color = $sub_menu_width = $sub_menu_bg = $sub_menu_itemcolor = $sub_menu_itemhover_color = $mega_menu_width = $mega_menu_bg = '';

        $menuitemscolor         = htmega_menu_get_option( 'menu_items_color', 'htmegamenu_style_tabs' );
        $menuitemshovercolor    = htmega_menu_get_option( 'menu_items_hover_color', 'htmegamenu_style_tabs' );
        $submenuwidth           = htmega_menu_get_option( 'sub_menu_width', 'htmegamenu_style_tabs' );
        $submenubg              = htmega_menu_get_option( 'sub_menu_bg_color', 'htmegamenu_style_tabs' );
        $submenuitemcolor       = htmega_menu_get_option( 'sub_menu_items_color', 'htmegamenu_style_tabs' );
        $submenuitemhovercolor  = htmega_menu_get_option( 'sub_menu_items_hover_color', 'htmegamenu_style_tabs' );
        $megamenuwidth          = htmega_menu_get_option( 'mega_menu_width', 'htmegamenu_style_tabs' );
        $megamenubg             = htmega_menu_get_option( 'mega_menu_bg_color', 'htmegamenu_style_tabs' );

        if( !empty($menuitemscolor) ){
            $menu_item_color = "
                .htmega-menu-container ul > li > a{
                    color: {$menuitemscolor};
                }
            ";
        }

        if( !empty($menuitemshovercolor) ){
            $menu_item_hover_color = "
                .htmega-menu-container ul > li.current_page_item  > a,
                .htmega-menu-container ul > li > a:hover{
                    color: {$menuitemshovercolor};
                }
            ";
        }

        if( !empty($submenuwidth) ){
            $sub_menu_width = "
                .htmega-menu-container .sub-menu{
                    width: {$submenuwidth}px;
                }
            ";
        }

        if( !empty($submenubg) ){
            $sub_menu_bg = "
                .htmega-menu-container .sub-menu{
                    background-color: {$submenubg};
                }
            ";
        }

        if( !empty($submenuitemcolor) ){
            $sub_menu_itemcolor = "
                .htmega-menu-container .sub-menu li a{
                    color: {$submenuitemcolor};
                }
            ";
        }

        if( !empty($submenuitemhovercolor) ){
            $sub_menu_itemhover_color = "
                .htmega-menu-container .sub-menu li a:hover{
                    color: {$submenuitemhovercolor};
                }
            ";
        }

        if( !empty($megamenuwidth) ){
            $mega_menu_width = "
                .htmega-menu-container .htmegamenu-content-wrapper{
                    width: {$megamenuwidth}px;
                }
            ";
        }

        if( !empty($megamenubg) ){
            $mega_menu_bg = "
                .htmega-menu-container .htmegamenu-content-wrapper{
                    background-color: {$megamenubg};
                }
            ";
        }

        $custom_css = "
            $menu_item_color
            $menu_item_hover_color
            $sub_menu_width
            $sub_menu_bg
            $sub_menu_itemcolor
            $sub_menu_itemhover_color
            $mega_menu_width
            $mega_menu_bg
            ";
        wp_add_inline_style( 'htmega-menu', $custom_css );
    }


}

HTMega_Menu_Elementor::instance();