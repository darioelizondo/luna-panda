<?php

    /**
     * Modules
     * 
     * @package Darío Elizondo
     * 
     */

    $module_count = 1;




    if ( have_rows( 'modules' ) ) : while ( have_rows( 'modules' ) ) : the_row( 'modules' );
     
        if ( get_row_layout() === 'hero' )                    require TD . '/template-parts/components/organisms/hero.php';
        if ( get_row_layout() === 'projects_home' )           require TD . '/template-parts/components/organisms/projects-home.php';
        if ( get_row_layout() === 'logos_carousel' )          require TD . '/template-parts/components/organisms/logos-carousel.php';
     
        $module_count++;
     
     endwhile;
     endif;

