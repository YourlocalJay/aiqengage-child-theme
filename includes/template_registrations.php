<?php
/**
 * AIQEngage Elementor Template Importer
 * 
 * @package     AIQEngage_Child
 * @version     1.0.0
 * @author      AIQEngage Team
 * @copyright   Copyright (c) 2025, AIQEngage
 * @license     GPL-3.0+
 */

// Exit if accessed directly
defined('ABSPATH') || exit;

if (!function_exists('aiqengage_child_register_elementor_templates')) {
    /**
     * Register Elementor templates on theme activation
     */
    function aiqengage_child_register_elementor_templates() {
        // Check if Elementor is installed and activated
        if (!did_action('elementor/loaded')) {
            error_log('AIQEngage: Elementor not active - template import skipped');
            return;
        }

        $templates_dir = get_stylesheet_directory() . '/elementor-templates/';
        $template_files = glob($templates_dir . '*.json');

        if (empty($template_files)) {
            error_log('AIQEngage: No template files found in ' . $templates_dir);
            return;
        }

        $import_count = 0;
        $template_manager = \Elementor\Plugin::$instance->templates_manager;

        foreach ($template_files as $file_path) {
            try {
                $template_data = json_decode(file_get_contents($file_path), true);
                
                if (!$template_data || !isset($template_data['content'])) {
                    error_log("AIQEngage: Invalid template file format - {$file_path}");
                    continue;
                }

                // Check for existing template by title
                $existing = aiqengage_child_find_existing_template(
                    $template_data['title'] ?? basename($file_path),
                    $template_manager
                );

                if ($existing) {
                    error_log("AIQEngage: Template '{$template_data['title']}' already exists (ID: {$existing['template_id']})");
                    continue;
                }

                // Import the template
                $result = $template_manager->import_template([
                    'fileData' => base64_encode(file_get_contents($file_path)),
                    'fileName' => basename($file_path)
                ]);

                if (is_wp_error($result)) {
                    throw new Exception($result->get_error_message());
                }

                $import_count++;
                error_log("AIQEngage: Successfully imported template - {$template_data['title']}");

            } catch (Exception $e) {
                error_log("AIQEngage: Template import failed - " . $e->getMessage());
            }
        }

        error_log("AIQEngage: Template import completed. {$import_count} templates imported.");
    }

    /**
     * Check if template already exists
     * 
     * @param string $title Template title to search for
     * @param \Elementor\TemplateLibrary\Manager $manager Template manager instance
     * @return array|null Existing template data or null if not found
     */
    function aiqengage_child_find_existing_template($title, $manager) {
        $templates = $manager->get_source('local')->get_items([
            'type' => 'section',
            'orderby' => 'title',
            'order' => 'ASC'
        ]);

        foreach ($templates as $template) {
            if (sanitize_title($template['title']) === sanitize_title($title)) {
                return $template;
            }
        }

        return null;
    }

    // Hook into theme activation
    add_action('after_switch_theme', 'aiqengage_child_register_elementor_templates');
}

/**
 * HOW TO MANAGE TEMPLATES:
 * 
 * 1. ADDING TEMPLATES:
 *    - Place .json files in /elementor-templates/ directory
 *    - File names should be descriptive (e.g. 'hero-section.json')
 *    - Templates will auto-import on theme activation
 * 
 * 2. REMOVING TEMPLATES:
 *    - Delete the .json file from /elementor-templates/
 *    - Existing imported templates must be manually deleted from:
 *      WordPress Dashboard → Templates → Saved Templates
 * 
 * 3. UPDATING TEMPLATES:
 *    - Replace the .json file with updated version
 *    - Delete the old template from Elementor library first
 *    - Reactivate theme to re-import
 * 
 * DEBUGGING:
 * - Check error logs for import status
 * - WP_DEBUG_LOG will show detailed errors
 */
