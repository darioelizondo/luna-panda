<?php
    /**
     * 
     * Template Name: About Us
     * 
     * @package Darío Elizondo
     */


    get_header();
?>

    <section class="about-us">
        <div class="about-us__inner container">
            
           <?php
                // Flexible content modules
                get_template_part( 'template-parts/modules/page-modules', null, [ 'field' => 'page_modules', 'wrapper_class' => 'about-us__wrapper', ] );
            ?>

        </div>
    </section>

<?php get_footer(); ?>