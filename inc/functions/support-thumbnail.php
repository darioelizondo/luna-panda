<?php

/**
 * Function: Support thumbnail
 * 
 * @package Darío Elizondo
 * 
 */

add_action( 'init', 'support_thumbnail' );

function support_thumbnail() {
	add_theme_support( 'post-thumbnails' );
}