/**
 * AIQEngage Conversion Tracking
 * 
 * Handles user interaction tracking for conversion optimization.
 */

(function() {
    'use strict';

    // Initialization
    document.addEventListener('DOMContentLoaded', function() {
        // Setup event listeners for conversion tracking
        setupConversionTracking();
    });

    /**
     * Sets up event listeners for tracking user interactions
     */
    function setupConversionTracking() {
        // Track form submissions
        document.querySelectorAll('form').forEach(form => {
            form.addEventListener('submit', trackFormSubmission);
        });

        // Track CTA button clicks
        document.querySelectorAll('.cta-button, .primary-cta').forEach(button => {
            button.addEventListener('click', trackCTAClick);
        });

        // Track scroll depth
        setupScrollDepthTracking();
    }

    /**
     * Tracks form submissions
     * @param {Event} event - The form submission event
     */
    function trackFormSubmission(event) {
        const form = event.currentTarget;
        const formId = form.id || 'unknown-form';
        const formAction = form.getAttribute('action') || 'unknown-action';

        // Send tracking data
        sendConversionEvent('form_submission', {
            form_id: formId,
            form_action: formAction
        });
    }

    /**
     * Tracks CTA button clicks
     * @param {Event} event - The click event
     */
    function trackCTAClick(event) {
        const button = event.currentTarget;
        const buttonText = button.textContent.trim();
        const buttonHref = button.getAttribute('href') || '';

        // Send tracking data
        sendConversionEvent('cta_click', {
            button_text: buttonText,
            button_href: buttonHref
        });
    }

    /**
     * Sets up scroll depth tracking
     */
    function setupScrollDepthTracking() {
        const scrollDepths = [25, 50, 75, 100];
        let trackedDepths = [];

        window.addEventListener('scroll', function() {
            const scrollPercent = getScrollPercent();
            
            scrollDepths.forEach(depth => {
                if (scrollPercent >= depth && !trackedDepths.includes(depth)) {
                    trackedDepths.push(depth);
                    sendConversionEvent('scroll_depth', {
                        depth_percent: depth
                    });
                }
            });
        });
    }

    /**
     * Gets the current scroll percentage
     * @returns {number} - Scroll percentage (0-100)
     */
    function getScrollPercent() {
        const h = document.documentElement;
        const b = document.body;
        const st = 'scrollTop';
        const sh = 'scrollHeight';
        
        return (h[st] || b[st]) / ((h[sh] || b[sh]) - h.clientHeight) * 100;
    }

    /**
     * Sends conversion event data to analytics
     * @param {string} eventName - Name of the event
     * @param {Object} eventData - Event data object
     */
    function sendConversionEvent(eventName, eventData) {
        // Send to Google Analytics if available
        if (window.gtag) {
            gtag('event', eventName, eventData);
        }
        
        // Send to internal tracking if needed
        console.log(`Conversion event: ${eventName}`, eventData);
    }
})();