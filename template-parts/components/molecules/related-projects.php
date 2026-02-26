<?php

    /**
     * Component: Molecule: Related projects
     *
     * @package Darío Elizondo
     * 
     */

    $post_id = get_the_ID();
    $terms = get_the_terms($post_id, 'project_category');

    // Si no hay categorías, no mostramos nada (o podés fallback a random global)
    if (!empty($terms) && !is_wp_error($terms)) :

    $term_ids = wp_list_pluck($terms, 'term_id');

    $q = new WP_Query([
        'post_type'           => 'project',
        'posts_per_page'      => 3,
        'post__not_in'        => [$post_id],
        'orderby'             => 'rand',
        'ignore_sticky_posts' => true,
        'no_found_rows'       => true,
        'tax_query'           => [
        [
            'taxonomy' => 'project_category',
            'field'    => 'term_id',
            'terms'    => $term_ids,
        ],
        ],
    ]);

    if ($q->have_posts()) : ?>
        <!-- Related projects -->
        <section class="project-related">

            <div class="project-related__inner container">

                <div class="project-related__header">
                    <h3 class="project-related__title">
                        More amazing projects
                    </h3>
                </div>

                <div class="project-related__carousel swiper" data-related-projects-swiper>
                    <div class="swiper-wrapper project-related__grid">
                        <?php while ($q->have_posts()) : $q->the_post(); ?>
                            <?php
                                $title = get_the_title();
                                $url   = get_permalink();

                                // Imagen: featured image
                                $img_html = '';
                                if (has_post_thumbnail()) {
                                $img_html = get_the_post_thumbnail(get_the_ID(), 'large', [
                                    'class'   => 'project-related__img',
                                    'loading' => 'lazy',
                                ]);
                                }
                            ?>

                            <article class="swiper-slide project-related__item">
                                <a class="project-related__link" href="<?= esc_url($url); ?>">
                                <div class="project-related__media">
                                    <?= $img_html; ?>
                                </div>
                                <h3 class="project-related__card-title"><?= esc_html($title); ?></h3>
                                </a>
                            </article>
                        <?php endwhile; wp_reset_postdata(); ?>
                    </div>

                </div>

            </div>
        </section>
        <!-- End Related projects -->
    <?php endif; ?>

    <?php endif; ?>