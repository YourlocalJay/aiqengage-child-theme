/**
 * AIQEngage A/B Testing Framework
 * Handles A/B testing for optimizing user experience and conversion rates
 */

(function($) {
    'use strict';
    
    // A/B Testing Manager
    const ABTestManager = {
        // Storage key for tests
        storageKey: 'aiqengage_ab_tests',
        
        // Default test configuration
        defaultTests: {
            'cta_button_color': {
                variants: ['primary', 'secondary', 'gradient'],
                weights: [0.34, 0.33, 0.33],
                active: true
            },
            'hero_layout': {
                variants: ['image-left', 'image-right', 'image-background'],
                weights: [0.4, 0.4, 0.2],
                active: true
            },
            'pricing_display': {
                variants: ['monthly-first', 'annual-first', 'comparison'],
                weights: [0.33, 0.33, 0.34],
                active: false // Not active by default
            }
        },
        
        // Test results storage
        results: {},
        
        // Initialize A/B testing framework
        init: function() {
            // Load or initialize tests configuration
            this.loadTests();
            
            // Check if user is already part of a test
            if (!this.hasAssignedVariants()) {
                this.assignVariants();
            }
            
            // Apply test variants to page
            this.applyTestVariants();
            
            // Set up tracking
            this.setupTracking();
            
            // Debug info if in development/staging environment
            if (this.isTestEnvironment()) {
                this.showDebugInfo();
            }
        },
        
        // Load tests from localStorage or use defaults
        loadTests: function() {
            let storedTests = localStorage.getItem(this.storageKey);
            
            if (storedTests) {
                try {
                    this.tests = JSON.parse(storedTests);
                    
                    // Merge with default tests in case new tests were added
                    for (const testName in this.defaultTests) {
                        if (!this.tests[testName]) {
                            this.tests[testName] = this.defaultTests[testName];
                        }
                    }
                } catch (e) {
                    console.error('Error parsing A/B tests:', e);
                    this.tests = {...this.defaultTests};
                }
            } else {
                this.tests = {...this.defaultTests};
            }
            
            // Load results
            let storedResults = localStorage.getItem(this.storageKey + '_results');
            if (storedResults) {
                try {
                    this.results = JSON.parse(storedResults);
                } catch (e) {
                    console.error('Error parsing A/B test results:', e);
                    this.results = {};
                }
            }
        },
        
        // Save tests to localStorage
        saveTests: function() {
            localStorage.setItem(this.storageKey, JSON.stringify(this.tests));
        },
        
        // Save test results to localStorage
        saveResults: function() {
            localStorage.setItem(this.storageKey + '_results', JSON.stringify(this.results));
        },
        
        // Check if user has already been assigned variants
        hasAssignedVariants: function() {
            for (const testName in this.tests) {
                if (this.tests[testName].assignedVariant !== undefined) {
                    return true;
                }
            }
            
            return false;
        },
        
        // Assign variants to user
        assignVariants: function() {
            for (const testName in this.tests) {
                const test = this.tests[testName];
                
                if (test.active) {
                    // Weighted random selection
                    const randomVal = Math.random();
                    let cumulativeWeight = 0;
                    
                    for (let i = 0; i < test.variants.length; i++) {
                        cumulativeWeight += test.weights[i];
                        
                        if (randomVal <= cumulativeWeight) {
                            test.assignedVariant = test.variants[i];
                            break;
                        }
                    }
                    
                    // Initialize results tracking
                    if (!this.results[testName]) {
                        this.results[testName] = {
                            impressions: {},
                            conversions: {}
                        };
                        
                        test.variants.forEach(variant => {
                            this.results[testName].impressions[variant] = 0;
                            this.results[testName].conversions[variant] = 0;
                        });
                    }
                }
            }
            
            this.saveTests();
        },
        
        // Apply test variants to the page
        applyTestVariants: function() {
            for (const testName in this.tests) {
                const test = this.tests[testName];
                
                if (test.active && test.assignedVariant) {
                    // Add variant as body class for CSS targeting
                    document.body.classList.add(`ab-${testName}-${test.assignedVariant}`);
                    
                    // Track impression
                    this.trackImpression(testName, test.assignedVariant);
                    
                    // Apply specific test variants
                    switch (testName) {
                        case 'cta_button_color':
                            this.applyCTAButtonVariant(test.assignedVariant);
                            break;
                        case 'hero_layout':
                            this.applyHeroLayoutVariant(test.assignedVariant);
                            break;
                        case 'pricing_display':
                            this.applyPricingDisplayVariant(test.assignedVariant);
                            break;
                    }
                }
            }
        },
        
        // Apply CTA button color variant
        applyCTAButtonVariant: function(variant) {
            const primaryButtons = document.querySelectorAll('.btn-primary, .elementor-button-link');
            
            switch (variant) {
                case 'primary':
                    // Default primary style - no changes needed
                    break;
                case 'secondary':
                    primaryButtons.forEach(button => {
                        button.style.background = 'transparent';
                        button.style.border = '1px solid #9C4DFF';
                        button.style.color = '#E0D6FF';
                    });
                    break;
                case 'gradient':
                    primaryButtons.forEach(button => {
                        button.style.background = 'linear-gradient(135deg, #9C4DFF 0%, #5E72E4 100%)';
                    });
                    break;
            }
        },
        
        // Apply hero layout variant
        applyHeroLayoutVariant: function(variant) {
            const heroSection = document.querySelector('.hero-section');
            
            if (!heroSection) return;
            
            switch (variant) {
                case 'image-left':
                    heroSection.classList.add('image-left');
                    heroSection.classList.remove('image-right', 'image-background');
                    break;
                case 'image-right':
                    heroSection.classList.add('image-right');
                    heroSection.classList.remove('image-left', 'image-background');
                    break;
                case 'image-background':
                    heroSection.classList.add('image-background');
                    heroSection.classList.remove('image-left', 'image-right');
                    break;
            }
        },
        
        // Apply pricing display variant
        applyPricingDisplayVariant: function(variant) {
            const pricingSection = document.querySelector('.pricing-section');
            
            if (!pricingSection) return;
            
            switch (variant) {
                case 'monthly-first':
                    pricingSection.classList.add('monthly-first');
                    pricingSection.classList.remove('annual-first', 'comparison');
                    break;
                case 'annual-first':
                    pricingSection.classList.add('annual-first');
                    pricingSection.classList.remove('monthly-first', 'comparison');
                    break;
                case 'comparison':
                    pricingSection.classList.add('comparison');
                    pricingSection.classList.remove('monthly-first', 'annual-first');
                    break;
            }
        },
        
        // Setup conversion tracking
        setupTracking: function() {
            // Track CTA button clicks
            document.querySelectorAll('.btn-primary, .elementor-button-link').forEach(button => {
                button.addEventListener('click', () => {
                    this.trackConversion('cta_button_color', 'click');
                });
            });
            
            // Track form submissions
            document.querySelectorAll('form').forEach(form => {
                form.addEventListener('submit', () => {
                    this.trackConversion('hero_layout', 'form_submit');
                });
            });
            
            // Track pricing selection
            document.querySelectorAll('.pricing-option').forEach(option => {
                option.addEventListener('click', () => {
                    this.trackConversion('pricing_display', 'selection');
                });
            });
        },
        
        // Track impression
        trackImpression: function(testName, variant) {
            if (this.results[testName] && this.results[testName].impressions[variant] !== undefined) {
                this.results[testName].impressions[variant]++;
                this.saveResults();
            }
        },
        
        // Track conversion
        trackConversion: function(testName, conversionType) {
            const test = this.tests[testName];
            
            if (test && test.active && test.assignedVariant) {
                if (!this.results[testName].conversions[conversionType]) {
                    this.results[testName].conversions[conversionType] = {};
                    
                    test.variants.forEach(variant => {
                        this.results[testName].conversions[conversionType][variant] = 0;
                    });
                }
                
                if (this.results[testName].conversions[conversionType][test.assignedVariant] !== undefined) {
                    this.results[testName].conversions[conversionType][test.assignedVariant]++;
                    this.saveResults();
                    
                    // Send to analytics if available
                    if (typeof gtag !== 'undefined') {
                        gtag('event', 'ab_conversion', {
                            'test_name': testName,
                            'variant': test.assignedVariant,
                            'conversion_type': conversionType
                        });
                    }
                }
            }
        },
        
        // Check if in test environment
        isTestEnvironment: function() {
            return (
                window.location.hostname.indexOf('staging') !== -1 ||
                window.location.hostname.indexOf('test') !== -1 ||
                window.location.search.indexOf('debug=true') !== -1
            );
        },
        
        // Show debug information
        showDebugInfo: function() {
            // Create debug panel
            const debugPanel = document.createElement('div');
            debugPanel.className = 'ab-debug-panel';
            debugPanel.style.cssText = `
                position: fixed;
                bottom: 10px;
                right: 10px;
                background: rgba(42, 25, 88, 0.9);
                border: 1px solid #9C4DFF;
                border-radius: 8px;
                padding: 15px;
                font-family: monospace;
                font-size: 12px;
                color: #E0D6FF;
                z-index: 10000;
                max-width: 300px;
                max-height: 400px;
                overflow-y: auto;
            `;
            
            let debugContent = '<h3>A/B Test Debug</h3>';
            
            for (const testName in this.tests) {
                const test = this.tests[testName];
                
                if (test.active) {
                    debugContent += `<div><strong>${testName}</strong>: ${test.assignedVariant}</div>`;
                    
                    if (this.results[testName]) {
                        debugContent += `<div>Impressions: ${this.results[testName].impressions[test.assignedVariant]}</div>`;
                        
                        for (const convType in this.results[testName].conversions) {
                            if (typeof this.results[testName].conversions[convType] === 'object') {
                                debugContent += `<div>${convType}: ${this.results[testName].conversions[convType][test.assignedVariant]}</div>`;
                            }
                        }
                    }
                    
                    debugContent += '<hr>';
                }
            }
            
            // Add controls
            debugContent += '<div class="ab-controls">';
            debugContent += '<button id="ab-reset-tests">Reset Tests</button>';
            debugContent += '<button id="ab-hide-debug">Hide</button>';
            debugContent += '</div>';
            
            debugPanel.innerHTML = debugContent;
            document.body.appendChild(debugPanel);
            
            // Add styles for debug panel
            const debugStyle = document.createElement('style');
            debugStyle.innerHTML = `
                .ab-debug-panel hr {
                    border: 0;
                    border-top: 1px solid rgba(156, 77, 255, 0.3);
                    margin: 10px 0;
                }
                .ab-debug-panel button {
                    background: #9C4DFF;
                    border: none;
                    color: white;
                    padding: 5px 10px;
                    border-radius: 4px;
                    margin-right: 5px;
                    cursor: pointer;
                }
                .ab-debug-panel button:hover {
                    background: #8E6BFF;
                }
                .ab-controls {
                    margin-top: 10px;
                }
            `;
            document.head.appendChild(debugStyle);
            
            // Add event listeners
            document.getElementById('ab-reset-tests').addEventListener('click', () => {
                localStorage.removeItem(this.storageKey);
                localStorage.removeItem(this.storageKey + '_results');
                location.reload();
            });
            
            document.getElementById('ab-hide-debug').addEventListener('click', () => {
                debugPanel.style.display = 'none';
            });
        },
        
        // Get test statistics
        getTestStatistics: function(testName) {
            const stats = {
                variants: {},
                winner: null,
                confidence: 0
            };
            
            if (!this.results[testName]) {
                return stats;
            }
            
            const test = this.tests[testName];
            
            // Calculate conversion rate for each variant
            test.variants.forEach(variant => {
                const impressions = this.results[testName].impressions[variant] || 0;
                let conversions = 0;
                
                // Sum all conversion types
                for (const convType in this.results[testName].conversions) {
                    if (typeof this.results[testName].conversions[convType] === 'object') {
                        conversions += this.results[testName].conversions[convType][variant] || 0;
                    }
                }
                
                stats.variants[variant] = {
                    impressions,
                    conversions,
                    rate: impressions > 0 ? (conversions / impressions) : 0
                };
            });
            
            // Find variant with highest conversion rate
            let highestRate = 0;
            for (const variant in stats.variants) {
                if (stats.variants[variant].rate > highestRate) {
                    highestRate = stats.variants[variant].rate;
                    stats.winner = variant;
                }
            }
            
            // Calculate statistical significance
            if (stats.winner && test.variants.length > 1) {
                // Simple z-test for proportion
                const winnerStats = stats.variants[stats.winner];
                const controlVariant = test.variants[0];
                const controlStats = stats.variants[controlVariant];
                
                if (controlStats.impressions > 0 && winnerStats.impressions > 0) {
                    const p1 = controlStats.conversions / controlStats.impressions;
                    const p2 = winnerStats.conversions / winnerStats.impressions;
                    const n1 = controlStats.impressions;
                    const n2 = winnerStats.impressions;
                    
                    if (p1 > 0 && p2 > 0) {
                        const se = Math.sqrt((p1 * (1 - p1) / n1) + (p2 * (1 - p2) / n2));
                        const z = (p2 - p1) / se;
                        
                        // Convert z-score to confidence
                        stats.confidence = this.zScoreToConfidence(z);
                    }
                }
            }
            
            return stats;
        },
        
        // Convert z-score to confidence percentage
        zScoreToConfidence: function(z) {
            // Approximation for confidence level
            const zAbs = Math.abs(z);
            
            if (zAbs < 1.65) {
                return Math.round((0.5 + 0.5 * zAbs / 1.65) * 100);
            } else if (zAbs < 1.96) {
                return 90;
            } else if (zAbs < 2.58) {
                return 95;
            } else {
                return 99;
            }
        }
    };
    
    // Initialize A/B testing when document is ready
    $(document).ready(function() {
        // Only run tests if not in admin area
        if (!$('body').hasClass('wp-admin')) {
            ABTestManager.init();
        }
    });
    
    // Expose API for manual tracking and analysis
    window.AIQEngage = window.AIQEngage || {};
    window.AIQEngage.ABTesting = {
        trackConversion: function(testName, conversionType) {
            ABTestManager.trackConversion(testName, conversionType);
        },
        getTestStatistics: function(testName) {
            return ABTestManager.getTestStatistics(testName);
        },
        getAllTestResults: function() {
            return ABTestManager.results;
        }
    };
    
})(jQuery);
