<?php
/**
 * Widget Autoloader for AIQEngage
 * 
 * Automatically loads and registers all widgets from the /widgets/ directory
 * 
 * @package AIQEngage-Child
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

/**
 * Widget Autoloader Class
 * 
 * Handles loading and registering of all widgets for AIQEngage
 */
class AIQEngage_Widget_Loader {
    /**
     * Store all widget classes
     */
    private $widgets = [];

    /**
     * Initialize the autoloader
     */
    public function __construct() {
        add_action('elementor/widgets/register', [$this, 'register_widgets']);
        $this->load_widget_files();
    }

    /**
     * Load all widget files from the widgets directory
     */
    private function load_widget_files() {
        $widget_dir = get_stylesheet_directory() . '/widgets/';
        
        // Skip if widgets directory doesn't exist
        if (!is_dir($widget_dir)) {
            return;
        }
        
        // Get all PHP files in the widgets directory
        $widget_files = glob($widget_dir . '*.php');
        
        if (!empty($widget_files)) {
            foreach ($widget_files as $file) {
                require_once $file;
                
                // Extract the class name from the file
                $this->extract_widget_class_from_file($file);
            }
        }
    }
    
    /**
     * Extract the widget class name from a file
     * 
     * @param string $file_path Path to the widget file
     */
    private function extract_widget_class_from_file($file_path) {
        // Get file contents
        $file_content = file_get_contents($file_path);
        
        // Use regex to find the class name
        if (preg_match('/class\s+(\w+)\s+extends\s+\\\\Elementor\\\\Widget_Base/i', $file_content, $matches)) {
            $class_name = $matches[1];
            
            // Check if class exists and is a widget
            if (class_exists($class_name) && is_subclass_of($class_name, '\Elementor\Widget_Base')) {
                $this->widgets[] = $class_name;
            }
        }
    }

    /**
     * Register all discovered widgets with Elementor
     * 
     * @param \Elementor\Widgets_Manager $widgets_manager Elementor widgets manager
     */
    public function register_widgets($widgets_manager) {
        foreach ($this->widgets as $widget) {
            if (class_exists($widget)) {
                $widgets_manager->register(new $widget());
            }
        }
    }
}

// Initialize the widget loader
new AIQEngage_Widget_Loader();
