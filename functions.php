<?php
/**
 * AIQEngage Child Theme - Core Functionality
 *
 * @package     aiqengage-child
 * @version     1.0.4
 * @since       1.0.0
 * @author      Jason
 * @copyright   Copyright (c) 2025, AIQEngage
 * @license     GPL-3.0+
 * @link        https://aiqengage.com
 */

// Exit if accessed directly
defined( 'ABSPATH' ) || exit;

// Define theme constants
define( 'AIQENGAGE_CHILD_VERSION', wp_get_theme()->get( 'Version' ) );
define( 'AIQENGAGE_CHILD_PATH', trailingslashit( get_stylesheet_directory() ) );
define( 'AIQENGAGE_CHILD_URL', trailingslashit( get_stylesheet_directory_uri() ) );

/**
 * Theme Setup
 */
function aiqengage_child_theme_setup() {
	// Load text domain
	load_child_theme_textdomain( 'aiqengage-child', AIQENGAGE_CHILD_PATH . 'languages' );

	// Add theme support
	add_theme_support( 'title-tag' );
	add_theme_support( 'post-thumbnails' );
	add_theme_support( 'html5', array( 'comment-list', 'comment-form', 'search-form', 'gallery', 'caption' ) );
	add_theme_support( 'align-wide' );

	// Register nav menus
	register_nav_menus(
		array(
			'primary' => __( 'Primary Menu', 'aiqengage-child' ),
			'footer'  => __( 'Footer Menu', 'aiqengage-child' ),
		)
	);
}
add_action( 'after_setup_theme', 'aiqengage_child_theme_setup' );

/**
 * Load Required Files
 */
function aiqengage_child_load_includes() {
	$includes = array(
		'/inc/css-loader.php',          // Asset management
		'/inc/widget-assets.php',       // Widget asset registration
		'/inc/widget-loader.php',       // Elementor widgets
		'/inc/template-registrations.php', // Template library
	);

	foreach ( $includes as $file ) {
		$filepath = AIQENGAGE_CHILD_PATH . ltrim( $file, '/' );
		if ( file_exists( $filepath ) ) {
			require_once $filepath;
		} else {
			error_log( sprintf( 'Missing required file: %s', $filepath ) );
		}
	}
}
add_action( 'after_setup_theme', 'aiqengage_child_load_includes' );

/**
 * Add resource hints for better performance
 */
function aiqengage_add_resource_hints() {
	// Add preconnect for Google Fonts
	echo '<link rel="preconnect" href="https://fonts.googleapis.com">';
	echo '<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>';
}
add_action( 'wp_head', 'aiqengage_add_resource_hints', 1 );

/**
 * Add theme-color meta tags and prevent FOUC (No Flicker)
 */
function aiqengage_add_theme_meta_and_no_fouc() {
	// Theme-color meta tags for browser UI
	?>
	<meta name="theme-color" content="#0B1220" media="(prefers-color-scheme: dark)">
	<meta name="theme-color" content="#F8FAFC" media="(prefers-color-scheme: light)">
	<?php
	
	// Critical no-FOUC script (runs before CSS)
	?>
	<script>
		(function () {
			try {
				var saved = localStorage.getItem('theme');
				var prefersDark = window.matchMedia('(prefers-color-scheme: dark)').matches;
				var theme = saved || (prefersDark ? 'dark' : 'light');
				document.documentElement.setAttribute('data-theme', theme);
			} catch (e) {
				// fail closed to light for readability
				document.documentElement.setAttribute('data-theme', 'light');
			}
		})();
	</script>
	<?php
}
add_action('wp_head', 'aiqengage_add_theme_meta_and_no_fouc', 0);

/**
 * Enqueue Theme Assets
 * CRITICAL: Ensure main.css with design tokens loads first
 */
function aiqengage_child_enqueue_assets() {
	// Parent theme styles
	wp_enqueue_style(
		'hello-elementor',
		get_template_directory_uri() . '/style.css',
		array(),
		AIQENGAGE_CHILD_VERSION
	);

	// Google Fonts (enqueued properly)
	wp_enqueue_style(
		'aiq-google-fonts',
		'https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap',
		array(),
		null
	);

	// PRIORITY 1: Main CSS with design tokens (MUST load first)
	wp_enqueue_style(
		'aiq-main-css',
		AIQENGAGE_CHILD_URL . 'assets/css/main.css',
		array( 'hello-elementor', 'aiq-google-fonts' ),
		AIQENGAGE_CHILD_VERSION
	);

	// PRIORITY 2: Theme CSS with light/dark mode variables
	wp_enqueue_style(
		'aiq-theme-css',
		AIQENGAGE_CHILD_URL . 'assets/css/aiq.css',
		array( 'aiq-main-css' ),
		AIQENGAGE_CHILD_VERSION
	);

	// PRIORITY 3: Accessibility CSS (critical for screen readers)
	wp_enqueue_style(
		'aiq-accessibility-css',
		AIQENGAGE_CHILD_URL . 'assets/css/accessibility.css',
		array( 'aiq-theme-css' ),
		AIQENGAGE_CHILD_VERSION
	);

	// PRIORITY 4: Child theme styles
	wp_enqueue_style(
		'aiqengage-child',
		AIQENGAGE_CHILD_URL . 'style.css',
		array( 'hello-elementor', 'aiq-main-css', 'aiq-theme-css', 'aiq-accessibility-css' ),
		AIQENGAGE_CHILD_VERSION
	);

	// Theme switcher script (loaded in footer)
	wp_enqueue_script(
		'aiq-theme-switcher',
		AIQENGAGE_CHILD_URL . 'assets/js/theme-switcher.js',
		array(),
		AIQENGAGE_CHILD_VERSION,
		true
	);

	// Remove WordPress emoji bloat
	remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
	remove_action( 'wp_print_styles', 'print_emoji_styles' );
	remove_action( 'admin_print_scripts', 'print_emoji_detection_script' );
	remove_action( 'admin_print_styles', 'print_emoji_styles' );
}
add_action( 'wp_enqueue_scripts', 'aiqengage_child_enqueue_assets', 15 );

/**
 * Register Elementor Widget Category
 */
function aiqengage_child_add_elementor_category( $elements_manager ) {
	$elements_manager->add_category(
		'aiqengage',
		array(
			'title' => esc_html__( 'AIQEngage Widgets', 'aiqengage-child' ),
			'icon'  => 'eicon-aiqengage',
		)
	);
}
add_action( 'elementor/elements/categories_registered', 'aiqengage_child_add_elementor_category' );

/**
 * Add theme support for Elementor color variables
 */
function aiqengage_elementor_color_support() {
	// This ensures Elementor uses our CSS variables
	add_theme_support( 'elementor-color-palette', array(
		array(
			'_id' => 'primary',
			'title' => __( 'Primary', 'aiqengage-child' ),
			'value' => 'var(--accent-500)',
		),
		array(
			'_id' => 'secondary',
			'title' => __( 'Secondary', 'aiqengage-child' ),
			'value' => 'var(--muted)',
		),
		array(
			'_id' => 'text',
			'title' => __( 'Text', 'aiqengage-child' ),
			'value' => 'var(--text)',
		),
		array(
			'_id' => 'accent',
			'title' => __( 'Accent', 'aiqengage-child' ),
			'value' => 'var(--teal-500)',
		),
	) );
}
add_action( 'after_setup_theme', 'aiqengage_elementor_color_support' );

/**
 * Theme Activation Hook
 */
function aiqengage_child_activation() {
	// Flush rewrite rules
	flush_rewrite_rules();

	// Initialize default settings
	if ( ! get_option( 'aiqengage_child_activated' ) ) {
		update_option( 'aiqengage_child_activated', time() );
	}
}
register_activation_hook( __FILE__, 'aiqengage_child_activation' );

/**
 * Theme Deactivation Cleanup
 */
function aiqengage_child_deactivation() {
	// Cleanup temporary options
	delete_option( 'aiqengage_child_activated' );
}
register_deactivation_hook( __FILE__, 'aiqengage_child_deactivation' );

/**
 * Add body class for theme mode (helps with styling)
 */
function aiqengage_body_class( $classes ) {
	// This will be set by our JavaScript, but we add a fallback
	$classes[] = 'aiqengage-theme';
	return $classes;
}
add_filter( 'body_class', 'aiqengage_body_class' );
