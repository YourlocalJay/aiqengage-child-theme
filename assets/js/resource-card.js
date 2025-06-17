/**
 * Enhanced Resource Card Widget - Interactive Features
 * Version: 2.0
 * Features:
 * - Smart video embedding (YouTube, Vimeo, Loom)
 * - Usage analytics tracking
 * - Performance optimizations
 * - Accessibility improvements
 * - Progressive enhancement
 */

class ResourceCardManager {
  constructor() {
    this.observer = null;
    this.init();
  }

  init() {
    // Initialize components
    this.setupVideoEmbeds();
    this.trackInteractions();
    this.setupLazyLoading();
    this.addAccessibilityFeatures();
  }

  setupVideoEmbeds() {
    document.querySelectorAll('.aiq-resource-card__video').forEach(videoContainer => {
      const embedUrl = videoContainer.dataset.embedUrl;
      if (!embedUrl) return;

      // Add click handler for video placeholder
      videoContainer.addEventListener('click', (e) => {
        e.preventDefault();
        this.loadVideoEmbed(videoContainer, embedUrl);
      });

      // Add keyboard support
      videoContainer.addEventListener('keydown', (e) => {
        if (e.key === 'Enter' || e.key === ' ') {
          e.preventDefault();
          this.loadVideoEmbed(videoContainer, embedUrl);
        }
      });
    });
  }

  loadVideoEmbed(container, url) {
    // Show loading state
    container.classList.add('loading');

    // Get proper embed URL
    const embedUrl = this.getEmbedUrl(url);

    // Create iframe
    const iframe = document.createElement('iframe');
    iframe.src = embedUrl;
    iframe.setAttribute('frameborder', '0');
    iframe.setAttribute('allow', 'autoplay; fullscreen');
    iframe.setAttribute('allowfullscreen', '');
    iframe.setAttribute('title', 'Embedded video player');
    
    // Load iframe after short delay
    setTimeout(() => {
      container.innerHTML = '';
      container.appendChild(iframe);
      container.classList.remove('loading');
      
      // Track video view
      this.trackEvent('video_view', {
        resource_id: container.closest('.aiq-resource-card').id,
        video_url: url
      });
    }, 300);
  }

  getEmbedUrl(url) {
    // YouTube
    const youtubeRegex = /(?:youtube\.com\/(?:[^\/]+\/.+\/|(?:v|e(?:mbed)?)\/|.*[?&]v=)|youtu\.be\/)([^"&?\/\s]{11})/;
    const youtubeMatch = url.match(youtubeRegex);
    if (youtubeMatch) {
      return `https://www.youtube.com/embed/${youtubeMatch[1]}?autoplay=1&rel=0`;
    }

    // Vimeo
    const vimeoRegex = /vimeo\.com\/(?:channels\/(?:\w+\/)?|groups\/(?:[^\/]*)\/videos\/|)(\d+)(?:|\/\?)/;
    const vimeoMatch = url.match(vimeoRegex);
    if (vimeoMatch) {
      return `https://player.vimeo.com/video/${vimeoMatch[1]}?autoplay=1`;
    }

    // Loom
    if (url.includes('loom.com/share')) {
      return url.replace('/share/', '/embed/');
    }

    return url;
  }

  trackInteractions() {
    document.querySelectorAll('.aiq-resource-card__cta').forEach(button => {
      button.addEventListener('click', (e) => {
        const card = button.closest('.aiq-resource-card');
        const isLocked = card.classList.contains('aiq-resource-card--locked');
        const resourceId = card.id;
        const resourceTitle = card.querySelector('.aiq-resource-card__title')?.textContent;
        const resourceType = card.querySelector('.aiq-resource-card__badge span')?.textContent;

        if (isLocked) {
          this.trackEvent('pro_unlock_click', {
            resource_id: resourceId,
            resource_title: resourceTitle
          });
        } else {
          this.trackEvent('resource_download', {
            resource_id: resourceId,
            resource_title: resourceTitle,
            resource_type: resourceType
          });

          // Animate download counter
          const counter = card.querySelector('.aiq-resource-card__downloads');
          if (counter) {
            counter.classList.add('downloading');
            setTimeout(() => counter.classList.remove('downloading'), 1000);
          }
        }
      });
    });
  }

  setupLazyLoading() {
    if ('IntersectionObserver' in window) {
      this.observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
          if (entry.isIntersecting) {
            const card = entry.target;
            this.preloadCardAssets(card);
            this.observer.unobserve(card);
          }
        });
      }, {
        rootMargin: '200px 0px',
        threshold: 0.01
      });

      document.querySelectorAll('.aiq-resource-card').forEach(card => {
        this.observer.observe(card);
      });
    } else {
      // Fallback: Load all immediately if IntersectionObserver not supported
      document.querySelectorAll('.aiq-resource-card').forEach(card => {
        this.preloadCardAssets(card);
      });
    }
  }

  preloadCardAssets(card) {
    const video = card.querySelector('.aiq-resource-card__video');
    if (video && video.dataset.embedUrl) {
      // Could preconnect to video domain here
      const link = document.createElement('link');
      link.rel = 'preconnect';
      link.href = new URL(video.dataset.embedUrl).origin;
      document.head.appendChild(link);
    }
  }

  addAccessibilityFeatures() {
    document.querySelectorAll('.aiq-resource-card').forEach(card => {
      // Ensure cards are keyboard navigable
      card.setAttribute('tabindex', '0');
      
      // Add ARIA labels for video cards
      const video = card.querySelector('.aiq-resource-card__video');
      if (video) {
        const title = card.querySelector('.aiq-resource-card__title')?.textContent;
        video.setAttribute('aria-label', `Play video: ${title}`);
        video.setAttribute('role', 'button');
      }
    });
  }

  trackEvent(eventName, eventData) {
    // Google Analytics
    if (typeof gtag === 'function') {
      gtag('event', eventName, eventData);
    }
    
    // Facebook Pixel
    if (typeof fbq === 'function') {
      fbq('trackCustom', eventName, eventData);
    }
    
    // Custom analytics
    if (typeof window.trackResourceEvent === 'function') {
      window.trackResourceEvent(eventName, eventData);
    }

    // Store in localStorage for user profile
    try {
      const profileKey = 'aiq_user_profile';
      const profile = JSON.parse(localStorage.getItem(profileKey) || '{}');
      
      profile.resource_interactions = profile.resource_interactions || [];
      profile.resource_interactions.push({
        event: eventName,
        data: eventData,
        timestamp: new Date().toISOString()
      });
      
      localStorage.setItem(profileKey, JSON.stringify(profile));
    } catch (e) {
      console.warn('Could not store interaction:', e);
    }
  }
}

// Initialize when DOM is ready
if (document.readyState !== 'loading') {
  new ResourceCardManager();
} else {
  document.addEventListener('DOMContentLoaded', () => new ResourceCardManager());
}