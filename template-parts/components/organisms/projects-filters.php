<?php
/**
 * Component: Organism: Projects Filters
 *
 * @package Darío Elizondo
 */

if ( ! defined( 'ABSPATH' ) ) exit;

if ( ! function_exists( 'de_get_projects_page_url' ) ) {
    function de_get_projects_page_url() {
        $pages = get_pages([
            'meta_key'   => '_wp_page_template',
            'meta_value' => 'templates/page-projects.php',
            'number'     => 1,
        ]);

        if ( ! empty( $pages ) ) {
            return get_permalink( $pages[0]->ID );
        }

        // Fallback
        return home_url( '/projects/' );
    }
}

$terms = get_terms([
    'taxonomy'   => 'project_category',
    'hide_empty' => true,
]);

$is_projects_page  = is_page_template( 'templates/page-projects.php' );
$is_single_project = is_singular( 'project' );

if ( is_wp_error( $terms ) || empty( $terms ) ) return;
if ( ! $is_projects_page && ! $is_single_project ) return;

$projects_page_url = de_get_projects_page_url();

// Modo del componente
$filter_mode = $is_projects_page ? 'ajax' : 'links';

// Term activo
$active_term_slug = '';

if ( isset( $_GET['cat'] ) && ! empty( $_GET['cat'] ) ) {
    $active_term_slug = sanitize_text_field( wp_unslash( $_GET['cat'] ) );
} elseif ( $is_single_project ) {
    $project_terms = get_the_terms( get_the_ID(), 'project_category' );
    if ( ! is_wp_error( $project_terms ) && ! empty( $project_terms ) ) {
        $active_term_slug = $project_terms[0]->slug;
    }
}

// Título actual para el pseudo-breadcrumb
$current_project_title = $is_single_project ? get_the_title() : '';
?>

<!-- Projects filters -->
<div
    class="projects-filters"
    data-projects-filters
    data-filter-mode="<?php echo esc_attr( $filter_mode ); ?>"
    data-projects-url="<?php echo esc_url( $projects_page_url ); ?>"
>
    <div class="projects-filters__inner container">

        <?php if ( $is_projects_page ) : ?>
            <button
                class="projects-filters__button <?php echo empty( $active_term_slug ) ? 'is-active' : ''; ?>"
                type="button"
                data-filter-term=""
            >
                All projects
            </button>
        <?php else : ?>
            <a
                class="projects-filters__button <?php echo empty( $active_term_slug ) ? 'is-active' : ''; ?>"
                href="<?php echo esc_url( $projects_page_url ); ?>"
                data-filter-term=""
            >
                All projects
            </a>
        <?php endif; ?>

        <?php foreach ( $terms as $term ) : ?>
            <?php
                $is_active = $active_term_slug === $term->slug;
                $term_url  = add_query_arg( 'cat', $term->slug, $projects_page_url );
            ?>

            <?php if ( $is_projects_page ) : ?>
                <button
                    class="projects-filters__button <?php echo $is_active ? 'is-active' : ''; ?>"
                    type="button"
                    data-filter-term="<?php echo esc_attr( $term->slug ); ?>"
                >
                    <?php echo esc_html( $term->name ); ?>
                </button>
            <?php else : ?>
                <a
                    class="projects-filters__button <?php echo $is_active ? 'is-active' : ''; ?>"
                    href="<?php echo esc_url( $term_url ); ?>"
                    data-filter-term="<?php echo esc_attr( $term->slug ); ?>"
                >
                    <?php echo esc_html( $term->name ); ?>
                </a>
            <?php endif; ?>
        <?php endforeach; ?>

    </div>

    <!-- Current project -->
    <div class="project-filters__current-project">
        <?php if ( $is_single_project && ! empty( $current_project_title ) ) : ?>
            <p class="projects-filters__current-title" aria-current="page">
                <?php echo esc_html( $current_project_title ); ?> ☜
            </p>
        <?php endif; ?>
    </div>
    
</div>



<!-- End projects filters -->