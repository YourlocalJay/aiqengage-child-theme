/**
 * AIQEngage Evergreen Countdown - Enhanced Version
 * Version: 2.1
 * Features:
 * - Multiple display modes (modal, sticky, inline)
 * - Various trigger types (delay, scroll, exit intent)
 * - LocalStorage persistence
 * - Customizable expiration actions
 * - Responsive behavior
 * - Accessibility improvements
 */

class EvergreenCountdown {
  constructor(element) {
    this.element = element;
    this.type = element.dataset.countdownType;
    this.cookieId = element.dataset.cookieId;
    this.afterExpiry = element.dataset.afterExpiry;
    this.displayStyle = this.getDisplayStyle();
    this.init();
  }

  init() {
    // Get or set end time
    this.endTime = this.type === 'evergreen' 
      ? this.getEvergreenEndTime() 
      : parseInt(this.element.dataset.endDate, 10) * 1000;

    // Check if already expired
    if (Date.now() >= this.endTime) {
      this.handleExpiry();
      return;
    }

    // Initialize display
    this.initDisplay();
    this.startCountdown();

    // Set up close functionality if available
    this.initCloseButton();
  }

  getDisplayStyle() {
    if (this.element.classList.contains('aiq-evergreen-countdown--modal')) {
      return 'modal';
    }
    if (this.element.classList.contains('aiq-evergreen-countdown--sticky')) {
      return 'sticky';
    }
    return 'inline';
  }

  getEvergreenEndTime() {
    const duration = parseInt(this.element.dataset.duration, 10) * 1000;
    let endTime = localStorage.getItem(this.cookieId);

    if (!endTime) {
      endTime = Date.now() + duration;
      localStorage.setItem(this.cookieId, endTime.toString());
    } else {
      endTime = parseInt(endTime, 10);
    }

    return endTime;
  }

  initDisplay() {
    if (this.displayStyle === 'inline') return;

    // Check if previously closed
    if (localStorage.getItem(`${this.cookieId}_closed`)) {
      return;
    }

    switch (this.displayStyle) {
      case 'modal':
        this.initModal();
        break;
      case 'sticky':
        this.showSticky();
        break;
    }
  }

  initModal() {
    const triggerType = this.element.dataset.modalTrigger;

    switch (triggerType) {
      case 'delay':
        const delay = parseInt(this.element.dataset.modalDelay, 10) * 1000;
        setTimeout(() => this.showModal(), delay);
        break;

      case 'scroll':
        const percentage = parseInt(this.element.dataset.scrollPercentage, 10);
        this.initScrollTrigger(percentage);
        break;

      case 'exit':
        this.initExitIntent();
        break;

      default:
        this.showModal();
    }
  }

  initScrollTrigger(percentage) {
    const scrollHandler = () => {
      const scrollPos = window.scrollY || window.pageYOffset;
      const docHeight = document.documentElement.scrollHeight - window.innerHeight;
      const scrollPercent = (scrollPos / docHeight) * 100;

      if (scrollPercent >= percentage) {
        this.showModal();
        window.removeEventListener('scroll', scrollHandler);
      }
    };

    window.addEventListener('scroll', scrollHandler);
  }

  initExitIntent() {
    const exitHandler = (e) => {
      if (e.clientY < 0) {
        this.showModal();
        document.removeEventListener('mouseleave', exitHandler);
      }
    };

    document.addEventListener('mouseleave', exitHandler);
  }

  showModal() {
    this.element.classList.add('is-visible');
    document.body.classList.add('aiq-modal-open');

    // Trap focus for accessibility
    this.trapFocus();

    // Close on overlay click
    this.element.addEventListener('click', (e) => {
      if (e.target === this.element) {
        this.hide();
      }
    });
  }

  showSticky() {
    this.element.classList.add('is-visible');
  }

  trapFocus() {
    const focusableElements = this.element.querySelectorAll(
      'button, [href], input, select, textarea, [tabindex]:not([tabindex="-1"])'
    );
    const firstElement = focusableElements[0];
    const lastElement = focusableElements[focusableElements.length - 1];

    this.element.addEventListener('keydown', (e) => {
      if (e.key !== 'Tab') return;

      if (e.shiftKey) {
        if (document.activeElement === firstElement) {
          lastElement.focus();
          e.preventDefault();
        }
      } else {
        if (document.activeElement === lastElement) {
          firstElement.focus();
          e.preventDefault();
        }
      }
    });

    firstElement.focus();
  }

  startCountdown() {
    this.updateDisplay();

    this.interval = setInterval(() => {
      if (Date.now() >= this.endTime) {
        clearInterval(this.interval);
        this.handleExpiry();
      } else {
        this.updateDisplay();
      }
    }, 1000);
  }

  updateDisplay() {
    const timeLeft = this.endTime - Date.now();
    const days = Math.floor(timeLeft / (1000 * 60 * 60 * 24));
    const hours = Math.floor((timeLeft % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
    const minutes = Math.floor((timeLeft % (1000 * 60 * 60)) / (1000 * 60));
    const seconds = Math.floor((timeLeft % (1000 * 60)) / 1000);

    // Update DOM elements
    const daysEl = this.element.querySelector('[data-countdown-days]');
    const hoursEl = this.element.querySelector('[data-countdown-hours]');
    const minsEl = this.element.querySelector('[data-countdown-minutes]');
    const secsEl = this.element.querySelector('[data-countdown-seconds]');

    if (daysEl) daysEl.textContent = this.formatTime(days);
    if (hoursEl) hoursEl.textContent = this.formatTime(hours);
    if (minsEl) minsEl.textContent = this.formatTime(minutes);
    if (secsEl) secsEl.textContent = this.formatTime(seconds);

    // Update ARIA live region
    const liveRegion = this.element.querySelector('[aria-live]');
    if (liveRegion) {
      liveRegion.textContent = `${days} days, ${hours} hours, ${minutes} minutes, and ${seconds} seconds remaining`;
    }
  }

  formatTime(value) {
    return value < 10 ? `0${value}` : value.toString();
  }

  initCloseButton() {
    const closeButton = this.element.querySelector('.aiq-evergreen-countdown__close');
    if (closeButton) {
      closeButton.addEventListener('click', () => this.hide());
    }
  }

  hide() {
    if (this.displayStyle === 'modal') {
      document.body.classList.remove('aiq-modal-open');
    }
    
    this.element.classList.remove('is-visible');
    localStorage.setItem(`${this.cookieId}_closed`, 'true');
  }

  handleExpiry() {
    switch (this.afterExpiry) {
      case 'hide':
        this.element.style.display = 'none';
        break;
        
      case 'message':
        const expiryMessage = this.element.querySelector('.aiq-evergreen-expired');
        if (expiryMessage) {
          expiryMessage.style.display = 'block';
        }
        break;
        
      case 'redirect':
        const redirectUrl = this.element.dataset.redirectUrl;
        if (redirectUrl) {
          window.location.href = redirectUrl;
        }
        break;
        
      default:
        this.element.style.opacity = '0.5';
    }
    
    // Clear the interval if it exists
    if (this.interval) {
      clearInterval(this.interval);
    }
  }
}

// Initialize all countdowns on the page
document.addEventListener('DOMContentLoaded', () => {
  document.querySelectorAll('.aiq-evergreen-countdown').forEach(el => {
    new EvergreenCountdown(el);
  });
});
