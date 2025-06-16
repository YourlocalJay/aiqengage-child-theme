/**
 * AIQEngage Custom Scripts
 * Handles all frontend interactions for widgets
 * 
 * @package AIQEngage-Child
 */

(function($) {
    'use strict';

    // Store initialized widgets to prevent double initialization
    const initializedWidgets = {
        valueProp: new Set(),
        promptCard: new Set(),
        metricBadge: new Set(),
        blueprintFlow: new Set(),
        comparisonMatrix: new Set()
    };

    /**
     * Widget Manager Object
     * 
     * Handles initialization of all AIQEngage widgets
     */
    const AIQWidgets = {
        /**
         * Initialize all widgets
         */
        init: function() {
            // Initialize all widgets when not in Elementor editor
            if (typeof aiqengage_ajax === 'undefined' || !aiqengage_ajax.is_elementor) {
                this.initValuePropWidgets();
                this.initPromptCards();
                this.initMetricBadges();
                this.initBlueprintFlows();
                this.initComparisonMatrices();
            }
            
            // Listen for Elementor frontend init event (for preview mode)
            $(window).on('elementor/frontend/init', function() {
                if (typeof elementorFrontend !== 'undefined') {
                    elementorFrontend.hooks.addAction('frontend/element_ready/aiqengage-value-prop.default', AIQWidgets.initValuePropWidget);
                    elementorFrontend.hooks.addAction('frontend/element_ready/aiqengage-prompt-card.default', AIQWidgets.initPromptCardWidget);
                    elementorFrontend.hooks.addAction('frontend/element_ready/aiqengage-metric-badge.default', AIQWidgets.initMetricBadgeWidget);
                    elementorFrontend.hooks.addAction('frontend/element_ready/aiqengage-blueprint-flow.default', AIQWidgets.initBlueprintFlowWidget);
                    elementorFrontend.hooks.addAction('frontend/element_ready/aiqengage-comparison-matrix.default', AIQWidgets.initComparisonMatrixWidget);
                }
            });
        },

        /**
         * Initialize all Value Proposition widgets on the page
         */
        initValuePropWidgets: function() {
            $('.value-proposition').each(function() {
                AIQWidgets.initValuePropWidget($(this));
            });
        },
        
        /**
         * Initialize a single Value Proposition widget
         * 
         * @param {jQuery} $element The widget element
         */
        initValuePropWidget: function($element) {
            const widgetId = $element.data('widget-id');
            
            // Skip if already initialized
            if (initializedWidgets.valueProp.has(widgetId)) {
                return;
            }
            
            // Add to initialized set
            initializedWidgets.valueProp.add(widgetId);
            
            // Check if animations are enabled
            const hasAnimation = $element.data('animation') === true;
            
            if (hasAnimation) {
                $element.find('.feature-card.elementor-invisible').each(function() {
                    const $card = $(this);
                    const observer = new IntersectionObserver((entries) => {
                        entries.forEach(entry => {
                            if (entry.isIntersecting) {
                                $card.removeClass('elementor-invisible').addClass('animate');
                                observer.unobserve(entry.target);
                            }
                        });
                    }, { threshold: 0.1 });
                    
                    observer.observe(this);
                });
            }
        },

        /**
         * Initialize all Prompt Card widgets on the page
         */
        initPromptCards: function() {
            $('.prompt-card').each(function() {
                AIQWidgets.initPromptCardWidget($(this));
            });
        },
        
        /**
         * Initialize a single Prompt Card widget
         * 
         * @param {jQuery} $element The widget element
         */
        initPromptCardWidget: function($element) {
            const promptId = $element.data('prompt-id');
            
            // Skip if already initialized
            if (initializedWidgets.promptCard.has(promptId)) {
                return;
            }
            
            // Add to initialized set
            initializedWidgets.promptCard.add(promptId);
            
            // Toggle button functionality
            $element.find('.toggle-button').on('click', function() {
                if ($(this).hasClass('results-toggle')) {
                    const $results = $(this).next('.results-preview');
                    $results.toggleClass('hidden');
                    $(this).text($results.hasClass('hidden') ? 
                        aiqengage_ajax.i18n.see_results : 
                        aiqengage_ajax.i18n.hide_results);
                } else {
                    const $content = $(this).prev('.prompt-content');
                    $content.toggleClass('collapsed');
                    $(this).text($content.hasClass('collapsed') ? 
                        aiqengage_ajax.i18n.show_prompt : 
                        aiqengage_ajax.i18n.hide_prompt);
                }
            });
            
            // Copy button functionality
            $element.find('.copy-button').on('click', function() {
                const promptText = $element.find('.prompt-content').text();
                
                if (navigator.clipboard) {
                    navigator.clipboard.writeText(promptText).then(() => {
                        const $button = $(this);
                        $button.addClass('copied');
                        setTimeout(() => {
                            $button.removeClass('copied');
                        }, 2000);
                    }).catch(() => {
                        fallbackCopy(promptText, $(this));
                    });
                } else {
                    fallbackCopy(promptText, $(this));
                }
            });
            
            // Fallback copy function for older browsers
            function fallbackCopy(text, $button) {
                const $temp = $('<textarea>');
                $('body').append($temp);
                $temp.val(text).select();
                document.execCommand('copy');
                $temp.remove();
                
                $button.addClass('copied');
                setTimeout(() => {
                    $button.removeClass('copied');
                }, 2000);
            }
        },

        /**
         * Initialize all Metric Badge widgets on the page
         */
        initMetricBadges: function() {
            $('.metric-badge').each(function() {
                AIQWidgets.initMetricBadgeWidget($(this));
            });
        },
        
        /**
         * Initialize a single Metric Badge widget
         * 
         * @param {jQuery} $element The widget element
         */
        initMetricBadgeWidget: function($element) {
            const widgetId = $element.closest('.elementor-element').data('id');
            
            // Skip if already initialized
            if (initializedWidgets.metricBadge.has(widgetId)) {
                return;
            }
            
            // Add to initialized set
            initializedWidgets.metricBadge.add(widgetId);
            
            // Animate counter
            const $counterValue = $element.find('.counter-value');
            
            if ($counterValue.length > 0) {
                const finalValue = parseInt($counterValue.data('value'));
                
                const observer = new IntersectionObserver((entries) => {
                    entries.forEach(entry => {
                        if (entry.isIntersecting) {
                            // Animate counter when visible
                            $({ countNum: 0 }).animate(
                                { countNum: finalValue },
                                {
                                    duration: 1500,
                                    easing: 'swing',
                                    step: function() {
                                        $counterValue.text(Math.floor(this.countNum));
                                    },
                                    complete: function() {
                                        $counterValue.text(finalValue);
                                    }
                                }
                            );
                            
                            observer.unobserve(entry.target);
                        }
                    });
                }, { threshold: 0.1 });
                
                observer.observe($counterValue[0]);
            }
        },
        
        /**
         * Initialize all Blueprint Flow widgets on the page
         */
        initBlueprintFlows: function() {
            $('.blueprint-flow-container').each(function() {
                AIQWidgets.initBlueprintFlowWidget($(this));
            });
        },
        
        /**
         * Initialize a single Blueprint Flow widget
         * 
         * @param {jQuery} $element The widget element
         */
        initBlueprintFlowWidget: function($element) {
            const widgetId = $element.closest('.elementor-element').data('id');
            
            // Skip if already initialized
            if (initializedWidgets.blueprintFlow.has(widgetId)) {
                return;
            }
            
            // Add to initialized set
            initializedWidgets.blueprintFlow.add(widgetId);
            
            // Initialize ROI calculator if present
            const $calculator = $element.find('.roi-calculator');
            
            if ($calculator.length > 0) {
                const $trafficInput = $calculator.find('input[id^="traffic-input-"]');
                const $conversionInput = $calculator.find('input[id^="conversion-input-"]');
                const $revenueInput = $calculator.find('input[id^="revenue-input-"]');
                const $customersResult = $calculator.find('[id^="customers-result-"]');
                const $revenueResult = $calculator.find('[id^="revenue-result-"]');
                const $annualResult = $calculator.find('[id^="annual-result-"]');
                
                function calculateROI() {
                    const traffic = parseFloat($trafficInput.val()) || 0;
                    const conversionRate = parseFloat($conversionInput.val()) || 0;
                    const revenue = parseFloat($revenueInput.val()) || 0;
                    
                    const customers = Math.round(traffic * (conversionRate / 100));
                    const monthlyRevenue = customers * revenue;
                    const annualRevenue = monthlyRevenue * 12;
                    
                    $customersResult.text(customers);
                    $revenueResult.text('$' + monthlyRevenue.toLocaleString('en-US', {maximumFractionDigits: 2}));
                    $annualResult.text('$' + annualRevenue.toLocaleString('en-US', {maximumFractionDigits: 2}));
                }
                
                // Calculate initial values
                calculateROI();
                
                // Recalculate on input change
                $trafficInput.on('input', calculateROI);
                $conversionInput.on('input', calculateROI);
                $revenueInput.on('input', calculateROI);
            }
            
            // Make nodes interactive
            $element.find('.interactive-node').on('click', function() {
                $element.find('.interactive-node').removeClass('active');
                $(this).addClass('active');
            });
        },
        
        /**
         * Initialize all Comparison Matrix widgets on the page
         */
        initComparisonMatrices: function() {
            $('.comparison-matrix-container').each(function() {
                AIQWidgets.initComparisonMatrixWidget($(this));
            });
        },
        
        /**
         * Initialize a single Comparison Matrix widget
         * 
         * @param {jQuery} $element The widget element
         */
        initComparisonMatrixWidget: function($element) {
            const widgetId = $element.closest('.elementor-element').data('id');
            
            // Skip if already initialized
            if (initializedWidgets.comparisonMatrix.has(widgetId)) {
                return;
            }
            
            // Add to initialized set
            initializedWidgets.comparisonMatrix.add(widgetId);
            
            // Tab switching functionality
            $element.find('.category-tab').on('click', function() {
                const category = $(this).data('category');
                
                // Update tab states
                $element.find('.category-tab').removeClass('active').attr('aria-selected', 'false');
                $(this).addClass('active').attr('aria-selected', 'true');
                
                // Update panel visibility
                $element.find('.matrix-panel').removeClass('active');
                $element.find('.matrix-panel[data-category="' + category + '"]').addClass('active');
            });
            
            // Highlight rows on hover
            $element.find('.comparison-matrix-table tr').on('mouseenter', function() {
                $(this).addClass('hover');
            }).on('mouseleave', function() {
                $(this).removeClass('hover');
            });
        }
    };

    // Initialize when DOM is ready
    $(document).ready(function() {
        AIQWidgets.init();
    });

})(jQuery);
