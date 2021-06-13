<?php
/**
 * The template for displaying all single posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package 99fy
 */
?>

<div class="blog-details-style">
    <div class="blog-part">
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
</div>