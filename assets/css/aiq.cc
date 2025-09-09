:root {
  color-scheme: light dark;
  
  /* Core color palette - DARK MODE (default) */
  --ink-950: #0A1A2F;
  --ink-800: #1E293B;
  --ink-600: #334155;
  --teal-500: #1DE9B6;
  --gold-400: #F5C542;
  --accent-500: #27A0F8;
  
  /* Semantic variables - DARK MODE */
  --bg: #0B1220;
  --bg-secondary: #131f30;
  --text: #E6EAF2;
  --text-secondary: #c5cad3;
  --muted: #9AA4B2;
  --border: #2A3A52;
  
  /* Design tokens */
  --radius: 12px;
  --shadow: 0 8px 24px rgba(2, 6, 23, 0.3);
  --shadow-light: 0 4px 12px rgba(2, 6, 23, 0.15);
  --transition: all 0.3s ease;
  
  /* Spacing */
  --space-xs: 0.25rem;
  --space-sm: 0.5rem;
  --space-md: 1rem;
  --space-lg: 1.5rem;
  --space-xl: 2rem;
}

/* Elementor compatibility */
:root, .elementor-kit-*-root {
  --e-global-color-primary: var(--accent-500);
  --e-global-color-secondary: var(--muted);
  --e-global-color-text: var(--text);
  --e-global-color-accent: var(--teal-500);
  --e-global-color-background: var(--bg);
}

[data-theme="light"] {
  /* LIGHT MODE overrides */
  --bg: #F8FAFC;
  --bg-secondary: #FFFFFF;
  --text: #0F172A;
  --text-secondary: #334155;
  --muted: #64748B;
  --border: #E2E8F0;
  --shadow: 0 8px 24px rgba(2, 6, 23, 0.1);
  --shadow-light: 0 4px 12px rgba(2, 6, 23, 0.05);
  --ink-800: #F1F5F9;
  --ink-600: #E2E8F0;
}

/* Smart transitions (only what changes) */
html, body, 
.card, .btn, 
.footer-links a,
.theme-toggle {
  transition: background-color 0.25s ease, 
              color 0.25s ease, 
              border-color 0.25s ease, 
              box-shadow 0.25s ease;
}

/* Focus styles for accessibility */
:where(a, button, [role="button"], input, select, textarea):focus-visible {
  outline: 2px solid var(--accent-500);
  outline-offset: 2px;
}

/* Rest of your CSS remains the same */
body {
  background: var(--bg);
  color: var(--text);
}

.btn {
  display: inline-flex;
  gap: var(--space-sm);
  align-items: center;
  padding: 0.7rem 1rem;
  border-radius: var(--radius);
  background: var(--teal-500);
  color: #08131f;
  font-weight: 600;
  text-decoration: none;
  transition: var(--transition);
  border: none;
  cursor: pointer;
  box-shadow: var(--shadow);
}

.btn:hover {
  transform: translateY(-2px);
  box-shadow: 0 12px 28px rgba(2, 6, 23, 0.4);
  background: #1ad1a3;
}

/* ... rest of your CSS ... */

/* High contrast mode support */
@media (prefers-contrast: high) {
  .card {
    border: 2px solid var(--border);
  }
  
  .btn {
    border: 1px solid currentColor;
  }
}

/* Reduced motion support */
@media (prefers-reduced-motion: reduce) {
  * {
    transition: none !important;
  }
  
  .btn:hover,
  .card:hover {
    transform: none !important;
  }
}
