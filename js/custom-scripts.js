/**
 * AIQEngage Custom Scripts
 * Handles all frontend interactions for widgets
 */

jQuery(document).ready(function($) {
    // Initialize all widgets when not in Elementor editor
    if (typeof aiqengage_ajax === 'undefined' || !aiqengage_ajax.is_elementor) {
        initValuePropWidgets();
        initPromptCards();
        initMetricBadges();
    }

    // Value Proposition Widget animations
    function initValuePropWidgets() {
        $('.value-proposition-grid .feature-card.elementor-invisible').each(function() {
            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        $(entry.target).removeClass('elementor-invisible').addClass('animate');
                        observer.unobserve(entry.target);
                    }
                });
            }, { threshold: 0.1 });
            
            observer.observe(this);
        });
    }

    // Prompt Card functionality
    function initPromptCards() {
        // Toggle prompt content
        $('.prompt-card .toggle-button').on('click', function() {
            const $content = $(this).prev('.prompt-content');
            $content.toggleClass('collapsed');
            $(this).text($content.hasClass('collapsed') ? 
                aiqengage_ajax.i18n.show_prompt : 
                aiqengage_ajax.i18n.hide_prompt);
        });

        // Toggle results
        $('.prompt-card .results-toggle').on('click', function() {
            const $results = $(this).next('.results-preview');
            $results.toggleClass('hidden');
            $(this).text($results.hasClass('hidden') ? 
                aiqengage_ajax.i18n.see_results : 
                aiqengage_ajax.i18n.hide_results);
        });

        // Copy prompt functionality
        $('.prompt-card .copy-button').on('click', function() {
            const promptText = $(this).closest('.prompt-card').find('.prompt-content').text();
            
            navigator.clipboard.writeText(promptText).then(() => {
                const $button = $(this);
                $button.addClass('copied');
                setTimeout(() => $button.removeClass('copied'), 2000);
            }).catch(() => {
                // Fallback for older browsers
                const $temp = $('<textarea>');
                $('body').append($temp);
                $temp.val(promptText).select();
                document.execCommand('copy');
                $temp.remove();
                
                const $button = $(this);
                $button.addClass('copied');
                setTimeout(() => $button.removeClass('copied'), 2000);
            });
        });
    }

    // Metric Badge animations
    function initMetricBadges() {
        $('.metric-badge .counter-value').each(function() {
            const $counter = $(this);
            const finalValue = parseInt($counter.data('value'));
            
            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        $({ countNum: 0 }).animate(
                            { countNum: finalValue },
                            {
                                duration: 1500,
                                easing: 'swing',
                                step: function() {
                                    $counter.text(Math.floor(this.countNum));
                                },
                                complete: function() {
                                    $counter.text(finalValue);
                                }
                            }
                        );
                        observer.unobserve(entry.target);
                    }
                });
            }, { threshold: 0.1 });
            
            observer.observe(this);
        });
    }
});
