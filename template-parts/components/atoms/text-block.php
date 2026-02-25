<?php
    /**
     * 
     * Component: Atom: Text block
     * @package Darío Elizondo
     * 
     */

    require_once TD . '/inc/functions/layout-control.php';

    $layout = $args['layout'] ?? '';
    $attrs = layout_control_attrs( $layout , 'layout-control', $layout );

    $text_block = get_sub_field('text_block');

?>

<!-- Text block -->
<div <?= $attrs; ?>>
    <div class="<?php echo $layout; ?>__inner">
        <?php echo $text_block[ 'text' ]; ?>
    </div>
</div>
<!-- End text block -->