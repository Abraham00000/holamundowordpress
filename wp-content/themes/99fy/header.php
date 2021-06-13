<?php
/**
 * The header for our theme
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package 99fy
 */

$page_title_status = function_exists( 'nnfy_get_option' ) ? nnfy_get_option( 'nnfy_page_title_status', get_the_ID(), false ) : 1;
$breadcrumb_status = function_exists( 'nnfy_get_option' ) ? nnfy_get_option( 'nnfy_breadcrumb_status', get_the_ID(), false ) : 1;

?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="profile" href="http://gmpg.org/xfn/11">

<?php wp_head(); ?>

</head>

<body <?php body_class(); ?>>
	<?php wp_body_open(); ?>
	<div id="page" class="site site-wrapper">
		<div id="nnfy">
			<?php
				get_template_part('inc/header/header-top-bar');
				get_template_part('inc/header/default');
				
				if( !is_front_page() && ( $page_title_status || $breadcrumb_status ) ){
					include get_template_directory().'/inc/breadcrumb/pagetitle.php';
				}
			?>

		<div id="content" class="site-content">