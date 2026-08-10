<?php
/**
 * Component: Atom: Contact block
 *
 * @package Darío Elizondo
 */

if ( ! defined( 'ABSPATH' ) ) exit;

require_once TD . '/inc/functions/layout-control.php';

$layout = $args['layout'] ?? '';

$contact_block = get_sub_field( 'contact_block' );

if ( ! $layout || ! is_array( $contact_block ) ) {
    return;
}

$title           = trim( (string) ( $contact_block['title'] ?? '' ) );
$form_shortcode  = trim( (string) ( $contact_block['form_shortcode'] ?? '' ) );
$need_container  = ! empty( $contact_block['need_container'] );
$attrs           = layout_control_attrs( $layout, 'layout-control', $layout );
$has_valid_form  = $form_shortcode !== ''
    && shortcode_exists( 'contact-form-7' )
    && has_shortcode( $form_shortcode, 'contact-form-7' );
?>

<!-- Contact block -->
<?php if ( $need_container ) : ?>

    <div class="container grid-columns-s--2 grid-columns-l--12">

<?php endif; ?>

    <div id="<?php if( $contact_block[ 'identifier' ] ) { echo esc_attr( $contact_block[ 'identifier' ] ); } ?>" <?= $attrs; ?>>

        <div class="<?= esc_attr( $layout ); ?>__inner">

            <?php if ( $title !== '' ) : ?>
                <h2 class="<?= esc_attr( $layout ); ?>__title"><?= esc_html( $title ); ?></h2>
            <?php endif; ?>

            <?php if ( $has_valid_form ) : ?>
                <div class="<?= esc_attr( $layout ); ?>__form">
                    <?= do_shortcode( $form_shortcode ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
                </div>
            <?php endif; ?>

        </div>

    </div>

<?php if ( $need_container ) : ?>

    </div>

<?php endif; ?>
<!-- End contact block -->
