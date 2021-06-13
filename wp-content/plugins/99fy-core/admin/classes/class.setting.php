<?php

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly.

class NNFy_Admin_Settings {

    private $settings_api;

    function __construct() {
        $this->settings_api = new NNFy_Settings_API();

        add_action( 'admin_init', [ $this, 'admin_init' ] );
        add_action( 'admin_menu', [ $this, 'admin_menu' ], 220 );

        add_action( 'wsa_form_bottom_nnfy_general_tabs', [ $this, 'html_general_tabs' ] );

    }

    function admin_init() {

        //set the settings
        $this->settings_api->set_sections( $this->admin_get_settings_sections() );
        $this->settings_api->set_fields( $this->admin_fields_settings() );

        //initialize settings
        $this->settings_api->admin_init();
    }
    
    // Plugins menu Register
    function admin_menu() {

        $menu = 'add_menu_' . 'page';
        $menu(
            'nnfy_panel',
            esc_html__( '99Fy Options', '99fy' ),
            esc_html__( '99Fy Options', '99fy' ),
            'nnfy_option_page',
            NULL,
            'dashicons-admin-generic',
            59
        );
        
        add_submenu_page(
            'nnfy_option_page', 
            esc_html__( '99Fy Options', '99fy' ),
            esc_html__( '99Fy Options', '99fy' ), 
            'manage_options', 
            'nnfy_options', 
            [ $this, 'plugin_page' ]
        );
        
        add_submenu_page(
            'nnfy_option_page', 
            esc_html__( 'Theme Options', '99fy' ),
            esc_html__( 'Theme Options', '99fy' ), 
            'manage_options', 
            'customize.php'
        );
        
        add_submenu_page(
            'nnfy_option_page', 
            esc_html__( 'Recommendations', '99fy' ),
            esc_html__( 'Recommendations', '99fy' ), 
            'manage_options', 
            'nnfy_recommendation', 
            [ $this, 'recommendation_render_html' ]
        );

    }

    // Options page Section register
    function admin_get_settings_sections() {
        $sections = array(

            array(
                'id'    => 'nnfy_general_tabs',
                'title' => esc_html__( 'General', '99fy' )
            ),

        );

        $advance_element = array();

        return array_merge( $sections, $advance_element );
    }

    // Options page field register
    protected function admin_fields_settings() {

        $settings_fields = array(

            'nnfy_general_tabs'=>array(

            ),


        );

        return $settings_fields;
    }


    function plugin_page() {

        echo '<div class="wrap">';
            echo '<h2>'.esc_html__( '99Fy Settings','99fy' ).'</h2>';
            $this->save_message();
            $this->settings_api->show_navigation();
            $this->settings_api->show_forms();
        echo '</div>';

    }

    function save_message() {
        if( isset($_GET['settings-updated']) ) { ?>
            <div class="updated notice is-dismissible"> 
                <p><strong><?php esc_html_e('Successfully Settings Saved.', '99fy') ?></strong></p>
            </div>
            <?php
        }
    }

    // General tab
    function html_general_tabs(){
        ob_start();
        ?>
            <div class="nnfy-general-tabs">

                <div class="nnfy-document-section">
                    <div class="nnfy-column">
                        <a href="https://hasthemes.com/blog-category/99fy/" target="_blank">
                            <img src="<?php echo NNFY_PL_URL; ?>/admin/assets/images/video-tutorial.jpg" alt="<?php esc_attr_e( 'Video Tutorial', '99fy' ); ?>">
                        </a>
                    </div>
                    <div class="nnfy-column">
                        <a href="#" target="_blank">
                            <img src="<?php echo NNFY_PL_URL; ?>/admin/assets/images/online-documentation.jpg" alt="<?php esc_attr_e( 'Online Documentation', '99fy' ); ?>">
                        </a>
                    </div>
                    <div class="nnfy-column">
                        <a href="https://hasthemes.com/contact-us/" target="_blank">
                            <img src="<?php echo NNFY_PL_URL; ?>/admin/assets/images/genral-contact-us.jpg" alt="<?php esc_attr_e( 'Contact Us', '99fy' ); ?>">
                        </a>
                    </div>
                </div>

                <div class="different-pro-free">
                    <h3 class="nnfy-section-title"><?php echo esc_html__( '99Fy Free VS 99Fy Pro.', '99fy' ); ?></h3>

                    <div class="nnfy-admin-row">
                        <div class="features-list-area">
                            <h3><?php echo esc_html__( '99Fy Free', '99fy' ); ?></h3>
                            <ul>
                                <li><?php echo esc_html__( '8 Elementor Addons', '99fy' ); ?></li>
                                <li><?php echo esc_html__( '99 Home Page Include', '99fy' ); ?></li>
                                <li><?php echo esc_html__( 'Topbar ( Hide / show )', '99fy' ); ?></li>
                                <li><?php echo esc_html__( 'Topbar Action Button Control', '99fy' ); ?></li>
                                <li><?php echo esc_html__( 'Breadcrumb 4 Layout', '99fy' ); ?></li>
                                <li><?php echo esc_html__( 'Control Page title and Breadcrumb Options', '99fy' ); ?></li>
                                <li><?php echo esc_html__( 'Breadcrumb and page title custom position', '99fy' ); ?></li>
                                <li><?php echo esc_html__( 'Background Control Options', '99fy' ); ?></li>
                                <li><?php echo esc_html__( 'Blog Column Options', '99fy' ); ?></li>
                                <li><?php echo esc_html__( 'Blog Title length, Excerpt length', '99fy' ); ?></li>
                                <li><?php echo esc_html__( 'Blog Read More button text change options', '99fy' ); ?></li>
                                <li><?php echo esc_html__( 'Blog Meta Control options', '99fy' ); ?></li>
                                <li><?php echo esc_html__( 'Blog page sidebar (Left, right, No sidebar )', '99fy' ); ?></li>
                                <li><?php echo esc_html__( 'Shop page sidebar (Left, right, No sidebar )', '99fy' ); ?></li>
                                <li><?php echo esc_html__( 'Footer Widgets Area hide/show options', '99fy' ); ?></li>
                                <li><?php echo esc_html__( 'Footer Widgets column options', '99fy' ); ?></li>
                                <li><?php echo esc_html__( 'Footer Copyright Area hide/show options', '99fy' ); ?></li>
                                <li><?php echo esc_html__( 'Footer Copyright text change options', '99fy' ); ?></li>
                                <li class="nnfydel"><del><?php echo esc_html__( '5 Header Layouts', '99fy' ); ?></del></li>
                                <li class="nnfydel"><del><?php echo esc_html__( 'Sticky Header Options', '99fy' ); ?></del></li>
                                <li class="nnfydel"><del><?php echo esc_html__( 'Logo Position Options', '99fy' ); ?></del></li>
                                <li class="nnfydel"><del><?php echo esc_html__( 'Blog Sticky Sidebar Options', '99fy' ); ?></del></li>
                                <li class="nnfydel"><del><?php echo esc_html__( 'Shop Sticky Sidebar Options', '99fy' ); ?></del></li>
                                <li class="nnfydel"><del><?php echo esc_html__( '5 Footer Layouts', '99fy' ); ?></del></li>
                                <li class="nnfydel"><del><?php echo esc_html__( 'Sticky Footer Options', '99fy' ); ?></del></li>
                            </ul>
                            <a class="button button-primary" href="<?php echo esc_url( NNFy_Template_Library::instance()->get_pro_link() ); ?>" target="_blank"><?php echo esc_html__( 'Upgrade to Pro', '99fy' ); ?></a>
                        </div>
                        <div class="features-list-area">
                            <h3><?php echo esc_html__( '99Fy Pro', '99fy' ); ?></h3>
                            <ul>
                                <li><?php echo esc_html__( '8 Elementor Addons', '99fy' ); ?></li>
                                <li><?php echo esc_html__( '99 Home Page Include', '99fy' ); ?></li>
                                <li><?php echo esc_html__( 'Topbar ( Hide / show )', '99fy' ); ?></li>
                                <li><?php echo esc_html__( 'Topbar Action Button Control', '99fy' ); ?></li>
                                <li><?php echo esc_html__( 'Breadcrumb 4 Layout', '99fy' ); ?></li>
                                <li><?php echo esc_html__( 'Control Page title and Breadcrumb Options', '99fy' ); ?></li>
                                <li><?php echo esc_html__( 'Breadcrumb and page title custom position', '99fy' ); ?></li>
                                <li><?php echo esc_html__( 'Background Control Options', '99fy' ); ?></li>
                                <li><?php echo esc_html__( 'Blog Column Options', '99fy' ); ?></li>
                                <li><?php echo esc_html__( 'Blog Title length, Excerpt length', '99fy' ); ?></li>
                                <li><?php echo esc_html__( 'Blog Read More button text change options', '99fy' ); ?></li>
                                <li><?php echo esc_html__( 'Blog Meta Control options', '99fy' ); ?></li>
                                <li><?php echo esc_html__( 'Blog page sidebar (Left, right, No sidebar )', '99fy' ); ?></li>
                                <li><?php echo esc_html__( 'Shop page sidebar (Left, right, No sidebar )', '99fy' ); ?></li>
                                <li><?php echo esc_html__( 'Footer Widgets Area hide/show options', '99fy' ); ?></li>
                                <li><?php echo esc_html__( 'Footer Widgets column options', '99fy' ); ?></li>
                                <li><?php echo esc_html__( 'Footer Copyright Area hide/show options', '99fy' ); ?></li>
                                <li><?php echo esc_html__( 'Footer Copyright text change options', '99fy' ); ?></li>
                                <li><?php echo esc_html__( '5 Header Layouts', '99fy' ); ?></li>
                                <li><?php echo esc_html__( 'Sticky Header Options', '99fy' ); ?></li>
                                <li><?php echo esc_html__( 'Logo Position Options', '99fy' ); ?></li>
                                <li><?php echo esc_html__( 'Blog Sticky Sidebar Options', '99fy' ); ?></li>
                                <li><?php echo esc_html__( 'Shop Sticky Sidebar Options', '99fy' ); ?></li>
                                <li><?php echo esc_html__( '5 Footer Layouts', '99fy' ); ?></li>
                                <li><?php echo esc_html__( 'Sticky Footer Options', '99fy' ); ?></li>
                            </ul>
                            <a class="button button-primary" href="<?php echo esc_url( NNFy_Template_Library::instance()->get_pro_link() ); ?>" target="_blank"><?php echo esc_html__( 'Buy Now', '99fy' ); ?></a>
                        </div>
                    </div>

                </div>

            </div>
        <?php
        echo ob_get_clean();
    }

    // Recommendation Menu
    function recommendation_render_html(){
        wp_enqueue_script( 'nnfy-install-manager' );
        ob_start();
        ?>
            <div class="nnfy-row">
                <div class="nnfy-column-1">
                    <h2><?php echo esc_html( get_admin_page_title() ); ?></h2>
                </div>
            </div>
            <div class="nnfy-row">
                <div class="nnfy-column-2">
                    <div class="nnfy-singleplugin">
                        <h3><?php esc_html_e( 'WooCommerce Currency Switcher','99fy' );?></h3>
                        <p><?php esc_html_e( 'If you want to use multi-currency for your store, then wc multi currency is the best free plugin for this.', '99fy' )?></p>
                        <div class="nnfy-button-area">
                            <a class="button primary" href="https://wordpress.org/plugins/wc-multi-currency/" target="_blank"><?php esc_html_e( 'More Details', '99fy' )?></a>
                            <?php nnfy_plugin_install_button( 'wc-multi-currency/wcmilticurrency.php','wc-multi-currency' ); ?>
                        </div>
                    </div>
                </div>
                <div class="nnfy-column-2">
                    <div class="nnfy-singleplugin">
                        <h3><?php esc_html_e( 'Contact Form 7','99fy' );?></h3>
                        <p><?php esc_html_e( 'To create contact forms on your site contact form 7 is the best plugin for you.', '99fy' )?></p>
                        <div class="nnfy-button-area">
                            <a class="button primary" href="https://wordpress.org/plugins/contact-form-7/" target="_blank"><?php esc_html_e( 'More Details', '99fy' )?></a>
                            <?php nnfy_plugin_install_button( 'contact-form-7/wp-contact-form-7.php','contact-form-7' ); ?>
                        </div>
                    </div>
                </div>
                <div class="nnfy-column-2">
                    <div class="nnfy-singleplugin">
                        <h3><?php esc_html_e( 'One Clicks Demo Setup','99fy' );?></h3>
                        <p><?php esc_html_e( 'To make your website same as our theme demo, you can Install this plugin.', '99fy' )?></p>
                        <div class="nnfy-button-area">
                            <a class="button primary" href="https://wordpress.org/plugins/one-click-demo-import/" target="_blank"><?php esc_html_e( 'More Details', '99fy' )?></a>
                            <?php nnfy_plugin_install_button( 'one-click-demo-import/one-click-demo-import.php','one-click-demo-import' ); ?>
                        </div>
                    </div>
                </div>
                <div class="nnfy-column-2">
                    <div class="nnfy-singleplugin">
                        <h3><?php esc_html_e( 'HT Mega','99fy' );?></h3>
                        <p><?php esc_html_e( 'An Absolute plugin for Elementor Addons. More than 30,000 websites are using this plugin.', '99fy' )?></p>
                        <div class="nnfy-button-area">
                            <a class="button primary" href="https://wordpress.org/plugins/ht-mega-for-elementor/" target="_blank"><?php esc_html_e( 'More Details', '99fy' )?></a>
                            <?php nnfy_plugin_install_button( 'ht-mega-for-elementor/htmega_addons_elementor.php','ht-mega-for-elementor' ); ?>
                        </div>
                    </div>
                </div>
            </div>
            <div class="nnfy-row">
                <div class="nnfy-column-1">
                    <a href="https://hasthemes.com/nkoq" target="_blank">
                        <img style="margin-top: 20px; max-width: 100%;" src="https://demo.hasthemes.com/banner/970x250-elementor-guru-hasthemespng.png" alt="">
                    </a>
                </div>
            </div>
        <?php
        echo ob_get_clean();
    }


}

new NNFy_Admin_Settings();