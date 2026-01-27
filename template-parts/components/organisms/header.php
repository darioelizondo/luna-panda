<?php

    /**
     * Component: Organism: Header
     * 
     * @package Darío Elizondo
     * 
     */

    $header_caption = get_field( 'header_caption', 'option' );

    $data = array(
        'header_caption' => $header_caption,
    );

?>

<!-- Header -->
<header class="header js-header">
    <div class="header__inner container grid-columns-l--12">
        <!-- Content -->
        <div class="header__content">
            <div class="header__logo-hamburger">
                <div class="header__logo js-logo">
                    <?php get_template_part( 'template-parts/components/atoms/logo' ); ?>
                </div>
                <!-- <div class="header__hamburger-icon js-hamburger-menu">
                    <?php // get_template_part( 'template-parts/components/atoms/hamburger-icon' ); ?>
                </div> -->
            </div>
            <div class="header__caption js-caption">
                <?php
                    get_template_part( 'template-parts/components/atoms/header-caption', null, [ 'data' => $data ] );
                ?>
            </div>
            <div class="header__menu js-menu">
                <?php get_template_part( 'template-parts/components/molecules/menu' ); ?>
            </div>
        </div>
        <!-- End content --> 
    </div>
</header>
<!-- End header -->

<?php
    unset( $header_caption );
?>