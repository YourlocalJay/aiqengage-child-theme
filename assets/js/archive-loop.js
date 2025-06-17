/* aiq-archive-loop Widget Scripts */

(function($) {
    'use strict';
    
    // Archive Loop Widget JavaScript functionality
    $(document).ready(function() {
        $('.aiq-archive-loop').each(function() {
            const $widget = $(this);
            
            // Initialize archive loop functionality
            initArchiveLoop($widget);
        });
    });
    
    function initArchiveLoop($widget) {
        // Archive loop specific JavaScript here
        console.log('Archive Loop Widget initialized');
    }
    
})(jQuery);
