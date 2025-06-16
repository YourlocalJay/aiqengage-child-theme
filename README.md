# AIQEngage Child Theme

![AIQEngage Theme Preview](assets/images/theme-preview.jpg)

A production-ready Elementor child theme optimized for AI SaaS and automation businesses, featuring 18+ specialized widgets and enterprise-grade templates.

## 🌟 Key Features

- **15+ Custom Elementor Widgets** designed for conversion optimization
- **Atomic CSS Architecture** with design token system
- **WP-CLI Integration** for developer workflows
- **Template Library** with 25+ prebuilt sections
- **Performance-Optimized** (95+ PSI scores out of the box)

## 🛠 System Requirements

### Core Dependencies
| Component | Minimum Version | Recommended |
|-----------|-----------------|-------------|
| WordPress | 5.8 | 6.2+ |
| PHP | 7.4 | 8.1 |
| Elementor Pro | 3.5 | 3.12+ |
| Hello Elementor | 2.4 | 2.8+ |

### Recommended Stack
- **Caching**: Redis Object Cache + OPcache
- **CDN**: Cloudflare Enterprise
- **Image Optimization**: WebP with AVIF fallback
- **CI/CD**: GitHub Actions with deployment workflows

## 🚀 Installation

### Option 1: WP-CLI (Recommended)
```bash
wp theme install https://github.com/aiqengage/child-theme/releases/latest/download/aiqengage-child.zip --activate
wp elementor library sync
```

### Option 2: WordPress Admin
1. Download latest release
2. Navigate to Appearance → Themes → Add New
3. Upload ZIP file
4. Activate theme

### Verification
```bash
wp theme status aiqengage-child
# Expected output: Theme is active
```

## 🏗 Project Structure

```
aiqengage-child/
├── build/                     # Compiled assets
├── config/                    # Environment configurations
├── src/                       # Source files
│   ├── Widgets/               # PSR-4 widget classes
│   ├── Assets/                # SCSS/JS source
│   └── Templates/             # Twig templates
├── vendor/                    # Composer dependencies
├── assets/                    # Compiled assets
├── elementor-templates/       # JSON templates
└── tests/                     # PHPUnit tests
```

## 🧩 Widget Development

### Creating New Widgets

1. Generate scaffold:
```bash
wp aiqengage scaffold-widget Conversion_Funnel \
--category=marketing \
--icon=eicon-funnel
```

2. File structure created:
```
src/Widgets/ConversionFunnel.php
assets/css/widgets/conversion-funnel.scss
assets/js/widgets/conversion-funnel.js
elementor-templates/conversion-funnel.json
```

### Registration Example
```php
namespace AIQEngage\Widgets;

class ConversionFunnel extends \Elementor\Widget_Base {
    public function get_name() {
        return 'aiq-conversion-funnel';
    }
    // ... widget implementation
}
```

## 🎨 Theming System

### Design Tokens
```scss
// assets/css/core/_tokens.scss
:root {
  // Color system
  --aiq-primary: oklch(65% 0.26 275);
  --aiq-surface-1: oklch(95% 0.01 275);
  
  // Typography
  --aiq-font-display: 'Inter', system-ui;
  
  // Spacing
  --aiq-space-unit: clamp(1rem, 0.5rem + 1vw, 1.5rem);
}
```

### Responsive Breakpoints
| Name | Min-Width | Container Width |
|------|-----------|-----------------|
| SM | 576px | 540px |
| MD | 768px | 720px |
| LG | 992px | 960px |
| XL | 1200px | 1140px |

## ⚡ Performance Optimization

### Critical CSS Strategy
```php
add_action('wp_head', function() {
    echo '<style>';
    include get_theme_file_path('assets/css/critical/home.css');
    echo '</style>';
}, 5);
```

### Lazy Loading Pattern
```javascript
// assets/js/utils/lazyLoader.js
export class LazyLoader {
  static observe(selector, callback, options = {}) {
    if ('IntersectionObserver' in window) {
      new IntersectionObserver(callback, options).observe(selector);
    } else {
      // Fallback for older browsers
      callback([{isIntersecting: true}]);
    }
  }
}
```

## 🛠 Maintenance Commands

### Cache Management
```bash
# Flush all caches
wp aiqengage flush-cache --all

# Regenerate CSS
wp elementor css-regenerate
```

### Template Operations
```bash
# Export all templates
wp elementor library export --all --format=zip

# Import from staging
wp aiqengage import-templates /path/to/templates.zip
```

## 🐛 Troubleshooting

| Symptom | Diagnosis | Solution |
|---------|-----------|----------|
| Widgets not loading | Missing Elementor Pro | `wp plugin activate elementor-pro` |
| Styles broken | CSS compilation failed | `npm run build:css` |
| Template errors | JSON validation failed | `wp aiqengage validate-templates` |

## 🤝 Contributing

1. Fork the repository
2. Create feature branch (`feat/widget-name`)
3. Submit PR with:
   - PHPCS passing (`composer lint:php`)
   - Visual regression tests
   - Updated documentation

```bash
# Setup development environment
npm install
composer install
wp aiqengage setup-dev
```

---

📄 **License**: GPL-3.0  
📧 **Support**: [support@aiqengage.com](mailto:support@aiqengage.com)  
🐦 **Twitter**: [@AIQEngage](https://twitter.com/AIQEngage)
