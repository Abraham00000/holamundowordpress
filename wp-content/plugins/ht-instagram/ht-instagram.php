<?php
/**
 * Plugin Name: HT Feed
 * Description: The HT Feed is a elementor addons, Visul Composer addons, WordPress Widges.
 * Plugin URI:  https://htplugins.com/
 * Author:      HasThemes
 * Author URI:  https://hasthemes.com/
 * Version:     1.2.0
 * License:     GPL2
 * License URI:  https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain: ht-instagram
 * Domain Path: /languages
*/

if( ! defined( 'ABSPATH' ) ) exit(); // Exit if accessed directly

define( 'HTINSTA_VERSION', '1.2.0' );
define( 'HTINSTA_PL_URL', plugins_url( '/', __FILE__ ) );
define( 'HTINSTA_PL_PATH', plugin_dir_path( __FILE__ ) );

// Required File
require_once HTINSTA_PL_PATH.'include/classes.php';
require_once HTINSTA_PL_PATH.'admin/admin-init.php';
require_once HTINSTA_PL_PATH.'include/default_widgets.php';
require_once HTINSTA_PL_PATH.'include/shortcode.php';

if( did_action( 'elementor/loaded' ) ){
    require_once HTINSTA_PL_PATH. '/include/class.htinstagram-icon-manager.php';
}

if ( in_array('js_composer/js_composer.php', get_option('active_plugins') ) ){
    include( HTINSTA_PL_PATH.'include/vc_map.php' );
}

function htinstagram_elementor_widgets(){
    include( HTINSTA_PL_PATH.'include/elementor_widgets.php' );
}
add_action('elementor/widgets/widgets_registered','htinstagram_elementor_widgets');

// Options value fetch
function htinstagram_get_option( $option, $section, $default = '' ) {
    $options = get_option( $section );
    if ( isset( $options[$option] ) ) {
        return $options[$option];
    }
    return $default;
}

//Enqueue style

function htinstagram_assests_enqueue() {

    wp_enqueue_style('htinstagram-feed', HTINSTA_PL_URL . 'assests/css/ht-instagramfeed.css', '', HTINSTA_VERSION );
    wp_enqueue_style('font-awesome', HTINSTA_PL_URL . 'assests/css/font-awesome.min.css', '', HTINSTA_VERSION );

    // Register Style
    wp_register_style( 'slick', HTINSTA_PL_URL . 'assests/css/slick.min.css', array(), HTINSTA_VERSION );

    // Script register
    wp_register_script( 'slick', HTINSTA_PL_URL . 'assests/js/slick.min.js', array(), HTINSTA_VERSION, TRUE );
    wp_register_script( 'ht-instagramFeed', HTINSTA_PL_URL . 'assests/js/jquery.instagramFeed.min.js', array('jquery'), HTINSTA_VERSION, TRUE );
    wp_register_script( 'ht-active', HTINSTA_PL_URL . 'assests/js/active.js', array('jquery'), HTINSTA_VERSION, TRUE );

}
add_action( 'wp_enqueue_scripts', 'htinstagram_assests_enqueue' );

// Add settings link on plugin page.
function htinstagram_pl_setting_links( $htinstagram_links ) {
    $htinstagram_settings_link = '<a href="admin.php?page=htinstagram">'.esc_html__( 'Settings', 'ht-instagram' ).'</a>'; 
    array_unshift( $htinstagram_links, $htinstagram_settings_link );   
    return $htinstagram_links; 
} 
$htinstagram_plugin_name = plugin_basename(__FILE__); 
add_filter("plugin_action_links_$htinstagram_plugin_name", 'htinstagram_pl_setting_links' );