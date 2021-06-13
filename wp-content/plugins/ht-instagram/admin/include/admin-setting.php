<?php

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly.

if ( ! function_exists('is_plugin_active')){ include_once( ABSPATH . 'wp-admin/includes/plugin.php' ); }

class HTinstagram_Admin_Settings {

    private $settings_api;

    function __construct() {
        $this->settings_api = new HTinstagram_Settings_API;

        add_action( 'admin_init', array( $this, 'admin_init' ) );
        add_action( 'admin_menu', array( $this, 'admin_menu' ), 220 );
        add_action( 'wsa_form_bottom_htinstagram_shortcodeopt_tabs', array( $this, 'htinstagram_shortcode_opt_table' ) );
    }

    function admin_init() {

        //set the settings
        $this->settings_api->set_sections( $this->htinstagram_admin_get_settings_sections() );
        $this->settings_api->set_fields( $this->htinstagram_admin_fields_settings() );

        //initialize settings
        $this->settings_api->admin_init();
    }

    // Plugins menu Register
    function admin_menu() {
        add_menu_page( 
            __( 'WP Instagram', 'ht-instagram' ),
            __( 'WP Instagram', 'ht-instagram' ),
            'manage_options',
            'htinstagram',
            array ( $this, 'plugin_page' ),
            HTINSTA_PL_URL.'assests/images/menu-logo.png',
            100
        );
    }

    // Options page Section register
    function htinstagram_admin_get_settings_sections() {
        $sections = array(
            
            array(
                'id'    => 'htinstagram_general_tabs',
                'title' => esc_html__( 'General', 'ht-instagram' )
            ),

            array(
                'id'    => 'htinstagram_widgets_style_tabs',
                'title' => esc_html__( 'Widgets', 'ht-instagram' )
            ),

            array(
                'id'    => 'htinstagram_shortcodeopt_tabs',
                'title' => esc_html__( 'Shortcode ', 'ht-instagram' )
            ),

        );
        return $sections;
    }

    // Options page field register
    protected function htinstagram_admin_fields_settings() {

        $settings_fields = array(

            'htinstagram_general_tabs'=>array(

                array(
                    'name'  => 'instagram_access_token',
                    'label' => __( 'Access Token', 'ht-instagram' ),
                    'placeholder' => __( 'Access Token', 'ht-instagram' ),
                    'type' => 'text',
                    'sanitize_callback' => 'sanitize_text_field',
                     'desc'   => wp_kses_post( '(<a href="'.esc_url('https://developers.facebook.com/docs/instagram-basic-display-api/getting-started').'" target="_blank">Lookup your Access Token</a>)', 'ht-instagram' ),
                ),

            ),

            'htinstagram_widgets_style_tabs'=>array(

                array(
                    'name'  => 'widgets_style_title',
                    'label'  => __( '<h2 class="htinstaop-headding">Style</h2>', 'ht-instagram' ),
                    'type'  => 'title',
                    'class'=>'htoptions_headding_table_row',
                ),

                array(
                    'name'  => 'likecommentbg',
                    'label' => __( 'Caption Background', 'ht-instagram' ),
                    'desc' => wp_kses_post( 'You can handle caption area background.', 'ht-instagram' ),
                    'type' => 'color',
                ),

                array(
                    'name'  => 'commentlike_color',
                    'label' => __( 'Caption Color', 'ht-instagram' ),
                    'desc' => wp_kses_post( 'You can caption color.', 'ht-instagram' ),
                    'type' => 'color',
                ),

                array(
                    'name'  => 'commentlike_font_size',
                    'label' => __( 'Caption Font Size', 'ht-instagram' ),
                    'desc' => wp_kses_post( 'You can handle caption font size.', 'ht-instagram' ),
                    'min'               => 0,
                    'max'               => 100,
                    'step'              => '1',
                    'type'              => 'number',
                    'sanitize_callback' => 'floatval'
                ),

                array(
                    'name'  => 'follow_background',
                    'label' => __( 'Follow Button Background Color', 'ht-instagram' ),
                    'desc' => wp_kses_post( 'You can handle follow button background.', 'ht-instagram' ),
                    'type' => 'color',
                ),

                array(
                    'name'  => 'follow_buttoncolor',
                    'label' => __( 'Follow Button Color', 'ht-instagram' ),
                    'desc' => wp_kses_post( 'You can handle follow button color.', 'ht-instagram' ),
                    'type' => 'color',
                ),

                array(
                    'name'  => 'follow_button_f_s',
                    'label' => __( 'Follow Button Font Size', 'ht-instagram' ),
                    'desc' => wp_kses_post( 'You can handle follow button font size.', 'ht-instagram' ),
                    'min'               => 0,
                    'max'               => 100,
                    'step'              => '1',
                    'type'              => 'number',
                    'sanitize_callback' => 'floatval'
                ),

                array(
                    'name'  => 'follow_icon_color',
                    'label' => __( 'Follow Button Icon Color', 'ht-instagram' ),
                    'desc' => wp_kses_post( 'You can handle follow button icon color.', 'ht-instagram' ),
                    'type' => 'color',
                ),

                array(
                    'name'  => 'follow_icon_background',
                    'label' => __( 'Follow Button Icon Background Color', 'ht-instagram' ),
                    'desc' => wp_kses_post( 'You can handle follow button icon background color.', 'ht-instagram' ),
                    'type' => 'color',
                ),

                array(
                    'name'  => 'widgets_slideroptions_title',
                    'label'  => __( '<h2 class="htinstaop-headding">Slider Options</h2>', 'ht-instagram' ),
                    'type'  => 'title',
                    'class'=>'htoptions_headding_table_row htseperator',
                ),

                array(
                    'name'  => 'slider_on',
                    'label' => __( 'On', 'ht-instagram' ),
                    'desc'  => __( 'Slider: On / off', 'ht-instagram' ),
                    'type'  => 'checkbox'
                ),

                array(
                    'name'  => 'slitems',
                    'label' => __( 'Number Of item', 'ht-instagram' ),
                    'desc' => wp_kses_post( 'Number Of item to show', 'ht-instagram' ),
                    'min'               => 0,
                    'max'               => 100,
                    'step'              => '1',
                    'type'              => 'number',
                    'sanitize_callback' => 'floatval'
                ),

                array(
                    'name'  => 'slrows',
                    'label' => __( 'Number Of item Row', 'ht-instagram' ),
                    'desc' => wp_kses_post( 'Number Of item row to show', 'ht-instagram' ),
                    'min'               => 0,
                    'max'               => 50,
                    'step'              => '1',
                    'type'              => 'number',
                    'sanitize_callback' => 'floatval'
                ),

                array(
                    'name'  => 'sltablet_display_columns',
                    'label' => __( 'Number Of item On Tablet', 'ht-instagram' ),
                    'desc' => wp_kses_post( 'Number Of item show on Tablet', 'ht-instagram' ),
                    'min'               => 0,
                    'max'               => 50,
                    'step'              => '1',
                    'type'              => 'number',
                    'sanitize_callback' => 'floatval'
                ),

                array(
                    'name'  => 'slmobile_display_columns',
                    'label' => __( 'Number Of item On Mobile', 'ht-instagram' ),
                    'desc' => wp_kses_post( 'Number Of item show on Mobile', 'ht-instagram' ),
                    'min'               => 0,
                    'max'               => 50,
                    'step'              => '1',
                    'type'              => 'number',
                    'sanitize_callback' => 'floatval'
                ),

                array(
                    'name'  => 'slarrows',
                    'label' => __( 'Navigation', 'ht-instagram' ),
                    'desc'  => __( 'Navigation: On / off', 'ht-instagram' ),
                    'type'  => 'checkbox'
                ),

                array(
                    'name'  => 'sldots',
                    'label' => __( 'Pagination', 'ht-instagram' ),
                    'desc'  => __( 'Pagination: On / off', 'ht-instagram' ),
                    'type'  => 'checkbox'
                ),

                array(
                    'name'  => 'slautolay',
                    'label' => __( 'Auto Play', 'ht-instagram' ),
                    'desc'  => __( 'Auto Play: On / off', 'ht-instagram' ),
                    'type'  => 'checkbox'
                ),

                array(
                    'name'  => 'slautoplay_speed',
                    'label' => __( 'Auto Play Speed', 'ht-instagram' ),
                    'desc'  => __( 'Auto Play Speed', 'ht-instagram' ),
                    'placeholder' => __( '3000', 'ht-instagram' ),
                    'type' => 'text',
                    'sanitize_callback' => 'sanitize_text_field'
                ),

                array(
                    'name'  => 'slanimation_speed',
                    'label' => __( 'Animation Speed', 'ht-instagram' ),
                    'desc'  => __( 'Animation Speed', 'ht-instagram' ),
                    'placeholder' => __( '300', 'ht-instagram' ),
                    'type' => 'text',
                    'sanitize_callback' => 'sanitize_text_field'
                ),

                array(
                    'name'  => 'slcentermode',
                    'label' => __( 'Center Mode', 'ht-instagram' ),
                    'desc'  => __( 'Center Mode : On / off', 'ht-instagram' ),
                    'type'  => 'checkbox'
                ),

                array(
                    'name'  => 'slcenterpadding',
                    'label' => __( 'Center Padding', 'ht-instagram' ),
                    'desc'  => __( 'Center Padding', 'ht-instagram' ),
                    'placeholder' => __( '50', 'ht-instagram' ),
                    'type' => 'text',
                    'sanitize_callback' => 'sanitize_text_field'
                ),

            ),

            'htinstagram_shortcodeopt_tabs'=>array(

            ),

        );
        
        return array_merge( $settings_fields );
    }


    function plugin_page() {

        echo '<div class="wrap">';
            echo '<h2>'.esc_html__( 'HT Instagram Settings','ht-instagram' ).'</h2>';
            $this->save_message();
            $this->settings_api->show_navigation();
            $this->settings_api->show_forms();
        echo '</div>';

    }

    function save_message() {
        if( isset($_GET['settings-updated']) ) { ?>
            <div class="updated notice is-dismissible"> 
                <p><strong><?php esc_html_e('Successfully Settings Saved.', 'ht-instagram') ?></strong></p>
            </div>
            <?php
        }
    }

    // Short Code table
    function htinstagram_shortcode_opt_table() {
        $output = '<input type="text" title="Click the field then press Ctrl + C." onclick="this.focus();this.select()" style="text-align: center; margin-bottom:10px;" readonly="readonly" size="15" value="[htinstagram]">';
        $output .= '<table class="htinstagram_widgets_opt"><tr><th scope="row">Shortcode option</th><th scope="row">Description</th><th scope="row">Example</th></tr>';
        $output .='<tr class="httablehedding"><td colspan="3">Configure Options</td></tr>';
        $output .='<tr><td>limit</td><td>Show Number Of item.</td><td>[htinstagram limit="8"]</td></tr>';
        $output .='<tr><td>column</td><td>Show Number Of item column.</td><td>[htinstagram column="4"]</td></tr>';
        $output .='<tr><td>space</td><td>Item Space</td><td>[htinstagram space="5"]</td></tr>';
        $output .='<tr><td>showcaption</td><td>Control the caption</td><td>[htinstagram showcaption="yes"]</td></tr>';
        $output .='<tr><td>caption_pos</td><td>Control the caption position</td><td>[htinstagram caption_pos="top"]</td></tr>';
        $output .='<tr><td>showfollowbtn</td><td>Control the follow button</td><td>[htinstagram showfollowbtn="yes"]</td></tr>';
        $output .='<tr><td>followbtnpos</td><td>Control the follow button position</td><td>[htinstagram followbtnpos="yes"]</td></tr>';
        $output .='<tr><td>target</td><td>Control the follow button position</td><td>[htinstagram target="_self"]</td></tr>';
        $output .='<tr class="httablehedding"><td colspan="3">Slider Options</td></tr>';
        $output .='<tr><td>slider_on</td><td>Control the slider enable disable.</td><td>[htinstagram slider_on="yes"]</td></tr>';
        $output .='<tr><td>slarrows</td><td>Control the slider arrow enable disable.</td><td>[htinstagram slarrows="yes"]</td></tr>';

        $output .='<tr><td>slprevicon</td><td>You can change the slider previous arrow icon.</td><td>[htinstagram slprevicon="fa fa-angle-left"]</td></tr>';
        $output .='<tr><td>slnexticon</td><td>You can change the slider next arrow icon.</td><td>[htinstagram slnexticon="fa fa-angle-right"]</td></tr>';
        $output .='<tr><td>sldots</td><td>Control The slider pagination.</td><td>[htinstagram sldots="no"]</td></tr>';
        $output .='<tr><td>slautolay</td><td>Control The slider autoplay.</td><td>[htinstagram slautolay="no"]</td></tr>';
        $output .='<tr><td>slautoplay_speed</td><td>Control The slider autoplay speed.</td><td>[htinstagram slautoplay_speed="3000"]</td></tr>';
        $output .='<tr><td>slanimation_speed</td><td>Control The slider animation speed.</td><td>[htinstagram slanimation_speed="300"]</td></tr>';
        $output .='<tr><td>slcentermode</td><td>Control The slider center mode.</td><td>[htinstagram slcentermode="yes"]</td></tr>';
        $output .='<tr><td>slcenterpadding</td><td>Control The slider center mode padding.</td><td>[htinstagram slcenterpadding="15"]</td></tr>';
        $output .='<tr><td>slitems</td><td>Control The slider number of item visible.</td><td>[htinstagram slitems="4"]</td></tr>';
        $output .='<tr><td>slitems</td><td>Control The slider number of item visible.</td><td>[htinstagram slitems="4"]</td></tr>';
        $output .='<tr><td>slrows</td><td>Control The slider number of row visible.</td><td>[htinstagram slrows="1"]</td></tr>';
        $output .='<tr><td>slscroll_columns</td><td>Control slide to scroll.</td><td>[htinstagram slscroll_columns="2"]</td></tr>';
        $output .='<tr><td>sltablet_width</td><td>Control slider tablet layout width.</td><td>[htinstagram sltablet_width="750"]</td></tr>';
        $output .='<tr><td>sltablet_display_columns</td><td>Control slider display on tablet layout.</td><td>[htinstagram sltablet_display_columns="2"]</td></tr>';
        $output .='<tr><td>sltablet_display_columns</td><td>Control slider scroll amount on tablet layout.</td><td>[htinstagram sltablet_scroll_columns="2"]</td></tr>';
        $output .='<tr><td>slmobile_width</td><td>Control slider mobile layout width.</td><td>[htinstagram slmobile_width="480"]</td></tr>';
        $output .='<tr><td>slmobile_display_columns</td><td>Control slider display on mobile layout.</td><td>[htinstagram slmobile_display_columns="2"]</td></tr>';
        $output .='<tr><td>slmobile_scroll_columns</td><td>Control slider scroll amount on mobile layout.</td><td>[htinstagram slmobile_scroll_columns="2"]</td></tr>';
         $output .='<tr class="httablehedding"><td colspan="3">Styling Options</td></tr>';
         $output .='<tr><td>captionbg</td><td>Control caption area backgound color.</td><td>[htinstagram captionbg="#dddddd"]</td></tr>';
         $output .='<tr><td>caption_color</td><td>Control caption color.</td><td>[htinstagram caption_color="#ffffff"]</td></tr>';
         $output .='<tr><td>caption_font_size</td><td>Control caption font size.</td><td>[htinstagram caption_font_size="14"]</td></tr>';
         $output .='<tr><td>follow_background</td><td>Control follow button background color.</td><td>[htinstagram follow_background="#dddddd"]</td></tr>';
         $output .='<tr><td>follow_buttoncolor</td><td>Control follow button text color.</td><td>[htinstagram follow_buttoncolor="#fffff"]</td></tr>';
         $output .='<tr><td>follow_button_f_s</td><td>Control follow button font size.</td><td>[htinstagram follow_button_f_s="14"]</td></tr>';
         $output .='<tr><td>follow_icon_color</td><td>Control follow button icon color.</td><td>[htinstagram follow_icon_color="#dddddd"]</td></tr>';
         $output .='<tr><td>follow_icon_background</td><td>Control follow button icon backgound color.</td><td>[htinstagram follow_icon_background="#ffffff"]</td></tr>';
        $output .= '</table>';
        echo $output;
    }
    

}

new HTinstagram_Admin_Settings();