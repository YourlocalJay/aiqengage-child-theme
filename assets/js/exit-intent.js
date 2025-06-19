
/**
 * Exit Intent Modal Widget Script
 *
 * @package aiqengage-child
 * @version   1.0.0
 * @since     1.0.0
 * @author    Jason
 */


class ExitIntentManager {
  constructor() {
    this.modals = [];
    this.currentModal = null;
    this.isInitialized = false;
    this.lastMousePosition = { x: 0, y: 0 };
    this.inactivityTimer = null;
    this.scrollDepthHandlers = new WeakMap();
    this.eventHandlers = new Map();
  }

  init() {
    if (this.isInitialized) return;

    // Find and initialize all modals
    document.querySelectorAll('.aiq-exit-intent').forEach(element => {
      try {
        const modal = new ExitIntentModal(element, this);
        this.modals.push(modal);
        modal.setupTriggers();
      } catch (error) {
        console.error('Error initializing modal:', error);
      }
    });

    // Set up global event listeners
    this.setupEventListeners();
    this.setupExitIntentDetection();

    this.isInitialized = true;
  }

  setupEventListeners() {
    document.addEventListener('keydown', this.handleKeyDown.bind(this));
    window.addEventListener('resize', this.handleResize.bind(this));
    document.addEventListener('visibilitychange', this.handleVisibilityChange.bind(this));
  }

  setupExitIntentDetection() {
    // Enhanced mouse tracking for exit intent
    document.addEventListener('mousemove', (e) => {
      this.lastMousePosition = { x: e.clientX, y: e.clientY };
    });

    document.addEventListener('mouseleave', (e) => {
      if (e.clientY <= 0 && !this.isMobileDevice()) {
        this.triggerModals('exit_intent');
      }
    });
  }

  handleKeyDown(e) {
    if (!this.currentModal) return;

    // ESC key closes modal
    if (e.key === 'Escape' && this.currentModal.closeOnEsc) {
      this.currentModal.close();
      e.preventDefault();
    }

    // TAB key for focus trapping
    if (e.key === 'Tab') {
      this.currentModal.handleTabKey(e);
    }
  }

  handleResize() {
    if (this.currentModal) {
      this.currentModal.updateFocusableElements();
    }
  }

  handleVisibilityChange() {
    if (document.visibilityState === 'hidden' && this.currentModal) {
      this.currentModal.pauseAnimations();
    } else if (this.currentModal) {
      this.currentModal.resumeAnimations();
    }
  }

  triggerModals(triggerType) {
    this.modals.forEach(modal => {
      if (modal.trigger === triggerType && modal.shouldShow()) {
        modal.show();
      }
    });
  }

  isMobileDevice() {
    // More reliable mobile detection
    const ua = navigator.userAgent;
    const isMobile = /Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(ua);
    const isTablet = /iPad|Android/i.test(ua) && !/Mobile/i.test(ua);
    const touchEnabled = 'ontouchstart' in window || navigator.maxTouchPoints > 0;

    return isMobile || (touchEnabled && (window.innerWidth < 1024 || isTablet));
  }

  // Public API
  showModal(id) {
    const modal = this.modals.find(m => m.id === id);
    if (modal) modal.show();
  }

  closeCurrentModal() {
    if (this.currentModal) this.currentModal.close();
  }

  closeModalById(id) {
    const modal = this.modals.find(m => m.id === id);
    if (modal) modal.close();
  }

  getModalIds() {
    return this.modals.map(m => m.id);
  }

  on(event, callback) {
    if (!this.eventHandlers.has(event)) {
      this.eventHandlers.set(event, []);
    }
    this.eventHandlers.get(event).push(callback);
  }

  off(event, callback) {
    const handlers = this.eventHandlers.get(event);
    if (handlers) {
      this.eventHandlers.set(
        event,
        handlers.filter(handler => handler !== callback)
      );
    }
  }

  dispatchEvent(event, data) {
    const handlers = this.eventHandlers.get(event);
    if (handlers) {
      handlers.forEach(handler => handler(data));
    }
  }
}

class ExitIntentModal {
  constructor(element, manager) {
    this.element = element;
    this.manager = manager;
    this.id = element.id;
    this.config = this.parseConfig();
    this.state = {
      isActive: false,
      isClosing: false,
      hasShown: this.checkIfShown(),
      focusableElements: [],
      animationPaused: false
    };

    this.elements = {
      modal: element.querySelector('.aiq-exit-intent__modal'),
      overlay: element.querySelector('.aiq-exit-intent__overlay'),
      closeButton: element.querySelector('.aiq-exit-intent__close'),
      contentWrapper: element.querySelector('.aiq-exit-intent__content-wrapper')
    };

    this.bindEvents();
    this.setAccessibilityAttributes();
  }

  parseConfig() {
    return {
      trigger: this.element.dataset.trigger || 'exit_intent',
      displayOnce: this.element.dataset.displayOnce === 'yes',
      daysToRemember: parseInt(this.element.dataset.daysRemember || 7, 10),
      closeOnEsc: this.element.dataset.closeEsc === 'yes',
      closeOnOverlay: this.element.dataset.closeOverlay === 'yes',
      animation: this.element.dataset.animation || 'fade-in',
      timeDelay: parseInt(this.element.dataset.delay || 0, 10) * 1000,
      scrollDepth: parseInt(this.element.dataset.scrollDepth || 50, 10),
      specificPages: this.element.dataset.specificPages ?
        this.element.dataset.specificPages.split(',') : [],
      excludeMobile: this.element.dataset.excludeMobile === 'yes'
    };
  }

  bindEvents() {
    if (this.elements.closeButton) {
      this.elements.closeButton.addEventListener('click', this.close.bind(this));
    }

    if (this.config.closeOnOverlay && this.elements.overlay) {
      this.elements.overlay.addEventListener('click', (e) => {
        if (e.target === this.elements.overlay) {
          this.close();
        }
      });
    }
  }

  setAccessibilityAttributes() {
    this.elements.modal.setAttribute('role', 'dialog');
    this.elements.modal.setAttribute('aria-modal', 'true');
    this.elements.modal.setAttribute('aria-labelledby', `${this.id}-heading`);

    if (this.elements.closeButton) {
      this.elements.closeButton.setAttribute('aria-label', 'Close modal');
    }
  }

  setupTriggers() {
    if (!this.shouldShowOnCurrentPage()) return;
    if (this.config.displayOnce && this.state.hasShown) return;
    if (this.config.excludeMobile && this.manager.isMobileDevice()) return;

    switch (this.config.trigger) {
      case 'exit_intent':
        // Handled globally by manager
        break;

      case 'time_delay':
        setTimeout(() => this.show(), this.config.timeDelay);
        break;

      case 'scroll_depth':
        this.setupScrollDepthTrigger();
        break;

      case 'inactivity':
        this.setupInactivityTrigger();
        break;
    }
  }

  setupScrollDepthTrigger() {
    const handler = () => {
      const scrollTop = window.scrollY || document.documentElement.scrollTop;
      const windowHeight = window.innerHeight;
      const documentHeight = document.documentElement.scrollHeight;
      const scrollPercentage = (scrollTop / (documentHeight - windowHeight)) * 100;

      if (scrollPercentage >= this.config.scrollDepth) {
        this.show();
        window.removeEventListener('scroll', handler);
      }
    };

    this.manager.scrollDepthHandlers.set(this, handler);
    window.addEventListener('scroll', handler);
    handler(); // Check immediately
  }

  setupInactivityTrigger() {
    let activityTimeout;

    const resetTimer = () => {
      clearTimeout(activityTimeout);
      activityTimeout = setTimeout(() => this.show(), this.config.timeDelay);
    };

    ['mousemove', 'keydown', 'scroll', 'touchstart'].forEach(event => {
      window.addEventListener(event, resetTimer);
    });

    resetTimer();
  }

  shouldShow() {
    return (
      !this.state.isActive &&
      !this.state.isClosing &&
      (!this.config.displayOnce || !this.state.hasShown) &&
      this.shouldShowOnCurrentPage()
    );
  }

  shouldShowOnCurrentPage() {
    if (this.config.specificPages.length === 0) return true;

    const currentPageId = document.body.dataset.postId;
    return currentPageId && this.config.specificPages.includes(currentPageId);
  }

  show() {
    if (!this.shouldShow()) return;

    // Close any open modal first
    if (this.manager.currentModal) {
      this.manager.currentModal.close();
    }

    // Update state
    this.state.isActive = true;
    this.manager.currentModal = this;

    // Show modal
    this.element.classList.add('active');
    document.body.style.overflow = 'hidden';
    this.elements.modal.setAttribute('tabindex', '-1');
    this.elements.modal.focus();

    // Update focusable elements
    this.updateFocusableElements();

    // Track display if needed
    if (this.config.displayOnce) {
      this.setModalShown();
    }

    // Dispatch event
    this.manager.dispatchEvent('modal:opened', { id: this.id });
  }

  close() {
    if (!this.state.isActive || this.state.isClosing) return;

    this.state.isClosing = true;
    this.element.classList.add('closing');

    const animationDuration = getComputedStyle(this.elements.modal).animationDuration;
    const duration = parseFloat(animationDuration) * 1000 || 300;

    setTimeout(() => {
      this.element.classList.remove('active', 'closing');
      this.state.isActive = false;
      this.state.isClosing = false;

      document.body.style.overflow = '';

      if (this.manager.currentModal === this) {
        this.manager.currentModal = null;
      }

      this.manager.dispatchEvent('modal:closed', { id: this.id });
    }, duration);
  }

  handleTabKey(e) {
    if (!this.state.isActive || this.state.focusableElements.length < 2) return;

    const firstElement = this.state.focusableElements[0];
    const lastElement = this.state.focusableElements[this.state.focusableElements.length - 1];

    if (e.shiftKey && document.activeElement === firstElement) {
      e.preventDefault();
      lastElement.focus();
    } else if (!e.shiftKey && document.activeElement === lastElement) {
      e.preventDefault();
      firstElement.focus();
    }
  }

  updateFocusableElements() {
    this.state.focusableElements = Array.from(
      this.element.querySelectorAll(
        'a[href], button, input, textarea, select, details, [tabindex]:not([tabindex="-1"])'
      )
    ).filter(el => !el.disabled && el.offsetParent !== null);
  }

  pauseAnimations() {
    if (this.state.animationPaused) return;

    this.element.style.animationPlayState = 'paused';
    this.state.animationPaused = true;
  }

  resumeAnimations() {
    if (!this.state.animationPaused) return;

    this.element.style.animationPlayState = 'running';
    this.state.animationPaused = false;
  }

  checkIfShown() {
    if (!this.config.displayOnce) return false;

    const storageKey = `aiq_modal_shown_${this.id}`;
    const savedValue = localStorage.getItem(storageKey);

    if (!savedValue) return false;

    try {
      const data = JSON.parse(savedValue);
      const now = Date.now();
      return data.timestamp && (now - data.timestamp) < (this.config.daysToRemember * 86400000);
    } catch (e) {
      return false;
    }
  }

  setModalShown() {
    if (!this.config.displayOnce) return;

    const storageKey = `aiq_modal_shown_${this.id}`;
    const data = { timestamp: Date.now() };

    localStorage.setItem(storageKey, JSON.stringify(data));
    this.state.hasShown = true;
  }
}

// Initialize the manager
const exitIntentManager = new ExitIntentManager();

// Expose public API
window.AIQExitIntent = {
  show: id => exitIntentManager.showModal(id),
  close: () => exitIntentManager.closeCurrentModal(),
  closeById: id => exitIntentManager.closeModalById(id),
  getModalIds: () => exitIntentManager.getModalIds(),
  on: (event, callback) => exitIntentManager.on(event, callback),
  off: (event, callback) => exitIntentManager.off(event, callback)
};

// Initialize when ready
if (document.readyState === 'loading') {
  document.addEventListener('DOMContentLoaded', () => exitIntentManager.init());
} else {
  exitIntentManager.init();
}
