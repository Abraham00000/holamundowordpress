<?php
/**
 * Blocks Initializer
 *
 * Enqueue CSS/JS of all the blocks.
 * @package Hashbar Notification
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Enqueue Gutenberg block assets for both frontend + backend.
 *
 * Assets enqueued:
 * 1. blocks.style.build.css - Frontend + Backend.
 * 2. blocks.build.js - Backend.
 * 3. blocks.editor.build.css - Backend.
 *
 * @uses {wp-blocks} for block type registration & related functions.
 * @uses {wp-element} for WP Element abstraction — structure of blocks.
 * @uses {wp-i18n} to internationalize the block's text.
 * @uses {wp-editor} for WP editor styles.
 * @since 1.0.0
 */

function hashbar_wpnb_check_post(){

    $get_custom_post_type = isset($_GET['post']) ? get_post($_GET['post'])->post_type : '';

    if((isset($_GET['post_type']) && $_GET['post_type'] == 'wphash_ntf_bar') || ($get_custom_post_type!== '' && $get_custom_post_type == 'wphash_ntf_bar')){

        return true;
    }
    return false;
}

function hashbar_block_init() {

	// Register block styles for both frontend + backend.
	wp_register_style(
		'hashbar-block-style-css',
		plugins_url( 'blocks/dist/blocks.style.build.css', HASHBAR_WPNB_ROOT ),
		is_admin() ? array( 'wp-editor' ) : null,
		null
	);

	// Register block editor styles for backend.
	wp_register_style(
		'hashbar-block-editor-css', // Handle.
		plugins_url( 'blocks/dist/blocks.editor.build.css', HASHBAR_WPNB_ROOT ),
		array( 'wp-edit-blocks' ),
		null
	);

	// Register block editor script for backend.
	wp_register_script(
		'hashbar-block-js',
		plugins_url( 'blocks/dist/blocks.build.js', HASHBAR_WPNB_ROOT ), 
		array( 'wp-blocks', 'wp-i18n', 'wp-element', 'wp-editor' ), 
		null, 
		true
	);

	// WP Localized globals. Use dynamic PHP stuff in JavaScript via `rocketGlobal` object.
	wp_localize_script(
		'hashbar-block-js',
		'hashbarGlobal',
		[
			'pluginDirPath'   	=> plugin_dir_path( __DIR__ ),
			'pluginDirUrl'    	=> plugin_dir_url( __DIR__ )
		]
	);

	/**
	 * Register Gutenberg block on server-side.
	 *
	 * Register the block on server-side to ensure that the block
	 * scripts and styles for both frontend and backend are
	 * enqueued when the editor loads.
	 */
	register_block_type(
		'hashbar/hashbar-button', array(
			// Enqueue blocks.style.build.css on both frontend & backend.
			'style'         => 'hashbar-block-style-css',
			// Enqueue blocks.build.js in the editor only.
			'editor_script' => 'hashbar-block-js',
			// Enqueue blocks.editor.build.css in the editor only.
			'editor_style'  => 'hashbar-block-editor-css',
		)
	);
}

// Hook: Block assets.
if(is_admin()){
	if(hashbar_wpnb_check_post()){
		add_action( 'init', 'hashbar_block_init' );
	}
}else{
	add_action( 'init', 'hashbar_block_init' );
}
