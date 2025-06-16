/**
 * AIQEngage Theme Testing Script
 * Used to validate theme functionality in staging environment
 */

(function() {
    'use strict';

    // Configuration
    const config = {
        selectors: {
            valueProps: '.value-proposition-grid .feature-card',
            promptCards: '.prompt-card',
            metricBadges: '.metric-badge',
            blueprintFlows: '.blueprint-flow',
            comparisonMatrices: '.comparison-matrix',
            testimonialCards: '.testimonial-card'
        },
        testMode: window.location.href.indexOf('test-mode=1') > -1,
        logStyles: 'background: #2A1958; color: #E0D6FF; padding: 2px 5px; border-radius: 3px;'
    };

    // Test results tracking
    const testResults = {
        passed: 0,
        failed: 0,
        warnings: 0
    };

    /**
     * Initialize tests when DOM is ready
     */
    function initTests() {
        if (!config.testMode) {
            console.info('%c AIQEngage Test Mode', config.logStyles, 'Add ?test-mode=1 to URL to run tests');
            return;
        }

        console.info('%c AIQEngage Theme Tests', config.logStyles, 'Starting tests...');
        
        // Run all tests
        testValuePropositions();
        testPromptCards();
        testMetricBadges();
        testBlueprintFlows();
        testComparisonMatrices();
        testTestimonialCards();
        
        // Report results
        reportTestResults();
    }

    /**
     * Test Value Proposition Widgets
     */
    function testValuePropositions() {
        const elements = document.querySelectorAll(config.selectors.valueProps);
        
        if (elements.length === 0) {
            logWarning('No Value Proposition widgets found to test');
            return;
        }
        
        console.group('%c Testing Value Proposition Widgets', config.logStyles);
        console.log(`Found ${elements.length} value proposition cards`);
        
        // Check if cards have titles
        const missingTitles = Array.from(elements).filter(el => !el.querySelector('h3'));
        if (missingTitles.length > 0) {
            logFailure(`${missingTitles.length} cards missing titles`);
        } else {
            logSuccess('All cards have titles');
        }
        
        // Check if cards have descriptions
        const missingDescriptions = Array.from(elements).filter(el => !el.querySelector('p'));
        if (missingDescriptions.length > 0) {
            logFailure(`${missingDescriptions.length} cards missing descriptions`);
        } else {
            logSuccess('All cards have descriptions');
        }
        
        console.groupEnd();
    }

    /**
     * Test Prompt Card Widgets
     */
    function testPromptCards() {
        const elements = document.querySelectorAll(config.selectors.promptCards);
        
        if (elements.length === 0) {
            logWarning('No Prompt Card widgets found to test');
            return;
        }
        
        console.group('%c Testing Prompt Card Widgets', config.logStyles);
        console.log(`Found ${elements.length} prompt cards`);
        
        // Test copy functionality
        testCopyFunctionality(elements);
        
        // Test toggle functionality
        Array.from(elements).forEach((card, index) => {
            const toggleBtn = card.querySelector('.toggle-button:not(.results-toggle)');
            const content = card.querySelector('.prompt-content');
            
            if (toggleBtn && content) {
                try {
                    const initialState = content.classList.contains('collapsed');
                    toggleBtn.click();
                    const newState = content.classList.contains('collapsed');
                    
                    if (initialState !== newState) {
                        logSuccess(`Toggle functionality working for card #${index + 1}`);
                    } else {
                        logFailure(`Toggle not working for card #${index + 1}`);
                    }
                    
                    // Restore initial state
                    if (initialState !== content.classList.contains('collapsed')) {
                        toggleBtn.click();
                    }
                } catch (err) {
                    logFailure(`Error testing toggle for card #${index + 1}: ${err.message}`);
                }
            }
        });
        
        console.groupEnd();
    }

    /**
     * Test copy functionality
     */
    function testCopyFunctionality(elements) {
        // Mock clipboard API if needed for testing
        if (!navigator.clipboard) {
            navigator.clipboard = {
                writeText: text => {
                    console.log('Clipboard write mocked:', text.substring(0, 30) + '...');
                    return Promise.resolve();
                }
            };
        }
        
        // Test copy buttons
        let copyButtonsWorking = true;
        
        Array.from(elements).forEach((card, index) => {
            const copyBtn = card.querySelector('.copy-button');
            
            if (copyBtn) {
                try {
                    // Temporarily override clipboard.writeText
                    const originalWriteText = navigator.clipboard.writeText;
                    let wasCalled = false;
                    
                    navigator.clipboard.writeText = text => {
                        wasCalled = true;
                        return Promise.resolve();
                    };
                    
                    // Trigger copy
                    copyBtn.click();
                    
                    // Check if clipboard was called
                    if (wasCalled) {
                        logSuccess(`Copy button working for card #${index + 1}`);
                    } else {
                        logFailure(`Copy button not triggered for card #${index + 1}`);
                        copyButtonsWorking = false;
                    }
                    
                    // Restore original
                    navigator.clipboard.writeText = originalWriteText;
                } catch (err) {
                    logFailure(`Error testing copy for card #${index + 1}: ${err.message}`);
                    copyButtonsWorking = false;
                }
            }
        });
        
        return copyButtonsWorking;
    }

    /**
     * Test Metric Badge Widgets
     */
    function testMetricBadges() {
        const elements = document.querySelectorAll(config.selectors.metricBadges);
        
        if (elements.length === 0) {
            logWarning('No Metric Badge widgets found to test');
            return;
        }
        
        console.group('%c Testing Metric Badge Widgets', config.logStyles);
        console.log(`Found ${elements.length} metric badges`);
        
        // Check for basic structure
        Array.from(elements).forEach((badge, index) => {
            const hasValue = !!badge.querySelector('.metric-value');
            const hasLabel = !!badge.querySelector('.metric-label');
            
            if (hasValue && hasLabel) {
                logSuccess(`Badge #${index + 1} has correct structure`);
            } else {
                logFailure(`Badge #${index + 1} missing ${!hasValue ? 'value' : 'label'}`);
            }
        });
        
        console.groupEnd();
    }

    /**
     * Test Blueprint Flow Widgets
     */
    function testBlueprintFlows() {
        const elements = document.querySelectorAll(config.selectors.blueprintFlows);
        
        if (elements.length === 0) {
            logWarning('No Blueprint Flow widgets found to test');
            return;
        }
        
        console.group('%c Testing Blueprint Flow Widgets', config.logStyles);
        console.log(`Found ${elements.length} blueprint flows`);
        
        // These will be implemented when Blueprint Flow widget is added
        logWarning('Blueprint Flow test implementation pending');
        
        console.groupEnd();
    }

    /**
     * Test Comparison Matrix Widgets
     */
    function testComparisonMatrices() {
        const elements = document.querySelectorAll(config.selectors.comparisonMatrices);
        
        if (elements.length === 0) {
            logWarning('No Comparison Matrix widgets found to test');
            return;
        }
        
        console.group('%c Testing Comparison Matrix Widgets', config.logStyles);
        console.log(`Found ${elements.length} comparison matrices`);
        
        // These will be implemented when Comparison Matrix widget is added
        logWarning('Comparison Matrix test implementation pending');
        
        console.groupEnd();
    }

    /**
     * Test Testimonial Card Widgets
     */
    function testTestimonialCards() {
        const elements = document.querySelectorAll(config.selectors.testimonialCards);
        
        if (elements.length === 0) {
            logWarning('No Testimonial Card widgets found to test');
            return;
        }
        
        console.group('%c Testing Testimonial Card Widgets', config.logStyles);
        console.log(`Found ${elements.length} testimonial cards`);
        
        // These will be implemented when Testimonial Card widget is added
        logWarning('Testimonial Card test implementation pending');
        
        console.groupEnd();
    }

    /**
     * Log success message and increment counter
     */
    function logSuccess(message) {
        console.log('%c ✓ SUCCESS', 'color: #4CAF50', message);
        testResults.passed++;
    }

    /**
     * Log failure message and increment counter
     */
    function logFailure(message) {
        console.error('%c ✗ FAILURE', 'color: #F44336', message);
        testResults.failed++;
    }

    /**
     * Log warning message and increment counter
     */
    function logWarning(message) {
        console.warn('%c ⚠ WARNING', 'color: #FFC107', message);
        testResults.warnings++;
    }

    /**
     * Report final test results
     */
    function reportTestResults() {
        console.group('%c AIQEngage Theme Test Results', config.logStyles);
        console.log(`Passed: ${testResults.passed}`);
        console.log(`Failed: ${testResults.failed}`);
        console.log(`Warnings: ${testResults.warnings}`);
        
        if (testResults.failed === 0) {
            console.log('%c All tests passed!', 'color: #4CAF50; font-weight: bold;');
        } else {
            console.log('%c Some tests failed', 'color: #F44336; font-weight: bold;');
        }
        
        console.groupEnd();
        
        // Create visual indicator on the page
        const testIndicator = document.createElement('div');
        testIndicator.style.cssText = `
            position: fixed;
            bottom: 20px;
            right: 20px;
            padding: 10px 15px;
            background: ${testResults.failed === 0 ? '#4CAF50' : '#F44336'};
            color: white;
            border-radius: 5px;
            font-family: sans-serif;
            font-size: 14px;
            z-index: 9999;
            box-shadow: 0 2px 10px rgba(0,0,0,0.2);
        `;
        testIndicator.innerHTML = `
            Tests: ${testResults.passed + testResults.failed + testResults.warnings}<br>
            Passed: ${testResults.passed} | Failed: ${testResults.failed} | Warnings: ${testResults.warnings}
        `;
        document.body.appendChild(testIndicator);
    }

    // Initialize when DOM is ready
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', initTests);
    } else {
        initTests();
    }
})();
