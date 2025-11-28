<?php

    /**
     * Header
     * 
     * @package Darío Elizondo
     */

?>
    <!DOCTYPE HTML>
    <html <?php language_attributes(); ?>>
    <head>
        <meta charset="<?php bloginfo( 'charset' ); ?>">
        <link href="<?php echo esc_attr( TDU ); ?>/favicon.ico" rel="shortcut icon">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <!-- Favicon light-->
        <link rel="icon" href="<?php echo TDU; ?>/assets/images/favicon/favicon-deema-murad-light.png" media="(prefers-color-scheme: light)">
        <!-- Favicon dark -->
        <link rel="icon" href="<?php echo TDU; ?>/assets/images/favicon/favicon-deema-murad-dark.png" media="(prefers-color-scheme: dark)">

        <?php wp_head(); ?>
    </head>

    <?php include TD . '/template-parts/components/molecules/terms-and-conditions-popup.php'; ?>
    
    <body <?php body_class(); ?>>
        <main class="main">
            <?php include TD . '/template-parts/components/organisms/header.php'; ?>