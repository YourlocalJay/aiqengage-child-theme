<?php
/**
 * AIQEngage Elementor Widget Loader
 * 
 * @package     AIQEngage_Child
 * @version     1.0.1
 * @author      AIQEngage Team
 * @copyright   Copyright (c) 2025, AIQEngage
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
            if (WP_DEBUG) {
                error_log('AIQEngage: Elementor plugin is not active. Widgets will not be loaded.');
            }
            return;
        }

        // Hook widget registration to init
        add_action('init', 'aiqengage_child_register_widgets', 9);
        
        // Register conversion tracking script
        add_action('wp_enqueue_scripts', 'aiqengage_register_conversion_script', 20);
    }

    /**
     * Register conversion tracking script for enhanced conversion tracking
     */
    function aiqengage_register_conversion_script() {
        // Only load on frontend and not for admin users
        if (is_admin() || current_user_can('manage_options')) {
            return;
        }
        
        // Register but don't enqueue yet - will be loaded on demand
        wp_register_script(
            'aiqengage-conversion-tracking',
            AIQENGAGE_CHILD_URL . 'assets/js/conversion-tracking.js',
            ['jquery'],
            AIQENGAGE_CHILD_VERSION,
            true
        );
        
        // Add inline initialization code
        wp_add_inline_script('aiqengage-conversion-tracking', '
            document.addEventListener("DOMContentLoaded", function() {
                // Progressive disclosure pattern for complex features
                const progressiveReveal = () => {
                  document.querySelectorAll(".feature-reveal").forEach(container => {
                    const triggers = container.querySelectorAll(".reveal-trigger");
                    const content = container.querySelector(".reveal-content");
                    
                    if (!triggers.length || !content) return;
                    
                    // Show minimal content first
                    content.setAttribute("aria-hidden", "true");
                    
                    // Add interaction for revealing more
                    triggers.forEach(trigger => {
                      trigger.addEventListener("click", () => {
                        content.setAttribute("aria-hidden", "false");
                        content.classList.add("revealed");
                        
                        // Track engagement
                        if (window.gtag) {
                          gtag("event", "feature_expand", {
                            "feature_name": container.dataset.feature || "unknown"
                          });
                        }
                      });
                    });
                  });
                };
                
                // Initialize progressive reveal
                progressiveReveal();
            });
        ');
    }

    /**
     * Scan and register all valid widget classes
     */
    function aiqengage_child_register_widgets() {
        $widgets_dir = get_stylesheet_directory() . '/widgets/';
        
        // Check if directory exists
        if (!file_exists($widgets_dir)) {
            if (WP_DEBUG) {
                error_log('AIQEngage: Widgets directory not found at ' . $widgets_dir);
            }
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
        try {
            require_once $file;

            // Extract class name from filename
            $filename = basename($file, '.php');
            $class_name = str_replace('class-', '', $filename);
            $class_name = str_replace('-', '_', $class_name);
            $class_name = implode('_', array_map('ucfirst', explode('_', $class_name)));

            // Verify the class exists and extends Widget_Base
            if (class_exists($class_name) && is_subclass_of($class_name, '\\Elementor\\Widget_Base')) {
                return $class_name;
            }

            if (WP_DEBUG) {
                error_log("AIQEngage: Widget class {$class_name} is invalid or doesn't extend \\Elementor\\Widget_Base");
            }
            return null;
        } catch (Exception $e) {
            if (WP_DEBUG) {
                error_log("AIQEngage: Error loading widget file {$file}: " . $e->getMessage());
            }
            return null;
        }
    }

    /**
     * Register widgets with Elementor
     * 
     * @param array $widget_classes Array of valid widget class names
     */
    function aiqengage_child_register_with_elementor($widget_classes) {
        // Early exit if Elementor is not loaded properly
        if (!class_exists('\\Elementor\\Plugin') || !isset(\\Elementor\\Plugin::instance()->widgets_manager)) {
            return;
        }
            
        $widget_manager = \\Elementor\\Plugin::instance()->widgets_manager;
        $registered_count = 0;

        foreach ($widget_classes as $class) {
            if ($class) {
                try {
                    $widget_manager->register(new $class());
                    $registered_count++;
                } catch (Exception $e) {
                    if (WP_DEBUG) {
                        error_log("AIQEngage: Failed to register widget {$class} - " . $e->getMessage());
                    }
                }
            }
        }
        
        // Log success message when widgets are registered
        if (WP_DEBUG && $registered_count > 0) {
            error_log("AIQEngage: Successfully registered {$registered_count} widgets");
        }
    }

    // Initialize widget loading
    aiqengage_child_load_elementor_widgets();
}

/**
 * Check if widgets directory exists and log error if not
 */
function aiqengage_check_widgets_directory() {
    $widgets_dir = get_stylesheet_directory() . '/widgets';
    
    if (!file_exists($widgets_dir) || !is_dir($widgets_dir)) {
        // Log error
        error_log('AIQEngage Child Theme: Required directory "widgets/" does not exist.');
        
        // Add admin notice if user is admin
        add_action('admin_notices', 'aiqengage_missing_widgets_notice');
    }
}
add_action('init', 'aiqengage_check_widgets_directory');

/**
 * Admin notice for missing widgets directory
 */
function aiqengage_missing_widgets_notice() {
    if (current_user_can('administrator')) {
        ?>
        <div class="notice notice-error">
            <p><?php _e('AIQEngage Child Theme: Required directory "widgets/" does not exist. Some features may not work properly.', 'aiqengage'); ?></p>
        </div>
        <?php
    }
}