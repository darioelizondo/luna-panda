<?php

    /**
     * Component: Atom: Image project
     *
     * @package Darío Elizondo
     * 
     */

    $data = $args['data'] ?? [];

    $thumb_id = get_post_thumbnail_id(get_the_ID());
    if ( !$thumb_id ) return;

    $src    = wp_get_attachment_image_url($thumb_id, 'full');
    $alt    = get_post_meta($thumb_id, '_wp_attachment_image_alt', true);
    $meta   = wp_get_attachment_metadata($thumb_id);
    $width  = $meta['width'] ?? '';
    $height = $meta['height'] ?? '';

    $image_mobile_span = (int)($data['image_mobile_col_span'] ?? 2 ); // 2 porque va a tener 2fr el grid en mobile: Por default que ocupe al 100%
    $image_span        = (int)($data['image_col_span'] ?? 4 ); // 4 porque va a tener 4fr el grid: Por default que ocupe al 100%
 
    $style = '--m-span:' . $image_mobile_span . '; --span:' . $image_span . ';';

?>

<?php if ( $src ) : ?>
    <!-- Image project  -->
    <div class="image-project" style="<?php echo esc_attr($style); ?>">
        <picture class="image-project__picture">
        <img
            class="image-project__image image--fluid"
            src="<?php echo esc_url($src); ?>"
            alt="<?php echo esc_attr($alt ?: get_the_title()); ?>"
            width="<?php echo esc_attr($width); ?>"
            height="<?php echo esc_attr($height); ?>"
            loading="lazy"
            decoding="async"
        />
        </picture>
    </div>
<?php endif; ?>