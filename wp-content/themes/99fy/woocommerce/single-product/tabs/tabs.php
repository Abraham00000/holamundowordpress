<?php
/**
 * Single Product tabs
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/tabs/tabs.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce/Templates
 * @version 3.8.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Filter tabs and allow third parties to add their own.
 *
 * Each tab is an array containing title, callback and priority.
 *
 * @see woocommerce_default_product_tabs()
 */
$product_tabs = apply_filters( 'woocommerce_product_tabs', array() );

if ( ! empty( $product_tabs ) ) : ?>

	<div class="product-description-review-area pb-120">
		<ul class="description-review-title">
			<?php $i = 0; foreach ( $product_tabs as $key => $product_tab ) : $i++; ?>
				<li><a href="#tab-<?php echo esc_attr( $key ); ?>" class="<?php echo esc_attr( $i == 1 ? 'nnfyactive' : '' ); ?>">
					<?php echo wp_kses_post( apply_filters( 'woocommerce_product_' . $key . '_tab_title', $product_tab['title'], $key ) ); ?>
					</a></li>
			<?php endforeach; ?>
		</ul>
		
		<div class="description-review-text">
		<?php $i = 0; foreach ( $product_tabs as $key => $product_tab ) :  $i++; ?>
			<div class="woocommerce-Tabs-panel woocommerce-Tabs-panel--<?php echo esc_attr( $key ); ?> panel entry-content wc-tab nnfy-tab-pane <?php echo esc_attr( $i == 1 ? 'nnfyactive' : '' ); ?>" id="tab-<?php echo esc_attr( $key ); ?>" aria-labelledby="tab-title-<?php echo esc_attr( $key ); ?>">
			<?php
				if ( isset( $product_tab['callback'] ) ) {
					call_user_func( $product_tab['callback'], $key, $product_tab );
				}
			?>
			</div>
		<?php endforeach; ?>
		</div>
	</div>

<?php endif; ?>
