# Footer Template Documentation

## Overview

The footer template (`footer.json`) is a production-ready Elementor section template that follows the AIQEngage brand guidelines. It includes a comprehensive footer layout with navigation, legal links, partner information, social icons, and proper accessibility features.

## Template Structure

### Main Sections

1. **Main Footer Row** - 4-column layout containing:

   - Quick Links navigation
   - Legal links
   - Partners information
   - Logo and social icons

2. **Affiliate Notice** - Transparent disclosure section

3. **Bottom Bar** - Copyright and tagline

## Features

### Design Elements

- ✅ AIQEngage brand colors (#1A0938, #9C4DFF, #E0D6FF)
- ✅ Inter font family throughout
- ✅ Proper spacing and responsive breakpoints
- ✅ BEM CSS methodology
- ✅ Brand-compliant styling

### Accessibility Features

- ✅ Proper ARIA labels and roles
- ✅ Keyboard navigation support
- ✅ Screen reader optimized
- ✅ Focus management
- ✅ High contrast mode support
- ✅ Reduced motion preferences

### Responsive Design

- ✅ Desktop: 4-column layout
- ✅ Tablet: 2-column layout
- ✅ Mobile: Single-column layout
- ✅ Touch-friendly targets (44px minimum)

### Performance Optimized

- ✅ Lazy loading for images
- ✅ Optimized CSS with minimal specificity
- ✅ Print-friendly styles
- ✅ Efficient resource loading

## Implementation

### Using the Template

1. **Import in Elementor**:

   - Go to Elementor Templates
   - Import `footer.json`
   - Place in your page/site footer

2. **Global Footer Setup**:
   - Use as a global footer template
   - Apply across all pages via Theme Builder

### Required Assets

The template expects these assets to exist:

- Logo: `/wp-content/themes/aiqengage-child/assets/images/aiq-logo-white.svg`
- CSS: `/assets/css/components/footer.css` (automatically loaded)

### Navigation Menus

Create these WordPress menus:

- **Primary Menu**: Main site navigation
- **Footer Quick Links**: Quick navigation items

Configure in Appearance > Menus:

- Vault, Tools, Automation Hub, Results

### Legal Pages

Ensure these pages exist:

- `/privacy` - Privacy Policy
- `/terms` - Terms of Service
- `/affiliate-disclosure` - Affiliate Disclosure
- `/contact` - Contact Support

### Social Media

Update social media links in the template:

- Twitter: `https://twitter.com/aiqengage`
- LinkedIn: `https://linkedin.com/company/aiqengage`
- YouTube: `https://youtube.com/@aiqengage`

## Customization

### Brand Colors

The footer uses these CSS custom properties:

```css
:root {
  --aiq-bg-primary: #1a0938;
  --aiq-bg-secondary: #2a1958;
  --aiq-text-primary: #e0d6ff;
  --aiq-accent: #9c4dff;
  --aiq-text-muted: rgba(224, 214, 255, 0.8);
}
```

### Typography

Uses Inter font family with these weights:

- Regular (400) - Body text
- Medium (500) - Links
- Semi-bold (600) - Headings

### Spacing

Follows 8px grid system:

- Padding: 60px (desktop), 40px (mobile)
- Margins: 30px between sections
- Gap: 20px between elements

## Compliance

### Legal Requirements

- ✅ Copyright notice included
- ✅ Affiliate disclosure present
- ✅ Links to all required legal pages
- ✅ Transparent partner relationships

### Accessibility Compliance

- ✅ WCAG 2.1 AA compliant
- ✅ Proper color contrast ratios
- ✅ Semantic HTML structure
- ✅ Keyboard navigation support

## File Dependencies

### CSS Files

- `assets/css/components/footer.css` - Main footer styles
- `assets/css/main.css` - Design tokens (dependency)
- `assets/css/accessibility.css` - Accessibility overrides

### PHP Files

- `inc/css_loader.php` - Handles CSS loading
- `functions.php` - Enqueues footer styles

### Template Files

- `elementor-templates/sections/footer.json` - Main template

## Browser Support

- ✅ Chrome 90+
- ✅ Firefox 88+
- ✅ Safari 14+
- ✅ Edge 90+
- ✅ Mobile browsers (iOS 14+, Android 10+)

## Testing Checklist

Before deploying:

- [ ] Test on all breakpoints (desktop, tablet, mobile)
- [ ] Verify all links work correctly
- [ ] Check keyboard navigation
- [ ] Test with screen reader
- [ ] Validate accessibility with tools
- [ ] Check performance impact
- [ ] Test in high contrast mode
- [ ] Verify print styles

## Updates & Maintenance

### Regular Updates

- Review partner information quarterly
- Update copyright year annually
- Check legal links monthly
- Audit accessibility annually

### Version History

- v1.0.0 - Initial production-ready footer
- Brand colors: #1A0938, #2A1958, #E0D6FF, #9C4DFF
- Features: Full responsive layout, accessibility compliant
