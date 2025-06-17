/* aiq-resource-card Widget Scripts */

(function($) {
    'use strict';
    
    // Resource Card Widget JavaScript functionality
    $(document).ready(function() {
        $('.aiq-resource-card').each(function() {
            const $widget = $(this);
            
            // Initialize resource card functionality
            initResourceCard($widget);
        });
    });
    
    function initResourceCard($widget) {
        // Add interactive features for resource cards
        const $cards = $widget.find('.aiq-resource-card__item');
        
        $cards.each(function() {
            const $card = $(this);
            const $downloadBtn = $card.find('.aiq-resource-card__download');
            const $previewBtn = $card.find('.aiq-resource-card__preview');
            
            // Handle download button clicks
            $downloadBtn.on('click', function(e) {
                const $btn = $(this);
                $btn.addClass('is-downloading');
                
                // Add visual feedback
                setTimeout(() => {
                    $btn.removeClass('is-downloading');
                    $btn.addClass('is-complete');
                    
                    setTimeout(() => {
                        $btn.removeClass('is-complete');
                    }, 2000);
                }, 1000);
            });
            
            // Handle preview functionality
            $previewBtn.on('click', function(e) {
                e.preventDefault();
                
                // Add preview modal or inline preview functionality
                const previewUrl = $(this).attr('href');
                if (previewUrl && previewUrl !== '#') {
                    // Open preview in modal or new tab
                    window.open(previewUrl, '_blank');
                }
            });
            
            // Add hover effects
            $card.on('mouseenter', function() {
                $(this).addClass('is-hovered');
            }).on('mouseleave', function() {
                $(this).removeClass('is-hovered');
            });
        });
        
        console.log('Resource Card Widget initialized');
    }
    
})(jQuery);
