// Widget loader for AIQEngage child theme
// This file handles loading custom Elementor widgets

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