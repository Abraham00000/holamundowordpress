<?php

namespace NNfy;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

 /**
 * Scripts Manager
 */
 class NNFy_Scripts{

    private static $instance = null;

    public static function instance() {
        if ( is_null( self::$instance ) ) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    function __construct(){
        $this->init();
    }

    public function init() {

        // Register Scripts
        add_action( 'wp_enqueue_scripts', [ $this, 'register_assets' ] );
        add_action( 'admin_enqueue_scripts', [ $this, 'register_assets' ] );

        // Admin Scripts
        add_action('admin_enqueue_scripts', [ $this, 'enqueue_admin_scripts' ] );

        // Frontend Scripts
        add_action( 'wp_enqueue_scripts', [ $this, 'enqueue_frontend_scripts' ] );

    }

    /**
     * All available styles
     *
     * @return array
     */
    public function get_styles() {
        $style_list = [

            'nnfy-main' => [
                'src'     => NNFY_ASSETS . 'css/nnfy-main.css',
                'version' => NNFY_VERSION
            ],
            'nnfy-admin' => [
                'src'     => NNFY_ADMIN_ASSETS . 'css/admin-options.css',
                'version' => NNFY_VERSION
            ],
            'selectric' => [
                'src'     => NNFY_ADMIN_ASSETS . 'lib/css/selectric.css',
                'version' => NNFY_VERSION
            ],
            'nnfy-temlibray-style' => [
                'src'     => NNFY_ADMIN_ASSETS . 'css/tmp-style.css',
                'version' => NNFY_VERSION
            ],

        ];

        return $style_list;
    }

    /**
     * All available scripts
     *
     * @return array
     */
    public function get_scripts() {
        $script_list = [

            'nnfy-main' => [
                'src'     => NNFY_ASSETS . 'js/nnfy-main.js',
                'version' => NNFY_VERSION,
                'deps'    => [ 'jquery' ]
            ],
            'nnfy-modernizr' => [
                'src'     => NNFY_ADMIN_ASSETS . 'lib/js/modernizr.custom.63321.js',
                'version' => NNFY_VERSION,
                'deps'    => [ 'jquery' ]
            ],
            'jquery-selectric' => [
                'src'     => NNFY_ADMIN_ASSETS . 'lib/js/jquery.selectric.min.js',
                'version' => NNFY_VERSION,
                'deps'    => [ 'jquery' ]
            ],
            'jquery-ScrollMagic' => [
                'src'     => NNFY_ADMIN_ASSETS . 'lib/js/ScrollMagic.min.js',
                'version' => NNFY_VERSION,
                'deps'    => [ 'jquery' ]
            ],
            'babel-min' => [
                'src'     => NNFY_ADMIN_ASSETS . 'lib/js/babel.min.js',
                'version' => NNFY_VERSION,
                'deps'    => [ 'jquery' ]
            ],
            'nnfy-templates' => [
                'src'     => NNFY_ADMIN_ASSETS . 'js/template_library_manager.js',
                'version' => NNFY_VERSION,
                'deps'    => [ 'jquery-selectric','jquery-ScrollMagic','babel-min' ]
            ],
            'nnfy-install-manager' => [
                'src'     => NNFY_ADMIN_ASSETS . 'js/install_manager.js',
                'version' => NNFY_VERSION,
                'deps'    => [ 'nnfy-templates', 'wp-util', 'updates' ]
            ],

        ];

        return $script_list;
    }

    /**
     * Register scripts and styles
     *
     * @return void
     */
    public function register_assets() {

        $scripts = $this->get_scripts();
        $styles  = $this->get_styles();

        // Register Scripts
        foreach ( $scripts as $handle => $script ) {
            $deps = ( isset( $script['deps'] ) ? $script['deps'] : false );
            wp_register_script( $handle, $script['src'], $deps, $script['version'], true );
        }

        // Register Styles
        foreach ( $styles as $handle => $style ) {
            $deps = ( isset( $style['deps'] ) ? $style['deps'] : false );
            wp_register_style( $handle, $style['src'], $deps, $style['version'] );
        }

        // For Admin
        if( is_admin() ){

            //Localize Scripts For template Library
            $current_user  = wp_get_current_user();
            $localize_data = [
                'ajaxurl'          => admin_url( 'admin-ajax.php' ),
                'adminURL'         => admin_url(),
                'elementorURL'     => admin_url( 'edit.php?post_type=elementor_library' ),
                'version'          => NNFY_VERSION,
                'pluginURL'        => plugin_dir_url( __FILE__ ),
                'alldata'          => ( !empty( \NNFy_Template_Library::instance()->get_templates_info()['templates'] ) ? \NNFy_Template_Library::instance()->get_templates_info()['templates']:array() ),
                'prolink'          => ( !empty( \NNFy_Template_Library::instance()->get_pro_link() ) ? \NNFy_Template_Library::instance()->get_pro_link() : '#' ),
                'prolabel'         => esc_html__( 'Pro', '99fy' ),
                'loadingimg'       => NNFY_ADMIN_ASSETS . 'images/loading.gif',
                'message'          =>[
                    'packagedesc'=> esc_html__( 'in this package', '99fy' ),
                    'allload'    => esc_html__( 'All Items have been Loaded', '99fy' ),
                    'notfound'   => esc_html__( 'Nothing Found', '99fy' ),
                ],
                'buttontxt'      =>[
                    'tmplibrary' => esc_html__( 'Import to Library', '99fy' ),
                    'tmppage'    => esc_html__( 'Import to Page', '99fy' ),
                    'import'     => esc_html__( 'Import', '99fy' ),
                    'buynow'     => esc_html__( 'Buy Now', '99fy' ),
                    'preview'    => esc_html__( 'Preview', '99fy' ),
                    'installing' => esc_html__( 'Installing..', '99fy' ),
                    'activating' => esc_html__( 'Activating..', '99fy' ),
                    'active'     => esc_html__( 'Active', '99fy' ),
                ],
                'user'           => [
                    'email' => $current_user->user_email,
                ],
            ];
            wp_localize_script( 'nnfy-templates', 'NNFYTM', $localize_data );
        }
        
    }

    /**
    * Admin Scripts
    */

    public function enqueue_admin_scripts( $hook ){

        if( '99fy-options_page_nnfy_options' == $hook || '99fy-options_page_nnfy_recommendation' == $hook || '99fy-options_page_nnfy_templates' == $hook ){
        
            // Admin styles
            wp_enqueue_style( 'nnfy-admin' );

            // wp core styles
            wp_enqueue_style( 'wp-jquery-ui-dialog' );
            // wp core scripts
            wp_enqueue_script( 'jquery-ui-dialog' );
            
        }

    }

    /**
     * Enqueue frontend scripts
     */
    public function enqueue_frontend_scripts() {

        // CSS
        wp_enqueue_style( 'nnfy-main' );

        // JS
        wp_enqueue_script( 'nnfy-main' );

    }
    

}

NNFy_Scripts::instance();