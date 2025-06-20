# AIQEngage Child Theme

![AIQEngage Theme Preview](assets/images/theme-preview.jpg)
_Note: The preview image is currently a placeholder. Replace with actual theme screenshot (min. 880x660px) before release._

A production-ready Elementor child theme optimized for AI SaaS and automation businesses, featuring 23 specialized widgets and enterprise-grade templates.

## 🌟 Key Features

- **23 Custom Elementor Widgets** designed for conversion optimization
- **Atomic CSS Architecture** with design token system
- **Template Library** with prebuilt sections
- **Performance-Optimized** with accessibility compliance
- **Modular Asset System** for efficient loading

## 🛠 System Requirements

### Core Dependencies

| Component       | Minimum Version | Recommended |
| --------------- | --------------- | ----------- |
| WordPress       | 5.8             | 6.2+        |
| PHP             | 7.4             | 8.1+        |
| Elementor Pro   | 3.5             | 3.12+       |
| Hello Elementor | 2.4             | 2.8+        |

### Recommended Stack

- **Caching**: Redis Object Cache + OPcache
- **CDN**: Cloudflare Enterprise
- **Image Optimization**: WebP with AVIF fallback
- **Performance**: 95+ PageSpeed Insights scores

## 🚀 Quick Start

### Installation

1. Download the latest release
2. Upload to WordPress via Appearance → Themes → Add New
3. Activate the theme
4. Ensure Elementor Pro is active and updated

### Verification

Check that all widgets are available in Elementor by:

1. Edit any page with Elementor
2. Look for "AIQEngage Widgets" category in the widget panel
3. Verify 23 widgets are available

## 🧩 Available Widgets

The theme includes 23 production-ready Elementor widgets:

### Core Widgets

- **404 Template** - Custom error page layouts
- **Archive Loop** - Dynamic content loops
- **Blueprint Flow** - Process visualization diagrams
- **Chat Widget** - Interactive chat interfaces
- **Comparison Matrix** - Feature comparison tables
- **CTA Banner** - Call-to-action sections
- **FAQ Accordion** - Expandable question sections
- **Feature Section** - Product feature layouts
- **Metric Badge** - Animated statistics displays
- **Pricing Table** - Subscription plan comparisons
- **Progress Bar** - Visual progress indicators
- **Prompt Card** - AI prompt display and copy functionality
- **Quiz Widget** - Interactive assessment tools
- **Resource Card** - Content resource displays
- **ROI Calculator** - Interactive calculators
- **Testimonial Card** - Customer review displays
- **Tool Card** - Software tool showcases
- **Value Timeline** - Process and milestone timelines

### Engagement Widgets

- **Evergreen Countdown** - Dynamic countdown timers
- **Exit Intent** - Exit-intent popup triggers

All widgets follow AIQEngage brand guidelines and include:

- Responsive design patterns
- Accessibility compliance (WCAG 2.2 AA)
- Performance optimization
- Brand-consistent styling

## 🏗 Project Structure

```
aiqengage-child/
├── assets/                    # Compiled assets
│   ├── css/                   # Stylesheets with design tokens
│   ├── js/                    # JavaScript functionality
│   └── images/                # Theme images (includes preview placeholder)
├── elementor-templates/       # Template library
├── inc/                       # Core functionality
│   ├── css_loader.php         # Asset management
│   ├── widget-assets.php      # Widget asset registration
│   ├── widget-loader.php      # Automatic widget registration
│   └── template_registrations.php # Template library
├── templates/                 # Custom page templates
├── widgets/                   # 23 Elementor widgets
├── functions.php              # Theme initialization
└── style.css                  # Main stylesheet with tokens
```

## 🎨 Design System

### Design Tokens

The theme uses CSS custom properties for consistent styling:

```scss
:root {
  // Color system
  --aiq-primary-bg: #1a0938;
  --aiq-secondary-bg: #2a1958;
  --aiq-primary-text: #e0d6ff;
  --aiq-accent: #9c4dff;

  // Typography
  --aiq-font-primary: "Inter", sans-serif;
  --aiq-h1-size: 4.5rem;
  --aiq-h2-size: 2.5rem;
  --aiq-h3-size: 1.5rem;

  // Spacing
  --aiq-card-padding: 1.5rem;
  --aiq-card-radius: 15px;
}
```

### Responsive Breakpoints

| Name    | Min-Width | Container Width |
| ------- | --------- | --------------- |
| Mobile  | 320px     | 100%            |
| Tablet  | 768px     | 720px           |
| Desktop | 1025px    | 1200px          |

## ⚡ Performance Features

### Critical CSS Strategy

- Design tokens loaded with highest priority
- Accessibility CSS loaded immediately after
- Component styles loaded on demand

### Asset Optimization

- Modular CSS loading per component
- JavaScript lazy loading for widgets
- WebP image support with fallbacks
- Inter font preloading with `font-display: swap`

### Accessibility Compliance

- WCAG 2.2 AA compliance
- Screen reader support
- Keyboard navigation
- Reduced motion support
- High contrast mode compatibility

## 🔧 Widget Development

### Auto-Registration System

Widgets are automatically registered when placed in `/widgets/` directory with proper naming:

**Supported Patterns:**

- `class-{name}-widget.php` (preferred)
- `aiq-{name}-widget.php` (legacy support)

**Class Naming Convention:**

```php
// File: class-my-custom-widget.php
class AIQ_My_Custom_Widget extends \Elementor\Widget_Base {
    public function get_name() {
        return 'aiq-my-custom';
    }
    // ... widget implementation
}
```

### Asset Loading

Each widget can have associated assets:

- CSS: `/assets/css/widgets/{widget-name}.css`
- JS: `/assets/js/widgets/{widget-name}.js`

## 🛠 Maintenance

### Updating Widgets

1. Modify widget files in `/widgets/` directory
2. Clear Elementor cache: Elementor → System Info → Regenerate CSS
3. Test widget functionality in Elementor editor

### Version Management

- Theme version is defined in `style.css` header
- PHP version constant in `functions.php`
- Both versions are currently synchronized at 1.0.3

### Debugging

Enable widget debugging with:

```php
define('WP_DEBUG', true);
define('WP_DEBUG_LOG', true);
```

Widget registration details will appear in debug logs.

## 📋 Upgrade Instructions

### From Version 1.0.2 to 1.0.3

1. Backup your site
2. Upload the new theme files
3. Regenerate Elementor CSS
4. Verify all widgets are functioning

### Theme Activation Checklist

- [ ] WordPress 5.8+ is installed
- [ ] Elementor Pro is active and updated
- [ ] Hello Elementor parent theme is available
- [ ] All 23 widgets appear in Elementor
- [ ] Site performance remains optimized

## 📄 Documentation

### Additional Resources

- **ACCESSIBILITY_SUMMARY.md** - Comprehensive accessibility compliance details
- **WIDGET_SYSTEM.md** - Complete widget development and registration documentation
- **Brand Style Guide** - Design system and component guidelines (external)

### Support Resources

- Theme follows WordPress coding standards
- PSR-4 autoloading for widget organization
- Comprehensive error handling and logging

## 🐛 Troubleshooting

| Issue                     | Cause                      | Solution                  |
| ------------------------- | -------------------------- | ------------------------- |
| Widgets not appearing     | Elementor Pro not active   | Activate Elementor Pro    |
| Styles not loading        | CSS import paths incorrect | Check asset file paths    |
| JavaScript errors         | Missing dependencies       | Verify jQuery is loaded   |
| Widget registration fails | File naming mismatch       | Follow naming conventions |

## 🤝 Contributing

When contributing to the theme:

1. Follow the established file structure
2. Use the design token system for styling
3. Ensure accessibility compliance
4. Test across all breakpoints
5. Maintain widget naming conventions

## 📸 Theme Preview Image

**Current Status**: Placeholder file exists at `/assets/images/theme-preview.jpg`

**Before Release**: Replace placeholder with actual screenshot meeting these requirements:

- Minimum size: 880x660 pixels
- Format: JPG or PNG preferred
- Content: Homepage or key theme features showcase
- Should highlight the dark purple theme, neural patterns, and key widgets
- Include branded elements and conversion-optimized layout

---

📄 **License**: GPL-3.0  
📧 **Support**: [support@aiqengage.com](mailto:support@aiqengage.com)  
🌐 **Website**: [AIQEngage.com](https://aiqengage.com)  
**Version**: 1.0.3  
**Last Updated**: June 2025
