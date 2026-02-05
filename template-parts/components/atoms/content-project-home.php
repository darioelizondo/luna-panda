<?php

    /**
     * Component: Atom: Content project home
     *
     * @package Darío Elizondo
     * 
     */

    $data = $args['data'] ?? null;

?>

<?php if( isset( $data[ 'item_project' ][ 'content_project' ] ) && !empty( $data[ 'item_project' ][ 'content_project' ] ) ) : ?>
    <!-- Content project home  -->
    <div class="content-project-home">
        <div class="content-project-home__inner">
            <!-- Content project home header -->
            <div class="content-project-home__header">
                <h4 class="content-project-home__title">
                    <?php echo esc_html( $data[ 'item_project' ][ 'content_project' ][ 'title' ] ); ?>
                </h4>
                <p class="content-project-home__subtitle">
                    <?php echo esc_html( $data[ 'item_project' ][ 'content_project' ][ 'subtitle' ] ); ?>
                </p>
            </div>
            <!-- Content project home text -->
            <div class="content-project-home__wrapper-text">
                <p class="content-project-home__text">
                    <?php echo wp_kses_post( $data[ 'item_project' ][ 'content_project' ][ 'text' ] ); ?>
                </p>
            </div>
        </div>
    </div>
    <!-- End content project home  -->
<?php endif; ?>