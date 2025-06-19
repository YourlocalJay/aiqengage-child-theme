/**
 * Archive Loop Widget Script
 *
 * @package aiqengage-child
 * @version 1.0.0
 * @since   1.0.0
 */


(function ($) {
	'use strict';

	// Archive Loop Widget JavaScript functionality
	$( document ).ready(
		function () {
			$( '.aiq-archive-loop' ).each(
				function () {
					const $widget = $( this );

					// Initialize archive loop functionality
					initArchiveLoop( $widget );
				}
			);
		}
	);

	function initArchiveLoop($widget) {
		// TODO: Implement Archive Loop widget functionality
	}

})( jQuery );
