<?php

    /**
     * Component: Organism: Hero
     * 
     * @package Darío Elizondo
     * 
     */

    $hero = get_sub_field( 'hero' );
    $main_slider = $hero['main_slider'];
    $contact = get_field( 'contact', 'option' );

?>

<!-- Hero -->
<div class="hero">
    <div class="hero__inner">
        <!-- Slider -->
        <div class="header__slider">
            <?php get_template_part( 'template-parts/components/molecules/main-slider' ); ?>
        </div>
        <!-- End slider -->
        <!-- Contact -->
        <div class="header__contact">
            <?php get_template_part( 'template-parts/components/molecules/contact' ); ?>
        </div>
        <!-- End contact -->
    </div>
</div>
<!-- End hero -->

<?php
    unset( $hero );
    unset( $main_slider );
    unset( $contact );
?>  