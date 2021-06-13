<?php
/*
 * Wishsuite Uninstall plugin
 * Uninstalling Wishsuite deletes tables, and options.
 */

if ( ! defined( 'WP_UNINSTALL_PLUGIN' ) ) exit; // Exit if accessed directly

include_once dirname( __FILE__ ) . '/includes/classes/Installer.php';

function wishsuite_uninstall(){

	// Delete page created for this plugin
	$option_data = get_option( 'wishsuite_table_settings_tabs' );
	wp_delete_post( $option_data['wishlist_page'], true );

	// Option delete
	delete_option( 'wishsuite_version' );
	delete_option( 'wishsuite_settings_tabs' );
	delete_option( 'wishsuite_table_settings_tabs' );
	delete_option( 'wishsuite_style_settings_tabs' );

	// Delete table
	\WishSuite\Installer::drop_tables();
	
}
wishsuite_uninstall();