<?php

    /**
     * Menu Walker
     *
     * @package Dario Elizondo
     */

    class LunaPanda_Menu_Walker extends Walker_Nav_Menu {

        function start_el( &$output, $item, $depth = 0, $args = null, $id = 0 ) {

            // CSS class of the <li> element
            $classes = implode(" ", $item->classes);

            $output .= "<li class='" . esc_attr( $classes ) . "'>";

            // Determine if the item has children
            $has_children = !empty($args->walker->has_children);

            // Build the link
            $link_class = $has_children ? "menu__link menu__has-child" : "menu__link";
            $link_class_first_level = $has_children && $depth == 0 ? "menu__has-child--first-level" : "";

            if( isset( $slug ) && !empty( $slug ) ) {
                $output .= '<a class="' . esc_attr($link_class). ' ' . esc_attr($link_class_first_level) . '" href="' . esc_url($item->url) . '" data-title="' . esc_attr($item->title) . '" target="' . esc_attr($item->target) . '"  data-slug="' . esc_attr($slug) . '">';
            } else {
                $output .= '<a class="' . esc_attr($link_class). ' ' . esc_attr($link_class_first_level) . '" href="' . esc_url($item->url) . '" data-title="' . esc_attr($item->title) . '" target="' . esc_attr($item->target) . '">';
            }

            // Additional content if it is top level
            if ($depth == 0) {
                $output .= '<span class="menu__count"></span>';
            }

            // Link title
            $output .= '<span class="menu__link-title">' . esc_html($item->title) . '</span>';

            if( $has_children && $depth == 1 ) {
                $output .= '<span class="menu__plus-minus-toggle collapsed"></span>';
            }

            // Close tag <a>
            $output .= '</a>';
        }

        function start_lvl( &$output, $depth = 0, $args = null ) {
            
            // Submenu from first level
            if ($depth == 0) {
                $output .= '<div class="wrapper-submenu">';
                $output .= '<ul class="submenu submenu--first-level">';
            }
            
            if ($depth != 0) {
                $output .= '<ul class="submenu submenu--second-level">';
            }
            
            
        }

        function end_lvl( &$output, $depth = 0, $args = null ) {

            $output .= '</ul>';

            if ( $depth == 0 ) {
                $output .= '</div">';
            }
        }

        function end_el( &$output, $item, $depth = 0, $args = null ) {
            $output .= '</li>';
        }
    }