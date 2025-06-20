/**
 * Tool Card Widget Script
 *
 * @package aiqengage-child
 * @version 1.0.0
 * @since   1.0.0
 * @author  Jason
 */

(function ($) {
	'use strict';

	// Configuration constants
	const CONFIG = {
		CATEGORY_COLORS: {
			'writer': '#9C4DFF',
			'automation': '#635BFF',
			'research': '#7F5AF0',
			'design': '#8E6BFF',
			'analytics': '#5E72E4',
			'productivity': '#A0AEC0',
			'default': '#4A5568'
		},
		LOCAL_STORAGE_KEY: 'aiq_user_profile',
		TRANSITION_DURATION: '0.3s',
		LOGO_SCALE: 1.05
	};

	// Tracking functions
	const Tracking = {
		/**
		 * Track tool card click event
		 *
		 * @param {string} trackingId - Unique tracking identifier
		 * @param {string} toolName - Name of the tool
		 * @param {string} toolCategory - Category of the tool
		 */
		trackClick: function (trackingId, toolName, toolCategory) {
			// Google Analytics tracking
			if (typeof gtag === 'function') {
				try {
					gtag(
						'event',
						'tool_click',
						{
							'event_category': 'Affiliate',
							'event_label': toolName,
							'value': 1,
							'tool_category': toolCategory,
							'tracking_id': trackingId
						}
					);
				} catch (e) {
					console.warn( 'GA tracking error:', e );
				}
			}

			// Internal analytics tracking
			if (typeof window.aiqAnalytics === 'object' &&
				typeof window.aiqAnalytics.trackInteraction === 'function') {
				try {
					window.aiqAnalytics.trackInteraction(
						'toolClick',
						trackingId,
						{
							category: toolCategory,
							weight: 1,
							name: toolName
						}
					);
				} catch (e) {
					console.warn( 'Internal analytics error:', e );
				}
			}

			// Update user profile in localStorage
			this.updateUserProfile( toolCategory );
		},

		/**
		 * Update user profile with interaction data
		 *
		 * @param {string} category - Tool category
		 */
		updateUserProfile: function (category) {
			try {
				const profile = JSON.parse(
					localStorage.getItem( CONFIG.LOCAL_STORAGE_KEY ) || '{}'
				);

				// Initialize profile structure if needed
				profile.interactions            = profile.interactions || {};
				profile.interactions.toolClicks =
					(profile.interactions.toolClicks || 0) + 1;

				// Track category interests
				profile.interests           = profile.interests || {};
				profile.interests[category] =
					(profile.interests[category] || 0) + 1;

				localStorage.setItem(
					CONFIG.LOCAL_STORAGE_KEY,
					JSON.stringify( profile )
				);
			} catch (error) {
				console.warn( 'User profile update failed:', error );
			}
		}
	};

	// Animation handlers
	const Animations = {
		/**
		 * Initialize hover animations for a card
		 *
		 * @param {jQuery} $card - Tool card jQuery element
		 */
		initCardHover: function ($card) {
			const $logo = $card.find( '.aiq-tool-card__logo' );

			// Set up logo scale animation
			$logo.css( 'transition', `transform ${CONFIG.TRANSITION_DURATION} ease` );

			$card.on(
				'mouseenter mouseleave',
				function (event) {
					const scale = event.type === 'mouseenter' ? CONFIG.LOGO_SCALE : 1;
					$logo.css( 'transform', `scale( ${scale} )` );
				}
			);
		},

		/**
		 * Initialize button hover effects
		 *
		 * @param {jQuery} $button - Button element
		 * @param {string} category - Tool category
		 */
		initButtonHover: function ($button, category) {
			const color = CONFIG.CATEGORY_COLORS[category] || CONFIG.CATEGORY_COLORS.default;

			$button.on(
				'mouseenter mouseleave',
		function () {
			const shadow = event.type === 'mouseenter'
			? `0 4px 12px ${color}66`
			: '';
			$( this ).css( 'box-shadow', shadow );
		}
			);
		}
	};

	// Accessibility enhancements
	const Accessibility = {
		/**
		 * Enhance accessibility for a tool card
		 *
		 * @param {jQuery} $card - Tool card jQuery element
		 */
		enhance: function ($card) {
			const category = $card.data( 'category' );
			$card.find( '.aiq-tool-card__category' )
				.attr( 'aria-label', `Category: ${category}` );

			// Ensure buttons have proper ARIA attributes
			$card.find( '.aiq-tool-card__button' )
				.attr( 'aria-label', `Visit ${$card.find( '.aiq-tool-card__title' ).text()}` );
		}
	};

	/**
	 * Initialize a single tool card
	 *
	 * @param {jQuery} $card - Tool card jQuery element
	 */
	function initToolCard($card) {
		const category = $card.data( 'category' );

		// Initialize animations
		Animations.initCardHover( $card );
		Animations.initButtonHover(
			$card.find( '.aiq-tool-card__button' ),
			category
		);

		// Apply accessibility enhancements
		Accessibility.enhance( $card );
	}

	/**
	 * Initialize all tool cards on the page
	 */
	function initAllToolCards() {
		$( '.aiq-tool-card' ).each(
			function () {
				initToolCard( $( this ) );
			}
		);
	}

	// Event handlers
	$( document )
		// Track affiliate link clicks
		.on(
			'click',
			'.aiq-tool-card__button',
			function () {
				const $card = $( this ).closest( '.aiq-tool-card' );
				Tracking.trackClick(
					$( this ).data( 'tracking-id' ),
					$card.find( '.aiq-tool-card__title' ).text(),
					$card.data( 'category' )
				);
			}
		);

	// Initialization
	$(
		function () {
			// Standard initialization
			initAllToolCards();

			// Elementor-specific initialization
			if (typeof elementorFrontend !== 'undefined') {
				elementorFrontend.hooks.addAction(
					'frontend/element_ready/aiq_tool_card.default',
					function ($scope) {
						$scope.find( '.aiq-tool-card' ).each(
							function () {
								initToolCard( $( this ) );
							}
						);
					}
				);
			}
		}
	);

})( jQuery );
