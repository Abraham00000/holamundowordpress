<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

if ( class_exists( 'WP_Customize_Control' ) && ! class_exists( 'WP_Customize_Separator_Control' ) ) {
    class WP_Customize_Separator_Control extends WP_Customize_Control {
        
        public $type = 'separator';

        /**
         * Enqueue scripts/styles.
         */
        public function enqueue() {
            wp_enqueue_style( 'nnfy-separator-control-css', NNFY_ADMIN_ASSETS . 'css/customizer-separator-control.css', array(), NNFY_VERSION );
        }

        /**
         * Render the control's content.
         */
        public function render_content(){
            ?>
                <hr/>
            <?php
        }

    }
}