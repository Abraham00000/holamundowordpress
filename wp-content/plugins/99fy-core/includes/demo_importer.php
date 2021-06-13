<?php

add_action( 'admin_head', 'nnfy_remove_ocdi_notice' );
function nnfy_remove_ocdi_notice(){
  ?>
  <style type="text/css">
    .ocdi .notice-info{
      display: none !important;
    }
    .ocdi__gl-item[data-name="comingsoon"]{
      display: none !important;
    }
  </style>
  <?php
}

function nnfy_import_files() {

  return array(

    array(
      'import_file_name'             => 'Standard Demo',
      'local_import_file'            => NNFY_PL_PATH . 'includes/demo-content/standard-demo/99fy.xml',
      'local_import_widget_file'     => NNFY_PL_PATH . 'includes/demo-content/standard-demo/99fy.wie',
      'local_import_customizer_file' => NNFY_PL_PATH . 'includes/demo-content/standard-demo/99fy.dat',
      'import_preview_image_url'     => NNFY_PL_URL . 'includes/demo-content/standard-demo/screenshot.png',
    ),
    
    array(
      'import_file_name'             => '99Fy Animal',
      'local_import_file'            => NNFY_PL_PATH . 'includes/demo-content/animal/all-content.xml',
      'local_import_widget_file'     => NNFY_PL_PATH . 'includes/demo-content/animal/widgets.wie',
      'local_import_customizer_file' => NNFY_PL_PATH . 'includes/demo-content/animal/customizer.dat',
      'import_preview_image_url'     => NNFY_PL_URL . 'includes/demo-content/animal/animal.jpg',
    ),

    array(
      'import_file_name'             => '99Fy Book',
      'local_import_file'            => NNFY_PL_PATH . 'includes/demo-content/book/all-content.xml',
      'local_import_widget_file'     => NNFY_PL_PATH . 'includes/demo-content/book/widgets.wie',
      'local_import_customizer_file' => NNFY_PL_PATH . 'includes/demo-content/book/customizer.dat',
      'import_preview_image_url'     => NNFY_PL_URL . 'includes/demo-content/book/book.jpg',
    ),

    array(
      'import_file_name'             => '99Fy Car & Motors',
      'local_import_file'            => NNFY_PL_PATH . 'includes/demo-content/carmotors/all-content.xml',
      'local_import_widget_file'     => NNFY_PL_PATH . 'includes/demo-content/carmotors/widgets.wie',
      'local_import_customizer_file' => NNFY_PL_PATH . 'includes/demo-content/carmotors/customizer.dat',
      'import_preview_image_url'     => NNFY_PL_URL . 'includes/demo-content/carmotors/carmotors.jpg',
    ),

    array(
      'import_file_name'             => '99Fy Cosmetic',
      'local_import_file'            => NNFY_PL_PATH . 'includes/demo-content/cosmetic/all-content.xml',
      'local_import_widget_file'     => NNFY_PL_PATH . 'includes/demo-content/cosmetic/widgets.wie',
      'local_import_customizer_file' => NNFY_PL_PATH . 'includes/demo-content/cosmetic/customizer.dat',
      'import_preview_image_url'     => NNFY_PL_URL . 'includes/demo-content/cosmetic/cosmetic.jpg',
    ),

    array(
      'import_file_name'             => '99Fy Electronics',
      'local_import_file'            => NNFY_PL_PATH . 'includes/demo-content/electronics/all-content.xml',
      'local_import_widget_file'     => NNFY_PL_PATH . 'includes/demo-content/electronics/widgets.wie',
      'local_import_customizer_file' => NNFY_PL_PATH . 'includes/demo-content/electronics/customizer.dat',
      'import_preview_image_url'     => NNFY_PL_URL . 'includes/demo-content/electronics/electronics.jpg',
    ),

    array(
      'import_file_name'             => '99Fy Fashion',
      'local_import_file'            => NNFY_PL_PATH . 'includes/demo-content/fashion/all-content.xml',
      'local_import_widget_file'     => NNFY_PL_PATH . 'includes/demo-content/fashion/widgets.wie',
      'local_import_customizer_file' => NNFY_PL_PATH . 'includes/demo-content/fashion/customizer.dat',
      'import_preview_image_url'     => NNFY_PL_URL . 'includes/demo-content/fashion/fashion.jpg',
    ),

    array(
      'import_file_name'             => '99Fy Flowers',
      'local_import_file'            => NNFY_PL_PATH . 'includes/demo-content/flowers/all-content.xml',
      'local_import_widget_file'     => NNFY_PL_PATH . 'includes/demo-content/flowers/widgets.wie',
      'local_import_customizer_file' => NNFY_PL_PATH . 'includes/demo-content/flowers/customizer.dat',
      'import_preview_image_url'     => NNFY_PL_URL . 'includes/demo-content/flowers/flowers.jpg',
    ),

    array(
      'import_file_name'             => '99Fy Food',
      'local_import_file'            => NNFY_PL_PATH . 'includes/demo-content/food/all-content.xml',
      'local_import_widget_file'     => NNFY_PL_PATH . 'includes/demo-content/food/widgets.wie',
      'local_import_customizer_file' => NNFY_PL_PATH . 'includes/demo-content/food/customizer.dat',
      'import_preview_image_url'     => NNFY_PL_URL . 'includes/demo-content/food/food.jpg',
    ),

    array(
      'import_file_name'             => '99Fy Fruits',
      'local_import_file'            => NNFY_PL_PATH . 'includes/demo-content/fruits/all-content.xml',
      'local_import_widget_file'     => NNFY_PL_PATH . 'includes/demo-content/fruits/widgets.wie',
      'local_import_customizer_file' => NNFY_PL_PATH . 'includes/demo-content/fruits/customizer.dat',
      'import_preview_image_url'     => NNFY_PL_URL . 'includes/demo-content/fruits/fruits.jpg',
    ),

    array(
      'import_file_name'             => '99Fy Furniture',
      'local_import_file'            => NNFY_PL_PATH . 'includes/demo-content/furniture/all-content.xml',
      'local_import_widget_file'     => NNFY_PL_PATH . 'includes/demo-content/furniture/widgets.wie',
      'local_import_customizer_file' => NNFY_PL_PATH . 'includes/demo-content/furniture/customizer.dat',
      'import_preview_image_url'     => NNFY_PL_URL . 'includes/demo-content/furniture/furniture.jpg',
    ),

    array(
      'import_file_name'             => '99Fy Handmade',
      'local_import_file'            => NNFY_PL_PATH . 'includes/demo-content/handmade/all-content.xml',
      'local_import_widget_file'     => NNFY_PL_PATH . 'includes/demo-content/handmade/widgets.wie',
      'local_import_customizer_file' => NNFY_PL_PATH . 'includes/demo-content/handmade/customizer.dat',
      'import_preview_image_url'     => NNFY_PL_URL . 'includes/demo-content/handmade/handmade.jpg',
    ),

    array(
      'import_file_name'             => '99Fy Health & Beauty',
      'local_import_file'            => NNFY_PL_PATH . 'includes/demo-content/healthbeauty/all-content.xml',
      'local_import_widget_file'     => NNFY_PL_PATH . 'includes/demo-content/healthbeauty/widgets.wie',
      'local_import_customizer_file' => NNFY_PL_PATH . 'includes/demo-content/healthbeauty/customizer.dat',
      'import_preview_image_url'     => NNFY_PL_URL . 'includes/demo-content/healthbeauty/healthbeauty.jpg',
    ),

    array(
      'import_file_name'             => '99Fy Jewelry',
      'local_import_file'            => NNFY_PL_PATH . 'includes/demo-content/jewelry/all-content.xml',
      'local_import_widget_file'     => NNFY_PL_PATH . 'includes/demo-content/jewelry/widgets.wie',
      'local_import_customizer_file' => NNFY_PL_PATH . 'includes/demo-content/jewelry/customizer.dat',
      'import_preview_image_url'     => NNFY_PL_URL . 'includes/demo-content/jewelry/jewelry.jpg',
    ),

    array(
      'import_file_name'             => '99Fy Kids',
      'local_import_file'            => NNFY_PL_PATH . 'includes/demo-content/kids/all-content.xml',
      'local_import_widget_file'     => NNFY_PL_PATH . 'includes/demo-content/kids/widgets.wie',
      'local_import_customizer_file' => NNFY_PL_PATH . 'includes/demo-content/kids/customizer.dat',
      'import_preview_image_url'     => NNFY_PL_URL . 'includes/demo-content/kids/kids.jpg',
    ),

    array(
      'import_file_name'             => '99Fy Kitchen',
      'local_import_file'            => NNFY_PL_PATH . 'includes/demo-content/kitchen/all-content.xml',
      'local_import_widget_file'     => NNFY_PL_PATH . 'includes/demo-content/kitchen/widgets.wie',
      'local_import_customizer_file' => NNFY_PL_PATH . 'includes/demo-content/kitchen/customizer.dat',
      'import_preview_image_url'     => NNFY_PL_URL . 'includes/demo-content/kitchen/kitchen.jpg',
    ),

    array(
      'import_file_name'             => '99Fy Matcha',
      'local_import_file'            => NNFY_PL_PATH . 'includes/demo-content/matcha/all-content.xml',
      'local_import_widget_file'     => NNFY_PL_PATH . 'includes/demo-content/matcha/widgets.wie',
      'local_import_customizer_file' => NNFY_PL_PATH . 'includes/demo-content/matcha/customizer.dat',
      'import_preview_image_url'     => NNFY_PL_URL . 'includes/demo-content/matcha/matcha.jpg',
    ),

    array(
      'import_file_name'             => '99Fy Maternity',
      'local_import_file'            => NNFY_PL_PATH . 'includes/demo-content/maternity/all-content.xml',
      'local_import_widget_file'     => NNFY_PL_PATH . 'includes/demo-content/maternity/widgets.wie',
      'local_import_customizer_file' => NNFY_PL_PATH . 'includes/demo-content/maternity/customizer.dat',
      'import_preview_image_url'     => NNFY_PL_URL . 'includes/demo-content/maternity/maternity.jpg',
    ),

    array(
      'import_file_name'             => '99Fy Minimal',
      'local_import_file'            => NNFY_PL_PATH . 'includes/demo-content/minimal/all-content.xml',
      'local_import_widget_file'     => NNFY_PL_PATH . 'includes/demo-content/minimal/widgets.wie',
      'local_import_customizer_file' => NNFY_PL_PATH . 'includes/demo-content/minimal/customizer.dat',
      'import_preview_image_url'     => NNFY_PL_URL . 'includes/demo-content/minimal/minimal.jpg',
    ),

    array(
      'import_file_name'             => '99Fy Perfume',
      'local_import_file'            => NNFY_PL_PATH . 'includes/demo-content/perfume/all-content.xml',
      'local_import_widget_file'     => NNFY_PL_PATH . 'includes/demo-content/perfume/widgets.wie',
      'local_import_customizer_file' => NNFY_PL_PATH . 'includes/demo-content/perfume/customizer.dat',
      'import_preview_image_url'     => NNFY_PL_URL . 'includes/demo-content/perfume/perfume.jpg',
    ),

    array(
      'import_file_name'             => '99Fy Plants & Nursery',
      'local_import_file'            => NNFY_PL_PATH . 'includes/demo-content/plantsnursery/all-content.xml',
      'local_import_widget_file'     => NNFY_PL_PATH . 'includes/demo-content/plantsnursery/widgets.wie',
      'local_import_customizer_file' => NNFY_PL_PATH . 'includes/demo-content/plantsnursery/customizer.dat',
      'import_preview_image_url'     => NNFY_PL_URL . 'includes/demo-content/plantsnursery/plantsnursery.jpg',
    ),

    array(
      'import_file_name'             => '99Fy Shapewear',
      'local_import_file'            => NNFY_PL_PATH . 'includes/demo-content/shapewear/all-content.xml',
      'local_import_widget_file'     => NNFY_PL_PATH . 'includes/demo-content/shapewear/widgets.wie',
      'local_import_customizer_file' => NNFY_PL_PATH . 'includes/demo-content/shapewear/customizer.dat',
      'import_preview_image_url'     => NNFY_PL_URL . 'includes/demo-content/shapewear/shapewear.jpg',
    ),

    array(
      'import_file_name'             => '99Fy Sports',
      'local_import_file'            => NNFY_PL_PATH . 'includes/demo-content/sports/all-content.xml',
      'local_import_widget_file'     => NNFY_PL_PATH . 'includes/demo-content/sports/widgets.wie',
      'local_import_customizer_file' => NNFY_PL_PATH . 'includes/demo-content/sports/customizer.dat',
      'import_preview_image_url'     => NNFY_PL_URL . 'includes/demo-content/sports/sports.jpg',
    ),

    array(
      'import_file_name'             => '99Fy Tools & Equipment',
      'local_import_file'            => NNFY_PL_PATH . 'includes/demo-content/toolsequipment/all-content.xml',
      'local_import_widget_file'     => NNFY_PL_PATH . 'includes/demo-content/toolsequipment/widgets.wie',
      'local_import_customizer_file' => NNFY_PL_PATH . 'includes/demo-content/toolsequipment/customizer.dat',
      'import_preview_image_url'     => NNFY_PL_URL . 'includes/demo-content/toolsequipment/toolsequipment.jpg',
    ),

    array(
      'import_file_name'             => '99Fy Watch',
      'local_import_file'            => NNFY_PL_PATH . 'includes/demo-content/watch/all-content.xml',
      'local_import_widget_file'     => NNFY_PL_PATH . 'includes/demo-content/watch/widgets.wie',
      'local_import_customizer_file' => NNFY_PL_PATH . 'includes/demo-content/watch/customizer.dat',
      'import_preview_image_url'     => NNFY_PL_URL . 'includes/demo-content/watch/watch.jpg',
    ),

    array(
      'import_file_name'           => 'ComingSoon',
      'local_import_file'            => NNFY_PL_PATH . 'includes/demo-content/99fy.xml',
      'local_import_widget_file'     => NNFY_PL_PATH . 'includes/demo-content/99fy.wie',
      'local_import_customizer_file' => NNFY_PL_PATH . 'includes/demo-content/99fy.dat',
      'import_preview_image_url'     => get_stylesheet_directory_uri().'/screenshot.png',
    )

  );

}
add_filter( 'pt-ocdi/import_files', 'nnfy_import_files' );

function nnfy_after_import_setup() {

    // Assign menus to their locations.
    $header_menu = get_term_by( 'name', 'Main Menu', 'nav_menu' );
    set_theme_mod( 'nav_menu_locations' , array( 
        'primary' => $header_menu->term_id,
      )
    );

    // Set home page
    $front_page_id = get_page_by_title( 'Home' );
    update_option( 'show_on_front', 'page' );
    update_option( 'page_on_front', $front_page_id->ID );

    // Set blog page
    $blog_page_id  = get_page_by_title( 'Blog' );
    update_option( 'page_for_posts', $blog_page_id->ID );

    // Set shop page
    $shop_page_id = get_page_by_title('shop');
    $shop_page_id = $shop_page_id ? $shop_page_id->ID : get_option( 'woocommerce_shop_page_id');
    update_option( 'woocommerce_shop_page_id', $shop_page_id);

    // Set cart page
    $cart_page_id = get_page_by_title('cart');
    $cart_page_id = $cart_page_id ? $cart_page_id->ID : get_option( 'woocommerce_cart_page_id');
    update_option( 'woocommerce_cart_page_id', $cart_page_id);

    // Set checkout page
    $checkout_page_id = get_page_by_title('checkout');
    $checkout_page_id = $checkout_page_id ? $checkout_page_id->ID : get_option( 'woocommerce_checkout_page_id');
    update_option( 'woocommerce_checkout_page_id', $checkout_page_id);

    // Set myaccount page
    $account_page_id = get_page_by_title('my account ');
    $account_page_id = $account_page_id ? $account_page_id->ID : get_option( 'woocommerce_myaccount_page_id');
    update_option( 'woocommerce_myaccount_page_id', $account_page_id);

    // Set wishlist page
    $wishlist_page_id = get_page_by_title('wishlist');
    $wishlist_page_id = $wishlist_page_id ? $wishlist_page_id->ID : get_option( 'yith_wcwl_wishlist_page_id');
    update_option( 'yith_wcwl_wishlist_page_id', $wishlist_page_id);
    
    flush_rewrite_rules();
}

add_action( 'pt-ocdi/after_import', 'nnfy_after_import_setup' );