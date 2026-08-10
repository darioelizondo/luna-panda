<?php
/**
 *
 * Component: Atom: Video embed
 * @package Darío Elizondo
 *
 */

require_once TD . '/inc/functions/layout-control.php';

$layout = $args['layout'] ?? '';

$video_embed = get_sub_field( 'video_embed' );

if ( ! is_array( $video_embed ) ) {
    return;
}

$video          = $video_embed['video'] ?? '';
$need_container = ! empty( $video_embed['need_container'] );

if ( ! $video ) {
    return;
}

$allowed_embed_html = [
    'iframe' => [
        'allow'          => true,
        'allowfullscreen' => true,
        'class'          => true,
        'frameborder'    => true,
        'height'         => true,
        'loading'        => true,
        'referrerpolicy' => true,
        'sandbox'        => true,
        'src'            => true,
        'style'          => true,
        'title'          => true,
        'width'          => true,
    ],
];

$video = wp_kses( $video, $allowed_embed_html );

if ( class_exists( 'WP_HTML_Tag_Processor' ) ) {
    $video_processor = new WP_HTML_Tag_Processor( $video );

    if ( $video_processor->next_tag( 'iframe' ) ) {
        if ( ! $video_processor->get_attribute( 'loading' ) ) {
            $video_processor->set_attribute( 'loading', 'lazy' );
        }

        if ( ! $video_processor->get_attribute( 'title' ) ) {
            $video_processor->set_attribute(
                'title',
                __( 'Embedded video', 'luna-panda' )
            );
        }
    }

    $video = $video_processor->get_updated_html();
}

$attrs = layout_control_attrs(
    $layout,
    'layout-control',
    $layout
);

?>

<!-- Video embed -->
<?php if ( $need_container ) : ?>

    <div class="container grid-columns-s--2 grid-columns-l--12">

<?php endif; ?>

    <div <?= $attrs; ?>>

        <div class="<?= esc_attr( $layout ); ?>__inner">

            <div class="<?= esc_attr( $layout ); ?>__media">
                <?= $video; ?>
            </div>

        </div>

    </div>

<?php if ( $need_container ) : ?>

    </div>

<?php endif; ?>
<!-- End video embed -->
