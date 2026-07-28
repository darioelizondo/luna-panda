<?php

/**
 * Component: Molecule: Hero block slider
 *
 * @package Darío Elizondo
 * 
 */

$data = $args['data'] ?? null;

?>

<?php if( isset( $data[ 'slider' ] ) && !empty( $data[ 'slider' ] ) ) : ?>
    <!-- Hero block slider -->
    <div class="hero-block-slider" data-hero-block-slider>

        <?php if( count( $data[ 'slider' ] ) == 1 ) { ?>
            <div class="hero-block-slider__wrapper">
                <picture class="hero-block-slider__picture">
                    <source media="(min-width: 768px)" srcset="<?php echo esc_url( $data[ 'slider' ][0]['image_xl']['url'] ); ?>">
                    <img class="hero-block-slider__image image--fluid" src="<?php echo esc_url( $data[ 'slider' ][0]['image_sm']['url'] ); ?>" alt="<?php echo esc_attr( $data[ 'slider' ][0]['image_sm']['alt'] ); ?>" />
                </picture>
            </div>            
        <?php } ?>

        <?php if( count( $data[ 'slider' ] ) > 1 ) { ?>

            <div class="hero-block-slider__inner swiper">

                <div class="hero-block-slider__wrapper swiper-wrapper">
                    <?php foreach( $data[ 'slider' ] as $nkey => $slide ) : ?>
                        <!-- Slide -->
                        <div class="hero-block-slider__slide swiper-slide <?php echo 'hero-block-slider__slide--' . ( $nkey + 1 ) ; ?>">
                            <picture class="hero-block-slider__picture">
                                <source media="(min-width: 768px)" srcset="<?php echo esc_url( $slide['image_xl']['url'] ); ?>">
                                <img class="hero-block-slider__image image--fluid" src="<?php echo esc_url( $slide['image_sm']['url'] ); ?>" alt="<?php echo esc_attr( $slide['image_sm']['alt'] ); ?>" />
                            </picture>
                        </div>
                        <!-- End slide -->
                    <?php endforeach; ?>
                </div>

            </div>

        <?php } ?>

    </div>
    <!-- End hero block slider -->
<?php endif; ?>