<?php

    /**
     * Function: Custom Post Type: Projects
     * 
     * @package Darío Elizondo
     * 
     */

if ( ! defined('ABSPATH') ) exit;

add_action('init', function () {

  // CPT: Project
  register_post_type('project', [
    'labels' => [
      'name'               => __('Projects', 'your-textdomain'),
      'singular_name'      => __('Project', 'your-textdomain'),
      'add_new'            => __('Add Project', 'your-textdomain'),
      'add_new_item'       => __('Add New Project', 'your-textdomain'),
      'edit_item'          => __('Edit Project', 'your-textdomain'),
      'new_item'           => __('New Project', 'your-textdomain'),
      'view_item'          => __('View Project', 'your-textdomain'),
      'search_items'       => __('Search Projects', 'your-textdomain'),
      'not_found'          => __('No projects found', 'your-textdomain'),
      'not_found_in_trash' => __('No projects found in Trash', 'your-textdomain'),
    ],
    'public'              => true,
    'has_archive'         => true,
    'rewrite'             => ['slug' => 'projects'],
    'menu_icon'           => 'dashicons-portfolio',
    'show_in_rest'        => true, // útil si después querés endpoints
    'supports'            => ['title', 'thumbnail', 'editor', 'page-attributes'],
    // page-attributes => habilita "menu_order" (orden manual)
  ]);

  // Taxonomy: Project Category (para filtro)
  register_taxonomy('project_category', ['project'], [
    'labels' => [
      'name'          => __('Project Categories', 'your-textdomain'),
      'singular_name' => __('Project Category', 'your-textdomain'),
    ],
    'public'       => true,
    'hierarchical' => true,
    'show_in_rest' => true,
    'rewrite'      => ['slug' => 'project-category'],
  ]);

});
