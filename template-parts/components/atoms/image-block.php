<?php
    /**
     * 
     * Component: Atom: Image block
     * @package Darío Elizondo
     * 
     */

    require_once TD . '/inc/functions/layout-control.php';

    $layout = $args['layout'] ?? '';
    $attrs = layout_control_attrs( $layout , 'layout-control', $layout );

    $image_block = get_sub_field( 'image_block' );

    $image_sm   = $image_block[ 'image_sm' ];
    $image_xl   = $image_block[ 'image_xl' ];
?>

<!-- Image block -->
<div <?= $attrs; ?>>
    <div class="<?php echo $layout; ?>__inner">
        <picture class="<?php echo $layout; ?>__picture">
            <source media="(min-width: 1024px)" srcset="<?php echo esc_url( $image_xl['url'] ); ?>" />
            <img 
                class="<?php echo $layout; ?>__image image--fluid"
                src="<?php echo esc_url( $image_sm['url'] ); ?>" 
                alt="<?php echo esc_attr( $image_sm['alt'] ); ?>" 
                width="<?php echo esc_attr( $image_sm['width'] ); ?>" 
                height="<?php echo esc_attr( $image_sm['height'] ); ?>"
            />
        </picture>
    </div>
</div>
<!-- End image block -->