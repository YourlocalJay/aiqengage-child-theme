<?php
/**
 * AIQEngage Child Theme Functions
 * 
 * @package AIQEngage-Child
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

/**
 * Enqueue parent theme styles, child theme styles, and custom scripts
 */
function aiqengage_child_enqueue_styles() {
    // Parent styles
    wp_enqueue_style('parent-style', get_template_directory_uri() . '/style.css');
    
    // Inter font from Google Fonts
    wp_enqueue_style('inter-font', 
        'https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700;800&display=swap',
        array(),
        null
    );
    
    // Child theme style
    wp_enqueue_style('child-style', 
        get_stylesheet_directory_uri() . '/style.css', 
        array('parent-style', 'inter-font')
    );
    
    // Main theme styles with proper colors and components
    wp_enqueue_style('aiqengage-main-styles', 
        get_stylesheet_directory_uri() . '/css/main.css',
        array('child-style'),
        '1.0.1'
    );
    
    // Custom scripts
    wp_enqueue_script('aiqengage-scripts', 
        get_stylesheet_directory_uri() . '/js/custom-scripts.js', 
        array('jquery'), 
        '1.0.1', 
        true
    );
    
    // Localize script for AJAX
    wp_localize_script('aiqengage-scripts', 'aiqengage_ajax', array(
        'ajaxurl' => admin_url('admin-ajax.php'),
        'nonce' => wp_create_nonce('aiqengage-ajax-nonce'),
        'is_elementor' => \Elementor\Plugin::$instance->preview->is_preview_mode(),
        'i18n' => array(
            'invalid_email' => __('Please enter a valid email address.', 'aiqengage'),
            'network_error' => __('Network error. Please try again.', 'aiqengage'),
            'show_prompt' => __('Show Prompt', 'aiqengage'),
            'hide_prompt' => __('Hide Prompt', 'aiqengage'),
            'see_results' => __('See Results', 'aiqengage'),
            'hide_results' => __('Hide Results', 'aiqengage')
        )
    ));
}
add_action('wp_enqueue_scripts', 'aiqengage_child_enqueue_styles');

/**
 * Allow SVG and WebP upload
 */
function aiqengage_allow_mime_types($mimes) {
    $mimes['svg'] = 'image/svg+xml';
    $mimes['webp'] = 'image/webp';
    return $mimes;
}
add_filter('upload_mimes', 'aiqengage_allow_mime_types');

/**
 * Add custom Elementor category for AIQEngage widgets
 */
function aiqengage_add_elementor_widget_categories($elements_manager) {
    $elements_manager->add_category(
        'aiqengage-elements',
        [
            'title' => __('AIQEngage Elements', 'aiqengage'),
            'icon' => 'fa fa-plug',
        ]
    );
}
add_action('elementor/elements/categories_registered', 'aiqengage_add_elementor_widget_categories');

/**
 * Include custom widgets
 */
require_once get_stylesheet_directory() . '/aiqengage-widgets.php';

/**
 * AJAX handler for lead form submissions
 */
function aiqengage_subscribe_handler() {
    // Verify nonce
    check_ajax_referer('aiqengage-ajax-nonce', 'security');
    
    // Get email
    $email = isset($_POST['email']) ? sanitize_email($_POST['email']) : '';
    
    if (!is_email($email)) {
        wp_send_json_error(array(
            'message' => __('Please enter a valid email address.', 'aiqengage')
        ));
    }
    
    // Here you would typically add the subscriber to your email service
    // For now, we'll just simulate success
    
    wp_send_json_success(array(
        'message' => __('Thank you for subscribing! Check your inbox shortly.', 'aiqengage'),
        'redirect' => site_url('/thank-you/') // Optional redirect
    ));
}
add_action('wp_ajax_aiqengage_subscribe', 'aiqengage_subscribe_handler');
add_action('wp_ajax_nopriv_aiqengage_subscribe', 'aiqengage_subscribe_handler');

/**
 * Add custom body classes
 */
function aiqengage_body_classes($classes) {
    $classes[] = 'aiqengage-theme';
    
    // Add page-specific classes
    if (is_page('vault')) {
        $classes[] = 'vault-page';
    } elseif (is_page('tools')) {
        $classes[] = 'tools-page';
    } elseif (is_page('automation-hub')) {
        $classes[] = 'automation-hub-page';
    }
    
    return $classes;
}
add_filter('body_class', 'aiqengage_body_classes');

/**
 * Register a custom navigation location
 */
function aiqengage_register_menus() {
    register_nav_menus(array(
        'primary' => __('Primary Menu', 'aiqengage'),
        'footer' => __('Footer Menu', 'aiqengage'),
        'legal' => __('Legal Links', 'aiqengage'),
    ));
}
add_action('after_setup_theme', 'aiqengage_register_menus');
