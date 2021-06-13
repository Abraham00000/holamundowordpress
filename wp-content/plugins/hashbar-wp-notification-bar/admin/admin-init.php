<?php

// Load additional libs
add_action( 'admin_init', 'hashfolio_wpn_load_libs');
function hashfolio_wpn_load_libs(){
     $installed_plugins = get_plugins();
     $active_plugins = (array) get_option( 'active_plugins', array() );


     //load cmb2
     $plugin = 'cmb2/init.php';
     if (array_key_exists($plugin, $installed_plugins) && !in_array($plugin, $active_plugins) || !array_key_exists($plugin, $installed_plugins)){
         //echo "not active so include";
        include_once( HASHBAR_WPNB_DIR. '/admin/cmb2/init.php');
     }
}