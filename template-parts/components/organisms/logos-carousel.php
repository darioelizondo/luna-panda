<?php

    /**
     * Component: Organism: Logos carousel
     * 
     * @package Darío Elizondo
     * 
     */

    $logos_carousel = get_sub_field( 'logos_carousel' );
    $logos_slider = $logos_carousel['items'];

    $data = array(
        'logos_slider' => $logos_slider,
    );

?>

<?php if( isset( $logos_carousel ) && !empty( $logos_carousel ) ) : ?>
    <!-- Logos carousel -->
    <section class="logos-carousel <?php echo 'module-' . $module_count; ?>">
        <div class="logos-carousel__inner">
            <!-- Title -->
             <div class="logos-carousel__wrapper-title">
                <h3 class="logos-carousel__title">
                    <?php echo esc_html( $logos_carousel[ 'title' ] ); ?>
                </h3>
             </div>
            <!-- Slider -->
            <div class="logos-carousel__slider">
                <?php get_template_part( 'template-parts/components/molecules/logos-slider', null, [ 'data' => $data ]  ); ?>
            </div>
        </div>
    </section>
    <!-- End Logos carousel -->
 <?php endif; ?>

<?php
    unset( $logos_carousel );
    unset( $logos_slider );
?>  