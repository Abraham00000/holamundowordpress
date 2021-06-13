<?php
namespace NNfy\Elementor\Widget;

// Elementor Classes
use Elementor\Plugin as Elementor;
use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Core\Schemes\Color as Scheme_Color;
use Elementor\Core\Schemes\Typography as Scheme_Typography;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class NNfy_Adds_Banner_Element extends Widget_Base {

    public function get_name() {
        return 'nnfy-adds-banner';
    }

    public function get_title() {
        return __( '99FY: Adds Banner', '99fy' );
    }

    public function get_icon() {
        return 'eicon-image';
    }

    public function get_categories() {
        return ['99fy'];
    }

    protected function _register_controls() {

        $this->start_controls_section(
            'adds_banner_content',
            [
                'label' => __( 'Adds Banner', '99fy' ),
            ]
        );
            $this->add_control(
                'bannerimage',
                [
                    'label' => __( 'Banner image', '99fy' ),
                    'type' => Controls_Manager::MEDIA,
                    'default' => [
                        'url' => \Elementor\Utils::get_placeholder_image_src(),
                    ],
                ]
            );

            $this->add_group_control(
                \Elementor\Group_Control_Image_Size::get_type(),
                [
                    'name' => 'bannerimagesize',
                    'default' => 'large',
                    'separator' => 'none',
                ]
            );

            $this->add_control(
                'bannertitle',
                [
                    'label' => __( 'Banner Title', '99fy' ),
                    'type' => Controls_Manager::TEXTAREA,
                ]
            );

            $this->add_control(
                'bannersubtitle',
                [
                    'label' => __( 'Banner Sub Title', '99fy' ),
                    'type' => Controls_Manager::TEXTAREA,
                ]
            );

            $this->add_control(
                'buttontxt',
                [
                    'label' => __( 'Button Text', '99fy' ),
                    'type' => Controls_Manager::TEXT,
                ]
            );

            $this->add_control(
                'buttonlink',
                [
                    'label' => __( 'Button Link', '99fy' ),
                    'type' => Controls_Manager::URL,
                    'placeholder' => __( 'https://your-link.com', '99fy' ),
                    'show_external' => true,
                    'default' => [
                        'url' => '',
                        'is_external' => true,
                        'nofollow' => true,
                    ],
                ]
            );

        $this->end_controls_section();

        // Style tab section
        $this->start_controls_section(
            'banner-style-section',
            [
                'label' => esc_html__( 'Style', '99fy' ),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );
            
            $this->add_control(
                'title_style_heading',
                [
                    'label' => __( 'Title', '99fy' ),
                    'type' => Controls_Manager::HEADING,
                ]
            );

            $this->add_control(
                'title_color',
                [
                    'label' => __( 'Color', '99fy' ),
                    'type' => Controls_Manager::COLOR,
                    'scheme' => [
                        'type' => Scheme_Color::get_type(),
                        'value' => Scheme_Color::COLOR_1,
                    ],
                    'default' => '#fff',
                    'selectors' => [
                        '{{WRAPPER}} .banner-content > h4' => 'color: {{VALUE}};',
                    ],
                ]
            );

            $this->add_group_control(
                \Elementor\Group_Control_Typography::get_type(),
                [
                    'name' => 'title_typography',
                    'label' => __( 'Typography', '99fy' ),
                    'scheme' => Scheme_Typography::TYPOGRAPHY_1,
                    'selector' => '{{WRAPPER}} .banner-content > h4',
                ]
            );
            $this->add_responsive_control(
                        'title_padding',
                        [
                            'label' => __( 'Title Padding', '99fy' ),
                            'type' => Controls_Manager::DIMENSIONS,
                            'size_units' => [ 'px', '%' ],
                            'selectors' => [
                                '{{WRAPPER}} .banner-content > h4' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                            ],

                        ]
                    );
                    $this->add_responsive_control(
                        'title_margin',
                        [
                            'label' => __( 'Title Margin', '99fy' ),
                            'type' => Controls_Manager::DIMENSIONS,
                            'size_units' => [ 'px', '%' ],
                            'selectors' => [
                                '{{WRAPPER}} .banner-content > h4' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                            ],

                        ]
                    );

                    $this->add_control(
                        'sub_title_style_heading',
                        [
                            'label' => __( 'Sub Title', '99fy' ),
                            'type' => Controls_Manager::HEADING,
                            'separator'=>'before',
                        ]
                    );

                    $this->add_control(
                        'sub_title_color',
                        [
                            'label' => __( 'Color', '99fy' ),
                            'type' => Controls_Manager::COLOR,
                            'scheme' => [
                                'type' => Scheme_Color::get_type(),
                                'value' => Scheme_Color::COLOR_1,
                            ],
                            'default' => '#fff',
                            'selectors' => [
                                '{{WRAPPER}} .banner-content > h3' => 'color: {{VALUE}};',
                            ],
                        ]
                    );

                    $this->add_group_control(
                        \Elementor\Group_Control_Typography::get_type(),
                        [
                            'name' => 'sub_title_typography',
                            'label' => __( 'Typography', '99fy' ),
                            'scheme' => Scheme_Typography::TYPOGRAPHY_1,
                            'selector' => '{{WRAPPER}} .banner-content > h3',
                        ]
                    );
                    $this->add_responsive_control(
                        'sub_title_padding',
                        [
                            'label' => __( 'Subtitle Padding', '99fy' ),
                            'type' => Controls_Manager::DIMENSIONS,
                            'size_units' => [ 'px', '%' ],
                            'selectors' => [
                                '{{WRAPPER}} .banner-content > h3' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                            ],

                        ]
                    );
                    $this->add_responsive_control(
                        'sub_title_margin',
                        [
                            'label' => __( 'Subtitle Margin', '99fy' ),
                            'type' => Controls_Manager::DIMENSIONS,
                            'size_units' => [ 'px', '%' ],
                            'selectors' => [
                                '{{WRAPPER}} .banner-content > h3' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                            ],
                        ]
                    );

                    $this->add_control(
                        'button_style_heading',
                        [
                            'label' => __( 'Button', '99fy' ),
                            'type' => Controls_Manager::HEADING,
                            'separator'=>'before',
                        ]
                    );

            $this->add_control(
                'button_color',
                [
                    'label' => __( 'Color', '99fy' ),
                    'type' => Controls_Manager::COLOR,
                    'scheme' => [
                        'type' => Scheme_Color::get_type(),
                        'value' => Scheme_Color::COLOR_1,
                    ],
                    'default' => '#fff',
                    'selectors' => [
                        '{{WRAPPER}} .banner-content > a.banner_button' => 'color: {{VALUE}};',
                    ],
                ]
            );

            $this->add_control(
                'button_hover_color',
                [
                    'label' => __( 'Hover Color', '99fy' ),
                    'type' => Controls_Manager::COLOR,
                    'scheme' => [
                        'type' => Scheme_Color::get_type(),
                        'value' => Scheme_Color::COLOR_1,
                    ],
                    'default' => '#fff',
                    'selectors' => [
                        '{{WRAPPER}} .banner-content > a.banner_button:hover' => 'color: {{VALUE}};',
                    ],
                ]
            );
            $this->add_control(
                'button_bg_color',
                [
                    'label' => __( 'Button BG Color', '99fy' ),
                    'type' => Controls_Manager::COLOR,
                    'default' =>'rgba(0,0,0,0)',
                    'selectors' => [
                        '{{WRAPPER}} .banner-content > a.banner_button' => 'background: {{VALUE}};',
                    ],
                ]
            );
            $this->add_control(
                'button_bg_hvr_color',
                [
                    'label' => __( 'Button BG Hover Color', '99fy' ),
                    'type' => Controls_Manager::COLOR,
                    'default' =>'rgba(0,0,0,0)',
                    'selectors' => [
                        '{{WRAPPER}} .banner-content > a.banner_button:hover' => 'background: {{VALUE}};',
                    ],
                ]
            );
            $this->add_group_control(
                \Elementor\Group_Control_Typography::get_type(),
                [
                    'name' => 'button_typography',
                    'label' => __( 'Typography', '99fy' ),
                    'scheme' => Scheme_Typography::TYPOGRAPHY_1,
                    'selector' => '{{WRAPPER}} .banner-content > a.banner_button',
                ]
            );
            $this->add_control(
                'button_border_radius',
                [
                    'label' => __( 'Border Radius', '99fy' ),
                    'type' => Controls_Manager::DIMENSIONS,
                    'size_units' => [ 'px', '%' ],
                    'selectors' => [
                        '{{WRAPPER}} .banner-content > a.banner_button' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    ],

                ]
            );
            $this->add_responsive_control(
                'button_padding',
                [
                    'label' => __( 'Button Padding', '99fy' ),
                    'type' => Controls_Manager::DIMENSIONS,
                    'size_units' => [ 'px', '%' ],
                    'selectors' => [
                        '{{WRAPPER}} .banner-content > a.banner_button' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    ],

                ]
            );
            $this->add_responsive_control(
                'button_margin',
                [
                    'label' => __( 'Button Margin', '99fy' ),
                    'type' => Controls_Manager::DIMENSIONS,
                    'size_units' => [ 'px', '%' ],
                    'selectors' => [
                        '{{WRAPPER}} .banner-content > a.banner_button' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    ],

                ]
            );

        $this->end_controls_section(); // Style tab end



    }

    protected function render( $instance = [] ) {

        $settings   = $this->get_settings_for_display();

        $this->add_render_attribute( 'adds_banner_area_attr', 'class', 'sc_banner' );

        // Button Link
        $target = $settings['buttonlink']['is_external'] ? ' target="_blank"' : '';
        $nofollow = $settings['buttonlink']['nofollow'] ? ' rel="nofollow"' : '';
        $url = $settings['buttonlink']['url'] ? $settings['buttonlink']['url'] : '#';

        ?>
            <div <?php echo $this->get_render_attribute_string( 'adds_banner_area_attr' ); ?> >
                <div class="single-banner ht-text-center">
                    <?php echo \Elementor\Group_Control_Image_Size::get_attachment_image_html( $settings, 'bannerimagesize', 'bannerimage' );?>
                    <div class="banner-content">
                        <?php
                            if( !empty( $settings['bannersubtitle'] ) ){
                                echo '<h4>'.$settings['bannersubtitle'].'</h4>';
                            }
                            if( !empty( $settings['bannertitle'] ) ){
                                echo '<h3>'.$settings['bannertitle'].'</h3>';
                            }
                            if( !empty( $settings['buttontxt'] ) ){
                                echo '<a class="banner_button" href="'.esc_url( $url ).'" '.$target.$nofollow.'>'.esc_html__( $settings['buttontxt'], '99fy' ).'</a>';
                            }
                        ?>
                    </div>
                </div>
            </div>

        <?php

    }

}