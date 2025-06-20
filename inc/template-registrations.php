<?php
/**
 * AIQEngage Elementor Template Importer
 *
 * @package     AIQEngage_Child
 * @version     1.0.1
 * @author      AIQEngage Team
 * @copyright   Copyright (c) 2025, AIQEngage.
 * @license     GPL-3.0+
 * @file        template-registrations.php
 */

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

use Elementor\Plugin;
use Elementor\TemplateLibrary\Manager;

if ( ! function_exists( 'aiqengage_child_register_elementor_templates' ) ) {
	/**
	 * Register Elementor templates on theme activation.
	 *
	 * @param bool $force Optional. Force template registration even if already activated.
	 * @return int Number of templates imported.
	 * @throws Exception If template import fails.
	 */
	function aiqengage_child_register_elementor_templates( $force = false ) {
		// Check if Elementor is installed and activated.
		if ( ! did_action( 'elementor/loaded' ) ) {
			if ( WP_DEBUG ) {
				error_log( 'AIQEngage: Elementor not active - template import skipped.' );
			}
			return 0;
		}

		// Skip if already activated unless forced.
		if ( ! $force && get_option( 'aiqengage_child_templates_imported' ) ) {
			return 0;
		}

		$templates_dir  = get_stylesheet_directory() . '/elementor-templates/';
		$template_files = glob( $templates_dir . '*.json' );

		if ( empty( $template_files ) ) {
			if ( WP_DEBUG ) {
				error_log( 'AIQEngage: No template files found in ' . $templates_dir . '.' );
			}
			return 0;
		}

		$import_count = 0;

		// Get Elementor template manager instance.
		if ( ! class_exists( Plugin::class ) || ! isset( Plugin::$instance->templates_manager ) ) {
			if ( WP_DEBUG ) {
				error_log( 'AIQEngage: Elementor Plugin or Templates Manager not available.' );
			}
			return 0;
		}

		$template_manager = Plugin::$instance->templates_manager;

		// Track memory usage.
		$initial_memory = memory_get_usage();
		$start_time     = microtime( true );

		// Create batches to prevent memory issues.
		$template_batches = array_chunk( $template_files, 5 );

		foreach ( $template_batches as $batch ) {
			// Process each batch.
			foreach ( $batch as $file_path ) {
				try {
					$response = wp_remote_get( $file_path );
					if ( is_array( $response ) && ! is_wp_error( $response ) ) {
						$template_json = wp_remote_retrieve_body( $response );
					} else {
						if ( WP_DEBUG ) {
							error_log( "AIQEngage: Failed to retrieve template file - {$file_path}." );
						}
						continue;
					}

					$template_data = json_decode( $template_json, true );

					if ( ! $template_data || ! isset( $template_data['content'] ) ) {
						if ( WP_DEBUG ) {
							error_log( "AIQEngage: Invalid template file format - {$file_path}." );
						}
						continue;
					}

					// Check for existing template by title.
					$existing = aiqengage_child_find_existing_template(
						$template_data['title'] ?? basename( $file_path ),
						$template_manager
					);

					if ( $existing ) {
						if ( WP_DEBUG ) {
							error_log( "AIQEngage: Template '{$template_data['title']}' already exists (ID: {$existing['template_id']})." );
						}
						continue;
					}

					// Safe use: encoding Elementor JSON template data for import.
					$result = $template_manager->import_template(
						array(
							'fileData' => base64_encode( $template_json ),
							'fileName' => basename( $file_path ),
						)
					);

					if ( is_wp_error( $result ) ) {
						throw new Exception( $result->get_error_message() );
					}

					++$import_count;
					if ( WP_DEBUG ) {
						error_log( "AIQEngage: Successfully imported template - {$template_data['title']}." );
					}
				} catch ( Exception $e ) {
					if ( WP_DEBUG ) {
						error_log( 'AIQEngage: Template import failed - ' . $e->getMessage() . '.' );
					}
				}
			}

			// Free memory after each batch.
			wp_cache_flush();
			if ( function_exists( 'gc_collect_cycles' ) ) {
				gc_collect_cycles();
			}
		}

		// Mark templates as imported.
		update_option( 'aiqengage_child_templates_imported', time() );

		// Log memory usage and time.
		if ( WP_DEBUG ) {
			$memory_used = memory_get_usage() - $initial_memory;
			$time_taken  = microtime( true ) - $start_time;
			error_log(
				sprintf(
					'AIQEngage: Template import completed. %d templates imported. Memory used: %.2f MB, Time: %.2f seconds.',
					$import_count,
					$memory_used / 1024 / 1024,
					$time_taken
				)
			);
		}

		return $import_count;
	}

	/**
	 * Check if template already exists.
	 *
	 * @param string  $title   Template title to search for.
	 * @param Manager $manager Template manager instance.
	 * @return array|null Existing template data or null if not found.
	 */
	function aiqengage_child_find_existing_template( $title, $manager ) {
		// Early exit if source not available.
		if ( ! $manager || ! method_exists( $manager, 'get_source' ) ) {
			return null;
		}

		$source = $manager->get_source( 'local' );
		if ( ! $source || ! method_exists( $source, 'get_items' ) ) {
			return null;
		}

		$templates = $source->get_items(
			array(
				'type'    => 'section',
				'orderby' => 'title',
				'order'   => 'ASC',
			)
		);

		if ( ! is_array( $templates ) ) {
			return null;
		}

		foreach ( $templates as $template ) {
			if ( sanitize_title( $template['title'] ) === sanitize_title( $title ) ) {
				return $template;
			}
		}

		return null;
	}

	/**
	 * Force re-registration of all templates.
	 */
	function aiqengage_child_force_template_registration() {
		return aiqengage_child_register_elementor_templates( true );
	}

	// Hook into theme activation.
	add_action( 'after_switch_theme', 'aiqengage_child_register_elementor_templates' );
}

/**
 * Add custom template data to Elementor editor.
 */
function aiqengage_child_localize_template_data() {
	// Only run in Elementor editor.
	if ( ! isset( $_GET['action'] ) || 'elementor' !== $_GET['action'] ) {
		return;
	}

	// Add template info for UI integration.
	$template_data = array(
		'templates_version'  => get_option( 'aiqengage_child_templates_imported', 0 ),
		'aiqengage_help_url' => 'https://aiqengage.com/docs/templates',
		'import_url'         => admin_url( 'admin.php?page=elementor-tools#tab-import-export-kit' ),
	);

	wp_localize_script( 'elementor-editor', 'AIQEngageTemplates', $template_data );
}
add_action( 'elementor/editor/before_enqueue_scripts', 'aiqengage_child_localize_template_data' );

/**
 * Register REST API endpoint to force template reimport.
 */
function aiqengage_child_register_api_endpoints() {
	register_rest_route(
		'aiqengage/v1',
		'/refresh-templates',
		array(
			'methods'             => 'POST',
			'callback'            => 'aiqengage_child_force_template_registration',
			'permission_callback' => function () {
				return current_user_can( 'manage_options' );
			},
		)
	);
}
add_action( 'rest_api_init', 'aiqengage_child_register_api_endpoints' );

/**
 * HOW TO MANAGE TEMPLATES:
 *
 * 1. ADDING TEMPLATES:
 *    - Place .json files in /elementor-templates/ directory.
 *    - File names should be descriptive (e.g. 'hero-section.json').
 *    - Templates will auto-import on theme activation.
 *
 * 2. REMOVING TEMPLATES:
 *    - Delete the .json file from /elementor-templates/.
 *    - Existing imported templates must be manually deleted from:
 *      WordPress Dashboard → Templates → Saved Templates.
 *
 * 3. UPDATING TEMPLATES:
 *    - Replace the .json file with updated version.
 *    - Delete the old template from Elementor library first.
 *    - Call API endpoint: /wp-json/aiqengage/v1/refresh-templates (POST, admin only).
 *
 * DEBUGGING:
 * - Check error logs for import status.
 * - WP_DEBUG_LOG will show detailed errors.
 */

/**
 * Check if Elementor templates directory exists and log error if not.
 */
function aiqengage_check_templates_directory() {
	$templates_dir = get_stylesheet_directory() . '/elementor-templates';

	if ( ! file_exists( $templates_dir ) || ! is_dir( $templates_dir ) ) {
		// Log error.
		if ( WP_DEBUG ) {
			error_log( 'AIQEngage Child Theme: Required directory "elementor-templates/" does not exist.' );
		}

		// Add admin notice if user is admin.
		add_action( 'admin_notices', 'aiqengage_missing_templates_notice' );
	}
}
add_action( 'init', 'aiqengage_check_templates_directory' );

/**
 * Admin notice for missing templates directory.
 */
function aiqengage_missing_templates_notice() {
	if ( current_user_can( 'manage_options' ) ) {
		?>
		<div class="notice notice-error">
			<p><?php echo esc_html__( 'AIQEngage Child Theme: Required directory "elementor-templates/" does not exist. Custom Elementor templates will not be available.', 'aiqengage-child' ); ?></p>
		</div>
		<?php
	}
}
?>
