<?php 
	
    /**
     * Function: Option Page
     * 
     * @package Darío Elizondo
     * 
     */ 

if ( function_exists( 'acf_add_options_page' ) ) {

	acf_add_options_page(
		array(
			'page_title' => 'Configuration',
			'menu_title' => 'Configuration',
			'menu_slug'  => 'site_options',
			'capability' => 'edit_posts',
			'position'   => '25',
			'icon_url'   => 'dashicons-list-view',
			'redirect'   =>  false,
			'post_id'    => 'options'
		)
	);

	acf_add_options_sub_page(
		array(
			'page_title'  => 'Configuration',
			'menu_title'  => 'Configuration',
			'parent_slug' => 'site_options',
			'menu_slug'   => 'site_options'
		)
	);
}
