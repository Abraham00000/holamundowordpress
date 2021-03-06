<?php
namespace WishSuite\Frontend;
/**
 * Shortcode handler class
 */
class Shortcode {

    /**
     * [$_instance]
     * @var null
     */
    private static $_instance = null;

    /**
     * [instance] Initializes a singleton instance
     * @return [Base]
     */
    public static function instance() {
        if ( is_null( self::$_instance ) ) {
            self::$_instance = new self();
        }
        return self::$_instance;
    }

    /**
     * Initializes the class
     */
    function __construct() {
        add_shortcode( 'wishsuite_button', [ $this, 'button_shortcode' ] );
        add_shortcode( 'wishsuite_table', [ $this, 'table_shortcode' ] );
    }

    /**
     * [button_shortcode] Button Shortcode callable function
     * @param  [type] $atts 
     * @param  string $content
     * @return [HTML] 
     */
    public function button_shortcode( $atts, $content = '' ){
        wp_enqueue_style( 'wishsuite-frontend' );
        wp_enqueue_script( 'wishsuite-frontend' );

        global $product;
        $product_id = '';
        if ( $product && is_a( $product, 'WC_Product' ) ) {
            $product_id = $product->get_id();
        }

        $has_product = false;
        if ( Manage_Wishlist::instance()->is_product_in_wishlist( $product_id ) ) {
            $has_product = true;
        }

        // Fetch option data
        $button_text        = wishsuite_get_option( 'button_text','wishsuite_settings_tabs', 'Wishlist' );
        $button_added_text  = wishsuite_get_option( 'added_button_text','wishsuite_settings_tabs', 'Product Added' );
        $button_exist_text  = wishsuite_get_option( 'exist_button_text','wishsuite_settings_tabs', 'Product already added' );
        $shop_page_btn_position     = wishsuite_get_option( 'shop_btn_position', 'wishsuite_settings_tabs', 'after_cart_btn' );
        $product_page_btn_position  = wishsuite_get_option( 'product_btn_position', 'wishsuite_settings_tabs', 'after_cart_btn' );
        $button_style               = wishsuite_get_option( 'button_style', 'wishsuite_style_settings_tabs', 'default' );

        $button_class = array(
            'wishsuite-btn',
            'wishsuite-button',
            'wishsuite-shop-'.$shop_page_btn_position,
            'wishsuite-product-'.$product_page_btn_position,
        );

        if( $button_style === 'themestyle' ){
            $button_class[] = 'button';
        }

        if ( $has_product === true && ( $key = array_search( 'wishsuite-btn', $button_class ) ) !== false ) {
            unset( $button_class[$key] );
        }


        $button_icon        = $this->icon_generate();
        $added_button_icon  = $this->icon_generate('added');
        
        if( !empty( $button_text ) ){
            $button_text = '<span class="wishsuite-btn-text">'.$button_text.'</span>';
        }
        
        if( !empty( $button_exist_text ) ){
            $button_exist_text = '<span class="wishsuite-btn-text">'.$button_exist_text.'</span>';
        }

        if( !empty( $button_added_text ) ){
            $button_added_text = '<span class="wishsuite-btn-text">'.$button_added_text.'</span>';
        }

        // Shortcode atts
        $default_atts = array(
            'product_id'        => $product_id,
            'button_url'        => wishsuite_get_page_url(),
            'button_class'      => implode(' ', $button_class ),
            'button_text'       => $button_icon.$button_text,
            'button_added_text' => $added_button_icon.$button_added_text,
            'button_exist_text' => $added_button_icon.$button_exist_text,
            'has_product'       => $has_product,
            'template_name'     => ( $has_product === true ) ? 'exist' : 'add',
        );
        $atts = shortcode_atts( $default_atts, $atts, $content );
        return Manage_Wishlist::instance()->button_html( $atts );

    }

    /**
     * [table_shortcode] Table List Shortcode callable function
     * @param  [type] $atts
     * @param  string $content
     * @return [HTML] 
     */
    public function table_shortcode( $atts, $content = '' ){
        wp_enqueue_style( 'wishsuite-frontend' );
        wp_enqueue_script( 'wishsuite-frontend' );

        /* Fetch From option data */
        $empty_text = wishsuite_get_option( 'empty_table_text', 'wishsuite_table_settings_tabs' );

        /* Product and Field */
        $products   = Manage_Wishlist::instance()->get_products_data();
        $fields     = Manage_Wishlist::instance()->get_all_fields();

        $custom_heading = !empty( wishsuite_get_option( 'table_heading', 'wishsuite_table_settings_tabs' ) ) ? wishsuite_get_option( 'table_heading', 'wishsuite_table_settings_tabs' ) : array();

        $default_atts = array(
            'wishsuite'    => Manage_Wishlist::instance(),
            'products'     => $products,
            'fields'       => $fields,
            'heading_txt'  => $custom_heading,
            'empty_text'   => !empty( $empty_text ) ? $empty_text : '',
        );

        $atts = shortcode_atts( $default_atts, $atts, $content );
        return Manage_Wishlist::instance()->table_html( $atts );

    }

    /**
     * [icon_generate]
     * @param  string $type
     * @return [HTML]
     */
    public function icon_generate( $type = '' ){

        $default_icon = file_get_contents( WISHSUITE_ASSETS .'/images/icon.svg' );
        $default_loader = '<span class="wishsuite-loader">'.file_get_contents( WISHSUITE_ASSETS .'/images/loading.svg' ).'</span>';
        
        $button_icon = '';
        $button_text = ( $type === 'added' ) ? wishsuite_get_option( 'added_button_text','wishsuite_settings_tabs', 'Wishlist' ) : wishsuite_get_option( 'button_text','wishsuite_settings_tabs', 'Wishlist' );
        $button_icon_type  = wishsuite_get_option( $type.'button_icon_type', 'wishsuite_style_settings_tabs', 'default' );

        if( $button_icon_type === 'custom' ){
            $button_icon = wishsuite_get_option( $type.'button_custom_icon','wishsuite_style_settings_tabs', '' );
        }else{
            if( $button_icon_type !== 'none' ){
                return $default_icon;
            }
        }

        if( !empty( $button_icon ) ){
            $button_icon = '<img src="'.esc_url( $button_icon ).'" alt="'.esc_attr( $button_text ).'">';
        }

        return $button_icon.$default_loader;

    }


}