<?php
/**
 * AIQEngage Elementor Widget Loader
 * 
 * @package     AIQEngage_Child
 * @version     1.0.0
 * @author      AIQEngage Team
 * @copyright   Copyright (c) 2023, AIQEngage
 * @license     GPL-3.0+
 */

// Exit if accessed directly
defined('ABSPATH') || exit;

if (!function_exists('aiqengage_child_load_elementor_widgets')) {
    /**
     * Main function to initialize widget loading
     */
    function aiqengage_child_load_elementor_widgets() {
        // Early exit if Elementor is not active
        if (!did_action('elementor/loaded')) {
            error_log('AIQEngage: Elementor plugin is not active. Widgets will not be loaded.');
            return;
        }

        // Hook widget registration to init
        add_action('init', 'aiqengage_child_register_widgets', 9);
    }

    /**
     * Scan and register all valid widget classes
     */
    function aiqengage_child_register_widgets() {
        $widgets_dir = get_stylesheet_directory() . '/widgets/';
        
        // Check if directory exists
        if (!file_exists($widgets_dir)) {
            error_log('AIQEngage: Widgets directory not found at ' . $widgets_dir);
            return;
        }

        // Get all widget files matching the pattern
        $widget_files = glob($widgets_dir . 'class-*-widget.php');

        // Require each widget file and collect class names
        $widget_classes = [];
        foreach ($widget_files as $file) {
            $widget_classes[] = aiqengage_child_process_widget_file($file);
        }

        // Register valid widgets with Elementor
        aiqengage_child_register_with_elementor($widget_classes);
    }

    /**
     * Process individual widget file
     * 
     * @param string $file Path to widget file
     * @return string|null Class name or null if invalid
     */
    function aiqengage_child_process_widget_file($file) {
        require_once $file;

        // Extract class name from filename
        $filename = basename($file, '.php');
        $class_name = str_replace('class-', '', $filename);
        $class_name = str_replace('-', '_', $class_name);
        $class_name = implode('_', array_map('ucfirst', explode('_', $class_name)));

        // Verify the class exists and extends Widget_Base
        if (class_exists($class_name) && is_subclass_of($class_name, '\Elementor\Widget_Base')) {
            return $class_name;
        }

        error_log("AIQEngage: Widget class {$class_name} is invalid or doesn't extend \Elementor\Widget_Base");
        return null;
    }

    /**
     * Register widgets with Elementor
     * 
     * @param array $widget_classes Array of valid widget class names
     */
    function aiqengage_child_register_with_elementor($widget_classes) {
        $widget_manager = \Elementor\Plugin::instance()->widgets_manager;

        foreach ($widget_classes as $class) {
            if ($class) {
                try {
                    $widget_manager->register(new $class());
                } catch (Exception $e) {
                    error_log("AIQEngage: Failed to register widget {$class} - " . $e->getMessage());
                }
            }
        }
    }

    // Initialize widget loading
    aiqengage_child_load_elementor_widgets();
}
