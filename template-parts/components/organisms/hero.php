<?php

    /**
     * Component: Organism: Hero
     * 
     * @package Darío Elizondo
     * 
     */

    $hero = get_sub_field( 'hero' );
    $main_slider = $hero['items'];
    $contact = get_field( 'contact', 'option' );

    $data = array(
        'main_slider' => $main_slider,
        'contact'     => $contact,
    );

?>

<?php if( isset( $hero ) && !empty( $hero ) ) : ?>
    <!-- Hero -->
    <section class="hero <?php echo 'module-' . $module_count; ?>">
        <div class="hero__inner">
            <!-- Slider -->
            <div class="header__slider">
                <?php get_template_part( 'template-parts/components/molecules/main-slider', null, [ 'data' => $data ]  ); ?>
            </div>
            <!-- End slider -->
            <!-- Contact -->
            <div class="header__contact">
                <?php get_template_part( 'template-parts/components/molecules/contact', null, [ 'data' => $data ] ); ?>
            </div>
            <!-- End contact -->
        </div>
    </section>
    <!-- End hero -->
 <?php endif; ?>

<?php
    unset( $hero );
    unset( $main_slider );
    unset( $contact );
?>  