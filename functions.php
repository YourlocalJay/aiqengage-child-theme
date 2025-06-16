<?php
/**
 * AIQEngage Child Theme Functions
 * 
 * This file contains functions specific to the AIQEngage child theme,
 * primarily focused on optimizing CSS loading and widget registration.
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

/**
 * Enqueue parent theme styles and child theme styles
 */
function aiqengage_child_enqueue_styles() {
    // Enqueue parent theme's style.css
    wp_enqueue_style(
        'parent-style',
        get_template_directory_uri() . '/style.css',
        array(),
        wp_get_theme()->get('Version')
    );

    // Enqueue child theme's main CSS with variables and shared styles
    wp_enqueue_style(
        'aiqengage-main',
        get_stylesheet_directory_uri() . '/css/main.css',
        array('parent-style'),
        wp_get_theme('aiqengage-child-theme')->get('Version')
    );

    // Load widget-specific CSS files only when needed
    aiqengage_load_widget_styles();
}
add_action('wp_enqueue_scripts', 'aiqengage_child_enqueue_styles');

/**
 * Define widget mappings for CSS files
 * This maps widget names to their corresponding CSS files
 * 
 * @return array Widget mapping array
 */
function aiqengage_get_widget_css_mapping() {
    return array(
        'prompt-card' => 'prompt-card.css',
        'metric-badge' => 'metric-badge.css',
        'blueprint-flow' => 'blueprint-flow.css',
        'comparison-matrix' => 'comparison-matrix.css',
        'testimonial-card' => 'testimonial-card.css',
        'value-timeline' => 'value-timeline.css',
        'feature-section' => 'feature-section.css',
        'cta-banner' => 'cta-banner.css'
    );
}

/**
 * Check if specific Elementor widgets are used on a page
 * 
 * @param int $post_id The post ID to check
 * @param array $widget_names Array of widget names to check for
 * @return array List of widget names that are used on the page
 */
function aiqengage_check_elementor_widgets_on_page($post_id, $widget_names) {
    // Get Elementor controls usage data
    $elementor_data = get_post_meta($post_id, '_elementor_controls_usage', true);
    
    // If no Elementor data or not an array, return empty array
    if (empty($elementor_data) || !is_array($elementor_data)) {
        return array();
    }
    
    // Initialize array to track which widgets are used
    $used_widgets = array();
    
    // Check each widget name against the Elementor data
    foreach ($widget_names as $widget_name) {
        if (array_key_exists($widget_name, $elementor_data)) {
            $used_widgets[] = $widget_name;
        }
    }
    
    return $used_widgets;
}

/**
 * Load widget-specific CSS files only when needed
 * This function checks the current page for widget usage and only loads
 * the CSS files for widgets that are actually used.
 */
function aiqengage_load_widget_styles() {
    // Get current post ID
    $post_id = get_the_ID();
    
    // Skip if no post ID (like on 404 pages)
    if (!$post_id) {
        // Load all widget styles on archive/category pages or when post ID isn't available
        aiqengage_load_all_widget_styles();
        return;
    }
    
    // Get widget CSS mapping
    $widget_mapping = aiqengage_get_widget_css_mapping();
    
    // Check which widgets are used on the current page
    $used_widgets = aiqengage_check_elementor_widgets_on_page($post_id, array_keys($widget_mapping));
    
    // If no widgets are detected, load all styles as fallback
    // This ensures styles are loaded if the detection fails
    if (empty($used_widgets)) {
        aiqengage_load_all_widget_styles();
        return;
    }
    
    // Load CSS only for widgets used on the page
    foreach ($used_widgets as $widget_name) {
        if (isset($widget_mapping[$widget_name])) {
            $css_file = $widget_mapping[$widget_name];
            wp_enqueue_style(
                'aiqengage-widget-' . $widget_name,
                get_stylesheet_directory_uri() . '/css/widgets/' . $css_file,
                array('aiqengage-main'),
                wp_get_theme('aiqengage-child-theme')->get('Version')
            );
        }
    }
}

/**
 * Load all widget styles as a fallback
 * Used on archive pages or when widget detection fails
 */
function aiqengage_load_all_widget_styles() {
    $widget_mapping = aiqengage_get_widget_css_mapping();
    
    foreach ($widget_mapping as $widget_name => $css_file) {
        wp_enqueue_style(
            'aiqengage-widget-' . $widget_name,
            get_stylesheet_directory_uri() . '/css/widgets/' . $css_file,
            array('aiqengage-main'),
            wp_get_theme('aiqengage-child-theme')->get('Version')
        );
    }
}

/**
 * Add admin-specific styles for Elementor editor
 */
function aiqengage_admin_styles() {
    if (is_admin()) {
        // Only load in Elementor editor
        if (isset($_GET['action']) && $_GET['action'] === 'elementor') {
            wp_enqueue_style(
                'aiqengage-admin-editor',
                get_stylesheet_directory_uri() . '/css/admin/editor.css',
                array(),
                wp_get_theme('aiqengage-child-theme')->get('Version')
            );
        }
    }
}
add_action('admin_enqueue_scripts', 'aiqengage_admin_styles');

/**
 * Register custom Elementor widgets
 */
function aiqengage_register_elementor_widgets() {
    // Make sure Elementor is active
    if (!did_action('elementor/loaded')) {
        return;
    }
    
    // Require widget files
    require_once(get_stylesheet_directory() . '/widgets/class-prompt-card-widget.php');
    require_once(get_stylesheet_directory() . '/widgets/class-metric-badge-widget.php');
    require_once(get_stylesheet_directory() . '/widgets/class-blueprint-flow-widget.php');
    require_once(get_stylesheet_directory() . '/widgets/class-comparison-matrix-widget.php');
    require_once(get_stylesheet_directory() . '/widgets/class-testimonial-card-widget.php');
    require_once(get_stylesheet_directory() . '/widgets/class-value-timeline-widget.php');
    require_once(get_stylesheet_directory() . '/widgets/class-feature-section-widget.php');
    require_once(get_stylesheet_directory() . '/widgets/class-cta-banner-widget.php');
    
    // Register widgets
    \Elementor\Plugin::instance()->widgets_manager->register_widget_type(new \AIQEngage\Widgets\Prompt_Card_Widget());
    \Elementor\Plugin::instance()->widgets_manager->register_widget_type(new \AIQEngage\Widgets\Metric_Badge_Widget());
    \Elementor\Plugin::instance()->widgets_manager->register_widget_type(new \AIQEngage\Widgets\Blueprint_Flow_Widget());
    \Elementor\Plugin::instance()->widgets_manager->register_widget_type(new \AIQEngage\Widgets\Comparison_Matrix_Widget());
    \Elementor\Plugin::instance()->widgets_manager->register_widget_type(new \AIQEngage\Widgets\Testimonial_Card_Widget());
    \Elementor\Plugin::instance()->widgets_manager->register_widget_type(new \AIQEngage\Widgets\Value_Timeline_Widget());
    \Elementor\Plugin::instance()->widgets_manager->register_widget_type(new \AIQEngage\Widgets\Feature_Section_Widget());
    \Elementor\Plugin::instance()->widgets_manager->register_widget_type(new \AIQEngage\Widgets\CTA_Banner_Widget());
}
add_action('elementor/widgets/widgets_registered', 'aiqengage_register_elementor_widgets');

/**
 * Register custom widget categories for Elementor
 *
 * @param \Elementor\Elements_Manager $elements_manager Elementor elements manager
 */
function aiqengage_register_widget_categories($elements_manager) {
    $elements_manager->add_category(
        'aiqengage',
        [
            'title' => __('AIQEngage', 'aiqengage-child-theme'),
            'icon' => 'fa fa-plug',
        ]
    );
}
add_action('elementor/elements/categories_registered', 'aiqengage_register_widget_categories');
