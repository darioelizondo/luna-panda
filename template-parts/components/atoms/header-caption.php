<?php

/**
 * Component: Atom: Header caption
 *
 * @package Darío Elizondo
 * 
 */

?>

<?php if( isset( $header_caption ) && !empty( $header_caption ) ) : ?>
    <!-- Header caption -->
    <div class="header-caption">
        <div class="header-caption__inner">
            <p class="header-caption__text">
                <?php echo esc_html( $header_caption ); ?>
            </p>
        </div>
    </div>
    <!--End header caption -->
<?php endif; ?>