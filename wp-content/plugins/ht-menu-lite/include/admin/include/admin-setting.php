<?php

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly.

class HTMega_Menu_Admin_Settings {

    private $settings_api;

    function __construct() {
        $this->settings_api = new HTMega_Menu_Settings_API();

        add_action( 'admin_init', array( $this, 'admin_init' ) );
        add_action( 'admin_menu', array( $this, 'admin_menu' ), 220 );
        add_action( 'wsa_form_bottom_htmegamenu_general_tabs', array( $this, 'htmega_menu_html_general_tabs' ) );
        add_action( 'wsa_form_bottom_htmegamenu_plugins_tabs', array( $this, 'htmega_menu_html_plugins_library_tabs' ) );
    }

    function admin_init() {

        //set the settings
        $this->settings_api->set_sections( $this->htmega_menu_admin_get_settings_sections() );
        $this->settings_api->set_fields( $this->htmega_menu_admin_fields_settings() );

        //initialize settings
        $this->settings_api->admin_init();
    }

    // Plugins menu Register
    function admin_menu() {
        add_menu_page( 
            __( 'HT Menu', 'htmega-menu' ),
            __( 'HT Menu', 'htmega-menu' ),
            'manage_options',
            'htmegamenu',
            array ( $this, 'plugin_page' ),
            'dashicons-welcome-widgets-menus',
            100
        );
    }

    // Options page Section register
    function htmega_menu_admin_get_settings_sections() {
        $sections = array(
            
            array(
                'id'    => 'htmegamenu_general_tabs',
                'title' => esc_html__( 'General', 'htmega-menu' )
            ),

            array(
                'id'    => 'htmegamenu_style_tabs',
                'title' => esc_html__( 'Style', 'htmega-menu' )
            ),

            array(
                'id'    => 'htmegamenu_plugins_tabs',
                'title' => esc_html__( 'Our Plugins', 'htmega-menu' )
            ),

        );
        return $sections;
    }

    // Options page field register
    protected function htmega_menu_admin_fields_settings() {

        $settings_fields = array(

            'htmegamenu_general_tabs' => array(),
            
            'htmegamenu_style_tabs' => array(

                array(
                    'name'  => 'menu_items_color',
                    'label' => __( 'Menu Items Color', 'htmega-menu' ),
                    'desc' => wp_kses_post( 'Menu Items color.', 'htmega-menu' ),
                    'type' => 'color',
                ),

                array(
                    'name'  => 'menu_items_hover_color',
                    'label' => __( 'Menu Hover & Active Color', 'htmega-menu' ),
                    'desc' => wp_kses_post( 'Menu Items Hover color.', 'htmega-menu' ),
                    'type' => 'color',
                ),

                array(
                    'name'  => 'sub_menu_width',
                    'label' => __( 'Sub Menu Width', 'htmega-menu' ),
                    'desc' => wp_kses_post( 'Sub Menu Width.', 'htmega-menu' ),
                    'min'               => 0,
                    'max'               => 1000,
                    'step'              => '1',
                    'type'              => 'number',
                    'sanitize_callback' => 'floatval'
                ),

                array(
                    'name'  => 'sub_menu_bg_color',
                    'label' => __( 'Sub Menu Background Color', 'htmega-menu' ),
                    'desc' => wp_kses_post( 'Menu Background Color.', 'htmega-menu' ),
                    'type' => 'color',
                ),

                array(
                    'name'  => 'sub_menu_items_color',
                    'label' => __( 'Sub Menu Items Color', 'htmega-menu' ),
                    'desc' => wp_kses_post( 'Sub Menu Items Color.', 'htmega-menu' ),
                    'type' => 'color',
                ),

                array(
                    'name'  => 'sub_menu_items_hover_color',
                    'label' => __( 'Sub Menu Items Hover Color', 'htmega-menu' ),
                    'desc' => wp_kses_post( 'Sub Menu Items Hover Color.', 'htmega-menu' ),
                    'type' => 'color',
                ),

                array(
                    'name'  => 'mega_menu_width',
                    'label' => __( 'Mega Menu Width', 'htmega-menu' ),
                    'desc' => wp_kses_post( 'Mega Menu Width.', 'htmega-menu' ),
                    'min'               => 0,
                    'max'               => 1500,
                    'step'              => '1',
                    'type'              => 'number',
                    'sanitize_callback' => 'floatval'
                ),

                array(
                    'name'  => 'mega_menu_bg_color',
                    'label' => __( 'Mega Menu Background Color', 'htmega-menu' ),
                    'desc' => wp_kses_post( 'Mega Menu Background Color.', 'htmega-menu' ),
                    'type' => 'color',
                ),

            ),

            'htmegamenu_plugins_tabs' => array(),


        );
        
        return array_merge( $settings_fields );
    }


    function plugin_page() {

        echo '<div class="wrap">';
            echo '<h2>'.esc_html__( 'HT Menu Settings','htmega-menu' ).'</h2>';
            $this->save_message();
            $this->settings_api->show_navigation();
            $this->settings_api->show_forms();
        echo '</div>';

    }
    function save_message() {
        if( isset($_GET['settings-updated']) ) { ?>
            <div class="updated notice is-dismissible"> 
                <p><strong><?php esc_html_e('Successfully Settings Saved.', 'htmega-menu') ?></strong></p>
            </div>
            <?php
        }
    }

    // General tab
    function htmega_menu_html_general_tabs(){
        ob_start();
        ?>
            <div class="htmegamenu-general-tabs">

                <div class="htmegamenu-document-section">
                    <div class="htmegamenu-column">
                        <a href="https://hasthemes.com/blog-category/ht-mega-menu/" target="_blank">
                            <img src="<?php echo HTMEGA_MENU_PL_URL; ?>include/admin/assets/images/video-tutorial.jpg" alt="<?php esc_attr_e( 'Video Tutorial', 'htmega-menu' ); ?>">
                        </a>
                    </div>
                    <div class="htmegamenu-column">
                        <a href="https://hasthemes.com/ht-mega-menu-for-elementor-page-builder-documentation/" target="_blank">
                            <img src="<?php echo HTMEGA_MENU_PL_URL; ?>include/admin/assets/images/online-documentation.jpg" alt="<?php esc_attr_e( 'Online Documentation', 'htmega-menu' ); ?>">
                        </a>
                    </div>
                    <div class="htmegamenu-column">
                        <a href="https://hasthemes.com/contact-us/" target="_blank">
                            <img src="<?php echo HTMEGA_MENU_PL_URL; ?>include/admin/assets/images/genral-contact-us.jpg" alt="<?php esc_attr_e( 'Contact Us', 'htmega-menu' ); ?>">
                        </a>
                    </div>
                </div>

                <div class="menudifferent-pro-free">
                    <h3 class="htmegamenu-section-title"><?php echo esc_html__( 'HT Menu Free VS HT Menu Pro.', 'htmega-menu' ); ?></h3>

                    <div class="htmegamenu-admin-row">
                        <div class="features-list-area">
                            <h3><?php echo esc_html__( 'HT Menu Free', 'htmega-menu' ); ?></h3>
                            <ul>
                                <li><?php echo esc_html__( 'Menu Template Option', 'htmega-menu' ); ?></li>
                                <li><?php echo esc_html__( 'Individual Menu Width Control Option', 'htmega-menu' ); ?></li>
                                <li><?php echo esc_html__( 'Sub Menu Position', 'htmega-menu' ); ?></li>
                                <li><?php echo esc_html__( '5 Menu Layouts', 'htmega-menu' ); ?></li>
                                <li class="htdel"><del><?php echo esc_html__( 'Menu Icon Picker', 'htmega-menu' ); ?></del></li>
                                <li class="htdel"><del><?php echo esc_html__( 'Menu Icon Color', 'htmega-menu' ); ?></del></li>
                                <li class="htdel"><del><?php echo esc_html__( 'Menu Badge', 'htmega-menu' ); ?></del></li>
                                <li class="htdel"><del><?php echo esc_html__( 'Menu Badge Color', 'htmega-menu' ); ?></del></li>
                                <li class="htdel"><del><?php echo esc_html__( 'Menu Badge Background Color', 'htmega-menu' ); ?></del></li>
                            </ul>
                            <a class="button button-primary" href="<?php echo esc_url( admin_url() ); ?>plugin-install.php" target="_blank"><?php echo esc_html__( 'Install Now', 'htmega-menu' ); ?></a>
                        </div>
                        <div class="features-list-area">
                            <h3><?php echo esc_html__( 'HT Menu Pro', 'htmega-menu' ); ?></h3>
                            <ul>
                                <li><?php echo esc_html__( 'Menu Template Option', 'htmega-menu' ); ?></li>
                                <li><?php echo esc_html__( 'Individual Menu Width Control Option', 'htmega-menu' ); ?></li>
                                <li><?php echo esc_html__( 'Sub Menu Position', 'htmega-menu' ); ?></li>
                                <li><?php echo esc_html__( '10 Menu Layouts', 'htmega-menu' ); ?></li>
                                <li><?php echo esc_html__( 'Menu Icon Picker', 'htmega-menu' ); ?></li>
                                <li><?php echo esc_html__( 'Menu Icon Color', 'htmega-menu' ); ?></li>
                                <li><?php echo esc_html__( 'Menu Badge', 'htmega-menu' ); ?></li>
                                <li><?php echo esc_html__( 'Menu Badge Color', 'htmega-menu' ); ?></li>
                                <li><?php echo esc_html__( 'Menu Badge Background Color', 'htmega-menu' ); ?></li>
                            </ul>
                            <a class="button button-primary" href="https://hasthemes.com/ht-mega-menu-for-elementor-page-builder/" target="_blank"><?php echo esc_html__( 'Buy Now', 'htmega-menu' ); ?></a>
                        </div>
                    </div>

                </div>

            </div>
        <?php
        echo ob_get_clean();
    }


    // Plugins Library
    function htmega_menu_html_plugins_library_tabs() {
        ob_start();
        ?>
        <div class="htmegamenu-plugins-laibrary">
            <p><?php echo esc_html__( 'Use Our plugins.', 'htmega-menu' ); ?></p>
            <div class="htmegamenu-plugins-area">
                <h3><?php esc_html_e( 'Premium Plugins', 'htmega-menu' ); ?></h3>
                <div class="htmegamenu-plugins-row">
                    
                    <div class="htmegamenu-single-plugins"><img src="<?php echo HTMEGA_MENU_PL_URL; ?>include/admin/assets/images/preview_woolentor-pro.jpg" alt="">
                        <div class="htmegamenu-plugins-content">
                            <h3><?php echo esc_html__( 'WooLentor - WooCommerce Page Builder and WooCommerce Elementor Addon', 'htmega-menu' ); ?></h3>
                            <a href="https://woolentor.com/" class="htmegamenu-button" target="_blank"><?php echo esc_html__( 'Preview', 'htmega-menu' ); ?></a>
                            <a href="https://hasthemes.com/plugins/woolentor-pro-woocommerce-page-builder/" class="htmegamenu-button" target="_blank"><?php echo esc_html__( 'Buy Now', 'htmega-menu' ); ?></a>
                        </div>
                    </div>

                    <div class="htmegamenu-single-plugins"><img src="<?php echo HTMEGA_MENU_PL_URL; ?>/include/admin/assets/images/htbuilder_preview.jpg" alt="">
                        <div class="htmegamenu-plugins-content">
                            <h3><?php echo esc_html__( 'HT Builder Pro - WordPress Theme Builder for Elementor', 'htmega-menu' ); ?></h3>
                            <a href="https://hasthemes.com/plugins/ht-builder-wordpress-theme-builder-for-elementor/" class="htmegamenu-button" target="_blank"><?php echo esc_html__( 'Buy Now', 'htmega-menu' ); ?></a>
                        </div>
                    </div>
                    
                    <div class="htmegamenu-single-plugins"><img src="<?php echo HTMEGA_MENU_PL_URL; ?>include/admin/assets/images/hasbarpro-preview.jpg" alt="">
                        <div class="htmegamenu-plugins-content">
                            <h3><?php echo esc_html__( 'HashBar Pro - WordPress Notification Bar plugin', 'htmega-menu' ); ?></h3>
                            <a href="http://demo.wphash.com/hashbar/" class="htmegamenu-button" target="_blank"><?php echo esc_html__( 'Preview', 'htmega-menu' ); ?></a>
                            <a href="https://hasthemes.com/wordpress-notification-bar-plugin/" class="htmegamenu-button" target="_blank"><?php echo esc_html__( 'Buy Now', 'htmega-menu' ); ?></a>
                        </div>
                    </div>
                    
                    <div class="htmegamenu-single-plugins"><img src="<?php echo HTMEGA_MENU_PL_URL; ?>include/admin/assets/images/htscript-preview.png" alt="">
                        <div class="htmegamenu-plugins-content">
                            <h3><?php echo esc_html__( 'HT Script Pro - Insert Header & Footer Code', 'htmega-menu' ); ?></h3>
                            <a href="https://hasthemes.com/plugins/insert-headers-and-footers-code-ht-script/" class="htmegamenu-button" target="_blank"><?php echo esc_html__( 'Buy Now', 'htmega-menu' ); ?></a>
                        </div>
                    </div>

                </div>

                <h3><?php esc_html_e( 'Free Plugins', 'htmega-menu' ); ?></h3>
                <div class="htmegamenu-plugins-row">
                    <?php self::get_org_plugins(); ?>
                </div>

            </div>
        </div>
        <?php
        echo ob_get_clean();
    }

    /*
     * Plugisn API Data Fetch
     */
    public static function get_org_plugins( $author = 'htplugins' ) {
        
        $plcachekey = 'hastech_plugins';
        $plugins_data = get_transient( $plcachekey );

        if ( !$plugins_data ) {

            $args    = (object) array(
                'author'   => $author,
                'per_page' => '50',
                'page'     => '1',
                'fields'   => array( 'slug', 'name', 'icons', 'version', 'downloaded', 'active_installs' )
            );
            $request = array( 'action' => 'query_plugins', 'timeout' => 15, 'request' => serialize( $args ) );

            //https://codex.wordpress.org/WordPress.org_API
            $url = 'http://api.wordpress.org/plugins/info/1.0/';
            $response = wp_remote_post( $url, array( 'body' => $request ) );
            if ( ! is_wp_error( $response ) ) {
                $plugins_data = array();
                $plugins  = unserialize( $response['body'] );
                if ( isset( $plugins->plugins ) && ( count( $plugins->plugins ) > 0 ) ) {
                    foreach ( $plugins->plugins as $pl_info ) {
                        $plugins_data[] = array(
                            'slug'            => $pl_info->slug,
                            'name'            => $pl_info->name,
                            'icons'           => $pl_info->icons,
                            'version'         => $pl_info->version,
                            'downloaded'      => $pl_info->downloaded,
                            'active_installs' => $pl_info->active_installs
                        );
                    }
                }
                set_transient( $plcachekey, $plugins_data, 24 * HOUR_IN_SECONDS );
            }
        }

        if ( is_array( $plugins_data ) && ( count( $plugins_data ) > 0 ) ) {
            array_multisort( array_column( $plugins_data, 'active_installs' ), SORT_DESC, $plugins_data );
            foreach ( $plugins_data as $pl_data ) {
                ?>
                    <div class="htmegamenu-single-plugins htfree-plugins">
                        <div class="htmegamenu-img">
                            <img src="<?php echo esc_url ( $pl_data['icons']['1x'] ); ?>" alt="<?php echo esc_attr__( $pl_data['name'], 'ht-menu' ); ?>">
                        </div>
                        <div class="htmegamenu-plugins-content">
                            <a href="https://wordpress.org/plugins/<?php echo $pl_data['slug']; ?>/"><h3><?php echo esc_html__( $pl_data['name'], 'ht-menu' ); ?></h3></a>
                            <a class="htmegamenu-button" href="<?php echo esc_url( admin_url() ); ?>plugin-install.php?s=<?php echo $pl_data['slug']; ?>&tab=search&type=term" target="_blank"><?php echo esc_html__( 'Install Now', 'ht-menu' ); ?></a>
                        </div>
                    </div>

                <?php
            }
        }

    }
    

}

new HTMega_Menu_Admin_Settings();