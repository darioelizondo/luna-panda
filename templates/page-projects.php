<?php
/**
 * Template Name: Projects (Loop + Filters)
 *
 * @package Darío Elizondo
 * 
 */

get_header();
?>

<section class="page-projects" data-page="projects">
    <div class="page-projects__inner container grid-columns-l--12">

        <?php
            // Filters (taxonomy project_category)
            get_template_part( 'template-parts/components/organisms/projects-filters', null, [] );
        ?>

        <?php
            // Loop / grid
            get_template_part( 'template-parts/components/organisms/project-presentation', null, );
        ?>

    </div>
</section>

<?php get_footer(); ?>
