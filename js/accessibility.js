/**
 * AIQEngage Accessibility Enhancements
 * Improves website accessibility for all users
 */

(function($) {
    'use strict';
    
    // Accessibility Manager
    const AccessibilityManager = {
        // Initialize accessibility enhancements
        init: function() {
            // Apply accessibility improvements
            this.improveKeyboardNavigation();
            this.enhanceFocusStyles();
            this.addSkipToContentLink();
            this.improveARIAAttributes();
            this.respectedReducedMotion();
            this.addScreenReaderAnnouncements();
            this.improveFormAccessibility();
            this.setupHighContrastMode();
            
            // Listen for preference changes
            this.listenForPreferenceChanges();
        },
        
        // Improve keyboard navigation
        improveKeyboardNavigation: function() {
            // Add class to body when using keyboard navigation
            document.addEventListener('keydown', function(e) {
                if (e.key === 'Tab') {
                    document.body.classList.add('using-keyboard-nav');
                }
            });
            
            // Remove class when using mouse
            document.addEventListener('mousedown', function() {
                document.body.classList.remove('using-keyboard-nav');
            });
            
            // Add focus trap for modals
            $('.modal, .elementor-popup-modal').each(function() {
                const $modal = $(this);
                const $focusableElements = $modal.find('button, [href], input, select, textarea, [tabindex]:not([tabindex="-1"])');
                const $firstFocusableElement = $focusableElements.first();
                const $lastFocusableElement = $focusableElements.last();
                
                $modal.on('keydown', function(e) {
                    if (e.key === 'Tab') {
                        // If shift+tab on first element, focus last element
                        if (e.shiftKey && document.activeElement === $firstFocusableElement[0]) {
                            e.preventDefault();
                            $lastFocusableElement.focus();
                        } 
                        // If tab on last element, focus first element
                        else if (!e.shiftKey && document.activeElement === $lastFocusableElement[0]) {
                            e.preventDefault();
                            $firstFocusableElement.focus();
                        }
                    }
                    
                    // Close modal on escape
                    if (e.key === 'Escape') {
                        $modal.find('.close, .elementor-popup-modal__close').trigger('click');
                    }
                });
                
                // Focus first element when modal opens
                $modal.on('shown.bs.modal', function() {
                    $firstFocusableElement.focus();
                });
            });
            
            // Make dropdown menus keyboard accessible
            $('.menu-item-has-children > a, .sub-menu-toggle').on('keydown', function(e) {
                if (e.key === 'Enter' || e.key === ' ') {
                    e.preventDefault();
                    $(this).closest('.menu-item-has-children').toggleClass('focus');
                }
            });
            
            // Close dropdown menus when focus moves away
            $('.menu-item-has-children').on('focusout', function(e) {
                if (!$(this).has(e.relatedTarget).length) {
                    $(this).removeClass('focus');
                }
            });
        },
        
        // Enhance focus styles for better visibility
        enhanceFocusStyles: function() {
            // Add styles for keyboard focus
            const style = document.createElement('style');
            style.textContent = `
                .using-keyboard-nav :focus {
                    outline: 3px solid #9C4DFF !important;
                    outline-offset: 2px !important;
                    text-decoration: none !important;
                }
                
                .using-keyboard-nav button:focus,
                .using-keyboard-nav .btn:focus,
                .using-keyboard-nav .elementor-button:focus {
                    box-shadow: 0 0 0 3px rgba(156, 77, 255, 0.5) !important;
                }
                
                /* Hide focus styles when using mouse */
                button:focus:not(:focus-visible),
                .btn:focus:not(:focus-visible),
                .elementor-button:focus:not(:focus-visible) {
                    outline: none !important;
                    box-shadow: none !important;
                }
                
                /* Additional styles for high contrast mode */
                .high-contrast-mode :focus {
                    outline: 3px solid #FFFF00 !important;
                }
            `;
            document.head.appendChild(style);
        },
        
        // Add skip to content link for keyboard users
        addSkipToContentLink: function() {
            const skipLink = document.createElement('a');
            skipLink.className = 'skip-to-content-link';
            skipLink.href = '#main-content';
            skipLink.textContent = 'Skip to content';
            
            // Add styling
            skipLink.style.cssText = `
                position: absolute;
                top: -50px;
                left: 0;
                padding: 10px 15px;
                background-color: #2A1958;
                color: #E0D6FF;
                border: 2px solid #9C4DFF;
                border-radius: 0 0 5px 0;
                z-index: 10000;
                text-decoration: none;
                transition: top 0.3s ease;
            `;
            
            // Show on focus
            skipLink.addEventListener('focus', function() {
                this.style.top = '0';
            });
            
            // Hide when focus is lost
            skipLink.addEventListener('blur', function() {
                this.style.top = '-50px';
            });
            
            // Add to DOM
            document.body.insertBefore(skipLink, document.body.firstChild);
            
            // Add ID to main content area if not present
            if (!document.getElementById('main-content')) {
                const mainContent = document.querySelector('main, .site-main, .elementor-location-single, .elementor-location-archive, article');
                
                if (mainContent) {
                    mainContent.id = 'main-content';
                    
                    // Add tabindex to make it focusable
                    mainContent.setAttribute('tabindex', '-1');
                    
                    // Remove outline when focused via skip link
                    mainContent.style.outline = 'none';
                }
            }
        },
        
        // Improve ARIA attributes for better screen reader experience
        improveARIAAttributes: function() {
            // Add missing labels to form fields
            $('input, select, textarea').each(function() {
                const $input = $(this);
                
                // Skip inputs with existing labels or aria-labels
                if ($input.attr('aria-label') || $('label[for="' + $input.attr('id') + '"]').length) {
                    return;
                }
                
                // Get placeholder as fallback
                const placeholder = $input.attr('placeholder');
                
                if (placeholder) {
                    $input.attr('aria-label', placeholder);
                }
            });
            
            // Add ARIA roles to landmarks
            $('header, nav').attr('role', 'navigation');
            $('main, [role="main"]').attr('role', 'main');
            $('footer').attr('role', 'contentinfo');
            $('aside, .sidebar').attr('role', 'complementary');
            $('section').attr('role', 'region');
            
            // Add ARIA expanded to toggles
            $('.menu-toggle, .sub-menu-toggle, .elementor-toggle-icon').attr('aria-expanded', 'false');
            
            // Update ARIA expanded on toggle
            $('.menu-toggle, .sub-menu-toggle, .elementor-toggle-icon').on('click', function() {
                const isExpanded = $(this).attr('aria-expanded') === 'true';
                $(this).attr('aria-expanded', (!isExpanded).toString());
            });
            
            // Add ARIA live regions for dynamic content
            $('.elementor-alert, .elementor-message').attr('aria-live', 'polite');
            
            // Add missing alt text to images
            $('img:not([alt])').attr('alt', '');
            
            // Add ARIA labels to buttons without text
            $('button:not(:has(text())), a.elementor-button:not(:has(text()))').each(function() {
                const $button = $(this);
                
                // Skip buttons with existing aria-label
                if ($button.attr('aria-label')) {
                    return;
                }
                
                // Use title attribute as fallback
                const title = $button.attr('title');
                
                if (title) {
                    $button.attr('aria-label', title);
                } else {
                    // Try to determine purpose from classes or content
                    if ($button.hasClass('close') || $button.find('.close').length) {
                        $button.attr('aria-label', 'Close');
                    } else if ($button.hasClass('search') || $button.find('.search').length) {
                        $button.attr('aria-label', 'Search');
                    } else if ($button.hasClass('menu-toggle') || $button.find('.menu-toggle').length) {
                        $button.attr('aria-label', 'Toggle menu');
                    }
                }
            });
        },
        
        // Respect reduced motion preferences
        respectedReducedMotion: function() {
            // Add class to body based on preference
            if (window.matchMedia('(prefers-reduced-motion: reduce)').matches) {
                document.body.classList.add('reduced-motion');
            }
            
            // Add CSS to handle animations based on preference
            const style = document.createElement('style');
            style.textContent = `
                @media (prefers-reduced-motion: reduce) {
                    * {
                        animation-duration: 0.001ms !important;
                        transition-duration: 0.001ms !important;
                        scroll-behavior: auto !important;
                    }
                }
                
                .reduced-motion * {
                    animation-duration: 0.001ms !important;
                    transition-duration: 0.001ms !important;
                    scroll-behavior: auto !important;
                }
            `;
            document.head.appendChild(style);
        },
        
        // Add screen reader announcements for dynamic content
        addScreenReaderAnnouncements: function() {
            // Create live region for announcements
            const announcer = document.createElement('div');
            announcer.className = 'sr-announcer';
            announcer.setAttribute('aria-live', 'polite');
            announcer.setAttribute('aria-atomic', 'true');
            announcer.style.cssText = `
                position: absolute;
                width: 1px;
                height: 1px;
                padding: 0;
                margin: -1px;
                overflow: hidden;
                clip: rect(0, 0, 0, 0);
                white-space: nowrap;
                border: 0;
            `;
            
            document.body.appendChild(announcer);
            
            // Expose announcer API
            window.AIQEngage = window.AIQEngage || {};
            window.AIQEngage.Accessibility = window.AIQEngage.Accessibility || {};
            window.AIQEngage.Accessibility.announce = function(message, priority = 'polite') {
                announcer.setAttribute('aria-live', priority);
                
                // Clear previous announcement
                announcer.textContent = '';
                
                // Set new announcement after a short delay
                setTimeout(function() {
                    announcer.textContent = message;
                }, 100);
            };
            
            // Hook into form submissions to announce results
            $('form').on('submit', function() {
                $(this).find('.form-notice, .elementor-message').on('DOMNodeInserted', function() {
                    window.AIQEngage.Accessibility.announce($(this).text());
                });
            });
        },
        
        // Improve form accessibility
        improveFormAccessibility: function() {
            // Add required attribute and aria-required for required fields
            $('input[required], select[required], textarea[required]').attr('aria-required', 'true');
            
            // Add validation messages
            $('form').on('submit', function(e) {
                const $form = $(this);
                const $requiredFields = $form.find('[required], [aria-required="true"]');
                
                $requiredFields.each(function() {
                    const $field = $(this);
                    
                    // Remove previous error messages
                    $field.next('.field-error').remove();
                    
                    // Check if field is empty
                    if (!$field.val()) {
                        e.preventDefault();
                        
                        // Add error message
                        const errorMessage = document.createElement('div');
                        errorMessage.className = 'field-error';
                        errorMessage.textContent = 'This field is required';
                        errorMessage.style.cssText = `
                            color: #F44336;
                            font-size: 0.875rem;
                            margin-top: 5px;
                        `;
                        
                        // Set aria-invalid
                        $field.attr('aria-invalid', 'true');
                        
                        // Add error message after field
                        $field.after(errorMessage);
                        
                        // Announce error to screen readers
                        if (window.AIQEngage.Accessibility.announce) {
                            window.AIQEngage.Accessibility.announce('Form has errors. Please check your inputs.');
                        }
                    } else {
                        // Reset aria-invalid
                        $field.attr('aria-invalid', 'false');
                    }
                });
            });
            
            // Add better focus handling for form fields
            $('input, select, textarea').on('focus', function() {
                $(this).closest('.elementor-field-group, .form-group').addClass('is-focused');
            }).on('blur', function() {
                $(this).closest('.elementor-field-group, .form-group').removeClass('is-focused');
            });
        },
        
        // Setup high contrast mode
        setupHighContrastMode: function() {
            // Add toggle button
            const contrastToggle = document.createElement('button');
            contrastToggle.className = 'contrast-toggle';
            contrastToggle.innerHTML = `
                <span class="contrast-icon">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M12 2C6.48 2 2 6.48 2 12C2 17.52 6.48 22 12 22C17.52 22 22 17.52 22 12C22 6.48 17.52 2 12 2ZM12 20C7.58 20 4 16.42 4 12C4 7.58 7.58 4 12 4V20Z" fill="currentColor"/>
                    </svg>
                </span>
                High Contrast
            `;
            
            contrastToggle.style.cssText = `
                position: fixed;
                bottom: 20px;
                left: 20px;
                background: #2A1958;
                color: #E0D6FF;
                border: 1px solid #9C4DFF;
                border-radius: 4px;
                padding: 8px 12px;
                font-size: 14px;
                font-family: 'Inter', sans-serif;
                cursor: pointer;
                display: flex;
                align-items: center;
                gap: 8px;
                z-index: 999;
            `;
            
            // Check for saved preference
            const highContrastEnabled = localStorage.getItem('aiqengage_high_contrast') === 'true';
            
            if (highContrastEnabled) {
                document.body.classList.add('high-contrast-mode');
            }
            
            // Toggle high contrast mode
            contrastToggle.addEventListener('click', function() {
                const isEnabled = document.body.classList.toggle('high-contrast-mode');
                localStorage.setItem('aiqengage_high_contrast', isEnabled.toString());
                
                // Announce change to screen readers
                if (window.AIQEngage.Accessibility.announce) {
                    window.AIQEngage.Accessibility.announce(
                        isEnabled ? 'High contrast mode enabled' : 'High contrast mode disabled'
                    );
                }
            });
            
            // Add high contrast styles
            const highContrastStyles = document.createElement('style');
            highContrastStyles.textContent = `
                .high-contrast-mode {
                    --primary-bg: #000000;
                    --secondary-bg: #222222;
                    --primary-text: #FFFFFF;
                    --secondary-text: #FFFFFF;
                    --accent: #FFFF00;
                }
                
                .high-contrast-mode body,
                .high-contrast-mode .elementor-element {
                    background-color: var(--primary-bg) !important;
                    color: var(--primary-text) !important;
                }
                
                .high-contrast-mode .feature-card,
                .high-contrast-mode .prompt-card,
                .high-contrast-mode .metric-badge,
                .high-contrast-mode .elementor-widget-container {
                    background-color: var(--secondary-bg) !important;
                    border: 1px solid var(--accent) !important;
                }
                
                .high-contrast-mode h1, 
                .high-contrast-mode h2, 
                .high-contrast-mode h3, 
                .high-contrast-mode h4, 
                .high-contrast-mode h5, 
                .high-contrast-mode h6 {
                    color: var(--primary-text) !important;
                }
                
                .high-contrast-mode a,
                .high-contrast-mode .card-link,
                .high-contrast-mode .elementor-button-text {
                    color: var(--accent) !important;
                    text-decoration: underline !important;
                }
                
                .high-contrast-mode .btn-primary,
                .high-contrast-mode .elementor-button {
                    background: var(--secondary-bg) !important;
                    color: var(--accent) !important;
                    border: 2px solid var(--accent) !important;
                }
                
                .high-contrast-mode img {
                    filter: grayscale(100%) contrast(120%);
                }
            `;
            document.head.appendChild(highContrastStyles);
            
            // Add toggle to the page
            document.body.appendChild(contrastToggle);
        },
        
        // Listen for preference changes
        listenForPreferenceChanges: function() {
            // Listen for prefers-reduced-motion changes
            const motionMediaQuery = window.matchMedia('(prefers-reduced-motion: reduce)');
            
            motionMediaQuery.addEventListener('change', () => {
                if (motionMediaQuery.matches) {
                    document.body.classList.add('reduced-motion');
                } else {
                    document.body.classList.remove('reduced-motion');
                }
            });
            
            // Listen for prefers-color-scheme changes (for additional customization)
            const darkModeMediaQuery = window.matchMedia('(prefers-color-scheme: dark)');
            
            darkModeMediaQuery.addEventListener('change', () => {
                // Site is already dark themed, but we can add additional customizations if needed
                if (darkModeMediaQuery.matches) {
                    // Additional dark mode customizations could go here
                }
            });
        }
    };
    
    // Initialize accessibility enhancements when document is ready
    $(document).ready(function() {
        AccessibilityManager.init();
    });
    
})(jQuery);
