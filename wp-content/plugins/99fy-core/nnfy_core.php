<?php
/**
 * Plugin Name: 99Fy Core
 * Description: After installing the 99fy WordPress Theme, you recommended to install this "99Fy Companion Plugin" first in order to make your site look like as in the demo.
 * Plugin URI:  https://hasthemes.com/plugins/
 * Version:     1.2.2
 * Author:      HasThemes
 * Author URI:  https://hasthemes.com/
 * License:     GPL-2.0+
 * License URI: http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain: 99fy
 * Domain Path: /languages
*/

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

define( 'NNFY_VERSION', '1.2.2' );
define( 'NNFY_PL_ROOT', __FILE__ );
define( 'NNFY_PL_URL', plugin_dir_url(  NNFY_PL_ROOT ) );
define( 'NNFY_PL_PATH', plugin_dir_path( NNFY_PL_ROOT ) );
define( 'NNFY_PLUGIN_BASE', plugin_basename( NNFY_PL_ROOT ) );
define( 'NNFY_ASSETS', trailingslashit( NNFY_PL_URL . 'assets' ) );
define( 'NNFY_ADMIN_ASSETS', trailingslashit( NNFY_PL_URL . 'admin/assets' ) );
// Include base file
require ( NNFY_PL_PATH . 'includes/base.php' );
\NNfy\Base::instance();