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

            <?php require TD . '/template-parts/components/molecules/related-projects.php'; ?>

        </div>

<?php endwhile; endif;

    get_footer();