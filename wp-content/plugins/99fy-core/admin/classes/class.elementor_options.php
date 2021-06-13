<?php

namespace NNfy;
use Elementor\Plugin as Elementor;
use Elementor\Controls_Manager;
use Elementor\Element_Base;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

/**
*  NNPROFy Elementor Options
*/
class NNFy_Elementor_Options{

    public $pro_link = 'https://bit.ly/2SbjVPh';

    private static $_instance = null;
    public static function instance() {
        if ( is_null( self::$_instance ) ) {
            self::$_instance = new self();
        }
        return self::$_instance;
    }
    
    function __construct(){

        // Register Control Document
        add_action( 'elementor/documents/register_controls', [ $this, 'add_elementor_page_settings_controls'], 10, 1 );

    }

    /*
    * Elementor Page Document Setting Add
    */
    public function add_elementor_page_settings_controls( $document ) {
        
        // Start Header and Footer
        $document->start_controls_section(
            'nnfy_section_header_footer',
            [
                'label' => __( 'Header & Footer', '99fy' ),
                'tab' => Controls_Manager::TAB_SETTINGS,
            ]
        );
            
            $document->add_control(
                'nnfy_header_footer_pro',
                [
                    'type' => Controls_Manager::RAW_HTML,
                    'raw' => '<div class="elementor-nerd-box">' .
                            '<i class="elementor-nerd-box-icon eicon-hypster"></i>
                            <div class="elementor-nerd-box-title">' .
                                __( 'Header & Footer Settings', '99fy' ) .
                            '</div>
                            <div class="elementor-nerd-box-message">' .
                                __( 'Purchase our premium version to unlock these pro feature!', '99fy' ) .
                            '</div>
                            <a class="elementor-nerd-box-link elementor-button elementor-button-default elementor-go-pro" href="' . esc_url( $this->pro_link ) . '" target="_blank">' .
                                __( 'Go Pro', '99fy' ) .
                            '</a>
                            </div>',
                ]
            );

        $document->end_controls_section();
        // End Header and Footer

        // Page Settings section start
        $document->start_controls_section(
            'nnprofy_section_page_title_setting',
            [
                'label' => __( 'Page Title Settings', '99fy' ),
                'tab' => Controls_Manager::TAB_SETTINGS,
            ]
        );
            $document->add_control(
                'nnfy_page_title_setting_pro',
                [
                    'type' => Controls_Manager::RAW_HTML,
                    'raw' => '<div class="elementor-nerd-box">' .
                            '<i class="elementor-nerd-box-icon eicon-hypster"></i>
                            <div class="elementor-nerd-box-title">' .
                                __( 'Page Title Settings', '99fy' ) .
                            '</div>
                            <div class="elementor-nerd-box-message">' .
                                __( 'Purchase our premium version to unlock these pro feature!', '99fy' ) .
                            '</div>
                            <a class="elementor-nerd-box-link elementor-button elementor-button-default elementor-go-pro" href="' . esc_url( $this->pro_link ) . '" target="_blank">' .
                                __( 'Go Pro', '99fy' ) .
                            '</a>
                            </div>',
                ]
            );

        $document->end_controls_section();
        //Page Setting section end

        // Side Canvas
        $document->start_controls_section(
            'nnfy_section_side_canvas',
            [
                'label' => __( 'Side Canvas', '99fy' ),
                'tab' => Controls_Manager::TAB_SETTINGS,
            ]
        );
            
            $document->add_control(
                'nnfy_side_canvas_setting_pro',
                [
                    'type' => Controls_Manager::RAW_HTML,
                    'raw' => '<div class="elementor-nerd-box">' .
                            '<i class="elementor-nerd-box-icon eicon-hypster"></i>
                            <div class="elementor-nerd-box-title">' .
                                __( 'Side Canvas Settings', '99fy' ) .
                            '</div>
                            <div class="elementor-nerd-box-message">' .
                                __( 'Purchase our premium version to unlock these pro feature!', '99fy' ) .
                            '</div>
                            <a class="elementor-nerd-box-link elementor-button elementor-button-default elementor-go-pro" href="' . esc_url( $this->pro_link ) . '" target="_blank">' .
                                __( 'Go Pro', '99fy' ) .
                            '</a>
                            </div>',
                ]
            );

        $document->end_controls_section();

        // Custom Css
        $document->start_controls_section(
            'nnfy_section_custom_css',
            [
                'label' => __( 'Custom CSS', '99fy' ),
                'tab' => Controls_Manager::TAB_SETTINGS,
            ]
        );
            
            $document->add_control(
                'nnfy_custom_css_pro',
                [
                    'type' => Controls_Manager::RAW_HTML,
                    'raw' => '<div class="elementor-nerd-box">' .
                            '<i class="elementor-nerd-box-icon eicon-hypster"></i>
                            <div class="elementor-nerd-box-title">' .
                                __( 'Custom CSS Option', '99fy' ) .
                            '</div>
                            <div class="elementor-nerd-box-message">' .
                                __( 'Purchase our premium version to unlock these pro feature!', '99fy' ) .
                            '</div>
                            <a class="elementor-nerd-box-link elementor-button elementor-button-default elementor-go-pro" href="' . esc_url( $this->pro_link ) . '" target="_blank">' .
                                __( 'Go Pro', '99fy' ) .
                            '</a>
                            </div>',
                ]
            );

        $document->end_controls_section();

    }


}

NNFy_Elementor_Options::instance();