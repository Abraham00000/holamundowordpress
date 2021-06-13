<?php
namespace NNfy\Elementor\Widget;

// Elementor Classes
use Elementor\Plugin as Elementor;
use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Core\Schemes\Color as Scheme_Color;
use Elementor\Core\Schemes\Typography as Scheme_Typography;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class NNfy_Teammember_Element extends Widget_Base {

    public function get_name() {
        return 'nnfy-teammember';
    }

    public function get_title() {
        return __( '99FY: Team Member', '99fy' );
    }

    public function get_icon() {
        return 'eicon-user-circle-o';
    }

    public function get_categories() {
        return ['99fy'];
    }

    protected function _register_controls() {

        $this->start_controls_section(
            'teammember_content',
            [
                'label' => __( 'Team Member', '99fy' ),
            ]
        );
            
            $this->add_control(
                'teammemberimage',
                [
                    'label' => __( 'Team Member image', '99fy' ),
                    'type' => Controls_Manager::MEDIA,
                    'default' => [
                        'url' => \Elementor\Utils::get_placeholder_image_src(),
                    ],
                ]
            );

            $this->add_group_control(
                \Elementor\Group_Control_Image_Size::get_type(),
                [
                    'name' => 'teammemberimagesize',
                    'default' => 'large',
                    'separator' => 'none',
                ]
            );

            $this->add_control(
                'teammember_name',
                [
                    'label' => __( 'Name', '99fy' ),
                    'type' => Controls_Manager::TEXT,
                ]
            );

        $this->end_controls_section();

        // Social Profile Link
        $this->start_controls_section(
            'social_profile_link',
            [
                'label' => __( 'Socail Profile Link', '99fy' ),
            ]
        );
            
            $repeater = new \Elementor\Repeater();

            $repeater->add_control(
                'social_icon', [
                    'label' => __( 'Title', '99fy' ),
                    'type' => \Elementor\Controls_Manager::ICONS,
                    'default' => [
                        'value' => 'fab fa-facebbok',
                        'library' => 'solid',
                    ],
                    'label_block' => true,
                ]
            );

            $repeater->add_control(
                'social_profile_link',
                [
                    'label' => __( 'Profile Link', '99fy' ),
                    'type' => \Elementor\Controls_Manager::URL,
                    'placeholder' => __( 'https://your-link.com', '99fy' ),
                    'show_external' => true,
                    'default' => [
                        'url' => '',
                        'is_external' => true,
                        'nofollow' => true,
                    ],
                ]
            );

            $this->add_control(
                'social_profile_list',
                [
                    'label' => __( 'Social Profile Link', '99fy' ),
                    'type' => \Elementor\Controls_Manager::REPEATER,
                    'fields' => $repeater->get_controls(),
                    'default' => [
                        [
                            'social_profile_link' => __( '#', '99fy' ),
                        ],
                        [
                            'social_profile_link' => __( '#', '99fy' ),
                        ],
                    ],
                    'title_field' => '{{{ social_icon.value }}}',
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
                'name_style_heading',
                [
                    'label' => __( 'Name', '99fy' ),
                    'type' => Controls_Manager::HEADING,
                ]
            );

            $this->add_control(
                'name_color',
                [
                    'label' => __( 'Color', '99fy' ),
                    'type' => Controls_Manager::COLOR,
                    'scheme' => [
                        'type' => Scheme_Color::get_type(),
                        'value' => Scheme_Color::COLOR_1,
                    ],
                    'default'=>'#fff',
                    'selectors' => [
                        '{{WRAPPER}} .team-title > h4' => 'color: {{VALUE}};',
                    ],
                ]
            );

            $this->add_group_control(
                \Elementor\Group_Control_Typography::get_type(),
                [
                    'name' => 'name_typography',
                    'label' => __( 'Typography', '99fy' ),
                    'scheme' => Scheme_Typography::TYPOGRAPHY_4,
                    'selector' => '{{WRAPPER}} .team-title > h4',
                ]
            );

            $this->add_control(
                'social_link_style_heading',
                [
                    'label' => __( 'Social Icon', '99fy' ),
                    'type' => Controls_Manager::HEADING,
                    'separator'=>'before',
                ]
            );

            $this->add_control(
                'socil_icon_color',
                [
                    'label' => __( 'Social Icon Color', '99fy' ),
                    'type' => Controls_Manager::COLOR,
                    'scheme' => [
                        'type' => Scheme_Color::get_type(),
                        'value' => Scheme_Color::COLOR_1,
                    ],
                    'default'=>'#fff',
                    'selectors' => [
                        '{{WRAPPER}} .team-icon > a' => 'color: {{VALUE}};',
                    ],
                ]
            );

            $this->add_control(
                'social_icon_hover_color',
                [
                    'label' => __( 'Social Icon Hover Color', '99fy' ),
                    'type' => Controls_Manager::COLOR,
                    'scheme' => [
                        'type' => Scheme_Color::get_type(),
                        'value' => Scheme_Color::COLOR_1,
                    ],
                    'default'=>'#96bf48',
                    'selectors' => [
                        '{{WRAPPER}} .team-icon > a:hover' => 'color: {{VALUE}};',
                    ],
                ]
            );

        $this->end_controls_section(); // Style tab end



    }

    protected function render( $instance = [] ) {

        $settings   = $this->get_settings_for_display();

        $this->add_render_attribute( 'team_area_attr', 'class', 'sc_team' );
        ?>
            
            <div <?php echo $this->get_render_attribute_string( 'team_area_attr' ); ?> >
               <div class="team-wrapper mb-30">
                   <div class="team-member">
                       <?php echo \Elementor\Group_Control_Image_Size::get_attachment_image_html( $settings, 'teammemberimagesize', 'teammemberimage' ); ?>
                        <div class="team-imfo">
                            <?php
                                if( !empty($settings['teammember_name']) ){
                                    echo '<div class="team-title"><h4>'.esc_html( $settings['teammember_name'] ).'</h4></div>';
                                }
                            ?>
                            <?php if( $settings['social_profile_list'] ): ?>
                                <div class="team-icon">
                                    <?php 
                                        foreach ( $settings['social_profile_list'] as $item ):
                                            // Profile Link
                                            $target = $item['social_profile_link']['is_external'] ? ' target="_blank"' : '';
                                            $nofollow = $item['social_profile_link']['nofollow'] ? ' rel="nofollow"' : '';
                                            $url = $item['social_profile_link']['url'] ? $item['social_profile_link']['url'] : '#';
                                    ?>
                                        <a href="<?php echo esc_url( $url ); ?>" <?php echo $target.$nofollow; ?> >
                                            <?php 
                                                \Elementor\Icons_Manager::render_icon( $item['social_icon'], [ 'aria-hidden' => 'true' ] );
                                            ?>
                                        </a>
                                    <?php endforeach; ?>
                                </div>
                            <?php endif; ?>
                       </div>

                   </div>
               </div>
            </div><!-- /.sc_team -->

        <?php

    }

}