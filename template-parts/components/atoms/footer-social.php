<?php

/**
 * Component: Atom: Footer caption
 *
 * @package Darío Elizondo
 * 
 */

$data = $args['data'] ?? null;

?>

<?php if( isset( $data[ 'footer_social' ] ) && !empty( $data[ 'footer_social' ] ) ) : ?>
    <!-- Footer social -->
    <div class="footer-social">
        <?php foreach( $data[ 'footer_social' ][ 'items' ] as $nkey => $item ) : ?>
            <a href="<?php echo esc_attr( $item[ 'link' ][ 'url' ] ); ?>" class="footer_social__item-social" target="<?php echo esc_attr( $item[ 'link' ][ 'target' ] ); ?>">
                <img src="<?php echo esc_attr( $item[ 'image' ][ 'url' ] ); ?>" class="footer_social__social-image">
            </a>
        <?php endforeach;?>
    </div>
    <!--End footer social -->
<?php endif; ?>