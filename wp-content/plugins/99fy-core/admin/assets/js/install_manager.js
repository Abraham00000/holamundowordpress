;(function($) {
"use strict";

    /*
    * Plugin Installation Manager
    */
    var NNfytemplataPluginManager = {

        init: function(){
            $( document ).on('click','.install-now', NNfytemplataPluginManager.installNow );
            $( document ).on('click','.activate-now', NNfytemplataPluginManager.activatePlugin);
            $( document ).on('wp-plugin-install-success', NNfytemplataPluginManager.installingSuccess);
            $( document ).on('wp-plugin-install-error', NNfytemplataPluginManager.installingError);
            $( document ).on('wp-plugin-installing', NNfytemplataPluginManager.installingProcess);
        },

        /**
         * Installation Error.
         */
        installingError: function( e, response ) {
            e.preventDefault();
            var $card = $( '.htwptemplata-plugin-' + response.slug );
            $button = $card.find( '.button' );
            $button.removeClass( 'button-primary' ).addClass( 'disabled' ).html( wp.updates.l10n.installFailedShort );
        },

        /**
         * Installing Process
         */
        installingProcess: function(e, args){
            e.preventDefault();
            var $card = $( '.htwptemplata-plugin-' + args.slug ),
                $button = $card.find( '.button' );
                $button.text( NNFYTM.buttontxt.installing ).addClass( 'updating-message' );
        },

        /**
        * Plugin Install Now
        */
        installNow: function(e){
            e.preventDefault();

            var $button = $( e.target ),
                $plugindata = $button.data('pluginopt');

            if ( $button.hasClass( 'updating-message' ) || $button.hasClass( 'button-disabled' ) ) {
                return;
            }
            if ( wp.updates.shouldRequestFilesystemCredentials && ! wp.updates.ajaxLocked ) {
                wp.updates.requestFilesystemCredentials( e );
                $( document ).on( 'credential-modal-cancel', function() {
                    var $message = $( '.install-now.updating-message' );
                    $message.removeClass( 'updating-message' ).text( wp.updates.l10n.installNow );
                    wp.a11y.speak( wp.updates.l10n.updateCancel, 'polite' );
                });
            }
            wp.updates.installPlugin( {
                slug: $plugindata['slug']
            });

        },

        /**
         * After Plugin Install success
         */
        installingSuccess: function( e, response ) {
            var $message = $( '.htwptemplata-plugin-' + response.slug ).find( '.button' );

            var $plugindata = $message.data('pluginopt');

            $message.removeClass( 'install-now installed button-disabled updated-message' )
                .addClass( 'updating-message' )
                .html( NNFYTM.buttontxt.activating );

            setTimeout( function() {
                $.ajax( {
                    url: NNFYTM.ajaxurl,
                    type: 'POST',
                    data: {
                        action   : 'nnfytmp_ajax_plugin_activation',
                        location : $plugindata['location'],
                    },
                } ).done( function( result ) {
                    if ( result.success ) {
                        $message.removeClass( 'button-primary install-now activate-now updating-message' )
                            .attr( 'disabled', 'disabled' )
                            .addClass( 'disabled' )
                            .text( NNFYTM.buttontxt.active );

                    } else {
                        $message.removeClass( 'updating-message' );
                    }

                });

            }, 1200 );

        },

        /**
         * Plugin Activate
         */
        activatePlugin: function( e, response ) {
            e.preventDefault();

            var $button = $( e.target ),
                $plugindata = $button.data('pluginopt');

            if ( $button.hasClass( 'updating-message' ) || $button.hasClass( 'button-disabled' ) ) {
                return;
            }

            $button.addClass( 'updating-message button-primary' ).html( NNFYTM.buttontxt.activating );

            $.ajax( {
                url: NNFYTM.ajaxurl,
                type: 'POST',
                data: {
                    action   : 'nnfytmp_ajax_plugin_activation',
                    location : $plugindata['location'],
                },
            }).done( function( response ) {
                if ( response.success ) {
                    $button.removeClass( 'button-primary install-now activate-now updating-message' )
                        .attr( 'disabled', 'disabled' )
                        .addClass( 'disabled' )
                        .text( NNFYTM.buttontxt.active );
                }
            });

        },

        
    };

    /*
    * Theme Installation Manager
    */
    var NNfytemplataThemeManager = {

        init: function(){
            $( document ).on('click','.themeinstall-now', NNfytemplataThemeManager.installNow );
            $( document ).on('click','.themeactivate-now', NNfytemplataThemeManager.activateTheme);
            $( document ).on('wp-theme-install-success', NNfytemplataThemeManager.installingSuccess);
            $( document ).on('wp-theme-install-error', NNfytemplataThemeManager.installingError);
            $( document ).on('wp-theme-installing', NNfytemplataThemeManager.installingProcess);
        },

        /**
         * Installation Error.
         */
        installingError: function( e, response ) {
            e.preventDefault();
            var $card = $( '.htwptemplata-theme-' + response.slug );
            $button = $card.find( '.button' );
            $button.removeClass( 'button-primary' ).addClass( 'disabled' ).html( wp.updates.l10n.installFailedShort );
        },

        /**
         * Installing Process
         */
        installingProcess: function(e, args){
            e.preventDefault();
            var $card = $( '.htwptemplata-theme-' + args.slug ),
                $button = $card.find( '.button' );
                $button.text( NNFYTM.buttontxt.installing ).addClass( 'updating-message' );
        },

        /**
        * Theme Install Now
        */
        installNow: function(e){
            e.preventDefault();

            var $button = $( e.target ),
                $themedata = $button.data('themeopt');

            if ( $button.hasClass( 'updating-message' ) || $button.hasClass( 'button-disabled' ) ) {
                return;
            }
            if ( wp.updates.shouldRequestFilesystemCredentials && ! wp.updates.ajaxLocked ) {
                wp.updates.requestFilesystemCredentials( e );
                $( document ).on( 'credential-modal-cancel', function() {
                    var $message = $( '.themeinstall-now.updating-message' );
                    $message.removeClass( 'updating-message' ).text( wp.updates.l10n.installNow );
                    wp.a11y.speak( wp.updates.l10n.updateCancel, 'polite' );
                });
            }
            wp.updates.installTheme( {
                slug: $themedata['slug']
            });

        },

        /**
         * After Theme Install success
         */
        installingSuccess: function( e, response ) {
            var $message = $( '.htwptemplata-theme-' + response.slug ).find( '.button' );

            var $themedata = $message.data('themeopt');

            $message.removeClass( 'install-now installed button-disabled updated-message' )
                .addClass( 'updating-message' )
                .html( NNFYTM.buttontxt.activating );

            setTimeout( function() {
                $.ajax( {
                    url: NNFYTM.ajaxurl,
                    type: 'POST',
                    data: {
                        action   : 'nnfytmp_ajax_theme_activation',
                        themeslug : $themedata['slug'],
                    },
                } ).done( function( result ) {
                    if ( result.success ) {
                        $message.removeClass( 'button-primary install-now activate-now updating-message' )
                            .attr( 'disabled', 'disabled' )
                            .addClass( 'disabled' )
                            .text( NNFYTM.buttontxt.active );

                    } else {
                        $message.removeClass( 'updating-message' );
                    }

                });

            }, 1200 );

        },

        /**
         * Theme Activate
         */
        activateTheme: function( e, response ) {
            e.preventDefault();

            var $button = $( e.target ),
                $themedata = $button.data('themeopt');

            if ( $button.hasClass( 'updating-message' ) || $button.hasClass( 'button-disabled' ) ) {
                return;
            }

            $button.addClass( 'updating-message button-primary' ).html( NNFYTM.buttontxt.activating );

            $.ajax( {
                url: NNFYTM.ajaxurl,
                type: 'POST',
                data: {
                    action   : 'nnfytmp_ajax_theme_activation',
                    themeslug : $themedata['slug'],
                },
            }).done( function( response ) {
                if ( response.success ) {
                    $button.removeClass( 'button-primary install-now activate-now updating-message' )
                        .attr( 'disabled', 'disabled' )
                        .addClass( 'disabled' )
                        .text( NNFYTM.buttontxt.active );
                }
            });

        },

        
    };

    /**
     * Initialize NNfytemplataPluginManager
     */
    $( document ).ready( function() {
        NNfytemplataPluginManager.init();
        NNfytemplataThemeManager.init();
    });

})(jQuery);