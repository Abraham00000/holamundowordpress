<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

/**
 * This is a customized version of https://github.com/soderlind/class-customizer-toggle-control
 */
if ( class_exists( 'WP_Customize_Control' ) && ! class_exists( 'WP_Customize_Toggleswitch_Control' ) ) {
	class WP_Customize_Toggleswitch_Control extends WP_Customize_Control {
		public $type = 'toggleswitch';

		/**
		 * Enqueue scripts/styles.
		 *
		 * @since 3.4.0
		 */
		public function enqueue() {
			wp_enqueue_style( 'nnfy-toggle-switch-control-css', NNFY_ADMIN_ASSETS . 'css/customizer-toggle-switch-control.css', array(), NNFY_VERSION );
			wp_enqueue_script( 'nnfy-toggle-switch-control-js', NNFY_ADMIN_ASSETS . 'js/customizer-toggle-switch-control.js', array( 'jquery' ), NNFY_VERSION, true );
		}

		/**
		 * Render the control's content.
		 *
		 * @author soderlind
		 * @version 1.2.0
		 */
		public function render_content() {
			?>
			<label>
				<div style="display:flex;flex-direction: row;justify-content: flex-start; align-items: center;">
					<span class="customize-control-title" style="flex: 2 0 0; vertical-align: middle; margin:10px 0;"><?php echo esc_html( $this->label ); ?></span>
					<input id="cb<?php echo $this->instance_number ?>" type="checkbox" class="tgl tgl-light" value="<?php echo esc_attr( $this->value() ); ?>" <?php $this->link(); checked( $this->value() ); ?> />
					<label for="cb<?php echo $this->instance_number ?>" class="tgl-btn"></label>
				</div>
				<?php if ( ! empty( $this->description ) ) : ?>
				<span class="description customize-control-description"><?php echo esc_html( $this->description ); ?></span>
				<?php endif; ?>
			</label>
			<?php
		}
	}
}