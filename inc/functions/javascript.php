<?php

    /**
     * Function: Javascript
     * 
     * @package Darío Elizondo
     * 
     */

    add_action( 'wp_enqueue_scripts', 'lunapanda_javascript' );

    function lunapanda_javascript() {

        // App
        wp_enqueue_script( 'lunapanda.app', TDU . '/assets/javascript/production/app.js', array( 'jquery' ), filemtime( TD . '/assets/javascript/production/app.js' ), true );

    }