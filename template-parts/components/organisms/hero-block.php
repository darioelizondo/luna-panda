<?php

    /**
     * Component: Organism: Hero Block
     * 
     * @package Darío Elizondo
     * 
     */

    $hero = get_sub_field( 'hero_block' );
    $slider = $hero['items'];

    $data = array(
        'slider' => $slider,
    );

?>

<?php if( isset( $hero ) && !empty( $hero ) ) : ?>
    <!-- Hero block -->
    <section class="hero-block" data-hero-block>
        <div class="hero-block__inner">
            <!-- Overlay -->
            <div class="hero-block__overlay"></div>
            <!-- End Overlay -->
            <!-- Slider -->
            <div class="hero-block__slider">
                <?php get_template_part( 'template-parts/components/molecules/hero-block-slider', null, [ 'data' => $data ]  ); ?>
            </div>
            <!-- End slider -->
            <!-- Content -->
            <div class="hero-block__content">
                <div class="hero-block__content-inner grid-columns-l--12">
                    <div class="hero-block__title">
                        <?php echo wp_kses_post( $hero['title'] ); ?>
                    </div>
                    <div class="hero-block__description">
                        <?php echo wp_kses_post( $hero['description'] ); ?>
                    </div>
                    <?php if( isset( $hero['button'] ) && !empty( $hero['button'] ) ) : ?>
                        <div class="hero-block__wrapper-button">
                            <a class="hero-block__button" href="<?php echo esc_url( $hero['button']['url'] ); ?>" target="<?php echo esc_attr( $hero['button']['target'] ); ?>">
                                <?php echo esc_html( $hero['button']['title'] ); ?>
                            </a>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
            <!-- End content -->
        </div>
    </section>
    <!-- End hero block -->
 <?php endif; ?>

<?php
    unset( $hero );
    unset( $slider );
?>  