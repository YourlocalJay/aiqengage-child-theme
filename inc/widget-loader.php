<?php
/**
 * AIQEngage Elementor Widget Loader
 * 
 * @package     AIQEngage_Child
 * @version     1.0.2
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

        // Get all widget files matching multiple patterns
        $widget_files = [];
        
        // Pattern 1: class-*-widget.php (standard naming)
        $pattern_1 = glob($widgets_dir . 'class-*-widget.php');
        if ($pattern_1) {
            $widget_files = array_merge($widget_files, $pattern_1);
        }
        
        // Pattern 2: aiq-*-widget.php (legacy naming)
        $pattern_2 = glob($widgets_dir . 'aiq-*-widget.php');
        if ($pattern_2) {
            $widget_files = array_merge($widget_files, $pattern_2);
        }
        
        // Remove duplicates
        $widget_files = array_unique($widget_files);

        if (WP_DEBUG && !empty($widget_files)) {
            error_log('AIQEngage: Found ' . count($widget_files) . ' widget files: ' . implode(', ', array_map('basename', $widget_files)));
        }

        // Require each widget file and collect class names
        $widget_classes = [];
        foreach ($widget_files as $file) {
            $class_name = aiqengage_child_process_widget_file($file);
            if ($class_name) {
                $widget_classes[] = $class_name;
            }
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

            // Extract class name from filename using improved logic
            $filename = basename($file, '.php');
            $class_name = aiqengage_child_filename_to_class_name($filename);

            if (WP_DEBUG) {
                error_log("AIQEngage: Processing widget file: $filename -> $class_name");
            }

            // Verify the class exists and extends Widget_Base
            if (class_exists($class_name) && is_subclass_of($class_name, '\\Elementor\\Widget_Base')) {
                if (WP_DEBUG) {
                    error_log("AIQEngage: Successfully loaded widget class: $class_name");
                }
                return $class_name;
            }

            if (WP_DEBUG) {
                if (!class_exists($class_name)) {
                    error_log("AIQEngage: Widget class {$class_name} does not exist in file {$filename}");
                } else {
                    error_log("AIQEngage: Widget class {$class_name} doesn't extend \\Elementor\\Widget_Base");
                }
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
     * Convert filename to class name with proper AIQ_ prefix handling
     * 
     * @param string $filename Widget filename without extension
     * @return string Expected class name
     */
    function aiqengage_child_filename_to_class_name($filename) {
        // Handle different filename patterns
        if (strpos($filename, 'class-') === 0) {
            // Remove 'class-' prefix
            $name_part = substr($filename, 6);
        } elseif (strpos($filename, 'aiq-') === 0) {
            // Remove 'aiq-' prefix (legacy naming)
            $name_part = substr($filename, 4);
        } else {
            // Use full filename
            $name_part = $filename;
        }
        
        // Remove '-widget' suffix if present
        if (substr($name_part, -7) === '-widget') {
            $name_part = substr($name_part, 0, -7);
        }
        
        // Convert hyphenated name to class name format
        // Split by hyphens, capitalize each part, join with underscores
        $parts = explode('-', $name_part);
        $formatted_parts = array_map('ucfirst', $parts);
        $class_suffix = implode('_', $formatted_parts);
        
        // Always use AIQ_ prefix for our widgets
        return 'AIQ_' . $class_suffix . '_Widget';
    }

    /**
     * Register widgets with Elementor
     * 
     * @param array $widget_classes Array of valid widget class names
     */
    function aiqengage_child_register_with_elementor($widget_classes) {
        // Early exit if Elementor is not loaded properly
        if (!class_exists('\\Elementor\\Plugin') || !isset(\\Elementor\\Plugin::instance()->widgets_manager)) {
            if (WP_DEBUG) {
                error_log('AIQEngage: Elementor Plugin or widgets_manager not available');
            }
            return;
        }
            
        $widget_manager = \\Elementor\\Plugin::instance()->widgets_manager;
        $registered_count = 0;
        $failed_widgets = [];

        foreach ($widget_classes as $class) {
            if ($class) {
                try {
                    $widget_instance = new $class();
                    $widget_manager->register($widget_instance);
                    $registered_count++;
                    
                    if (WP_DEBUG) {
                        error_log("AIQEngage: Successfully registered widget: {$class}");
                    }
                } catch (Exception $e) {
                    $failed_widgets[] = $class;
                    if (WP_DEBUG) {
                        error_log("AIQEngage: Failed to register widget {$class} - " . $e->getMessage());
                    }
                }
            }
        }
        
        // Log summary
        if (WP_DEBUG) {
            if ($registered_count > 0) {
                error_log("AIQEngage: Successfully registered {$registered_count} widgets");
            }
            if (!empty($failed_widgets)) {
                error_log("AIQEngage: Failed to register widgets: " . implode(', ', $failed_widgets));
            }
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
