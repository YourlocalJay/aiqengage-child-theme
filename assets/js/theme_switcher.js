document.addEventListener('DOMContentLoaded', function() {
  const toggles = document.querySelectorAll('[data-theme-toggle]');
  const root = document.documentElement;

  // Initial state is already set in head; just sync checkboxes
  const initial = root.getAttribute('data-theme') || 'light';
  
  // Set all toggles to correct initial state
  toggles.forEach(toggle => {
    toggle.checked = (initial === 'light');
  });

  // Theme setting function
  function setTheme(nextTheme) {
    root.setAttribute('data-theme', nextTheme);
    
    try {
      localStorage.setItem('theme', nextTheme);
    } catch (e) {
      console.warn('Could not save theme preference:', e);
    }
    
    // Update all toggles
    toggles.forEach(toggle => {
      toggle.checked = (nextTheme === 'light');
    });
  }

  // Add event listeners to all toggles
  toggles.forEach(toggle => {
    toggle.addEventListener('change', function() {
      setTheme(this.checked ? 'light' : 'dark');
    });
  });

  // Listen for system theme changes (only if no explicit preference)
  const mediaQuery = window.matchMedia('(prefers-color-scheme: dark)');
  
  // Modern browsers
  if (mediaQuery.addEventListener) {
    mediaQuery.addEventListener('change', e => {
      if (!localStorage.getItem('theme')) {
        setTheme(e.matches ? 'dark' : 'light');
      }
    });
  } 
  // Legacy browsers
  else if (mediaQuery.addListener) {
    mediaQuery.addListener(e => {
      if (!localStorage.getItem('theme')) {
        setTheme(e.matches ? 'dark' : 'light');
      }
    });
  }
});

// Quick test function (for console)
window.__aiqThemeDebug = function() {
  const r = document.documentElement;
  const t = r.getAttribute('data-theme');
  console.log('Current theme:', t, 
              '| Prefers dark:', window.matchMedia('(prefers-color-scheme: dark)').matches,
              '| Saved:', localStorage.getItem('theme'));
};
