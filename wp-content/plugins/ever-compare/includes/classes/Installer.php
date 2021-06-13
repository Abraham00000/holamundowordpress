<?php
namespace EverCompare;
/**
 * Installer class
 */
class Installer {

    /**
     * Run the installer
     *
     * @return void
     */
    public function run() {
        $this->add_version();
        $this->add_redirection_flag();
    }

    /**
     * Add time and version on DB
     */
    public function add_version() {
        $installed = get_option( 'evercompare_installed' );

        if ( ! $installed ) {
            update_option( 'evercompare_installed', time() );
        }

        update_option( 'evercompare_version', EVERCOMPARE_VERSION );
    }

    /**
     * [add_redirection_flag] redirection flug
     */
    public function add_redirection_flag(){
        add_option( 'evercompare_do_activation_redirect', true );
    }


}