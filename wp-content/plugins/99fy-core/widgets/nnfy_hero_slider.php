<?php
namespace NNfy\Elementor\Widget;

// Elementor Classes
use Elementor\Plugin as Elementor;
use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Text_Shadow;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Background;
use Elementor\Utils;
use Elementor\Core\Schemes\Color as Scheme_Color;
use Elementor\Core\Schemes\Typography as Scheme_Typography;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class NNfy_Hero_Slider_Element extends Widget_Base {

    public function get_name() {
        return 'nnfy-hero-slider';
    }

    public function get_title() {
        return __( '99FY: Hero Slider', '99fy' );
    }

    public function get_icon() {
        return 'eicon-slider-device';
    }

    public function get_categories() {
        return ['99fy'];
    }

    protected function _register_controls() {

        $this->start_controls_section(
            'hero_slider_content',
            [
                'label' => __( 'Hero Slider', '99fy' ),
            ]
        );
            
            $repeater = new \Elementor\Repeater();

            $repeater->start_controls_tabs('sldier_tabs');

                $repeater->start_controls_tab(
                    'slider_content_tab',
                    [
                        'label' => __( 'Content', '99fy' ),
                    ]
                );

                $repeater->add_control(
                    'sldier_title', [
                        'label' => __( 'Title', '99fy' ),
                        'type' => Controls_Manager::TEXT,
                        'default' => __( 'Wooden Regular Chair' , '99fy' ),
                        'label_block' => true,
                    ]
                );

                $repeater->add_control(
                    'sldier_sub_title', [
                        'label' => __( 'Sub Title', '99fy' ),
                        'type' => Controls_Manager::TEXT,
                        'default' => __( '$352.00' , '99fy' ),
                        'label_block' => true,
                    ]
                );

                $repeater->add_control(
                    'sldier_description', [
                        'label' => __( 'Description', '99fy' ),
                        'type' => Controls_Manager::WYSIWYG,
                        'default' => __( 'There are many variations of pas of Lorem Ipsum available, but the maj.' , '99fy' ),
                        'show_label' => false,
                    ]
                );

                $repeater->add_control(
                    'slider_image',
                    [
                        'label' => __( 'Slider Image', '99fy' ),
                        'type' => Controls_Manager::MEDIA,
                        'default' => [
                            'url' => Utils::get_placeholder_image_src(),
                        ],
                    ]
                );

                $repeater->add_control(
                    'sldier_button_txt', [
                        'label' => __( 'Button Text', '99fy' ),
                        'type' => Controls_Manager::TEXT,
                        'default' => __( 'Show Now' , '99fy' ),
                        'label_block' => true,
                    ]
                );

                $repeater->add_control(
                    'slider_button_link',
                    [
                        'label' => __( 'Button Link', '99fy' ),
                        'type' => Controls_Manager::URL,
                        'placeholder' => __( 'https://your-link.com', '99fy' ),
                        'show_external' => true,
                        'default' => [
                            'url' => '#',
                            'is_external' => true,
                            'nofollow' => true,
                        ],
                    ]
                );

                $repeater->end_controls_tab();

                // Style tabs
                $repeater->start_controls_tab(
                    'slider_style_tab',
                    [
                        'label' => __( 'Style', '99fy' ),
                    ]
                );

                $repeater->add_control(
                    'sldier_title_color',
                    [
                        'label' => __( 'Title Color', '99fy' ),
                        'type' => Controls_Manager::COLOR,
                        'selectors' => [
                            '{{WRAPPER}} .single-slider{{CURRENT_ITEM}} .slider-content h2' => 'color: {{VALUE}}'
                        ],
                    ]
                );

                $repeater->add_control(
                    'sldier_sub_title_color',
                    [
                        'label' => __( 'Sub Title Color', '99fy' ),
                        'type' => Controls_Manager::COLOR,
                        'selectors' => [
                            '{{WRAPPER}} .single-slider{{CURRENT_ITEM}} .slider-content h3' => 'color: {{VALUE}}'
                        ],
                    ]
                );

                $repeater->add_control(
                    'sldier_description_color',
                    [
                        'label' => __( 'Description Color', '99fy' ),
                        'type' => Controls_Manager::COLOR,
                        'selectors' => [
                            '{{WRAPPER}} .single-slider{{CURRENT_ITEM}} .slider-content p' => 'color: {{VALUE}}'
                        ],
                    ]
                );

                $repeater->add_control(
                    'sldier_button_color',
                    [
                        'label' => __( 'Button Color', '99fy' ),
                        'type' => Controls_Manager::COLOR,
                        'selectors' => [
                            '{{WRAPPER}} .single-slider{{CURRENT_ITEM}} .slider-btn-style' => 'color: {{VALUE}}'
                        ],
                    ]
                );

                $repeater->add_control(
                    'sldier_button_bg_color',
                    [
                        'label' => __( 'Button Background Color', '99fy' ),
                        'type' => Controls_Manager::COLOR,
                        'selectors' => [
                            '{{WRAPPER}} .single-slider{{CURRENT_ITEM}} .slider-btn-style' => 'background-color: {{VALUE}}'
                        ],
                    ]
                );

                $repeater->end_controls_tab();

            $repeater->end_controls_tabs();

            $this->add_control(
                'hero_slideres',
                [
                    'label' => __( 'Hero Slider', '99fy' ),
                    'type' => Controls_Manager::REPEATER,
                    'fields' => $repeater->get_controls(),
                    'default' => [
                        [
                            'sldier_title' => __( 'Wooden Regular Chair', '99fy' ),
                            'sldier_sub_title' => __( '$352.00', '99fy' ),
                            'sldier_description' => __( 'There are many variations of pas of Lorem Ipsum available, but the maj.', '99fy' ),
                            'sldier_button_txt' => __( 'Shop Now', '99fy' ),
                        ],
                        [
                            'sldier_title' => __( 'Wooden Regular Chair', '99fy' ),
                            'sldier_sub_title' => __( '$352.00', '99fy' ),
                            'sldier_description' => __( 'There are many variations of pas of Lorem Ipsum available, but the maj.', '99fy' ),
                            'sldier_button_txt' => __( 'Shop Now', '99fy' ),
                        ],
                    ],
                    'title_field' => '{{{ sldier_title }}}',
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
            'slider_style_section',
            [
                'label' => __( 'Slider', '99fy' ),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );
            $this->add_control(
                'sldier_title_heading',
                [
                    'label' => __( 'Title', '99fy' ),
                    'type' => Controls_Manager::HEADING,
                    'separator' => 'before',
                ]
            );

            $this->add_control(
                'sldier_title_color',
                [
                    'label' => __( 'Title Color', '99fy' ),
                    'type' => Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} .single-slider .slider-content h2' => 'color: {{VALUE}}'
                    ],
                ]
            );

            $this->add_group_control(
                Group_Control_Typography::get_type(),
                [
                    'name' => 'sldier_title_typography',
                    'label' => __( 'Title Typography', '99fy' ),
                    'scheme' => Scheme_Typography::TYPOGRAPHY_1,
                    'selector' => '{{WRAPPER}} .single-slider .slider-content h2',
                ]
            );

            $this->add_control(
                'sldier_sub_title_heading',
                [
                    'label' => __( 'Sub Title', '99fy' ),
                    'type' => Controls_Manager::HEADING,
                    'separator' => 'before',
                ]
            );

            $this->add_control(
                'sldier_sub_title_color',
                [
                    'label' => __( 'Sub Title Color', '99fy' ),
                    'type' => Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} .single-slider .slider-content h3' => 'color: {{VALUE}}'
                    ],
                ]
            );

            $this->add_group_control(
                Group_Control_Typography::get_type(),
                [
                    'name' => 'sldier_sub_title_typography',
                    'label' => __( 'Sub Title Typography', '99fy' ),
                    'scheme' => Scheme_Typography::TYPOGRAPHY_1,
                    'selector' => '{{WRAPPER}} .single-slider .slider-content h3',
                ]
            );

            $this->add_control(
                'sldier_description_heading',
                [
                    'label' => __( 'Description', '99fy' ),
                    'type' => Controls_Manager::HEADING,
                    'separator' => 'before',
                ]
            );

            $this->add_control(
                'sldier_description_color',
                [
                    'label' => __( 'Description Color', '99fy' ),
                    'type' => Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} .single-slider .slider-content p' => 'color: {{VALUE}}'
                    ],
                ]
            );

            $this->add_group_control(
                Group_Control_Typography::get_type(),
                [
                    'name' => 'sldier_description_typography',
                    'label' => __( 'Description Typography', '99fy' ),
                    'scheme' => Scheme_Typography::TYPOGRAPHY_1,
                    'selector' => '{{WRAPPER}} .single-slider .slider-content p',
                ]
            );

            $this->add_control(
                'sldier_button_heading',
                [
                    'label' => __( 'Button', '99fy' ),
                    'type' => Controls_Manager::HEADING,
                    'separator' => 'before',
                ]
            );

            $this->add_control(
                'sldier_button_color',
                [
                    'label' => __( 'Button Color', '99fy' ),
                    'type' => Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} .single-slider .slider-content .slider-btn-style' => 'color: {{VALUE}}'
                    ],
                ]
            );

            $this->add_control(
                'sldier_button_bg_color',
                [
                    'label' => __( 'Button Background Color', '99fy' ),
                    'type' => Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} .single-slider .slider-content .slider-btn-style' => 'background-color: {{VALUE}}'
                    ],
                ]
            );

            $this->add_group_control(
                Group_Control_Typography::get_type(),
                [
                    'name' => 'sldier_button_typography',
                    'label' => __( 'Button Typography', '99fy' ),
                    'scheme' => Scheme_Typography::TYPOGRAPHY_1,
                    'selector' => '{{WRAPPER}} .single-slider .slider-content .slider-btn-style',
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
                        '{{WRAPPER}} .slider-active .owl-nav div' => 'color: {{VALUE}}'
                    ],
                ]
            );

            $this->add_group_control(
                Group_Control_Typography::get_type(),
                [
                    'name' => 'sldier_navigation_typography',
                    'label' => __( 'Navigation Typography', '99fy' ),
                    'scheme' => Scheme_Typography::TYPOGRAPHY_1,
                    'selector' => '{{WRAPPER}} .slider-active .owl-nav div',
                ]
            );

            $this->add_control(
                'sldier_navigation_bg_color',
                [
                    'label' => __( 'Navigation Background Color', '99fy' ),
                    'type' => Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} .slider-active .owl-nav div' => 'background-color: {{VALUE}}'
                    ],
                ]
            );

            $this->add_group_control(
                Group_Control_Border::get_type(),
                [
                    'name' => 'bsldier_navigation_order',
                    'label' => __( 'Border', '99fy' ),
                    'selector' => '{{WRAPPER}} .slider-active .owl-nav div',
                ]
            );

        $this->end_controls_section();


    }

    protected function render( $instance = [] ) {

        $settings   = $this->get_settings_for_display();
        $id         = $this->get_id();

        $this->add_render_attribute( 'slider_area_attr', 'class', 'sc_hero_slider slider-area' );
        ?>
            <div <?php echo $this->get_render_attribute_string( 'slider_area_attr' ); ?> >
                <div class="slider-active owl-carousel">
                    <?php
                        foreach( $settings['hero_slideres'] as $item ):

                            // Link
                            $target = $item['slider_button_link']['is_external'] ? ' target="_blank"' : '';
                            $nofollow = $item['slider_button_link']['nofollow'] ? ' rel="nofollow"' : '';
                            $link_url = $item['slider_button_link']['url'] ? $item['slider_button_link']['url'] : '#';

                            // Image
                            $bg_image = '';
                            $bg_image_url = wp_get_attachment_image_src( $item['slider_image']['id'], 'full' );

                            if( $bg_image_url ){
                                $bg_image = 'style="background-image: url('. $bg_image_url[0].')"';
                            }
                    ?>
                        <div class="single-slider bg-img elementor-repeater-item-<?php echo $item['_id']; ?>" <?php echo $bg_image; ?>>
                            <div class="ht-container">
                                <div class="slider-content slider-content-style-1 slider-animated-1">
                                    <?php
                                        if( !empty( $item['sldier_sub_title'] ) ){
                                            echo '<h3 class="animated">'.esc_html( $item['sldier_sub_title'] ).'</h3>';
                                        }
                                        if( !empty( $item['sldier_title'] ) ){
                                            echo '<h2 class="animated">'.esc_html( $item['sldier_title'] ).'</h2>';
                                        }
                                        if( !empty( $item['sldier_description'] ) ){
                                            echo '<p class="animated">'.$item['sldier_description'].'</p>';
                                        }
                                        if( !empty( $item['sldier_button_txt'] ) ){
                                            echo '<a class="btn-hover slider-btn-style animated" href="'.esc_url( $link_url ).'" '.$target . $nofollow.'>'.esc_html( $item['sldier_button_txt'] ).'</a>';
                                        }
                                    ?>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
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
                            margin:0,
                            nav:<?php echo $nav; ?>,
                            autoplay: <?php echo $autoplay; ?>,
                            navText: [ '<i class="fa fa-angle-left"></i>','<i class="fa fa-angle-right"></i>' ],
                            autoplayTimeout: <?php echo $autoplaytimeout; ?>,
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