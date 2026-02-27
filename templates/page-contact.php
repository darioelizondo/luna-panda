<?php
    /**
     * 
     * Template Name: Contact us
     * 
     * @package Darío Elizondo
     */

    $contact_us = get_field('contact', 'option');


    get_header();
?>

    <section class="contact-us">
        <div class="contact-us__inner container">
            
        <!-- Contact text -->
        <div class="contact-us__wrapper-text">
            <div class="contact-us__text">
                <?php echo wp_kses_post( $contact_us[ 'text' ] ); ?>
            </div>
        </div>
        <!-- End contact text -->
        
        <!-- Contact form -->
        <div class="contact-us__wrapper-form">
            <?php echo do_shortcode( $contact_us[ 'form' ] ); ?>
        </div>
        <!-- End contact form -->

        </div>
    </section>

<?php get_footer(); ?>