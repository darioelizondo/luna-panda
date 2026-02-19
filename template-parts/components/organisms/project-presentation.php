<?php

    /**
     * Component: Organism: Project Presentation
     * 
     * @package Darío Elizondo
     * 
     */

?>

<!-- Project presentation -->
<div class="project-presentation">
    <div class="project-presentation__inner container grid-columns-l--12" data-projects-results>

        <?php
            $query = new WP_Query([
                'post_type'      => 'project',
                'posts_per_page' => 12,
                'orderby'        => [
                'menu_order' => 'ASC',
                'date'       => 'DESC',
                ],
            ]);

            if ( $query->have_posts() ) :
                while ( $query->have_posts() ) : $query->the_post();

                $project_presentation = get_field('project_presentation', get_the_ID()) ?: [];

                // Elements
                $logo         = $project_presentation['project_logo'] ?? null;
                $project_tags = $project_presentation['project_tags'] ?? [];
                $short_line   = $project_presentation['project_short_line'] ?? '';

                // Layout settings - Mobile
                $image_mobile_col_span                 = (int)($project_presentation['layout_mobile']['image_mobile_col_span'] ?? 2);
                $content_mobile_col_span               = (int)($project_presentation['layout_mobile']['content_mobile_col_span'] ?? 2);
                $logo_mobile_col_span                  = (int)($project_presentation['layout_mobile']['logo_mobile_col_span'] ?? 1);
                $title_tags_mobile_col_span            = (int)($project_presentation['layout_mobile']['title_tags_mobile_col_span'] ?? 1);
                $short_line_button_mobile_col_span     = (int)($project_presentation['layout_mobile']['short_line_and_button_mobile_col_span'] ?? 1);

                // Layout settings - Desktop
                $image_col_span                        = (int)($project_presentation['layout_desktop']['image_col_span'] ?? 4);
                $content_col_span                      = (int)($project_presentation['layout_desktop']['content_col_span'] ?? 4);
                $logo_col_span                         = (int)($project_presentation['layout_desktop']['logo_col_span'] ?? 1);
                $title_tags_col_span                   = (int)($project_presentation['layout_desktop']['title_tags_col_span'] ?? 1);
                $short_line_button_col_span            = (int)($project_presentation['layout_desktop']['short_line_and_button_col_span'] ?? 1);

                // Offsets (desde ACF)
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

                endwhile;
                wp_reset_postdata();
            endif;
        ?>
    </div>
</div>
<!-- End project presentation -->