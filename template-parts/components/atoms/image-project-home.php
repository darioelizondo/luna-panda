<?php

    /**
     * Component: Atom: Image project home
     *
     * @package Darío Elizondo
     * 
     */

    $data = $args['data'] ?? null;

?>

<?php if( isset( $data[ 'item_project' ][ 'image_project_home' ] ) && !empty( $data[ 'item_project' ][ 'image_project_home' ] ) ) : ?>
    <!-- Image project home  -->
    <a href="<?php echo esc_attr( $data[ 'item_project' ][ 'image_project_home_link' ] ) ?>" class="image-project-home">
        <picture class="image-project-home__content">
            <source media="(min-width: 1024px)" srcset="<?php echo esc_url( $data[ 'item_project' ][ 'image_project_home_xl' ]['url'] ); ?>" />
            <img 
                src="<?php echo esc_url( $data[ 'item_project' ][ 'image_project_home_sm' ]['url'] ); ?>" 
                alt="<?php echo esc_attr( $data[ 'item_project' ][ 'image_project_home_sm' ]['alt'] ); ?>" 
                width="<?php echo esc_attr( $data[ 'item_project' ][ 'image_project_home_sm' ]['width'] ); ?>" 
                height="<?php echo esc_attr( $data[ 'item_project' ][ 'image_project_home_sm' ]['height'] ); ?>"
            />
        </picture>
    </a>
    <!-- End image project home  -->
<?php endif; ?>