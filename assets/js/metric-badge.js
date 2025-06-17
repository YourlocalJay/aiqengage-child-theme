/* assets/js/widgets/metric-badge.js */

/**
 * Metric Badge Widget
 * 
 * Handles animated counters and accessibility features
 * 
 * @package AIQEngage
 * @version 1.0.0
 */

( function( $ ) {
    'use strict';
    
    /**
     * Initialize Metric Badge functionality
     */
    function initMetricBadges() {
        $( '.aiq-metric-badge[data-counter="true"]' ).each( function() {
            const $badge = $( this );
            const $valueElement = $badge.find( '.aiq-metric-badge__value' );
            const endValue = parseFloat( $badge.data( 'value' ) ) || 0;
            const suffix = $badge.data( 'suffix' ) || '';
            const duration = parseInt( $badge.data( 'duration' ) ) || 2000;
            
            // Only run counter animation if value is numeric
            if ( isNaN( endValue ) {
                return;
            }
            
            // Reset counter value to zero
            $valueElement.text( '0' + suffix );
            
            // Start counter when in viewport
            createIntersectionObserver( $badge, function() {
                animateCounter( $valueElement, 0, endValue, duration, suffix );
            } );
        } );
        
        // Handle keyboard navigation for accessibility
        $( '.aiq-metric-badge' ).attr( 'tabindex', '0' )
            .on( 'keydown', function( e ) {
                // If Enter or Space key is pressed
                if ( e.key === 'Enter' || e.key === ' ' ) {
                    e.preventDefault();
                    $( this ).trigger( 'click' );
                }
            } );
    }
    
    /**
     * Animate counter from start to end value
     * 
     * @param {jQuery} $element Element to update
     * @param {number} startValue Starting value
     * @param {number} endValue Ending value
     * @param {number} duration Animation duration in milliseconds
     * @param {string} suffix Optional suffix (e.g. '%')
     */
    function animateCounter( $element, startValue, endValue, duration, suffix ) {
        try {
            // Determine if value is an integer or has decimal places
            const isInteger = Number.isInteger( endValue );
            const decimalPlaces = isInteger ? 0 : getDecimalPlaces( endValue );
            
            // Use requestAnimationFrame for smoother animation
            const startTime = performance.now();
            
            function updateCounter( currentTime ) {
                // Calculate progress (0 to 1)
                const elapsed = currentTime - startTime;
                const progress = Math.min( elapsed / duration, 1 );
                
                // Calculate current value using easeOutQuad easing function
                const currentValue = startValue + ( easeOutQuad( progress ) * ( endValue - startValue );
                
                // Format and display the value
                const formattedValue = isInteger ? 
                    Math.floor( currentValue ).toLocaleString() : 
                    currentValue.toFixed( decimalPlaces ).toLocaleString();
                
                $element.text( formattedValue + suffix );
                
                // Announce for screen readers on significant changes (25%, 50%, 75%, 100%)
                const milestones = [ 0.25, 0.5, 0.75, 1 ];
                if ( milestones.some( m => Math.abs( progress - m ) < 0.01 ) ) {
                    $element.attr( 'aria-live', 'polite' );
                } else {
                    $element.attr( 'aria-live', 'off' );
                }
                
                // Continue animation if not complete
                if ( progress < 1 ) {
                    requestAnimationFrame( updateCounter );
                }
            }
            
            requestAnimationFrame( updateCounter );
        } catch ( error ) {
            console.error( 'Error in counter animation:', error );
            // Fallback to showing the final value
            $element.text( endValue + suffix );
        }
    }
    
    /**
     * Create intersection observer to trigger animation when element is visible
     * 
     * @param {jQuery} $element Element to observe
     * @param {Function} callback Function to call when element is visible
     */
    function createIntersectionObserver( $element, callback ) {
        // Skip if IntersectionObserver is not supported
        if ( ! ( 'IntersectionObserver' in window ) ) {
            callback();
            return;
        }
        
        const observer = new IntersectionObserver( 
            ( entries ) => {
                entries.forEach( entry => {
                    if ( entry.isIntersecting ) {
                        callback();
                        observer.unobserve( entry.target );
                    }
                } );
            }, 
            { 
                rootMargin: '0px 0px -100px 0px',
                threshold: 0.1 
            } 
        );
        
        observer.observe( $element[ 0 ] );
    }
    
    /**
     * Ease out quad easing function
     * 
     * @param {number} t Progress (0-1)
     * @return {number} Eased value
     */
    function easeOutQuad( t ) {
        return t * ( 2 - t );
    }
    
    /**
     * Get number of decimal places in a number
     * 
     * @param {number} num Number to check
     * @return {number} Number of decimal places (max 2)
     */
    function getDecimalPlaces( num ) {
        try {
            const match = ( '' + num ).match( /(?:\.(\d+))?$/ );
            return match ? Math.min( match[ 1 ].length, 2 ) : 0;
        } catch ( error ) {
            return 0;
        }
    }
    
    /**
     * Initialize when document is ready
     */
    $( document ).ready( function() {
        initMetricBadges();
    } );
    
    /**
     * Re-initialize when Elementor frontend is initialized or preview is refreshed
     */
    $( window ).on( 'elementor/frontend/init', function() {
        elementorFrontend.hooks.addAction( 
            'frontend/element_ready/aiq_metric_badge.default', 
            function() {
                initMetricBadges();
            } 
        );
    } );
    
} )( jQuery );
