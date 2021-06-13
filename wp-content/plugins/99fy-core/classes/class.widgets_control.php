<?php

namespace NNfy\Elementor;
use Elementor\Controls_Manager;
use Elementor\Element_Base;
use Elementor\Controls_Stack;
use Elementor\Plugin as Elementor;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

/**
* Widgets Control
*/
class NNfy_Widgets_Control{

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

    // Widgets Initialize
    public function init() {

        // Register custom Widgets category
        add_action( 'elementor/elements/categories_registered', [ $this, 'add_category' ] );

        // Register custom Widgets
        add_action( 'elementor/widgets/widgets_registered', [ $this, 'register_widgets' ] );

    }

    /**
     * Add custom category.
     *
     * @param $elements_manager
     */
    public function add_category( $elements_manager ) {
        $elements_manager->add_category(
            '99fy',
            [
                'title' => __( '99Fy', '99fy' ),
                'icon' => 'fa fa-snowflake-o',
            ]
        );
    }

    /*
    * Widgets Register
    */
    public function register_widgets() {

        $element_manager  = array(
            'nnfy_hero_slider',
            'nnfy_adds_banner',
            'nnfy_blog',
            'nnfy_service_info',
            'nnfy_testimonial',
            'nnfy_teammember',
            'nnfy_logo_showcase',
        );
        if ( in_array('woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ){
            $element_manager['nnfy_products'] = 'nnfy_products';
        }

        // Include Widget files
        foreach ( $element_manager as $element ){
            if ( file_exists( NNFY_PL_PATH .'widgets/'.$element.'.php' ) ){
                require( NNFY_PL_PATH .'widgets/'.$element.'.php' );
                $class_name = 'NNfy\Elementor\Widget\\'.$element.'_Element';
                Elementor::instance()->widgets_manager->register_widget_type( new $class_name() );
            }
        }

    }

}

NNfy_Widgets_Control::instance();