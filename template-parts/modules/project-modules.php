<?php
    /**
     * 
     * Project modules
     * @package Darío Elizondo
     * 
     */

    if (!defined('ABSPATH')) exit;

    require_once TD . '/inc/functions/layout-control.php';

    ?>

    <section class="project-single__content">
        <div class="project-single__inner container">

            <?php
            
                $module_count = 1;
                if ( have_rows( 'project_modules' ) ) : while ( have_rows( 'project_modules' ) ) : the_row( 'project_modules' );
                        $layout = get_row_layout();

                        // Args
                        $args = [
                            'layout' => $layout,
                        ];

                        if ( $layout === 'text_block' ) {            get_template_part('template-parts/components/atoms/text-block', null, $args); }
                        if ( $layout === 'image_block' ) {           get_template_part('template-parts/components/atoms/image-block', null, $args); }
                        if ( $layout === 'slider_block' ) {          get_template_part('template-parts/components/atoms/slider-block', null, $args); }

                        $module_count++;
            
                    endwhile;
                endif;

            ?>

        </div>
    </section>