<?php

    /**
     * Function: Menus
     * 
     * @package Darío Elizondo
     * 
     */

    add_action( 'init', 'lunapanda_add_menus' );

    function lunapanda_add_menus() {
        register_nav_menus( array(
            'main_menu'         => __( 'Main Menu' ),
            'main_menu_footer'  => __( 'Footer Menu' ),
        ) );
    }