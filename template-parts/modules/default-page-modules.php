<?php

    /**
     * 
     * Default Page modules
     * @package Darío Elizondo
     * 
     */

    if (!defined('ABSPATH')) exit;

    require_once TD . '/inc/functions/layout-control.php';

    $field = $args['field'] ?? '';

    if (!$field) return;

    $wrapper_class = $args['wrapper_class'] ?? 'lp-template-page';    

    ?>

    <!-- Luna & Panda template page -->
    <div class="<?= esc_attr($wrapper_class); ?>">
        <div class="<?= esc_attr($wrapper_class); ?>__inner">

                <?php

                if ( have_rows( 'default_page_modules' ) ) : while ( have_rows( 'default_page_modules' ) ) : the_row( 'default_page_modules' );

                        $layout = get_row_layout();

                        // Args
                        $args = [
                            'layout' => $layout,
                        ];
                        
                        if ( $layout === 'text_block' ) {                       get_template_part('template-parts/components/atoms/text-block', null, $args); }
                        if ( $layout === 'image_block' ) {                      get_template_part('template-parts/components/atoms/image-block', null, $args); }
                        if ( $layout === 'slider_block' ) {                     get_template_part('template-parts/components/atoms/slider-block', null, $args); }
                        if ( $layout === 'hero_block' ) {                       get_template_part('template-parts/components/organisms/hero-block', null, $args); }
                        if ( $layout === 'before_after_image_comparison' ) {    get_template_part('template-parts/components/atoms/before-after-image-comparison', null, $args); }
                        if ( $layout === 'button_block' ) {                     get_template_part('template-parts/components/atoms/button-block', null, $args); }
                        if ( $layout === 'logos_carousel' ) {                   get_template_part('template-parts/components/organisms/logos-carousel', null, $args); }
                        if ( $layout === 'video_embed' ) {                      get_template_part('template-parts/components/atoms/video-embed', null, $args); }
                        if ( $layout === 'contact_block' ) {                    get_template_part('template-parts/components/atoms/contact-block', null, $args); }

                    endwhile;
                endif;

                ?>

        </div>
    </div>
    <!-- End Luna & Panda template page -->
