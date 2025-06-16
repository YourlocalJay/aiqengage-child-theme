<?php
/**
 * AIQEngage Sticky Notification Bar
 *
 * @package AIQEngage-Child
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

/**
 * Class AIQEngage_Sticky_Notification_Bar
 * Handles the display and functionality of the sticky notification bar
 */
class AIQEngage_Sticky_Notification_Bar {
    
    /**
     * Constructor
     */
    public function __construct() {
        add_action('wp_footer', array($this, 'render_notification_bar'));
        add_action('wp_enqueue_scripts', array($this, 'enqueue_scripts'));
        add_action('customize_register', array($this, 'customize_register'));
    }
    
    /**
     * Register settings in the WordPress Customizer
     */
    public function customize_register($wp_customize) {
        // Add section for notification bar
        $wp_customize->add_section('aiqengage_notification_bar', array(
            'title'    => __('Sticky Notification Bar', 'aiqengage'),
            'priority' => 120,
        ));
        
        // Add setting for notification bar status
        $wp_customize->add_setting('aiqengage_notification_bar_enable', array(
            'default'           => true,
            'sanitize_callback' => 'aiqengage_sanitize_checkbox',
        ));
        
        $wp_customize->add_control('aiqengage_notification_bar_enable', array(
            'label'    => __('Enable Notification Bar', 'aiqengage'),
            'section'  => 'aiqengage_notification_bar',
            'type'     => 'checkbox',
        ));
        
        // Add setting for notification message
        $wp_customize->add_setting('aiqengage_notification_message', array(
            'default'           => __('Ready to unlock Claude\'s most trusted growth stacks?', 'aiqengage'),
            'sanitize_callback' => 'sanitize_text_field',
        ));
        
        $wp_customize->add_control('aiqengage_notification_message', array(
            'label'    => __('Notification Message', 'aiqengage'),
            'section'  => 'aiqengage_notification_bar',
            'type'     => 'text',
        ));
        
        // Add setting for primary button text
        $wp_customize->add_setting('aiqengage_primary_button_text', array(
            'default'           => __('🔓 View Vault', 'aiqengage'),
            'sanitize_callback' => 'sanitize_text_field',
        ));
        
        $wp_customize->add_control('aiqengage_primary_button_text', array(
            'label'    => __('Primary Button Text', 'aiqengage'),
            'section'  => 'aiqengage_notification_bar',
            'type'     => 'text',
        ));
        
        // Add setting for primary button URL
        $wp_customize->add_setting('aiqengage_primary_button_url', array(
            'default'           => '/vault/',
            'sanitize_callback' => 'esc_url_raw',
        ));
        
        $wp_customize->add_control('aiqengage_primary_button_url', array(
            'label'    => __('Primary Button URL', 'aiqengage'),
            'section'  => 'aiqengage_notification_bar',
            'type'     => 'url',
        ));
        
        // Add setting for secondary button text
        $wp_customize->add_setting('aiqengage_secondary_button_text', array(
            'default'           => __('💡 Get Recommendations', 'aiqengage'),
            'sanitize_callback' => 'sanitize_text_field',
        ));
        
        $wp_customize->add_control('aiqengage_secondary_button_text', array(
            'label'    => __('Secondary Button Text', 'aiqengage'),
            'section'  => 'aiqengage_notification_bar',
            'type'     => 'text',
        ));
        
        // Add setting for secondary button URL
        $wp_customize->add_setting('aiqengage_secondary_button_url', array(
            'default'           => '/ai-guidance/',
            'sanitize_callback' => 'esc_url_raw',
        ));
        
        $wp_customize->add_control('aiqengage_secondary_button_url', array(
            'label'    => __('Secondary Button URL', 'aiqengage'),
            'section'  => 'aiqengage_notification_bar',
            'type'     => 'url',
        ));
        
        // Add setting for scroll trigger percentage
        $wp_customize->add_setting('aiqengage_scroll_trigger', array(
            'default'           => 45,
            'sanitize_callback' => 'absint',
        ));
        
        $wp_customize->add_control('aiqengage_scroll_trigger', array(
            'label'    => __('Scroll Trigger Percentage', 'aiqengage'),
            'section'  => 'aiqengage_notification_bar',
            'type'     => 'number',
            'input_attrs' => array(
                'min'  => 0,
                'max'  => 100,
                'step' => 5,
            ),
        ));
        
        // Add setting for dismissible status
        $wp_customize->add_setting('aiqengage_notification_dismissible', array(
            'default'           => true,
            'sanitize_callback' => 'aiqengage_sanitize_checkbox',
        ));
        
        $wp_customize->add_control('aiqengage_notification_dismissible', array(
            'label'    => __('Allow Users to Dismiss', 'aiqengage'),
            'section'  => 'aiqengage_notification_bar',
            'type'     => 'checkbox',
        ));
        
        // Add setting for dismiss duration (in days)
        $wp_customize->add_setting('aiqengage_dismiss_duration', array(
            'default'           => 7,
            'sanitize_callback' => 'absint',
        ));
        
        $wp_customize->add_control('aiqengage_dismiss_duration', array(
            'label'    => __('Dismiss Duration (days)', 'aiqengage'),
            'section'  => 'aiqengage_notification_bar',
            'type'     => 'number',
            'input_attrs' => array(
                'min'  => 1,
                'max'  => 365,
                'step' => 1,
            ),
            'active_callback' => function() {
                return get_theme_mod('aiqengage_notification_dismissible', true);
            },
        ));
    }
    
    /**
     * Enqueue necessary scripts and styles
     */
    public function enqueue_scripts() {
        if (get_theme_mod('aiqengage_notification_bar_enable', true)) {
            wp_enqueue_style(
                'aiqengage-notification-bar',
                get_stylesheet_directory_uri() . '/css/notification-bar.css',
                array(),
                '1.0.0'
            );
            
            wp_enqueue_script(
                'aiqengage-notification-bar',
                get_stylesheet_directory_uri() . '/js/notification-bar.js',
                array('jquery'),
                '1.0.0',
                true
            );
            
            wp_localize_script('aiqengage-notification-bar', 'notificationBarData', array(
                'scrollTrigger' => get_theme_mod('aiqengage_scroll_trigger', 45),
                'dismissible'   => get_theme_mod('aiqengage_notification_dismissible', true),
                'dismissDays'   => get_theme_mod('aiqengage_dismiss_duration', 7),
            ));
        }
    }
    
    /**
     * Render the notification bar in the footer
     */
    public function render_notification_bar() {
        if (!get_theme_mod('aiqengage_notification_bar_enable', true)) {
            return;
        }
        
        $message = get_theme_mod('aiqengage_notification_message', __('Ready to unlock Claude\'s most trusted growth stacks?', 'aiqengage'));
        $primary_text = get_theme_mod('aiqengage_primary_button_text', __('🔓 View Vault', 'aiqengage'));
        $primary_url = get_theme_mod('aiqengage_primary_button_url', '/vault/');
        $secondary_text = get_theme_mod('aiqengage_secondary_button_text', __('💡 Get Recommendations', 'aiqengage'));
        $secondary_url = get_theme_mod('aiqengage_secondary_button_url', '/ai-guidance/');
        $dismissible = get_theme_mod('aiqengage_notification_dismissible', true);
        
        ?>
        <div id="sticky-notification-bar" class="sticky-notification-bar">
            <div class="sticky-notification-container">
                <div class="notification-message">
                    <?php echo esc_html($message); ?>
                </div>
                <div class="notification-buttons">
                    <a href="<?php echo esc_url($primary_url); ?>" class="btn btn-primary"><?php echo esc_html($primary_text); ?></a>
                    <a href="<?php echo esc_url($secondary_url); ?>" class="btn btn-secondary"><?php echo esc_html($secondary_text); ?></a>
                </div>
                <?php if ($dismissible): ?>
                <button class="notification-close" aria-label="<?php esc_attr_e('Close notification', 'aiqengage'); ?>">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M18 6L6 18" stroke="#E0D6FF" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        <path d="M6 6L18 18" stroke="#E0D6FF" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                </button>
                <?php endif; ?>
            </div>
        </div>
        <?php
    }
}

/**
 * Sanitize checkbox input
 */
function aiqengage_sanitize_checkbox($input) {
    return (isset($input) && $input === true) ? true : false;
}

// Initialize the notification bar
new AIQEngage_Sticky_Notification_Bar();
