<?php

if( !class_exists( 'HTinstagram_feed' )){

    class HTinstagram_feed{

         /**
         * [$_instance]
         * @var null
         */
        private static $_instance = null;

        /**
         * [instance] Initializes a singleton instance
         * @return [HTinstagram_feed]
         */
        public static function instance() {
            if ( is_null( self::$_instance ) ) {
                self::$_instance = new self();
            }
            return self::$_instance;
        }

        // Instagram Feed
        public function htinstagram_items_feed( $settings = array(), $id ){

            $access_token = htinstagram_get_option( 'instagram_access_token','htinstagram_general_tabs' );
            $access_token = !empty( $access_token ) ? $access_token : '';
            $limit        = !empty( $settings['limit'] ) ? $settings['limit'] : 8;

            $cache_duration = $this->get_cacheing_duration( $settings['cash_time_duration'] );
            $transient_var  = 'htfeed_instragram_data_' .$id.'_'.$limit;

            if( $settings['delete_cache'] === 'yes' ){
                delete_transient( $transient_var );
                $cache_duration = MINUTE_IN_SECONDS;
            }

            if( empty( $access_token ) ){
                echo '<p>'.esc_html__('Please enter your access token.','htmega-addons').'</p>';
                return;
            }

            if ( false === ( $items = get_transient( $transient_var ) ) ) {

                $url = 'https://graph.instagram.com/me/media?fields=id,caption,media_type,media_url,permalink,thumbnail_url,timestamp,username&limit=200&access_token='.esc_html($access_token);

                $response       = wp_remote_get( $url );
                $instagram_data = wp_remote_retrieve_body( $response );

                $instagram_data = json_decode( $instagram_data, true );
                
                if ( ! is_wp_error( $instagram_data ) && 200 == (int) wp_remote_retrieve_response_code( $response ) ) {
                    
                    if ( isset( $instagram_data['error']['message'] ) ) {
                        echo '<p>'.esc_html__('Incorrect access token specified.','htmega-addons').'</p>';
                    }

                    $items = array();
                    foreach ( $instagram_data['data'] as $data_item ) {
                        $item['id']         = $data_item['id'];
                        $item['media_type'] = $data_item['media_type'];
                        $item['src']        = $data_item['media_url'];
                        $item['username']   = $data_item['username'];
                        $item['link']       = $data_item['permalink'];
                        $item['timestamp']  = $data_item['timestamp'];
                        $item['caption']    = !empty( $data_item['caption'] ) ? $data_item['caption'] : '';
                        $items[]            = $item;
                    }
                    set_transient( $transient_var, $items, 1 * $cache_duration );

                }

            }
            return $items;

        }

        protected function get_cacheing_duration( $duration ){
            switch ( $duration ) {
                case 'minute':
                    $cache_duration = MINUTE_IN_SECONDS;
                    break;
                case 'hour':
                    $cache_duration = HOUR_IN_SECONDS;
                    break;
                case 'day':
                    $cache_duration = DAY_IN_SECONDS;
                    break;
                case 'week':
                    $cache_duration = WEEK_IN_SECONDS;
                    break;
                case 'month':
                    $cache_duration = MONTH_IN_SECONDS;
                    break;
                case 'year':
                    $cache_duration = YEAR_IN_SECONDS;
                    break;
                default:
                    $cache_duration = DAY_IN_SECONDS;
            }
            return $cache_duration;
        }


    }

}


?>