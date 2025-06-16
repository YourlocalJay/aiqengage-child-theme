/**
 * AIQEngage Custom Scripts
 * Handles all frontend interactions for the AIQEngage child theme
 * 
 * @package AIQEngage-Child
 */

(function($) {
    'use strict';
    
    /**
     * User profile tracking and personalization system
     */
    const UserProfile = {
        /**
         * Initialize user profile
         */
        init: function() {
            if (!localStorage.getItem('aiq_user_profile')) {
                localStorage.setItem('aiq_user_profile', JSON.stringify({
                    id: this.generateUUID(),
                    firstVisit: new Date().toISOString(),
                    lastVisit: new Date().toISOString(),
                    preferences: {},
                    interests: {},
                    skillLevel: 1,
                    pageViews: [],
                    interactions: {
                        promptCopies: 0,
                        toolClicks: 0,
                        blueprintViews: 0
                    }
                }));
            } else {
                // Update last visit
                const profile = JSON.parse(localStorage.getItem('aiq_user_profile'));
                profile.lastVisit = new Date().toISOString();
                localStorage.setItem('aiq_user_profile', JSON.stringify(profile));
            }
            
            // Track page view
            this.trackPageView(
                $('body').data('page-type') || 'page',
                $('body').data('page-id') || window.location.pathname
            );
            
            // Set up interaction tracking
            this.setupInteractionTracking();
        },
        
        /**
         * Generate a random UUID for user identification
         */
        generateUUID: function() {
            return 'xxxxxxxx-xxxx-4xxx-yxxx-xxxxxxxxxxxx'.replace(/[xy]/g, function(c) {
                const r = Math.random() * 16 | 0;
                const v = c === 'x' ? r : (r & 0x3 | 0x8);
                return v.toString(16);
            });
        },
        
        /**
         * Track page view
         */
        trackPageView: function(pageType, pageId) {
            const profile = JSON.parse(localStorage.getItem('aiq_user_profile'));
            
            profile.pageViews.push({
                timestamp: new Date().toISOString(),
                pageType: pageType,
                pageId: pageId
            });
            
            // Keep only last 20 page views
            if (profile.pageViews.length > 20) {
                profile.pageViews = profile.pageViews.slice(-20);
            }
            
            localStorage.setItem('aiq_user_profile', JSON.stringify(profile));
            
            // Track in Google Analytics if available
            if (typeof gtag !== 'undefined') {
                gtag('event', 'page_view', {
                    page_type: pageType,
                    page_id: pageId
                });
            }
        },
        
        /**
         * Track user interaction
         */
        trackInteraction: function(type, itemId, metadata = {}) {
            const profile = JSON.parse(localStorage.getItem('aiq_user_profile'));
            
            // Increment interaction counters
            if (profile.interactions[type] !== undefined) {
                profile.interactions[type]++;
            }
            
            // Update interests based on interaction
            if (metadata.category) {
                if (!profile.interests[metadata.category]) {
                    profile.interests[metadata.category] = 0;
                }
                profile.interests[metadata.category] += metadata.weight || 1;
            }
            
            localStorage.setItem('aiq_user_profile', JSON.stringify(profile));
            
            // Track in Google Analytics if available
            if (typeof gtag !== 'undefined') {
                gtag('event', type, {
                    item_id: itemId,
                    category: metadata.category || '',
                    weight: metadata.weight || 1
                });
            }
        },
        
        /**
         * Set up click tracking on interactive elements
         */
        setupInteractionTracking: function() {
            const self = this;
            
            // Track elements with data-track-click attribute
            $('[data-track-click]').on('click', function() {
                const $this = $(this);
                const type = $this.data('track-type') || 'click';
                const itemId = $this.data('track-id') || '';
                const category = $this.data('track-category') || '';
                const weight = parseInt($this.data('track-weight') || '1');
                
                self.trackInteraction(type, itemId, {
                    category: category,
                    weight: weight
                });
            });
            
            // Track prompt copies
            $('.copy-button').on('click', function() {
                const $card = $(this).closest('.prompt-card');
                const promptId = $card.data('prompt-id') || '';
                const category = $card.data('category') || '';
                
                self.trackInteraction('promptCopies', promptId, {
                    category: category,
                    weight: 2
                });
            });
            
            // Track tool clicks
            $('.tool-link').on('click', function() {
                const toolId = $(this).data('tool-id') || '';
                const category = $(this).data('category') || '';
                
                self.trackInteraction('toolClicks', toolId, {
                    category: category,
                    weight: 3
                });
            });
            
            // Track blueprint views using Intersection Observer
            if ('IntersectionObserver' in window) {
                const blueprintObserver = new IntersectionObserver((entries) => {
                    entries.forEach(entry => {
                        if (entry.isIntersecting && entry.intersectionRatio >= 0.5) {
                            const $blueprint = $(entry.target);
                            const blueprintId = $blueprint.data('blueprint-id') || '';
                            const category = $blueprint.data('category') || '';
                            
                            self.trackInteraction('blueprintViews', blueprintId, {
                                category: category,
                                weight: 2
                            });
                            
                            blueprintObserver.unobserve(entry.target);
                        }
                    });
                }, { threshold: 0.5 });
                
                $('.blueprint-flow').each(function() {
                    blueprintObserver.observe(this);
                });
            }
        }
    };
    
    /**
     * A/B Testing framework
     */
    const ABTesting = {
        /**
         * Initialize A/B tests
         */
        init: function() {
            // Find test elements
            $('[data-ab-test]').each((index, element) => {
                const $testContainer = $(element);
                const testId = $testContainer.data('ab-test');
                const variant = this.determineVariant(testId);
                
                // Show appropriate variant
                $testContainer.find('[data-variant]').each((i, variantElement) => {
                    const $variantElement = $(variantElement);
                    if ($variantElement.data('variant') === variant) {
                        $variantElement.show();
                        this.trackImpression(testId);
                        
                        // Track conversions for clickable elements
                        $variantElement.find('[data-conversion]').on('click', function() {
                            ABTesting.trackConversion(testId, $(this).data('conversion'));
                        });
                    } else {
                        $variantElement.hide();
                    }
                });
            });
        },
        
        /**
         * Determine which variant to show to user
         */
        determineVariant: function(testId) {
            const profile = JSON.parse(localStorage.getItem('aiq_user_profile'));
            const userId = profile.id;
            
            // Use hash of user ID to create stable assignment
            const hash = this.hashString(userId + testId);
            const cohort = hash % 100;
            
            // Initialize test data if needed
            const testData = JSON.parse(localStorage.getItem('aiq_ab_tests') || '{}');
            if (!testData[testId]) {
                let variantId;
                
                // Distribute users across variants
                if (cohort < 25) {
                    variantId = 'control'; // 25% control group
                } else if (cohort < 50) {
                    variantId = 'variant_a'; // 25% variant A
                } else if (cohort < 75) {
                    variantId = 'variant_b'; // 25% variant B
                } else {
                    variantId = 'variant_c'; // 25% variant C
                }
                
                testData[testId] = {
                    variant: variantId,
                    impressions: 0,
                    conversions: {}
                };
                
                localStorage.setItem('aiq_ab_tests', JSON.stringify(testData));
            }
            
            return testData[testId].variant;
        },
        
        /**
         * Track impression for a test
         */
        trackImpression: function(testId) {
            const testData = JSON.parse(localStorage.getItem('aiq_ab_tests') || '{}');
            
            if (testData[testId]) {
                testData[testId].impressions++;
                localStorage.setItem('aiq_ab_tests', JSON.stringify(testData));
                
                // Track in Google Analytics if available
                if (typeof gtag !== 'undefined') {
                    gtag('event', 'ab_test_impression', {
                        test_id: testId,
                        variant: testData[testId].variant
                    });
                }
            }
        },
        
        /**
         * Track conversion for a test
         */
        trackConversion: function(testId, conversionType) {
            const testData = JSON.parse(localStorage.getItem('aiq_ab_tests') || '{}');
            
            if (testData[testId]) {
                if (!testData[testId].conversions[conversionType]) {
                    testData[testId].conversions[conversionType] = 0;
                }
                
                testData[testId].conversions[conversionType]++;
                localStorage.setItem('aiq_ab_tests', JSON.stringify(testData));
                
                // Track in Google Analytics if available
                if (typeof gtag !== 'undefined') {
                    gtag('event', 'ab_test_conversion', {
                        test_id: testId,
                        variant: testData[testId].variant,
                        conversion_type: conversionType
                    });
                }
            }
        },
        
        /**
         * Simple string hash function
         */
        hashString: function(str) {
            let hash = 0;
            for (let i = 0; i < str.length; i++) {
                const char = str.charCodeAt(i);
                hash = ((hash << 5) - hash) + char;
                hash = hash & hash; // Convert to 32bit integer
            }
            return Math.abs(hash);
        }
    };
    
    /**
     * UI Components and interactions
     */
    const UIComponents = {
        /**
         * Initialize UI components
         */
        init: function() {
            this.initStickyCTA();
            this.initScrollAnimations();
            this.initPromptCards();
            this.initLeadForm();
            this.initAccessibility();
        },
        
        /**
         * Initialize sticky CTA bar
         */
        initStickyCTA: function() {
            const $stickyCta = $('.sticky-cta');
            if (!$stickyCta.length) return;

            const scrollTrigger = window.innerHeight * 0.45;
            
            $(window).on('scroll', function() {
                if ($(this).scrollTop() > scrollTrigger) {
                    $stickyCta.addClass('visible');
                } else {
                    $stickyCta.removeClass('visible');
                }
            });
            
            // Check initial scroll position
            if ($(window).scrollTop() > scrollTrigger) {
                $stickyCta.addClass('visible');
            }
        },
        
        /**
         * Initialize scroll-based animations
         */
        initScrollAnimations: function() {
            // Only proceed if not reduced motion
            if (window.matchMedia('(prefers-reduced-motion: reduce)').matches) {
                return;
            }
            
            const $animatedElements = $('.feature-card, .testimonial-card, .value-prop-card');
            if (!$animatedElements.length) return;
            
            if ('IntersectionObserver' in window) {
                const observer = new IntersectionObserver((entries) => {
                    entries.forEach(entry => {
                        if (entry.isIntersecting) {
                            $(entry.target).addClass('animate');
                            observer.unobserve(entry.target);
                        }
                    });
                }, { threshold: 0.1 });
                
                $animatedElements.each(function() {
                    observer.observe(this);
                });
            } else {
                // Fallback for browsers without IntersectionObserver
                $animatedElements.addClass('animate');
            }
            
            // Add neural background to sections with .add-neural-bg class
            $('.add-neural-bg').each(function() {
                if (!$(this).find('.neural-pattern').length) {
                    const $neuralBg = $('<div class="neural-pattern"></div>');
                    $(this).append($neuralBg);
                }
            });
        },
        
        /**
         * Initialize prompt card functionality
         */
        initPromptCards: function() {
            // Copy button functionality
            $('.prompt-card .copy-button').on('click', function() {
                const $card = $(this).closest('.prompt-card');
                const promptText = $card.find('.prompt-content').text();
                
                // Use modern clipboard API with fallback
                if (navigator.clipboard) {
                    navigator.clipboard.writeText(promptText).then(() => {
                        const $button = $(this);
                        $button.addClass('copied');
                        setTimeout(() => {
                            $button.removeClass('copied');
                        }, 2000);
                    });
                } else {
                    // Fallback method
                    const $temp = $('<textarea>');
                    $('body').append($temp);
                    $temp.val(promptText).select();
                    document.execCommand('copy');
                    $temp.remove();
                    
                    const $button = $(this);
                    $button.addClass('copied');
                    setTimeout(() => {
                        $button.removeClass('copied');
                    }, 2000);
                }
            });
            
            // Expand/collapse toggle
            $('.prompt-card .toggle-button').on('click', function() {
                const $content = $(this).prev('.prompt-content');
                $content.toggleClass('collapsed');
                $(this).text($content.hasClass('collapsed') ? 'Show Prompt' : 'Hide Prompt');
            });
        },
        
        /**
         * Initialize lead form functionality
         */
        initLeadForm: function() {
            const $leadForm = $('.lead-form form');
            if (!$leadForm.length) return;
            
            $leadForm.on('submit', function(e) {
                e.preventDefault();
                
                const $form = $(this);
                const $emailInput = $form.find('input[type="email"]');
                const email = $emailInput.val().trim();
                const $formGroup = $form.find('.form-group');
                
                // Reset previous states
                $formGroup.find('.error-message, .success-message').remove();
                
                if (UIComponents.validateEmail(email)) {
                    // Disable form during submission
                    $form.addClass('submitting');
                    $emailInput.prop('disabled', true);
                    $form.find('button[type="submit"]').prop('disabled', true);
                    
                    // Submit via AJAX
                    UIComponents.submitFormData(email, $form);
                } else {
                    UIComponents.showFormError($formGroup, aiqengage_ajax.i18n.invalid_email);
                }
            });
        },
        
        /**
         * Email validation helper
         */
        validateEmail: function(email) {
            const re = /^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
            return re.test(String(email).toLowerCase());
        },
        
        /**
         * Form submission handler
         */
        submitFormData: function(email, $form) {
            $.ajax({
                url: aiqengage_ajax.ajaxurl,
                type: 'POST',
                data: {
                    action: 'aiqengage_subscribe',
                    email: email,
                    security: aiqengage_ajax.nonce
                },
                success: function(response) {
                    if (response.success) {
                        UIComponents.showFormSuccess($form.find('.form-group'), response.data.message);
                        
                        // Track conversion
                        if (typeof gtag !== 'undefined') {
                            gtag('event', 'conversion', {
                                'send_to': 'AW-123456789/AbCd-EFGhIJK1234567890'
                            });
                        }
                        
                        // Also track in user profile
                        UserProfile.trackInteraction('form_submit', 'lead_form', {
                            category: 'lead_generation',
                            weight: 5
                        });
                        
                        // Redirect if needed
                        if (response.data.redirect) {
                            setTimeout(() => {
                                window.location.href = response.data.redirect;
                            }, 1500);
                        }
                    } else {
                        UIComponents.showFormError($form.find('.form-group'), response.data.message);
                        UIComponents.enableForm($form);
                    }
                },
                error: function(xhr) {
                    const message = xhr.responseJSON && xhr.responseJSON.data && xhr.responseJSON.data.message 
                        ? xhr.responseJSON.data.message 
                        : aiqengage_ajax.i18n.network_error;
                    UIComponents.showFormError($form.find('.form-group'), message);
                    UIComponents.enableForm($form);
                }
            });
        },
        
        /**
         * UI feedback functions
         */
        showFormSuccess: function($formGroup, message) {
            $formGroup.append(`<div class="success-message">${message}</div>`);
        },
        
        showFormError: function($formGroup, message) {
            $formGroup.append(`<div class="error-message">${message}</div>`);
        },
        
        enableForm: function($form) {
            $form.removeClass('submitting');
            $form.find('input, button').prop('disabled', false);
        },
        
        /**
         * Initialize accessibility features
         */
        initAccessibility: function() {
            // Add keyboard user detection
            $(document).on('keydown', function(e) {
                if (e.key === 'Tab') {
                    $('body').addClass('keyboard-user');
                }
            });
            
            $(document).on('mousedown', function() {
                $('body').removeClass('keyboard-user');
            });
            
            // Check for reduced motion preference
            if (window.matchMedia('(prefers-reduced-motion: reduce)').matches) {
                $('body').addClass('reduced-motion');
            }
        }
    };
    
    /**
     * Performance monitoring
     */
    const PerformanceMonitor = {
        /**
         * Initialize performance monitoring
         */
        init: function() {
            // Only run if not in Elementor editor
            if (typeof aiqengage_ajax !== 'undefined' && aiqengage_ajax.is_elementor) {
                return;
            }
            
            // Track Core Web Vitals
            this.trackWebVitals();
            
            // Track custom metrics
            this.trackCustomMetrics();
        },
        
        /**
         * Track Core Web Vitals
         */
        trackWebVitals: function() {
            if (!('PerformanceObserver' in window)) return;
            
            // LCP (Largest Contentful Paint)
            try {
                const lcpObserver = new PerformanceObserver((entryList) => {
                    const entries = entryList.getEntries();
                    const lastEntry = entries[entries.length - 1];
                    
                    // Report LCP
                    this.reportWebVital('LCP', lastEntry.startTime);
                });
                
                lcpObserver.observe({ type: 'largest-contentful-paint', buffered: true });
            } catch (e) {
                console.error('LCP observation error:', e);
            }
            
            // FID (First Input Delay)
            try {
                const fidObserver = new PerformanceObserver((entryList) => {
                    const entries = entryList.getEntries();
                    entries.forEach(entry => {
                        this.reportWebVital('FID', entry.processingStart - entry.startTime);
                    });
                });
                
                fidObserver.observe({ type: 'first-input', buffered: true });
            } catch (e) {
                console.error('FID observation error:', e);
            }
            
            // CLS (Cumulative Layout Shift)
            try {
                let cumulativeLayoutShift = 0;
                
                const clsObserver = new PerformanceObserver((entryList) => {
                    for (const entry of entryList.getEntries()) {
                        // Only count layout shifts without recent user input
                        if (!entry.hadRecentInput) {
                            cumulativeLayoutShift += entry.value;
                        }
                    }
                    
                    this.reportWebVital('CLS', cumulativeLayoutShift);
                });
                
                clsObserver.observe({ type: 'layout-shift', buffered: true });
            } catch (e) {
                console.error('CLS observation error:', e);
            }
        },
        
        /**
         * Report web vitals to analytics
         */
        reportWebVital: function(metric, value) {
            // Log to console in development
            if (location.hostname === 'localhost' || location.hostname === '127.0.0.1') {
                console.log(`Web Vital: ${metric} = ${value}`);
            }
            
            // Send to Google Analytics if available
            if (typeof gtag !== 'undefined') {
                gtag('event', 'web_vitals', {
                    event_category: 'Web Vitals',
                    event_label: metric,
                    value: Math.round(metric === 'CLS' ? value * 1000 : value),
                    non_interaction: true
                });
            }
        },
        
        /**
         * Track custom performance metrics
         */
        trackCustomMetrics: function() {
            // Time to interactive custom metric
            setTimeout(() => {
                const navigationTiming = performance.getEntriesByType('navigation')[0];
                if (navigationTiming) {
                    const timeToInteractive = navigationTiming.domInteractive;
                    this.reportWebVital('TTI', timeToInteractive);
                }
            }, 0);
        }
    };
    
    /**
     * Personalization System
     */
    const PersonalizationSystem = {
        /**
         * Initialize personalization
         */
        init: function() {
            this.applyPersonalization();
        },
        
        /**
         * Apply personalization based on user profile
         */
        applyPersonalization: function() {
            const profile = JSON.parse(localStorage.getItem('aiq_user_profile') || '{}');
            
            // Get top interests
            const interests = Object.entries(profile.interests || {})
                .sort((a, b) => b[1] - a[1])
                .slice(0, 2)
                .map(entry => entry[0]);
                
            // Determine skill level
            const skillLevel = profile.interactions && profile.interactions.promptCopies > 10 ? 'advanced' : 
                             profile.interactions && profile.interactions.promptCopies > 5 ? 'intermediate' : 'beginner';
            
            // Apply personalization to elements with data-personalize attribute
            $('[data-personalize]').each((index, element) => {
                const $element = $(element);
                const personalizationType = $element.data('personalize');
                
                if (personalizationType === 'skill-level') {
                    // Hide all skill-level variants
                    $element.find('[data-skill]').hide();
                    
                    // Show matching skill level
                    const $skillItem = $element.find(`[data-skill="${skillLevel}"]`);
                    if ($skillItem.length) {
                        $skillItem.show();
                    } else {
                        // Show default if no match
                        $element.find('[data-skill="beginner"]').show();
                    }
                }
                
                if (personalizationType === 'interest-based') {
                    // Hide all interest variants
                    $element.find('[data-interest]').hide();
                    
                    // Show matching interests or default
                    let matchFound = false;
                    
                    interests.forEach(interest => {
                        const $interestItem = $element.find(`[data-interest="${interest}"]`);
                        if ($interestItem.length) {
                            $interestItem.show();
                            matchFound = true;
                        }
                    });
                    
                    // If no match found, show default
                    if (!matchFound) {
                        $element.find('[data-interest="default"]').show();
                    }
                }
                
                // Add personalization for CTA text
                if (personalizationType === 'cta-text') {
                    const visitCount = profile.pageViews ? profile.pageViews.length : 0;
                    
                    if (visitCount > 5) {
                        $element.find('[data-visit="returning"]').show();
                        $element.find('[data-visit="new"]').hide();
                    } else {
                        $element.find('[data-visit="new"]').show();
                        $element.find('[data-visit="returning"]').hide();
                    }
                }
            });
        }
    };
    
    /**
     * Master initialization function
     */
    function init() {
        // Skip initialization in Elementor editor
        if (typeof aiqengage_ajax !== 'undefined' && aiqengage_ajax.is_elementor) {
            return;
        }
        
        // Initialize all modules
        UserProfile.init();
        ABTesting.init();
        UIComponents.init();
        PerformanceMonitor.init();
        PersonalizationSystem.init();
        
        // Log initialization in development
        if (location.hostname === 'localhost' || location.hostname === '127.0.0.1') {
            console.log('AIQEngage theme initialized');
        }
    }
    
    // Initialize when DOM is ready
    $(document).ready(init);
    
})(jQuery);