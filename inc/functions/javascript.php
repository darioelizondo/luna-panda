<?php

    /**
     * Function: Javascript
     * 
     * @package Darío Elizondo
     * 
     */

    add_action( 'wp_enqueue_scripts', 'lunapanda_javascript', 20 );

    function lunapanda_javascript() {

        // App
        wp_enqueue_script( 'lunapanda.app', TDU . '/assets/javascript/production/app.js', array( 'jquery' ), filemtime( TD . '/assets/javascript/production/app.js' ), true );
        wp_localize_script('lunapanda.app', 'DE_PROJECTS', [
            'ajaxUrl' => admin_url('admin-ajax.php'),
            'nonce'   => wp_create_nonce('de_projects_filter'),
        ]);

    }