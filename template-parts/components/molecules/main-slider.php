<?php

/**
 * Component: Molecule: Main slider
 *
 * @package Darío Elizondo
 * 
 */

$data = $args['data'] ?? null;

?>

<?php if( isset( $data[ 'main_slider' ] ) && !empty( $data[ 'main_slider' ] ) ) : ?>
    <!-- Main slider -->
    <div class="main-slider" data-main-slider>
        <div class="main-slider__inner swiper">

            <div class="main-slider__wrapper swiper-wrapper">
                <?php foreach( $data[ 'main_slider' ] as $nkey => $slide ) : ?>
                    <!-- Slide -->
                    <div class="main-slider__slide swiper-slide <?php echo 'main-slider__slide--' . ( $nkey + 1 ) ; ?>">
                        <picture class="main-slider__picture">
                            <source media="(min-width: 768px)" srcset="<?php echo esc_url( $slide['image_xl']['url'] ); ?>">
                            <img class="main-slider__image image--fluid" src="<?php echo esc_url( $slide['image_sm']['url'] ); ?>" alt="<?php echo esc_attr( $slide['image_sm']['alt'] ); ?>" />
                        </picture>
                    </div>
                    <!-- End slide -->
                <?php endforeach; ?>
            </div>

            <!-- Swipper controls -->
            <!-- <div class="main-slider__next swiper-button-next"></div>
            <div class="main-slider__prev swiper-button-prev"></div> -->

        </div>
    </div>
    <!-- End main slider -->
<?php endif; ?>