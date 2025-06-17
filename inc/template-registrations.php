// Template registrations for AIQEngage child theme
// This file handles registering custom Elementor templates

/**
 * Check if Elementor templates directory exists and log error if not
 */
function aiqengage_check_templates_directory() {
    $templates_dir = get_stylesheet_directory() . '/elementor-templates';
    
    if (!file_exists($templates_dir) || !is_dir($templates_dir)) {
        // Log error
        error_log('AIQEngage Child Theme: Required directory "elementor-templates/" does not exist.');
        
        // Add admin notice if user is admin
        add_action('admin_notices', 'aiqengage_missing_templates_notice');
    }
}
add_action('init', 'aiqengage_check_templates_directory');

/**
 * Admin notice for missing templates directory
 */
function aiqengage_missing_templates_notice() {
    if (current_user_can('administrator')) {
        ?>
        <div class="notice notice-error">
            <p><?php _e('AIQEngage Child Theme: Required directory "elementor-templates/" does not exist. Custom Elementor templates will not be available.', 'aiqengage-child'); ?></p>
        </div>
        <?php
    }
}
