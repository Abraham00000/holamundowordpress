<?php
add_action( 'admin_menu', 'hashbar_wpnb_add_admin_menu' );
add_action( 'admin_init', 'hashbar_wpnb_settings_init' );


function hashbar_wpnb_add_admin_menu(  ) { 

	add_submenu_page( 'edit.php?post_type=wphash_ntf_bar', 'HashBar Options', 'HashBar Options', 'manage_options', 'hashbar_options_page', 'hashbar_wpnb_options_page' );

}


function hashbar_wpnb_settings_init(  ) { 

	register_setting( 'options_group_1', 'hashbar_wpnbp_opt' );

	add_settings_section(
		'hashbar_wpnbp_options_group_1_section', 
		'', 
		null, 
		'options_group_1'
	);

	add_settings_field( 
		'dont_show_bar_after_close', 
		__( 'Don\'t Show Notification After Close <span class="pro">(Pro)</span>', 'hashbar' ), 
		'hashbar_wpnb_checkbox_render', 
		'options_group_1', 
		'hashbar_wpnbp_options_group_1_section' 
	);

	add_settings_field( 
		'keep_closed_bar', 
		__( 'Kepp The Notification Bar Closed <span class="pro">(Pro)</span>', 'hashbar' ), 
		'hashbar_wpnb_bar_closed_checkbox_render', 
		'options_group_1', 
		'hashbar_wpnbp_options_group_1_section' 
	);

	add_settings_field( 
		'mobile_device_breakpoint', 
		__( 'Mobile device breakpoint (px) <span class="pro">(Pro)</span>', 'hashbar' ), 
		'hashbar_wpnb_text_render', 
		'options_group_1', 
		'hashbar_wpnbp_options_group_1_section' 
	);

}


function hashbar_wpnb_checkbox_render(  ) { 

	$options = get_option( 'hashbar_wpnbp_opt' );
	$checkbox_val = isset($options['dont_show_bar_after_close']) ? $options['dont_show_bar_after_close'] : '';
	?>
	<input class="pro" type='checkbox' name='hashbar_wpnbp_opt[dont_show_bar_after_close]'  <?php checked($checkbox_val, 1) ?> value='1'>
	<p class="description">If check this option. The notification will not apprear again in a page, after closing the notification.</p>
	<?php

}

function hashbar_wpnb_bar_closed_checkbox_render(){
	$options = get_option( 'hashbar_wpnbp_opt' );
	$checkbox_val = isset($options['keep_closed_bar']) ? $options['keep_closed_bar'] : '';
	?>
	<input type='checkbox' name='hashbar_wpnbp_opt[keep_closed_bar]' value='1' disabled="disabled">
	<p class="description">When you close the notification bar once then it will always keep closed in all pages of your site.</p>
	<?php
}

function hashbar_wpnb_text_render(  ) {

	$options = get_option( 'hashbar_wpnbp_opt' );
	$text_val = isset($options['mobile_device_breakpoint']) ? $options['mobile_device_breakpoint'] : '';
	?>
	<input class="pro" type='text' name='hashbar_wpnbp_opt[mobile_device_breakpoint]' value="<?php echo esc_attr($text_val); ?>">
	<p class="description">Sets the breakpoint between mobile and desktop devices. Below this breakpoint mobile layout will appear (Default: 767).</p>
	<?php

}


function hashbar_wpnb_options_page(  ) { 

	?>
	<form id="hashbar" action='options.php' method='post'>

		<h2><?php echo esc_html__( 'HashBar Pro Global Options', 'hashbar' ) ?></h2>

		<?php
		settings_fields( 'options_group_1' );
		do_settings_sections( 'options_group_1' );
		submit_button();
		?>


		<div class="hashbar_pro_details">
			<a class="buy_pro" target="_blank" href="https://hasthemes.com/0lx0">Buy PRO</a>
			<a class="banner" target="_blank" href="https://hasthemes.com/0lx0"><img src="<?php echo esc_url( HASHBAR_WPNB_URI . '/admin/img/hashbarpro-banner.jpg'); ?>"></a>
			<p>HashBar Pro <a target="_blank" href="https://hasthemes.com/0lx0">More Details</a></p>
		</div>
	</form>
	<?php

}

?>