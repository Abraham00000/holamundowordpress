<?php

namespace NNfy;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

/**
* Base Class
*/
class Base{

    const MINIMUM_ELEMENTOR_VERSION = '2.0.0';
    const MINIMUM_PHP_VERSION = '7.0';
    
    private static $_instance = null;
    public static function instance(){
        if( is_null( self::$_instance ) ){
            self::$_instance = new self();
        }
        return self::$_instance;
    }

    function __construct(){
        if ( ! function_exists('is_plugin_active') ){ include_once( ABSPATH . 'wp-admin/includes/plugin.php' ); }
        add_action( 'init', [ $this, 'i18n' ] );
        add_action( 'plugins_loaded', [ $this, 'init' ] );

        // Plugin Active Hook
        register_activation_hook( NNFY_PL_ROOT, [ $this, 'plugin_activate_hook'] );
        
        // Plugin Deactivate Hook
        register_deactivation_hook( NNFY_PL_ROOT, [ $this, 'plugin_deactivation_hook' ] );

    }

    /*
    * Load Text Domain
    */
    public function i18n() {
        load_plugin_textdomain( '99fy', false, dirname( plugin_basename( NNFY_PL_ROOT ) ) . '/languages/' );
    }

    /*
    * Plugins Loaded Hook Call Back Function
    */
    public function init(){

        // Check if Elementor installed and activated
        if ( ! did_action( 'elementor/loaded' ) ) {
            add_action( 'admin_notices', [ $this, 'admin_notice_missing_main_plugin' ] );
            return;
        }

        // Check for required Elementor version
        if ( ! version_compare( ELEMENTOR_VERSION, self::MINIMUM_ELEMENTOR_VERSION, '>=' ) ) {
            add_action( 'admin_notices', [ $this, 'admin_notice_minimum_elementor_version' ] );
            return;
        }

        // Check for required PHP version
        if ( version_compare( PHP_VERSION, self::MINIMUM_PHP_VERSION, '<' ) ) {
            add_action( 'admin_notices', [ $this, 'admin_notice_minimum_php_version' ] );
            return;
        }

        // Plugins Setting Page
        add_filter('plugin_action_links_'.NNFY_PLUGIN_BASE, [ $this, 'plugins_setting_links' ] );

        // Include File
        $this->include_files();

        // After Active Plugin then redirect to setting page
        $this->plugin_redirect_option_page();

    }

    /*
    * Notice For Elementor Install / Activation
    */
    public function admin_notice_missing_main_plugin() {
        if ( isset( $_GET['activate'] ) ) unset( $_GET['activate'] );
        $message = sprintf(
            /* translators: 1: Plugin name 2: Elementor */
            esc_html__( '"%1$s" requires "%2$s" to be installed and activated.', '99fy' ),
            '<strong>' . esc_html__( '99Fy Core', '99fy' ) . '</strong>',
            '<strong>' . esc_html__( 'Elementor', '99fy' ) . '</strong>'
        );
        printf( '<div class="notice notice-warning is-dismissible"><p>%1$s</p></div>', $message );
    }

    /*
    * Notice For Elementor Requires Version
    */
    public function admin_notice_minimum_elementor_version() {
        if ( isset( $_GET['activate'] ) ) unset( $_GET['activate'] );
        $message = sprintf(
            /* translators: 1: Plugin name 2: Elementor 3: Required Elementor version */
            esc_html__( '"%1$s" requires "%2$s" version %3$s or greater.', '99fy' ),
            '<strong>' . esc_html__( '99Fy Core', '99fy' ) . '</strong>',
            '<strong>' . esc_html__( 'Elementor', '99fy' ) . '</strong>',
             self::MINIMUM_ELEMENTOR_VERSION
        );
        printf( '<div class="notice notice-warning is-dismissible"><p>%1$s</p></div>', $message );
    }

    /*
    * Notice For PHP Requires Version
    */
    public function admin_notice_minimum_php_version() {
        if ( isset( $_GET['activate'] ) ) unset( $_GET['activate'] );
        $message = sprintf(
            /* translators: 1: Plugin name 2: PHP 3: Required PHP version */
            esc_html__( '"%1$s" requires "%2$s" version %3$s or greater.', '99fy' ),
            '<strong>' . esc_html__( '99Fy Core', '99fy' ) . '</strong>',
            '<strong>' . esc_html__( 'PHP', '99fy' ) . '</strong>',
             self::MINIMUM_PHP_VERSION
        );
        printf( '<div class="notice notice-warning is-dismissible"><p>%1$s</p></div>', $message );
    }

    /* 
    * Plugin Activation Hook
    */
    public function plugin_activate_hook() {
        add_option( 'nnfy_do_activation_redirect', TRUE );
        delete_transient( 'nnfy_template_info' );

        $nnfy_opt_field = array(
            'page_title_status'         => 1,
            'breadcrumb_status'         => 1,
            'footer_top_status'         => 1,
            'footer_copyright_status'   => 1,
        );

        foreach ( $nnfy_opt_field as $opt => $value ) {
            $optfield = 'nnfy_'.$opt;
            if( empty( get_option( $optfield ) ) || get_option( $optfield ) ){
                update_option( $optfield, $value );
            }else{
                add_option( $optfield, $value );
            }
        }

    }

    /**
     * Plugin deactivation Hook
     */
    public function plugin_deactivation_hook(){
        delete_transient( 'nnfy_template_info' );
        
        $nnfy_opt_field = array(
            'page_title_status',
            'breadcrumb_status',
            'footer_top_status',
            'footer_copyright_status',
        );

        if ( !is_multisite() ){
            foreach ( $nnfy_opt_field as $fieldname ) {
                $optfield = 'nnfy_'.$fieldname;
                delete_option( $optfield );
            }
        }

    }

    /*
    * After Active Plugin then redirect page
    */
    public function plugin_redirect_option_page() {
        if ( get_option( 'nnfy_do_activation_redirect', FALSE ) ) {
            delete_option('nnfy_do_activation_redirect');
            if( !isset( $_GET['activate-multi'] ) ){
                wp_redirect( admin_url("admin.php?page=nnfy_options") );
            }
        }
    }

    /* 
    * Add settings link on plugin page.
    */
    public function plugins_setting_links( $links ) {
        $settings_link = '<a href="'.admin_url('customize.php').'">'.esc_html__( 'Settings', '99fy' ).'</a>'; 
        array_unshift( $links, $settings_link );
        if( !is_plugin_active('99fy-pro/nnfy_pro.php') && class_exists('NNFy_Template_Library') ){
            $links['nnfygo_pro'] = sprintf('<a href="%1$s" target="_blank" style="color: #39b54a; font-weight: bold;">%2$s</a>',esc_url( \NNFy_Template_Library::instance()->get_pro_link() ), esc_html__('Go Pro','99fy') );
        }
        return $links; 
    }

    /*
    * Include File
    */
    public function include_files() {

        require( NNFY_PL_PATH . 'includes/helper_functions.php' );
        require( NNFY_PL_PATH .'includes/demo_importer.php' );
        require( NNFY_PL_PATH .'includes/fontawesome.php' );
        require( NNFY_PL_PATH . 'classes/class.scripts_manager.php' );
        require( NNFY_PL_PATH .'classes/class.widgets_control.php' );
        require( NNFY_PL_PATH . 'admin/classes/class.settings_api.php');

        // Template Library
        if( is_admin() ){
            require_once( NNFY_PL_PATH. 'admin/classes/template-library.php' );
        }

        // Pro Not install
        if ( ! is_plugin_active( '99fy-pro/nnfy_pro.php' ) ) {
            require( NNFY_PL_PATH .'admin/classes/class.setting.php' );
            require( NNFY_PL_PATH .'admin/classes/class.elementor_options.php' );
        }

        // Customizer Field
        if ( class_exists( 'WP_Customize_Control' ) ) {
            require( NNFY_PL_PATH . 'admin/classes/customizer/class.customizer_info_control.php' );
            require( NNFY_PL_PATH . 'admin/classes/customizer/class.customizer_separator_control.php' );
            require( NNFY_PL_PATH . 'admin/classes/customizer/class.customizer_toggle_control.php' );
            require( NNFY_PL_PATH . 'admin/classes/customizer/class.customizer_range_value_control.php' );
            require( NNFY_PL_PATH . 'admin/classes/customizer/class.customizer_repeater_control.php' );
            require( NNFY_PL_PATH . 'admin/classes/customizer/class.sanitization_callbacks.php' );
            require( NNFY_PL_PATH . 'admin/classes/customizer/class.customizer.php' );
        }

    }


}