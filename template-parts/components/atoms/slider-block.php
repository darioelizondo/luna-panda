<?php
    /**
     * 
     * Component: Atom: Slider block (Swiper)
     * @package Darío Elizondo
     * 
     */

    require_once TD . '/inc/functions/layout-control.php';

    $layout = $args['layout'] ?? '';
    $attrs = layout_control_attrs( $layout , 'layout-control', $layout );

    $slider_block = get_sub_field('text_block');

    if ( !isset( $slider_block[ 'items' ] ) || empty( $slider_block[ 'items' ] ) ) return;

    // Slides per view
    $spv_m = (int)( $slider_block[ 'slides_per_view_mobile' ] ?? 2 );
    $spv_d = (int)( $slider_block[ 'slides_per_view_desktop' ] ?? 3 );

    // Space between
    $sb_m  = (int)( $slider_block[ 'space_between_mobile' ] ?? 12 );
    $sb_d  = (int)( $slider_block[ 'space_between_desktop' ] ?? 24 );

    // Clamps
    $spv_m = max(1, min(2, $spv_m));
    $spv_d = max(1, min(6, $spv_d));
    $sb_m  = max(0, min(80, $sb_m));
    $sb_d  = max(0, min(120, $sb_d));
    ?>

    <!-- Slider block -->
    <div <?= $attrs; ?>>
        <div class="<?php echo $layout; ?>__inner">

            <div
                class="<?php echo $layout; ?>__swiper swiper"
                data-swiper
                data-spv-mobile="<?= esc_attr($spv_m); ?>"
                data-spv-desktop="<?= esc_attr($spv_d); ?>"
                data-space-mobile="<?= esc_attr($sb_m); ?>"
                data-space-desktop="<?= esc_attr($sb_d); ?>"
            >
                <div class="<?php echo $layout; ?>__wrapper swiper-wrapper">
                    <?php foreach ( $slider_block[ 'items' ] as $nkey => $item ) : ?>

                        <div class="<?php echo $layout; ?>__slide swiper-slide <?php echo $layout . '--' . ( $nkey + 1 ) ; ?>">
                        <picture class="<?php echo $layout; ?>__picture">
                                <img class="<?php echo $layout; ?>__image image--fluid" src="<?php echo esc_url( $item['image']['url'] ); ?>" alt="<?php echo esc_attr( $item['image']['alt'] ); ?>" />
                            </picture>
                        </div>

                    <?php endforeach; ?>
                </div>
                
            </div>

        </div>
    </div>
    <!-- End slider block -->