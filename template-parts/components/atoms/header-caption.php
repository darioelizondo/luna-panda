<?php

/**
 * Atom: Header caption
 *
 * @package Darío Elizondo
 * 
 */

$header_caption = get_field( 'header_caption', 'option' );

?>

<!-- Header caption -->
<div class="header-caption">
    <div class="header-caption__inner">
        <?php if ( $header_caption ) : ?>
            <p class="header-caption__text">
                <?php echo esc_html( $header_caption ); ?>
            </p>
        <?php endif; ?>
    </div>
</div>
<!--End header caption -->