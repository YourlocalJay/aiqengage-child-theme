/**
 * Evergreen Countdown Widget Script
 *
 * @package aiqengage-child
 * @version   1.0.0
 * @since     1.0.0
 * @author    Jason
 */

class EvergreenCountdown {
  constructor(element) {
    this.element = element;
    this.config = this.parseConfig();
    this.displayStyle = this.getDisplayStyle();
    this.isActive = false;
    this.init();
  }

  init() {
    // Set end time based on type
    this.endTime = this.config.type === 'evergreen'
      ? this.getEvergreenEndTime()
      : this.config.endDate * 1000;

    // Check expiration
    if (this.isExpired()) {
      this.handleExpiry();
      return;
    }

    // Initialize display and countdown
    this.initDisplay();
    this.startCountdown();
    this.initCloseButton();
    this.initUrgentState();
  }

  parseConfig() {
    return {
      type: this.element.dataset.countdownType,
      cookieId: this.element.dataset.cookieId,
      afterExpiry: this.element.dataset.afterExpiry,
      duration: parseInt(this.element.dataset.duration, 10),
      endDate: parseInt(this.element.dataset.endDate, 10),
      modalTrigger: this.element.dataset.modalTrigger,
      modalDelay: parseInt(this.element.dataset.modalDelay, 10),
      scrollPercentage: parseInt(this.element.dataset.scrollPercentage, 10),
      displayDays: this.element.dataset.displayDays === 'true',
      displayHours: this.element.dataset.displayHours === 'true',
      displayMinutes: this.element.dataset.displayMinutes === 'true',
      displaySeconds: this.element.dataset.displaySeconds === 'true',
      redirectUrl: this.element.dataset.redirectUrl
    };
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
    // Try localStorage first, then cookies
    let endTime = this.getFromStorage(this.config.cookieId);

    if (!endTime) {
      endTime = Date.now() + (this.config.duration * 1000);
      this.setToStorage(this.config.cookieId, endTime);
    }

    return parseInt(endTime, 10);
  }

  getFromStorage(key) {
    // Try localStorage first
    try {
      return localStorage.getItem(key);
    } catch {
      // Fallback to cookies if localStorage fails
      const cookie = document.cookie.match(`(^|;)\\s*${key}\\s*=\\s*([^;]+)`);
      return cookie ? cookie.pop() : null;
    }
  }

  setToStorage(key, value) {
    // Try localStorage first
    try {
      localStorage.setItem(key, value);
    } catch {
      // Fallback to cookies if localStorage fails
      const date = new Date();
      date.setFullYear(date.getFullYear() + 1);
      document.cookie = `${key}=${value}; expires=${date.toUTCString()}; path=/`;
    }
  }

  isExpired() {
    return Date.now() >= this.endTime;
  }

  initDisplay() {
    if (this.displayStyle === 'inline') return;
    if (this.getFromStorage(`${this.config.cookieId}_closed`)) return;

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
    switch (this.config.modalTrigger) {
      case 'delay':
        setTimeout(() => this.showModal(), this.config.modalDelay * 1000);
        break;
      case 'scroll':
        this.initScrollTrigger();
        break;
      case 'exit':
        this.initExitIntent();
        break;
      default:
        this.showModal();
    }
  }

  initScrollTrigger() {
    const handler = () => {
      const scrollPos = window.scrollY || window.pageYOffset;
      const docHeight = document.documentElement.scrollHeight - window.innerHeight;
      const scrollPercent = (scrollPos / docHeight) * 100;

      if (scrollPercent >= this.config.scrollPercentage) {
        this.showModal();
        window.removeEventListener('scroll', handler);
      }
    };

    window.addEventListener('scroll', handler);
  }

  initExitIntent() {
    const handler = (e) => {
      if (e.clientY < 0) {
        this.showModal();
        document.removeEventListener('mouseleave', handler);
      }
    };

    document.addEventListener('mouseleave', handler);
  }

  showModal() {
    if (this.isActive) return;

    this.element.classList.add('is-visible');
    document.body.classList.add('aiq-modal-open');
    this.isActive = true;

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
    this.isActive = true;
  }

  trapFocus() {
    const focusable = this.getFocusableElements();
    if (focusable.length === 0) return;

    const first = focusable[0];
    const last = focusable[focusable.length - 1];

    const keyHandler = e => {
      if (e.key !== 'Tab') return;

      if (e.shiftKey && document.activeElement === first) {
        last.focus();
        e.preventDefault();
      } else if (!e.shiftKey && document.activeElement === last) {
        first.focus();
        e.preventDefault();
      }
    };

    this.element.addEventListener('keydown', keyHandler);
    first.focus();
  }

  getFocusableElements() {
    return Array.from(this.element.querySelectorAll(
      'button, [href], input, select, textarea, [tabindex]:not([tabindex="-1"])'
    )).filter(el => !el.disabled && el.offsetParent !== null);
  }

  startCountdown() {
    this.updateDisplay();
    this.interval = setInterval(() => this.updateDisplay(), 1000);
  }

  updateDisplay() {
    const timeLeft = this.endTime - Date.now();

    if (timeLeft <= 0) {
      clearInterval(this.interval);
      this.handleExpiry();
      return;
    }

    const { days, hours, minutes, seconds } = this.calculateTimeUnits(timeLeft);
    this.updateTimeDisplay(days, hours, minutes, seconds);
    this.updateUrgentState(timeLeft);
    this.announceTimePeriodically(timeLeft, days, hours, minutes, seconds);
  }

  calculateTimeUnits(timeLeft) {
    return {
      days: Math.floor(timeLeft / (1000 * 60 * 60 * 24)),
      hours: Math.floor((timeLeft % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60)),
      minutes: Math.floor((timeLeft % (1000 * 60 * 60)) / (1000 * 60)),
      seconds: Math.floor((timeLeft % (1000 * 60)) / 1000)
    };
  }

  updateTimeDisplay(days, hours, minutes, seconds) {
    if (this.config.displayDays) {
      this.updateDigit('days', days);
    }
    if (this.config.displayHours) {
      this.updateDigit('hours', hours);
    }
    if (this.config.displayMinutes) {
      this.updateDigit('minutes', minutes);
    }
    if (this.config.displaySeconds) {
      this.updateDigit('seconds', seconds);
    }
  }

  updateDigit(unit, value) {
    const digitEl = this.element.querySelector(`[data-countdown-${unit}]`);
    if (!digitEl) return;

    const formatted = value < 10 ? `0${value}` : value.toString();
    if (digitEl.textContent !== formatted) {
      digitEl.textContent = formatted;
    }
  }

  initUrgentState() {
    this.urgentThreshold = 3600000; // 1 hour
    this.element.classList.toggle('is-urgent', this.endTime - Date.now() <= this.urgentThreshold);
  }

  updateUrgentState(timeLeft) {
    const isUrgent = timeLeft <= this.urgentThreshold;
    this.element.classList.toggle('is-urgent', isUrgent);
  }

  announceTimePeriodically(timeLeft, days, hours, minutes, seconds) {
    // Announce every 15 minutes or when under 5 minutes
    if (timeLeft <= 300000 || (timeLeft % 900000 < 1000 && timeLeft > 900000)) {
      this.announceTimeLeft(days, hours, minutes, seconds);
    }
  }

  announceTimeLeft(days, hours, minutes, seconds) {
    const ariaLive = this.element.querySelector('[aria-live]');
    if (!ariaLive) return;

    const parts = [];
    if (days > 0) parts.push(`${days} day${days !== 1 ? 's' : ''}`);
    if (hours > 0 || days > 0) parts.push(`${hours} hour${hours !== 1 ? 's' : ''}`);
    parts.push(`${minutes} minute${minutes !== 1 ? 's' : ''}`);
    parts.push(`${seconds} second${seconds !== 1 ? 's' : ''}`);

    ariaLive.textContent = `Time remaining: ${parts.join(', ')}`;
  }

  initCloseButton() {
    const closeBtn = this.element.querySelector('.aiq-evergreen-countdown__close');
    if (closeBtn) {
      closeBtn.addEventListener('click', () => this.hide());
    }
  }

  hide() {
    if (this.displayStyle === 'modal') {
      document.body.classList.remove('aiq-modal-open');
    }

    this.element.classList.remove('is-visible');
    this.setToStorage(`${this.config.cookieId}_closed`, 'true');
    this.isActive = false;
  }

  handleExpiry() {
    clearInterval(this.interval);
    this.element.classList.add('is-expired');

    switch (this.config.afterExpiry) {
      case 'hide':
        this.element.style.display = 'none';
        break;

      case 'message':
        this.showFallbackContent();
        break;

      case 'redirect':
        this.handleRedirect();
        break;

      default:
        this.element.style.opacity = '0.5';
    }
  }

  showFallbackContent() {
    // Hide original content
    const originalContent = this.element.querySelector('.aiq-evergreen-countdown__original');
    if (originalContent) originalContent.style.display = 'none';

    // Show fallback content
    const fallbackContent = this.element.querySelector('.aiq-evergreen-countdown__fallback');
    if (fallbackContent) fallbackContent.style.display = 'block';

    // Announce expiry
    const ariaLive = this.element.querySelector('[aria-live]');
    if (ariaLive) {
      ariaLive.setAttribute('aria-live', 'assertive');
      ariaLive.textContent = 'This offer has expired';
      setTimeout(() => ariaLive.setAttribute('aria-live', 'polite'), 1000);
    }
  }

  handleRedirect() {
    if (this.config.redirectUrl) {
      setTimeout(() => {
        window.location.href = this.config.redirectUrl;
      }, 1500);
    }
  }
}

// Initialize all countdowns on page load
document.addEventListener('DOMContentLoaded', () => {
  const countdowns = document.querySelectorAll('.aiq-evergreen-countdown');
  countdowns.forEach(el => new EvergreenCountdown(el));
});

// Testing utilities
window.AIQCountdown = {
  reset: function(cookieId) {
    try {
      localStorage.removeItem(cookieId);
      localStorage.removeItem(`${cookieId}_closed`);
    } catch {
      document.cookie = `${cookieId}=; expires=Thu, 01 Jan 1970 00:00:00 GMT`;
      document.cookie = `${cookieId}_closed=; expires=Thu, 01 Jan 1970 00:00:00 GMT`;
    }
    location.reload();
  },

  setTestTime: function(cookieId, minutesLeft) {
    const endTime = Date.now() + (minutesLeft * 60000);
    try {
      localStorage.setItem(cookieId, endTime.toString());
    } catch {
      const date = new Date();
      date.setFullYear(date.getFullYear() + 1);
      document.cookie = `${cookieId}=${endTime}; expires=${date.toUTCString()}; path=/`;
    }
    location.reload();
  },

  showAll: function() {
    document.querySelectorAll('.aiq-evergreen-countdown').forEach(el => {
      el.classList.add('is-visible');
    });
  }
};
