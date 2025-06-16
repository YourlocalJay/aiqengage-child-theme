<?php
/**
 * AIQEngage Child Theme - Core Functionality
 *
 * @package     AIQEngage_Child
 * @version     1.0.2
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
    add_theme_support('align