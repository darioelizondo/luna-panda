<?php

    /**
     * Component: Organism: Projects home
     * 
     * @package Darío Elizondo
     * 
     */

    $projects_home = get_sub_field( 'projects_home' );

?>

<?php if( isset( $projects_home ) && !empty( $projects_home ) ) : ?>
    <!-- Projects home -->
    <div class="projects-home">
        <div class="projects-home__inner container grid-columns-l--12">
            <?php foreach( $projects_home as $item_project ) : ?>
                <?php   
                    // Data item project
                    $data_item_project = array(
                        'item_project' => $item_project,
                    );
                    
                    // Item project home
                    get_template_part( 'template-parts/components/molecules/item-project-home', null, array( 'data' => $data_item_project ) ); 
                ?>
            <?php endforeach; ?>
        </div>
    </div>
    <!-- End projects home -->
<?php endif; ?>