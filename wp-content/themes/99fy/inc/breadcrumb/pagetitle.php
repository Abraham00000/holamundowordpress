<?php
    $breadcrumb_layout = function_exists( 'nnfy_get_option' ) ? nnfy_get_option( 'nnfy_breadcrumb_layout', get_the_ID(), 'default' ) : '';
	$bg_image = get_option('nnfy_page_title_bgimage');
	$bg_color = get_option( 'nnfy_page_title_bgcolor','#ddd' );
    $bg_size = get_option( 'nnfy_page_title_bg_image_size', 'cover' );
	$space = function_exists( 'nnfy_get_option' ) ? nnfy_get_option( 'nnfy_page_title_space', get_the_ID(), '20px' ) : '';

    // Page background value
    $pcolor = function_exists( 'nnfy_get_elementor_option' ) ? nnfy_get_elementor_option( 'nnfy_title_area_bg_color', get_the_ID() ) : '';
    $pimage = function_exists( 'nnfy_get_elementor_option' ) ? nnfy_get_elementor_option( 'nnfy_title_area_bg_image', get_the_ID() ): '';
    $pposition = function_exists( 'nnfy_get_elementor_option' ) ? nnfy_get_elementor_option( 'nnfy_title_area_bg_position', get_the_ID() ) : '';
    $pattachment = function_exists( 'nnfy_get_elementor_option' ) ? nnfy_get_elementor_option( 'nnfy_title_area_bg_attachment', get_the_ID() ) : '';
    $prepeat = function_exists( 'nnfy_get_elementor_option' ) ? nnfy_get_elementor_option( 'nnfy_title_area_bg_repeat', get_the_ID() ) : '';
    $psize = function_exists( 'nnfy_get_elementor_option' ) ? nnfy_get_elementor_option( 'nnfy_title_area_bg_size', get_the_ID() ) : '';
    if( !empty( $pcolor ) || !empty( $pimage['url'] ) ){
        $css = ( !empty( $pimage['url'] ) ? 'background-image:url('.$pimage['url'].');' : '' ).
            ( !empty( $pcolor ) ? 'background-color:'.$pcolor.';' : '' ).
            ( !empty( $pposition ) ? 'background-position:'.$pposition.';' : '' ).
            ( !empty( $pattachment ) ? 'background-attachment:'.$pattachment.';' : '' ).
            ( !empty( $prepeat ) ? 'background-repeat:'.$prepeat.';' : '' ).
            ( !empty( $psize ) ? 'background-size:'.$psize.';' : '' );

    }else{
	   $css = "background:url(". esc_url( $bg_image ) .") no-repeat center/$bg_size $bg_color;";
    }
    if( $space ){ $css .= "padding: $space 0;"; }

    //Custom title postion
    $title_custom_pos = get_option( 'nnfy_page_title_custom_postion', 'no' );
    $x_pos = get_option( 'nnfy_page_title_x_position','0' ).'px';
    $y_pos = get_option( 'nnfy_page_title_y_position','0' ).'px';
    $csspos = "transform: translate( {$x_pos}, {$y_pos} );";

?>
<div class="<?php echo 'page_title_area-'.get_the_ID(); ?> breadcrumb-area pt-20 pb-20 breadcrumb-style-<?php echo esc_attr( $breadcrumb_layout ); ?>" style="<?php echo esc_html( $css ); ?>">
    <div class="ht-container">
        <div class="breadcrumb-content ht-text-center" style="<?php if( $title_custom_pos == 'yes' ){ echo "display: inline-block; $csspos"; } ?>">
        	
        	<?php
                if( $page_title_status ){
                    echo '<h2>';
                		if( function_exists('is_woocommerce') ){
                			if(is_woocommerce()){
                				woocommerce_page_title();
                			} else {
                				wp_title('');
                			}
                		} else {
                			wp_title('');
                		}
                    echo '</h2>';
                }
        	
	            if( $breadcrumb_status ){
					if( function_exists('is_woocommerce') ){
                        if( is_woocommerce() ){
                            woocommerce_breadcrumb();
                        } else {
                            nnfy_breadcrumbs();
                        }
                    } else {
                        nnfy_breadcrumbs();
                    }
	            }
            ?>
        </div>
    </div>
</div>