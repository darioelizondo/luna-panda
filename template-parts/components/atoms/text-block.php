<?php
/**
 *
 * Component: Atom: Text block
 * @package Darío Elizondo
 *
 */

require_once TD . '/inc/functions/layout-control.php';

$layout = $args['layout'] ?? '';

$text_block = get_sub_field( 'text_block' );

if ( ! is_array( $text_block ) ) {
    return;
}

$text           = $text_block['text'] ?? '';
$need_container = ! empty( $text_block['need_container'] );

$text_color = $text_block['text_color'] ?? '';

$font_size_desktop = isset( $text_block['font_size_desktop'] )
    ? absint( $text_block['font_size_desktop'] )
    : 0;

$font_size_tablet = isset( $text_block['font_size_tablet'] )
    ? absint( $text_block['font_size_tablet'] )
    : 0;

$font_size_mobile = isset( $text_block['font_size_mobile'] )
    ? absint( $text_block['font_size_mobile'] )
    : 0;


/*
 * Component-specific CSS custom properties.
 */
$custom_properties = [];

if ( $text_color ) {
    $sanitized_text_color = sanitize_hex_color( $text_color );

    if ( $sanitized_text_color ) {
        $custom_properties[] =
            '--text-block-color:' . $sanitized_text_color;
    }
}

if ( $font_size_mobile ) {
    $custom_properties[] =
        '--text-block-font-size-mobile:' .
        $font_size_mobile .
        'px';
}

if ( $font_size_tablet ) {
    $custom_properties[] =
        '--text-block-font-size-tablet:' .
        $font_size_tablet .
        'px';
}

if ( $font_size_desktop ) {
    $custom_properties[] =
        '--text-block-font-size-desktop:' .
        $font_size_desktop .
        'px';
}


/*
 * Layout Control attributes + component CSS properties.
 */
$attrs = layout_control_attrs(
    $layout,
    'layout-control',
    $layout,
    $custom_properties
);

?>

<!-- Text block -->
<?php if ( $need_container ) : ?>

    <div class="container grid-columns-s--2 grid-columns-l--12">

<?php endif; ?>

    <div <?= $attrs; ?>>

        <div class="<?= esc_attr( $layout ); ?>__inner">

            <?= wp_kses_post( $text ); ?>

        </div>

    </div>

<?php if ( $need_container ) : ?>

    </div>

<?php endif; ?>
<!-- End text block -->