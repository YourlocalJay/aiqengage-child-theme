<?php
/**
 * AIQEngage Child Theme Functions
 *
 * @package AIQEngage Child Theme
 */

// Exit if accessed directly
if (!defined('ABSPATH')) {
    exit;
}

/**
 * Enqueue parent theme and child theme styles
 */
function aiqengage_child_enqueue_styles() {
    $parent_style = 'hello-elementor-style';
    
    // Enqueue parent theme style
    wp_enqueue_style(
        $parent_style,
        get_template_directory_uri() . '/style.css',
        array(),
        wp_get_theme('hello-elementor')->get('Version')
    );
    
    // Enqueue child theme style
    wp_enqueue_style(
        'aiqengage-child-style',
        get_stylesheet_directory_uri() . '/style.css',
        array($parent_style),
        wp_get_theme()->get('Version')
    );
}
add_action('wp_enqueue_scripts', 'aiqengage_child_enqueue_styles');

/**
 * Include custom Elementor widgets
 */
function aiqengage_include_widgets() {
    // Include the widgets file that was causing the error
    $widgets_file = get_stylesheet_directory() . '/aiqengage-widgets.php';
    
    if (file_exists($widgets_file)) {
        require_once $widgets_file;
    }
}
add_action('after_setup_theme', 'aiqengage_include_widgets');

/**
 * Add theme support for features already in the parent theme
 */
function aiqengage_child_theme_setup() {
    // Add default posts and comments RSS feed links to head
    add_theme_support('automatic-feed-links');

    // Let WordPress manage the document title
    add_theme_support('title-tag');

    // Enable support for Post Thumbnails on posts and pages
    add_theme_support('post-thumbnails');

    // Add support for core custom logo
    add_theme_support(
        'custom-logo',
        array(
            'height'      => 250,
            'width'       => 250,
            'flex-width'  => true,
            'flex-height' => true,
        )
    );
}
add_action('after_setup_theme', 'aiqengage_child_theme_setup');
