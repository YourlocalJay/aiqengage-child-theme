<?php
/**
 * AIQEngage Child Theme - CSS Loader
 *
 * Conditionally enqueues widget-specific CSS based on Elementor widgets used on the page.
 *
 * @package   AIQEngage_Child
 * @version   1.0.0
 * @author    AIQEngage Team
 * @license   GPL-3.0+
 */

// Exit if accessed directly.
defined('ABSPATH') || exit;

/**
 * Returns mapping of Elementor widget names to their CSS files.
 *
 * @return array<string,string> Associative array of widget-name => css-filename.
 */
function aiqengage_get_widget_css_mapping() {
    return [
        'prompt-card'           => 'prompt-card.css',
        'metric-badge'          => 'metric-badge.css',
        'blueprint-flow'        => 'blueprint-flow.css',
        'comparison-matrix'     => 'comparison-matrix.css',
        'testimonial-card'      => 'testimonial-card.css',
        'value-timeline'        => 'value-timeline.css',
        'feature-section'       => 'feature-section.css',
        'cta-banner'            => 'cta-banner.css',
        'roi-calculator'        => 'roi-calculator.css',
        'pricing-table'         => 'pricing-table.css',
        'evergreen-countdown'   => 'evergreen-countdown.css',
        'resource-card'         => 'resource-card.css',
        'progress-bar'          => 'progress-bar.css',
        'exit-intent'           => 'exit-intent.css',
        'faq-accordion'         => 'faq-accordion.css',
        'tool-card'             => 'tool-card.css',
        'archive-loop'          => 'archive-loop.css',
    ];
}

/**
 * Enqueue widget CSS based on used widgets.
 */
function aiqengage_child_enqueue_widget_styles() {
    // Only run on front-end
    if (is_admin()) {
        return;
    }

    // Get mapping of widget names to CSS files
    $mapping = aiqengage_get_widget_css_mapping();

    // Try to detect Elementor widgets on this page
    $used_widgets = [];
    $post_id = get_queried_object_id();

    if ($post_id) {
        $data = get_post_meta($post_id, '_elementor_data', true);
        if (!empty($data)) {
            // Decode JSON structure
            $elements = json_decode($data, true);
            if (is_array($elements)) {
                array_walk_recursive($elements, function($value, $key) use (&$used_widgets) {
                    if ($key === 'widgetType') {
                        $used_widgets[] = $value;
                    }
                });
            }
        }
    }

    // Unique widget names
    $used_widgets = array_unique($used_widgets);

    // Enqueue each CSS file if its widget was used
    $enqueued = false;
    foreach ($mapping as $widget_name => $css_file) {
        if (in_array($widget_name, $used_widgets, true)) {
            $handle = "aiq-widget-{$widget_name}";
            wp_enqueue_style(
                $handle,
                trailingslashit(get_stylesheet_directory_uri()) . "assets/css/widgets/{$css_file}",
                ['aiqengage-child'],
                AIQENGAGE_CHILD_VERSION
            );
            $enqueued = true;
        }
    }

    // Fallback: if no widgets detected, enqueue all widget CSS files
    if (!$enqueued) {
        foreach ($mapping as $widget_name => $css_file) {
            $handle = "aiq-widget-{$widget_name}";
            wp_enqueue_style(
                $handle,
                trailingslashit(get_stylesheet_directory_uri()) . "assets/css/widgets/{$css_file}",
                ['aiqengage-child'],
                AIQENGAGE_CHILD_VERSION
            );
        }
    }
}
add_action('wp_enqueue_scripts', 'aiqengage_child_enqueue_widget_styles', 20);
