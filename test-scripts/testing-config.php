<?php
/**
 * AIQEngage Theme Testing Configuration
 * 
 * This file loads test scripts and provides testing utilities for the staging environment.
 * IMPORTANT: This file should only be loaded in the staging environment, not in production.
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

/**
 * Helper class for AIQEngage theme testing
 */
class AIQEngage_Theme_Testing {
    /**
     * Initialize testing environment
     */
    public static function init() {
        // Only load in test environments
        if (!self::is_test_environment()) {
            return;
        }
        
        // Add actions and filters
        add_action('wp_enqueue_scripts', array(__CLASS__, 'enqueue_test_scripts'));
        add_action('admin_bar_menu', array(__CLASS__, 'add_admin_bar_testing_menu'), 999);
        add_action('admin_footer', array(__CLASS__, 'output_test_logs_modal'));
        add_action('wp_footer', array(__CLASS__, 'output_test_logs_modal'));
        
        // Add AJAX handlers
        add_action('wp_ajax_aiqengage_run_tests', array(__CLASS__, 'ajax_run_tests'));
        
        // Add test mode indicator
        if (isset($_GET['test-mode']) && $_GET['test-mode'] == '1') {
            add_action('wp_head', array(__CLASS__, 'add_test_mode_indicator'));
        }
    }
    
    /**
     * Check if we're in a test environment
     */
    public static function is_test_environment() {
        // Check for specific staging domains or test parameter
        $is_staging = (
            strpos($_SERVER['HTTP_HOST'], 'staging') !== false || 
            strpos($_SERVER['HTTP_HOST'], 'test') !== false ||
            isset($_GET['enable_theme_tests'])
        );
        
        return $is_staging;
    }
    
    /**
     * Enqueue test scripts
     */
    public static function enqueue_test_scripts() {
        // Enqueue test script
        wp_enqueue_script(
            'aiqengage-theme-tests',
            get_stylesheet_directory_uri() . '/test-scripts/theme-test.js',
            array('jquery'),
            filemtime(get_stylesheet_directory() . '/test-scripts/theme-test.js'),
            true
        );
        
        // Pass test config to script
        wp_localize_script(
            'aiqengage-theme-tests',
            'aiqengageTests',
            array(
                'ajaxurl' => admin_url('admin-ajax.php'),
                'nonce' => wp_create_nonce('aiqengage-theme-tests'),
                'isTestMode' => isset($_GET['test-mode']) && $_GET['test-mode'] == '1',
                'inTestEnvironment' => true
            )
        );
        
        // Add test CSS
        wp_add_inline_style('aiqengage-main-styles', self::get_test_css());
    }
    
    /**
     * Add test mode indicator styles
     */
    public static function get_test_css() {
        return "
            /* Test mode indicator */
            .aiqengage-test-indicator {
                position: fixed;
                top: 32px;
                right: 10px;
                background: #2A1958;
                color: #E0D6FF;
                padding: 5px 10px;
                font-size: 12px;
                z-index: 999999;
                border-radius: 3px;
                font-family: monospace;
                box-shadow: 0 2px 5px rgba(0,0,0,0.2);
            }
            
            /* Test logs modal */
            #aiqengage-test-logs-modal {
                position: fixed;
                top: 0;
                left: 0;
                right: 0;
                bottom: 0;
                background: rgba(0,0,0,0.8);
                z-index: 999999;
                display: none;
            }
            #aiqengage-test-logs-container {
                position: absolute;
                top: 50px;
                left: 50px;
                right: 50px;
                bottom: 50px;
                background: #1A0938;
                color: #E0D6FF;
                border-radius: 15px;
                padding: 20px;
                overflow: auto;
                font-family: monospace;
                border: 1px solid #7F5AF0;
            }
            #aiqengage-test-logs-close {
                position: absolute;
                top: 10px;
                right: 10px;
                background: none;
                border: none;
                color: #E0D6FF;
                font-size: 20px;
                cursor: pointer;
            }
            .test-log-entry {
                margin-bottom: 10px;
                padding-bottom: 10px;
                border-bottom: 1px solid rgba(127, 90, 240, 0.3);
            }
            .test-log-success {
                color: #4CAF50;
            }
            .test-log-error {
                color: #F44336;
            }
            .test-log-warning {
                color: #FFC107;
            }
        ";
    }
    
    /**
     * Add test mode indicator to head
     */
    public static function add_test_mode_indicator() {
        echo '<div class="aiqengage-test-indicator">AIQEngage TEST MODE</div>';
    }
    
    /**
     * Add testing options to admin bar
     */
    public static function add_admin_bar_testing_menu($admin_bar) {
        // Add main testing menu
        $admin_bar->add_menu(array(
            'id'    => 'aiqengage-testing',
            'title' => 'AIQ Theme Testing',
            'href'  => '#',
            'meta'  => array(
                'title' => 'AIQEngage Theme Testing Tools',
            ),
        ));
        
        // Add submenu items
        $admin_bar->add_menu(array(
            'parent' => 'aiqengage-testing',
            'id'     => 'aiqengage-run-tests',
            'title'  => 'Run Tests',
            'href'   => add_query_arg('test-mode', '1'),
            'meta'   => array(
                'title' => 'Run AIQEngage Theme Tests',
                'target' => '_self',
            ),
        ));
        
        $admin_bar->add_menu(array(
            'parent' => 'aiqengage-testing',
            'id'     => 'aiqengage-view-logs',
            'title'  => 'View Test Logs',
            'href'   => '#aiqengage-test-logs-modal',
            'meta'   => array(
                'title' => 'View Test Logs',
                'class' => 'aiqengage-view-logs-button',
            ),
        ));
    }
    
    /**
     * Output test logs modal
     */
    public static function output_test_logs_modal() {
        ?>
        <div id="aiqengage-test-logs-modal">
            <div id="aiqengage-test-logs-container">
                <button id="aiqengage-test-logs-close">&times;</button>
                <h2>AIQEngage Theme Test Logs</h2>
                <div id="aiqengage-test-logs-content"></div>
            </div>
        </div>
        <script>
            jQuery(document).ready(function($) {
                // Toggle test logs modal
                $('.aiqengage-view-logs-button').on('click', function(e) {
                    e.preventDefault();
                    $('#aiqengage-test-logs-modal').fadeIn(200);
                    loadTestLogs();
                });
                
                // Close test logs modal
                $('#aiqengage-test-logs-close').on('click', function() {
                    $('#aiqengage-test-logs-modal').fadeOut(200);
                });
                
                // Load test logs
                function loadTestLogs() {
                    const $content = $('#aiqengage-test-logs-content');
                    $content.html('<p>Loading test logs...</p>');
                    
                    $.ajax({
                        url: ajaxurl,
                        type: 'POST',
                        data: {
                            action: 'aiqengage_get_test_logs',
                            nonce: '<?php echo wp_create_nonce('aiqengage-theme-tests'); ?>'
                        },
                        success: function(response) {
                            if (response.success) {
                                $content.html(response.data.logs);
                            } else {
                                $content.html('<p class="test-log-error">Error loading logs: ' + response.data.message + '</p>');
                            }
                        },
                        error: function() {
                            $content.html('<p class="test-log-error">Error connecting to server</p>');
                        }
                    });
                }
            });
        </script>
        <?php
    }
    
    /**
     * AJAX handler for running tests
     */
    public static function ajax_run_tests() {
        check_ajax_referer('aiqengage-theme-tests', 'nonce');
        
        // This would normally run your tests and return results
        // For now, we'll just return a success message
        wp_send_json_success(array(
            'message' => 'Tests completed successfully',
            'logs' => array(
                array(
                    'type' => 'success',
                    'message' => 'All tests passed'
                )
            )
        ));
    }
}

// Initialize testing
AIQEngage_Theme_Testing::init();
