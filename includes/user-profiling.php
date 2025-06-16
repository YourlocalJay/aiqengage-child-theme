<?php
/**
 * AIQEngage User Profiling System
 *
 * @package AIQEngage-Child
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

/**
 * Class AIQEngage_User_Profiling
 * Handles user profiling, personalization, and content adaptation
 */
class AIQEngage_User_Profiling {
    
    /**
     * Constructor
     */
    public function __construct() {
        add_action('wp_enqueue_scripts', array($this, 'enqueue_scripts'));
        add_action('wp_footer', array($this, 'add_tracking_code'));
        add_action('wp_ajax_aiqengage_update_profile', array($this, 'ajax_update_profile'));
        add_action('wp_ajax_nopriv_aiqengage_update_profile', array($this, 'ajax_update_profile'));
        add_filter('body_class', array($this, 'add_profile_body_classes'));
        add_action('wp_head', array($this, 'add_personalization_data'));
    }
    
    /**
     * Enqueue necessary scripts
     */
    public function enqueue_scripts() {
        wp_enqueue_script(
            'aiqengage-user-profiling',
            get_stylesheet_directory_uri() . '/js/user-profiling.js',
            array('jquery'),
            '1.0.0',
            true
        );
        
        wp_localize_script('aiqengage-user-profiling', 'aiqengageProfile', array(
            'ajaxurl' => admin_url('admin-ajax.php'),
            'nonce' => wp_create_nonce('aiqengage-profile-nonce'),
            'isLoggedIn' => is_user_logged_in(),
            'categories' => $this->get_content_categories(),
        ));
    }
    
    /**
     * Add tracking code to footer
     */
    public function add_tracking_code() {
        if (is_admin()) {
            return;
        }
        ?>
        <script>
            (function() {
                // Track page view
                window.aiqengageTrackPageView = function() {
                    const pageData = {
                        url: window.location.href,
                        title: document.title,
                        referrer: document.referrer,
                        timestamp: new Date().toISOString()
                    };
                    
                    // Store page view in user profile
                    let userProfile = JSON.parse(localStorage.getItem('aiqengage_user_profile') || '{}');
                    if (!userProfile.pageViews) {
                        userProfile.pageViews = [];
                    }
                    
                    // Limit to last 20 page views
                    userProfile.pageViews.push(pageData);
                    if (userProfile.pageViews.length > 20) {
                        userProfile.pageViews = userProfile.pageViews.slice(-20);
                    }
                    
                    // Update last active timestamp
                    userProfile.lastActive = new Date().toISOString();
                    
                    // Store updated profile
                    localStorage.setItem('aiqengage_user_profile', JSON.stringify(userProfile));
                };
                
                // Track when document is ready
                if (document.readyState === 'complete' || document.readyState === 'interactive') {
                    setTimeout(window.aiqengageTrackPageView, 1000);
                } else {
                    document.addEventListener('DOMContentLoaded', function() {
                        setTimeout(window.aiqengageTrackPageView, 1000);
                    });
                }
            })();
        </script>
        <?php
    }
    
    /**
     * AJAX handler for updating user profile
     */
    public function ajax_update_profile() {
        // Check nonce
        check_ajax_referer('aiqengage-profile-nonce', 'security');
        
        // Get profile data
        $profile_data = isset($_POST['profile_data']) ? $_POST['profile_data'] : '';
        $profile_data = json_decode(stripslashes($profile_data), true);
        
        if (!$profile_data || !is_array($profile_data)) {
            wp_send_json_error(array('message' => 'Invalid profile data'));
            return;
        }
        
        // If user is logged in, store profile in user meta
        if (is_user_logged_in()) {
            $user_id = get_current_user_id();
            update_user_meta($user_id, 'aiqengage_user_profile', $profile_data);
        }
        
        wp_send_json_success(array('message' => 'Profile updated successfully'));
    }
    
    /**
     * Add profile-specific body classes
     */
    public function add_profile_body_classes($classes) {
        // Add classes based on UTM parameters
        if (isset($_GET['utm_source'])) {
            $classes[] = 'utm-source-' . sanitize_title($_GET['utm_source']);
        }
        
        if (isset($_GET['utm_medium'])) {
            $classes[] = 'utm-medium-' . sanitize_title($_GET['utm_medium']);
        }
        
        if (isset($_GET['utm_campaign'])) {
            $classes[] = 'utm-campaign-' . sanitize_title($_GET['utm_campaign']);
        }
        
        // Add return visitor class
        $classes[] = $this->is_return_visitor() ? 'return-visitor' : 'new-visitor';
        
        return $classes;
    }
    
    /**
     * Add personalization data to head
     */
    public function add_personalization_data() {
        if (is_admin()) {
            return;
        }
        
        // Get user interests from query params or existing profile
        $interests = $this->get_user_interests();
        $skill_level = $this->get_user_skill_level();
        
        // Output data for JS personalization
        ?>
        <script>
            window.aiqengagePersonalization = {
                interests: <?php echo json_encode($interests); ?>,
                skillLevel: <?php echo json_encode($skill_level); ?>,
                isReturnVisitor: <?php echo json_encode($this->is_return_visitor()); ?>,
                visitCount: <?php echo json_encode($this->get_visit_count()); ?>,
                preferredContentLength: "<?php echo esc_js($this->get_preferred_content_length()); ?>",
                lastActiveCategory: "<?php echo esc_js($this->get_last_active_category()); ?>"
            };
        </script>
        <?php
    }
    
    /**
     * Check if this is a return visitor
     */
    private function is_return_visitor() {
        // Check for existing cookie
        if (isset($_COOKIE['aiqengage_returning_visitor'])) {
            return true;
        }
        
        // Check for existing user profile in localStorage via JS
        return false; // This will be handled by JS
    }
    
    /**
     * Get visit count for the user
     */
    private function get_visit_count() {
        if (is_user_logged_in()) {
            $user_id = get_current_user_id();
            $visit_count = get_user_meta($user_id, 'aiqengage_visit_count', true);
            return $visit_count ? intval($visit_count) : 1;
        }
        
        // For non-logged in users, return 1 (first visit)
        return 1;
    }
    
    /**
     * Get user interests from various sources
     */
    private function get_user_interests() {
        $interests = array();
        
        // Check query parameters
        if (isset($_GET['interest'])) {
            $interests[] = sanitize_text_field($_GET['interest']);
        }
        
        // Get interests from URL path
        $current_path = trim(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH), '/');
        $path_parts = explode('/', $current_path);
        
        if (!empty($path_parts[0])) {
            $potential_categories = $this->get_content_categories();
            if (in_array($path_parts[0], $potential_categories)) {
                $interests[] = $path_parts[0];
            }
        }
        
        return array_unique($interests);
    }
    
    /**
     * Get user skill level
     */
    private function get_user_skill_level() {
        // Default level is intermediate (5)
        $level = 5;
        
        // Check for skill level in query params
        if (isset($_GET['skill_level'])) {
            $param_level = intval($_GET['skill_level']);
            if ($param_level >= 1 && $param_level <= 10) {
                $level = $param_level;
            }
        }
        
        // If user is logged in, get from user meta
        if (is_user_logged_in()) {
            $user_id = get_current_user_id();
            $stored_level = get_user_meta($user_id, 'aiqengage_skill_level', true);
            if ($stored_level) {
                $level = intval($stored_level);
            }
        }
        
        return $level;
    }
    
    /**
     * Get preferred content length
     */
    private function get_preferred_content_length() {
        // Default to medium
        $length = 'medium';
        
        // Check for preference in query params
        if (isset($_GET['content_length'])) {
            $param_length = sanitize_text_field($_GET['content_length']);
            if (in_array($param_length, array('short', 'medium', 'detailed'))) {
                $length = $param_length;
            }
        }
        
        return $length;
    }
    
    /**
     * Get last active category
     */
    private function get_last_active_category() {
        // Default to empty
        $category = '';
        
        // If on a category page, use that
        if (is_category()) {
            $category = single_cat_title('', false);
        }
        
        return $category;
    }
    
    /**
     * Get available content categories
     */
    private function get_content_categories() {
        return array(
            'vault',
            'tools',
            'automation-hub',
            'results',
            'blog',
            'affiliate',
            'prompts',
            'reddit',
            'email',
            'landing-page',
            'youtube',
            'product-review'
        );
    }
}

// Initialize the user profiling system
new AIQEngage_User_Profiling();
