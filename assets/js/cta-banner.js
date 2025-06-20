/**
 * CTA Banner Widget Script
 *
 * @package aiqengage-child
 * @version 1.0.0
 * @since   1.0.0
 * @author  Jason
 */

(function ($, gtag) {
	'use strict';

	// Initialize on document ready
	$( document ).ready(
		function () {
			initStickyBanners();
		}
	);

	/**
	 * Initialize all sticky CTA banners on the page
	 */
	function initStickyBanners() {
		$( '.aiq-cta-banner--sticky' ).each(
			function () {
				const $banner       = $( this );
				const bannerId      = $banner.attr( 'id' );
				const scrollTrigger = parseInt( $banner.data( 'scroll-trigger' ) ) || 45;
				const cookieExpiry  = parseInt( $banner.data( 'cookie-expiry' ) ) || 7;

				// Check if banner should be hidden based on cookie
				if ($banner.find( '.aiq-cta-banner__close' ).length && hasDismissCookie( bannerId )) {
					return; // Skip this banner if it was dismissed
				}

				// Set up scroll trigger
				setupScrollTrigger( $banner, scrollTrigger );

				// Set up close button functionality
				setupCloseButton( $banner, bannerId, cookieExpiry );
			}
		);
	}

	/**
	 * Set up scroll trigger for sticky banner visibility
	 */
	function setupScrollTrigger($banner, scrollTrigger) {
		const showOnScroll = function () {
			const scrollPercent = ($( window ).scrollTop() / ($( document ).height() - $( window ).height())) * 100;

			if (scrollPercent >= scrollTrigger) {
				$banner.addClass( 'aiq-cta-banner--visible' );
			} else {
				$banner.removeClass( 'aiq-cta-banner--visible' );
			}
		};

		// Initial check
		showOnScroll();

		// Check on scroll
		$( window ).on(
			'scroll',
			function () {
				showOnScroll();
			}
		);
	}

	/**
	 * Set up close button functionality
	 */
	function setupCloseButton($banner, bannerId, cookieExpiry) {
		$banner.find( '.aiq-cta-banner__close' ).on(
			'click',
			function () {
				$banner.removeClass( 'aiq-cta-banner--visible' );

				// Slide up animation before complete removal
				$banner.css( 'transform', $banner.hasClass( 'aiq-cta-banner--sticky-top' ) ? 'translateY(-100%)' : 'translateY(100%)' );

				// Set cookie to remember dismissal
				setDismissCookie( bannerId, cookieExpiry );

				return false;
			}
		);
	}

	/**
	 * Check if dismissal cookie exists
	 */
	function hasDismissCookie(bannerId) {
		if (typeof localStorage !== 'undefined') {
			const cookieName     = 'aiq_cta_dismissed_' + bannerId;
			const dismissedUntil = localStorage.getItem( cookieName );

			if (dismissedUntil && parseInt( dismissedUntil ) > Date.now()) {
				return true;
			}
		}

		return false;
	}

	/**
	 * Set dismissal cookie
	 */
	function setDismissCookie(bannerId, expiryDays) {
		if (typeof localStorage !== 'undefined') {
			const cookieName = 'aiq_cta_dismissed_' + bannerId;
			const expiryTime = Date.now() + (expiryDays * 24 * 60 * 60 * 1000); // Convert days to milliseconds

			localStorage.setItem( cookieName, expiryTime.toString() );
		}
	}

	/**
	 * Track CTA engagement
	 */
	function trackCTAEngagement($banner) {
		// Initialize click tracking on CTA buttons
		$banner.find( '.aiq-cta-banner__button' ).on(
			'click',
			function () {
				const buttonType = $( this ).hasClass( 'aiq-cta-banner__button--primary' ) ? 'primary' : 'secondary';
				const buttonId   = $( this ).attr( 'id' ) || '';
				const buttonText = $( this ).text().trim();

				// Check if analytics tracking is available
				if (typeof gtag === 'function') {
					gtag(
						'event',
						'cta_click',
						{
							'event_category': 'CTA Banner',
							'event_label': buttonText,
							'banner_id': $banner.attr( 'id' ),
							'button_type': buttonType,
							'button_id': buttonId
						}
					);
				}

				// Optional: Store interaction in localStorage for personalization
				if (typeof localStorage !== 'undefined') {
					try {
						// Get existing interactions or initialize
						const interactions = JSON.parse( localStorage.getItem( 'aiq_cta_interactions' ) || '{}' );

						// Update interaction count
						const bannerId = $banner.attr( 'id' );
						if ( ! interactions[bannerId]) {
							interactions[bannerId] = {};
						}

						if ( ! interactions[bannerId][buttonType]) {
							interactions[bannerId][buttonType] = 0;
						}

						interactions[bannerId][buttonType]++;
						interactions.last_interaction = Date.now();

						// Save updated interactions
						localStorage.setItem( 'aiq_cta_interactions', JSON.stringify( interactions ) );
					} catch (e) {
						console.warn( 'Failed to store CTA interaction:', e );
					}
				}
			}
		);
	}

	// Document load event with jQuery fallback
	$(
		function () {
			// Initialize all sticky banners
			initStickyBanners();

			// Set up engagement tracking for all CTA banners
			$( '.aiq-cta-banner' ).each(
				function () {
					trackCTAEngagement( $( this ) );
				}
			);
		}
	);

})( window.jQuery, window.gtag );
