<?php

     /**
     * Single project
     * 
     * @package Darío Elizondo
     * 
     */

    get_header();

    if (have_posts()) : while (have_posts()) : the_post();
?>

        <div class="project-single">
            <?php require TD . '/template-parts/modules/project-modules.php'; ?>

            <section class="project-single__related">
                <!-- Parte 3: related projects -->
            </section>

        </div>

    <?php endwhile; endif;

get_footer();