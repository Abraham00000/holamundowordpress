<?php
/**
 * The template for displaying all single posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package 99fy
 */

$layout = get_option('nnfy_blog_layout', 'none');

$content_class = ($layout == 'left' || $layout == 'right') ? 'ht-col-md-12 ht-col-lg-8 ht-col-xs-12' : 'ht-col-lg-12 ht-col-xs-12';

get_header(); 

	
?>
<div class="page-wrapper clear">
	<div class="ht-container">
		<div class="ht-row">
			<?php
				if( $layout == 'left' ){
					echo '<div class="ht-col-md-12 ht-col-lg-4 ht-col-xs-12 '.apply_filters( 'nnfy_sidebar_sticky_class', ' ' ).'">';

					get_sidebar();

					echo '</div>';
				}
			?>
			<div class="<?php echo esc_attr( $content_class ); ?>">
				<?php
					while ( have_posts() ) : the_post();
						get_template_part( 'template-parts/formats/content-single', get_post_format() );
						// If comments are open or we have at least one comment, load up the comment template.
						if ( comments_open() || get_comments_number() ) :
							comments_template();
						endif;
					endwhile; // End of the loop.
			    ?>
		     </div>
		     <?php
		     	if( $layout == 'right' ){
		     		echo '<div class="ht-col-md-12 ht-col-xs-12 ht-col-lg-4 ht-col-md-12 '.apply_filters( 'nnfy_sidebar_sticky_class', ' ' ).'">';

		     		get_sidebar();

		     		echo '</div>';
		     	}
		    ?>
		</div><!-- row -->
	</div><!-- container -->
</div><!--page-wrapper -->
<?php
get_footer();