<?php

add_action('cmb2_meta_boxes','hashbar_wpnb_meta_boxes');
if( ! function_exists('hashbar_wpnb_meta_boxes') ){

	function hashbar_wpnb_meta_boxes(){
		$prefix = '_wphash_';

		$meta_box = new_cmb2_box( array(
			'id'          => $prefix . 'notification_options',
			'title'       => esc_html__( 'Notification Bar Options', 'hashbar' ),
			'object_types'=> array('wphash_ntf_bar'),
			'context'     => 'normal',
			'priority'    => 'high',
			'show_names'  => true,
		) );

		$meta_box->add_field( array(
			'id'          => $prefix.'notification_where_to_show',
			'name'        => esc_html__( 'Choose option where to show', 'hashbar' ),
			'type'        => 'radio_inline',
			'options'     => array(
				'everywhere'    => __( 'Everywhere', 'hashbar' ),
				'custom'       	=> __( 'Custom', 'hashbar' ),
				'post'       	=> __( 'Individual Posts <span class="pro">(Pro)</span>', 'hashbar' ),
				'page'       	=> __( 'Individual Pages <span class="pro">(Pro)</span>', 'hashbar' ),
				'url_param'  	=> __( 'URL Parameter', 'hashbar' ),
				'none'       	=> __( 'Don\'t show', 'hashbar' ),
			),
			'default'     		=> 'everywhere',
		) );

		$meta_box->add_field( array(
			'id'                 => $prefix.'url_param',
			'name'        		 => esc_html__( 'URL Paramenter Value', 'hashbar' ),
			'type'        		 => 'text',
			'description'		 => esc_html__('Input URL parameter value, ex: discount_50 . So your URL should look like: example.com/?param=discount_50 . When visitors visit this URL they will see this notification.'),
			'attributes' => array(
				'data-conditional-id'    => $prefix . 'notification_where_to_show',
				'data-conditional-value' => wp_json_encode( array( 'url_param' ) ),
			),
		) );

		$meta_box->add_field( array(
			'id'        => $prefix.'notification_where_to_show_custom',
			'name'      => esc_html__( 'Custom options where to show', 'hashbar' ),
			'type'      => 'multicheck',
			'options'   => array(
				'posts' => esc_html__( 'Posts', 'hashbar' ),
				'page'  => esc_html__( 'Pages', 'hashbar' ),
				'home'  => esc_html__( 'Home', 'hashbar' ),
			),
			'attributes' => array(
				'data-conditional-id'    => $prefix . 'notification_where_to_show',
				'data-conditional-value' => wp_json_encode( array( 'custom' ) ),
			),

		) );

		$meta_box->add_field( array(
			'id'                 => $prefix.'notification_width',
			'name'        		 => esc_html__( 'Width', 'hashbar' ),
			'type'        		 => 'text',
			'description'		 => esc_html__('Input width of notification bar, ex: 300px')
		) );

		$meta_box->add_field( array(
			'id'               => $prefix.'notification_position',
			'name'        	   => esc_html__( 'Positioning', 'hashbar' ),
			'type'        	   => 'radio_inline',
			'options'     	   => array(
				'ht-n-left'    => esc_html__( 'Left', 'hashbar' ),
				'ht-n-top'     => esc_html__( 'Top', 'hashbar' ),
				'ht-n-right'   => esc_html__( 'Right', 'hashbar' ),
				'ht-n-bottom'  => esc_html__( 'Bottom', 'hashbar' ),
			),
			'default' => 'ht-n-top',
			'desc' 	  => wp_kses( __( 'Left means the notification bar is always fixed at the left <br> Top means the notificatin bar is always fixed at the top of the page. <br> Right means the notification bar is always fixed at the right<br> Bottom means the notificatin bar is always visible at the bottom of the page', 'hashbar' ), array( 'br' => array() ) ),
		) );

		$meta_box->add_field( array(
			'id'    => $prefix.'themes_header_type',
			'name'  => __( 'Theme\'s Header Type <span>(Pro)</span>', 'hashbar' ),
			'type'  => 'select',
			'options' => array(
				'none'	=> __('Default', 'hashbar'),
				'transparent' => __('Transparent or sticky', 'hashbar'),
			),
			'description' => __('What kind of header you are using in your theme?<br> Select the header type.<br> If your header transparent or sticky, <br>then you must need input  height of the notification bar and css selector of your header.'),
			'attributes' => array(
				'disabled' => true,
			),
		) );

		$meta_box->add_field( array(
			'id'    => $prefix.'notification_transparent_selector',
			'name'  => __( 'Header Class/ID <span>(Pro)</span>', 'hashbar' ),
			'type'  => 'text',
			'description' => esc_html__('Input the Header Class / ID of your transparent / sticky header. Ex: #header/.header'),
			'attributes' => array(
				'disabled' => true,
			),
		) );

		$meta_box->add_field( array(
			'id'    => $prefix.'notification_display',
			'name'  => esc_html__( 'Display', 'hashbar' ),
			'type'  => 'radio_inline',
			'options'=> array(
				'ht-n-open' => esc_html__( 'Open', 'hashbar' ),
				'ht-n-close'=> esc_html__( 'Close', 'hashbar' ),
			),
			'default' => 'ht-n-open',
		) );

		$meta_box->add_field( array(
			'id'   => $prefix.'notification_on_desktop',
			'name' => esc_html__( 'Enable / Disable On Desktop Device', 'hashbar' ),
			'type' => 'radio_inline',
			'options'=> array(
				'on' => esc_html__( 'Enable', 'hashbar' ),
				'off'=> esc_html__( 'Disable', 'hashbar' ),
			),
			'default' => 'on',
		) );

		$meta_box->add_field( array(
			'id'   => $prefix.'notification_on_mobile',
			'name' => esc_html__( 'Enable / Disable On Mobile Device', 'hashbar' ),
			'type' => 'radio_inline',
			'options' => array(
				'on'  => esc_html__( 'Enable', 'hashbar' ),
				'off' => esc_html__( 'Disable', 'hashbar' ),
			),
			'default' => 'on',
		) );

		// pro
		$meta_box->add_field( array(
			'id'   => $prefix.'notification_schedule',
			'name' => __( 'Enable / Disable Schedule Pause Time <span class="">(Pro)</span>', 'hashbar' ),
			'type' => 'radio_inline',
			'options' => array(
				'on'  => esc_html__( 'Enable', 'hashbar' ),
				'off' => esc_html__( 'Disable', 'hashbar' ),
			),
			'desc' => 'This option useful, if you need to pause this notification at a specific date/time. </br> If you enable shceduling, the scheduled time must be greater than current time, otherwise this notifcation will be saved as draft. </br>Your current time is: '. current_time(get_option( 'date_format')) .' '. current_time('h : i A') . ' If you see it is not correct, set the correct timezone of your location from Settings > General > Timezone or  <a target="_blank" href="'.admin_url( 'options-general.php').'">click here</a>',
			'default' => 'off',
			'attributes' => array(
				'disabled' => true,
			),
		) );

		$meta_box->add_field( array(
			'id'   => $prefix.'notification_schedule_datetime',
			'name' => __( 'Notification Paused Date/Time <span class="">(Pro)</span>', 'hashbar' ),
			'type' => 'text_datetime_timestamp',
			'desc' => 'Set the date and time when this notification will be paused.',
			'attributes' => array(
				'disabled' => true,
			),
		) );

		$meta_box->add_field( array(
			'id'                 => $prefix.'notification_content_width',
			'name'        		 => esc_html__( 'Content Width', 'hashbar' ),
			'type'        		 => 'radio_inline',
			'options'     		 => array(
				'default-width'  => esc_html__( 'Default', 'hashbar' ),
				'ht-n-full-width'=> esc_html__( 'Full Width', 'hashbar' ),
			),
			'default' => 'default-width',
			'attributes' => array(
				'data-conditional-id'    => $prefix . 'notification_position',
				'data-conditional-value' => wp_json_encode( array( 'ht-n-top','ht-n-bottom' ) ),
			),
		) );

		$meta_box->add_field( array(
			'id'   => $prefix.'notification_content_margin',
			'name' => esc_html__( 'Content Margin', 'hashbar' ),
			'type' => 'hashbar_margin_input'
		) );

		$meta_box->add_field( array(
			'id'   => $prefix.'notification_content_padding',
			'name' => esc_html__( 'Content Padding', 'hashbar' ),
			'type' => 'hashbar_padding_inpupt'
		) );

		$meta_box->add_field( array(
			'id'   => $prefix.'notification_how_many_times_to_show',
			'name' => esc_html__( 'How many time to show notification', 'hashbar' ),
			'type' => 'text',
			'desc' => esc_html__( 'Input the number, how many time will apprear this notification. Number consider by each page load where the notification appear', 'hashbar' ),
		) );

		$meta_box->add_field( array(
			'id'   => $prefix.'notification_content_bg_color',
			'name' => esc_html__( 'Content Background color', 'hashbar' ),
			'type' => 'colorpicker',
		) );

		$meta_box->add_field( array(
			'id'   => $prefix.'notification_content_bg_image',
			'name' => esc_html__( 'Content Background Image', 'hashbar' ),
			'type' => 'file',
		) );

		$meta_box->add_field( array(
			'id'   => $prefix.'notification_content_text_color',
			'name' => esc_html__( 'Content Text Color', 'hashbar' ),
			'type' => 'colorpicker',
		) );

		$meta_box->add_field( array(
			'id'    => $prefix.'notification_content_bg_opcacity',
			'name'  => esc_html__( 'Opacity', 'hashbar' ),
			'type'  => 'text',
		) );

		$meta_box->add_field( array(
			'id'       => $prefix.'notification_close_button',
			'name'     => esc_html__( 'Enable / Disable Close Button', 'hashbar' ),
			'type'     => 'radio_inline',
			'options'  => array(
				'on'   => esc_html__( 'Enable', 'hashbar' ),
				'off'  => esc_html__( 'Disable', 'hashbar' ),
			),
			'default'  => 'on',
		) );

		$meta_box->add_field( array(
			'id'             => $prefix.'notification_close_button_text',
			'name'        	 => esc_html__( 'Close Button Text', 'hashbar' ),
			'type'        	 => 'text',
			'before_display' => '<h3 style="border-bottom: 1px solid #e9e9e9;padding-bottom: 1em;">Close Button Options</h3>',
			'desc' => esc_html__( 'Only works with left and right position', 'hashbar' ),
		) );

		$meta_box->add_field( array(
			'id'   => $prefix.'notification_open_button_text',
			'name' => esc_html__( 'Open Button Text', 'hashbar' ),
			'type' => 'text',
			'desc' => esc_html__( 'Leave it empty if you don\'t want text instead of arrow icon', 'hashbar' ),
		) );

		$meta_box->add_field( array(
			'id'   => $prefix.'notification_close_button_bg_color',
			'name' => esc_html__( 'Close Button BG Color', 'hashbar' ),
			'type' => 'colorpicker',
		) );

		$meta_box->add_field( array(
			'id'   => $prefix.'notification_close_button_color',
			'name' => esc_html__( 'Close Button Color', 'hashbar' ),
			'type' => 'colorpicker',
		) );

		$meta_box->add_field( array(
			'id'   => $prefix.'notification_close_button_hover_color',
			'name' => esc_html__( 'Close Button Hover Color', 'hashbar' ),
			'type' => 'colorpicker',
		) );

		$meta_box->add_field( array(
			'id'    => $prefix.'notification_close_button_hover_bg_color',
			'name'  => esc_html__( 'Close Button Hover BG Color', 'hashbar' ),
			'type'  => 'colorpicker',
		) );

		$meta_box->add_field( array(
			'id'   => $prefix.'notification_arrow_bg_color',
			'name' => esc_html__( 'Arrow Bg Color', 'hashbar' ),
			'type' => 'colorpicker',
		) );

		$meta_box->add_field( array(
			'id'   => $prefix.'notification_arrow_color',
			'name' => esc_html__( 'Arrow Color', 'hashbar' ),
			'type' => 'colorpicker',
		) );

		$meta_box->add_field( array(
			'id'   => $prefix.'notification_arrow_hover_color',
			'name' => esc_html__( 'Arrow Hover Color', 'hashbar' ),
			'type' => 'colorpicker',
		) );

		$meta_box->add_field( array(
			'id'   => $prefix.'notification_arrow_hover_bg_color',
			'name' => esc_html__( 'Arrow Hover Bg Color', 'hashbar' ),
			'type' => 'colorpicker',
		) );
		
	}
}
