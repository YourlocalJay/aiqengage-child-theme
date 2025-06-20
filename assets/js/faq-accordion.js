/**
 * FAQ Accordion Widget Script
 *
 * @package aiqengage-child
 * @version 1.0.0
 * @since   1.0.0
 * @author  Jason
 */

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

        // Set up accordion container ARIA attributes
        accordion.setAttribute('role', 'presentation');

        // Initialize default states
        questions.forEach((question, index) => {
            const item = question.closest(CONFIG.selectors.item);
            const answer = item.querySelector(CONFIG.selectors.answer);

            // Generate unique IDs if not present
            if (!question.id) {
                question.id = `faq-question-${accordion.id || 'default'}-${index}`;
            }
            if (!answer.id) {
                answer.id = `faq-answer-${accordion.id || 'default'}-${index}`;
            }

            // Set up button attributes for question
            question.setAttribute('role', 'button');
            question.setAttribute('tabindex', '0');
            question.setAttribute('aria-expanded', 'false');
            question.setAttribute('aria-controls', answer.id);

            // Set up answer panel attributes
            answer.setAttribute('role', 'region');
            answer.setAttribute('aria-labelledby', question.id);
            answer.setAttribute('aria-hidden', 'true');

            // Set initial state based on defaultOpen
            if (defaultOpen === 'all' || (defaultOpen === 'first' && index === 0)) {
                toggleItem(item, true);
            }

            // Add event listeners
            question.addEventListener('click', (e) => {
                e.preventDefault();
                toggleItem(item);
            });

            question.addEventListener('keydown', (e) => handleKeyboardNavigation(e, questions, index));
        });

        // Announce accordion setup to screen readers
        announceToScreenReader(`FAQ accordion with ${questions.length} questions loaded. Use Tab to navigate questions, Enter or Space to expand, arrow keys to move between questions.`);
    }

    /**
     * Setup search functionality for an accordion
     * @param {HTMLElement} accordion The accordion container
     * @param {HTMLElement} searchInput The search input element
     */
    function setupSearch(accordion, searchInput) {
        const items = accordion.querySelectorAll(CONFIG.selectors.item);
        const noResults = accordion.querySelector(CONFIG.selectors.noResults);

        // Set up search input accessibility
        searchInput.setAttribute('aria-label', 'Search FAQ questions');
        searchInput.setAttribute('aria-describedby', 'search-instructions');

        // Add search instructions for screen readers
        let instructions = accordion.querySelector('#search-instructions');
        if (!instructions) {
            instructions = document.createElement('div');
            instructions.id = 'search-instructions';
            instructions.className = 'sr-only';
            instructions.textContent = 'Type to search through FAQ questions. Results will be filtered as you type.';
            searchInput.parentNode.appendChild(instructions);
        }

        // Debounce search input to improve performance
        const debouncedSearch = debounce(function() {
            const searchTerm = this.value.trim().toLowerCase();
            let hasResults = false;
            let visibleCount = 0;

            items.forEach(item => {
                const questionText = item.dataset.question?.toLowerCase() ||
                                   item.querySelector(CONFIG.selectors.question).textContent.toLowerCase();
                const answerText = item.querySelector(CONFIG.selectors.answer).textContent.toLowerCase();
                const isMatch = !searchTerm || questionText.includes(searchTerm) || answerText.includes(searchTerm);

                item.classList.toggle(CONFIG.classes.hidden, !isMatch);
                item.setAttribute('aria-hidden', !isMatch);

                if (isMatch) {
                    hasResults = true;
                    visibleCount++;
                }
            });

            // Show/hide no results message
            if (noResults) {
                noResults.style.display = hasResults || !searchTerm ? 'none' : 'block';
                if (!hasResults && searchTerm) {
                    noResults.setAttribute('aria-live', 'polite');
                    noResults.textContent = `No results found for "${searchTerm}"`;
                }
            }

            // Announce search results to screen readers
            if (searchTerm) {
                announceToScreenReader(`${visibleCount} question${visibleCount !== 1 ? 's' : ''} found for "${searchTerm}"`);
            }
        }, 300);

        searchInput.addEventListener('input', debouncedSearch);

        // Clear search on Escape
        searchInput.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                this.value = '';
                debouncedSearch.call(this);
                announceToScreenReader('Search cleared, showing all questions');
            }
        });
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
        answer.setAttribute('aria-hidden', (!isOpening).toString());

        // Handle animations based on prefers-reduced-motion
        const prefersReducedMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;

        if (prefersReducedMotion) {
            // No animation for users who prefer reduced motion
            item.classList.toggle(CONFIG.classes.active, isOpening);
            answer.style.display = isOpening ? 'block' : 'none';

            // Focus management for screen readers
            if (isOpening) {
                // Set tabindex on answer content for potential focus
                answer.setAttribute('tabindex', '-1');
                // Announce state change
                announceToScreenReader(`Question expanded: ${question.textContent}`);
            } else {
                answer.removeAttribute('tabindex');
                announceToScreenReader(`Question collapsed: ${question.textContent}`);
            }
            return;
        }

        if (isOpening) {
            // Open the item
            item.classList.add(CONFIG.classes.active);
            animateOpen(answer, () => {
                // After animation, announce to screen readers
                announceToScreenReader(`Question expanded: ${question.textContent}`);
                // Set up focus management
                answer.setAttribute('tabindex', '-1');
            });
        } else {
            // Close the item
            animateClose(answer, () => {
                item.classList.remove(CONFIG.classes.active);
                answer.removeAttribute('tabindex');
                announceToScreenReader(`Question collapsed: ${question.textContent}`);
            });
        }
    }

    /**
     * Animate opening an accordion answer
     * @param {HTMLElement} answer The answer element to animate
     * @param {Function} callback Optional callback after animation
     */
    function animateOpen(answer, callback) {
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

            if (callback) callback();
        }, CONFIG.animationDuration);
    }

    /**
     * Animate closing an accordion answer
     * @param {HTMLElement} answer The answer element to animate
     * @param {Function} callback Function to call after animation completes
     */
    function animateClose(answer, callback) {
        // Store the current height value
        const height = answer.offsetHeight;

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

        // Handle activation keys
        if (key === 'Enter' || key === ' ') {
            event.preventDefault();
            const item = questions[currentIndex].closest(CONFIG.selectors.item);
            toggleItem(item);
            return;
        }

        // Handle navigation keys
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

        // Move focus to target question
        questions[targetIndex].focus();

        // Announce navigation to screen readers
        announceToScreenReader(`Question ${targetIndex + 1} of ${questions.length}: ${questions[targetIndex].textContent}`);

        // Optionally open the item when navigating with Ctrl+Arrow keys
        if (isArrowKey && event.ctrlKey) {
            const item = questions[targetIndex].closest(CONFIG.selectors.item);
            toggleItem(item, true);
        }
    }

    /**
     * Announce message to screen readers
     * @param {string} message The message to announce
     */
    function announceToScreenReader(message) {
        // Create or get the announcer element
        let announcer = document.getElementById('faq-announcer');
        if (!announcer) {
            announcer = document.createElement('div');
            announcer.id = 'faq-announcer';
            announcer.setAttribute('aria-live', 'polite');
            announcer.setAttribute('aria-atomic', 'true');
            announcer.className = 'sr-only';
            document.body.appendChild(announcer);
        }

        // Clear previous announcement
        announcer.textContent = '';

        // Make announcement after a brief delay to ensure screen readers pick it up
        setTimeout(() => {
            announcer.textContent = message;
        }, 100);

        // Clear after announcement
        setTimeout(() => {
            announcer.textContent = '';
        }, 3000);
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
