<?php

 if ( ! class_exists( 'WooCommerce' ) ) return;

 add_theme_support( 'woocommerce' );


 // remove actions
 add_action( 'init', 'nnfy_wc_remove_actions' );
 function nnfy_wc_remove_actions(){
 	remove_action( 'woocommerce_before_main_content', 'woocommerce_breadcrumb', 20 );
 	remove_action( 'woocommerce_before_shop_loop', 'woocommerce_output_all_notices', 10 );
 	remove_action( 'woocommerce_before_shop_loop', 'wc_print_notices', 10 );

 	//content product
 	remove_action( 'woocommerce_before_shop_loop_item', 'woocommerce_template_loop_product_link_open', 10 );

 	remove_action( 'woocommerce_before_shop_loop_item_title', 'woocommerce_show_product_loop_sale_flash', 10 );
 	remove_action( 'woocommerce_before_shop_loop_item_title', 'woocommerce_template_loop_product_thumbnail', 10 );

 	remove_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_product_link_close', 5 );
 	remove_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_add_to_cart', 10 );

 	remove_action( 'woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_rating', 5 );

 	// cart page
 	remove_action( 'woocommerce_cart_collaterals', 'woocommerce_cart_totals', 10 );

 }


 // add actions
 add_action( 'init', 'nnfy_wc_add_actions' );
 function nnfy_wc_add_actions(){

 	//content product
 	add_action( 'woocommerce_shop_loop_item_title', 'woocommerce_template_loop_product_link_open',5 );
 	add_action( 'woocommerce_shop_loop_item_title', 'woocommerce_template_loop_product_link_close',15 );

 	add_action( 'woocommerce_before_shop_loop_item_title', 'nnfy_woocommerce_template_loop_product_thumbnail',10 );
 	add_action( 'woocommerce_before_shop_loop_item_title', 'nnfy_woocommerce_template_loop_product_content_list',15 );

 	// cart page
 	add_action( 'woocommerce_after_cart_table', 'woocommerce_cart_totals', 10 );
 }


// archive product
add_action( 'woocommerce_before_shop_loop', 'nnfy_before_shop_loop_left_wrapper_start', 15);
function nnfy_before_shop_loop_left_wrapper_start(){
	echo '<div class="shop-bar pb-30"><div class="shop-found-selector">';
}

add_action( 'woocommerce_before_shop_loop', 'nnfy_before_shop_loop_left_wrapper_end', 35);
function nnfy_before_shop_loop_left_wrapper_end(){
	echo "</div><!-- ./shop-found-selector -->";
}

add_action( 'woocommerce_before_shop_loop', 'nnfy_archive_view_switch', 40 );
function nnfy_archive_view_switch(){
	?>
	<div class="shop-filter-tab">
        <div class="shop-tab nav" role="tablist">
            <a class="active" href="#grid_view" data-toggle="grid_view">
                <i class="ion-android-apps"></i>
            </a>
            <a href="#list_view" data-toggle="list_view">
                <i class="ion-android-menu"></i>
            </a>
        </div>
    </div>
</div> <!-- close div shop bar area -->
	<?php
}


// custom wishlist button
function nnfy_add_to_wishlist_button() {
	global $product;

	$output = '';

	if( class_exists('WishSuite_Base') ){

        $button_args = [
            'btn_text' => '<i class="sli sli-heart"></i>',
            'btn_added_text' => '<i class="sli sli-check"></i>',
            'btn_exist_text' => '<i class="fa fa-heart"></i>',
        ];
        
        add_filter( 'wishsuite_button_arg', function( $button_arg ) use ( $button_args ) {

            $button_arg['button_text'] = $button_args['btn_text'];
            $button_arg['button_added_text'] = $button_args['btn_added_text'];
            $button_arg['button_exist_text'] = $button_args['btn_exist_text'];

            return $button_arg;
        }, 90, 1 );
		
		$output .= '<div class="action-same yith-wcwl-add-to-wishlist">'.do_shortcode('[wishsuite_button]').'</div>';
		return $output;


	}elseif( class_exists( 'YITH_WCWL' ) && !empty( get_option( 'yith_wcwl_wishlist_page_id' ) ) ){

		global $yith_wcwl;

		$url          = YITH_WCWL()->get_wishlist_url();
		$product_type = $product->get_type();
		$exists       = $yith_wcwl->is_product_in_wishlist( $product->get_id() );
		$classes      = 'class="add_to_wishlist"';
		$add          = get_option( 'yith_wcwl_add_to_wishlist_text' );
		$browse       = get_option( 'yith_wcwl_browse_wishlist_text' );
		$added        = get_option( 'yith_wcwl_product_added_text' );

		$output = '';

		$output  .= '<div class="action-same yith-wcwl-add-to-wishlist add-to-wishlist-' . esc_attr( $product->get_id() ) . '">';
			$output .= '<div class="yith-wcwl-add-button';
				$output .= $exists ? ' hide" style="display:none;"' : ' show"';
				$output .= '><a href="' . esc_url( htmlspecialchars( YITH_WCWL()->get_wishlist_url() ) ) . '" data-product-id="' . esc_attr( $product->get_id() ) . '" data-product-type="' . esc_attr( $product_type ) . '" ' . $classes . ' ><i class="ion-ios-heart-outline"></i></a>';
				$output .= '<i class="fa fa-spinner fa-pulse ajax-loading" style="visibility:hidden"></i>';
			$output .= '</div>';

			$output .= '<div class="yith-wcwl-wishlistaddedbrowse hide" style="display:none;"><a class="" href="' . esc_url( $url ) . '"><i class="ion-ios-heart"></i></a></div>';
			$output .= '<div class="yith-wcwl-wishlistexistsbrowse ' . ( $exists ? 'show' : 'hide' ) . '" style="display:' . ( $exists ? 'block' : 'none' ) . '"><a href="' . esc_url( $url ) . '" class=""><i class="ion-ios-heart"></i></a></div>';
		$output .= '</div>';

		return $output;

	}else{
        return;
    }

}


// format price html
add_filter( 'woocommerce_format_sale_price', 'nnfy_format_sale_price', '', 4 );
function nnfy_format_sale_price($price, $regular_price, $sale_price){
	$price = '<span class="new">' . ( is_numeric( $sale_price ) ? wc_price( $sale_price ) : $sale_price ) . '</span> <span class="old"><del>' . ( is_numeric( $regular_price ) ? wc_price( $regular_price ) : $regular_price ) . '</del></span>';

	return $price;
}

// customize rating html
add_filter( 'woocommerce_product_get_rating_html', 'nnfy_wc_get_rating_html', '', 3 );
function nnfy_wc_get_rating_html($html, $rating, $count){
	global $product;

	if ( $rating > 0) {
		$rating_whole = floor($rating);
		$rating_fraction = $rating - $rating_whole;
		$review_count = $product->get_review_count();

		$wrapper_class = is_single() ? 'rating-number' : 'top-rated-rating';
		ob_start();
	?>
	<div class="<?php echo esc_attr( $wrapper_class ); ?>">
	    <div class="quick-view-rating">
	    	<?php for($i = 1; $i <= 5; $i++){
				if($i <= $rating_whole){
					echo '<i class="ion-ios-star red-star"></i>';
				} else {
					if($rating_fraction){
						echo '<i class="ion-android-star-half"></i>';
					} else {
						echo '<i class="ion-android-star-outline"></i>';
					}
				}
	    	} ?>
	    </div>

	</div>

	 <?php
		$html = ob_get_clean();
	} else {
		$html  = '';
	}

	return $html;
}


// wishlist button on single product
add_action( 'woocommerce_after_add_to_cart_button', 'nnfy_wishlist_button_after_add_to_cart');
function nnfy_wishlist_button_after_add_to_cart(){
	echo '<div class="nnfyquickview-btn-wishlist">';
		if(function_exists('nnfy_add_to_wishlist_button')){
			echo nnfy_add_to_wishlist_button();
		}
	echo '</div>';
}


function nnfy_woocommerce_template_loop_product_thumbnail(){
	global $product;
	?>
	<div class="product-img">
		<a href="<?php the_permalink(); ?>">
		    <?php woocommerce_template_loop_product_thumbnail(); ?>
		</a>

        <div class="product-action">
            <div class="product-action-style">
				<?php woocommerce_template_loop_add_to_cart(); ?>
				
                <a class="action-eye nnfyquickview" title="Quick View" data-toggle="modal" data-target="#exampleModal" data-quick-id="<?php the_ID(); ?>" href="<?php the_permalink(); ?>">
                	<i class="ion-ios-eye-outline"></i>
                </a>
               
                <?php
                	if(function_exists('nnfy_add_to_wishlist_button')){
                		echo nnfy_add_to_wishlist_button();
                	}
                ?>
            </div>
        </div>

		<?php
			$attributes = $product->get_attributes();
			if($attributes) :
		?>

		<div class="product-size-color-wrapper">
			
		<?php
			foreach( $attributes as $item ):

				if( isset( $item['name'] ) ):

					$name = $item->get_name();

					$values = wc_get_product_terms( $product->get_id(), $name, array( 'fields' => 'all' ) );

					if( $item['name'] == 'pa_size'):
					?>

					<div class="product-size">
						<?php
							if( $values ){
								foreach ($values as $item) {
									echo '<span>'.$item->name.' </span>';
								}
							}
						?>
					</div>

					<?php elseif($item['name'] == 'pa_color'): ?>
						<div class="product-color">
							<ul>
								<?php
									if($values){
										foreach ($values as $item) {
											$product_term_name = esc_html( $item->name );
	                                        $link = get_term_link( $item->term_id, $name );
	                                        $color = get_term_meta( $item->term_id, 'color', true );
	                                        if( !empty($link) ){
												echo '<a href="'.esc_url( $link ).'"><li style="'.( !empty( $color ) ? 'background-color:'.$color : '' ).'" class="'.strtolower($product_term_name).'">'.esc_html($product_term_name).'</li></a>';
	                                        }else{
	                                        	echo '<li style="'.( !empty( $color ) ? 'background-color:'.$color : '' ).'" class="'.strtolower($product_term_name).'">'.esc_html($product_term_name).'</li>';
	                                        }
										}
									}
								?>
							</ul>
						</div>
			<?php
					endif;
				endif;
			endforeach;
			?>
		</div>
		<?php endif; ?>

	</div>
	<?php
}


function nnfy_woocommerce_template_loop_product_content_list(){
	?>
	<div class="product-content-list">
	    <div class="product-list-info">
	        <h4>
	            <a href="<?php the_permalink( ) ?>"><?php the_title(); ?></a>
	        </h4>
	        <span><?php woocommerce_template_loop_price(); ?></span>
	        <?php woocommerce_template_single_excerpt(); ?>
	    </div>
	    <div class="product-list-cart-wishlist">
	        <div class="product-list-cart">
	            <?php woocommerce_template_loop_add_to_cart(); ?>
	        </div>

	        <?php if(function_exists('nnfy_add_to_wishlist_button')): ?>
	        <div class="product-list-wishlist">
	            <?php echo nnfy_add_to_wishlist_button(); ?>
	        </div>
	    	<?php endif; ?>
	    </div>
	</div>
	<?php
}

// nnfyquickview ajax
add_action( 'wp_ajax_nnfy_product_nnfyquickview', 'nnfy_product_nnfyquickview' );
add_action( 'wp_ajax_nopriv_nnfy_product_nnfyquickview', 'nnfy_product_nnfyquickview' );
function nnfy_product_nnfyquickview() {
	$product_id = (int) $_POST['data'];

	$params = array('p' => $product_id,'post_type' => array('product','product_variation'));
	$query = new WP_Query($params);
	if($query->have_posts()){
		while ($query->have_posts()){
			$query->the_post();

			include get_template_directory().'/woocommerce/content-quickview.php';
		}
	}
	wp_reset_postdata();
	die();
}


add_action( 'woocommerce_before_add_to_cart_quantity', 'nnfy_product_variation_image' );
function nnfy_product_variation_image() {
	global $product;
	if ( $product->is_type('variable') ) {
	    ?>
	    <script>
	      	;jQuery(document).ready(function($) {
		      	$('.variations .loop .value select').on('change', function(){
		            if( '' != $('input.variation_id').val() ) {
			            var var_id = $('input.variation_id').val();
			            $( '.nnfy-tab-pane' ).removeClass('nnfyactive');
			            $( '.nnfyfirstthumb' ).addClass('nnfyactive');
			        }
		      	});         
	      	});
	    </script>
	    <?php
	}
    
}