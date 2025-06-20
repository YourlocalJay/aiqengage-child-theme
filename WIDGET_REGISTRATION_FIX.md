# AIQEngage Widget Registration System Documentation

## Widget Auto-Registration Overview

The AIQEngage child theme includes an automatic widget registration system that scans the `/widgets/` directory and registers all valid Elementor widgets without manual intervention.

## How It Works

### File Scanning

The system scans for widget files using two supported naming patterns:

1. **Preferred Pattern**: `class-{name}-widget.php`
2. **Legacy Pattern**: `aiq-{name}-widget.php` (maintained for backward compatibility)

### Class Name Convention

All widget classes must follow the `AIQ_{Name}_Widget` format:

```php
// File: class-my-custom-widget.php
class AIQ_My_Custom_Widget extends \Elementor\Widget_Base {
    public function get_name() {
        return 'aiq-my-custom';
    }

    public function get_title() {
        return __('My Custom Widget', 'aiqengage-child');
    }

    // ... rest of widget implementation
}
```

### Filename to Class Name Conversion

The system automatically converts filenames to class names:

| Filename                        | Expected Class Name       |
| ------------------------------- | ------------------------- |
| `class-cta-banner-widget.php`   | `AIQ_Cta_Banner_Widget`   |
| `class-metric-badge-widget.php` | `AIQ_Metric_Badge_Widget` |
| `aiq-legacy-widget.php`         | `AIQ_Legacy_Widget`       |

## Currently Registered Widgets (23 Total)

### Core Widgets

- **404 Template** (`AIQ_404_Template_Widget`)
- **Archive Loop** (`AIQ_Archive_Loop_Widget`)
- **Blueprint Flow** (`AIQ_Blueprint_Flow_Widget`)
- **Chat Widget** (`AIQ_Chat_Widget`)
- **Comparison Matrix** (`AIQ_Comparison_Matrix_Widget`)
- **CTA Banner** (`AIQ_Cta_Banner_Widget`)
- **FAQ Accordion** (`AIQ_Faq_Accordion_Widget`)
- **Feature Section** (`AIQ_Feature_Section_Widget`)
- **Metric Badge** (`AIQ_Metric_Badge_Widget`)
- **Pricing Table** (`AIQ_Pricing_Table_Widget`)
- **Progress Bar** (`AIQ_Progress_Bar_Widget`)
- **Prompt Card** (`AIQ_Prompt_Card_Widget`)
- **Quiz Widget** (`AIQ_Quiz_Widget`)
- **Resource Card** (`AIQ_Resource_Card_Widget`)
- **ROI Calculator** (`AIQ_Roi_Calculator_Widget`)
- **Testimonial Card** (`AIQ_Testimonial_Card_Widget`)
- **Tool Card** (`AIQ_Tool_Card_Widget`)
- **Value Timeline** (`AIQ_Value_Timeline_Widget`)

### Engagement Widgets

- **Evergreen Countdown** (`AIQ_Evergreen_Countdown_Widget`)
- **Exit Intent** (`AIQ_Exit_Intent_Widget`)

### Legacy Support

- **AiQ Prompt Card** (`AIQ_Prompt_Card_Widget`) - Duplicate support for backward compatibility

## Widget Development Guidelines

### Creating New Widgets

1. **Create the widget file** in `/widgets/` using the preferred naming pattern:

   ```
   /widgets/class-my-new-widget.php
   ```

2. **Implement the widget class**:

   ```php
   <?php
   if (!defined('ABSPATH')) exit;

   class AIQ_My_New_Widget extends \Elementor\Widget_Base {
       public function get_name() {
           return 'aiq-my-new';
       }

       public function get_title() {
           return __('My New Widget', 'aiqengage-child');
       }

       public function get_icon() {
           return 'eicon-elementor';
       }

       public function get_categories() {
           return ['aiqengage'];
       }

       protected function register_controls() {
           // Define widget controls
       }

       protected function render() {
           // Output widget HTML
       }
   }
   ```

3. **The widget will be automatically registered** when the theme loads.

### Widget Assets

Each widget can have associated CSS and JavaScript files:

- CSS: `/assets/css/widgets/{widget-name}.css`
- JS: `/assets/js/widgets/{widget-name}.js`

These are loaded automatically by the asset management system.

## Debugging Widget Registration

### Enable Debug Logging

```php
define('WP_DEBUG', true);
define('WP_DEBUG_LOG', true);
```

### Debug Information Logged

- Widget file discovery
- Class name conversion
- Registration success/failure
- Error details for failed registrations

### Common Issues and Solutions

| Issue                           | Cause                                    | Solution                              |
| ------------------------------- | ---------------------------------------- | ------------------------------------- |
| Widget not appearing            | File naming doesn't match pattern        | Use `class-{name}-widget.php` format  |
| Class not found                 | Class name doesn't match expected format | Follow `AIQ_{Name}_Widget` convention |
| Widget not extending base class | Missing parent class                     | Extend `\Elementor\Widget_Base`       |
| Registration fails              | Syntax errors in widget file             | Check PHP syntax and debug logs       |

## System Requirements

- **WordPress**: 5.8+
- **Elementor Pro**: 3.5+
- **PHP**: 7.4+

## Performance Considerations

- Widgets are registered only on pages using Elementor
- Asset loading is optimized per widget usage
- Debug logging can be disabled in production

## Maintenance

### Adding New Widgets

Simply place properly named widget files in `/widgets/` directory - no manual registration required.

### Updating Existing Widgets

Modify widget files directly and clear Elementor cache to see changes.

### Removing Widgets

Delete widget files and clear Elementor cache to remove from available widgets.

---

**Last Updated**: June 2025  
**System Version**: 1.0.3
