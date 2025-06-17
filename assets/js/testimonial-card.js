// assets/js/testimonial-card.js

/**
 * AIQEngage Testimonial Card Widget
 * 
 * Adds interactivity to testimonial cards including:
 * - Star rating animation
 * - Pro badge hover effects
 * - Optional testimonial slider functionality
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
    
    /**
     * Optional: Initialize testimonial slider if multiple cards are in a container
     * Note: This requires a parent element with class 'aiq-testimonial-slider'
     */
    function initTestimonialSlider() {
        const sliders = document.querySelectorAll('.aiq-testimonial-slider');
        
        if (!sliders.length) {
            return;
        }
        
        sliders.forEach(slider => {
            const cards = slider.querySelectorAll('.aiq-testimonial-card');
            const cardCount = cards.length;
            
            if (cardCount <= 1) {
                return;
            }
            
            // Create navigation elements
            const nav = document.createElement('div');
            nav.className = 'aiq-testimonial-slider__nav';
            
            const prevBtn = document.createElement('button');
            prevBtn.className = 'aiq-testimonial-slider__nav-btn aiq-testimonial-slider__nav-prev';
            prevBtn.innerHTML = '&larr;';
            prevBtn.setAttribute('aria-label', 'Previous testimonial');
            
            const nextBtn = document.createElement('button');
            nextBtn.className = 'aiq-testimonial-slider__nav-btn aiq-testimonial-slider__nav-next';
            nextBtn.innerHTML = '&rarr;';
            nextBtn.setAttribute('aria-label', 'Next testimonial');
            
            // Add navigation to slider
            nav.appendChild(prevBtn);
            nav.appendChild(nextBtn);
            slider.appendChild(nav);
            
            // Set up slider functionality
            let currentIndex = 0;
            
            // Update visible card
            function updateSlider() {
                cards.forEach((card, index) => {
                    card.style.display = index === currentIndex ? 'block' : 'none';
                    
                    if (index === currentIndex) {
                        card.setAttribute('aria-hidden', 'false');
                    } else {
                        card.setAttribute('aria-hidden', 'true');
                    }
                });
            }
            
            // Initialize slider
            updateSlider();
            
            // Add event listeners
            prevBtn.addEventListener('click', () => {
                currentIndex = (currentIndex - 1 + cardCount) % cardCount;
                updateSlider();
            });
            
            nextBtn.addEventListener('click', () => {
                currentIndex = (currentIndex + 1) % cardCount;
                updateSlider();
            });
            
            // Add keyboard navigation
            slider.setAttribute('tabindex', '0');
            slider.addEventListener('keydown', (e) => {
                if (e.key === 'ArrowLeft') {
                    prevBtn.click();
                } else if (e.key === 'ArrowRight') {
                    nextBtn.click();
                }
            });
        });
    }
    
    // Initialize when DOM is ready
    document.addEventListener('DOMContentLoaded', function() {
        initTestimonialCards();
        
        // Uncomment to enable slider functionality
        // initTestimonialSlider();
    });
    
    // Also initialize when Elementor frontend is ready (for editor preview)
    if (window.elementorFrontend) {
        window.elementorFrontend.hooks.addAction('frontend/element_ready/aiq_testimonial_card.default', function() {
            initTestimonialCards();
            // initTestimonialSlider();
        });
    }
})();
