/* aiq-pricing-table Widget Scripts */

(function($) {
    'use strict';
    
    // Pricing Table Widget JavaScript functionality
    $(document).ready(function() {
        $('.aiq-pricing-table').each(function() {
            const $widget = $(this);
            
            // Initialize pricing table functionality
            initPricingTable($widget);
        });
    });
    
    function initPricingTable($widget) {
        // Add hover effects and interactive features
        const $pricingCards = $widget.find('.aiq-pricing-table__card');
        
        $pricingCards.on('mouseenter', function() {
            $(this).addClass('is-highlighted');
        }).on('mouseleave', function() {
            $(this).removeClass('is-highlighted');
        });
        
        // Handle CTA button clicks
        $widget.find('.aiq-pricing-table__cta').on('click', function(e) {
            // Add click tracking or animations here
            const $card = $(this).closest('.aiq-pricing-table__card');
            $card.addClass('is-clicked');
            
            setTimeout(() => {
                $card.removeClass('is-clicked');
            }, 200);
        });
        
        console.log('Pricing Table Widget initialized');
    }
    
})(jQuery);
