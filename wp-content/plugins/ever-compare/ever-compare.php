<?php
/**
 * Plugin Name: Ever Compare
 * Description: WooCommerce Product compare plugin
 * Plugin URI: https://hasthemes.com/plugins/
 * Author: HasTheme
 * Author URI: https://hasthemes.com/
 * Version: 1.1.2
 * License: GPL2 or later
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain: ever-compare
 * Domain Path: /languages
 * WC tested up to: 5.3.0
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
require_once __DIR__ . '/vendor/autoload.php';

/**
* Plugin Main Class
*/
final class Ever_Compare{

    /**
     * Plugin version
     *
     * @var string
     */
    const version = '1.1.2';

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
     * [__construct] Class Constructor
     */
    private function __construct(){

        $this->define_constants();

        register_activation_hook( EVERCOMPARE_FILE, [ $this, 'activate' ] );

        add_action( 'init', [ $this, 'i18n' ] );
        add_action( 'plugins_loaded', [ $this, 'init_plugin' ] );

    }

    /**
     * Define the required plugin constants
     *
     * @return void
     */
    public function define_constants() {
        define( 'EVERCOMPARE_VERSION', self::version );
        define( 'EVERCOMPARE_FILE', __FILE__ );
        define( 'EVERCOMPARE_PATH', __DIR__ );
        define( 'EVERCOMPARE_DIR', plugin_dir_path( EVERCOMPARE_FILE ) );
        define( 'EVERCOMPARE_URL', plugins_url( '', EVERCOMPARE_FILE ) );
        define( 'EVERCOMPARE_ASSETS', EVERCOMPARE_URL . '/assets' );
        define( 'EVERCOMPARE_BASE', plugin_basename( EVERCOMPARE_FILE ) );
    }

    /**
     * [i18n] Load text domain
     * @return [void]
     */
    public function i18n() {
        load_plugin_textdomain( 'ever-compare', false, dirname( plugin_basename( EVERCOMPARE_FILE ) ) . '/languages/' );
    }

    /**
     * Initialize the plugin
     *
     * @return void
     */
    public function init_plugin() {
        if ( ! function_exists('is_plugin_active') ){ include_once( ABSPATH . 'wp-admin/includes/plugin.php' ); }

        EverCompare\Assets::instance();

        if ( defined( 'DOING_AJAX' ) && DOING_AJAX ) {
            EverCompare\Ajax::instance();
        }

        if ( is_admin() ) {
            $this->admin_notices();
            EverCompare\Admin::instance();
        }
        EverCompare\Frontend::instance();

        // add image size
        $this->set_image_size();

        // let's filter the woocommerce image size
        add_filter( 'woocommerce_get_image_size_ever-compare-image', [ $this, 'wc_image_filter_size' ], 10, 1 );

    }

    /**
     * Do stuff upon plugin activation
     *
     * @return void
     */
    public function activate() {
        $installer = new EverCompare\Installer();
        $installer->run();
    }

    /**
     * Admin Notices
     * @return void
     */
    public function admin_notices() {
        $notice = new EverCompare\Admin\Notices();
        $notice->notice();
    }

    /**
     * [set_image_size] Set Image Size
     */
    public function set_image_size(){

        $image_dimention = ever_compare_get_option( 'image_size', 'ever_compare_table_settings_tabs', array( 'width'=>300, 'height'=>300 ) );
        if( isset( $image_dimention ) && is_array( $image_dimention ) ){
            $hard_crop = !empty( ever_compare_get_option( 'hard_crop', 'ever_compare_table_settings_tabs' ) ) ? true : false;
            add_image_size( 'ever-compare-image', $image_dimention['width'], $image_dimention['height'], $hard_crop );
        }

    }

    /**
     * [wc_image_filter_size]
     * @return [array]
     */
    public function wc_image_filter_size(){

        $image_dimention = ever_compare_get_option( 'image_size', 'ever_compare_table_settings_tabs', array('width'=>300,'height'=>300) );
        $hard_crop = !empty( ever_compare_get_option( 'hard_crop', 'ever_compare_table_settings_tabs' ) ) ? true : false;

        if( isset( $image_dimention ) && is_array( $image_dimention ) ){
            return array(
                'width'  => isset( $image_dimention['width'] ) ? absint( $image_dimention['width'] ) : 300,
                'height' => isset( $image_dimention['height'] ) ? absint( $image_dimention['height'] ) : 300,
                'crop'   => isset( $hard_crop ) ? 1 : 0,
            );
        }
        
    }

}

/**
 * Initializes the main plugin
 *
 * @return ever_compare
 */
function ever_compare() {
    return Ever_Compare::instance();
}

// Start Our journey
ever_compare();