<?php

    /**
     * Function: Javascript
     * 
     * @package Darío Elizondo
     * 
     */

    add_action( 'wp_enqueue_scripts', 'lunapanda_javascript' );

    function lunapanda_javascript() {

        // Libs
        // wp_register_script( 'animejs', TDU . '/assets/third/anime-js/anime.min.js', array( 'jquery' ), '3.2.2', true );
        // wp_register_script( 'swiper', TDU . '/assets/third/swiper/swiper-bundle.min.js', array( 'jquery' ), '11.2.2', true );
        // wp_register_script( 'aos', TDU . '/assets/third/aos/aos.js', array( 'jquery' ), '3.0.0', true );
        // wp_register_script( 'gsap', TDU . '/assets/third/gsap/gsap.min.js', array( 'jquery' ), '3.12.7', true );
        // wp_register_script( 'gsap.scrollTrigger', TDU . '/assets/third/gsap/ScrollTrigger.min.js', array( 'jquery' ), '3.12.7', true );

        // App
        // wp_enqueue_script( 'lunapanda.onload-page', TDU . '/assets/javascript/production/onload-page.js', array( 'jquery' ), filemtime( TD . '/assets/javascript/production/onload-page.js' ), true );
        // wp_register_script( 'lunapanda.menu', TDU . '/assets/javascript/production/menu.js', array( 'jquery' ), filemtime( TD . '/assets/javascript/production/menu.js' ), true );

    }