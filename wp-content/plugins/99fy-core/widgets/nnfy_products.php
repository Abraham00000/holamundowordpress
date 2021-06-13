<?php

namespace NNfy\Elementor\Widget;
use Elementor\Plugin as Elementor;
use Elementor\Widget_Base;
use Elementor\Controls_Manager;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class NNfy_Products_Element extends Widget_Base {

    public function get_name() {
        return 'nnfy-products';
    }

    public function get_title() {
        return __( '99FY: Products', '99fy' );
    }

    public function get_icon() {
        return 'eicon-products';
    }

    public function get_categories() {
        return ['99fy'];
    }

    protected function _register_controls() {

        // Product Content
        $this->start_controls_section(
            'nnfy-products-layout-setting',
            [
                'label' => esc_html__( 'Layout Settings', '99fy' ),
            ]
        );

            $this->add_control(
                'nnfy_product_grid_column',
                [
                    'label' => esc_html__( 'Columns', '99fy' ),
                    'type' => Controls_Manager::SELECT,
                    'default' => '4',
                    'options' => [
                        '1' => esc_html__( '1', '99fy' ),
                        '2' => esc_html__( '2', '99fy' ),
                        '3' => esc_html__( '3', '99fy' ),
                        '4' => esc_html__( '4', '99fy' ),
                        '5' => esc_html__( '5', '99fy' ),
                        '6' => esc_html__( '6', '99fy' ),
                    ]

                ]
            );

        $this->end_controls_section();

        $this->start_controls_section(
            'nnfy-products',
            [
                'label' => esc_html__( 'Query Settings', '99fy' ),
            ]
        );

            $this->add_control(
                'nnfy_product_grid_product_filter',
                [
                    'label' => esc_html__( 'Filter By', '99fy' ),
                    'type' => Controls_Manager::SELECT,
                    'default' => 'recent',
                    'options' => [
                        'recent' => esc_html__( 'Recent Products', '99fy' ),
                        'featured' => esc_html__( 'Featured Products', '99fy' ),
                        'best_selling' => esc_html__( 'Best Selling Products', '99fy' ),
                        'sale' => esc_html__( 'Sale Products', '99fy' ),
                        'top_rated' => esc_html__( 'Top Rated Products', '99fy' ),
                        'mixed_order' => esc_html__( 'Random Products', '99fy' ),
                        'show_byid' => esc_html__( 'Show By Id', '99fy' ),
                    ],
                ]
            );

            $this->add_control(
                'nnfy_product_id',
                [
                    'label' => __( 'Select Product', 'hastech' ),
                    'type' => Controls_Manager::SELECT2,
                    'label_block' => true,
                    'multiple' => true,
                    'options' => nnfy_post_name( 'product' ),
                    'condition' => [
                        'nnfy_product_grid_product_filter' => 'show_byid',
                    ]
                ]
            );

            $this->add_control(
              'nnfy_product_grid_products_count',
                [
                    'label'   => __( 'Product Limit', '99fy' ),
                    'type'    => Controls_Manager::NUMBER,
                    'default' => 4,
                    'step'    => 1,
                ]
            );

            $this->add_control(
                'nnfy_product_grid_categories',
                [
                    'label' => esc_html__( 'Product Categories', '99fy' ),
                    'type' => Controls_Manager::SELECT2,
                    'label_block' => true,
                    'multiple' => true,
                    'options' => nnfy_get_taxonomies( 'product_cat' ),
                    'condition' => [
                        'nnfy_product_grid_product_filter!' => 'show_byid',
                    ]
                ]
            );

            $this->add_control(
                'nnfy_custom_order',
                [
                    'label' => esc_html__( 'Custom order', '99fy' ),
                    'type' => Controls_Manager::SWITCHER,
                    'return_value' => 'yes',
                    'default' => 'no',
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
                        'nnfy_custom_order' => 'yes',
                    ]
                ]
            );

            $this->add_control(
                'order',
                [
                    'label' => esc_html__( 'order', '99fy' ),
                    'type' => Controls_Manager::SELECT,
                    'default' => 'DESC',
                    'options' => [
                        'DESC'  => esc_html__('Descending','99fy'),
                        'ASC'   => esc_html__('Ascending','99fy'),
                    ],
                    'condition' => [
                        'nnfy_custom_order' => 'yes',
                    ]
                ]
            );

        $this->end_controls_section();


    }

    protected function render( $instance = [] ) {

        $settings           = $this->get_settings_for_display();
        $product_type       = $this->get_settings_for_display('nnfy_product_grid_product_filter');
        $per_page           = $this->get_settings_for_display('nnfy_product_grid_products_count');
        $custom_order_ck    = $this->get_settings_for_display('nnfy_custom_order');
        $orderby            = $this->get_settings_for_display('orderby');
        $order              = $this->get_settings_for_display('order');
        $tabuniqid          = $this->get_id();
        $columns            = $this->get_settings_for_display('nnfy_product_grid_column');

        // Query Argument
        $args = array(
            'post_type'             => 'product',
            'post_status'           => 'publish',
            'ignore_sticky_posts'   => 1,
            'posts_per_page'        => $per_page,
        );

        switch( $product_type ){

            case 'sale':
                $args['post__in'] = array_merge( array( 0 ), wc_get_product_ids_on_sale() );
            break;

            case 'featured':
                $args['tax_query'][] = array(
                    'taxonomy' => 'product_visibility',
                    'field'    => 'name',
                    'terms'    => 'featured',
                    'operator' => 'IN',
                );
            break;

            case 'best_selling':
                $args['meta_key']   = 'total_sales';
                $args['orderby']    = 'meta_value_num';
                $args['order']      = 'desc';
            break;

            case 'top_rated': 
                $args['meta_key']   = '_wc_average_rating';
                $args['orderby']    = 'meta_value_num';
                $args['order']      = 'desc';          
            break;

            case 'mixed_order':
                $args['orderby']    = 'rand';
            break;

            case 'show_byid':
                $args['post__in'] = $settings['nnfy_product_id'];
            break;

            default: /* Recent */
                $args['orderby']    = 'date';
                $args['order']      = 'desc';
            break;
        }

        // Custom Order
        if( $custom_order_ck == 'yes' ){
            $args['orderby'] = $orderby;
            $args['order'] = $order;
        }

        $get_product_categories = $settings['nnfy_product_grid_categories']; // get custom field value
        $product_cats = str_replace(' ', '', $get_product_categories);
        if ( "0" != $get_product_categories) {
            if( is_array($product_cats) && count($product_cats) > 0 ){
                $field_name = is_numeric( $product_cats[0] )?'term_id':'slug';
                $args['tax_query'] = array(
                    array(
                        'taxonomy' => 'product_cat',
                        'terms' => $product_cats,
                        'field' => $field_name,
                        'include_children' => false
                    )
                );
            }
        }
        $products = new \WP_Query( $args );

        $this->add_render_attribute( 'products_area_attr', 'class', 'sc_products woocommerce columns-'.$columns );

        ?>
            <div <?php echo $this->get_render_attribute_string( 'products_area_attr' ); ?> >
                <div class="ht-row">
                    <?php 
                        while( $products->have_posts() ): $products->the_post();
                            wc_get_template_part('content-product');
                        endwhile;
                        wp_reset_postdata();
                    ?>
                </div>
            </div>

        <?php

    }

}