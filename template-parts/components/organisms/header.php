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
<header class="header">
    <div class="header__inner container grid-columns-l--12">
        <!-- Content -->
        <div class="header__content">
            <div class="header__logo-hamburger">
                <div class="header__logo">
                    <?php get_template_part( 'template-parts/components/atoms/logo' ); ?>
                </div>
                <div class="header__hamburger-icon">
                    <?php get_template_part( 'template-parts/components/atoms/hamburger-icon' ); ?>
                </div>
            </div>
            <div class="header__caption">
                <?php
                    get_template_part( 'template-parts/components/atoms/header-caption', null, [ 'data' => $data ] );
                ?>
            </div>
            <div class="header__menu">
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