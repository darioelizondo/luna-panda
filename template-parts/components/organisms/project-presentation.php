<?php

    /**
     * Component: Organism: Project Presentation
     * 
     * @package Darío Elizondo
     * 
     */

    $term = isset($_GET['cat']) ? sanitize_text_field($_GET['cat']) : '';

?>

<!-- Project presentation -->
<div class="project-presentation">
    <div class="project-presentation__inner container grid-columns-l--12" data-projects-results data-term="<?php echo esc_attr($term); ?>" data-max-pages="<?php echo esc_attr($max_pages); ?>">
        <!-- Populated by JS -->
    </div>
    
    <!-- Sentinel -->
    <div class="projects-sentinel" data-infinite-sentinel></div>
    <!-- End sentinel -->

</div>
<!-- End project presentation -->