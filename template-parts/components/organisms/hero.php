<?php

    /**
     * Component: Organism: Hero
     * 
     * @package Darío Elizondo
     * 
     */

    $hero = get_sub_field( 'hero' );
    $main_slider = $hero['items'];

    $data = array(
        'main_slider' => $main_slider,
    );

?>

<?php if( isset( $hero ) && !empty( $hero ) ) : ?>
    <!-- Hero -->
    <section class="hero <?php echo 'module-' . $module_count; ?>" data-hero>
        <div class="hero__inner">
            <!-- Slider -->
            <div class="hero__slider">
                <?php get_template_part( 'template-parts/components/molecules/main-slider', null, [ 'data' => $data ]  ); ?>
            </div>
            <!-- End slider -->
        </div>
    </section>
    <!-- End hero -->
 <?php endif; ?>

<?php
    unset( $hero );
    unset( $main_slider );
?>  