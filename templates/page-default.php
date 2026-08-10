<?php
    /**
     * 
     * Template Name: Default Page
     * 
     * @package Darío Elizondo
     */


    get_header();

    $bottom_spacing_mobile = get_field( 'bottom_spacing_adjustment_mobile' );

    $bottom_spacing_desktop = get_field( 'bottom_spacing_adjustment_desktop' );

    $page_styles = [];

    if ( $bottom_spacing_mobile ) {
        $page_styles[] =
            '--page-bottom-adjustment-mobile:' .
            $bottom_spacing_mobile .
            'px';
    }

    if ( $bottom_spacing_desktop ) {
        $page_styles[] =
            '--page-bottom-adjustment-desktop:' .
            $bottom_spacing_desktop .
            'px';
    }

?>

    <section class="default-page" <?php if ( $page_styles ) : ?> style="<?= esc_attr( implode( ';', $page_styles ) ); ?>" <?php endif; ?>>
        <div class="default-page__inner">
            
           <?php
                // Flexible content modules
                get_template_part( 'template-parts/modules/default-page-modules', null, [ 'field' => 'default_page_modules', 'wrapper_class' => 'default-page__wrapper', ] );
            ?>

        </div>
    </section>

<?php get_footer(); ?>