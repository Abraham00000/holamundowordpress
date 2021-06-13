<?php
namespace NNfy;
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
/**
* Customizer Register
*/
class NNfy_Customizer{

    public $prefixid = 'nnfy_';
    public $pro_link = 'https://bit.ly/2SbjVPh';

    private static $_instance = null;
    public static function instance(){
        if( is_null( self::$_instance ) ){
            self::$_instance = new self();
        }
        return self::$_instance;
    }
    
    function __construct(){
        add_action( 'customize_preview_init', [ $this, 'customize_preview_js' ] );
        add_action( 'customize_controls_enqueue_scripts', [ $this, 'customizer_scripts' ] );
        add_action( 'customize_register', [ $this, 'add_settings' ], 999 );
        add_action( 'customize_register', [ $this, 'add_controls' ], 999 );
        add_action( 'customize_register', [ $this, 'change_control_status' ], 999 );
    }

    // Preview Customizer JS
    public function customize_preview_js() {
        wp_enqueue_script( 'nnfy_customizer', NNFY_ADMIN_ASSETS . '/js/customizer-preview.js', array( 'customize-preview' ), '', true );
    }

    // Customizer Scripts
    public function customizer_scripts() {
        
        wp_enqueue_style( 'nnfy-customizer-css', NNFY_ADMIN_ASSETS . 'css/customizer-style.css', array(), NNFY_VERSION );
        wp_enqueue_script( 'nnfy-customizer', NNFY_ADMIN_ASSETS . 'js/customizer-scripts.js', array( 'jquery' ), NNFY_VERSION, true );

        $localize_array = array(
            'header_layout' => get_option( 'nnfy_header_layout', '' ),
            'footer_layout' => get_option( 'nnfy_footer_layout', '' ),
            'custom_pos'    => get_option( 'nnfy_page_title_custom_postion', 'no' ),
            'image_size_type'    => get_option( 'nnfy_blog_img_size' ),
            'check_pro_plugin'    => is_plugin_active( '99fy-pro/nnfy_pro.php' ),
        );
        wp_localize_script( 'nnfy-customizer', 'nnfy', $localize_array );
    }

    // Existing Controls Change Status
    public function change_control_status( $wp_customize ){

        // Add postMessage support for site title and description for the Theme Customizer.
        $wp_customize->get_setting( 'blogname' )->transport         = 'postMessage';
        $wp_customize->get_setting( 'blogdescription' )->transport  = 'postMessage';
        $wp_customize->get_setting( 'header_textcolor' )->transport = 'postMessage';

        // Logo Change Section.
        $wp_customize->get_control( 'custom_logo' )->section = 'nnfy_header_settings';
        $wp_customize->get_control( 'custom_logo' )->priority = 1;

    }

    // Add setting
    public function add_settings( $wp_customize ) {
        foreach ( $this->get_setting_controls() as $setting_key => $setting ) {
            $setting_config = array(
                'type'              => 'option',
                'capability'        => 'edit_theme_options',
                'transport'         => isset( $setting['transport'] ) ? $setting['transport'] : 'postMessage',
                'default'           => isset( $setting['default'] ) ? $setting['default'] : '',
                'sanitize_callback' => isset( $setting['sanitize_callback'] ) ? array( '\NNfy\NNfy_Sanitize', $setting['sanitize_callback'] ) : '',
            );
            $wp_customize->add_setting( $this->prefixid . $setting_key, $setting_config );
        }
    }


    // Add Control
    public function add_controls( $wp_customize ){

        foreach ( $this->get_setting_controls() as $setting_key => $setting ) {
            
            // Add Section
            $this->section_add( $wp_customize, $setting );

            // Get control class name (none, color, upload, image)
            $control_class = isset( $setting['control_type'] ) ? ucfirst( $setting['control_type'] ) . '_' : '';
            $control_class = 'WP_Customize_' . $control_class . 'Control';

            // Control Configuration
            $control_config = array(
                'label'    => $setting['title'],
                'settings' => $this->prefixid . $setting_key,
                'priority' => isset( $setting['priority'] ) ? $setting['priority'] : 10,
            );

            // Description
            if ( ! empty( $setting['description'] ) ) {
                $control_config['description'] = $setting['description'];
            }

            // Add control to section
            if ( ! empty( $setting['section'] ) ) {
                $control_config['section'] = $this->prefixid . $setting['section'];
            }

            // Add custom field type
            if ( ! empty( $setting['type'] ) ) {
                $control_config['type'] = $setting['type'];
            }

            // Add select field options
            if ( ! empty( $setting['choices'] ) ) {
                $control_config['choices'] = $setting['choices'];
            }
            // Input attributese
            if ( ! empty( $setting['input_attrs'] ) ) {
                $control_config['input_attrs'] = $setting['input_attrs'];
            }

            // Repeater controls:
            if ( ! empty( $setting['customizer_repeater_image_control'] ) ) {
                $control_config['customizer_repeater_image_control'] = $setting['customizer_repeater_image_control'];
            }
            if ( ! empty( $setting['customizer_repeater_icon_control'] ) ) {
                $control_config['customizer_repeater_icon_control'] = $setting['customizer_repeater_icon_control'];
            }
            if ( ! empty( $setting['customizer_repeater_title_control'] ) ) {
                $control_config['customizer_repeater_title_control'] = $setting['customizer_repeater_title_control'];
            }
            if ( ! empty( $setting['customizer_repeater_link_control'] ) ) {
                $control_config['customizer_repeater_link_control'] = $setting['customizer_repeater_link_control'];
            }

            $wp_customize->add_control( new $control_class( $wp_customize, $this->prefixid . $setting_key, $control_config ) );

        }

    }

    // Section add
    public function section_add( $wp_customize, $fields ){
        // Get sections
        $sections = $this->get_sections();
        if ( ! empty( $fields['section'] ) && isset( $sections[ $fields['section'] ] ) ) {
            // Section key
            $section_key = $fields['section'];
            // Data Reference from section
            $section = $sections[ $section_key ];
            // Section config
            $section_config = array(
                'title'     => $section['title'],
                'priority'  => ( isset( $section['priority'] ) ? $section['priority'] : 10 ),
            );
            // Description
            if ( ! empty( $section['description'] ) ) {
                $section_config['description'] = $section['description'];
            }

            // Add Panel
            $this->panel_add( $wp_customize, $section );

            // Add Section to panel
            if ( ! empty( $section['panel'] ) ) {
                $section_config['panel'] = $this->prefixid . $section['panel'];
            }

            // Register section
            $wp_customize->add_section( $this->prefixid . $section_key, $section_config );
        }
    }

    // Panel Add
    public function panel_add( $wp_customize, $fieldssection ){
        // Panel List
        $panels = $this->get_panels();
        if ( ! empty( $fieldssection['panel'] ) && isset( $panels[ $fieldssection['panel'] ] ) ) {
            
            // Reference current panel key
            $panel_key = $fieldssection['panel'];
            // Data Reference from panel
            $panel = $panels[ $panel_key ];

            // Panel config
            $panel_config = array(
                'title'         => $panel['title'],
                'priority'      => ( isset( $panel['priority'] ) ? $panel['priority'] : 10 ),
            );
            // Panel description
            if ( ! empty( $panel['description'] ) ) {
                $panel_config['description'] = $panel['description'];
            }
            // Register panel
            $wp_customize->add_panel( $this->prefixid . $panel_key, $panel_config );

        }
    }

    // Panel List
    public function get_panels(){
        $panels = array(
            // Penel.
            'nnfy_panel' => array(
                'title'    => __( '99FY Options', '99fy' ),
                'priority' => 170,
            ),
        );
        return $panels;
    }

    // Sections
    public function get_sections(){
        $sections = array( 
            
            'general_settings' => array(
                'title'    => __( 'General Settings', '99fy' ),
                'panel' => 'nnfy_panel',
                'priority'  => 1,
            ),
            
            'header_settings' => array(
                'title'    => __( 'Header Settings', '99fy' ),
                'panel' => 'nnfy_panel',
                'priority'  => 5,
            ),
            
            'page_title_settings' => array(
                'title'    => __( 'Page Title Settings', '99fy' ),
                'panel' => 'nnfy_panel',
                'priority'  => 10,
            ),
            
            'blog_settings' => array(
                'title'    => __( 'Blog Settings', '99fy' ),
                'panel' => 'nnfy_panel',
                'priority'  => 15,
            ),
            
            'woocommerce_settings' => array(
                'title'    => __( 'WooCommerce Settings', '99fy' ),
                'panel' => 'nnfy_panel',
                'priority'  => 15,
            ),

            'sidebar_settings' => array(
                'title'    => __( 'Sidebar Settings', '99fy' ),
                'panel' => 'nnfy_panel',
                'priority'  => 20,
            ),
            
            'footer_settings' => array(
                'title'    => __( 'Footer Settings', '99fy' ),
                'panel' => 'nnfy_panel',
                'priority'  => 30,
            ),

        );
        return $sections;
    }


    // Settings Controll Field
    public function get_setting_controls(){
        $controls = array();

        $controls[ 'logo_separator_btn' ] = array(
            'title'           => __( 'Logo Separator', '99fy' ),
            'section'         => 'header_settings',
            'control_type'    => 'separator',
            'priority'=>2,
        );

        $controls['topbar_status'] = array(
            'title'           => __( 'Show Top Bar', '99fy' ),
            'section'         => 'header_settings',
            'control_type'    => 'toggleswitch',
            'transport'       => 'refresh',
            'sanitize_callback' => 'sanitize_checkbox',
            'priority'=>5,
        );

        $controls['topbar_left'] = array(
            'title' => __('Top Bar Contact information','99fy'),
            'section'   => 'header_settings',
            'type'   => 'textarea',
            'default'     => __( 'Call Us : 012036 039 &nbsp; &nbsp;|&nbsp; &nbsp;  Email : yourmail@domain.com','99fy' ),
            'transport'   => 'refresh',
            'sanitize_callback' => 'sanitize_input',
            'priority'=>10,
        );

        $controls[ 'header_action_btn' ] = array(
            'title'           => __( 'Header Action Button Separator', '99fy' ),
            'section'         => 'header_settings',
            'control_type'    => 'separator',
            'priority'=>14,
        );

        $controls[ 'show_search' ] = array(
            'title'           => __( 'Show Search', '99fy' ),
            'section'         => 'header_settings',
            'control_type'    => 'toggleswitch',
            'transport'       => 'refresh',
            'sanitize_callback' => 'sanitize_checkbox',
            'priority'=>15,
        );

        $controls['show_myaccount'] = array(
            'title' => __('Show MyAccount','99fy'),
            'section'         => 'header_settings',
            'control_type'    => 'toggleswitch',
            'transport'       => 'refresh',
            'sanitize_callback' => 'sanitize_checkbox',
            'priority'=>15,
        );

        $controls['show_wishlist'] = array(
            'title' => __('Show Wishlist','99fy'),
            'section'         => 'header_settings',
            'control_type'    => 'toggleswitch',
            'transport'       => 'refresh',
            'sanitize_callback' => 'sanitize_checkbox',
            'priority'=>15,
        );

        $controls['show_cart'] = array(
            'title' => __('Show Mini Cart','99fy'),
            'section'         => 'header_settings',
            'control_type'    => 'toggleswitch',
            'transport'       => 'refresh',
            'sanitize_callback' => 'sanitize_checkbox',
            'priority'=>15,
        );

        // Page Title Setting
        $controls['page_title_status'] = array(
            'title' => __('Show Page title','99fy'),
            'section'         => 'page_title_settings',
            'control_type'    => 'toggleswitch',
            'transport'       => 'refresh',
            'default'         => true,
            'sanitize_callback' => 'sanitize_checkbox',
            'priority'=>5,
        );

        $controls['breadcrumb_status'] = array(
            'title' => __('Show Breadcrumb','99fy'),
            'section'         => 'page_title_settings',
            'control_type'    => 'toggleswitch',
            'transport'       => 'refresh',
            'default'         => true,
            'sanitize_callback' => 'sanitize_checkbox',
            'priority'=>10,
        );

        $controls['breadcrumb_layout'] = array(
            'title' => __('Breadcrumb Layout','99fy'),
            'section'   => 'page_title_settings',
            'type'   => 'select',
            'choices'   => array(
                'default'=> __('Default Layout','99fy'),
                'one'   => __('Layout One','99fy'),
                'two'   => __('Layout Two','99fy'),
                'three' => __('Layout Three','99fy'),
            ),
            'default'     => 'default',
            'transport'   => 'refresh',
            'sanitize_callback' => 'sanitize_select',
            'priority'=>4,
        );

        $controls[ 'breadcrumb_other_opt' ] = array(
            'title'           => __( 'Breadcrumb Separator', '99fy' ),
            'section'         => 'page_title_settings',
            'control_type'    => 'separator',
            'priority'=>4,
        );

        $controls[ 'page_title_custom_opt' ] = array(
            'title'           => __( 'Custom Position Separator', '99fy' ),
            'section'         => 'page_title_settings',
            'control_type'    => 'separator',
            'priority'=>10,
        );

        $controls['page_title_custom_postion'] = array(
            'title' => __('Custom Position','99fy'),
            'section'   => 'page_title_settings',
            'type'   => 'select',
            'choices'   => array(
                'yes'  => __('Yes','99fy'),
                'no'   => __('No','99fy'),
            ),
            'default'     => 'no',
            'transport'   => 'refresh',
            'sanitize_callback' => 'sanitize_select',
            'priority'=>10,
        );

        $controls['page_title_x_position'] = array(
            'title'         => __( 'Horizontal Postion', '99fy' ),
            'control_type'  => 'rangevalue',
            'section'       => 'page_title_settings',
            'default'       => '0',
            'input_attrs' => array(
                'step'  => 1,
                'min'   => 0,
                'max'   => 1500,
            ),
            'transport'   => 'refresh',
            'priority'=>10,
        );

        $controls['page_title_y_position'] = array(
            'title'         => __( 'Vertical Postion', '99fy' ),
            'control_type'  => 'rangevalue',
            'section'       => 'page_title_settings',
            'default'       => '0',
            'input_attrs' => array(
                'step'  => 1,
                'min'   => 0,
                'max'   => 1000,
            ),
            'transport'   => 'refresh',
            'priority'=>10,
        );

        $controls[ 'breadcrumb_other_opt1' ] = array(
            'title'           => __( 'Breadcrumb Separator Two', '99fy' ),
            'section'         => 'page_title_settings',
            'control_type'    => 'separator',
            'priority'=>11,
        );

        $controls['page_title_bgcolor'] = array(
            'title' => __('Background Color','99fy'),
            'section'   => 'page_title_settings',
            'control_type'=> 'color',
            'default'     => '#dddddd',
            'transport'   => 'refresh',
            'sanitize_callback' => 'sanitize_hex_color',
            'priority'=>15,
        );

        $controls['page_title_bgimage'] = array(
            'title' => __('Background Image','99fy'),
            'section'   => 'page_title_settings',
            'control_type'=> 'image',
            'transport'   => 'refresh',
            'sanitize_callback' => 'sanitize_text_field',
            'priority'=>15,
        );

        $controls['page_title_bg_image_size'] = array(
            'title' => __('Background Image Size','99fy'),
            'section'   => 'page_title_settings',
            'type'   => 'select',
            'choices'   => array(
                'auto'      => __('Auto','99fy'),
                'cover'     => __('Cover','99fy'),
                'contain'   => __('Contain','99fy'),
            ),
            'default'     => 'cover',
            'transport'   => 'refresh',
            'sanitize_callback' => 'sanitize_select',
            'priority'=>15,
        );

        $controls['page_title_space'] = array(
            'title' => __('Page title section Space','99fy'),
            'section'   => 'page_title_settings',
            'type'      => 'textbox',
            'transport' => 'postMessage',
            'default'   =>'150px',
            'sanitize_callback' => 'sanitize_input',
            'priority'  => 20,
        );

        // Woocommerce Setting
        $controls['woocommerce_mobile_col_size'] = array(
            'title' => __('WooCommerce Mobile Column','99fy'),
            'section'   => 'woocommerce_settings',
            'type'   => 'select',
            'choices'   => array(
                '1'     => __('1 Column','99fy'),
                '2'     => __('2 Column','99fy'),
            ),
            'default'     => '1',
            'transport'   => 'refresh',
            'sanitize_callback' => 'sanitize_select',
            'priority'=>5,
        );

        // Blog Setting
        $controls['blog_col_size'] = array(
            'title' => __('Blog Column','99fy'),
            'section'   => 'blog_settings',
            'type'   => 'select',
            'choices'   => array(
                '1'     => __('1 Column','99fy'),
                '2'     => __('2 Column','99fy'),
                '3'     => __('3 Column','99fy'),
                '4'     => __('4 column','99fy'),
            ),
            'default'     => '3',
            'transport'   => 'refresh',
            'sanitize_callback' => 'sanitize_select',
            'priority'=>5,
        );

        $controls[ 'blog_length_separator' ] = array(
            'title'           => __( 'Blog content length Options Separator', '99fy-pro' ),
            'section'         => 'blog_settings',
            'control_type'    => 'separator',
            'priority'=>10,
        );

        $controls['blog_title_length'] = array(
            'title' => __('Title length','99fy'),
            'section'   => 'blog_settings',
            'type'      => 'textbox',
            'transport'   => 'refresh',
            'default'   =>'8',
            'sanitize_callback' => 'sanitize_input',
            'priority'=>10,
        );

        $controls['blog_img_size'] = array(
            'title' => __('Choose Image Size','99fy'),
            'section'   => 'blog_settings',
            'type'   => 'select',
            'choices'   => array(
                'thumbnail'     => __('Thumbnail','99fy'),
                'medium'        => __('Medium','99fy'),
                'large'         => __('Large','99fy'),
                'full'          => __('Full','99fy'),
                'custom'        => __('Custom','99fy'),
            ),
            'default'     => 'custom',
            'transport'   => 'refresh',
            'sanitize_callback' => 'sanitize_select',
            'priority'=>10,
        );

        $controls['blog_image_width'] = array(
            'title' => __('Image Width','99fy'),
            'section'   => 'blog_settings',
            'type'      => 'textbox',
            'transport'   => 'refresh',
            'default'   =>'370',
            'sanitize_callback' => 'sanitize_input',
            'priority'=>10,
        );

        $controls['blog_image_height'] = array(
            'title' => __('Image Height','99fy'),
            'section'   => 'blog_settings',
            'type'      => 'textbox',
            'transport'   => 'refresh',
            'default'   =>'244',
            'sanitize_callback' => 'sanitize_input',
            'priority'=>10,
        );


        $controls['blog_title_length'] = array(
            'title' => __('Title length','99fy'),
            'section'   => 'blog_settings',
            'type'      => 'textbox',
            'transport'   => 'refresh',
            'default'   =>'8',
            'sanitize_callback' => 'sanitize_input',
            'priority'=>10,
        );

        $controls['blog_excerpt_length'] = array(
            'title' => __('Excerpt length','99fy'),
            'section'   => 'blog_settings',
            'type'      => 'textbox',
            'transport'   => 'refresh',
            'default'   =>'20',
            'sanitize_callback' => 'sanitize_input',
            'priority'=>10,
        );

        $controls['blog_read_more_txt'] = array(
            'title' => __('Read More button Text','99fy'),
            'section'   => 'blog_settings',
            'type'      => 'textbox',
            'transport'   => 'refresh',
            'default'   =>'Read More',
            'sanitize_callback' => 'sanitize_input',
            'priority'=>10,
        );

        $controls[ 'blog_extra_separator' ] = array(
            'title'           => __( 'Blog Extra Options Separator', '99fy-pro' ),
            'section'         => 'blog_settings',
            'control_type'    => 'separator',
            'priority'=>10,
        );

        $controls[ 'blog_title_meta_status' ] = array(
            'title'           => __( 'Blog Meta Hide', '99fy-pro' ),
            'section'         => 'blog_settings',
            'control_type'    => 'toggleswitch',
            'transport'       => 'refresh',
            'sanitize_callback' => 'sanitize_checkbox',
            'priority'=>10,
        );

        // Sidebar Field
        $controls['blog_layout'] = array(
            'title' => __('Blog Sidebar','99fy'),
            'section'   => 'sidebar_settings',
            'type'   => 'select',
            'choices'   => array(
                'none'  => __('No sidebar','99fy'),
                'left'  => __('Left Sidebar','99fy'),
                'right' => __('Right Sidebar','99fy'),
            ),
            'default'     => 'none',
            'transport'   => 'refresh',
            'sanitize_callback' => 'sanitize_select',
            'priority'=>5,
        );

        $controls[ 'shop_sidebar_separator' ] = array(
            'title'           => __( 'Shop Sidebar Separator', '99fy' ),
            'section'         => 'sidebar_settings',
            'control_type'    => 'separator',
            'priority'=>10,
        );

        $controls['shop_sidebar'] = array(
            'title' => __('Shop page sidebar','99fy'),
            'section'   => 'sidebar_settings',
            'type'   => 'select',
            'choices'   => array(
                'none'  => __('No sidebar','99fy'),
                'left'  => __('Left Sidebar','99fy'),
                'right' => __('Right Sidebar','99fy'),
            ),
            'default'     => 'none',
            'transport'   => 'refresh',
            'sanitize_callback' => 'sanitize_select',
            'priority'=>10,
        );

        // Footer Field
        $controls['footer_top_status'] = array(
            'title' => __('Show Footer','99fy'),
            'section'         => 'footer_settings',
            'control_type'    => 'toggleswitch',
            'transport'       => 'refresh',
            'default'         => true,
            'sanitize_callback' => 'sanitize_checkbox',
            'priority'=>5,
        );

        $controls['footer_copyright_status'] = array(
            'title' => __('Show Copyright','99fy'),
            'section'         => 'footer_settings',
            'control_type'    => 'toggleswitch',
            'transport'       => 'refresh',
            'default'         => true,
            'sanitize_callback' => 'sanitize_checkbox',
            'priority'=>5,
        );

         $controls[ 'footer_switcher_separator' ] = array(
            'title'           => __( 'Footer Switcher Separator', '99fy' ),
            'section'         => 'footer_settings',
            'control_type'    => 'separator',
            'priority'=>6,
        );

        $controls['footer_col_size'] = array(
            'title' => __('Footer Column','99fy'),
            'section'   => 'footer_settings',
            'type'   => 'select',
            'choices'   => array(
                '1'     => __('1 Column','99fy'),
                '2'     => __('2 Column','99fy'),
                '3'     => __('3 Column','99fy'),
                '4'     => __('4 column','99fy'),
                '5'     => __('5 Column','99fy'),
            ),
            'default'     => '4',
            'transport'   => 'refresh',
            'sanitize_callback' => 'sanitize_select',
            'priority'=>15,
        );

        $controls['footer_copyright_text'] = array(
            'title' => __('Footer copyright text','99fy'),
            'section'   => 'footer_settings',
            'type'   => 'textarea',
            'default'     => sprintf( __('Copyright &copy; %1$s %2$s','99fy-pro'), date('Y'), 'HasThemes' ),
            'transport'   => 'refresh',
            'sanitize_callback' => 'sanitize_input',
            'priority'=>20,
        );

        // Pro Element
        if ( ! is_plugin_active( '99fy-pro/nnfy_pro.php' ) ) {

            // Header
            $controls[ 'header_notice_separator' ] = array(
                'title'           => __( 'Header Notice Separator', '99fy' ),
                'section'         => 'header_settings',
                'control_type'    => 'separator',
                'priority'=>15,
            );

            $controls[ 'notice_header' ] = array(
                'title'           => __( 'Upgrade To 99fy Pro', '99fy' ),
                'section'         => 'header_settings',
                'control_type'    => 'info',
                'description'     => [
                    'info_message' => sprintf( '<a href="%1$s" target="_blank" rel="nofollow">%2$s</a> %3$s', $this->pro_link, __( 'Purchase Pro','99fy' ), __( 'To Unlock full Features.','99fy' )  ),
                    'features_list'   => [
                        'header_layout'        => __( '5 Header Layouts', '99fy'),
                        'header_sticky'        => __( 'Sticky Header', '99fy'),
                        'header_logo_postion'  => __( 'Logo Position', '99fy'),
                    ],
                ],
                'priority'=>15,
            );

            // Sidebar
            $controls[ 'sidebar_notice_separator' ] = array(
                'title'           => __( 'Sidebar Notice Separator', '99fy' ),
                'section'         => 'sidebar_settings',
                'control_type'    => 'separator',
                'priority'=>15,
            );

            $controls[ 'sidebar_notice' ] = array(
                'title'           => __( 'Upgrade To 99fy Pro', '99fy' ),
                'section'         => 'sidebar_settings',
                'control_type'    => 'info',
                'description'     => [
                    'info_message' => sprintf( '<a href="%1$s" target="_blank" rel="nofollow">%2$s</a> %3$s', $this->pro_link, __( 'Purchase Pro','99fy' ), __( 'To Unlock full Features.','99fy' )  ),
                    'features_list'   => [
                        'blog_sidebar_sticky'  => __( 'Blog Sticky Sidebar', '99fy'),
                        'shop_sidebar_sticky'  => __( 'Shop Sticky Sidebar', '99fy'),
                    ],
                ],
                'priority'=>15,
            );

            // Footer
            $controls[ 'footer_notice_separator' ] = array(
                'title'           => __( 'Footer Notice Separator', '99fy' ),
                'section'         => 'footer_settings',
                'control_type'    => 'separator',
                'priority'=>21,
            );

            $controls['footer_copyright_brand'] = array(
                'title' => __('Footer Copyright Brand (pro)','99fy-pro'),
                'section'   => 'footer_settings',
                'type'   => 'textarea',
                'default'     =>  __('<a href="https://hasthemes.com/woocommerce-themes/99fy-pro/">Built with 99fy by HasThemes</a>','99fy'),
                'transport'   => 'refresh',
                'sanitize_callback' => 'sanitize_input',
                'priority'=>20,
            );

            $controls[ 'footer_notice' ] = array(
                'title'           => __( 'Upgrade To 99fy Pro', '99fy' ),
                'section'         => 'footer_settings',
                'control_type'    => 'info',
                'description'     => [
                    'info_message' => sprintf( '<a href="%1$s" target="_blank" rel="nofollow">%2$s</a> %3$s', $this->pro_link, __( 'Purchase Pro','99fy' ), __( 'To Unlock full Features.','99fy' )  ),
                    'features_list'   => [
                        'footer_layout'  => __( '5 Footer Layouts', '99fy'),
                        'footer_sticky'  => __( 'Sticky Footer', '99fy'),
                        'footer_copyright_change'  => __( 'To change text "Built with 99fy by HasThemes"', '99fy'),
                    ],
                ],
                'priority'=>21,
            );

        }

        return $controls;
    }



}

NNfy_Customizer::instance();