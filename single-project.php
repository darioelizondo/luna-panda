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

            <div class="project-single__inner-filters container">
                <?php get_template_part( 'template-parts/components/organisms/projects-filters' ); ?>
            </div>

            <div class="project-single__wrapper">
                <?php require TD . '/template-parts/modules/project-modules.php'; ?>
                <?php require TD . '/template-parts/components/molecules/related-projects.php'; ?>
            </div>

        </div>

<?php endwhile; endif;

    get_footer();