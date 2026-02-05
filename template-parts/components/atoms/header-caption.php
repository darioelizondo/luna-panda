<?php

/**
 * Component: Atom: Header caption
 *
 * @package Darío Elizondo
 * 
 */

$data = $args['data'] ?? null;

?>

<?php if( isset( $data[ 'header_caption' ] ) && !empty( $data[ 'header_caption' ] ) ) : ?>
    <!-- Header caption -->
    <div class="header-caption">
        <div class="header-caption__inner">
            <h1 class="header-caption__content">
                <?php echo wp_kses_post( $data[ 'header_caption' ] ); ?>
            </h1>
        </div>
    </div>
    <!--End header caption -->
<?php endif; ?>