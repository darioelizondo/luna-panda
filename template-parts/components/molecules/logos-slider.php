<?php

/**
 * Component: Molecule: Logos slider
 *
 * @package Darío Elizondo
 * 
 */

$data = $args['data'] ?? null;

?>

<?php if( isset( $data[ 'logos_slider' ] ) && !empty( $data[ 'logos_slider' ] ) ) : ?>
    <!-- Logos slider -->
    <div class="logos-slider" data-logos-slider>
        <div class="logos-slider__inner swiper">

            <div class="logos-slider__wrapper swiper-wrapper">
                <?php foreach( $data[ 'logos_slider' ] as $nkey => $slide ) : ?>
                    <!-- Slide -->
                    <div class="logos-slider__slide swiper-slide <?php echo 'logos-slider__slide--' . ( $nkey + 1 ) ; ?>">
                        <picture class="logos-slider__picture">
                            <img class="logos-slider__image image--fluid" src="<?php echo esc_url( $slide['image']['url'] ); ?>" alt="<?php echo esc_attr( $slide['image']['alt'] ); ?>" />
                        </picture>
                    </div>
                    <!-- End slide -->
                <?php endforeach; ?>
            </div>

        </div>
    </div>
    <!-- End logos slider -->
<?php endif; ?>