<?php

    /**
     * Component: Molecule: Project Item
     *
     * @package Darío Elizondo
     * 
     */

    $data        = $args['data'] ?? null;

    // Position
    $offset_x_m = (int)($data['offset_x_m'] ?? 0);
    $offset_y_m = (int)($data['offset_y_m'] ?? 0);
    $offset_x   = (int)($data['offset_x'] ?? 0);
    $offset_y   = (int)($data['offset_y'] ?? 0);

    // Project item style
    $style  = '--p-oxm:' . $offset_x_m . 'px; --p-oym:' . $offset_y_m . 'px;';
    $style .= '--p-ox:'  . $offset_x   . 'px; --p-oy:'  . $offset_y   . 'px;';


?>

<?php if ( !empty($data) ) : ?>
    <!-- Project item -->
    <div class="project-item" style="<?php echo esc_attr($style); ?>">
        <div class="project-item__inner">
            <?php 
                // Image project
                get_template_part( 'template-parts/components/atoms/image-project', null, array( 'data' => $data ) ); 
            ?>
            <?php 
                // Content project
                get_template_part( 'template-parts/components/atoms/content-project', null, array( 'data' => $data ) ); 
            ?>
        </div>
    </div>
    <!-- End project item -->
<?php endif; ?>