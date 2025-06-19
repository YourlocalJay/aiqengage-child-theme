/**
 * Value Timeline Widget Script
 *
 * @package aiqengage-child
 * @version 1.0.0
 * @since   1.0.0
 * @author  Jason
 */

(function ($) {
	'use strict';

	var ValueTimeline = {
		/**
		 * Initialize the timeline functionality
		 */
		init: function () {
			var $timelines = $( '.aiq-value-timeline' );

			if ($timelines.length === 0) {
				return;
			}

			$timelines.each(
				function () {
					var $timeline = $( this );

					// Initialize progress bar
					ValueTimeline.initProgressBar( $timeline );

					// Initialize animations
					if ($timeline.hasClass( 'aiq-value-timeline--animate-fade' ) ||
					$timeline.hasClass( 'aiq-value-timeline--animate-slide' ) ||
					$timeline.hasClass( 'aiq-value-timeline--animate-grow' ) ||
					$timeline.hasClass( 'aiq-value-timeline--animate-highlight' )) {
						ValueTimeline.initAnimations( $timeline );
					}

					// Handle keyboard navigation
					ValueTimeline.initKeyboardNavigation( $timeline );
				}
			);
		},

		/**
		 * Initialize progress bar based on completed items
		 */
		initProgressBar: function ($timeline) {
			var $items         = $timeline.find( '.aiq-value-timeline__item' );
			var $progress      = $timeline.find( '.aiq-value-timeline__progress' );
			var completedCount = $timeline.find( '.aiq-value-timeline__item--completed' ).length;
			var activeCount    = $timeline.find( '.aiq-value-timeline__item--active' ).length;
			var totalCount     = $items.length;

			// Set progress percentage
			var progressPercentage = ((completedCount + (activeCount * 0.5)) / totalCount) * 100;

			if ($timeline.hasClass( 'aiq-value-timeline--vertical' )) {
				$progress.css( 'height', progressPercentage + '%' );
			} else {
				$progress.css( 'width', progressPercentage + '%' );
			}
		},

		/**
		 * Initialize animations using Intersection Observer
		 */
		initAnimations: function ($timeline) {
			var $items = $timeline.find( '.aiq-value-timeline__item' );

			if ('IntersectionObserver' in window) {
				var options = {
					root: null,
					rootMargin: '0px',
					threshold: 0.1
				};

				var observer = new IntersectionObserver(
					function (entries) {
						entries.forEach(
							function (entry) {
								if (entry.isIntersecting) {
									entry.target.classList.add( 'is-visible' );
									observer.unobserve( entry.target );
								}
							}
						);
					},
					options
				);

				$items.each(
					function () {
						observer.observe( this );
					}
				);
			} else {
				// Fallback for browsers without IntersectionObserver support
				$items.addClass( 'is-visible' );
			}
		},

		/**
		 * Initialize keyboard navigation for accessibility
		 */
		initKeyboardNavigation: function ($timeline) {
			var $items = $timeline.find( '.aiq-value-timeline__item' );

			// Add tabindex to make items focusable
			$items.attr( 'tabindex', '0' );

			// Add keyboard navigation
			$items.on(
				'keydown',
				function (e) {
					var $currentItem = $( this );
					var currentIndex = $items.index( $currentItem );
					var nextIndex, $nextItem;

					// Handle arrow keys
					switch (e.keyCode) {
						case 37: // left arrow
						case 38: // up arrow
							nextIndex = Math.max( 0, currentIndex - 1 );
							$nextItem = $items.eq( nextIndex );
							$nextItem.focus();
							e.preventDefault();
							break;
						case 39: // right arrow
						case 40: // down arrow
							nextIndex = Math.min( $items.length - 1, currentIndex + 1 );
							$nextItem = $items.eq( nextIndex );
							$nextItem.focus();
							e.preventDefault();
							break;
						case 36: // home
							$items.first().focus();
							e.preventDefault();
							break;
						case 35: // end
							$items.last().focus();
							e.preventDefault();
							break;
					}
				}
			);
		},

		/**
		 * Refresh the timeline (useful after dynamic content changes)
		 */
		refresh: function ($timeline) {
			if ( ! $timeline) {
				$( '.aiq-value-timeline' ).each(
					function () {
						ValueTimeline.initProgressBar( $( this ) );
					}
				);
			} else {
				ValueTimeline.initProgressBar( $timeline );
			}
		}
	};

	// Initialize on document ready
	$( document ).ready(
		function () {
			ValueTimeline.init();
		}
	);

	// Initialize on Elementor frontend init
	$( window ).on(
		'elementor/frontend/init',
		function () {
			if (typeof elementorFrontend !== 'undefined' && elementorFrontend.hooks) {
				elementorFrontend.hooks.addAction(
					'frontend/element_ready/aiq_value_timeline.default',
					function ($scope) {
						ValueTimeline.init();
					}
				);
			}
		}
	);

	// Add to global scope for external access
	window.AIQValueTimeline = ValueTimeline;

})( jQuery );
