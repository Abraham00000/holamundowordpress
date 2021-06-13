<?php
namespace NNfy\Elementor\Widget;

// Elementor Classes
use Elementor\Plugin as Elementor;
use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Border;
use Elementor\Core\Schemes\Color as Scheme_Color;
use Elementor\Core\Schemes\Typography as Scheme_Typography;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class NNfy_Logo_Showcase_Element extends Widget_Base {

    public function get_name() {
        return 'nnfy-logo-showcase';
    }

    public function get_title() {
        return __( '99FY: Logo Showcase', '99fy' );
    }

    public function get_icon() {
        return 'eicon-image';
    }

    public function get_categories() {
        return ['99fy'];
    }

    protected function _register_controls() {

        $this->start_controls_section(
            'logo_showcase_content',
            [
                'label' => __( 'Logo Showcase', '99fy' ),
            ]
        );
            
            $this->add_control(
                'logoes',
                [
                    'label' => __( 'Add Images', '99fy' ),
                    'type' => Controls_Manager::GALLERY,
                    'default' => [],
                ]
            );

            $this->add_group_control(
                \Elementor\Group_Control_Image_Size::get_type(),
                [
                    'name' => 'logosize',
                    'default' => 'large',
                    'separator' => 'none',
                ]
            );

            $this->add_control(
                'navigation',
                [
                    'label' => __( 'Navigation', '99fy' ),
                    'type' => Controls_Manager::SWITCHER,
                    'label_on' => __( 'Yes', '99fy' ),
                    'label_off' => __( 'No', '99fy' ),
                    'return_value' => 'yes',
                    'default' => 'no',
                ]
            );

            $this->add_control(
                'autoplay',
                [
                    'label' => __( 'Auto Play', '99fy' ),
                    'type' => Controls_Manager::SWITCHER,
                    'label_on' => __( 'Yes', '99fy' ),
                    'label_off' => __( 'No', '99fy' ),
                    'return_value' => 'yes',
                    'default' => 'no',
                ]
            );

            $this->add_control(
                'loop',
                [
                    'label' => __( 'Loop', '99fy' ),
                    'type' => Controls_Manager::SWITCHER,
                    'label_on' => __( 'Yes', '99fy' ),
                    'label_off' => __( 'No', '99fy' ),
                    'return_value' => 'yes',
                    'default' => 'yes',
                ]
            );

            $this->add_control(
                'autoplaytimeout',
                [
                    'label' => __( 'Autoplay Timeout', '99fy' ),
                    'type' => Controls_Manager::TEXT,
                    'default' => __( '5000', '99fy' ),
                ]
            );

        $this->end_controls_section();

        $this->start_controls_section(
            'logo_style_section',
            [
                'label' => __( 'Style', '99fy' ),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );
            
            $this->add_group_control(
                Group_Control_Border::get_type(),
                [
                    'name' => 'logo_border',
                    'label' => __( 'Border', '99fy' ),
                    'selector' => '{{WRAPPER}} .logo_showcase .single-logo',
                ]
            );

            $this->add_control(
                'logo_margin',
                [
                    'label' => __( 'Margin', '99fy' ),
                    'type' => Controls_Manager::DIMENSIONS,
                    'size_units' => [ 'px', '%', 'em' ],
                    'selectors' => [
                        '{{WRAPPER}} .logo_showcase .single-logo' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    ],
                ]
            );

            $this->add_control(
                'logo_padding',
                [
                    'label' => __( 'Padding', '99fy' ),
                    'type' => Controls_Manager::DIMENSIONS,
                    'size_units' => [ 'px', '%', 'em' ],
                    'selectors' => [
                        '{{WRAPPER}} .logo_showcase .single-logo' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    ],
                ]
            );

        $this->end_controls_section();

        // Style tab section
        $this->start_controls_section(
            'slider_navigation_style_section',
            [
                'label' => __( 'Navigation', '99fy' ),
                'tab' => Controls_Manager::TAB_STYLE,
                'condition' => [
                    'navigation' => 'yes',
                ]
            ]
        );
            $this->add_control(
                'sldier_navigation_color',
                [
                    'label' => __( 'Navigation Color', '99fy' ),
                    'type' => Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} .logo_showcase .owl-nav div' => 'color: {{VALUE}}'
                    ],
                ]
            );

            $this->add_group_control(
                Group_Control_Typography::get_type(),
                [
                    'name' => 'sldier_navigation_typography',
                    'label' => __( 'Navigation Typography', '99fy' ),
                    'scheme' => Scheme_Typography::TYPOGRAPHY_1,
                    'selector' => '{{WRAPPER}} .logo_showcase .owl-nav div',
                ]
            );

            $this->add_control(
                'sldier_navigation_bg_color',
                [
                    'label' => __( 'Navigation Background Color', '99fy' ),
                    'type' => Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} .logo_showcase .owl-nav div' => 'background-color: {{VALUE}}'
                    ],
                ]
            );

            $this->add_group_control(
                Group_Control_Border::get_type(),
                [
                    'name' => 'bsldier_navigation_order',
                    'label' => __( 'Border', '99fy' ),
                    'selector' => '{{WRAPPER}} .logo_showcase .owl-nav div',
                ]
            );

        $this->end_controls_section();



    }

    protected function render( $instance = [] ) {

        $settings   = $this->get_settings_for_display();
        $id = $this->get_id();

        $this->add_render_attribute( 'logo_area_attr', 'class', 'sc_logo_showcase' );

        // Image Size
        $size = 'full';
        if( $settings['logosize_size'] == 'custom' ){
            $size = $settings['logosize_custom_dimension'];
        }else{
            $size = $settings['logosize_size'];
        }

        ?>
            

            <div <?php echo $this->get_render_attribute_string( 'logo_area_attr' ); ?> >
                <?php if ( $settings['logoes'] ): ?>
                    <div class="logo_showcase owl-carousel">
                        <?php foreach( $settings['logoes'] as $logo ): ?>
                            <div class="single-logo">
                                <?php echo wp_get_attachment_image( $logo['id'], $size ); ?>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php
                    $autoplay = $settings['autoplay'] == 'yes' ? 'true' : 'false';
                    $nav      = $settings['navigation'] == 'yes' ? 'true' : 'false';
                    $loop     = $settings['loop'] == 'yes' ? 'true' : 'false';
                    $autoplaytimeout = $settings['autoplaytimeout'] ? $settings['autoplaytimeout'] : '5000';
                ?>
                <script type="text/javascript">
                    jQuery(document).ready(function($) {
                        'use strict';
                        $('.elementor-element-<?php echo $id; ?> .owl-carousel').owlCarousel({
                            loop: <?php echo esc_js( $loop ); ?>,
                            autoplay: <?php echo esc_js( $autoplay ); ?>,
                            autoplayTimeout: <?php echo esc_js( $autoplaytimeout ); ?>,
                            margin: 40,
                            nav: <?php echo $nav; ?>,
                            navText: [ '<i class="fa fa-angle-left"></i>','<i class="fa fa-angle-right"></i>' ],
                            item: 5,
                            responsive: {
                                 0: {
                                     items: 1
                                 },
                                 480: {
                                     items: 2
                                 },
                                 768: {
                                     items: 3
                                 },
                                 992: {
                                     items: 4
                                 },
                                 1200: {
                                     items: 5
                                 }
                            }
                        })
                    });
                </script>
                <?php endif; ?>
            </div><!-- /.sc_logo_showcase -->

        <?php

    }

}