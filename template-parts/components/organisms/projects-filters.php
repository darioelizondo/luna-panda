<?php
/**
 * Component: Organism: Projects Filters
 *
 * @package Darío Elizondo
 * 
 */

$terms = get_terms([
  'taxonomy'   => 'project_category',
  'hide_empty' => true,
]);
?>

<?php if ( !is_wp_error($terms) && !empty($terms) ) : ?>

    <!-- Projects filters -->
    <div class="projects-filters" data-projects-filters>
        <div class="projects-filters__inner container">

            <button class="projects-filters__button is-active" type="button" data-filter-term="">
                All projects
            </button>

            <?php foreach ( $terms as $term ) : ?>
            <button
                class="projects-filters__button"
                type="button"
                data-filter-term="<?php echo esc_attr($term->slug); ?>"
            >
                <?php echo esc_html($term->name); ?>
            </button>
            <?php endforeach; ?>

        </div>
    </div>
    <!-- End projects filters -->

<?php endif; ?>
