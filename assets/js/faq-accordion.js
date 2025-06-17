// assets/js/faq-accordion.js
(function() {
    'use strict';
    
    // Configuration constants
    const CONFIG = {
        animationDuration: 300,
        easing: 'cubic-bezier(0.4, 0, 0.2, 1)',
        selectors: {
            accordion: '.aiq-faq-accordion',
            item: '.aiq-faq-accordion__item',
            question: '.aiq-faq-accordion__question',
            answer: '.aiq-faq-accordion__answer',
            search: '.aiq-faq-accordion__search',
            noResults: '.aiq-faq-accordion__search-no-results'
        },
        classes: {
            active: 'is-active',
            hidden: 'is-hidden'
        }
    };
    
    document.addEventListener('DOMContentLoaded', function() {
        initFaqAccordions();
    });
    
    /**
     * Initialize all FAQ accordions on the page
     */
    function initFaqAccordions() {
        const accordions = document.querySelectorAll(CONFIG.selectors.accordion);
        
        if (!accordions.length) return;
        
        accordions.forEach(function(accordion) {
            setupAccordion(accordion);
            
            // Initialize search functionality if enabled
            const searchInput = accordion.querySelector(CONFIG.selectors.search);
            if (searchInput) {
                setupSearch(accordion, searchInput);
            }
        });
    }
    
    /**
     * Setup an individual accordion instance
     * @param {HTMLElement} accordion The accordion container element
     */
    function setupAccordion(accordion) {
        const questions = accordion.querySelectorAll(CONFIG.selectors.question);
        const defaultOpen = accordion.dataset.defaultOpen || 'first';
        
        // Initialize default states
        questions.forEach((question, index) => {
            const item = question.closest(CONFIG.selectors.item);
            const answer = item.querySelector(CONFIG.selectors.answer);
            
            // Set initial ARIA attributes
            question.setAttribute('aria-expanded', 'false');
            question.setAttribute('aria-controls', answer.id);
            answer.setAttribute('aria-labelledby', question.id);
            
            // Set initial state based on defaultOpen
            if (defaultOpen === 'all' || (defaultOpen === 'first' && index === 0)) {
                toggleItem(item, true);
            }
            
            // Add event listeners
            question.addEventListener('click', () => toggleItem(item));
            question.addEventListener('keydown', (e) => handleKeyboardNavigation(e, questions, index));
        });
    }
    
    /**
     * Setup search functionality for an accordion
     * @param {HTMLElement} accordion The accordion container
     * @param {HTMLElement} searchInput The search input element
     */
    function setupSearch(accordion, searchInput) {
        const items = accordion.querySelectorAll(CONFIG.selectors.item);
        const noResults = accordion.querySelector(CONFIG.selectors.noResults);
        
        // Debounce search input to improve performance
        const debouncedSearch = debounce(function() {
            const searchTerm = this.value.trim().toLowerCase();
            let hasResults = false;
            
            items.forEach(item => {
                const questionText = item.dataset.question.toLowerCase();
                const isMatch = questionText.includes(searchTerm);
                
                item.classList.toggle(CONFIG.classes.hidden, !isMatch);
                
                if (isMatch) hasResults = true;
            });
            
            // Show/hide no results message
            if (noResults) {
                noResults.style.display = hasResults || !searchTerm ? 'none' : 'block';
            }
        }, 300);
        
        searchInput.addEventListener('input', debouncedSearch);
    }
    
    /**
     * Toggle an accordion item's state
     * @param {HTMLElement} item The accordion item element
     * @param {boolean} [forceState] Optional state to force (true = open, false = close)
     */
    function toggleItem(item, forceState) {
        const question = item.querySelector(CONFIG.selectors.question);
        const answer = item.querySelector(CONFIG.selectors.answer);
        const isOpening = forceState !== undefined ? forceState : !item.classList.contains(CONFIG.classes.active);
        
        // Update ARIA attributes
        question.setAttribute('aria-expanded', isOpening.toString());
        
        // Handle animations based on prefers-reduced-motion
        const prefersReducedMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
        
        if (prefersReducedMotion) {
            // No animation for users who prefer reduced motion
            item.classList.toggle(CONFIG.classes.active, isOpening);
            answer.style.display = isOpening ? 'block' : 'none';
            return;
        }
        
        if (isOpening) {
            // Open the item
            item.classList.add(CONFIG.classes.active);
            animateOpen(answer);
        } else {
            // Close the item
            animateClose(answer, () => {
                item.classList.remove(CONFIG.classes.active);
            });
        }
    }
    
    /**
     * Animate opening an accordion answer
     * @param {HTMLElement} answer The answer element to animate
     */
    function animateOpen(answer) {
        // Store the current padding values
        const computedStyle = window.getComputedStyle(answer);
        const paddingTop = computedStyle.paddingTop;
        const paddingBottom = computedStyle.paddingBottom;
        
        // Set initial state
        answer.style.display = 'block';
        answer.style.height = '0';
        answer.style.overflow = 'hidden';
        answer.style.paddingTop = '0';
        answer.style.paddingBottom = '0';
        answer.style.transition = `
            height ${CONFIG.animationDuration}ms ${CONFIG.easing},
            padding-top ${CONFIG.animationDuration}ms ${CONFIG.easing},
            padding-bottom ${CONFIG.animationDuration}ms ${CONFIG.easing}
        `;
        
        // Force reflow
        answer.offsetHeight;
        
        // Animate to full height
        answer.style.height = `${answer.scrollHeight}px`;
        answer.style.paddingTop = paddingTop;
        answer.style.paddingBottom = paddingBottom;
        
        // Clean up after animation
        setTimeout(() => {
            answer.style.removeProperty('height');
            answer.style.removeProperty('overflow');
            answer.style.removeProperty('padding-top');
            answer.style.removeProperty('padding-bottom');
            answer.style.removeProperty('transition');
        }, CONFIG.animationDuration);
    }
    
    /**
     * Animate closing an accordion answer
     * @param {HTMLElement} answer The answer element to animate
     * @param {Function} callback Function to call after animation completes
     */
    function animateClose(answer, callback) {
        // Store the current height and padding values
        const height = answer.offsetHeight;
        const computedStyle = window.getComputedStyle(answer);
        const paddingTop = computedStyle.paddingTop;
        const paddingBottom = computedStyle.paddingBottom;
        
        // Set up transition
        answer.style.height = `${height}px`;
        answer.style.overflow = 'hidden';
        answer.style.transition = `
            height ${CONFIG.animationDuration}ms ${CONFIG.easing},
            padding-top ${CONFIG.animationDuration}ms ${CONFIG.easing},
            padding-bottom ${CONFIG.animationDuration}ms ${CONFIG.easing}
        `;
        
        // Force reflow
        answer.offsetHeight;
        
        // Animate to collapsed state
        answer.style.height = '0';
        answer.style.paddingTop = '0';
        answer.style.paddingBottom = '0';
        
        // Clean up after animation and execute callback
        setTimeout(() => {
            answer.style.display = 'none';
            answer.style.removeProperty('height');
            answer.style.removeProperty('overflow');
            answer.style.removeProperty('padding-top');
            answer.style.removeProperty('padding-bottom');
            answer.style.removeProperty('transition');
            
            if (typeof callback === 'function') {
                callback();
            }
        }, CONFIG.animationDuration);
    }
    
    /**
     * Handle keyboard navigation for accessibility
     * @param {KeyboardEvent} event The keyboard event
     * @param {NodeList} questions All question elements in the accordion
     * @param {number} currentIndex The index of the current question
     */
    function handleKeyboardNavigation(event, questions, currentIndex) {
        const key = event.key;
        const isArrowKey = key === 'ArrowDown' || key === 'ArrowUp';
        const isHomeOrEnd = key === 'Home' || key === 'End';
        
        if (!isArrowKey && !isHomeOrEnd) return;
        
        event.preventDefault();
        
        let targetIndex;
        const lastIndex = questions.length - 1;
        
        switch (key) {
            case 'ArrowDown':
                targetIndex = currentIndex < lastIndex ? currentIndex + 1 : 0;
                break;
            case 'ArrowUp':
                targetIndex = currentIndex > 0 ? currentIndex - 1 : lastIndex;
                break;
            case 'Home':
                targetIndex = 0;
                break;
            case 'End':
                targetIndex = lastIndex;
                break;
        }
        
        questions[targetIndex].focus();
        
        // Optionally open the item when navigating with keyboard
        if (isArrowKey && event.ctrlKey) {
            const item = questions[targetIndex].closest(CONFIG.selectors.item);
            toggleItem(item, true);
        }
    }
    
    /**
     * Debounce function to limit how often a function is called
     * @param {Function} func The function to debounce
     * @param {number} wait The debounce delay in milliseconds
     * @return {Function} The debounced function
     */
    function debounce(func, wait) {
        let timeout;
        return function() {
            const context = this;
            const args = arguments;
            clearTimeout(timeout);
            timeout = setTimeout(() => {
                func.apply(context, args);
            }, wait);
        };
    }
})();
