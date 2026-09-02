<?php
/**
 *
 * Component: Atom: Button block
 * @package Darío Elizondo
 *
 */


require_once TD . '/inc/functions/layout-control.php';

$layout = $args['layout'] ?? '';

$button = get_sub_field( 'button_block' );

if ( !$button ) {
    return;
}

$text = $button['button']['title'] ?? '';
$url = $button['button']['url'] ?? '';
$need_container = !empty( $button['need_container'] );
$is_floating = !empty( $button['is_floating'] );


/*
 * Layout Control attributes + component CSS properties.
 */
$attrs = layout_control_attrs(
    $layout,
    'layout-control',
    trim( $layout . ( $is_floating ? ' button-block--floating' : '' ) ),
);

?>

<!-- Button block -->
<?php if ( $need_container ) : ?>

    <div class="container grid-columns-s--2 grid-columns-l--12">

<?php endif; ?>

    <div <?= $attrs; ?>>

        <div class="<?= esc_attr( $layout ); ?>__inner">

            <a href="<?= esc_url( $url ); ?>" class="single-button">
                <?= wp_kses_post( $text ); ?>
            </a>

        </div>

    </div>

<?php if ( $need_container ) : ?>

    </div>

<?php endif; ?>
<!-- End button block -->
