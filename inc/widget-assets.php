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
            'js'  => 'assets/js/feature-section.js',
            'deps' => ['jquery']
        ],
        
        // Prompt Card Widget
        'aiq-prompt-card' => [
            'css' => 'assets/css/widgets/aiq-prompt-card.css',
            'js'  => 'assets/js/aiq-prompt-card.js',
            'deps' => ['jquery']
        ],
        
        // CTA Banner Widget
        'aiq-cta-banner' => [
            'css' => 'assets/css/widgets/cta-banner.css',
            'js'  => 'assets/js/cta-banner.js',
            'deps' => ['jquery']
        ],
        
        // Comparison Matrix Widget
        'aiq-comparison-matrix' => [
            'css' => 'assets/css/widgets/comparison-matrix.css',
            'js'  => 'assets/js/comparison-matrix.js',
            'deps' => ['jquery']
        ],
        
        // Metric Badge Widget
        'aiq-metric-badge' => [
            'css' => 'assets/css/widgets/metric-badge.css',
            'js'  => 'assets/js/metric-badge.js',
            'deps' => ['jquery']
        ],
        
        // Blueprint Flow Widget
        'aiq-blueprint-flow' => [
            'css' => 'assets/css/widgets/blueprint-flow.css',
            'js'  => 'assets/js/blueprint-flow.js',
            'deps' => ['jquery']
        ],
        
        // Chat Widget
        'aiq-chat' => [
            'css' => 'assets/css/widgets/chat.css',
            'js'  => 'assets/js/chat.js',
            'deps' => ['jquery']
        ],
        
        // FAQ Accordion Widget
        'aiq-faq-accordion' => [
            'css' => 'assets/css/widgets/faq-accordion.css',
            'js'  => 'assets/js/faq-accordion.js',
            'deps' => ['jquery']
        ],
        
        // Exit Intent Widget
        'aiq-exit-intent' => [
            'css' => 'assets/css/widgets/exit-intent.css',
            'js'  => 'assets/js/exit-intent.js',
            'deps' => ['jquery']
        ],
        
        // Evergreen Countdown Widget
        'aiq-evergreen-countdown' => [
            'css' => 'assets/css/widgets/evergreen-countdown.css',
            'js'  => 'assets/js/evergreen-countdown.js',
            'deps' => ['jquery']
        ],
        
        // Pricing Table Widget
        'aiq-pricing-table' => [
            'css' => 'assets/css/widgets/pricing-table.css',
            'js'  => 'assets/js/pricing-table.js',
            'deps' => ['jquery']
        ],
        
        // Progress Bar Widget
        'aiq-progress-bar' => [
            'css' => 'assets/css/widgets/progress-bar.css',
            'js'  => 'assets/js/progress-bar.js',
            'deps' => ['jquery']
        ],
        
        // Quiz Widget
        'aiq-quiz' => [
            'css' => 'assets/css/widgets/quiz.css',
            'js'  => 'assets/js/quiz.js',
            'deps' => ['jquery']
        ],
        
        // Resource Card Widget
        'aiq-resource-card' => [
            'css' => 'assets/css/widgets/resource-card.css',
            'js'  => 'assets/js/resource-card.js',
            'deps' => ['jquery']
        ],
        
        // ROI Calculator Widget
        'aiq-roi-calculator' => [
            'css' => 'assets/css/widgets/roi-calculator.css',
            'js'  => 'assets/js/roi-calculator.js',
            'deps' => ['jquery']
        ],
        
        // Testimonial Card Widget
        'aiq-testimonial-card' => [
            'css' => 'assets/css/widgets/testimonial-card.css',
            'js'  => 'assets/js/testimonial-card.js',
            'deps' => ['jquery']
        ],
        
        // Tool Card Widget
        'aiq-tool-card' => [
            'css' => 'assets/css/widgets/tool-card.css',
            'js'  => 'assets/js/tool-card.js',
            'deps' => ['jquery']
        ],
        
        // Value Timeline Widget
        'aiq-value-timeline' => [
            'css' => 'assets/css/widgets/value-timeline.css',
            'js'  => 'assets/js/value-timeline.js',
            'deps' => ['jquery']
        ],
        
        // Archive Loop Widget
        'aiq-archive-loop' => [
            'css' => 'assets/css/widgets/archive-loop.css',
            'js'  => 'assets/js/archive-loop.js',
            'deps' => ['jquery']
        ],
        
        // 404 Template Widget
        'aiq-404-template' => [
            'css' => 'assets/css/widgets/404-template.css',
            'js'  => 'assets/js/404-template.js',
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
            // Log for debugging when file is missing
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
            // Log for debugging when file is missing
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
    // Hook the registration to init action with priority 5 to run early
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
    
    $missing_assets = [
        // Check for files that don't exist and create them
        'aiq-archive-loop' => [
            'js' => 'assets/js/archive-loop.js'
        ],
        'aiq-pricing-table' => [
            'js' => 'assets/js/pricing-table.js'
        ],
        'aiq-resource-card' => [
            'js' => 'assets/js/resource-card.js'
        ]
    ];
    
    $created_files = [];
    
    foreach ($missing_assets as $handle => $files) {
        foreach ($files as $type => $file_path) {
            $full_path = AIQENGAGE_CHILD_PATH . $file_path;
            
            if (!file_exists($full_path)) {
                // Create directory if it doesn't exist
                $dir = dirname($full_path);
                if (!is_dir($dir)) {
                    wp_mkdir_p($dir);
                }
                
                // Create placeholder file
                if ($type === 'css') {
                    $content = "/* {$handle} Widget Styles */\n\n/* Add your widget-specific styles here */\n";
                } else {
                    $content = "/* {$handle} Widget Scripts */\n\n(function($) {\n    'use strict';\n    \n    // Add your widget-specific JavaScript here\n    \n})(jQuery);\n";
                }
                
                if (file_put_contents($full_path, $content)) {
                    $created_files[] = $full_path;
                }
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
