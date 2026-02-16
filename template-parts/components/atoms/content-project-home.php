<?php

    /**
     * Component: Atom: Content project home
     *
     * @package Darío Elizondo
     * 
     */

    $data = $args['data'] ?? null;
    $data_item_project = $data['item_project'] ?? null;

    $content_offset_x_m = $data_item_project[ 'item_project' ]['content_offset_x_m'] ?? 0;
    $content_offset_y_m = $data_item_project[ 'item_project' ]['content_offset_y_m'] ?? 0;
    $content_offset_x   = $data_item_project[ 'item_project' ]['content_offset_x'] ?? 0;
    $content_offset_y   = $data_item_project[ 'item_project' ]['content_offset_y'] ?? 0;

    $style = '--coxm:' . (int)$content_offset_x_m . 'px; --coym:' . (int)$content_offset_y_m . 'px;';
    $style .= ' --cox:' . (int)$content_offset_x . 'px; --coy:' . (int)$content_offset_y . 'px;';


?>

<?php if( isset( $data_item_project[ 'item_project' ][ 'content_project' ] ) && !empty( $data_item_project[ 'item_project' ][ 'content_project' ] ) ) : ?>
    <!-- Content project home  -->
    <div class="content-project-home" style="<?php echo esc_attr($style); ?>">
        <div class="content-project-home__inner">
            <!-- Content project home header -->
            <div class="content-project-home__header">
                <h4 class="content-project-home__title">
                    <?php echo esc_html( $data_item_project[ 'item_project' ][ 'content_project' ][ 'title' ] ); ?>
                </h4>
                <p class="content-project-home__subtitle">
                    <?php echo esc_html( $data_item_project[ 'item_project' ][ 'content_project' ][ 'subtitle' ] ); ?>
                </p>
            </div>
            <!-- Content project home text -->
            <div class="content-project-home__text">
                <?php echo wp_kses_post( $data_item_project[ 'item_project' ][ 'content_project' ][ 'text' ] ); ?>
            </div>
        </div>
    </div>
    <!-- End content project home  -->
<?php endif; ?>