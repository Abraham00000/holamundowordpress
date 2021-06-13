<div class="httemplates-templates-area">
    <div class="httemplate-row">

        <!-- PopUp Content Start -->
        <div id="httemplate-popup-area" style="display: none;">
            <div class="httemplate-popupcontent">
                <div class='htspinner'></div>
                <div class="htmessage" style="display: none;">
                    <p></p>
                    <span class="httemplate-edit"></span>
                </div>
                <div class="htpopupcontent">
                    <p><?php esc_html_e( 'Import template to your Library', 'htmega-menu' );?></p>
                    <span class="htimport-button-dynamic"></span>
                    <div class="htpageimportarea">
                        <p> <?php esc_html_e( 'Create a new page from this template', 'htmega-menu' ); ?></p>
                        <input id="htpagetitle" type="text" name="htpagetitle" placeholder="<?php echo esc_attr_x( 'Enter a Page Name', 'placeholder', 'htmega-menu' ); ?>">
                        <span class="htimport-button-dynamic-page"></span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Layout PopUp View -->
        <div id="httemplate-popup-prev" style="display: none;"></div>
        <!-- PopUp Content End -->

        <!-- Top banner area Start -->
        <div class="httemplate-top-banner-area">
            <div class="htbanner-content">
                <div class="htbanner-desc">
                    <h3><?php esc_html_e( 'HT Mega Menu Templates Library', 'htmega-menu' ); ?></h3>
                    <?php
                        $alltemplates = sizeof( HTMegaMenu_Template_Library::instance()->get_templates_info()['templates'] ) ? sizeof( HTMegaMenu_Template_Library::instance()->get_templates_info()['templates'] ) : 0;
                    ?>
                    <p><?php esc_html_e( $alltemplates, 'htmega-menu' ); esc_html_e( ' Templates', 'htmega-menu' ); ?></p>
                </div>
                <a href="https://hasthemes.com/ht-mega-menu-for-elementor-page-builder/" target="_blank"><?php esc_html_e( 'Buy HT Menu Pro Version', 'htmega-menu' );?></a>
            </div>
        </div>
        <!-- Top banner area end -->

        <?php if( HTMegaMenu_Template_Library::instance()->get_templates_info()['templates'] ): ?>
            
            <div class="htmega-topbar">
                <span id="htmegaclose">&larr; <?php esc_html_e( 'Back to Library', 'htmega-menu' ); ?></span>
                <h3 id="htmega-tmp-name"></h3>
            </div>

            <ul id="tp-grid" class="tp-grid">

                <?php foreach ( HTMegaMenu_Template_Library::instance()->get_templates_info()['templates'] as $httemplate ): 
                    
                    $allcat = explode( ' ', $httemplate['category'] );

                    $htimp_btn_atr = [
                        'templpateid' => $httemplate['id'],
                        'templpattitle' => $httemplate['title'],
                        'message' => esc_html__( 'Successfully '.$httemplate['title'].' has been imported.', 'htmega-menu' ),
                        'htbtnlibrary' => esc_html__( 'Import to Library', 'htmega-menu' ),
                        'htbtnpage' => esc_html__( 'Import to Page', 'htmega-menu' ),
                    ];

                ?>

                    <li data-pile="<?php echo esc_attr( implode( ' ', $allcat ) ); ?>">
                        <div class="htsingle-templates-laibrary">
                            <div class="httemplate-thumbnails">
                                <img src="<?php echo esc_url( $httemplate['thumbnail'] ); ?>" alt="<?php echo esc_attr( $httemplate['title'] ); ?>">
                                <div class="httemplate-action">
                                    <?php if( $httemplate['is_pro'] == 1 ): ?>
                                        <a href="https://hasthemes.com/ht-mega-menu-for-elementor-page-builder/" target="_blank">
                                            <?php esc_html_e( 'Buy Now', 'htmega-menu' ); ?>
                                        </a>
                                    <?php else:?>
                                        <a href="#" class="wltemplateimp" data-templpateopt='<?php echo wp_json_encode( $htimp_btn_atr );?>' >
                                            <?php esc_html_e( 'Import', 'htmega-menu' ); ?>
                                        </a>
                                    <?php endif; ?>
                                    <a href="#" class="wlpreview" data-preview="<?php echo esc_url( $httemplate['thumbnail'] );?>"><?php esc_html_e( 'Preview', 'htmega-menu' ); ?></a>
                                </div>
                            </div>
                            <div class="httemplate-content">
                                <h3><?php echo esc_html__( $httemplate['title'], 'htmega-menu' ); if( $httemplate['is_pro'] == 1 ){ echo ' <span>( '.esc_html__('Pro','htmega-menu').' )</span>'; } ?></h3>
                                <div class="httemplate-tags">
                                    <?php echo implode( ' / ', explode( ',', $httemplate['tags'] ) ); ?>
                                </div>
                            </div>
                        </div>
                    </li>

                <?php endforeach; ?>

            </ul>

            <script type="text/javascript">
                jQuery(document).ready(function($) {

                    $(function() {
                        var $grid = $( '#tp-grid' ),
                            $name = $( '#htmega-tmp-name' ),
                            $close = $( '#htmegaclose' ),
                            $loaderimg = '<?php echo HTMEGA_MENU_PL_URL . 'include/admin/assets/images/ajax-loader.gif'; ?>',
                            $loader = $( '<div class="htmega-loader"><span><img src="'+$loaderimg+'" alt="" /></span></div>' ).insertBefore( $grid ),
                            stapel = $grid.stapel( {
                                onLoad : function() {
                                    $loader.remove();
                                },
                                onBeforeOpen : function( pileName ) {
                                    $( '.htmega-topbar,.httemplate-action' ).css('display','flex');
                                    $( '.httemplate-content span' ).css('display','inline-block');
                                    $close.show();
                                    $name.html( pileName );
                                },
                                onAfterOpen : function( pileName ) {
                                    $close.show();
                                }
                            } );
                        $close.on( 'click', function() {
                            $close.hide();
                            $name.empty();
                            $( '.htmega-topbar,.httemplate-action,.httemplate-content span' ).css('display','none');
                            stapel.closePile();
                        } );
                    } );

                });
            </script>
        <?php endif; ?>

    </div>
</div>