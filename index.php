<?php

    /**
     * Index
     * 
     * @package Darío Elizondo
     * 
     */

    get_header();

    if( have_posts() ) : while( have_posts() ) : the_post();

        require TD . '/template-parts/modules/modules.php';
    
    endwhile;
    endif;

    get_footer();
