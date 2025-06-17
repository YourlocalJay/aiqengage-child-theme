/**
 * AIQEngage Prompt Card Grid Scripts
 * Version: 1.0.0
 */

(function($) {
    'use strict';

    /**
     * Initialize Prompt Card functionality
     */
    function initPromptCards() {
        // Copy to clipboard functionality
        $('.aiq-prompt-card-copy').on('click', function(e) {
            e.preventDefault();
            
            const targetId = $(this).data('target');
            const textToCopy = $('#' + targetId).text();
            const $button = $(this);
            const originalText = $button.find('.aiq-copy-text').text();
            
            // Copy to clipboard
            navigator.clipboard.writeText(textToCopy).then(function() {
                // Success feedback
                $button.find('.aiq-copy-text').text('Copied!');
                $button.addClass('copied');
                
                // Reset after 2 seconds
                setTimeout(function() {
                    $button.find('.aiq-copy-text').text(originalText);
                    $button.removeClass('copied');
                }, 2000);
            }).catch(function(err) {
                // Fallback for older browsers
                fallbackCopyTextToClipboard(textToCopy, $button, originalText);
            });
        });

        // Toggle results
        $('.aiq-prompt-card-toggle-btn').on('click', function(e) {
            e.preventDefault();
            
            const targetId = $(this).data('target');
            const $results = $('#' + targetId);
            const $icon = $(this).find('.aiq-toggle-icon');
            
            $results.slideToggle(300, function() {
                if ($results.is(':visible')) {
                    $results.addClass('active');
                    $icon.text('−');
                } else {
                    $results.removeClass('active');
                    $icon.text('+');
                }
            });
        });

        // Category filter
        $('.aiq-category-filter button').on('click', function(e) {
            e.preventDefault();
            
            const filter = $(this).data('filter');
            const $grid = $(this).closest('.elementor-widget-container').find('.aiq-prompt-grid');
            const $cards = $grid.find('.aiq-prompt-card');
            
            // Update active state
            $(this).siblings().removeClass('active');
            $(this).addClass('active');
            
            // Filter cards
            if (filter === 'all') {
                $cards.fadeIn(300);
            } else {
                $cards.each(function() {
                    if ($(this).data('category') === filter) {
                        $(this).fadeIn(300);
                    } else {
                        $(this).fadeOut(200);
                    }
                });
            }
            
            // Optional: rearrange layout for best fit
            setTimeout(function() {
                rearrangeGrid($grid);
            }, 350);
        });
    }

    /**
     * Fallback copy to clipboard for browsers that don't support Clipboard API
     */
    function fallbackCopyTextToClipboard(text, $button, originalText) {
        const textArea = document.createElement("textarea");
        textArea.value = text;
        
        // Make the textarea out of viewport
        textArea.style.position = "fixed";
        textArea.style.left = "-999999px";
        textArea.style.top = "-999999px";
        document.body.appendChild(textArea);
        textArea.focus();
        textArea.select();
        
        try {
            const successful = document.execCommand('copy');
            if (successful) {
                $button.find('.aiq-copy-text').text('Copied!');
                $button.addClass('copied');
            } else {
                $button.find('.aiq-copy-text').text('Failed!');
            }
        } catch (err) {
            $button.find('.aiq-copy-text').text('Failed!');
        }
        
        // Cleanup
        document.body.removeChild(textArea);
        
        // Reset after 2 seconds
        setTimeout(function() {
            $button.find('.aiq-copy-text').text(originalText);
            $button.removeClass('copied');
        }, 2000);
    }

    /**
     * Rearrange grid for best fit after filtering
     */
    function rearrangeGrid($grid) {
        // This function could be used for advanced layout adjustments
        // For example, implementing a masonry-like layout
        // Currently just a placeholder for future enhancements
    }

    /**
     * Handle user interactions like hover effects
     */
    function setupInteractions() {
        // Add hover effect to cards
        $('.aiq-prompt-card').hover(
            function() {
                $(this).css('transform', 'translateY(-3px)');
                $(this).css('box-shadow', '0 8px 20px rgba(0, 0, 0, 0.4)');
            },
            function() {
                $(this).css('transform', 'translateY(0)');
                $(this).css('box-shadow', '0 5px 15px rgba(0, 0, 0, 0.3)');
            }
        );
        
        // Add hover effect to filter buttons
        $('.aiq-category-filter button').hover(
            function() {
                if (!$(this).hasClass('active')) {
                    $(this).css('background-color', 'rgba(126, 87, 194, 0.3)');
                }
            },
            function() {
                if (!$(this).hasClass('active')) {
                    $(this).css('background-color', 'rgba(126, 87, 194, 0.2)');
                }
            }
        );
    }

    /**
     * Handle responsive adaptations
     */
    function setupResponsive() {
        const handleResize = function() {
            if (window.innerWidth <= 767) {
                // Mobile adjustments
                $('.aiq-prompt-card-copy .aiq-copy-text').hide();
            } else {
                // Desktop layout
                $('.aiq-prompt-card-copy .aiq-copy-text').show();
            }
        };
        
        // Initial call
        handleResize();
        
        // Bind to window resize
        $(window).on('resize', handleResize);
    }

    /**
     * Initialize animations
     */
    function setupAnimations() {
        // Use Intersection Observer for revealing elements on scroll
        if ('IntersectionObserver' in window) {
            const config = {
                root: null,
                rootMargin: '0px',
                threshold: 0.1
            };
            
            const observer = new IntersectionObserver(function(entries) {
                entries.forEach(function(entry) {
                    if (entry.isIntersecting) {
                        entry.target.classList.add('aiq-animated');
                        observer.unobserve(entry.target);
                    }
                });
            }, config);
            
            document.querySelectorAll('.aiq-prompt-card').forEach(function(card) {
                observer.observe(card);
            });
        } else {
            // Fallback for browsers that don't support IntersectionObserver
            document.querySelectorAll('.aiq-prompt-card').forEach(function(card) {
                card.classList.add('aiq-animated');
            });
        }
    }

    /**
     * Initialize functionality when Elementor frontend is available
     */
    $(window).on('elementor/frontend/init', function() {
        if (typeof elementorFrontend !== 'undefined') {
            elementorFrontend.hooks.addAction('frontend/element_ready/aiq-prompt-card-grid.default', function($scope) {
                initPromptCards();
                setupInteractions();
                setupResponsive();
                setupAnimations();
            });
        }
    });

    /**
     * Initialize when document is ready (fallback)
     */
    $(document).ready(function() {
        initPromptCards();
        setupInteractions();
        setupResponsive();
        setupAnimations();
    });

})(jQuery);
