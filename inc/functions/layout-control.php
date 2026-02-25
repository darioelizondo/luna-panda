<?php

    /**
     * Function: Layout Control
     *
     * @package Darío Elizondo
     */

    if (!defined('ABSPATH')) exit;

    /**
     * Sanitize a list of classes (chain with spaces).
     */
    function td_sanitize_class_list($class_list = '') {
        $class_list = trim((string) $class_list);
        if ($class_list === '') return '';

        $parts = preg_split('/\s+/', $class_list);
        $parts = array_filter(array_map('sanitize_html_class', $parts));
        return implode(' ', $parts);
    }

    /**
     * Returns a normalized array with default values.
     */
    function get_layout_controls( $layout_name, $row = null) {

        $c = get_sub_field($layout_name)[ 'layout_controls' ] ?: [];

        return [
            'span_d'  => (int)($c['span_desktop'] ?? 12),
            'start_d' => (int)($c['start_desktop'] ?? 1),
            'span_m'  => (int)($c['span_mobile'] ?? 2),
            'start_m' => (int)($c['start_mobile'] ?? 1),

            'ox_d' => (int)($c['offset_x_desktop'] ?? 0),
            'oy_d' => (int)($c['offset_y_desktop'] ?? 0),
            'ox_m' => (int)($c['offset_x_mobile'] ?? 0),
            'oy_m' => (int)($c['offset_y_mobile'] ?? 0),

            'id'    => sanitize_title($c['html_id'] ?? ''),
            'class' => td_sanitize_class_list($c['extra_class'] ?? ''),
            'z'     => isset($c['z_index']) ? (int)$c['z_index'] : null,
        ];
    }

    /**
     * Generates HTML attributes for the module wrapper:
     * id, class, style (with CSS vars of grid/offset per breakpoint)
     */
    function layout_control_attrs( $layout_name, $base_class = 'layout-control', $extra_classes = '') {
        $c = get_layout_controls( $layout_name );

        // clamps
        $c['span_d']  = max(1, min(12, $c['span_d']));
        $c['start_d'] = max(1, min(12, $c['start_d']));
        $c['span_m']  = max(1, min(2, $c['span_m']));
        $c['start_m'] = max(1, min(2, $c['start_m']));

        $base_class   = td_sanitize_class_list($base_class);
        $extra_classes = td_sanitize_class_list($extra_classes);

        $classes = trim($base_class . ' ' . $extra_classes . ' ' . $c['class']);

        $style = [];
        // mobile
        $style[] = '--lc-span:' . $c['span_m'];
        $style[] = '--lc-start:' . $c['start_m'];
        $style[] = '--lc-ox:' . $c['ox_m'] . 'px';
        $style[] = '--lc-oy:' . $c['oy_m'] . 'px';
        // desktop
        $style[] = '--lc-d-span:' . $c['span_d'];
        $style[] = '--lc-d-start:' . $c['start_d'];
        $style[] = '--lc-d-ox:' . $c['ox_d'] . 'px';
        $style[] = '--lc-d-oy:' . $c['oy_d'] . 'px';

        if ($c['z'] !== null) {
            $style[] = 'z-index:' . $c['z'];
            $style[] = 'position:relative';
        }

        $attr = [];
        if (!empty($c['id'])) $attr[] = 'id="' . esc_attr($c['id']) . '"';
        $attr[] = 'class="' . esc_attr($classes) . '"';
        $attr[] = 'style="' . esc_attr(implode(';', $style)) . '"';

        return implode(' ', $attr);
    }