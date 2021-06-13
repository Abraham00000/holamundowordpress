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

class NNfy_Blog_Element extends Widget_Base {

    public function get_name() {
        return 'nnfy-blog';
    }

    public function get_title() {
        return __( '99FY: Blog', '99fy' );
    }

    public function get_icon() {
        return 'eicon-post-content';
    }

    public function get_categories() {
        return ['99fy'];
    }

    protected function _register_controls() {

        $this->start_controls_section(
            'post_option',
            [
                'label' => __( 'Post Option', '99fy' ),
            ]
        );
            
            $this->add_control(
                'post_column',
                [
                    'label' => __( 'Column', '99fy' ),
                    'type' => Controls_Manager::SELECT,
                    'default' => '3',
                    'options' => [
                        '1'   => __( 'One', '99fy' ),
                        '2'   => __( 'Two', '99fy' ),
                        '3'   => __( 'Three', '99fy' ),
                        '4'   => __( 'Four', '99fy' ),
                    ],
                ]
            );

            $this->add_control(
                'post_categories',
                [
                    'label' => esc_html__( 'Categories', '99fy' ),
                    'type' => Controls_Manager::SELECT2,
                    'label_block' => true,
                    'multiple' => true,
                    'options' => nnfy_get_taxonomies(),
                ]
            );

            $this->add_control(
                'post_limit',
                [
                    'label' => __('Limit', '99fy'),
                    'type' => Controls_Manager::NUMBER,
                    'default' => 5,
                    'separator'=>'before',
                ]
            );

            $this->add_control(
                'custom_order',
                [
                    'label' => esc_html__( 'Custom order', '99fy' ),
                    'type' => Controls_Manager::SWITCHER,
                    'return_value' => 'yes',
                    'default' => 'no',
                ]
            );

            $this->add_control(
                'postorder',
                [
                    'label' => esc_html__( 'Order', '99fy' ),
                    'type' => Controls_Manager::SELECT,
                    'default' => 'DESC',
                    'options' => [
                        'DESC'  => esc_html__('Descending','99fy'),
                        'ASC'   => esc_html__('Ascending','99fy'),
                    ],
                    'condition' => [
                        'custom_order!' => 'yes',
                    ]
                ]
            );

            $this->add_control(
                'orderby',
                [
                    'label' => esc_html__( 'Orderby', '99fy' ),
                    'type' => Controls_Manager::SELECT,
                    'default' => 'none',
                    'options' => [
                        'none'          => esc_html__('None','99fy'),
                        'ID'            => esc_html__('ID','99fy'),
                        'date'          => esc_html__('Date','99fy'),
                        'name'          => esc_html__('Name','99fy'),
                        'title'         => esc_html__('Title','99fy'),
                        'comment_count' => esc_html__('Comment count','99fy'),
                        'rand'          => esc_html__('Random','99fy'),
                    ],
                    'condition' => [
                        'custom_order' => 'yes',
                    ]
                ]
            );

            $this->add_control(
                'show_date',
                [
                    'label' => esc_html__( 'Date', '99fy' ),
                    'type' => Controls_Manager::SWITCHER,
                    'return_value' => 'yes',
                    'default' => 'yes',
                ]
            );

            $this->add_control(
                'show_author',
                [
                    'label' => esc_html__( 'Author', '99fy' ),
                    'type' => Controls_Manager::SWITCHER,
                    'return_value' => 'yes',
                    'default' => 'yes',
                ]
            );

             $this->add_control(
                'show_title',
                [
                    'label' => esc_html__( 'Title', '99fy' ),
                    'type' => Controls_Manager::SWITCHER,
                    'return_value' => 'yes',
                    'default' => 'yes',
                ]
            );

            $this->add_control(
                'title_length',
                [
                    'label' => __( 'Title Length', '99fy' ),
                    'type' => Controls_Manager::NUMBER,
                    'step' => 1,
                    'default' => 5,
                    'condition'=>[
                        'show_title'=>'yes',
                    ]
                ]
            );

            $this->add_control(
                'show_content',
                [
                    'label' => esc_html__( 'Content', '99fy' ),
                    'type' => Controls_Manager::SWITCHER,
                    'return_value' => 'yes',
                    'default' => 'yes',
                ]
            );

            $this->add_control(
                'content_length',
                [
                    'label' => __( 'Content Length', '99fy' ),
                    'type' => Controls_Manager::NUMBER,
                    'step' => 1,
                    'default' => 20,
                    'condition'=>[
                        'show_content'=>'yes',
                    ]
                ]
            );

        $this->end_controls_section();

        // Style tab section
        $this->start_controls_section(
            'blog_style_section',
            [
                'label' => esc_html__( 'Style', '99fy' ),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );
            
            $this->add_control(
                'heading_image_style',
                [
                    'label' => __( 'Thumbnails', '99fy' ),
                    'type' => Controls_Manager::HEADING,
                    'separator' => 'after',
                ]
            );

            $this->add_group_control(
                Group_Control_Border::get_type(),
                [
                    'name' => 'blog_thumbnail_border',
                    'label' => __( 'Border', '99fy' ),
                    'selector' => '{{WRAPPER}} .blog-img',
                ]
            );

            $this->add_responsive_control(
                'blog_thumbnail_margin',
                [
                    'label' => __( 'Margin', '99fy' ),
                    'type' => Controls_Manager::DIMENSIONS,
                    'size_units' => [ 'px', '%', 'em' ],
                    'selectors' => [
                        '{{WRAPPER}} .blog-img' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    ],
                ]
            );

            $this->add_responsive_control(
                'blog_thumbnail_padding',
                [
                    'label' => __( 'Padding', '99fy' ),
                    'type' => Controls_Manager::DIMENSIONS,
                    'size_units' => [ 'px', '%', 'em' ],
                    'selectors' => [
                        '{{WRAPPER}} .blog-img' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    ],
                ]
            );

            $this->add_control(
                'heading_title_style',
                [
                    'label' => __( 'Title', '99fy' ),
                    'type' => Controls_Manager::HEADING,
                    'separator' => 'after',
                ]
            );

            $this->add_control(
                'title_color',
                [
                    'label' => __( 'Title Color', '99fy' ),
                    'type' => Controls_Manager::COLOR,
                    'scheme' => [
                        'type' => Scheme_Color::get_type(),
                        'value' => Scheme_Color::COLOR_1,
                    ],
                    'default'=>'#444444',
                    'selectors' => [
                        '{{WRAPPER}} .blog-info a' => 'color: {{VALUE}}',
                    ],
                ]
            );

            $this->add_control(
                'title_hover_color',
                [
                    'label' => __( 'Title Hover Color', '99fy' ),
                    'type' => Controls_Manager::COLOR,
                    'scheme' => [
                        'type' => Scheme_Color::get_type(),
                        'value' => Scheme_Color::COLOR_1,
                    ],
                    'default'=>'#444444',
                    'selectors' => [
                        '{{WRAPPER}} .blog-info a:hover' => 'color: {{VALUE}}',
                    ],
                ]
            );

            $this->add_group_control(
                Group_Control_Typography::get_type(),
                [
                    'name' => 'title_typography',
                    'label' => __( 'Title Typography', '99fy' ),
                    'scheme' => Scheme_Typography::TYPOGRAPHY_4,
                    'selector' => '{{WRAPPER}} .blog-info > h4',
                ]
            );

            $this->add_responsive_control(
                'blog_title_margin',
                [
                    'label' => __( 'Margin', '99fy' ),
                    'type' => Controls_Manager::DIMENSIONS,
                    'size_units' => [ 'px', '%', 'em' ],
                    'selectors' => [
                        '{{WRAPPER}} .blog-info > h4' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    ],
                ]
            );

            $this->add_control(
                'heading_content_style',
                [
                    'label' => __( 'Content', '99fy' ),
                    'type' => Controls_Manager::HEADING,
                    'separator' => 'after',
                ]
            );

            $this->add_control(
                'content_color',
                [
                    'label' => __( 'Content Color', '99fy' ),
                    'type' => Controls_Manager::COLOR,
                    'scheme' => [
                        'type' => Scheme_Color::get_type(),
                        'value' => Scheme_Color::COLOR_1,
                    ],
                    'default'=>'#878787',
                    'selectors' => [
                        '{{WRAPPER}} .blog-info > p' => 'color: {{VALUE}}',
                    ],
                ]
            );

            $this->add_group_control(
                Group_Control_Typography::get_type(),
                [
                    'name' => 'content_typography',
                    'label' => __( 'Content Typography', '99fy' ),
                    'scheme' => Scheme_Typography::TYPOGRAPHY_4,
                    'selector' => '{{WRAPPER}} .blog-info > p',
                ]
            );

            $this->add_responsive_control(
                'blog_content_margin',
                [
                    'label' => __( 'Margin', '99fy' ),
                    'type' => Controls_Manager::DIMENSIONS,
                    'size_units' => [ 'px', '%', 'em' ],
                    'selectors' => [
                        '{{WRAPPER}} .blog-info > p' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    ],
                ]
            );

            $this->add_control(
                'heading_blog_meta_style',
                [
                    'label' => __( 'Meta', '99fy' ),
                    'type' => Controls_Manager::HEADING,
                    'separator' => 'after',
                ]
            );

            $this->add_control(
                'blog_meta_link_color',
                [
                    'label' => __( 'Post Meta Info Link Color', '99fy' ),
                    'type' => Controls_Manager::COLOR,
                    'scheme' => [
                        'type' => Scheme_Color::get_type(),
                        'value' => Scheme_Color::COLOR_1,
                    ],
                    'default'=>'#444444',
                    'selectors' => [
                        '{{WRAPPER}} .blog-info h6 a' => 'color: {{VALUE}}',
                    ],
                ]
            );

            $this->add_control(
                'blog_meta_label_color',
                [
                    'label' => __( 'Post Meta Info Label Color', '99fy' ),
                    'type' => Controls_Manager::COLOR,
                    'scheme' => [
                        'type' => Scheme_Color::get_type(),
                        'value' => Scheme_Color::COLOR_1,
                    ],
                    'default'=>'#878787',
                    'selectors' => [
                        '{{WRAPPER}} .blog-info h6' => 'color: {{VALUE}}',
                        '{{WRAPPER}} .blog-info span' => 'color: {{VALUE}}',
                    ],
                ]
            );

            $this->add_group_control(
                Group_Control_Typography::get_type(),
                [
                    'name' => 'meta_typography',
                    'label' => __( 'Meta Typography', '99fy' ),
                    'scheme' => Scheme_Typography::TYPOGRAPHY_4,
                    'selector' => '{{WRAPPER}} .blog-info > h6,{{WRAPPER}} .blog-info span',
                ]
            );

            $this->add_responsive_control(
                'blog_meta_margin',
                [
                    'label' => __( 'Margin', '99fy' ),
                    'type' => Controls_Manager::DIMENSIONS,
                    'size_units' => [ 'px', '%', 'em' ],
                    'selectors' => [
                        '{{WRAPPER}} .blog-info h6' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    ],
                ]
            );


        $this->end_controls_section(); // Style tab end



    }

    protected function render( $instance = [] ) {

        $settings   = $this->get_settings_for_display();

        $custom_order_ck    = $this->get_settings_for_display('custom_order');
        $orderby            = $this->get_settings_for_display('orderby');
        $postorder          = $this->get_settings_for_display('postorder');

        // Query
        $args = array(
            'post_type'             => 'post',
            'post_status'           => 'publish',
            'ignore_sticky_posts'   => 1,
            'posts_per_page'        => !empty( $settings['post_limit'] ) ? $settings['post_limit'] : 3,
            'order'                 => $postorder
        );

        // Custom Order
        if( $custom_order_ck == 'yes' ){
            $args['orderby']    = $orderby;
        }

        $get_categories = $settings['post_categories'];
        $post_cats = str_replace(' ', '', $get_categories);

        if (  !empty( $get_categories ) ) {
            if( is_array($post_cats) && count($post_cats) > 0 ){
                $field_name = is_numeric( $post_cats[0] ) ? 'term_id' : 'slug';
                $args['tax_query'] = array(
                    array(
                        'taxonomy' => 'category',
                        'terms' => $post_cats,
                        'field' => $field_name,
                        'include_children' => false
                    )
                );
            }
        }

        $post = new \WP_Query( $args );

        $this->add_render_attribute( 'post_area_attr', 'class', 'sc_blog' );


        ?>
            <div <?php echo $this->get_render_attribute_string( 'post_area_attr' ); ?> >
                <?php if( $post->have_posts() ): ?>
                    <div class="ht-row">
                        <?php while( $post->have_posts() ): $post->the_post(); ?>
                            <div class="ht-col-lg-<?php echo esc_attr( round( 12/$settings['post_column'] ) ); ?> ht-col-md-6 ht-col-sm-6 ht-col-xs-12">
                                <div class="product-wrapper mb-30">
                                    <?php if(has_post_thumbnail()): ?>
                                    <div class="blog-img">
                                        <a href="<?php the_permalink(); ?>">
                                            <?php
                                                $post_thumbnail_id = get_post_thumbnail_id( get_the_id() );
                                                echo wp_get_attachment_image( $post_thumbnail_id, 'nnfy_blog_grid_thumb' );
                                            ?>
                                        </a>
                                    </div>
                                    <?php endif; ?>
                                    <div class="blog-info">
                                        <?php
                                            $author_url = get_author_posts_url( get_the_author_meta('ID') );
                                        ?>
                                        <h4><a href="<?php the_permalink(); ?>"> <?php echo wp_trim_words( get_the_title(), $settings['title_length'], '' ); ?> </a></h4>
                                        <h6><?php if( $settings['show_author'] == 'yes' ): ?><?php echo esc_html__( 'By', 'nnfy' ); ?> <a href="<?php echo esc_url( $author_url ); ?>"><?php the_author_meta('nickname') ?><?php endif; ?></a> <?php if( $settings['show_date'] == 'yes' ): ?><?php echo esc_html__( 'on', 'nnfy' ); ?> <span><?php echo get_the_date( 'M d, Y' ); ?></span><?php endif; ?></h6>
                                        <p><?php echo wp_trim_words( get_the_content(), $settings['content_length'], '' ); ?></p>
                                    </div>
                                </div>
                            </div>
                        <?php endwhile; wp_reset_postdata(); ?>
                    </div>
                <?php endif; //endif have posts ?>
            </div>

        <?php

    }

}