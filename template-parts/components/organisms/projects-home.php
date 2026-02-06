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

                    // Layout settings
                    $start_mobile = !empty( $item_project['col_start_mobile'] ) ? $item_project[ 'col_start_mobile' ] : 'auto';
                    $span_mobile = isset( $item_project['col_span_mobile'] ) ? (int) $item_project[ 'col_span_mobile' ] : 2;

                    $start = !empty( $item_project['col_start'] ) ? $item_project[ 'col_start' ] : 'auto';
                    $span  = !empty( $item_project['col_span'] ) ? (int) $item_project[ 'col_span' ] : 10;

                    // Style settings
                    $ox  = isset($item_project['offset_x']) ? (int) $item_project['offset_x'] : 0;
                    $oy  = isset($item_project['offset_y']) ? (int) $item_project['offset_y'] : 0;

                    $oxm = isset($item_project['offset_x_m']) ? (int) $item_project['offset_x_m'] : 0;
                    $oym = isset($item_project['offset_y_m']) ? (int) $item_project['offset_y_m'] : 0;

                    $z   = isset($item_project['z_index']) ? (int) $item_project['z_index'] : 0;

                    // Clamps
                    $ox  = max(-400, min(400, $ox));
                    $oy  = max(-400, min(400, $oy));
                    $oxm = max(-250,  min(250,  $oxm));
                    $oym = max(-250,  min(250,  $oym));
                    $z   = max(0,    min(20,  $z));

                    // Data item project
                    $data_item_project = array(
                        'item_project'     => $item_project,
                        'col_start_mobile' => $start_mobile,
                        'col_span_mobile'  => ( $span_mobile === 1 ? 1 : 2 ),
                        'col_start'        => $start,
                        'col_span'         => max( 1, min( 10, $span ) ),
                        'offset_x_m'       => $oxm,
                        'offset_y_m'       => $oym,
                        'offset_x'         => $ox,
                        'offset_y'         => $oy,
                        'z_index'          => $z,
                    );
                    
                    // Item project home
                    get_template_part( 'template-parts/components/molecules/item-project-home', null, array( 'data' => $data_item_project ) ); 
                ?>
            <?php endforeach; ?>
        </div>
    </section>
    <!-- End projects home -->
<?php endif; ?>