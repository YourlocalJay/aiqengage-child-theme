<?php
/**
 * AIQEngage Child Theme - Core Functionality
 *
 * @package     AIQEngage_Child
 * @version     1.0.1
 * @author      AIQEngage Team
 * @copyright   Copyright (c) 2025, AIQEngage
 * @license     GPL-3.0+
 * @link        https://aiqengage.com
 */

// Exit if accessed directly
defined('ABSPATH') || exit;

// Define theme constants
define('AIQENGAGE_CHILD_VERSION', wp_get_theme()->get('Version'));
define('AIQENGAGE_CHILD_PATH', trailingslashit(get_stylesheet_directory()));
define('AIQENGAGE_CHILD_URL', trailingslashit(get_stylesheet_directory_uri()));

/**
 * Theme Setup
 */
function aiqengage_child_theme_setup() {
    // Load text domain
    load_child_theme_textdomain('aiqengage-child', AIQENGAGE_CHILD_PATH . 'languages');
    
    // Add theme support
    add_theme_support('post-thumbnails');
    add_theme_support('html5', ['comment-list', 'comment-form', 'search-form', 'gallery', 'caption']);
    add_theme_support('align-wide');
    
    // Register nav menus
    register_nav_menus([
        'primary' => __('Primary Menu', 'aiqengage-child'),
        'footer'  => __('Footer Menu', 'aiqengage-child')
    ]);
}
add_action('after_setup_theme', 'aiqengage_child_theme_setup');

/**
 * Load Required Files
 */
function aiqengage_child_load_includes() {
    $includes = [
        '/inc/class-autoloader.php',    // PSR-4 autoloader
        '/inc/widget-loader.php',       // Elementor widgets
        '/inc/css-loader.php',          // Asset management
        '/inc/template-registrations.php', // Template library
        '/inc/customizer.php',          // Theme customizations
        '/inc/utilities.php'            // Helper functions
    ];
    
    foreach ($includes as $file) {
        $filepath = AIQENGAGE_CHILD_PATH . ltrim($file, '/');
        if (file_exists($filepath)) {
            require_once $filepath;
        } else {
            error_log(sprintf('Missing required file: %s', $filepath));
        }
    }
}
add_action('after_setup_theme', 'aiqengage_child_load_includes');

/**
 * Enqueue Theme Assets
 */
function aiqengage_child_enqueue_assets() {
    // Parent theme styles
    wp_enqueue_style(
        'hello-elementor',
        get_template_directory_uri() . '/style.css',
        [],
        AIQENGAGE_CHILD_VERSION
    );
    
    // Child theme styles
    wp_enqueue_style(
        'aiqengage-child',
        AIQENGAGE_CHILD_URL . 'assets/css/main.css',
        ['hello-elementor'],
        AIQENGAGE_CHILD_VERSION
    );
    
    // Modern JavaScript with feature detection
    wp_register_script(
        'aiqengage-child-runtime',
        AIQENGAGE_CHILD_URL . 'assets/js/runtime.js',
        [],
        AIQENGAGE_CHILD_VERSION,
        true
    );
    
    wp_register_script(
        'aiqengage-child-main',
        AIQENGAGE_CHILD_URL . 'assets/js/main.js',
        ['aiqengage-child-runtime'],
        AIQENGAGE_CHILD_VERSION,
        true
    );
    
    wp_enqueue_script('aiqengage-child-main');
    
    // Localize scripts
    wp_localize_script('aiqengage-child-main', 'aiqengageVars', [
        'ajaxurl' => admin_url('admin-ajax.php'),
        'nonce'   => wp_create_nonce('aiqengage_nonce'),
        'isRTL'   => is_rtl()
    ]);
}
add_action('wp_enqueue_scripts', 'aiqengage_child_enqueue_assets', 15);

/**
 * Register Elementor Widget Category
 */
function aiqengage_child_add_elementor_category($elements_manager) {
    $elements_manager->add_category('aiqengage', [
        'title' => esc_html__('AIQEngage Widgets', 'aiqengage-child'),
        'icon'  => 'eicon-aiqengage'
    ]);
}
add_action('elementor/elements/categories_registered', 'aiqengage_child_add_elementor_category');

/**
 * Theme Activation Hook
 */
function aiqengage_child_activation() {
    // Flush rewrite rules
    flush_rewrite_rules();
    
    // Initialize default settings
    if (!get_option('aiqengage_child_activated')) {
        update_option('aiqengage_child_activated', time());
    }
}
register_activation_hook(__FILE__, 'aiqengage_child_activation');

/**
 * Theme Deactivation Cleanup
 */
function aiqengage_child_deactivation() {
    // Cleanup temporary options
    delete_option('aiqengage_child_activated');
}
register_deactivation_hook(__FILE__, 'aiqengage_child_deactivation');
