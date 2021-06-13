<?php

class htmenu_Mega_Menu {

	function __construct() {
		// add custom menu fields to menu
		add_filter( 'wp_setup_nav_menu_item', array( $this, 'add_custom_fields_meta' ) );

		// save menu custom fields
		add_action( 'wp_update_nav_menu_item', array( $this, 'update_custom_nav_fields'), 10, 3 );
		// edit menu walker
		add_filter( 'wp_edit_nav_menu_walker', array( $this, 'rc_scm_edit_walker'), 10, 2 );
	} // end constructor
	
	/**
	 * Add custom fields to $item nav object
	 * in order to be used in custom Walker
	 *
	 * @access      public
	 * @since       1.0 
	 * @return      void
	*/
	public function add_custom_fields_meta( $menu_item ) {
	    $menu_item->menuposition   = get_post_meta( $menu_item->ID, '_menu_item_menuposition', true );
	    $menu_item->megamenu       = get_post_meta( $menu_item->ID, '_menu_item_megamenu', true );
        $menu_item->template       = get_post_meta( $menu_item->ID, '_menu_item_template', true );
	    $menu_item->menuwidth      = get_post_meta( $menu_item->ID, '_menu_item_menuwidth', true );
	    $menu_item->disablet       = get_post_meta( $menu_item->ID, '_menu_item_disablet', true );
	    return $menu_item;
	}
    
	/**
	 * Save menu custom fields
	 *
	 * @access      public
	 * @since       1.0 
	 * @return      void
	*/
	public function update_custom_nav_fields( $menu_id, $menu_item_db_id, $args ) {
        $fieldkey = array( 
            'menuposition', 
            'megamenu', 
            'template', 
            'menuwidth',
            'disablet',
        );
        foreach ( $fieldkey as $key ) {
            if(!isset($_POST['menu-item-'.$key][$menu_item_db_id])) {
                $_POST['menu-item-'.$key][$menu_item_db_id] = '';
            }
            $value = sanitize_text_field( wp_unslash( $_POST['menu-item-'.$key][$menu_item_db_id] ) );
            update_post_meta( $menu_item_db_id, '_menu_item_'.$key, $value );
        }
	}

	/**
	 * Define new Walker edit
	 *
	 * @access      public
	 * @since       1.0 
	 * @return      void
	*/
	public function rc_scm_edit_walker( $walker, $menu_id ) {
        require_once HTMEGA_MENU_PL_PATH . '/include/menu/htmenu_edit_walker.php';
	    return 'htmenu_Walker_Nav_Menu_Edit';
	}



}

// instantiate plugin's class
$GLOBALS['htmenu_Mega_Menu'] = new htmenu_Mega_Menu();
require HTMEGA_MENU_PL_PATH . '/include/menu/htmenu_walker.php';
require HTMEGA_MENU_PL_PATH . '/include/menu/menu_term.php';