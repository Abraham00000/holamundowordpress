<?php

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

if ( class_exists( 'WP_Customize_Control' ) && ! class_exists( 'WP_Customize_Info_Control' ) ) {
    class WP_Customize_Info_Control extends WP_Customize_Control {
        
        public $type = 'info';

        /**
         * Enqueue scripts/styles.
         */
        public function enqueue() {
            wp_enqueue_style( 'nnfy-toggle-info-control-css', NNFY_ADMIN_ASSETS . 'css/customizer-info-control.css', array(), NNFY_VERSION );
        }

        /**
         * Render the control's content.
         */
        public function render_content(){
            ?>
                <div class="customize-control-info">
                    <span class="customize-control-title"><?php echo esc_html( $this->label ); ?></span>
                    <p class="customize-control-description"><?php echo wp_kses_post( $this->description['info_message'] ); ?></p>
                    <?php
                        if( isset(  $this->description['features_list'] ) && !empty( $this->description['features_list'] ) ){
                            echo '<ul class="features-list">';
                                foreach ( $this->description['features_list'] as $fekey => $feature ) {
                                    echo '<li><i class="dashicons dashicons-yes"></i>'.esc_html__( $feature ).'</li>';
                                }
                            echo '</ul>';
                        }
                    ?>
                </div>
            <?php
        }

    }
}