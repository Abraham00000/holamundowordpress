<?php

if ( !class_exists('htinstagram_default_widgets') ) {
	class htinstagram_default_widgets extends WP_Widget{

		function __construct(){

			$widget_options = array(
				'description' 					=> esc_html__('WP Instagram', 'ht-instagram'), 
				'customize_selective_refresh' 	=> true,
			);

			parent:: __construct('htinstagram_default_widgets', esc_html__( 'HT : WP Instagram', 'ht-instagram'), $widget_options );

		}
		/**
		 * Front-end display of widget.
		 *
		 * @see WP_Widget::widget()
		 *
		 * @param array $args     Widget arguments.
		 * @param array $instance Saved values from database.
		 */
		public function widget($args, $instance){ 

			$title 			= isset( $instance['title'] ) ? $instance['title'] : '';
			$limit 			= isset( $instance['limit'] ) ? (int)$instance['limit'] : 8;
			$delete_cache 	= isset( $instance['delete_cache'] ) ? $instance['delete_cache'] : 'no';
			$cache_time 	= isset( $instance['cache_time'] ) ? $instance['cache_time'] : 'week';
			$column 		= isset( $instance['column'] ) ? $instance['column'] : 4;
			$space 			= isset( $instance['space'] ) ? $instance['space'] : 5;
			$showcaption 	= isset( $instance['showcaption'] ) ? $instance['showcaption'] : '';
			$showfollowbtn 	= isset( $instance['showfollowbtn'] ) ? $instance['showfollowbtn'] : '';
			$followbtnpos 	= isset( $instance['followbtnpos'] ) ? $instance['followbtnpos'] : '';
			$target 		= isset( $instance['target'] ) ? $instance['target'] : '';
			
			// Options Value
			$likecommentbg 		= htinstagram_get_option( 'likecommentbg', 'htinstagram_widgets_style_tabs' );
			$commentlike_color 	= htinstagram_get_option( 'commentlike_color', 'htinstagram_widgets_style_tabs' );
			$commentlike_font_size = htinstagram_get_option( 'commentlike_font_size', 'htinstagram_widgets_style_tabs' );
			$follow_background 	= htinstagram_get_option( 'follow_background', 'htinstagram_widgets_style_tabs' );
			$follow_buttoncolor = htinstagram_get_option( 'follow_buttoncolor', 'htinstagram_widgets_style_tabs' );
			$follow_button_f_s 	= htinstagram_get_option( 'follow_button_f_s', 'htinstagram_widgets_style_tabs' );
			$follow_icon_color	= htinstagram_get_option( 'follow_icon_color', 'htinstagram_widgets_style_tabs' );
			$follow_icon_background = htinstagram_get_option( 'follow_icon_background', 'htinstagram_widgets_style_tabs' );

			// Slider Options value
			$slider_on = htinstagram_get_option( 'slider_on', 'htinstagram_widgets_style_tabs' );
			$slarrows = htinstagram_get_option( 'slarrows', 'htinstagram_widgets_style_tabs' );
			$sldots = htinstagram_get_option( 'sldots', 'htinstagram_widgets_style_tabs' );
			$slautolay = htinstagram_get_option( 'slautolay', 'htinstagram_widgets_style_tabs' );
			$slautoplay_speed = htinstagram_get_option( 'slautoplay_speed', 'htinstagram_widgets_style_tabs' );
			$slanimation_speed = htinstagram_get_option( 'slanimation_speed', 'htinstagram_widgets_style_tabs' );
			$slcentermode = htinstagram_get_option( 'slcentermode', 'htinstagram_widgets_style_tabs' );
			$slcenterpadding = htinstagram_get_option( 'slcenterpadding', 'htinstagram_widgets_style_tabs' );
			$slitems = htinstagram_get_option( 'slitems', 'htinstagram_widgets_style_tabs' );
			$slrows = htinstagram_get_option( 'slrows', 'htinstagram_widgets_style_tabs' );
			$sltablet_display_columns = htinstagram_get_option( 'sltablet_display_columns', 'htinstagram_widgets_style_tabs' );
			$slmobile_display_columns = htinstagram_get_option( 'slmobile_display_columns', 'htinstagram_widgets_style_tabs' );

			$uniqid = 'htinstragram_form_default_widget_'.$limit.$column;

			$shortcode_atts = [
				'id'=>'id="'.$uniqid.'"',
	            'limit' => 'limit="'.$limit.'"',
	            'column' => 'column="'.$column.'"',
	            'delete_cache' => 'delete_cache="'.$delete_cache.'"',
	            'cache_time' => 'cache_time="'.$cache_time.'"',
	            'space' => 'space="'.$space.'"',
	            'showcaption' => 'showcaption="'.$showcaption.'"',
	            'caption_pos' => 'caption_pos="top"',
	            'showfollowbtn' => 'showfollowbtn="'.$showfollowbtn.'"',
	            'followbtnpos' => 'followbtnpos="'.$followbtnpos.'"',
	            'target' => 'target="'.$target.'"',

	            'slider_on' => 'slider_on="'.( $slider_on == 'on' ? 'yes' : 'no' ).'"',
	            'slarrows' => 'slarrows="'.( $slarrows == 'on' ? 'yes' : 'no' ).'"',
	            'slprevicon' => 'slprevicon="fa fa-angle-left"',
	            'slnexticon' => 'slnexticon="fa fa-angle-right"',
	            'sldots' => 'sldots="'.( $sldots == 'on' ? 'yes' : 'no' ).'"',
	            'slautolay' => 'slautolay="'.( $slautolay == 'on' ? 'yes' : 'no' ).'"',
	            'slautoplay_speed' => 'slautoplay_speed="'.$slautoplay_speed.'"',
	            'slanimation_speed' => 'slanimation_speed="'.$slanimation_speed.'"',
	            'slcentermode' => 'slcentermode="'.( $slcentermode == 'on' ? 'yes' : 'no' ).'"',
	            'slcenterpadding' => 'slcenterpadding="'.$slcenterpadding.'"',
	            'slitems' => 'slitems="'.( $slitems <= 0 ? 4 : $slitems ).'"',
	            'slrows' => 'slrows="'.( $slrows <= 0 ? 1 : $slrows ).'"',
	            'slscroll_columns' => 'slscroll_columns="1"',
	            'sltablet_width' => 'sltablet_width="750"',
	            'sltablet_display_columns' => 'sltablet_display_columns="'.( $sltablet_display_columns <= 0 ? 1 : $sltablet_display_columns).'"',
	            'sltablet_scroll_columns' => 'sltablet_scroll_columns="1"',
	            'slmobile_width' => 'slmobile_width="480"',
	            'slmobile_display_columns' => 'slmobile_display_columns="'.( $slmobile_display_columns <= 0 ? 1 : $slmobile_display_columns ).'"',
	            'slmobile_scroll_columns' => 'slmobile_scroll_columns="1"',

	            'captionbg' => 'captionbg="'.$likecommentbg.'"',
	            'caption_color' => 'caption_color="'.$commentlike_color.'"',
	            'caption_font_size' => 'caption_font_size="'.( $commentlike_font_size <= 0 ? 14 : $commentlike_font_size ).'"',
	            'follow_background' => 'follow_background="'.$follow_background.'"',
	            'follow_buttoncolor' => 'follow_buttoncolor="'.$follow_buttoncolor.'"',
	            'follow_button_f_s' => 'follow_button_f_s="'.( $follow_button_f_s <= 0 ? 14 : $follow_button_f_s).'"',
	            'follow_icon_color' => 'follow_icon_color="'.$follow_icon_color.'"',
	            'follow_icon_background' => 'follow_icon_background="'.$follow_icon_background.'"',
	        ];

	        // Render Html
			echo $args['before_widget'];
		        if ( !empty( $title ) ) { echo $args['before_title'] . esc_html( $title ) . $args['after_title']; }
        	?>
    			<div class="htinsta-widgets">
    				<?php echo do_shortcode( sprintf( '[htinstagram %s]', implode(' ', $shortcode_atts ) ) ); ?>
    			</div>
	        <?php echo $args['after_widget']; 
		}


		/**
		 * Sanitize widget form values as they are saved.
		 *
		 * @see WP_Widget::update()
		 *
		 * @param array $new_instance Values just sent to be saved.
		 * @param array $old_instance Previously saved values from database.
		 *
		 * @return array Updated safe values to be saved.
		 */

		public function update( $new_instance, $old_instance ) {
			$instance = $old_instance;	
			$instance['title'] 			=  strip_tags($new_instance['title']);
			$instance['limit'] 			=  $new_instance['limit'];
			$instance['delete_cache'] 	=  $new_instance['delete_cache'];
			$instance['cache_time'] 	=  $new_instance['cache_time'];
			$instance['column'] 		=  $new_instance['column'];
			$instance['space'] 			=  $new_instance['space'];									
			$instance['showcaption'] 	=  $new_instance['showcaption'];									
			$instance['showfollowbtn'] 	=  $new_instance['showfollowbtn'];									
			$instance['followbtnpos'] 	=  $new_instance['followbtnpos'];									
			$instance['target'] 		=  $new_instance['target'];									
			return $instance;
		}

		/**
		 * Back-end widget form.
		 *
		 * @see WP_Widget::form()
		 *
		 * @param array $instance Previously saved values from database.
		 */

		public function form( $instance ){ 

			$array_default = array(
				'title'			=> 'HT Instagram'
				,'limit' 		=> 8
				,'delete_cache' => 'no'
				,'cache_time' 	=> 'week'
				,'column' 		=> 4
				,'space' 		=> 5
				,'showcaption' 	=> 'no'
				,'showfollowbtn'=> 'yes'
				,'followbtnpos'=> 'bottom'
				,'target' 		=> '_self'
			);
			$instance = wp_parse_args( (array) $instance, $array_default );

			?>

			<p>
				<label for="<?php echo $this->get_field_id('title'); ?>"><?php esc_html_e('Enter your title', 'ht-instagram'); ?> </label>
				<input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr($instance['title']); ?>" />
			</p>
			<p>
				<label for="<?php echo esc_attr($this->get_field_id('limit')); ?>"><?php echo esc_html__('Item Limit:' ,'ht-instagram') ?></label>
				<input id="<?php echo esc_attr($this->get_field_id('limit')); ?>" name="<?php echo esc_attr($this->get_field_name('limit')); ?>" type="number" class="widefat" value="<?php echo esc_attr($instance['limit']); ?>">
			</p>

			<p>
				<label for="<?php echo $this->get_field_id('delete_cache'); ?>"><?php esc_html_e('Delete Cache', 'ht-instagram'); ?> </label>
				<select class="widefat" id="<?php echo $this->get_field_id('delete_cache'); ?>" name="<?php echo $this->get_field_name('delete_cache'); ?>" >
					<option value="yes" <?php selected($instance['delete_cache'], 'yes'); ?> ><?php esc_html_e('Yes','ht-instagram');?></option>
					<option value="no" <?php selected($instance['delete_cache'], 'no'); ?> ><?php esc_html_e('No','ht-instagram');?></option>
				</select>
			</p>

			<p>
				<label for="<?php echo $this->get_field_id('cache_time'); ?>"><?php esc_html_e('Cache Time', 'ht-instagram'); ?> </label>
				<select class="widefat" id="<?php echo $this->get_field_id('cache_time'); ?>" name="<?php echo $this->get_field_name('cache_time'); ?>" >
					<option value="minute" <?php selected($instance['cache_time'], 'minute'); ?> ><?php esc_html_e('One Minute','ht-instagram');?></option>
					<option value="hour" <?php selected($instance['cache_time'], 'hour'); ?> ><?php esc_html_e('One hour','ht-instagram');?></option>
					<option value="day" <?php selected($instance['cache_time'], 'day'); ?> ><?php esc_html_e('One day','ht-instagram');?></option>
					<option value="week" <?php selected($instance['cache_time'], 'week'); ?> ><?php esc_html_e('One week','ht-instagram');?></option>
					<option value="month" <?php selected($instance['cache_time'], 'month'); ?> ><?php esc_html_e('One month','ht-instagram');?></option>
					<option value="year" <?php selected($instance['cache_time'], 'year'); ?> ><?php esc_html_e('One year','ht-instagram');?></option>
				</select>
			</p>

			<p>
				<label for="<?php echo $this->get_field_id('column'); ?>"><?php esc_html_e('Column', 'ht-instagram'); ?> </label>
				<select class="widefat" id="<?php echo $this->get_field_id('column'); ?>" name="<?php echo $this->get_field_name('column'); ?>" >
					<?php for( $i = 1; $i <= 6; $i++ ): ?>
					<option value="<?php echo $i; ?>" <?php selected($instance['column'], $i); ?> ><?php echo $i; ?></option>
					<?php endfor; ?>
				</select>
			</p>

			<p>
				<label for="<?php echo esc_attr($this->get_field_id('space')); ?>"><?php echo esc_html__('Item Space:' ,'ht-instagram') ?></label>
				<input id="<?php echo esc_attr($this->get_field_id('space')); ?>" name="<?php echo esc_attr($this->get_field_name('space')); ?>" type="number" class="widefat" value="<?php echo esc_attr($instance['space']); ?>">
			</p>

			<p>
				<label for="<?php echo $this->get_field_id('showcaption'); ?>"><?php esc_html_e('Show Caption', 'ht-instagram'); ?> </label>
				<select class="widefat" id="<?php echo $this->get_field_id('showcaption'); ?>" name="<?php echo $this->get_field_name('showcaption'); ?>" >
					<option value="yes" <?php selected($instance['showcaption'], 'yes'); ?> ><?php esc_html_e('Yes','ht-instagram');?></option>
					<option value="no" <?php selected($instance['showcaption'], 'no'); ?> ><?php esc_html_e('No','ht-instagram');?></option>
				</select>
			</p>
			<p>
				<label for="<?php echo $this->get_field_id('showfollowbtn'); ?>"><?php esc_html_e('Show Follow Button', 'ht-instagram'); ?> </label>
				<select class="widefat" id="<?php echo $this->get_field_id('showfollowbtn'); ?>" name="<?php echo $this->get_field_name('showfollowbtn'); ?>" >
					<option value="yes" <?php selected($instance['showfollowbtn'], 'yes'); ?> ><?php esc_html_e('Yes','ht-instagram');?></option>
					<option value="no" <?php selected($instance['showfollowbtn'], 'no'); ?> ><?php esc_html_e('No','ht-instagram');?></option>
				</select>
			</p>
			<p>
				<label for="<?php echo $this->get_field_id('followbtnpos'); ?>"><?php esc_html_e('Follow Button Position', 'ht-instagram'); ?> </label>
				<select class="widefat" id="<?php echo $this->get_field_id('followbtnpos'); ?>" name="<?php echo $this->get_field_name('followbtnpos'); ?>" >
					<option value="top" <?php selected($instance['followbtnpos'], 'top'); ?> ><?php esc_html_e('Top','ht-instagram');?></option>
					<option value="middle" <?php selected($instance['followbtnpos'], 'middle'); ?> ><?php esc_html_e('Middle','ht-instagram');?></option>
					<option value="bottom" <?php selected($instance['followbtnpos'], 'bottom'); ?> ><?php esc_html_e('Bottom','ht-instagram');?></option>
				</select>
			</p>
			<p>
				<label for="<?php echo $this->get_field_id('target'); ?>"><?php esc_html_e('Target', 'ht-instagram'); ?> </label>
				<select class="widefat" id="<?php echo $this->get_field_id('target'); ?>" name="<?php echo $this->get_field_name('target'); ?>" >
					<option value="_self" <?php selected($instance['target'], '_self'); ?> >Current window</option>
					<option value="_blank" <?php selected($instance['target'], '_blank'); ?> >New window</option>
				</select>
			</p>

		<?php }

	} // end extends class
} // end exists class


// Register Author information widget.

function htinstagram_default_widgets() {
    register_widget( 'htinstagram_default_widgets' );
}
add_action( 'widgets_init', 'htinstagram_default_widgets' );