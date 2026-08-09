<?php
    /**
     * 
     * Template Name: Default Page
     * 
     * @package Darío Elizondo
     */


    get_header();
?>

    <section class="default-page">
        <div class="default-page__inner">
            
           <?php
                // Flexible content modules
                get_template_part( 'template-parts/modules/default-page-modules', null, [ 'field' => 'default_page_modules', 'wrapper_class' => 'default-page__wrapper', ] );
            ?>

        </div>
    </section>

<?php get_footer(); ?>