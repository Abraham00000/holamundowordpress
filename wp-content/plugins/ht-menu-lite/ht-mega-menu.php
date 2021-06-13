<?php
/**
 * Plugin Name: HT Menu Lite
 * Description: HT Menu for Elementor Page Builder. You can create easily any layout use this plugins.
 * Plugin URI:  http://demo.shrimpthemes.com/1/megamenu/
 * Author:      HasThemes
 * Author URI:  http://hasthemes.com/
 * Version:     1.1.6
 * License:     GPL2
 * License URI:  https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain: htmega-menu
 * Domain Path: /languages
*/
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

define( 'HTMEGA_MENU_VERSION', '1.1.6' );
define( 'HTMEGA_MENU_PL_ROOT', __FILE__ );
define( 'HTMEGA_MENU_PL_URL', plugins_url( '/', HTMEGA_MENU_PL_ROOT ) );
define( 'HTMEGA_MENU_PL_PATH', plugin_dir_path( HTMEGA_MENU_PL_ROOT ) );
define( 'HTMEGA_MENU_DIR_URL', plugin_dir_url( HTMEGA_MENU_PL_ROOT ) );
define( 'HTMEGA_MENU_PLUGIN_BASE', plugin_basename( HTMEGA_MENU_PL_ROOT ) );
define( 'HTMEGA_MENU_NAME', 'HTMega Menu Lite' );

// Required File
require_once ( HTMEGA_MENU_PL_PATH . 'include/class.mega-menu.php' );
\HTMegaMenuLite\HTMega_Menu_Elementor::instance();