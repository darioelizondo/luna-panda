<?php
     /**
     * Function: Ajax projects filter
     * 
     * @package Darío Elizondo
     * 
     */

    if ( ! defined('ABSPATH') ) exit;

    /**
     * Render a single project card using your template part.
     * Ajustá el armado de $data_project si tus keys cambian.
     */

    function de_render_project_item($post_id) {
    $project_presentation = get_field('project_presentation', $post_id) ?: [];

    $logo         = $project_presentation['project_logo'] ?? null;
    $project_tags = $project_presentation['project_tags'] ?? [];
    $short_line   = $project_presentation['project_short_line'] ?? '';

    // Layout - Mobile
    $image_mobile_col_span                = (int)($project_presentation['layout_mobile']['image_mobile_col_span'] ?? 2);
    $content_mobile_col_span              = (int)($project_presentation['layout_mobile']['content_mobile_col_span'] ?? 2);
    $logo_mobile_col_span                 = (int)($project_presentation['layout_mobile']['logo_mobile_col_span'] ?? 1);
    $title_tags_mobile_col_span           = (int)($project_presentation['layout_mobile']['title_tags_mobile_col_span'] ?? 1);
    $short_line_button_mobile_col_span    = (int)($project_presentation['layout_mobile']['short_line_and_button_mobile_col_span'] ?? 1);

    // Layout - Desktop
    $image_col_span                       = (int)($project_presentation['layout_desktop']['image_col_span'] ?? 4);
    $content_col_span                     = (int)($project_presentation['layout_desktop']['content_col_span'] ?? 4);
    $logo_col_span                        = (int)($project_presentation['layout_desktop']['logo_col_span'] ?? 1);
    $title_tags_col_span                  = (int)($project_presentation['layout_desktop']['title_tags_col_span'] ?? 1);
    $short_line_button_col_span           = (int)($project_presentation['layout_desktop']['short_line_and_button_col_span'] ?? 1);

    // Offsets
    $oxm = (int)($project_presentation['offset_x_m'] ?? 0);
    $oym = (int)($project_presentation['offset_y_m'] ?? 0);
    $ox  = (int)($project_presentation['offset_x'] ?? 0);
    $oy  = (int)($project_presentation['offset_y'] ?? 0);

    // Clamps
    $oxm = max(-250, min(250, $oxm));
    $oym = max(-250, min(250, $oym));
    $ox  = max(-400, min(400, $ox));
    $oy  = max(-400, min(400, $oy));

    $data_project = [
        'logo'                                   => $logo,
        'project_tags'                           => $project_tags,
        'short_line'                             => $short_line,

        'image_mobile_col_span'                  => $image_mobile_col_span,
        'content_mobile_col_span'                => $content_mobile_col_span,
        'logo_mobile_col_span'                   => $logo_mobile_col_span,
        'title_tags_mobile_col_span'             => $title_tags_mobile_col_span,
        'short_line_and_button_mobile_col_span'  => $short_line_button_mobile_col_span,

        'image_col_span'                         => $image_col_span,
        'content_col_span'                       => $content_col_span,
        'logo_col_span'                          => $logo_col_span,
        'title_tags_col_span'                    => $title_tags_col_span,
        'short_line_and_button_col_span'         => $short_line_button_col_span,

        'offset_x_m'                             => $oxm,
        'offset_y_m'                             => $oym,
        'offset_x'                               => $ox,
        'offset_y'                               => $oy,
    ];

    get_template_part('template-parts/components/molecules/project-item', null, [
        'data' => $data_project
    ]);
    }

    /**
     * AJAX endpoint
     */
    add_action('wp_ajax_filter_projects', 'de_ajax_filter_projects');
    add_action('wp_ajax_nopriv_filter_projects', 'de_ajax_filter_projects');

    function de_ajax_filter_projects() {
        // Nonce check
        $nonce = isset($_POST['nonce']) ? sanitize_text_field($_POST['nonce']) : '';
        if ( ! wp_verify_nonce($nonce, 'de_projects_filter') ) {
            wp_send_json_error(['message' => 'Invalid nonce'], 403);
        }

        $term  = isset($_POST['term']) ? sanitize_text_field($_POST['term']) : '';
        $paged = isset($_POST['paged']) ? max(1, (int)$_POST['paged']) : 1;

        $tax_query = [];
        if ( $term !== '' ) {
            $tax_query[] = [
            'taxonomy' => 'project_category',
            'field'    => 'slug',
            'terms'    => $term,
            ];
        }

        $q = new WP_Query([
            'post_type'      => 'project',
            'posts_per_page' => 12,
            'paged'          => $paged,
            'orderby'        => [
            'menu_order' => 'ASC',
            'date'       => 'DESC',
            ],
            'tax_query'      => $tax_query,
        ]);

        ob_start();

        if ( $q->have_posts() ) {
            while ( $q->have_posts() ) {
            $q->the_post();
            de_render_project_item(get_the_ID());
            }
        } else {
            echo '<div class="projects-empty">No projects found.</div>';
        }

        wp_reset_postdata();

        $html = ob_get_clean();

        $has_more = ($paged < (int)$q->max_num_pages);

        wp_send_json_success([
            'html'       => $html,
            'foundPosts' => (int)$q->found_posts,
            'maxPages'   => (int)$q->max_num_pages,
            'paged'      => (int)$paged,
            'term'       => $term,
            'hasMore'    => $has_more,
        ]);

    }
