<?php

if( ! defined( 'ABSPATH' ) ) exit(); // Exit if accessed directly

class HTinstagram_Admin_Setting{

    public function __construct(){
        add_action('admin_enqueue_scripts', array( $this, 'htinstagram_enqueue_admin_scripts' ) );
        $this->htinstagram_admin_settings_page();
    }

    /*
    *  Setting Page
    */
    public function htinstagram_admin_settings_page() {
        require_once('include/class.settings-api.php');
        require_once('include/admin-setting.php');
    }

    /*
    *  Enqueue admin scripts
    */
    public function htinstagram_enqueue_admin_scripts(){
        wp_enqueue_style( 'htinstragram-admin', HTINSTA_PL_URL . 'admin/assets/css/admin_optionspanel.css', FALSE, HTINSTA_VERSION );
    }

}

new HTinstagram_Admin_Setting();