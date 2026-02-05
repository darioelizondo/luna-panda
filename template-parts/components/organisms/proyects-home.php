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
    <section class="projects-home">
        <div class="projects-home__inner container grid-columns-l--12">
            <?php foreach( $projects_home[ 'items' ] as $item_project ) : ?>
                <?php 
                    $span  = !empty( $item_project['col_span'] ) ? (int) $item_project[ 'col_span' ] : 10;
                    $start = !empty( $item_project['col_start'] ) ? $item_project[ 'col_start' ] : 'auto';
                    // Data item project
                    $data_item_project = array(
                        'item_project' => $item_project,
                        'col_span'     => max( 1, min( 10, $span ) ),
                        'col_span_mobile'  => ($mspan === 1 ? 1 : 2),
                    );
                    
                    // Item project home
                    get_template_part( 'template-parts/components/molecules/item-project-home', null, array( 'data' => $data_item_project ) ); 
                ?>
            <?php endforeach; ?>
        </div>
    </section>
    <!-- End projects home -->
<?php endif; ?>