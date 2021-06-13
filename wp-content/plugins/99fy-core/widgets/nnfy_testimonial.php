<?php
namespace NNfy\Elementor\Widget;

// Elementor Classes
use Elementor\Plugin as Elementor;
use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Image_Size;
use Elementor\Core\Schemes\Color as Scheme_Color;
use Elementor\Core\Schemes\Typography as Scheme_Typography;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class NNfy_Testimonial_Element extends Widget_Base {

    public function get_name() {
        return 'nnfy-testimonial';
    }

    public function get_title() {
        return __( '99FY: Testimonial', '99fy' );
    }

    public function get_icon() {
        return 'eicon-testimonial';
    }

    public function get_categories() {
        return ['99fy'];
    }

    protected function _register_controls() {

        $this->start_controls_section(
            'testimonial_content',
            [
                'label' => __( 'Testimonial', '99fy' ),
            ]
        );
            
            $this->add_control(
                'section_title',
                [
                    'label' => __( 'Section Title', '99fy' ),
                    'type' => Controls_Manager::TEXT,
                    'default' => __( 'CUSTOMERS SAYS', '99fy' ),
                    'placeholder' => __( 'Type your title here', '99fy' ),
                ]
            );

            $repeater = new \Elementor\Repeater();

            $repeater->add_control(
                'client_name', [
                    'label' => __( 'Name', '99fy' ),
                    'type' => Controls_Manager::TEXT,
                    'default' => __( 'Jone Doy' , '99fy' ),
                    'label_block' => true,
                ]
            );

            $repeater->add_control(
                'client_designation', [
                    'label' => __( 'Designation', '99fy' ),
                    'type' => Controls_Manager::TEXT,
                    'default' => __( 'Developer' , '99fy' ),
                    'label_block' => true,
                ]
            );

            $repeater->add_control(
                'client_say', [
                    'label' => __( 'Description', '99fy' ),
                    'type' => Controls_Manager::TEXTAREA,
                    'default' => __( 'Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incidunt ut labore <br> et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut <br> aliquip ex ea commodo consequat' , '99fy' ),
                ]
            );

            $repeater->add_control(
                'client_image',
                [
                    'label' => __( 'Thumbnails', '99fy' ),
                    'type' => Controls_Manager::MEDIA,
                ]
            );

            $repeater->add_group_control(
                Group_Control_Image_Size::get_type(),
                [
                    'name' => 'client_imagesize',
                    'default' => 'large',
                    'separator' => 'none',
                ]
            );

            $this->add_control(
                'testimonial_list',
                [
                    'label' => __( 'Testimonial', '99fy' ),
                    'type' => Controls_Manager::REPEATER,
                    'fields' => $repeater->get_controls(),
                    'default' => [
                        [
                            'client_name' => __( 'Jone Doy', '99fy' ),
                            'client_designation' => __( 'Developer', '99fy' ),
                            'client_say' => __( 'Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incidunt ut labore <br> et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut <br> aliquip ex ea commodo consequat', '99fy' ),
                        ],
                        [
                            'client_name' => __( 'Alex Jon Bin', '99fy' ),
                            'client_designation' => __( 'Hapy Customer', '99fy' ),
                            'client_say' => __( 'Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incidunt ut labore <br> et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut <br> aliquip ex ea commodo consequat', '99fy' ),
                        ],

                    ],
                    'title_field' => '{{{ client_name }}}',
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

        // Style tab section
        $this->start_controls_section(
            'style_section',
            [
                'label' => __( 'Testimonial', '99fy' ),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );
            
            $this->add_control(
                'section_title_heading',
                [
                    'label' => __( 'Section Title', '99fy' ),
                    'type' => Controls_Manager::HEADING,
                    'separator' => 'before',
                ]
            );

            $this->add_control(
                'section_title_color',
                [
                    'label' => __( 'Section Title Color', '99fy' ),
                    'type' => Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} .section-title h3' => 'color: {{VALUE}}'
                    ],
                ]
            );

            $this->add_group_control(
                \Elementor\Group_Control_Typography::get_type(),
                [
                    'name' => 'section_title_typography',
                    'label' => __( 'Name Typography', '99fy' ),
                    'scheme' => Scheme_Typography::TYPOGRAPHY_4,
                    'selector' => '{{WRAPPER}} .section-title h3',
                ]
            );

            $this->add_control(
                'name_heading',
                [
                    'label' => __( 'Name', '99fy' ),
                    'type' => Controls_Manager::HEADING,
                    'separator' => 'before',
                ]
            );

            $this->add_control(
                'name_color',
                [
                    'label' => __( 'Name Color', '99fy' ),
                    'type' => Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} .single-testimonial > h4' => 'color: {{VALUE}}'
                    ],
                ]
            );

            $this->add_group_control(
                \Elementor\Group_Control_Typography::get_type(),
                [
                    'name' => 'name_typography',
                    'label' => __( 'Name Typography', '99fy' ),
                    'scheme' => Scheme_Typography::TYPOGRAPHY_4,
                    'selector' => '{{WRAPPER}} .single-testimonial > h4',
                ]
            );

            $this->add_control(
                'designation_heading',
                [
                    'label' => __( 'Designation', '99fy' ),
                    'type' => Controls_Manager::HEADING,
                    'separator' => 'before',
                ]
            );

            $this->add_control(
                'designation_color',
                [
                    'label' => __( 'Designation Color', '99fy' ),
                    'type' => Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} .single-testimonial > span' => 'color: {{VALUE}}'
                    ],
                ]
            );

            $this->add_group_control(
                \Elementor\Group_Control_Typography::get_type(),
                [
                    'name' => 'designation_typography',
                    'label' => __( 'Designation Typography', '99fy' ),
                    'scheme' => Scheme_Typography::TYPOGRAPHY_1,
                    'selector' => '{{WRAPPER}} .single-testimonial > span',
                ]
            );

            $this->add_control(
                'client_say_heading',
                [
                    'label' => __( 'Comment', '99fy' ),
                    'type' => Controls_Manager::HEADING,
                    'separator' => 'before',
                ]
            );

            $this->add_control(
                'comment_color',
                [
                    'label' => __( 'Comment Color', '99fy' ),
                    'type' => Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} .single-testimonial > p' => 'color: {{VALUE}}'
                    ],
                ]
            );

            $this->add_group_control(
                \Elementor\Group_Control_Typography::get_type(),
                [
                    'name' => 'comment_typography',
                    'label' => __( 'Description Typography', '99fy' ),
                    'scheme' => Scheme_Typography::TYPOGRAPHY_4,
                    'selector' => '{{WRAPPER}} .single-testimonial > p',
                ]
            );

            $this->add_control(
                'client_image_heading',
                [
                    'label' => __( 'Thumbnails', '99fy' ),
                    'type' => Controls_Manager::HEADING,
                    'separator' => 'before',
                ]
            );

            $this->add_group_control(
                Group_Control_Border::get_type(),
                [
                    'name' => 'client_image_border',
                    'label' => __( 'Border', '99fy' ),
                    'selector' => '{{WRAPPER}} .owl-carousel .owl-item .single-testimonial img',
                ]
            );

            $this->add_responsive_control(
                'client_image_border_radius',
                [
                    'label' => __( 'Border Radius', '99fy' ),
                    'type' => Controls_Manager::DIMENSIONS,
                    'size_units' => [ 'px', '%', 'em' ],
                    'selectors' => [
                        '{{WRAPPER}} .owl-carousel .owl-item .single-testimonial img' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    ],
                ]
            );

            $this->add_responsive_control(
                'client_image_margin',
                [
                    'label' => __( 'Margin', '99fy' ),
                    'type' => Controls_Manager::DIMENSIONS,
                    'size_units' => [ 'px', '%', 'em' ],
                    'selectors' => [
                        '{{WRAPPER}} .owl-carousel .owl-item .single-testimonial img' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    ],
                ]
            );

            $this->add_responsive_control(
                'client_image_padding',
                [
                    'label' => __( 'Padding', '99fy' ),
                    'type' => Controls_Manager::DIMENSIONS,
                    'size_units' => [ 'px', '%', 'em' ],
                    'selectors' => [
                        '{{WRAPPER}} .owl-carousel .owl-item .single-testimonial img' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    ],
                ]
            );

        $this->end_controls_section();

        // Style tab section
        $this->start_controls_section(
            'navigation_style_section',
            [
                'label' => __( 'Navigation', '99fy' ),
                'tab' => Controls_Manager::TAB_STYLE,
                'condition' => [
                    'navigation' => 'yes',
                ]
            ]
        );
            
            // Start Normal Style tab
            $this->start_controls_tabs( 'navigation_style_tabs' );

                $this->start_controls_tab(
                    'navigation_style_normal_tab',
                    [
                        'label' => __( 'Normal', '99fy' ),
                    ]
                );

                $this->add_control(
                    'navigation_color',
                    [
                        'label' => __( 'Color', '99fy' ),
                        'type' => Controls_Manager::COLOR,
                        'selectors' => [
                            '{{WRAPPER}} .owl-carousel .owl-nav div' => 'color: {{VALUE}}'
                        ],
                    ]
                );

                $this->add_group_control(
                    \Elementor\Group_Control_Typography::get_type(),
                    [
                        'name' => 'navigation_typography',
                        'label' => __( 'Typography', '99fy' ),
                        'scheme' => Scheme_Typography::TYPOGRAPHY_1,
                        'selector' => '{{WRAPPER}} .owl-carousel .owl-nav div',
                    ]
                );

                $this->add_control(
                    'navigation_bg_color',
                    [
                        'label' => __( 'Background Color', '99fy' ),
                        'type' => Controls_Manager::COLOR,
                        'selectors' => [
                            '{{WRAPPER}} .owl-carousel .owl-nav div' => 'background-color: {{VALUE}}'
                        ],
                    ]
                );

                $this->add_group_control(
                    Group_Control_Border::get_type(),
                    [
                        'name' => 'navigation_order',
                        'label' => __( 'Border', '99fy' ),
                        'selector' => '{{WRAPPER}} .owl-carousel .owl-nav div',
                    ]
                );

                $this->add_responsive_control(
                    'navigation_border_radius',
                    [
                        'label' => __( 'Border Radius', '99fy' ),
                        'type' => Controls_Manager::DIMENSIONS,
                        'size_units' => [ 'px', '%', 'em' ],
                        'selectors' => [
                            '{{WRAPPER}} .owl-carousel .owl-nav div' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                        ],
                    ]
                );

            $this->end_controls_tab();
            // End Normal Style tab

            // Start Hover Style tab
            $this->start_controls_tab(
                'navigation_style_hover_tab',
                [
                    'label' => __( 'Hover', '99fy' ),
                ]
            );
                
                $this->add_control(
                    'navigation_hover_color',
                    [
                        'label' => __( 'Color', '99fy' ),
                        'type' => Controls_Manager::COLOR,
                        'selectors' => [
                            '{{WRAPPER}} .testimonial .owl-nav div:hover' => 'color: {{VALUE}}'
                        ],
                    ]
                );

                $this->add_control(
                    'navigation_hover_bg_color',
                    [
                        'label' => __( 'Background Color', '99fy' ),
                        'type' => Controls_Manager::COLOR,
                        'selectors' => [
                            '{{WRAPPER}} .testimonial .owl-nav div:hover' => 'background-color: {{VALUE}}'
                        ],
                    ]
                );

                $this->add_group_control(
                    Group_Control_Border::get_type(),
                    [
                        'name' => 'navigation_hover_order',
                        'label' => __( 'Border', '99fy' ),
                        'selector' => '{{WRAPPER}} .testimonial .owl-nav div:hover',
                    ]
                );

            $this->end_controls_tab();
            $this->end_controls_tabs();
            // End Hover Style tab

        $this->end_controls_section();


    }

    protected function render( $instance = [] ) {

        $settings   = $this->get_settings_for_display();
        $id         = $this->get_id();

        $this->add_render_attribute( 'testimonial_area_attr', 'class', 'sc_info_with_icon' );
        ?>
            <div <?php echo $this->get_render_attribute_string( 'testimonial_area_attr' ); ?> >

                <?php 
                    if( !empty( $settings['section_title'] ) ){
                        echo '<div class="section-title ht-text-center mb-45"><h3>'.esc_html( $settings['section_title'] ).'</h3></div>';
                    }
                ?>
                <?php if( $settings['testimonial_list'] ): ?>
                    <div class="testimonial ht-text-center z-index owl-carousel">
                        <?php foreach( $settings['testimonial_list'] as $item ): ?>
                            <div class="single-testimonial">
                                <?php
                                    echo Group_Control_Image_Size::get_attachment_image_html( $item, 'client_imagesize', 'client_image' );
                                    if ( !empty( $item['client_say'] ) ){
                                        echo '<p>'.wp_kses_post( $item['client_say'] ).'</p>'; 
                                    }

                                    if ( !empty( $item['client_name'] ) ){
                                        echo '<h4>'.esc_html( $item['client_name'] ).'</h4>'; 
                                    }
                                
                                    if ( !empty( $item['client_designation'] ) ){
                                        echo '<span>'.esc_html( $item['client_designation'] ).'</span>'; 
                                    }
                                ?>                
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>

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
                    if ($('.elementor-element-<?php echo $id; ?> .owl-carousel').length) {
                        $('.elementor-element-<?php echo $id; ?> .owl-carousel').owlCarousel({
                            loop: <?php echo $loop; ?>,
                            autoplay: <?php echo $autoplay; ?>,
                            autoplayTimeout: <?php echo $autoplaytimeout; ?>,
                            nav:<?php echo $nav; ?>,
                            navText: [ '<i class="fa fa-angle-left"></i>','<i class="fa fa-angle-right"></i>' ],
                            lazyLoad: true,
                            items: 1,
                            responsive:{
                                0:{
                                    items: 1
                                },
                            }
                        });
                    }
                });
            </script>

        <?php

    }

}