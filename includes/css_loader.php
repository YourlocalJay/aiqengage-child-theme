<?php
/**
 * AIQEngage Child Theme - CSS Loader
 *
 * Conditionally enqueues widget-specific CSS based on Elementor widgets used on the page.
 *
 * @package   AIQEngage_Child
 * @version   1.0.1
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
 * Adds resource hints for better performance.
 */
function aiqengage_add_resource_hints() {
    // Add preconnect for Google Fonts
    echo '<link rel="preconnect" href="https://fonts.googleapis.com">';
    echo '<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>';
    
    // Preload critical fonts
    echo '<link rel="preload" href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" as="style">';
    
    // Add preconnect for external resources (if needed)
    if (function_exists('elementor_pro_is_active') && elementor_pro_is_active()) {
        echo '<link rel="preconnect" href="https://fonts.googleapis.com">';
    }
}
add_action('wp_head', 'aiqengage_add_resource_hints', 1);

/**
 * Adds optimization for image loading.
 * 
 * @param array $attr Image attributes.
 * @return array Modified attributes.
 */
function aiqengage_optimize_image_loading($attr) {
    if (!isset($attr['loading'])) {
        $attr['loading'] = 'lazy';
    }
    
    if (!isset($attr['decoding'])) {
        $attr['decoding'] = 'async';
    }
    
    return $attr;
}
add_filter('wp_get_attachment_image_attributes', 'aiqengage_optimize_image_loading');

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

    // Enqueue only common CSS if no specific widgets detected
    if (!$enqueued) {
        $common_widgets = ['prompt-card', 'feature-section', 'cta-banner'];
        foreach ($common_widgets as $widget_name) {
            if (isset($mapping[$widget_name])) {
                $handle = "aiq-widget-{$widget_name}";
                wp_enqueue_style(
                    $handle,
                    trailingslashit(get_stylesheet_directory_uri()) . "assets/css/widgets/{$mapping[$widget_name]}",
                    ['aiqengage-child'],
                    AIQENGAGE_CHILD_VERSION
                );
            }
        }
    }
}
add_action('wp_enqueue_scripts', 'aiqengage_child_enqueue_widget_styles', 20);

/**
 * Add async/defer attributes to enqueued scripts when needed.
 *
 * @param string $tag    The <script> tag for the enqueued script.
 * @param string $handle The script's registered handle.
 * @return string Script tag with async/defer added if needed.
 */
function aiqengage_script_loader_tag($tag, $handle) {
    // Add async/defer to non-critical scripts
    $scripts_to_defer = ['aiqengage-child-animation', 'aiqengage-child-vendor'];
    $scripts_to_async = ['google-analytics', 'gtag'];
    
    if (in_array($handle, $scripts_to_defer, true)) {
        return str_replace(' src', ' defer src', $tag);
    }
    
    if (in_array($handle, $scripts_to_async, true)) {
        return str_replace(' src', ' async src', $tag);
    }
    
    return $tag;
}
add_filter('script_loader_tag', 'aiqengage_script_loader_tag', 10, 2);
