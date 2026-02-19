<?php

    /**
     * Component: Atom: Content project
     *
     * @package Darío Elizondo
     * 
     */

    $data = $args['data'] ?? null;

    // Content
    $content_mobile_span           = (int)($data['content_mobile_col_span'] ?? 2); // El contenido tiene el mismo default que la imagen en mobile
    $content_span                  = (int)($data['content_col_span'] ?? 4); // El contenido tiene el mismo default que la imagen

    // Content inside
    $logo_mobile_span              = (int)($data['logo_mobile_col_span'] ?? 1);
    $logo_span                     = (int)($data['logo_col_span'] ?? 1);

    $title_tags_mobile_span        = (int)($data['title_tags_mobile_col_span'] ?? 1);
    $title_tags_span               = (int)($data['title_tags_col_span'] ?? 1);

    $short_btn_mobile_span         = (int)($data['short_line_and_button_mobile_col_span'] ?? 1);
    $short_btn_span                = (int)($data['short_line_and_button_col_span'] ?? 1);

    $style                         = '--m-cspan:' . $content_mobile_span . '; --cspan:' . $content_span . ';';
    $logo_style                    = '--i-m-logospan:' . $logo_mobile_span . '; --i-logospan:' . $logo_span . ';';
    $title_tags_style              = '--i-m-titletagspan:' . $title_tags_mobile_span . '; --i-titletagspan:' . $title_tags_span . ';';
    $shortline_button_style        = '--i-m-shortbuttonspan:' . $short_btn_mobile_span . '; --i-shortbuttonspan:' . $short_btn_span . ';';

    $terms = get_the_terms(get_the_ID(), 'project_category');

    // print_r( $data['project_tags'] );

?>

<?php if ( !empty($data) ) : ?>
    <!-- Content project  -->
    <div class="content-project" style="<?php echo esc_attr($style); ?>">
        <div class="content-project__inner">

            <?php if ( !empty($data['logo']['url']) ) : ?>
                <!-- Logo -->
                <div class="content-project__logo" style="<?php echo esc_attr($logo_style); ?>">
                    <img
                        src="<?php echo esc_url($data['logo']['url']); ?>"
                        alt="<?php echo esc_attr($data['logo']['alt'] ?? get_the_title()); ?>"
                        class="content-project__logo-image image--fluid"
                        loading="lazy"
                        decoding="async"
                    />
                </div>
            <?php endif; ?>

            <!-- Title + Categories -->
            <div class="content-project__title-categories" style="<?php echo esc_attr($title_tags_style); ?>">
                <h4 class="content-project__title">
                    <?php echo esc_html(get_the_title()); ?>
                </h4>

                <?php if ( !empty($data['project_tags']) ) : ?>
                <ul class="content-project__category-list">
                    <?php foreach ( $data['project_tags'] as $tag ) : ?>
                        <li class="content-project__category"><?php echo esc_html($tag->name ?? ''); ?></li>
                    <?php endforeach; ?>
                </ul>
                <?php endif; ?>
            </div>
                        
            <!-- Shortline + Button -->
            <div class="content-project__short-line-button" style="<?php echo esc_attr($shortline_button_style); ?>">
                <?php if ( !empty($data['short_line']) ) : ?>
                    <p class="content-project__short-line"><?php echo esc_html($data['short_line']); ?></p>
                <?php endif; ?>

                <a class="content-project__button" href="<?php echo esc_url(get_permalink()); ?>">
                    See more
                </a>
            </div>

        </div>
    </div>
    <!-- End content project  -->
<?php endif; ?>