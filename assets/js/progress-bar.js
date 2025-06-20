/**
 * Progress Bar Widget Script
 *
 * @package aiqengage-child
 * @version 1.0.0
 * @since   1.0.0
 * @author  Jason
 */

/* global jQuery, elementorFrontend */

(function() {
    'use strict';

    class ProgressBarManager {
        constructor() {
            this.progressBars = [];
            this.lastProgress = 0;
            this.scrollThrottle = null;
            this.resizeThrottle = null;
            this.animationFrame = null;
            this.init();
        }

        init() {
            document.addEventListener('DOMContentLoaded', () => {
                this.setupProgressBars();
                this.setupEventListeners();
                this.updateProgressBars();
            });
        }

        setupProgressBars() {
            const bars = document.querySelectorAll('.aiq-progress-bar');
            if (!bars.length) return;

            this.progressBars = Array.from(bars).map(bar => {
                // Get animation speed from data attribute or default to 100ms
                const speed = bar.dataset.animationSpeed || 100;

                return {
                    element: bar,
                    percentageElement: bar.querySelector('.aiq-progress-bar__percentage'),
                    speed: parseInt(speed, 10),
                    liveRegion: this.createLiveRegion(bar),
                    lastAnnounced: -1
                };
            });

            // Initialize Intersection Observer for content changes
            this.setupIntersectionObserver();
        }

        createLiveRegion(bar) {
            const liveRegion = document.createElement('div');
            liveRegion.setAttribute('aria-live', 'polite');
            liveRegion.className = 'aiq-progress-bar__sr-text';
            bar.appendChild(liveRegion);
            return liveRegion;
        }

        setupIntersectionObserver() {
            // Watch for content changes that might affect page height
            const observer = new MutationObserver(() => {
                this.debouncedUpdate();
            });

            observer.observe(document.body, {
                childList: true,
                subtree: true,
                attributes: false,
                characterData: false
            });

            // Also observe main content area for better performance
            const mainContent = document.querySelector('main, .main-content, #main') || document.body;
            observer.observe(mainContent, {
                childList: true,
                subtree: true
            });
        }

        setupEventListeners() {
            // Throttled scroll event
            window.addEventListener('scroll', () => {
                if (!this.scrollThrottle) {
                    this.scrollThrottle = setTimeout(() => {
                        this.handleScroll();
                        this.scrollThrottle = null;
                    }, 16); // ~60fps
                }
            });

            // Throttled resize event
            window.addEventListener('resize', () => {
                if (!this.resizeThrottle) {
                    this.resizeThrottle = setTimeout(() => {
                        this.debouncedUpdate();
                        this.resizeThrottle = null;
                    }, 200);
                }
            });

            // Initialize accessibility features
            this.progressBars.forEach(barData => {
                barData.element.setAttribute('tabindex', '0');
                this.setupAccessibility(barData);
            });
        }

        setupAccessibility(barData) {
            // Announce progress at intervals
            setInterval(() => {
                const current = parseInt(barData.element.getAttribute('aria-valuenow'), 10);
                if (this.shouldAnnounceProgress(current, barData.lastAnnounced)) {
                    barData.liveRegion.textContent = `${current}% of content read`;
                    barData.lastAnnounced = current;
                }
            }, 2000);
        }

        shouldAnnounceProgress(current, lastAnnounced) {
            // Announce at 25% intervals or when complete
            return (Math.floor(current / 25) > Math.floor(lastAnnounced / 25)) ||
                   (current === 100 && lastAnnounced !== 100);
        }

        handleScroll() {
            if (this.animationFrame) {
                cancelAnimationFrame(this.animationFrame);
            }
            this.animationFrame = requestAnimationFrame(() => {
                this.updateProgressBars();
            });
        }

        debouncedUpdate() {
            if (this.animationFrame) {
                cancelAnimationFrame(this.animationFrame);
            }
            this.animationFrame = requestAnimationFrame(() => {
                this.updateProgressBars();
            });
        }

        calculateProgress() {
            const scrollTop = window.pageYOffset || document.documentElement.scrollTop;
            const docHeight = this.getDocumentHeight() - window.innerHeight;

            if (docHeight <= 0) return 0;

            const scrollPercent = (scrollTop / docHeight) * 100;
            return Math.min(100, Math.max(0, Math.round(scrollPercent)));
        }

        getDocumentHeight() {
            return Math.max(
                document.body.scrollHeight,
                document.body.offsetHeight,
                document.documentElement.clientHeight,
                document.documentElement.scrollHeight,
                document.documentElement.offsetHeight
            );
        }

        updateProgressBars() {
            const progress = this.calculateProgress();

            // Only update if progress has changed
            if (progress === this.lastProgress) return;

            this.lastProgress = progress;

            this.progressBars.forEach(barData => {
                this.updateSingleBar(barData, progress);
            });
        }

        updateSingleBar(barData, progress) {
            // Smooth transition for the progress bar
            barData.element.style.setProperty(
                '--aiq-progress-width',
                `${progress}%`,
                progress === 0 ? 'important' : ''
            );

            // Update ARIA attributes
            barData.element.setAttribute('aria-valuenow', progress);

            // Update percentage display if exists
            if (barData.percentageElement) {
                barData.percentageElement.textContent = `${progress}%`;

                // Add animation class for percentage change
                barData.percentageElement.classList.add('aiq-progress-percentage-changing');
                setTimeout(() => {
                    barData.percentageElement.classList.remove('aiq-progress-percentage-changing');
                }, barData.speed);
            }
        }
    }

    // Initialize the progress bar manager
    new ProgressBarManager();

})();
