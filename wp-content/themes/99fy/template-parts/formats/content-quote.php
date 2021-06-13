<?php
/**
 * Template part for displaying posts
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package 99fy
 */

$blog_col_size  = get_option( 'nnfy_blog_col_size', 3 );

for($i = 1; $i <= $blog_col_size; $i++){

    switch ($blog_col_size) {
        case '1':
            $col_class = 'ht-col-xs-12 ht-col-lg-12';
            break;

        case '2':
            $col_class = 'ht-col-xs-12 ht-col-sm-6 ht-col-lg-6';
            break;

        case '4':
            $col_class = 'ht-col-xs-12 ht-col-sm-6 ht-col-lg-3';
            break;
        
        default:
            $col_class = 'ht-col-xs-12 ht-col-sm-6 ht-col-lg-4';
            break;
    }
 }
?>


<div class="<?php echo esc_attr($col_class); ?>">
	<article id="post-<?php the_ID(); ?>" <?php post_class('blog-post'); ?>>
	    <div class="product-wrapper mb-30">
            <?php 
                $quote_cite = get_post_meta( get_the_ID(), 'nnfy_city_text', true );
                if( $quote_cite ){
                    echo '<div class="nnfy_quote"><blockquote>';
                        the_content();
                        echo '<footer><cite>';
                            echo esc_html( $quote_cite );
                        echo '</cite></footer>';
                    echo '</blockquote></div>';
                }
            ?>
	    </div>
	</article>
</div>
