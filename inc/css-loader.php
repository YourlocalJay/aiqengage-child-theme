// CSS loader for AIQEngage child theme
// This file handles loading CSS assets

/**
 * Check if CSS assets directory exists and log error if not
 */
function aiqengage_check_css_directory() {
    $css_dir = get_stylesheet_directory() . '/assets/css/widgets';
    
    if (!file_exists($css_dir) || !is_dir($css_dir)) {
        // Log error
        error_log('AIQEngage Child Theme: Required directory "assets/css/widgets/" does not exist.');
        
        // Add admin notice if user is admin
        add_action('admin_notices', 'aiqengage_missing_css_notice');
    }
}
add_action('init', 'aiqengage_check_css_directory');

/**
 * Admin notice for missing CSS directory
 */
function aiqengage_missing_css_notice() {
    if (current_user_can('administrator')) {
        ?>
        <div class="notice notice-error">
            <p><?php _e('AIQEngage Child Theme: Required directory "assets/css/widgets/" does not exist. Widget styling may not work properly.', 'aiqengage'); ?></p>
        </div>
        <?php
    }
}