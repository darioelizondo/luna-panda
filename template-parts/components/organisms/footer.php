<?php

    /**
     * Component: Organism: Footer
     * 
     * @package Darío Elizondo
     * 
     */

    $footer_caption = get_field( 'footer_caption', 'option' );
    $footer_social = get_field( 'footer_social', 'option' );
    $footer_logo_carousel = get_field( 'footer_logo_carousel', 'option' );


    $data = array(
        'footer_caption' => $footer_caption,
        'footer_social'  => $footer_social,
        'logos_slider' => $footer_logo_carousel,
    );

?>

<!-- Footer-->
<footer class="footer">
    <div class="footer__inner container grid-columns-l--12">
        <!-- Top -->
        <div class="footer__top">
            <!-- Footer logo -->
            <div class="footer__logo">
                <?php get_template_part( 'template-parts/components/atoms/logo-footer' ); ?>
            </div>
            <!-- Social -->
            <div class="footer__social">
                <?php
                    get_template_part( 'template-parts/components/atoms/footer-social', null, [ 'data' => $data ] );
                ?>
            </div>
        </div>
        <!-- Middle -->
        <div class="footer__middle">
            <div class="footer__wrapper-carousel-title">
                <h4 class="footer__carousel-title">
                    Trusted by
                </h4>
            </div>
            <!-- Logo carousel -->
            <div class="footer__logo-carousel">
                <?php if( isset( $footer_logo_carousel ) && !empty( $footer_logo_carousel ) ) : ?>
                    <?php get_template_part( 'template-parts/components/molecules/logos-slider', null, [ 'data' => $data ]  ); ?>
                <?php endif; ?>
            </div>
        </div>
        <!-- Bottom -->
        <div class="footer__bottom">
            <!-- Caption -->
            <div class="footer__caption">    
                <?php
                    get_template_part( 'template-parts/components/atoms/footer-caption', null, [ 'data' => $data ] );
                ?>
            </div>
        </div>
    </div>
</footer>
<!-- End footer -->