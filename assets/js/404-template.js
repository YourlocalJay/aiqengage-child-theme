/* global lottie, elementor, jQuery:false */
/**
 * 404 Template Widget Script
 *
 * @package aiqengage-child
 * @version 1.0.0
 * @since   1.0.0
 */

(function ($) {
	'use strict';

	/**
	 * Initialize the widget functionality
	 */
	function init404TemplateWidget() {
		// Find all widget instances on the page
		$( '.aiq-404-template' ).each(
			function () {
				const $widget = $( this );

				// Initialize components
				initLottieAnimation( $widget );
				initSearchForm( $widget );
				initParallaxEffect( $widget );
				initSVGAnimations( $widget );
			}
		);
	}

	/**
	 * Initialize Lottie animations
	 *
	 * @param {jQuery} $widget The widget element
	 */
	function initLottieAnimation($widget) {
		const $lottieElement = $widget.find( '.aiq-404-template__lottie' );

		if ( ! $lottieElement.length || typeof lottie === 'undefined') {
			return;
		}

		const lottieUrl         = $lottieElement.data( 'lottie-url' );
		const animationDuration = $lottieElement.data( 'animation-duration' ) || 4;

		if ( ! lottieUrl) {
			return;
		}

		// Set CSS variable for animation duration
		$lottieElement.css( '--aiq-mascot-duration', animationDuration + 's' );

		try {
			const animation = lottie.loadAnimation(
				{
					container: $lottieElement[0],
					renderer: 'svg',
					loop: true,
					autoplay: true,
					path: lottieUrl,
				}
			);

			// Handle animation load errors
			animation.addEventListener(
				'data_failed',
				function () {
					console.warn( 'Failed to load Lottie animation from:', lottieUrl );
					showFallbackImage( $lottieElement );
				}
			);
		} catch (error) {
			console.error( 'Lottie initialization error:', error );
			showFallbackImage( $lottieElement );
		}
	}

	/**
	 * Show fallback image when Lottie fails
	 *
	 * @param {jQuery} $element The element to replace
	 */
	function showFallbackImage($element) {
		const fallbackImg = document.createElement( 'img' );
		fallbackImg.src   = 'data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iMjAwIiBoZWlnaHQ9IjIwMCIgdmlld0JveD0iMCAwIDIwMCAyMDAiIGZpbGw9Im5vbmUiIHhtbG5zPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyI+PHJlY3Qgd2lkdGg9IjIwMCIgaGVpZ2h0PSIyMDAiIHJ4PSIxMDAiIGZpbGw9IiMxQTA5MzgiLz48dGV4dCB4PSI3MCIgeT0iMTA4IiBmb250LWZhbWlseT0iQXJpYWwiIGZvbnQtc2l6ZT0iNjAiIGZpbGw9IiNFMEQ2RkYiPj8/PC90ZXh0Pjwvc3ZnPg==';
		fallbackImg.alt   = 'AI Assistant';
		fallbackImg.classList.add( 'aiq-404-template__mascot-image' );

		// Replace Lottie container with fallback image
		$element.replaceWith( fallbackImg );
	}

	/**
	 * Initialize search form enhancements
	 *
	 * @param {jQuery} $widget The widget element
	 */
	function initSearchForm($widget) {
		const $searchForm   = $widget.find( '.aiq-404-template__search-form' );
		const $searchInput  = $widget.find( '.aiq-404-template__search-input' );
		const $searchButton = $widget.find( '.aiq-404-template__search-button' );

		if ( ! $searchForm.length || ! $searchInput.length || ! $searchButton.length) {
			return;
		}

		// Add focus/blur effects
		$searchInput.on(
			'focus',
			function () {
				$searchForm.addClass( 'is-focused' );
			}
		).on(
			'blur',
			function () {
				$searchForm.removeClass( 'is-focused' );
			}
		);

		// Ensure button submits the form
		$searchButton.on(
			'click',
			function (e) {
				e.preventDefault();
				if ($searchInput.val().trim()) {
					$searchForm.submit();
				} else {
					$searchInput.focus();
				}
			}
		);
	}

	/**
	 * Initialize parallax effect for neural pattern
	 *
	 * @param {jQuery} $widget The widget element
	 */
	function initParallaxEffect($widget) {
		const $neuralPattern = $widget.find( '.aiq-404-template__neural-pattern' );

		if ( ! $neuralPattern.length) {
			return;
		}

		// Check for reduced motion preference
		if (window.matchMedia( '(prefers-reduced-motion: reduce)' ).matches) {
			return;
		}

		// Add parallax effect on mouse move
		$widget.on(
			'mousemove',
			function (e) {
				if (window.innerWidth < 768) {
					return;
				}

				const rect = this.getBoundingClientRect();
				const x    = (e.clientX - rect.left) / rect.width;
				const y    = (e.clientY - rect.top) / rect.height;

				// Calculate the movement amount (subtle effect)
				const moveX = (x - 0.5) * 20;
				const moveY = (y - 0.5) * 20;

				// Apply the transformation
				$neuralPattern.css( 'transform', `translate( ${moveX}px, ${moveY}px )` );
			}
		);

		// Reset position when mouse leaves
		$widget.on(
			'mouseleave',
			function () {
				$neuralPattern.css( 'transform', 'translate(0, 0)' );
			}
		);
	}

	/**
	 * Initialize SVG animations
	 *
	 * @param {jQuery} $widget The widget element
	 */
	function initSVGAnimations($widget) {
		const $svgContainer = $widget.find( '.aiq-404-template__svg' );

		if ( ! $svgContainer.length) {
			return;
		}

		// Check for reduced motion preference
		if (window.matchMedia( '(prefers-reduced-motion: reduce)' ).matches) {
			return;
		}

		// Find all paths in the SVG
		const $paths = $svgContainer.find( 'path, circle, line, rect' );
		if ( ! $paths.length) {
			return;
		}

		// Add animation class and random delay to each element
		$paths.each(
			function () {
				const $element = $( this );
				$element.addClass( 'aiq-svg-animated' );

				// Set random animation delay for each element
				const delay = Math.random() * 3;
				$element.css( 'animation-delay', `${delay}s` );
			}
		);

		// Add CSS animation styles if not already present
		if ( ! $( '#aiq-svg-animations' ).length) {
			$(
				'<style id="aiq-svg-animations">' +
				'.aiq-svg-animated { animation: aiqSvgPulse 4s ease-in-out infinite; }' +
				'@keyframes aiqSvgPulse { 0% { opacity: 0.7; } 50% { opacity: 1; } 100% { opacity: 0.7; } }' +
				'</style>'
			).appendTo( 'head' );
		}
	}

	// Initialize on DOM ready
	$( document ).ready(
		function () {
			init404TemplateWidget();
		}
	);

	// Reinitialize when Elementor elements are loaded (for editor and dynamic content)
	if (typeof elementor !== 'undefined') {
		elementor.hooks.addAction( 'frontend/element_ready/aiq_404_template.default', init404TemplateWidget );
	}
})( jQuery );
