<?php

    /**
     * Component: Molecule: Project item home
     *
     * @package Darío Elizondo
     * 
     */

    $data              = $args['data'] ?? null;
    $data_item_project = $data['item_project'] ?? null;
    $mstart            = $data_item_project[ 'item_project' ]['col_start_mobile'] ?? 1;
    $mspan             = $data_item_project[ 'item_project' ]['col_span_mobile'] ?? 1;
    $start             = $data_item_project[ 'item_project' ]['col_start'] ?? 2;
    $span              = $data_item_project[ 'item_project' ]['col_span'] ?? 10;
    $offset_x_m        = $data_item_project[ 'item_project' ]['offset_x_m'] ?? 0;
    $offset_y_m        = $data_item_project[ 'item_project' ]['offset_y_m'] ?? 0;
    $offset_x          = $data_item_project[ 'item_project' ]['offset_x'] ?? 0;
    $offset_y          = $data_item_project[ 'item_project' ]['offset_y'] ?? 0;
    $z_index           = $data_item_project[ 'item_project' ]['z_index'] ?? 0;

    $style  = '--m-start:' . (int)$mstart . '; --m-span:' . (int)$mspan . '; --start:' . (int)$start . '; --span:' . (int)$span . ';';
    $style .= ' --oxm:' . (int)$offset_x_m . 'px; --oym:' . (int)$offset_y_m . 'px;';
    $style .= ' --ox:' . (int)$offset_x . 'px; --oy:' . (int)$offset_y . 'px;';
    $style .= ' --zi:' . (int)$z_index . ';';

?>

<?php if( isset( $data[ 'item_project' ] ) && !empty( $data[ 'item_project' ] ) ) : ?>
    <!-- Project item home -->
    <div class="project-item-home" style="<?php echo esc_attr($style); ?>" data-span="<?php echo esc_attr((int)($span ?? 10)); ?>">
        <div class="project-item-home__inner project-item-home--motion">
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
    <!-- End project item home -->
<?php endif; ?>