<?php

    /**
     * Component: Atom: Image project home
     *
     * @package Darío Elizondo
     * 
     */

    $data = $args['data'] ?? null;
    $data_item_project = $data['item_project'] ?? null;

    // print_r($data_item_project);

?>

<?php if( isset( $data_item_project[ 'item_project' ][ 'image_project' ] ) && !empty( $data_item_project[ 'item_project' ][ 'image_project' ] ) ) : ?>
    <!-- Image project home  -->
    <a href="<?php echo esc_attr( $data_item_project[ 'item_project' ][ 'image_project' ][ 'link' ] ) ?>" class="image-project-home">
        <picture class="image-project-home__picture">
            <source media="(min-width: 1024px)" srcset="<?php echo esc_url( $data_item_project[ 'item_project' ][ 'image_project' ][ 'image_xl' ]['url'] ); ?>" />
            <img 
                class="image-project-home__image image--fluid"
                src="<?php echo esc_url( $data_item_project[ 'item_project' ][ 'image_project' ][ 'image_sm' ]['url'] ); ?>" 
                alt="<?php echo esc_attr( $data_item_project[ 'item_project' ][ 'image_project' ][ 'image_sm' ]['alt'] ); ?>" 
                width="<?php echo esc_attr( $data_item_project[ 'item_project' ][ 'image_project' ][ 'image_sm' ]['width'] ); ?>" 
                height="<?php echo esc_attr( $data_item_project[ 'item_project' ][ 'image_project' ][ 'image_sm' ]['height'] ); ?>"
            />
        </picture>
    </a>
    <!-- End image project home  -->
<?php endif; ?>