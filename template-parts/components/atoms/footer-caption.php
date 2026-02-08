<?php

/**
 * Component: Atom: Footer caption
 *
 * @package Darío Elizondo
 * 
 */

$data = $args['data'] ?? null;

?>

<?php if( isset( $data[ 'footer_caption' ] ) && !empty( $data[ 'footer_caption' ] ) ) : ?>
    <!-- Footer caption -->
    <div class="footer-caption">
        <div class="footer-caption__inner">
            <div class="footer-caption__content">
                <?php echo wp_kses_post( $data[ 'footer_caption' ] ); ?>
            </div>
        </div>
    </div>
    <!--End footer caption -->
<?php endif; ?>