<?php
namespace NNfy\Elementor\Widget;

// Elementor Classes
use Elementor\Plugin as Elementor;
use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Core\Schemes\Color as Scheme_Color;
use Elementor\Core\Schemes\Typography as Scheme_Typography;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class NNfy_Service_Info_Element extends Widget_Base {

    public function get_name() {
        return 'nnfy-service-info';
    }

    public function get_title() {
        return __( '99FY: Service Info', '99fy' );
    }

    public function get_icon() {
        return 'eicon-info-box';
    }

    public function get_categories() {
        return ['99fy'];
    }

    protected function _register_controls() {

        $this->start_controls_section(
            'service_content',
            [
                'label' => __( 'Service', '99fy' ),
            ]
        );
            
            $this->add_control(
                'service_icon_type',
                [
                    'label' => __( 'Service Icon Type', '99fy' ),
                    'type' =>Controls_Manager::CHOOSE,
                    'options' =>[
                        'img' =>[
                            'title' =>__( 'Image', '99fy' ),
                            'icon' =>'fa fa-picture-o',
                        ],
                        'icon' =>[
                            'title' =>__( 'Icon', '99fy' ),
                            'icon' =>'fa fa-info',
                        ]
                    ],
                    'default' => 'img',
                ]
            );

            $this->add_control(
                'serviceimage',
                [
                    'label' => __( 'Image', '99fy' ),
                    'type' => Controls_Manager::MEDIA,
                    'default' => [
                        'url' => \Elementor\Utils::get_placeholder_image_src(),
                    ],
                    'condition' => [
                        'service_icon_type' => 'img',
                    ]
                ]
            );

            $this->add_group_control(
                \Elementor\Group_Control_Image_Size::get_type(),
                [
                    'name' => 'serviceimagesize',
                    'default' => 'large',
                    'separator' => 'none',
                    'condition' => [
                        'service_icon_type' => 'img',
                    ]
                ]
            );

            $this->add_control(
                'service_icon',
                [
                    'label' => __( 'Icon','99fy' ),
                    'type'=> Controls_Manager::ICONS,
                    'default' => [
                        'value'=>'fas fa-pencil-alt',
                        'library'=>'solid',
                    ],
                    'condition' => [
                        'service_icon_type' => 'icon',
                    ]
                ]
            );

            $this->add_control(
                'servicetitle',
                [
                    'label' => __( 'Title', '99fy' ),
                    'type' => Controls_Manager::TEXT,
                ]
            );

            $this->add_control(
                'servicesubtitle',
                [
                    'label' => __( 'Sub Title', '99fy' ),
                    'type' => Controls_Manager::TEXT,
                ]
            );

            $this->add_control(
                'servicelink',
                [
                    'label' => __( 'Link', '99fy' ),
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
            'style_section',
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
                    'default' => '#4f4e4e',
                    'selectors' => [
                        '{{WRAPPER}} .single-shop-content h5' => 'color: {{VALUE}};',
                    ],
                ]
            );

            $this->add_group_control(
                \Elementor\Group_Control_Typography::get_type(),
                [
                    'name' => 'title_typography',
                    'label' => __( 'Typography', '99fy' ),
                    'scheme' => Scheme_Typography::TYPOGRAPHY_4,
                    'selector' => '{{WRAPPER}} .single-shop-content h5',
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
                    'default' => '#4f4e4e',
                    'selectors' => [
                        '{{WRAPPER}} .single-shop-content > p' => 'color: {{VALUE}};',
                    ],
                ]
            );

            $this->add_group_control(
                \Elementor\Group_Control_Typography::get_type(),
                [
                    'name' => 'sub_title_typography',
                    'label' => __( 'Typography', '99fy' ),
                    'scheme' => Scheme_Typography::TYPOGRAPHY_4,
                    'selector' => '{{WRAPPER}} .single-shop-content > p',
                ]
            );

            $this->add_control(
                'icon_style_heading',
                [
                    'label' => __( 'Icon', '99fy' ),
                    'type' => Controls_Manager::HEADING,
                    'separator'=>'before',
                    'condition'=>[
                        'service_icon_type'=>'icon',
                    ],
                ]
            );

            $this->add_control(
                'icon_color',
                [
                    'label' => __( 'Color', '99fy' ),
                    'type' => Controls_Manager::COLOR,
                    'scheme' => [
                        'type' => Scheme_Color::get_type(),
                        'value' => Scheme_Color::COLOR_1,
                    ],
                    'default' => '#4f4e4e',
                    'selectors' => [
                        '{{WRAPPER}} .single-shop-services i' => 'color: {{VALUE}};',
                    ],
                    'condition'=>[
                        'service_icon_type'=>'icon',
                    ],
                ]
            );

            $this->add_control(
                'icon_size',
                [
                    'label' => __( 'Font Size', '99fy' ),
                    'type' => Controls_Manager::SLIDER,
                    'size_units' => [ 'px', '%' ],
                    'range' => [
                        'px' => [
                            'min' => 0,
                            'max' => 100,
                            'step' => 5,
                        ],
                        '%' => [
                            'min' => 0,
                            'max' => 100,
                        ],
                    ],
                    'default' => [
                        'unit' => 'px',
                        'size' => 18,
                    ],
                    'selectors' => [
                        '{{WRAPPER}} .single-shop-services i' => 'font-size: {{SIZE}}{{UNIT}};',
                    ],
                    'condition'=>[
                        'service_icon_type'=>'icon',
                    ],
                ]
            );

        $this->end_controls_section(); // Style tab end



    }

    protected function render( $instance = [] ) {

        $settings   = $this->get_settings_for_display();

        $this->add_render_attribute( 'service_area_attr', 'class', 'sc_info_with_icon services-all' );

        // Button Link
        $target = $settings['servicelink']['is_external'] ? ' target="_blank"' : '';
        $nofollow = $settings['servicelink']['nofollow'] ? ' rel="nofollow"' : '';
        $url = $settings['servicelink']['url'] ? $settings['servicelink']['url'] : '';

        ?>
            <div <?php echo $this->get_render_attribute_string( 'service_area_attr' ); ?> >
                
                <div class="single-shop-services mb-30">
                    <?php
                        if( 'img' === $settings['service_icon_type'] && !empty( $settings['serviceimage']['url'] ) ){
                            echo '<div class="single-shop-img">'.\Elementor\Group_Control_Image_Size::get_attachment_image_html( $settings, 'serviceimagesize', 'serviceimage' ).'</div>'; 
                        }
                        if( 'icon' === $settings['service_icon_type'] ){
                            \Elementor\Icons_Manager::render_icon( $settings['service_icon'], [ 'aria-hidden' => 'true' ] );
                        }
                    ?>
                    <div class="single-shop-content">
                        <?php
                            if( !empty( $url ) ){
                                echo '<a href="'.esc_url( $url ).'" '.$target.$nofollow.'>';
                            }

                            if( !empty( $settings['servicetitle'] ) ){
                                echo '<h5>'.esc_html( $settings['servicetitle'] ).'</h5>';
                            }

                            if( !empty( $url ) ){ echo '</a>'; }

                            if( !empty( $settings['servicesubtitle'] ) ){
                                echo '<p>'.esc_html( $settings['servicesubtitle'] ).'</p>';
                            }
                        ?>
                    </div>
                </div>

            </div>

        <?php

    }

}