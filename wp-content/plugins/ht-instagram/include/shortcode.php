<?php

    function htinstagram_shortcode( $atts ) {
        extract(shortcode_atts( array(
            'id'            => 'htinstragram_shortcode_one'
            ,'limit'         => 8
            ,'cash_time'    => MINUTE_IN_SECONDS
            ,'delete_cache' => 'no'
            ,'column'       => 4
            ,'space'        => 5
            ,'showcaption'  => 'no'
            ,'caption_pos'  => 'top'
            ,'showfollowbtn'=> 'yes'
            ,'followbtnpos' => 'bottom'
            ,'target'       => '_self'

            ,'slider_on'    => 'no'
            ,'slarrows'     => 'no'
            ,'slprevicon'   => 'fa fa-angle-left'
            ,'slnexticon'   => 'fa fa-angle-right'
            ,'sldots'       => 'no'
            ,'slautolay'    => 'yes'
            ,'slautoplay_speed'         => 3000
            ,'slanimation_speed'        => 300
            ,'slcentermode'             => 'no'
            ,'slcenterpadding'          => 0
            ,'slitems'                  => 4
            ,'slrows'                   => 2
            ,'slscroll_columns'         => 1
            ,'sltablet_width'           => 750
            ,'sltablet_display_columns' => 1
            ,'sltablet_scroll_columns'  => 1
            ,'slmobile_width'           => 480
            ,'slmobile_display_columns' => 1
            ,'slmobile_scroll_columns'  => 1

            ,'captionbg' => ''
            ,'caption_color' => ''
            ,'caption_font_size' => ''
            ,'follow_background' => ''
            ,'follow_buttoncolor' => ''
            ,'follow_button_f_s' => ''
            ,'follow_icon_color' => ''
            ,'follow_icon_background' => ''

        ), $atts ) );

        $settings = array(
            'limit'              => $limit,
            'cash_time_duration' => $cash_time,
            'delete_cache'       => $delete_cache,
        );

        $instaitem = HTinstagram_feed::instance()->htinstagram_items_feed( $settings, $id );
        $username      = !empty( $instaitem[0]['username'] ) ? $instaitem[0]['username'] : '';
        $profile_link  = !empty( $instaitem[0]['username'] ) ? 'https://www.instagram.com/'.$instaitem[0]['username'] : '#';

        $unique_class = uniqid('instragram_style_');
        $instaclass = array( $unique_class, 'htinsta-instragram', 'htinsta-column-'.$column, 'htinsta-comment-'.$caption_pos );

        $ulclass = array();
        $ulclass['class'] = 'htinstagram-list';
        if( $slider_on == 'yes' ){

            $ulclass['class'] = 'htinstagram-carousel';

            $slider_settings = [
                'arrows' => ( 'yes' === $slarrows ),
                'arrow_prev_txt' => '<i class="'.$slprevicon.'"></i>',
                'arrow_next_txt' => '<i class="'.$slnexticon.'"></i>',
                'dots' => ( 'yes' === $sldots ),
                'autoplay' => ( 'yes' === $slautolay ),
                'autoplay_speed' => absint( $slautoplay_speed ),
                'animation_speed' => absint( $slanimation_speed ),
                'center_mode' => ( 'yes' === $slcentermode ),
                'center_padding' => absint( $slcenterpadding ),
            ];

            $slider_responsive_settings = [
                'rows' => $slrows,
                'display_columns' => $slitems,
                'scroll_columns' => $slscroll_columns,
                'tablet_width' => $sltablet_width,
                'tablet_display_columns' => $sltablet_display_columns,
                'tablet_scroll_columns' => $sltablet_scroll_columns,
                'mobile_width' => $slmobile_width,
                'mobile_display_columns' => $slmobile_display_columns,
                'mobile_scroll_columns' => $slmobile_scroll_columns,
            ];

            $slider_settings = array_merge( $slider_settings, $slider_responsive_settings );
        }

        // Register CSS and JS
        if( $slider_on == 'yes' ){
            wp_enqueue_style('slick');
            wp_enqueue_script('ht-active');
        }

        ob_start();
        $output = '';
        // custom style
        $output .= '<style>';

        if( !empty( $captionbg ) ){
            $output .= ".$unique_class .instagram-like-comment{ background-color: {$captionbg}; }";
        }

        if( !empty( $caption_color ) ){
            $output .= ".$unique_class .instagram-like-comment p{ color: {$caption_color}; }";
        }

        if( !empty( $caption_font_size ) ){
            $output .= ".$unique_class .instagram-like-comment p{ font-size: {$caption_font_size}px; }";
        }

        if( !empty( $follow_background ) ){
            $output .= ".$unique_class a.instagram_follow_btn{ background-color: {$follow_background}; }";
        }

        if( !empty($follow_buttoncolor) ){
            $output .= ".$unique_class a.instagram_follow_btn{ color: {$follow_buttoncolor}; }";
        }

        if( !empty( $follow_button_f_s )){
            $output .= ".$unique_class a.instagram_follow_btn{ font-size: {$follow_button_f_s}px; }";
        }

        if( !empty( $follow_icon_color ) ){
            $output .= ".$unique_class a.instagram_follow_btn i{ color: {$follow_icon_color}; }";
        }

        if( !empty( $follow_icon_background ) ){
            $output .= ".$unique_class a.instagram_follow_btn i{ background-color: {$follow_icon_background}; }";
        }

        $output .= '</style>';

        ?>
            <div class="<?php echo implode(' ', $instaclass ); ?>" >
                <?php if ( isset( $instaitem ) && !empty($instaitem)) :?>

                    <?php if( $showfollowbtn == 'yes' && $followbtnpos == 'top' ): ?>
                        <a class="instagram_follow_btn <?php echo esc_attr( $followbtnpos );?>" href="<?php echo esc_url( $profile_link ); ?>" target="_blank">
                            <i class="fa fa-instagram"></i>
                            <span><?php echo esc_html__( 'Follow @ '.$username, 'ht-instagram' );?></span>
                        </a>
                    <?php endif;?>

                    <ul class="<?php echo esc_attr( $ulclass['class'] ); ?>" style="<?php if( $slider_on != 'yes' ){ echo 'margin: 0 -'.$space.'px'; } ?>" data-settings='<?php if( $slider_on == 'yes' ){ echo wp_json_encode( $slider_settings ); }else{echo 'no-opt'; } ?>'>
                        <?php
                            $countitem = 0;
                            foreach ( $instaitem as $item ):
                                $countitem++;
                                $items_link = $item['link'];
                        ?>
                            <li style="<?php echo 'padding: 0 '.$space.'px; margin-bottom: '.( $space*2 ).'px;';?>">
                                <div class="htinstagram_single_item">
                                    <a href="<?php echo esc_url( $items_link ); ?>" target="<?php echo esc_attr( $target );?>" >
                                        <img src="<?php echo esc_url( $item['src'] ); ?>" alt="<?php echo esc_html__( $item['username'], 'ht-instagram');?>">
                                    </a>
                                    
                                    <?php if( $showcaption == 'yes'  && !empty( $item['caption'] ) ) : ?>
                                        <div class="instagram-clip">
                                            <div class="htinstagram-content">
                                                <div class="instagram-like-comment">
                                                    <p><?php echo esc_html( $item['caption'] ); ?></p>
                                                </div>
                                            </div>
                                        </div>
                                    <?php endif;?>

                                </div>
                            </li>
                        <?php if( $countitem == $limit ){ break; } endforeach;?>
                    </ul>
                    <?php if( $showfollowbtn == 'yes' && ( $followbtnpos == 'bottom' || $followbtnpos == 'middle' ) ): ?>
                    <a class="instagram_follow_btn <?php echo esc_attr( $followbtnpos );?>" href="<?php echo esc_url( '' ); ?>" target="_blank">
                        <i class="fa fa-instagram"></i>
                        <span><?php echo esc_html__( 'Follow @ '.$username, 'ht-instagram' );?></span>
                    </a>
                <?php endif; else:?>
                    <p class="htinsta-error">
                        <?php 
                            esc_html_e( 'Instagram Feed Not found Please enter valid Access Token.','ht-instagram' );
                            echo wp_kses_post( '(<a href="'.esc_url( admin_url().'admin.php?page=htinstagram' ).'" target="_blank">Enter Access Token</a>)', 'ht-instagram' );
                        ?>
                    </p>
                <?php endif; ?>
            </div>
        <?php

        $output .= ob_get_clean();

        return $output;
    }
    add_shortcode( 'htinstagram', 'htinstagram_shortcode' );

?>