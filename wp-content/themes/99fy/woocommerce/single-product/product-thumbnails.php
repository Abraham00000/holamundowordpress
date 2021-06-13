<?php
/**
 * Single Product Thumbnails
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/product-thumbnails.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see 	    https://docs.woocommerce.com/document/template-structure/
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     3.5.1
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

global $post, $product;

?>

<ul class="product-details-small product-details-2">

<?php

$attachment_ids = $product->get_gallery_image_ids();

if ( $product->get_image_id() ){
    $attachment_ids = array( 'nnfythumbnails_id' => $product->get_image_id() ) + $attachment_ids;
}

if ( $attachment_ids && has_post_thumbnail() ) {
	$i = 0;
	foreach ( $attachment_ids as $imgkey => $attachment_id ) {
		$i++;

		$full_size_image = wp_get_attachment_image_src( $attachment_id, 'full' );
		$thumbnail       = wp_get_attachment_image_src( $attachment_id, 'woocommerce_thumbnail' );
		$attributes      = array(
			'title'                   => get_post_field( 'post_title', $attachment_id ),
			'data-caption'            => get_post_field( 'post_excerpt', $attachment_id ),
			'data-src'                => (isset($full_size_image[0]) ? $full_size_image[0] : ''),
			'data-large_image'        => (isset($full_size_image[0]) ? $full_size_image[0] : ''),
			'data-large_image_width'  => (isset($full_size_image[1]) ? $full_size_image[1] : ''),
			'data-large_image_height' => (isset($full_size_image[2]) ? $full_size_image[2] : ''),
		);

		$class = $i == 1 ? 'nnfyactive' : '';

		$html = ' <li><a class="'.$class.'" href="#pro-details'.( $imgkey === 'nnfythumbnails_id' ? $post->ID : $attachment_id ).'">';
 		$html .= wp_get_attachment_image( $attachment_id, 'nnfy_product_nav_thumb', false, $attributes );
 		$html .= '</a></li>';

		echo apply_filters( 'woocommerce_single_product_image_thumbnail_html', $html, $attachment_id );
	}
}

?>

</ul>
