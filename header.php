<?php

    /**
     * Header
     * 
     * @package Darío Elizondo
     * 
     */

?>
    <!DOCTYPE HTML>
    <html <?php language_attributes(); ?>>
    <head>
        <meta charset="<?php bloginfo( 'charset' ); ?>">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <!-- Favicon -->
        <link rel="apple-touch-icon" sizes="180x180" href="<?php echo TDU; ?>/assets/images/favicon/apple-touch-icon.png">
        <link rel="icon" type="image/png" sizes="32x32" href="<?php echo TDU; ?>/assets/images/favicon/favicon-32x32.png">
        <link rel="icon" type="image/png" sizes="16x16" href="<?php echo TDU; ?>/assets/images/favicon/favicon-16x16.png">
        <link rel="icon" href="<?php echo TDU; ?>/assets/images/favicon/favicon.ico">
        <!-- Theme color -->
        <meta name="theme-color" content="#ffffff" media="(prefers-color-scheme: light)" />
        <meta name="theme-color" content="#000000" media="(prefers-color-scheme: dark)" />

        <?php wp_head(); ?>
    </head>
    
    <body <?php body_class(); ?>>

        <!-- Loader -->
        <div class="loader">
          <canvas id="burn-canvas"></canvas>
        </div>
        <!-- End loader -->

        <?php include TD . '/template-parts/components/organisms/header.php'; ?>

        <div data-barba="wrapper" class="site-wrapper">
            <main class="main" data-barba="container" data-barba-namespace="<?php echo esc_attr( get_post_type() ?: 'page' ); ?>">

            <div style="width: 100%; height: 400px; background: #fff;"></div>
            <div style="width: 100%; height: 400px; background: red;"></div>