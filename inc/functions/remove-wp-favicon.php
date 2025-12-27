<?php 
	
    /**
     * Function: Remove WP Favicon
     * 
     * @package Darío Elizondo
     * 
     */ 

    
    remove_action( 'wp_head', 'wp_site_icon', 99 );