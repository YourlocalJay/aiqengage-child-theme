<?php
namespace AIQEngage\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Core\Schemes\Color;

if (!defined('ABSPATH')) exit;

class ROI_Calculator_Widget extends Widget_Base {

    public function get_name() {
        return 'roi-calculator';
    }

    public function get_title() {
        return __('Advanced ROI Calculator', 'aiqengage-child');
    }

    public function get_icon() {
        return 'eicon-calculator';
    }

    public function get_categories() {
        return ['aiqengage', 'finance-tools'];
    }

    public function get_keywords() {
        return ['roi', 'calculator', 'finance', 'profit', 'investment'];
    }

    protected function register_controls() {
        // Content Section
        $this->start_controls_section('content_section', [
            'label' => __('Content', 'aiqengage-child'),
            'tab' => Controls_Manager::TAB_CONTENT,
        ]);

        $this->add_control('headline', [
            'label' => __('Headline', 'aiqengage-child'),
            'type' => Controls_Manager::TEXT,
            'default' => __('AI Automation ROI Calculator', 'aiqengage-child'),
            'label_block' => true,
        ]);

        $this->add_control('description', [
            'label' => __('Description', 'aiqengage-child'),
            'type' => Controls_Manager::TEXTAREA,
            'default' => __('Estimate your profit and breakeven for any automation or affiliate campaign.', 'aiqengage-child'),
            'rows' => 3,
        ]);

        $this->end_controls_section();

        // Input Defaults Section
        $this->start_controls_section('defaults_section', [
            'label' => __('Default Values', 'aiqengage-child'),
            'tab' => Controls_Manager::TAB_CONTENT,
        ]);

        $this->add_control('default_traffic', [
            'label' => __('Daily Traffic', 'aiqengage-child'),
            'type' => Controls_Manager::NUMBER,
            'min' => 0,
            'default' => 100,
        ]);

        // ... (similar controls for other default values)

        $this->end_controls_section();

        // Style Section
        $this->start_controls_section('style_section', [
            'label' => __('Style', 'aiqengage-child'),
            'tab' => Controls_Manager::TAB_STYLE,
        ]);

        // ... (style controls here)

        $this->end_controls_section();
    }

    protected function render() {
        $settings = $this->get_settings_for_display();
        $widget_id = 'aiq-roi-calc-' . $this->get_id();
        ?>
        <section class="aiq-roi-calculator" id="<?php echo esc_attr($widget_id); ?>" data-widget-id="<?php echo esc_attr($this->get_id()); ?>">
            <div class="aiq-roi-calculator__container">
                <header class="aiq-roi-calculator__header">
                    <h3 class="aiq-roi-calculator__title"><?php echo esc_html($settings['headline']); ?></h3>
                    <?php if ($settings['description']) : ?>
                        <div class="aiq-roi-calculator__desc"><?php echo esc_html($settings['description']); ?></div>
                    <?php endif; ?>
                </header>
                
                <form class="aiq-roi-calculator__form" autocomplete="off" novalidate>
                    <div class="aiq-roi-calculator__input-grid">
                        <?php $this->render_input_field('traffic', __('Daily Traffic', 'aiqengage-child'), 'number', [
                            'min' => 0,
                            'step' => 1,
                            'value' => $settings['default_traffic']
                        ]); ?>
                        
                        <?php $this->render_input_field('conversion', __('Conversion Rate (%)', 'aiqengage-child'), 'number', [
                            'min' => 0,
                            'max' => 100,
                            'step' => 0.1,
                            'value' => 3.5
                        ]); ?>
                        
                        <!-- More input fields -->
                    </div>
                    
                    <div class="aiq-roi-calculator__actions">
                        <button type="submit" class="aiq-roi-calculator__button">
                            <?php esc_html_e('Calculate ROI', 'aiqengage-child'); ?>
                        </button>
                        <button type="reset" class="aiq-roi-calculator__reset">
                            <?php esc_html_e('Reset', 'aiqengage-child'); ?>
                        </button>
                    </div>
                </form>
                
                <output class="aiq-roi-calculator__results" aria-live="polite">
                    <div class="aiq-roi-result-card">
                        <h4><?php esc_html_e('Projected Results', 'aiqengage-child'); ?></h4>
                        <div class="aiq-roi-result-grid">
                            <div class="aiq-roi-result-item">
                                <span class="aiq-roi-result-label"><?php esc_html_e('Monthly Revenue:', 'aiqengage-child'); ?></span>
                                <span class="aiq-roi-result-value" data-result="monthly">$0</span>
                            </div>
                            <!-- More result items -->
                        </div>
                    </div>
                </output>
            </div>
        </section>
        <?php
    }

    protected function render_input_field($name, $label, $type = 'number', $attrs = []) {
        ?>
        <div class="aiq-roi-input-group">
            <label>
                <span class="aiq-roi-input-label"><?php echo esc_html($label); ?></span>
                <input 
                    type="<?php echo esc_attr($type); ?>" 
                    name="<?php echo esc_attr($name); ?>"
                    <?php foreach ($attrs as $attr => $value) : ?>
                        <?php echo esc_attr($attr); ?>="<?php echo esc_attr($value); ?>"
                    <?php endforeach; ?>
                    class="aiq-roi-input"
                >
                <?php if (isset($attrs['description'])) : ?>
                    <span class="aiq-roi-input-description"><?php echo esc_html($attrs['description']); ?></span>
                <?php endif; ?>
            </label>
        </div>
        <?php
    }

    public function get_style_depends() {
        return ['aiq-widget-roi-calculator'];
    }

    public function get_script_depends() {
        return ['aiq-roi-calculator', 'aiq-utils'];
    }
}
