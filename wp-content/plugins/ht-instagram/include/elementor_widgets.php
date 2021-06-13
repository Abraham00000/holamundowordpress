<?php
namespace Elementor;

// Elementor Classes
use Elementor\Core\Schemes\Color as Scheme_Color;
use Elementor\Core\Schemes\Typography as Scheme_Typography;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class HTinstragram_Elementor_Widget_Instagram extends Widget_Base {

    public function get_name() {
        return 'htinstagram-instagram-addons';
    }
    
    public function get_title() {
        return __( 'HT Instagram', 'ht-instagram' );
    }

    public function get_icon() {
        return 'eicon-photo-library';
    }

    public function get_categories() {
        return [ 'general' ];
    }

    public function get_style_depends() {
        return [ 'slick','elementor-icons-shared-0-css','elementor-icons-fa-brands','elementor-icons-fa-regular','elementor-icons-fa-solid' ];
    }

    public function get_script_depends() {
        return [ 'slick', 'ht-active' ];
    }

    protected function _register_controls() {

        $this->start_controls_section(
            'instagram_content',
            [
                'label' => __( 'Instagram', 'ht-instagram' ),
            ]
        );

            $this->add_control(
                'instagram_style',
                [
                    'label' => __( 'Style', 'ht-instagram' ),
                    'type' => Controls_Manager::SELECT,
                    'default' => '1',
                    'options' => [
                        '1'   => __( 'Style One', 'ht-instagram' ),
                        '2'   => __( 'Style Two', 'ht-instagram' ),
                    ],
                ]
            );

            $this->add_control(
                'limit',
                [
                    'label' => __( 'Item Limit', 'ht-instagram' ),
                    'type' => Controls_Manager::NUMBER,
                    'min' => 1,
                    'max' => 200,
                    'step' => 1,
                    'default' => 8,
                    'separator'=>'before',
                ]
            );

            $this->add_control(
                'delete_cache',
                [
                    'label'         => __( 'Delete existing caching data', 'ht-instagram' ),
                    'type'          => Controls_Manager::SWITCHER,
                    'separator'     => 'before',
                ]
            );

            $this->add_control(
                'cash_time_duration',
                [
                    'label' => __('Cache Time Duration', 'ht-instagram'),
                    'type' => Controls_Manager::SELECT,
                    'options' => [
                        'minute'    => __('Minute', 'ht-instagram'),
                        'hour'      => __('Hour', 'ht-instagram'),
                        'day'       => __('Day', 'ht-instagram'),
                        'week'      => __('Week', 'ht-instagram'),
                        'month'     => __('Month', 'ht-instagram'),
                        'year'      => __('Year', 'ht-instagram'),
                    ],
                    'default' => 'day',
                    'condition'=>[
                        'delete_cache!'=>'yes',
                    ],
                    'label_block'=>true,
                ]
            );

            $this->add_responsive_control(
                'instagram_column',
                [
                    'label' => __( 'Column', 'ht-instagram' ),
                    'type' => Controls_Manager::SELECT,
                    'description'   => wp_kses_post( 'If the slider is off, Then it will work.', 'ht-instagram' ),
                    'prefix_class' => 'htinsta-column%s-',
                    'default' => '4',
                    'required' => true,
                    'device_args' => [
                        Controls_Stack::RESPONSIVE_TABLET => [
                            'required' => false,
                        ],
                        Controls_Stack::RESPONSIVE_MOBILE => [
                            'required' => false,
                        ],
                    ],
                    'min_affected_device' => [
                        Controls_Stack::RESPONSIVE_DESKTOP => Controls_Stack::RESPONSIVE_TABLET,
                        Controls_Stack::RESPONSIVE_TABLET => Controls_Stack::RESPONSIVE_TABLET,
                    ],
                    'options' => [
                        '1'   => __( '1 Column', 'ht-instagram' ),
                        '2'   => __( '2 Column', 'ht-instagram' ),
                        '3'   => __( '3 Column', 'ht-instagram' ),
                        '4'   => __( '4 Column', 'ht-instagram' ),
                        '5'   => __( '5 Column', 'ht-instagram' ),
                        '6'   => __( '6 Column', 'ht-instagram' ),
                    ],
                ]
            );

            $this->add_control(
                'show_caption',
                [
                    'label'         => __( 'Show Caption', 'ht-instagram' ),
                    'type'          => Controls_Manager::SWITCHER,
                    'label_on'      => __( 'Show', 'ht-instagram' ),
                    'label_off'     => __( 'Hide', 'ht-instagram' ),
                    'return_value'  => 'yes',
                    'default'       => 'yes',
                ]
            );

            $this->add_control(
                'commentlike_pos',
                [
                    'label' => __( 'Caption Position', 'ht-instagram' ),
                    'type' => Controls_Manager::SELECT,
                    'default' => 'top',
                    'label_block' => true,
                    'options' => [
                        'top'     => __( 'Top', 'ht-instagram' ),
                        'middle'  => __( 'Middle', 'ht-instagram' ),
                        'bottom'  => __( 'Bottom', 'ht-instagram' ),
                    ],
                ]
            );

            $this->add_control(
                'show_light_box',
                [
                    'label'         => __( 'Show Light Box', 'ht-instagram' ),
                    'type'          => Controls_Manager::SWITCHER,
                    'label_on'      => __( 'Show', 'ht-instagram' ),
                    'label_off'     => __( 'Hide', 'ht-instagram' ),
                    'return_value'  => 'yes',
                    'default'       => 'yes',
                ]
            );

            $this->add_control(
                'zoomicon_type',
                [
                    'label' => esc_html__('Zoom Icon Type','ht-instagram'),
                    'type' =>Controls_Manager::CHOOSE,
                    'options' =>[
                        'img' =>[
                            'title' =>__('Image','ht-instagram'),
                            'icon' =>'fa fa-picture-o',
                        ],
                        'icon' =>[
                            'title' =>__('Icon','ht-instagram'),
                            'icon' =>'fa fa-info',
                        ]
                    ],
                    'default' =>'img',
                    'condition' =>[
                        'show_light_box' =>'yes',
                    ],
                ]
            );

            $this->add_control(
                'zoom_image',
                [
                    'label' => __('Image','ht-instagram'),
                    'type'=>Controls_Manager::MEDIA,
                    'dynamic' => [
                        'active' => true,
                    ],
                    'condition' => [
                        'show_light_box' =>'yes',
                        'zoomicon_type' => 'img',
                    ]
                ]
            );

            $this->add_group_control(
                Group_Control_Image_Size::get_type(),
                [
                    'name' => 'zoom_imagesize',
                    'default' => 'large',
                    'separator' => 'none',
                    'condition' => [
                        'show_light_box' =>'yes',
                        'zoomicon_type' => 'img',
                    ]
                ]
            );

            $this->add_control(
                'zoom_icon',
                [
                    'label' =>__('Zoom Icon','ht-instagram'),
                    'type'=>Controls_Manager::ICONS,
                    'default' => [
                        'value'=>'fas fa-plus',
                        'library' => 'solid',
                    ],
                    'condition' => [
                        'show_light_box' =>'yes',
                        'zoomicon_type' => 'icon',
                    ]
                ]
            );

            $this->add_control(
                'show_follow_button',
                [
                    'label'         => __( 'Show Follow Button', 'ht-instagram' ),
                    'type'          => Controls_Manager::SWITCHER,
                    'label_on'      => __( 'Show', 'ht-instagram' ),
                    'label_off'     => __( 'Hide', 'ht-instagram' ),
                    'return_value'  => 'yes',
                    'default'       => 'yes',
                ]
            );

            $this->add_control(
                'flow_button_txt',
                [
                    'label' => __( 'Follow button Aditional text', 'ht-instagram' ),
                    'type' => Controls_Manager::TEXT,
                    'default' => __( 'Follow @', 'ht-instagram' ),
                    'condition'=>[
                        'show_follow_button'=>'yes',
                    ],
                    'label_block'=>true,
                ]
            );

            $this->add_control(
                'flow_button_icon',
                [
                    'label' =>__('Flow Button Icon','ht-instagram'),
                    'type'=>Controls_Manager::ICONS,
                    'default' => [
                        'value'=>'fab fa-instagram',
                        'library' => 'solid',
                    ],
                    'condition' => [
                        'show_follow_button' =>'yes',
                    ]
                ]
            );

            $this->add_control(
                'followbtn_pos',
                [
                    'label' => __( 'Follow Button Position', 'ht-instagram' ),
                    'type' => Controls_Manager::SELECT,
                    'default' => 'bottom',
                    'label_block' => true,
                    'options' => [
                        'top'     => __( 'Top', 'ht-instagram' ),
                        'middle'  => __( 'Middle', 'ht-instagram' ),
                        'bottom'  => __( 'Bottom', 'ht-instagram' ),
                    ],
                    'condition' => [
                        'show_follow_button' =>'yes',
                    ]
                ]
            );

             $this->add_control(
                'gutter_space',
                [
                    'label' => __( 'Gutter Space', 'ht-instagram' ),
                    'type' => Controls_Manager::SLIDER,
                    'default' => [
                        'size' => 5,
                        'unit' => 'px',
                    ],
                    'range' => [
                        'px' => [
                            'min' => 0,
                            'max' => 500,
                        ],
                    ],
                ]
            );

            $this->add_control(
                'slider_on',
                [
                    'label'         => __( 'Slider', 'ht-instagram' ),
                    'type'          => Controls_Manager::SWITCHER,
                    'label_on'      => __( 'On', 'ht-instagram' ),
                    'label_off'     => __( 'Off', 'ht-instagram' ),
                    'return_value'  => 'yes',
                    'default'       => 'no',
                ]
            );
        
        $this->end_controls_section();

        // Slider setting
        $this->start_controls_section(
            'instagram_slider_option',
            [
                'label' => esc_html__( 'Slider Option', 'ht-instagram' ),
                'condition' => [
                    'slider_on' => 'yes',
                ]
            ]
        );

            $this->add_control(
                'slitems',
                [
                    'label' => esc_html__( 'Slider Items', 'ht-instagram' ),
                    'type' => Controls_Manager::NUMBER,
                    'min' => 1,
                    'max' => 100,
                    'step' => 1,
                    'default' => 8,
                    'condition' => [
                        'slider_on' => 'yes',
                    ]
                ]
            );

            $this->add_control(
                'slrows',
                [
                    'label' => esc_html__( 'Slider Row', 'ht-instagram' ),
                    'type' => Controls_Manager::NUMBER,
                    'min' => 1,
                    'max' => 50,
                    'step' => 1,
                    'default' => 2,
                    'condition' => [
                        'slider_on' => 'yes',
                    ]
                ]
            );

            $this->add_control(
                'slarrows',
                [
                    'label' => esc_html__( 'Slider Arrow', 'ht-instagram' ),
                    'type' => Controls_Manager::SWITCHER,
                    'return_value' => 'yes',
                    'default' => 'yes',
                    'condition' => [
                        'slider_on' => 'yes',
                    ]
                ]
            );

            $this->add_control(
                'slprevicon',
                [
                    'label' => __( 'Previous icon', 'ht-instagram' ),
                    'type' => Controls_Manager::ICONS,
                    'default' => [
                        'value'=>'fas fa-angle-left',
                        'library' => 'solid',
                    ],
                    'condition' => [
                        'slider_on' => 'yes',
                        'slarrows' => 'yes',
                    ]
                ]
            );

            $this->add_control(
                'slnexticon',
                [
                    'label' => __( 'Next icon', 'ht-instagram' ),
                    'type' => Controls_Manager::ICONS,
                    'default' => [
                        'value'=>'fas fa-angle-right',
                        'library' => 'solid',
                    ],
                    'condition' => [
                        'slider_on' => 'yes',
                        'slarrows' => 'yes',
                    ]
                ]
            );

            $this->add_control(
                'sldots',
                [
                    'label' => esc_html__( 'Slider dots', 'ht-instagram' ),
                    'type' => Controls_Manager::SWITCHER,
                    'return_value' => 'yes',
                    'default' => 'no',
                    'condition' => [
                        'slider_on' => 'yes',
                    ]
                ]
            );

            $this->add_control(
                'slcentermode',
                [
                    'label' => esc_html__( 'Center Mode', 'ht-instagram' ),
                    'type' => Controls_Manager::SWITCHER,
                    'return_value' => 'yes',
                    'default' => 'no',
                    'condition' => [
                        'slider_on' => 'yes',
                    ]
                ]
            );

            $this->add_control(
                'slcenterpadding',
                [
                    'label' => esc_html__( 'Center padding', 'ht-instagram' ),
                    'type' => Controls_Manager::NUMBER,
                    'min' => 0,
                    'max' => 500,
                    'step' => 1,
                    'default' => 50,
                    'condition' => [
                        'slider_on' => 'yes',
                        'slcentermode' => 'yes',
                    ]
                ]
            );

            $this->add_control(
                'slautolay',
                [
                    'label' => esc_html__( 'Slider auto play', 'ht-instagram' ),
                    'type' => Controls_Manager::SWITCHER,
                    'return_value' => 'yes',
                    'separator' => 'before',
                    'default' => 'no',
                    'condition' => [
                        'slider_on' => 'yes',
                    ]
                ]
            );

            $this->add_control(
                'slautoplay_speed',
                [
                    'label' => __('Autoplay speed', 'ht-instagram'),
                    'type' => Controls_Manager::NUMBER,
                    'default' => 3000,
                    'condition' => [
                        'slider_on' => 'yes',
                    ]
                ]
            );


            $this->add_control(
                'slanimation_speed',
                [
                    'label' => __('Autoplay animation speed', 'ht-instagram'),
                    'type' => Controls_Manager::NUMBER,
                    'default' => 300,
                    'condition' => [
                        'slider_on' => 'yes',
                    ]
                ]
            );

            $this->add_control(
                'slscroll_columns',
                [
                    'label' => __('Slider item to scroll', 'ht-instagram'),
                    'type' => Controls_Manager::NUMBER,
                    'min' => 1,
                    'max' => 10,
                    'step' => 1,
                    'default' => 1,
                    'condition' => [
                        'slider_on' => 'yes',
                    ]
                ]
            );

            $this->add_control(
                'heading_tablet',
                [
                    'label' => __( 'Tablet', 'ht-instagram' ),
                    'type' => Controls_Manager::HEADING,
                    'separator' => 'after',
                    'condition' => [
                        'slider_on' => 'yes',
                    ]
                ]
            );

            $this->add_control(
                'sltablet_display_columns',
                [
                    'label' => __('Slider Items', 'ht-instagram'),
                    'type' => Controls_Manager::NUMBER,
                    'min' => 1,
                    'max' => 8,
                    'step' => 1,
                    'default' => 1,
                    'condition' => [
                        'slider_on' => 'yes',
                    ]
                ]
            );

            $this->add_control(
                'sltablet_scroll_columns',
                [
                    'label' => __('Slider item to scroll', 'ht-instagram'),
                    'type' => Controls_Manager::NUMBER,
                    'min' => 1,
                    'max' => 8,
                    'step' => 1,
                    'default' => 1,
                    'condition' => [
                        'slider_on' => 'yes',
                    ]
                ]
            );

            $this->add_control(
                'sltablet_width',
                [
                    'label' => __('Tablet Resolution', 'ht-instagram'),
                    'description' => __('The resolution to tablet.', 'ht-instagram'),
                    'type' => Controls_Manager::NUMBER,
                    'default' => 750,
                    'condition' => [
                        'slider_on' => 'yes',
                    ]
                ]
            );

            $this->add_control(
                'heading_mobile',
                [
                    'label' => __( 'Mobile Phone', 'ht-instagram' ),
                    'type' => Controls_Manager::HEADING,
                    'separator' => 'after',
                    'condition' => [
                        'slider_on' => 'yes',
                    ]
                ]
            );

            $this->add_control(
                'slmobile_display_columns',
                [
                    'label' => __('Slider Items', 'ht-instagram'),
                    'type' => Controls_Manager::NUMBER,
                    'min' => 1,
                    'max' => 4,
                    'step' => 1,
                    'default' => 1,
                    'condition' => [
                        'slider_on' => 'yes',
                    ]
                ]
            );

            $this->add_control(
                'slmobile_scroll_columns',
                [
                    'label' => __('Slider item to scroll', 'ht-instagram'),
                    'type' => Controls_Manager::NUMBER,
                    'min' => 1,
                    'max' => 4,
                    'step' => 1,
                    'default' => 1,
                    'condition' => [
                        'slider_on' => 'yes',
                    ]
                ]
            );

            $this->add_control(
                'slmobile_width',
                [
                    'label' => __('Mobile Resolution', 'ht-instagram'),
                    'description' => __('The resolution to mobile.', 'ht-instagram'),
                    'type' => Controls_Manager::NUMBER,
                    'default' => 480,
                    'condition' => [
                        'slider_on' => 'yes',
                    ]
                ]
            );

        $this->end_controls_section(); // Slider Option end

        // Item Style
        $this->start_controls_section(
            'htinsta_instagram_item_style_section',
            [
                'label' => __( 'Item', 'ht-instagram' ),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );
            
            $this->add_group_control(
                Group_Control_Background::get_type(),
                [
                    'name' => 'instagram_item_background',
                    'label' => __( 'Background', 'ht-instagram' ),
                    'types' => [ 'classic', 'gradient' ],
                    'selector' => '{{WRAPPER}} .htinsta-instragram ul li',
                ]
            );

            $this->add_responsive_control(
                'instagram_item_margin',
                [
                    'label' => __( 'Margin', 'ht-instagram' ),
                    'type' => Controls_Manager::DIMENSIONS,
                    'size_units' => [ 'px', '%', 'em' ],
                    'selectors' => [
                        '{{WRAPPER}} .htinsta-instragram ul li' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    ],
                    'separator' =>'before',
                ]
            );

            $this->add_responsive_control(
                'instagram_item_padding',
                [
                    'label' => __( 'Padding', 'ht-instagram' ),
                    'type' => Controls_Manager::DIMENSIONS,
                    'size_units' => [ 'px', '%', 'em' ],
                    'selectors' => [
                        '{{WRAPPER}} .htinsta-instragram ul li' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    ],
                ]
            );

            $this->add_group_control(
                Group_Control_Border::get_type(),
                [
                    'name' => 'instagram_item_border',
                    'label' => __( 'Border', 'ht-instagram' ),
                    'selector' => '{{WRAPPER}} .htinsta-instragram ul li',
                ]
            );

            $this->add_responsive_control(
                'instagram_item_border_radius',
                [
                    'label' => esc_html__( 'Border Radius', 'ht-instagram' ),
                    'type' => Controls_Manager::DIMENSIONS,
                    'selectors' => [
                        '{{WRAPPER}} .htinsta-instragram ul li' => 'border-radius: {{TOP}}px {{RIGHT}}px {{BOTTOM}}px {{LEFT}}px;',
                    ],
                ]
            );

            $this->add_control(
                'instagram_item_overlay_color',
                [
                    'label' => __( 'Overlay Color', 'ht-instagram' ),
                    'type' => Controls_Manager::COLOR,
                    'scheme' => [
                        'type' => Scheme_Color::get_type(),
                        'value' => Scheme_Color::COLOR_1,
                    ],
                    'default' => 'rgba(0, 0, 0, 0.7)',
                    'selectors' => [
                        '{{WRAPPER}} .htinsta-instragram ul li .instagram-clip::before' => 'background-color: {{VALUE}};',
                    ],
                ]
            );

        $this->end_controls_section(); // Item Style end

        // Zoom icon Style
        $this->start_controls_section(
            'instagram_instagram_icon_style_section',
            [
                'label' => __( 'Icon', 'ht-instagram' ),
                'tab' => Controls_Manager::TAB_STYLE,
                'condition' =>[
                    'show_light_box' =>'yes',
                    'zoomicon_type'=>'icon',
                    'zoom_icon!'=>'',
                ]
            ]
        );

            $this->add_control(
                'icon_size',
                [
                    'label' => __( 'Font Size', 'ht-instagram' ),
                    'type' => Controls_Manager::SLIDER,
                    'size_units' => [ 'px', '%' ],
                    'range' => [
                        'px' => [
                            'min' => 0,
                            'max' => 100,
                            'step' => 1,
                        ],
                        '%' => [
                            'min' => 0,
                            'max' => 100,
                        ],
                    ],
                    'default' => [
                        'unit' => 'px',
                        'size' => 24,
                    ],
                    'selectors' => [
                        '{{WRAPPER}} .instagram-btn .zoom_icon' => 'font-size: {{SIZE}}{{UNIT}};',
                    ],
                ]
            );

            $this->add_control(
                'instagram_icon_color',
                [
                    'label' => __( 'Color', 'ht-instagram' ),
                    'type' => Controls_Manager::COLOR,
                    'scheme' => [
                        'type' => Scheme_Color::get_type(),
                        'value' => Scheme_Color::COLOR_1,
                    ],
                    'default' => '#ffffff',
                    'selectors' => [
                        '{{WRAPPER}} .instagram-btn .zoom_icon' => 'color: {{VALUE}};',
                    ],
                ]
            );

            $this->add_group_control(
                Group_Control_Background::get_type(),
                [
                    'name' => 'instagram_icon_background',
                    'label' => __( 'Background', 'ht-instagram' ),
                    'types' => [ 'classic', 'gradient' ],
                    'selector' => '{{WRAPPER}} .instagram-btn ul .zoom_icon',
                ]
            );

            $this->add_responsive_control(
                'instagram_icon_padding',
                [
                    'label' => __( 'Padding', 'ht-instagram' ),
                    'type' => Controls_Manager::DIMENSIONS,
                    'size_units' => [ 'px', '%', 'em' ],
                    'selectors' => [
                        '{{WRAPPER}} .instagram-btn ul .zoom_icon' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    ],
                ]
            );

            $this->add_group_control(
                Group_Control_Border::get_type(),
                [
                    'name' => 'instagram_icon_border',
                    'label' => __( 'Border', 'ht-instagram' ),
                    'selector' => '{{WRAPPER}} .instagram-btn ul .zoom_icon',
                ]
            );

            $this->add_responsive_control(
                'instagram_icon_border_radius',
                [
                    'label' => esc_html__( 'Border Radius', 'ht-instagram' ),
                    'type' => Controls_Manager::DIMENSIONS,
                    'selectors' => [
                        '{{WRAPPER}} .instagram-btn ul .zoom_icon' => 'border-radius: {{TOP}}px {{RIGHT}}px {{BOTTOM}}px {{LEFT}}px;',
                    ],
                ]
            );

        $this->end_controls_section(); // Zoom icon Style end

        // Like Comment
        $this->start_controls_section(
            'htinstagram_commentlike_style_section',
            [
                'label' => __( 'Caption', 'ht-instagram' ),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

            $this->add_group_control(
                Group_Control_Background::get_type(),
                [
                    'name' => 'instagram_commentlike_background',
                    'label' => __( 'Background', 'ht-instagram' ),
                    'types' => [ 'classic', 'gradient' ],
                    'selector' => '{{WRAPPER}} .instagram-like-comment',
                ]
            );

            $this->add_responsive_control(
                'instagram_commentlike_padding',
                [
                    'label' => __( 'Padding', 'ht-instagram' ),
                    'type' => Controls_Manager::DIMENSIONS,
                    'size_units' => [ 'px', '%', 'em' ],
                    'selectors' => [
                        '{{WRAPPER}} .instagram-like-comment' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    ],
                ]
            );

            $this->add_group_control(
                Group_Control_Border::get_type(),
                [
                    'name' => 'instagram_commentlike_border',
                    'label' => __( 'Border', 'ht-instagram' ),
                    'selector' => '{{WRAPPER}} .instagram-like-comment',
                ]
            );

            $this->add_responsive_control(
                'instagram_commentlike_border_radius',
                [
                    'label' => esc_html__( 'Border Radius', 'ht-instagram' ),
                    'type' => Controls_Manager::DIMENSIONS,
                    'selectors' => [
                        '{{WRAPPER}} .instagram-like-comment' => 'border-radius: {{TOP}}px {{RIGHT}}px {{BOTTOM}}px {{LEFT}}px;',
                    ],
                ]
            );

            $this->add_control(
                'commentlike_size',
                [
                    'label' => __( 'Font Size', 'ht-instagram' ),
                    'type' => Controls_Manager::SLIDER,
                    'size_units' => [ 'px', '%' ],
                    'range' => [
                        'px' => [
                            'min' => 0,
                            'max' => 100,
                            'step' => 1,
                        ],
                        '%' => [
                            'min' => 0,
                            'max' => 100,
                        ],
                    ],
                    'default' => [
                        'unit' => 'px',
                        'size' => 16,
                    ],
                    'selectors' => [
                        '{{WRAPPER}} .instagram-like-comment p' => 'font-size: {{SIZE}}{{UNIT}};',
                    ],
                ]
            );

            $this->add_control(
                'instagram_commentlike_color',
                [
                    'label' => __( 'Color', 'ht-instagram' ),
                    'type' => Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} .instagram-like-comment p' => 'color: {{VALUE}};',
                    ],
                ]
            );
        
        $this->end_controls_section(); // Like Comment

        // Follow Button
        $this->start_controls_section(
            'htinstagram_follow_style_section',
            [
                'label' => __( 'Follow Button', 'ht-instagram' ),
                'tab' => Controls_Manager::TAB_STYLE,
                'condition' =>[
                    'show_follow_button' =>'yes',
                ]
            ]
        );

             $this->add_group_control(
                Group_Control_Typography::get_type(),
                [
                    'name' => 'htinstagram_follow_typography',
                    'scheme' => Scheme_Typography::TYPOGRAPHY_1,
                    'selector' => '{{WRAPPER}} a.instagram_follow_btn span',
                ]
            );

            $this->add_group_control(
                Group_Control_Background::get_type(),
                [
                    'name' => 'htinstagram_follow_background',
                    'label' => __( 'Background', 'ht-instagram' ),
                    'types' => [ 'classic', 'gradient' ],
                    'selector' => '{{WRAPPER}} a.instagram_follow_btn',
                ]
            );

            $this->add_responsive_control(
                'htinstagram_follow_padding',
                [
                    'label' => __( 'Padding', 'ht-instagram' ),
                    'type' => Controls_Manager::DIMENSIONS,
                    'size_units' => [ 'px', '%', 'em' ],
                    'selectors' => [
                        '{{WRAPPER}} a.instagram_follow_btn' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    ],
                ]
            );
            
            $this->add_group_control(
                Group_Control_Border::get_type(),
                [
                    'name' => 'htinstagram_follow_border',
                    'label' => __( 'Border', 'ht-instagram' ),
                    'selector' => '{{WRAPPER}} a.instagram_follow_btn',
                ]
            );

            $this->add_responsive_control(
                'htinstagram_follow_border_radius',
                [
                    'label' => esc_html__( 'Border Radius', 'ht-instagram' ),
                    'type' => Controls_Manager::DIMENSIONS,
                    'selectors' => [
                        '{{WRAPPER}} a.instagram_follow_btn' => 'border-radius: {{TOP}}px {{RIGHT}}px {{BOTTOM}}px {{LEFT}}px;',
                    ],
                ]
            );

            $this->add_control(
                'htinstagram_follow_icon_size',
                [
                    'label' => __( 'Icon Font Size', 'ht-instagram' ),
                    'type' => Controls_Manager::SLIDER,
                    'size_units' => [ 'px', '%' ],
                    'range' => [
                        'px' => [
                            'min' => 0,
                            'max' => 100,
                            'step' => 1,
                        ],
                        '%' => [
                            'min' => 0,
                            'max' => 100,
                        ],
                    ],
                    'default' => [
                        'unit' => 'px',
                        'size' => 16,
                    ],
                    'selectors' => [
                        '{{WRAPPER}} a.instagram_follow_btn i' => 'font-size: {{SIZE}}{{UNIT}};',
                    ],
                ]
            );

            $this->add_control(
                'htinstagram_follow_icon_color',
                [
                    'label' => __( 'Icon Color', 'ht-instagram' ),
                    'type' => Controls_Manager::COLOR,
                    'scheme' => [
                        'type' => Scheme_Color::get_type(),
                        'value' => Scheme_Color::COLOR_1,
                    ],
                    'default' => '#ffffff',
                    'selectors' => [
                        '{{WRAPPER}} a.instagram_follow_btn i' => 'color: {{VALUE}};',
                    ],
                ]
            );

            $this->add_group_control(
                Group_Control_Background::get_type(),
                [
                    'name' => 'htinstagram_follow_icon_background',
                    'label' => __( 'Background', 'ht-instagram' ),
                    'types' => [ 'classic', 'gradient' ],
                    'selector' => '{{WRAPPER}} a.instagram_follow_btn i',
                ]
            );
        
        $this->end_controls_section(); // Like Comment


        // Style instagram arrow style start
        $this->start_controls_section(
            'htmega_instagram_arrow_style',
            [
                'label'     => __( 'Arrow', 'ht-instagram' ),
                'tab'       => Controls_Manager::TAB_STYLE,
                'condition' =>[
                    'slider_on' => 'yes',
                    'slarrows'  => 'yes',
                ],
            ]
        );
            
            $this->start_controls_tabs( 'instagram_arrow_style_tabs' );

                // Normal tab Start
                $this->start_controls_tab(
                    'instagram_arrow_style_normal_tab',
                    [
                        'label' => __( 'Normal', 'ht-instagram' ),
                    ]
                );

                    $this->add_control(
                        'htmega_instagram_arrow_color',
                        [
                            'label' => __( 'Color', 'ht-instagram' ),
                            'type' => Controls_Manager::COLOR,
                            'scheme' => [
                                'type' => Scheme_Color::get_type(),
                                'value' => Scheme_Color::COLOR_1,
                            ],
                            'default' => '#ffffff',
                            'selectors' => [
                                '{{WRAPPER}} .htmega-instragram .slick-arrow' => 'color: {{VALUE}};',
                            ],
                        ]
                    );

                    $this->add_control(
                        'htmega_instagram_arrow_fontsize',
                        [
                            'label' => __( 'Font Size', 'ht-instagram' ),
                            'type' => Controls_Manager::SLIDER,
                            'size_units' => [ 'px', '%' ],
                            'range' => [
                                'px' => [
                                    'min' => 0,
                                    'max' => 100,
                                    'step' => 1,
                                ],
                                '%' => [
                                    'min' => 0,
                                    'max' => 100,
                                ],
                            ],
                            'default' => [
                                'unit' => 'px',
                                'size' => 20,
                            ],
                            'selectors' => [
                                '{{WRAPPER}} .htmega-instragram .slick-arrow' => 'font-size: {{SIZE}}{{UNIT}};',
                            ],
                        ]
                    );

                    $this->add_group_control(
                        Group_Control_Background::get_type(),
                        [
                            'name' => 'instagram_arrow_background',
                            'label' => __( 'Background', 'ht-instagram' ),
                            'types' => [ 'classic', 'gradient' ],
                            'selector' => '{{WRAPPER}} .htmega-instragram .slick-arrow',
                        ]
                    );

                    $this->add_group_control(
                        Group_Control_Border::get_type(),
                        [
                            'name' => 'htmega_instagram_arrow_border',
                            'label' => __( 'Border', 'ht-instagram' ),
                            'selector' => '{{WRAPPER}} .htmega-instragram .slick-arrow',
                        ]
                    );

                    $this->add_responsive_control(
                        'htmega_instagram_arrow_border_radius',
                        [
                            'label' => esc_html__( 'Border Radius', 'ht-instagram' ),
                            'type' => Controls_Manager::DIMENSIONS,
                            'selectors' => [
                                '{{WRAPPER}} .htmega-instragram .slick-arrow' => 'border-radius: {{TOP}}px {{RIGHT}}px {{BOTTOM}}px {{LEFT}}px;',
                            ],
                        ]
                    );

                    $this->add_control(
                        'htmega_instagram_arrow_height',
                        [
                            'label' => __( 'Height', 'ht-instagram' ),
                            'type' => Controls_Manager::SLIDER,
                            'size_units' => [ 'px', '%' ],
                            'range' => [
                                'px' => [
                                    'min' => 0,
                                    'max' => 1000,
                                    'step' => 1,
                                ],
                                '%' => [
                                    'min' => 0,
                                    'max' => 100,
                                ],
                            ],
                            'default' => [
                                'unit' => 'px',
                                'size' => 30,
                            ],
                            'selectors' => [
                                '{{WRAPPER}} .htmega-instragram .slick-arrow' => 'height: {{SIZE}}{{UNIT}};',
                            ],
                        ]
                    );

                    $this->add_control(
                        'htmega_instagram_arrow_width',
                        [
                            'label' => __( 'Width', 'ht-instagram' ),
                            'type' => Controls_Manager::SLIDER,
                            'size_units' => [ 'px', '%' ],
                            'range' => [
                                'px' => [
                                    'min' => 0,
                                    'max' => 1000,
                                    'step' => 1,
                                ],
                                '%' => [
                                    'min' => 0,
                                    'max' => 100,
                                ],
                            ],
                            'default' => [
                                'unit' => 'px',
                                'size' => 30,
                            ],
                            'selectors' => [
                                '{{WRAPPER}} .htmega-instragram .slick-arrow' => 'width: {{SIZE}}{{UNIT}};',
                            ],
                        ]
                    );

                    $this->add_responsive_control(
                        'htmega_instagram_arrow_padding',
                        [
                            'label' => __( 'Padding', 'ht-instagram' ),
                            'type' => Controls_Manager::DIMENSIONS,
                            'size_units' => [ 'px', '%', 'em' ],
                            'selectors' => [
                                '{{WRAPPER}} .htmega-instragram .slick-arrow' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                            ],
                            'separator' =>'before',
                        ]
                    );

                $this->end_controls_tab(); // Normal tab end

                // Hover tab Start
                $this->start_controls_tab(
                    'instagram_arrow_style_hover_tab',
                    [
                        'label' => __( 'Hover', 'ht-instagram' ),
                    ]
                );

                    $this->add_control(
                        'htmega_instagram_arrow_hover_color',
                        [
                            'label' => __( 'Color', 'ht-instagram' ),
                            'type' => Controls_Manager::COLOR,
                            'scheme' => [
                                'type' => Scheme_Color::get_type(),
                                'value' => Scheme_Color::COLOR_1,
                            ],
                            'default' => '#ffffff',
                            'selectors' => [
                                '{{WRAPPER}} .htmega-instragram .slick-arrow:hover' => 'color: {{VALUE}};',
                            ],
                        ]
                    );

                    $this->add_group_control(
                        Group_Control_Background::get_type(),
                        [
                            'name' => 'instagram_arrow_hover_background',
                            'label' => __( 'Background', 'ht-instagram' ),
                            'types' => [ 'classic', 'gradient' ],
                            'selector' => '{{WRAPPER}} .htmega-instragram .slick-arrow:hover',
                        ]
                    );

                    $this->add_group_control(
                        Group_Control_Border::get_type(),
                        [
                            'name' => 'htmega_instagram_arrow_hover_border',
                            'label' => __( 'Border', 'ht-instagram' ),
                            'selector' => '{{WRAPPER}} .htmega-instragram .slick-arrow:hover',
                        ]
                    );

                    $this->add_responsive_control(
                        'htmega_instagram_arrow_hover_border_radius',
                        [
                            'label' => esc_html__( 'Border Radius', 'ht-instagram' ),
                            'type' => Controls_Manager::DIMENSIONS,
                            'selectors' => [
                                '{{WRAPPER}} .htmega-instragram .slick-arrow:hover' => 'border-radius: {{TOP}}px {{RIGHT}}px {{BOTTOM}}px {{LEFT}}px;',
                            ],
                        ]
                    );

                $this->end_controls_tab(); // Hover tab end

            $this->end_controls_tabs();

        $this->end_controls_section(); // Style instagram arrow style end


        // Style instagram Dots style start
        $this->start_controls_section(
            'htmega_instagram_dots_style',
            [
                'label'     => __( 'Pagination', 'ht-instagram' ),
                'tab'       => Controls_Manager::TAB_STYLE,
                'condition' =>[
                    'slider_on' => 'yes',
                    'sldots'  => 'yes',
                ],
            ]
        );
            
            $this->start_controls_tabs( 'instagram_dots_style_tabs' );

                // Normal tab Start
                $this->start_controls_tab(
                    'instagram_dots_style_normal_tab',
                    [
                        'label' => __( 'Normal', 'ht-instagram' ),
                    ]
                );

                    $this->add_group_control(
                        Group_Control_Background::get_type(),
                        [
                            'name' => 'instagram_dots_background',
                            'label' => __( 'Background', 'ht-instagram' ),
                            'types' => [ 'classic', 'gradient' ],
                            'selector' => '{{WRAPPER}} .htmega-instragram .slick-dots li',
                        ]
                    );

                    $this->add_group_control(
                        Group_Control_Border::get_type(),
                        [
                            'name' => 'htmega_instagram_dots_border',
                            'label' => __( 'Border', 'ht-instagram' ),
                            'selector' => '{{WRAPPER}} .htmega-instragram .slick-dots li',
                        ]
                    );

                    $this->add_responsive_control(
                        'htmega_instagram_dots_border_radius',
                        [
                            'label' => esc_html__( 'Border Radius', 'ht-instagram' ),
                            'type' => Controls_Manager::DIMENSIONS,
                            'selectors' => [
                                '{{WRAPPER}} .htmega-instragram .slick-dots li' => 'border-radius: {{TOP}}px {{RIGHT}}px {{BOTTOM}}px {{LEFT}}px;',
                            ],
                        ]
                    );

                    $this->add_control(
                        'htmega_instagram_dots_height',
                        [
                            'label' => __( 'Height', 'ht-instagram' ),
                            'type' => Controls_Manager::SLIDER,
                            'size_units' => [ 'px', '%' ],
                            'range' => [
                                'px' => [
                                    'min' => 0,
                                    'max' => 1000,
                                    'step' => 1,
                                ],
                                '%' => [
                                    'min' => 0,
                                    'max' => 100,
                                ],
                            ],
                            'default' => [
                                'unit' => 'px',
                                'size' => 15,
                            ],
                            'selectors' => [
                                '{{WRAPPER}} .htmega-instragram .slick-dots li' => 'height: {{SIZE}}{{UNIT}};',
                            ],
                        ]
                    );

                    $this->add_control(
                        'htmega_instagram_dots_width',
                        [
                            'label' => __( 'Width', 'ht-instagram' ),
                            'type' => Controls_Manager::SLIDER,
                            'size_units' => [ 'px', '%' ],
                            'range' => [
                                'px' => [
                                    'min' => 0,
                                    'max' => 1000,
                                    'step' => 1,
                                ],
                                '%' => [
                                    'min' => 0,
                                    'max' => 100,
                                ],
                            ],
                            'default' => [
                                'unit' => 'px',
                                'size' => 15,
                            ],
                            'selectors' => [
                                '{{WRAPPER}} .htmega-instragram .slick-dots li' => 'width: {{SIZE}}{{UNIT}} !important;',
                            ],
                        ]
                    );

                $this->end_controls_tab(); // Normal tab end

                // Hover tab Start
                $this->start_controls_tab(
                    'instagram_dots_style_hover_tab',
                    [
                        'label' => __( 'Active', 'ht-instagram' ),
                    ]
                );

                    $this->add_group_control(
                        Group_Control_Background::get_type(),
                        [
                            'name' => 'instagram_dots_hover_background',
                            'label' => __( 'Background', 'ht-instagram' ),
                            'types' => [ 'classic', 'gradient' ],
                            'selector' => '{{WRAPPER}} .htmega-instragram .slick-dots li.slick-active',
                        ]
                    );

                    $this->add_group_control(
                        Group_Control_Border::get_type(),
                        [
                            'name' => 'htmega_instagram_dots_hover_border',
                            'label' => __( 'Border', 'ht-instagram' ),
                            'selector' => '{{WRAPPER}} .htmega-instragram .slick-dots li.slick-active',
                        ]
                    );

                    $this->add_responsive_control(
                        'htmega_instagram_dots_hover_border_radius',
                        [
                            'label' => esc_html__( 'Border Radius', 'ht-instagram' ),
                            'type' => Controls_Manager::DIMENSIONS,
                            'selectors' => [
                                '{{WRAPPER}} .htmega-instragram .slick-dots li.slick-active' => 'border-radius: {{TOP}}px {{RIGHT}}px {{BOTTOM}}px {{LEFT}}px;',
                            ],
                        ]
                    );

                $this->end_controls_tab(); // Hover tab end

            $this->end_controls_tabs();

        $this->end_controls_section(); // Style instagram dots style end

    }

    protected function render( $instance = [] ) {
        $settings   = $this->get_settings_for_display();
        $id         = $this->get_id();

        $this->add_render_attribute( 'htinsta_instragram', 'class', 'htinsta-instragram' );
        $this->add_render_attribute( 'htinsta_instragram', 'class', 'htinsta-style-'.$settings['instagram_style'] );
        $this->add_render_attribute( 'htinsta_instragram', 'class', 'htinsta-column-'.$settings['instagram_column'] );
        $this->add_render_attribute( 'htinsta_instragram', 'class', 'htinsta-comment-'.$settings['commentlike_pos'] );
        $this->add_render_attribute( 'instagram_attr', 'class', 'ht-instagram-instagram-list' );

        $limit  = !empty( $settings['limit'] ) ? $settings['limit'] : 8;

        // Instagram Attribute
        if( $settings['slider_on'] != 'yes' ){
            $this->add_render_attribute( 'instagram_attr', 'style', 'margin:0 -'.$settings['gutter_space']['size'].'px;' );
        }
        if( $settings['slider_on'] == 'yes' ){

            $this->add_render_attribute( 'instagram_attr', 'class', 'htinstagram-carousel' );
            $slider_settings = [
                'arrows' => ('yes' === $settings['slarrows']),
                'arrow_prev_txt' => HTInstagram_Icon_manager::render_icon( $settings['slprevicon'], [ 'aria-hidden' => 'true' ] ),
                'arrow_next_txt' => HTInstagram_Icon_manager::render_icon( $settings['slnexticon'], [ 'aria-hidden' => 'true' ] ),
                'dots' => ('yes' === $settings['sldots']),
                'autoplay' => ('yes' === $settings['slautolay']),
                'autoplay_speed' => absint($settings['slautoplay_speed']),
                'animation_speed' => absint($settings['slanimation_speed']),
                'center_mode' => ( 'yes' === $settings['slcentermode']),
                'center_padding' => absint($settings['slcenterpadding']),
            ];

            $slider_responsive_settings = [
                'rows' => $settings['slrows'],
                'display_columns' => $settings['slitems'],
                'scroll_columns' => $settings['slscroll_columns'],
                'tablet_width' => $settings['sltablet_width'],
                'tablet_display_columns' => $settings['sltablet_display_columns'],
                'tablet_scroll_columns' => $settings['sltablet_scroll_columns'],
                'mobile_width' => $settings['slmobile_width'],
                'mobile_display_columns' => $settings['slmobile_display_columns'],
                'mobile_scroll_columns' => $settings['slmobile_scroll_columns'],
            ];

            $slider_settings = array_merge( $slider_settings, $slider_responsive_settings );
            $this->add_render_attribute( 'instagram_attr', 'data-settings', wp_json_encode( $slider_settings ) );
        }

        $instaitem = \HTinstagram_feed::instance()->htinstagram_items_feed( $settings, $id );

        if ( empty( $instaitem ) ){
            return;
        }
        
        $username      = !empty( $instaitem[0]['username'] ) ? $instaitem[0]['username'] : '';
        $profile_link  = !empty( $instaitem[0]['username'] ) ? 'https://www.instagram.com/'.$instaitem[0]['username'] : '#';

    ?>
            <div <?php echo $this->get_render_attribute_string('htinsta_instragram'); ?> >

                <?php
                    if ( isset( $instaitem ) && !empty($instaitem)):
                        if( $settings['show_follow_button'] == 'yes' && $settings['followbtn_pos'] == 'top' ): ?>
                            <a class="instagram_follow_btn <?php echo esc_attr( $settings['followbtn_pos'] );?>" href="<?php echo esc_url( $profile_link ); ?>" target="_blank">
                                <?php echo HTInstagram_Icon_manager::render_icon( $settings['flow_button_icon'], [ 'aria-hidden' => 'true' ] ); ?>
                                <span><?php echo esc_html__( 'Follow @ '.$username, 'ht-instagram' );?></span>
                            </a>
                        <?php endif; ?>

                <ul <?php echo $this->get_render_attribute_string('instagram_attr'); ?> >
                    <?php
                        $countitem = 0;
                        foreach ( $instaitem as $item ):
                            $countitem++;
                            if( $settings['show_light_box'] == 'yes' ){
                                $items_link = $item['src'];
                            }else{
                                $items_link = $item['link'];
                            }
                    ?>
                        <li style="<?php echo 'padding: 0 '.$settings['gutter_space']['size'].'px; margin-bottom: '.( $settings['gutter_space']['size']*2 ).'px;';?>">
                            <div class="htinstagram_single_item">
                                <a href="<?php echo esc_url( $items_link ); ?>">
                                    <img src="<?php echo esc_url( $item['src'] ); ?>" alt="<?php echo esc_html__( $item['username'], 'ht-instagram');?>">
                                </a>
                                <?php if( $settings['show_caption'] == 'yes' || $settings['show_light_box'] == 'yes' ): ?>
                                    <div class="instagram-clip">
                                        <div class="htinstagram-content">
                                             <?php if( $settings['show_caption'] == 'yes' && !empty( $item['caption'] ) ): ?>
                                                <div class="instagram-like-comment">
                                                    <p><?php echo esc_html( $item['caption'] ); ?></p>
                                                </div>
                                            <?php endif; if( $settings['show_light_box'] == 'yes' ): ?>
                                                <div class="instagram-btn">
                                                    <a class="image-popup-vertical-fit" href="<?php echo esc_url( $item['src'] ); ?>">
                                                        <?php
                                                            if( !empty( $settings['zoom_image'] ) && $settings['zoomicon_type'] == 'img' ){
                                                                echo Group_Control_Image_Size::get_attachment_image_html( $settings, 'zoom_imagesize', 'zoom_image' );
                                                            }else{
                                                                echo sprintf('<span class="zoom_icon">%1$s</span>', HTInstagram_Icon_manager::render_icon( $settings['zoom_icon'], [ 'aria-hidden' => 'true' ] ) );
                                                            }
                                                        ?>
                                                    </a>
                                                </div>
                                            <?php endif;?>
                                        </div>
                                    </div>
                                <?php endif;?>
                            </div>
                        </li>

                    <?php if( $countitem == $limit ){ break; } endforeach; echo '</ul>'; if( $settings['show_follow_button'] == 'yes' && ( $settings['followbtn_pos'] == 'bottom' || $settings['followbtn_pos'] == 'middle' ) ): 

                        $btn_prefix_txt = !empty( $settings['flow_button_txt'] ) ? $settings['flow_button_txt'] : '';
                    ?>
                        <a class="instagram_follow_btn <?php echo esc_attr( $settings['followbtn_pos'] );?>" href="<?php echo esc_url( $profile_link ); ?>" target="_blank">
                            <?php echo HTInstagram_Icon_manager::render_icon( $settings['flow_button_icon'], [ 'aria-hidden' => 'true' ] ); ?>
                            <span><?php echo esc_html__( $btn_prefix_txt.' '.$username, 'ht-instagram' );?></span>
                        </a>
                    <?php endif;?>

                    <?php else:?>
                        <p class="htinsta-error">
                            <?php 
                                esc_html_e( 'Instagram feed not found please enter valid access token.','ht-instagram' );
                                echo wp_kses_post( '(<a href="'.esc_url( admin_url().'admin.php?page=htinstagram' ).'" target="_blank">Enter Access Token</a>)', 'ht-instagram' );
                            ?>
                        </p>
                    <?php endif; ?>

            </div>

        <?php
    }
}

Plugin::instance()->widgets_manager->register_widget_type( new HTinstragram_Elementor_Widget_Instagram() );