<?php

    /**
     * Component: Organism: Header
     * 
     * @package Darío Elizondo
     * 
     */

    $header_caption = get_field( 'header_caption', 'option' );

?>

<!-- Header -->
<header class="header">
    <div class="header__inner container grid-column--12">
        <!-- Wrapper -->
        <div class="header__wrapper">
            <!-- Content -->
            <div class="header__content">
                <div class="header__logo">
                    <?php get_template_part( 'template-parts/components/atoms/logo' ); ?>
                </div>
                <div class="header__caption">
                    <?php get_template_part( 'template-parts/components/atoms/header-caption' ); ?>
                </div>
                <div class="header__menu">
                    <?php get_template_part( 'template-parts/components/molecules/menu' ); ?>
                </div>
            </div>
            <!-- End content --> 
        <!-- End wrapper -->
    </div>
</header>
<!-- End header -->

<?php
    unset( $header_caption );
?>