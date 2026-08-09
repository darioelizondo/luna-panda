<?php

    /**
     * Component: Organism: Logos carousel
     * 
     * @package Darío Elizondo
     * 
     */

    require_once TD . '/inc/functions/layout-control.php';

    $layout = $args['layout'] ?? '';

    $logos_carousel = get_sub_field( 'logos_carousel' );
    $logos_slider = $logos_carousel['items'];
    $need_container = ! empty( $logos_carousel['need_container'] );

    /*
    * Layout Control attributes + component CSS properties.
    */
    $attrs = layout_control_attrs(
        $layout,
        'layout-control',
        $layout,
    );

    

    $data = array(
        'logos_slider' => $logos_slider,
    );

?>

<?php if( isset( $logos_carousel ) && !empty( $logos_carousel ) ) : ?>
    <!-- Logos carousel -->
    <?php if ( $need_container ) : ?>
        <div class="container grid-columns-s--2 grid-columns-l--12">
    <?php endif; ?>

            <section <?= $attrs; ?>>
                <div class="logos_carousel__inner">
                    <?php if( isset( $logos_carousel['title'] ) && !empty( $logos_carousel['title'] ) ) : ?>
                    <!-- Title -->
                    <div class="logos_carousel__wrapper-title">
                        <h3 class="logos_carousel__title">
                            <?php echo esc_html( $logos_carousel[ 'title' ] ); ?>
                        </h3>
                    </div>
                    <?php endif; ?>
                    <!-- Slider -->
                    <div class="logos_carousel__slider">
                        <?php get_template_part( 'template-parts/components/molecules/logos-slider', null, [ 'data' => $data ]  ); ?>
                    </div>
                </div>
            </section>

    <?php if ( $need_container ) : ?>
        </div>
    <?php endif; ?>
    <!-- End Logos carousel -->
 <?php endif; ?>

<?php
    unset( $logos_carousel );
    unset( $logos_slider );
?>  