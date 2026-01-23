<?php

/**
 * Component: Molecule: Main slider
 *
 * @package Darío Elizondo
 * 
 */

?>

<?php if( isset( $main_slider[ 'items' ] ) && !empty( $main_slider[ 'items' ] ) ) : ?>
    <!-- Main slider -->
    <div class="main-slider">
        <div class="main-slider__inner swiper">
            <div class="main-slider__wrapper swiper-wrapper">
                <?php foreach( $main_slider[ 'items' ] as $nkey => $slide ) : ?>
                <div class="main-slider__slide swiper-slide <?php echo 'main-slider__slide--' . ( $nkey + 1 ); ?>">
                    <img class="main-slider__image image--fluid" src="<?php echo esc_url( $slide['slide_image']['url'] ); ?>" alt="<?php echo esc_attr( $slide['slide_image']['alt'] ); ?>" />
                </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
    <!-- End main slider -->
<?php endif; ?>