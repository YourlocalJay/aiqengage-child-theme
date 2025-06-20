/**
 * Testimonial Card Widget Script
 *
 * @package aiqengage-child
 * @version 1.0.0
 * @since   1.0.0
 * @author  Jason
 */

(function() {
    'use strict';

    /**
     * Initialize the testimonial card functionality
     */
    function initTestimonialCards() {
        const testimonialCards = document.querySelectorAll('.aiq-testimonial-card');

        if (!testimonialCards.length) {
            return;
        }

        // Add animation to star ratings
        animateStarRatings();

        // Add hover effects to pro badges
        initProBadges();
    }

    /**
     * Animate star ratings when they enter the viewport
     */
    function animateStarRatings() {
        const starElements = document.querySelectorAll('.aiq-testimonial-card__stars');

        if (!starElements.length || !window.IntersectionObserver) {
            return;
        }

        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    const starsEl = entry.target;
                    const filledStars = starsEl.querySelector('.aiq-testimonial-card__stars-filled');

                    // Reset width to 0 and animate to full width
                    if (filledStars) {
                        const finalWidth = filledStars.style.width;
                        filledStars.style.width = '0%';

                        // Trigger animation after a small delay
                        setTimeout(() => {
                            filledStars.style.transition = 'width 1.5s ease-in-out';
                            filledStars.style.width = finalWidth;
                        }, 300);
                    }

                    // Unobserve after animation
                    observer.unobserve(starsEl);
                }
            });
        }, {
            threshold: 0.5
        });

        // Observe each star rating element
        starElements.forEach(stars => {
            observer.observe(stars);
        });
    }

    /**
     * Initialize pro badge effects
     */
    function initProBadges() {
        const proBadges = document.querySelectorAll('.aiq-testimonial-card__pro-badge');

        if (!proBadges.length) {
            return;
        }

        proBadges.forEach(badge => {
            // Add subtle animation on hover
            badge.addEventListener('mouseenter', () => {
                badge.style.transform = 'scale(1.1) rotate(5deg)';
                badge.style.transition = 'transform 0.3s ease';
            });

            badge.addEventListener('mouseleave', () => {
                badge.style.transform = 'scale(1) rotate(0)';
            });
        });
    }

    // Initialize when DOM is ready
    document.addEventListener('DOMContentLoaded', function() {
        initTestimonialCards();
    });

    // Also initialize when Elementor frontend is ready (for editor preview)
    if (window.elementorFrontend) {
        window.elementorFrontend.hooks.addAction('frontend/element_ready/aiq_testimonial_card.default', function() {
            initTestimonialCards();
        });
    }
})();
