<?php

    /**
     * Component: Molecule: Item project home
     *
     * @package Darío Elizondo
     * 
     */

    $data = $args['data'] ?? null;

?>

<?php if( isset( $data[ 'item_project' ] ) && !empty( $data[ 'item_project' ] ) ) : ?>
    <!-- Item project home -->
    <div class="item-project-home">
        <div class="item-project-home__inner">
            <?php 
                // Image project home
                get_template_part( 'template-parts/components/atoms/image-project-home', null, array( 'data' => $data ) ); 
            ?>
            <?php 
                // Content project home
                get_template_part( 'template-parts/components/atoms/content-project-home', null, array( 'data' => $data ) ); 
            ?>
        </div>
    </div>
    <!-- End item project home -->
<?php endif; ?>