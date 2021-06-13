<?php
namespace NNfy;
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

/**
*  sanitize function
*/
class NNfy_Sanitize{
    /**
     * Sanitization callback for 'checkbox' type controls. This callback sanitizes `$checked`
     * as a boolean value, either TRUE or FALSE.
     *
     * @param bool $checked Whether the checkbox is checked.
     * @return bool Whether the checkbox is checked.
     */
    public static function sanitize_checkbox( $checked ) {
        // Boolean check.
        return ( ( isset( $checked ) && true == $checked ) ? true : false );
    }

    public static function sanitize_input($input){
        return wp_kses_post( $input );
    }

    public static function sanitize_text_field( $str ) {
        $filtered = _sanitize_text_fields( $str, false );

        /**
         * Filters a sanitized text field string.
         *
         * @since 2.9.0
         *
         * @param string $filtered The sanitized string.
         * @param string $str      The string prior to being sanitized.
         */
        return apply_filters( 'sanitize_text_field', $filtered, $str );
    }

    public static function sanitize_absinteger( $input ) {
        if ( is_numeric( $input ) && $input != '0' ) {
            return absint( $input );
        } else return '';
    }

    /**
     * - Sanitization: hex_color
     * - Control: text, WP_Customize_Color_Control
     * 
     * Note: sanitize_hex_color_no_hash() can also be used here, depending on whether
     * or not the hash prefix should be stored/retrieved with the hex color value.
     * 
     * @see sanitize_hex_color() https://developer.wordpress.org/reference/functions/sanitize_hex_color/
     * @link sanitize_hex_color_no_hash() https://developer.wordpress.org/reference/functions/sanitize_hex_color_no_hash/
     *
     * @param string               $hex_color HEX color to sanitize.
     * @param WP_Customize_Setting $setting   Setting instance.
     * @return string The sanitized hex color if not null; otherwise, the setting default.
     */
    public static function sanitize_hex_color( $hex_color, $setting ) {
        // Sanitize $input as a hex value without the hash prefix.
        $hex_color = sanitize_hex_color( $hex_color );
        
        // If $input is a valid hex value, return it; otherwise, return the default.
        return ( ! is_null( $hex_color ) ? $hex_color : $setting->default );
    }

    /**
     * - Sanitization: select
     * - Control: select, radio
     * 
     * Sanitization callback for 'select' and 'radio' type controls. This callback sanitizes `$input`
     * as a slug, and then validates `$input` against the choices defined for the control.
     * 
     * @see sanitize_key()               https://developer.wordpress.org/reference/functions/sanitize_key/
     * @see $wp_customize->get_control() https://developer.wordpress.org/reference/classes/wp_customize_manager/get_control/
     *
     * @param string               $input   Slug to sanitize.
     * @param WP_Customize_Setting $setting Setting instance.
     * @return string Sanitized slug if it is a valid choice; otherwise, the setting default.
     */
    public static function sanitize_select( $input, $setting ) {
        
        // Ensure input is a slug.
        $input = sanitize_key( $input );
        
        // Get list of choices from the control associated with the setting.
        $choices = $setting->manager->get_control( $setting->id )->choices;
        
        // If the input is a valid key, return it; otherwise, return the default.
        return ( array_key_exists( $input, $choices ) ? $input : $setting->default );
    }

    /** 
    * Sanitization: Repeter
    */
    public static function sanitize_repeater( $input ) {
        $input_decoded = json_decode($input,true);
        if(!empty($input_decoded)) {
            foreach ($input_decoded as $boxk => $box ){
                foreach ($box as $key => $value){
                    $input_decoded[$boxk][$key] = wp_kses_post( force_balance_tags( $value ) );
                }
            }
            return json_encode($input_decoded);
        }
        return $input;
    }

}