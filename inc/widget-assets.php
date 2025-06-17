<?php
/**
 * AIQEngage Widget Asset Registration
 * 
 * @package     AIQEngage_Child
 * @version     1.0.1
 * @author      AIQEngage Team
 * @copyright   Copyright (c) 2025, AIQEngage
 * @license     GPL-3.0+
 */

// Exit if accessed directly
defined('ABSPATH') || exit;

/**
 * Register all widget assets for proper dependency handling
 */
function aiqengage_register_widget_assets() {
    // Only register assets, don't enqueue them - Elementor will handle enqueuing based on dependencies
    
    // Get asset version
    $version = AIQENGAGE_CHILD_VERSION;
    
    // Widget assets mapping - each widget handle maps to its CSS/JS files
    $widget_assets = [
        // Feature Section Widget
        'aiq-feature-section' => [
            'css' => 'assets/css/widgets/feature-section.css',
            'js'  => 'assets/js/widgets/feature-section.js',
            'deps' => ['jquery']
        ],
        
        // Prompt Card Widget
        'aiq-prompt-card' => [
            'css' => 'assets/css/widgets/prompt-card.css',
            'js'  => 'assets/js/widgets/prompt-card.js',
            'deps' => ['jquery']
        ],
        
        // CTA Banner Widget
        'aiq-cta-banner' => [
            'css' => 'assets/css/widgets/cta-banner.css',
            'js'  => 'assets/js/widgets/cta-banner.js',
            'deps' => ['jquery']
        ],
        
        // Comparison Matrix Widget
        'aiq-comparison-matrix' => [
            'css' => 'assets/css/widgets/comparison-matrix.css',
            'js'  => 'assets/js/widgets/comparison-matrix.js',
            'deps' => ['jquery']
        ],
        
        // Metric Badge Widget
        'aiq-metric-badge' => [
            'css' => 'assets/css/widgets/metric-badge.css',
            'js'  => 'assets/js/widgets/metric-badge.js',
            'deps' => ['jquery']
        ],
        
        // Blueprint Flow Widget
        'aiq-blueprint-flow' => [
            'css' => 'assets/css/widgets/blueprint-flow.css',
            'js'  => 'assets/js/widgets/blueprint-flow.js',
            'deps' => ['jquery']
        ],
        
        // Chat Widget
        'aiq-chat' => [
            'css' => 'assets/css/widgets/chat.css',
            'js'  => 'assets/js/widgets/chat.js',
            'deps' => ['jquery']
        ],
        
        // FAQ Accordion Widget
        'aiq-faq-accordion' => [
            'css' => 'assets/css/widgets/faq-accordion.css',
            'js'  => 'assets/js/widgets/faq-accordion.js',
            'deps' => ['jquery']
        ],
        
        // Exit Intent Widget
        'aiq-exit-intent' => [
            'css' => 'assets/css/widgets/exit-intent.css',
            'js'  => 'assets/js/widgets/exit-intent.js',
            'deps' => ['jquery']
        ],
        
        // Evergreen Countdown Widget
        'aiq-evergreen-countdown' => [
            'css' => 'assets/css/widgets/evergreen-countdown.css',
            'js'  => 'assets/js/widgets/evergreen-countdown.js',
            'deps' => ['jquery']
        ],
        
        // Pricing Table Widget
        'aiq-pricing-table' => [
            'css' => 'assets/css/widgets/pricing-table.css',
            'js'  => 'assets/js/widgets/pricing-table.js',
            'deps' => ['jquery']
        ],
        
        // Progress Bar Widget
        'aiq-progress-bar' => [
            'css' => 'assets/css/widgets/progress-bar.css',
            'js'  => 'assets/js/widgets/progress-bar.js',
            'deps' => ['jquery']
        ],
        
        // Quiz Widget
        'aiq-quiz' => [
            'css' => 'assets/css/widgets/quiz.css',
            'js'  => 'assets/js/widgets/quiz.js',
            'deps' => ['jquery']
        ],
        
        // Resource Card Widget
        'aiq-resource-card' => [
            'css' => 'assets/css/widgets/resource-card.css',
            'js'  => 'assets/js/widgets/resource-card.js',
            'deps' => ['jquery']
        ],
        
        // ROI Calculator Widget
        'aiq-roi-calculator' => [
            'css' => 'assets/css/widgets/roi-calculator.css',
            'js'  => 'assets/js/widgets/roi-calculator.js',
            'deps' => ['jquery']
        ],
        
        // Testimonial Card Widget
        'aiq-testimonial-card' => [
            'css' => 'assets/css/widgets/testimonial-card.css',
            'js'  => 'assets/js/widgets/testimonial-card.js',
            'deps' => ['jquery']
        ],
        
        // Tool Card Widget
        'aiq-tool-card' => [
            'css' => 'assets/css/widgets/tool-card.css',
            'js'  => 'assets/js/widgets/tool-card.js',
            'deps' => ['jquery']
        ],
        
        // Value Timeline Widget
        'aiq-value-timeline' => [
            'css' => 'assets/css/widgets/value-timeline.css',
            'js'  => 'assets/js/widgets/value-timeline.js',
            'deps' => ['jquery']
        ],
        
        // Archive Loop Widget
        'aiq-archive-loop' => [
            'css' => 'assets/css/widgets/archive-loop.css',
            'js'  => 'assets/js/widgets/archive-loop.js',
            'deps' => ['jquery']
        ],
        
        // 404 Template Widget
        'aiq-404-template' => [
            'css' => 'assets/css/widgets/404-template.css',
            'js'  => 'assets/js/widgets/404-template.js',
            'deps' => ['jquery']
        ]
    ];
    
    // Register each widget's assets
    foreach ($widget_assets as $handle => $asset_config) {
        // Register CSS if file exists
        $css_path = AIQENGAGE_CHILD_PATH . $asset_config['css'];
        if (file_exists($css_path)) {
            wp_register_style(
                $handle,
                AIQENGAGE_CHILD_URL . $asset_config['css'],
                [],
                $version
            );
        } else {
            // Create placeholder file if needed - log for debugging
            if (WP_DEBUG) {
                error_log("AIQEngage: Missing CSS file for widget handle '{$handle}': {$css_path}");
            }
        }
        
        // Register JS if file exists
        $js_path = AIQENGAGE_CHILD_PATH . $asset_config['js'];
        if (file_exists($js_path)) {
            wp_register_script(
                $handle,
                AIQENGAGE_CHILD_URL . $asset_config['js'],
                $asset_config['deps'],
                $version,
                true
            );
        } else {
            // Create placeholder file if needed - log for debugging
            if (WP_DEBUG) {
                error_log("AIQEngage: Missing JS file for widget handle '{$handle}': {$js_path}");
            }
        }
    }
    
    // Log registration completion for debugging
    if (WP_DEBUG) {
        error_log('AIQEngage: Registered ' . count($widget_assets) . ' widget asset handles');
    }
}

/**
 * Initialize widget asset registration
 */
function aiqengage_init_widget_assets() {
    // Hook the registration to init action
    add_action('init', 'aiqengage_register_widget_assets', 5);
}

// Initialize the widget asset system
aiqengage_init_widget_assets();

/**
 * Create placeholder asset files for any missing widget assets
 * This function can be used to generate empty placeholder files for widgets that need them
 */
function aiqengage_create_missing_widget_assets() {
    // Only run this in development/debug mode
    if (!WP_DEBUG) {
        return;
    }
    
    $widget_handles = [
        'aiq-feature-section', 'aiq-prompt-card', 'aiq-cta-banner', 'aiq-comparison-matrix',
        'aiq-metric-badge', 'aiq-blueprint-flow', 'aiq-chat', 'aiq-faq-accordion',
        'aiq-exit-intent', 'aiq-evergreen-countdown', 'aiq-pricing-table', 'aiq-progress-bar',
        'aiq-quiz', 'aiq-resource-card', 'aiq-roi-calculator', 'aiq-testimonial-card',
        'aiq-tool-card', 'aiq-value-timeline', 'aiq-archive-loop', 'aiq-404-template'
    ];
    
    $created_files = [];
    
    foreach ($widget_handles as $handle) {
        // Check if CSS file exists
        $css_file = AIQENGAGE_CHILD_PATH . "assets/css/widgets/" . str_replace('aiq-', '', $handle) . ".css";
        if (!file_exists($css_file)) {
            // Create directory if it doesn't exist
            $css_dir = dirname($css_file);
            if (!is_dir($css_dir)) {
                wp_mkdir_p($css_dir);
            }
            
            // Create placeholder CSS file
            $css_content = "/* {$handle} Widget Styles */\n\n/* Add your widget-specific styles here */\n";
            if (file_put_contents($css_file, $css_content)) {
                $created_files[] = $css_file;
            }
        }
        
        // Check if JS file exists
        $js_file = AIQENGAGE_CHILD_PATH . "assets/js/widgets/" . str_replace('aiq-', '', $handle) . ".js";
        if (!file_exists($js_file)) {
            // Create directory if it doesn't exist
            $js_dir = dirname($js_file);
            if (!is_dir($js_dir)) {
                wp_mkdir_p($js_dir);
            }
            
            // Create placeholder JS file
            $js_content = "/* {$handle} Widget Scripts */\n\n(function($) {\n    'use strict';\n    \n    // Add your widget-specific JavaScript here\n    \n})(jQuery);\n";
            if (file_put_contents($js_file, $js_content)) {
                $created_files[] = $js_file;
            }
        }
    }
    
    if (!empty($created_files)) {
        error_log('AIQEngage: Created ' . count($created_files) . ' placeholder asset files: ' . implode(', ', $created_files));
    }
}

/**
 * Admin action to create missing assets (only for admins in debug mode)
 */
function aiqengage_admin_create_missing_assets() {
    if (current_user_can('administrator') && WP_DEBUG && isset($_GET['aiq_create_assets'])) {
        aiqengage_create_missing_widget_assets();
        wp_redirect(remove_query_arg('aiq_create_assets'));
        exit;
    }
}
add_action('admin_init', 'aiqengage_admin_create_missing_assets');
