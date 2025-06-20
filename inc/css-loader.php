<?php
/**
 * AIQEngage Child Theme - CSS Loader
 *
 * Conditionally enqueues widget-specific CSS based on Elementor widgets used on the page.
 * All widget CSS depends on main.css (design tokens) to ensure proper token availability.
 *
 * @package   AIQEngage_Child
 * @version   1.0.3
 * @author    AIQEngage Team
 * @license   GPL-3.0+
 */

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

/**
 * Returns mapping of Elementor widget names to their CSS files.
 *
 * @return array<string,string> Associative array of widget-name => css-filename.
 */
function aiqengage_get_widget_css_mapping() {
	return array(
		'prompt-card'         => 'prompt-card.css',
		'metric-badge'        => 'metric-badge.css',
		'blueprint-flow'      => 'blueprint-flow.css',
		'comparison-matrix'   => 'comparison-matrix.css',
		'testimonial-card'    => 'testimonial-card.css',
		'value-timeline'      => 'value-timeline.css',
		'feature-section'     => 'feature-section.css',
		'cta-banner'          => 'cta-banner.css',
		'roi-calculator'      => 'roi-calculator.css',
		'pricing-table'       => 'pricing-table.css',
		'evergreen-countdown' => 'evergreen-countdown.css',
		'resource-card'       => 'resource-card.css',
		'progress-bar'        => 'progress-bar.css',
		'exit-intent'         => 'exit-intent.css',
		'faq-accordion'       => 'faq-accordion.css',
		'tool-card'           => 'tool-card.css',
		'archive-loop'        => 'archive-loop.css',
	);
}

/**
 * Returns mapping of component names to their CSS files.
 *
 * @return array<string,string> Associative array of component-name => css-filename.
 */
function aiqengage_get_component_css_mapping() {
	return array(
		'footer'     => 'footer.css',
		'header'     => 'header.css',
		'navigation' => 'navigation.css',
		'sticky-cta' => 'sticky-cta.css',
		'modal'      => 'modal.css',
	);
}

/**
 * Adds resource hints for better performance.
 */
function aiqengage_add_resource_hints() {
	// Add preconnect for Google Fonts.
	echo '<link rel="preconnect" href="https://fonts.googleapis.com">';
	echo '<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>';

	// Preload critical fonts.
	echo '<link rel="preload" href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" as="style">';

	// Add preconnect for external resources (if needed).
	if ( function_exists( 'elementor_pro_is_active' ) && elementor_pro_is_active() ) {
		echo '<link rel="preconnect" href="https://fonts.googleapis.com">';
	}
}
add_action( 'wp_head', 'aiqengage_add_resource_hints', 1 );

/**
 * Adds optimization for image loading.
 *
 * @param array $attr Image attributes.
 * @return array Modified attributes.
 */
function aiqengage_optimize_image_loading( $attr ) {
	if ( ! isset( $attr['loading'] ) ) {
		$attr['loading'] = 'lazy';
	}

	if ( ! isset( $attr['decoding'] ) ) {
		$attr['decoding'] = 'async';
	}

	return $attr;
}
add_filter( 'wp_get_attachment_image_attributes', 'aiqengage_optimize_image_loading' );

/**
 * Enqueue component CSS for common elements like footer, header, etc.
 * These are always loaded as they appear on every page.
 */
function aiqengage_child_enqueue_component_styles() {
	// Only run on front-end.
	if ( is_admin() ) {
		return;
	}

	$components = aiqengage_get_component_css_mapping();

	// Always load these core components.
	$core_components = array( 'footer', 'header', 'navigation' );

	foreach ( $core_components as $component_name ) {
		if ( isset( $components[ $component_name ] ) ) {
			$handle   = "aiq-component-{$component_name}";
			$css_file = $components[ $component_name ];

			wp_enqueue_style(
				$handle,
				trailingslashit( get_stylesheet_directory_uri() ) . "assets/css/components/{$css_file}",
				array( 'aiq-main-css' ), // Depend on main.css for design tokens.
				AIQENGAGE_CHILD_VERSION
			);
		}
	}

	// Conditionally load other components based on page type or content.
	if ( is_singular() || is_home() ) {
		// Load sticky CTA on content pages.
		if ( isset( $components['sticky-cta'] ) ) {
			wp_enqueue_style(
				'aiq-component-sticky-cta',
				trailingslashit( get_stylesheet_directory_uri() ) . "assets/css/components/{$components['sticky-cta']}",
				array( 'aiq-main-css' ),
				AIQENGAGE_CHILD_VERSION
			);
		}
	}
}
add_action( 'wp_enqueue_scripts', 'aiqengage_child_enqueue_component_styles', 18 );

/**
 * Enqueue widget CSS based on used widgets.
 * CRITICAL: All widget CSS now depends on 'aiq-main-css' to ensure design tokens are available.
 */
function aiqengage_child_enqueue_widget_styles() {
	// Only run on front-end.
	if ( is_admin() ) {
		return;
	}

	// Get mapping of widget names to CSS files.
	$mapping = aiqengage_get_widget_css_mapping();

	// Try to detect Elementor widgets on this page.
	$used_widgets = array();
	$post_id      = get_queried_object_id();

	if ( $post_id !== 0 ) // Yoda condition check.
		$data = get_post_meta( $post_id, '_elementor_data', true );
		if ( ! empty( $data ) ) {
			// Decode JSON structure.
			$elements = json_decode( $data, true );
			if ( is_array( $elements ) ) {
				array_walk_recursive(
					$elements,
					function ( $value, $key ) use ( &$used_widgets ) {
						if ( $key === 'widgetType' ) {
							$used_widgets[] = $value;
						}
					}
				);
			}
		}
	}

	// Unique widget names.
	$used_widgets = array_unique( $used_widgets );

	// Enqueue each CSS file if its widget was used.
	// CRITICAL: Each widget CSS depends on 'aiq-main-css' for design tokens.
	$enqueued = false;
	foreach ( $mapping as $widget_name => $css_file ) {
		if ( in_array( $widget_name, $used_widgets, true ) ) {
			$handle = "aiq-widget-{$widget_name}";
			wp_enqueue_style(
				$handle,
				trailingslashit( get_stylesheet_directory_uri() ) . "assets/css/widgets/{$css_file}",
				array( 'aiq-main-css' ), // CRITICAL: Depend on main.css for design tokens.
				AIQENGAGE_CHILD_VERSION
			);
			$enqueued = true;
		}
	}

	// Enqueue only common CSS if no specific widgets detected.
	if ( false === $used_widgets ) {
		$common_widgets = array( 'prompt-card', 'feature-section', 'cta-banner' );
		foreach ( $common_widgets as $widget_name ) {
			if ( isset( $mapping[ $widget_name ] ) ) {
				$handle = "aiq-widget-{$widget_name}";
				wp_enqueue_style(
					$handle,
					trailingslashit( get_stylesheet_directory_uri() ) . "assets/css/widgets/{$mapping[$widget_name]}",
					array( 'aiq-main-css' ), // CRITICAL: Depend on main.css for design tokens.
					AIQENGAGE_CHILD_VERSION
				);
			}
		}
	}
}
add_action( 'wp_enqueue_scripts', 'aiqengage_child_enqueue_widget_styles', 20 );

/**
 * Add async/defer attributes to enqueued scripts when needed.
 *
 * @param string $tag    The <script> tag for the enqueued script.
 * @param string $handle The script's registered handle.
 * @return string Script tag with async/defer added if needed.
 */
function aiqengage_script_loader_tag( $tag, $handle ) {
	// Add async/defer to non-critical scripts.
	$scripts_to_defer = array( 'aiqengage-child-animation', 'aiqengage-child-vendor' );
	$scripts_to_async = array( 'google-analytics', 'gtag' );

	if ( in_array( $handle, $scripts_to_defer, true ) ) {
		return str_replace( ' src', ' defer src', $tag );
	}

	if ( in_array( $handle, $scripts_to_async, true ) ) {
		return str_replace( ' src', ' async src', $tag );
	}

	return $tag;
}
add_filter( 'script_loader_tag', 'aiqengage_script_loader_tag', 10, 2 );

/**
 * Check if CSS assets directory exists and log error if not.
 */
function aiqengage_check_css_directory() {
	$css_dirs = array(
		get_stylesheet_directory() . '/assets/css/widgets',
		get_stylesheet_directory() . '/assets/css/components',
	);

	foreach ( $css_dirs as $css_dir ) {
		if ( ! file_exists( $css_dir ) || ! is_dir( $css_dir ) ) {
			// Log the missing directory error.
			// phpcs:ignore WordPress.PHP.DevelopmentFunctions.error_log_error_log
			// error_log( "AIQEngage Child Theme: Required directory \"{$css_dir}\" does not exist." );

			// Add admin notice if user is an admin.
			add_action( 'admin_notices', 'aiqengage_missing_css_notice' );
		}
	}
}
add_action( 'init', 'aiqengage_check_css_directory' );

/**
 * Admin notice for missing CSS directory.
 */
function aiqengage_missing_css_notice() {
	if ( 'manage_options' === key( array_filter( wp_get_current_user()->allcaps ) ) ) {
		?>
		<div class="notice notice-error">
			<p><?php esc_html_e( 'AIQEngage Child Theme: Required CSS directories "assets/css/widgets/" or "assets/css/components/" do not exist. Styling may not work properly.', 'aiqengage-child' ); ?></p>
		</div>
		<?php
	}
}
