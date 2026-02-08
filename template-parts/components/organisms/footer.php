<?php

    /**
     * Component: Organism: Footer
     * 
     * @package Darío Elizondo
     * 
     */

    $footer_caption = get_field( 'footer_caption', 'option' );
    $footer_social = get_field( 'footer_social', 'option' );

    $data = array(
        'footer_caption' => $footer_caption,
        'footer_social'  => $footer_social,
    );

?>

<!-- Footer-->
<footer class="footer">
    <div class="footer__inner container grid-columns-l--12">
        <!-- Top -->
        <div class="footer__top">
            <!-- Caption -->
            <div class="footer__caption">    
                <?php
                    get_template_part( 'template-parts/components/atoms/footer-caption', null, [ 'data' => $data ] );
                ?>
            </div>
            <!-- Social -->
            <div class="footer__social">
                <?php
                    get_template_part( 'template-parts/components/atoms/footer-social', null, [ 'data' => $data ] );
                ?>
            </div>
        </div>
        <!-- Bottom -->
        <div class="footer__bottom">
            <div class="footer__logo">
                <?php get_template_part( 'template-parts/components/atoms/logo-footer' ); ?>
            </div>
        </div>
    </div>
</footer>
<!-- End footer -->

<?php
    unset( $footer_caption );
?>