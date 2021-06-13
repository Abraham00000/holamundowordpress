<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package 99fy
 */

$footer_top = $footer_copyright = false;
$footer_copywright_brand_custom = false;

if( function_exists('nnfy_get_option') ){
    $footer_top = nnfy_get_option( 'nnfy_footer_top_status', get_the_ID(), false );
    $footer_copyright = nnfy_get_option( 'nnfy_footer_copyright_status', get_the_ID(), false );
}

if ( nnfy_has_pro() ){

    $footer_brand = get_option( 'nnfy_footer_copyright_brand');

    $footer_copyright_brand = ( $footer_brand ? $footer_brand : esc_html__('Built with 99fy by HasThemes', '99fy' ));

    $footer_copyright_text = get_option( 'nnfy_footer_copyright_text', sprintf( __( 'Copyright &copy; %1$s %2$s All Right Reserved','99fy'), date('Y'), '99fy' ) ).' | '.$footer_copyright_brand;
}else{
    
    $url = sprintf('<a href="%1$s">%2$s</a>', esc_url('https://hasthemes.com/woocommerce-themes/99fy-pro/'), esc_html__( 'Built with 99fy by HasThemes', '99fy' ) );

    $footer_copyright_text = get_option( 'nnfy_footer_copyright_text', sprintf( __( 'Copyright &copy; %1$s %2$s All Right Reserved.','99fy'), date('Y'), '99fy' ) ).' | '.$url;
}


?>

</div><!-- #content -->

<?php
    if(
        $footer_top && (
        is_active_sidebar( 'sidebar-2' ) ||
        is_active_sidebar( 'sidebar-3' ) ||
        is_active_sidebar( 'sidebar-4' ) ||
        is_active_sidebar( 'sidebar-5' ) ||
        is_active_sidebar( 'sidebar-6' ) )
    ){
        $footer_top = true;
    } else {
        $footer_top = false;
    }

    if( $footer_top ):

        $footer_col_size = get_option( 'nnfy_footer_col_size', 4 );

?>
<div class="footer-top-area black-bg pt-120 pb-75">
    <div class="ht-container">
        <div class="ht-row">

            <?php
                $j = 1;
                for($i = 1; $i <= $footer_col_size; $i++):
                    $j++;
                    switch ($footer_col_size) {
                        case '1':
                             $col_class = 'ht-col-lg-12 ht-col-xs-12';
                            break;

                        case '2':
                             $col_class = 'ht-col-sm-6 ht-col-lg-6 ht-col-xs-12';
                            break;

                        case '3':
                             $col_class = 'ht-col-sm-6 ht-col-lg-4 ht-col-xs-12';
                            break;

                        case '5':
                             $col_class = ($i == 1 || $i == 5) ? 'ht-col-sm-6 ht-col-lg-3 ht-col-xs-12' : 'ht-col-sm-6 ht-col-lg-2 ht-col-xs-12';
                            break;
                        
                        default:
                            $col_class = 'ht-col-sm-6 ht-col-md-6 ht-col-lg-3 ht-col-xs-12';
                            break;
                    }
            ?>

            <div class="<?php echo esc_attr($col_class); ?>">
                <div class="footer-widget mb-40">
                    <?php dynamic_sidebar( 'sidebar-'.$j ); ?>
                </div>
            </div>

            <?php endfor; ?>
        </div>
    </div>
</div>
<?php endif; ?>

<?php if($footer_copyright && $footer_copyright_text): ?>

<div class="footer-bottom-area black-bg-2 ptb-15">
    <div class="ht-container">
        <div class="ht-row">
            <div class="ht-col-lg-12 ht-col-xs-12">
                <div class="copyright ht-text-center">
                    <?php 
                        echo wp_kses_post( $footer_copyright_text ); 
                    ?>
                </div>
            </div>
        </div>
    </div>
</div>

<?php endif; ?>

<div id="back-to-top"><i class="ion-arrow-up-c"></i></div>

</div><!-- #page -->
</div>

<?php wp_footer(); ?>

</body>
</html>