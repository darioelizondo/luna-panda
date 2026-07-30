<?php
/**
 * Component: Atom: Before / After Image Comparison
 *
 * @package Darío Elizondo
 */

if (!defined('ABSPATH')) exit;

require_once TD . '/inc/functions/layout-control.php';

$layout = $args['layout'] ?? '';
$comparison = get_sub_field('before_after_image_comparison');

if (!$layout || !is_array($comparison)) return;

$before_image = $comparison['before_image'] ?? null;
$after_image  = $comparison['after_image'] ?? null;

if (!is_array($before_image) || !is_array($after_image)) return;

$before_id = (int) ($before_image['ID'] ?? $before_image['id'] ?? 0);
$after_id  = (int) ($after_image['ID'] ?? $after_image['id'] ?? 0);

if (!$before_id || !$after_id) return;

$before_label = trim((string) ($comparison['before_label'] ?? '')) ?: __('Before', 'luna-panda');
$after_label  = trim((string) ($comparison['after_label'] ?? '')) ?: __('After', 'luna-panda');
$before_text  = (string) ($comparison['before_text'] ?? '');
$after_text   = (string) ($comparison['after_text'] ?? '');
$position     = isset($comparison['initial_position']) && is_numeric($comparison['initial_position'])
    ? (float) $comparison['initial_position']
    : 50;
$position     = max(0, min(100, $position));
$position     = round($position, 1);
$attrs        = layout_control_attrs($layout, 'layout-control', $layout);
$control_id   = wp_unique_id('before-after-control-');
$aria_label   = sprintf(
    /* translators: 1: before label, 2: after label. */
    __('Compare %1$s and %2$s images', 'luna-panda'),
    $before_label,
    $after_label
);
$image_attrs = [
    'class'    => $layout . '__image image--fluid',
    'loading'  => 'lazy',
    'decoding' => 'async',
    'sizes'    => '(min-width: 1024px) 50vw, 100vw',
];
?>

<!-- Before / After Image Comparison -->
<section class="before-after-image-comparison container grid-columns-l--12">
    <div <?= $attrs; ?> data-before-after data-after-label="<?= esc_attr($after_label); ?>">
        <div class="<?= esc_attr($layout); ?>__inner" style="--before-after-position: <?= esc_attr($position); ?>%;">
            <div class="<?= esc_attr($layout); ?>__labels" aria-hidden="true">
                <span class="<?= esc_attr($layout); ?>__label"><?= esc_html($before_label); ?></span>
                <span class="<?= esc_attr($layout); ?>__label"><?= esc_html($after_label); ?></span>
            </div>
    
            <div class="<?= esc_attr($layout); ?>__content <?= esc_attr($layout); ?>__content--before">
                <p class="<?= esc_attr($layout); ?>__title"><?= esc_html($before_label); ?></p>
                <?php if ($before_text !== '') : ?>
                    <div class="<?= esc_attr($layout); ?>__text"><?= wp_kses_post(wpautop($before_text)); ?></div>
                <?php endif; ?>
            </div>
    
            <div class="<?= esc_attr($layout); ?>__comparison">
                <div class="<?= esc_attr($layout); ?>__media" data-before-after-media>
                    <?= wp_get_attachment_image($before_id, 'full', false, array_merge($image_attrs, [
                        'class' => $layout . '__image ' . $layout . '__image--before image--fluid',
                    ])); ?>
    
                    <div class="<?= esc_attr($layout); ?>__after">
                        <?= wp_get_attachment_image($after_id, 'full', false, array_merge($image_attrs, [
                            'class' => $layout . '__image ' . $layout . '__image--after image--fluid',
                        ])); ?>
                    </div>
    
                    <span class="<?= esc_attr($layout); ?>__divider" aria-hidden="true">
                        <span class="<?= esc_attr($layout); ?>__handle"></span>
                    </span>
    
                    <label class="<?= esc_attr($layout); ?>__range-label" for="<?= esc_attr($control_id); ?>">
                        <?= esc_html($aria_label); ?>
                    </label>
                    <input
                        id="<?= esc_attr($control_id); ?>"
                        class="<?= esc_attr($layout); ?>__range"
                        data-before-after-range
                        type="range"
                        min="0"
                        max="100"
                        step="1"
                        value="<?= esc_attr($position); ?>"
                        aria-label="<?= esc_attr($aria_label); ?>"
                        aria-valuetext="<?= esc_attr(sprintf(__('%s percent after', 'luna-panda'), $position)); ?>"
                    >
                </div>
            </div>
    
            <div class="<?= esc_attr($layout); ?>__content <?= esc_attr($layout); ?>__content--after">
                <p class="<?= esc_attr($layout); ?>__title"><?= esc_html($after_label); ?></p>
                <?php if ($after_text !== '') : ?>
                    <div class="<?= esc_attr($layout); ?>__text"><?= wp_kses_post(wpautop($after_text)); ?></div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</section>
<!-- End Before / After Image Comparison -->
