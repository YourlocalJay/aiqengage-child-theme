/**
 * AIQEngage Notification Bar Script
 * Handles showing/hiding the sticky notification bar based on scroll position
 */

(function($) {
    'use strict';
    
    // Notification bar functionality
    $(document).ready(function() {
        const $notificationBar = $('#sticky-notification-bar');
        const scrollTrigger = notificationBarData.scrollTrigger / 100; // Convert percentage to decimal
        const dismissible = notificationBarData.dismissible;
        const dismissDays = notificationBarData.dismissDays;
        
        // Check if notification was previously dismissed
        const dismissedUntil = localStorage.getItem('aiqengage_notification_dismissed');
        const now = new Date().getTime();
        
        // If notification was dismissed and still within dismissal period, don't show
        if (dismissible && dismissedUntil && parseInt(dismissedUntil) > now) {
            return;
        }
        
        // Handle scroll event to show/hide notification
        $(window).on('scroll', function() {
            const scrollPosition = $(window).scrollTop();
            const documentHeight = $(document).height() - $(window).height();
            
            // Show notification when scrolled past trigger point
            if (scrollPosition > (documentHeight * scrollTrigger)) {
                $notificationBar.addClass('show');
            } else {
                $notificationBar.removeClass('show');
            }
            
            // Hide notification when scrolling back up
            if (window.prevScrollPosition && scrollPosition < window.prevScrollPosition) {
                $notificationBar.removeClass('show');
            }
            
            window.prevScrollPosition = scrollPosition;
        });
        
        // Handle close button click
        $('.notification-close').on('click', function() {
            $notificationBar.removeClass('show');
            
            // If dismissible, store dismissal in localStorage
            if (dismissible) {
                const dismissalTime = new Date().getTime() + (dismissDays * 24 * 60 * 60 * 1000); // Convert days to milliseconds
                localStorage.setItem('aiqengage_notification_dismissed', dismissalTime.toString());
            }
        });
        
        // Track interactions with notification buttons
        $('.notification-buttons .btn').on('click', function() {
            // If analytics is available, track the click
            if (typeof gtag === 'function') {
                gtag('event', 'notification_click', {
                    'event_category': 'engagement',
                    'event_label': $(this).text().trim()
                });
            }
            
            // If you want to dismiss the notification after clicking a button
            if (dismissible) {
                const dismissalTime = new Date().getTime() + (dismissDays * 24 * 60 * 60 * 1000);
                localStorage.setItem('aiqengage_notification_dismissed', dismissalTime.toString());
            }
        });
        
        // Check URL parameters for hiding notification
        const urlParams = new URLSearchParams(window.location.search);
        if (urlParams.has('hide_notification')) {
            // If URL contains hide_notification parameter, don't show notification for this session
            sessionStorage.setItem('aiqengage_hide_notification', 'true');
        }
        
        if (sessionStorage.getItem('aiqengage_hide_notification') === 'true') {
            return;
        }
    });
    
})(jQuery);
