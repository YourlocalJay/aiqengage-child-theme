<?php
namespace AIQEngage\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Repeater;
use Elementor\Group_Control_Typography;
use Elementor\Core\Schemes\Typography;

if (!defined('ABSPATH')) exit;

/**
 * AIQEngage Pricing Table Widget
 * 
 * An Elementor widget for displaying pricing plans according to AIQEngage brand guidelines
 * 
 * @since 1.0.0
 */
class Pricing_Table_Widget extends Widget_Base {
    
    /**
     * Get widget name
     * @return string Widget name
     */
    public function get_name() { 
        return 'aiq-pricing-table'; 
    }
    
    /**
     * Get widget title
     * @return string Widget title
     */
    public function get_title() { 
        return __('AIQ Pricing Table', 'aiqengage-child'); 
    }
    
    /**
     * Get widget icon
     * @return string Widget icon
     */
    public function get_icon() { 
        return 'eicon-table'; 
    }
    
    /**
     * Get widget categories
     * @return array Widget categories
     */
    public function get_categories() { 
        return ['aiqengage']; 
    }
    
    /**
     * Get widget keywords
     * @return array Widget keywords
     */
    public function get_keywords() { 
        return ['pricing', 'plans', 'table', 'offer', 'stack']; 
    }

    /**
     * Register widget controls
     */
    protected function register_controls() {
        
        // Pricing Plans Section
        $this->start_controls_section(
            'section_plans',
            [
                'label' => __('Pricing Plans', 'aiqengage-child'),
                'tab' => Controls_Manager::TAB_CONTENT,
            ]
        );

        // Toggle Features
        $this->add_control(
            'show_toggle',
            [
                'label' => __('Show Plan Toggle', 'aiqengage-child'),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => __('Yes', 'aiqengage-child'),
                'label_off' => __('No', 'aiqengage-child'),
                'default' => '',
            ]
        );

        $this->add_control(
            'toggle_left_text',
            [
                'label' => __('Toggle Left Text', 'aiqengage-child'),
                'type' => Controls_Manager::TEXT,
                'default' => __('Monthly', 'aiqengage-child'),
                'condition' => [
                    'show_toggle' => 'yes',
                ],
            ]
        );

        $this->add_control(
            'toggle_right_text',
            [
                'label' => __('Toggle Right Text', 'aiqengage-child'),
                'type' => Controls_Manager::TEXT,
                'default' => __('Lifetime', 'aiqengage-child'),
                'condition' => [
                    'show_toggle' => 'yes',
                ],
            ]
        );

        // Pricing Plans Repeater
        $repeater = new Repeater();
        
        $repeater->add_control(
            'plan_title',
            [
                'label' => __('Plan Name', 'aiqengage-child'),
                'type' => Controls_Manager::TEXT,
                'default' => __('Pro', 'aiqengage-child'),
                'label_block' => true,
            ]
        );
        
        $repeater->add_control(
            'plan_price',
            [
                'label' => __('Price', 'aiqengage-child'),
                'type' => Controls_Manager::TEXT,
                'default' => '$49/mo',
                'label_block' => true,
            ]
        );
        
        $repeater->add_control(
            'plan_alt_price',
            [
                'label' => __('Alternative Price (for toggle)', 'aiqengage-child'),
                'type' => Controls_Manager::TEXT,
                'default' => '$399',
                'label_block' => true,
            ]
        );
        
        $repeater->add_control(
            'plan_description',
            [
                'label' => __('Short Description', 'aiqengage-child'),
                'type' => Controls_Manager::TEXTAREA,
                'default' => __('Perfect for solo entrepreneurs', 'aiqengage-child'),
                'rows' => 2,
            ]
        );
        
        $repeater->add_control(
            'plan_features',
            [
                'label' => __('Features (one per line)', 'aiqengage-child'),
                'type' => Controls_Manager::TEXTAREA,
                'default' => "50+ Conversion Prompts\nWeekly Updates\nCommunity Access\nPriority Support",
                'rows' => 6,
                'placeholder' => __('One feature per line', 'aiqengage-child'),
            ]
        );
        
        $repeater->add_control(
            'plan_badge',
            [
                'label' => __('Badge Text', 'aiqengage-child'),
                'type' => Controls_Manager::TEXT,
                'default' => '',
                'placeholder' => __('e.g. Most Popular', 'aiqengage-child'),
            ]
        );
        
        $repeater->add_control(
            'plan_is_pro',
            [
                'label' => __('Mark as Pro/Featured', 'aiqengage-child'),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => __('Yes', 'aiqengage-child'),
                'label_off' => __('No', 'aiqengage-child'),
                'default' => '',
                'description' => __('Adds special styling and emphasis', 'aiqengage-child'),
            ]
        );
        
        $repeater->add_control(
            'plan_color',
            [
                'label' => __('Accent Color', 'aiqengage-child'),
                'type' => Controls_Manager::COLOR,
                'default' => '#9C4DFF',
                'selectors' => [
                    '{{WRAPPER}} {{CURRENT_ITEM}}' => '--plan-accent: {{VALUE}};',
                ],
            ]
        );
        
        $repeater->add_control(
            'plan_cta_label',
            [
                'label' => __('CTA Button Label', 'aiqengage-child'),
                'type' => Controls_Manager::TEXT,
                'default' => __('Get Started', 'aiqengage-child'),
            ]
        );
        
        $repeater->add_control(
            'plan_cta_url',
            [
                'label' => __('CTA Button Link', 'aiqengage-child'),
                'type' => Controls_Manager::URL,
                'placeholder' => 'https://aiqengage.com/checkout',
                'default' => [
                    'url' => '#',
                ],
            ]
        );

        $this->add_control(
            'plans',
            [
                'label' => __('Pricing Plans', 'aiqengage-child'),
                'type' => Controls_Manager::REPEATER,
                'fields' => $repeater->get_controls(),
                'default' => [
                    [
                        'plan_title' => __('Starter', 'aiqengage-child'),
                        'plan_price' => __('$29/mo', 'aiqengage-child'),
                        'plan_alt_price' => __('$299', 'aiqengage-child'),
                        'plan_description' => __('For beginners getting started', 'aiqengage-child'),
                        'plan_features' => "25+ Basic Prompts\nMonthly Updates\nEmail Support",
                        'plan_cta_label' => __('Get Started', 'aiqengage-child'),
                    ],
                    [
                        'plan_title' => __('Pro', 'aiqengage-child'),
                        'plan_price' => __('$49/mo', 'aiqengage-child'),
                        'plan_alt_price' => __('$499', 'aiqengage-child'),
                        'plan_description' => __('Perfect for solo entrepreneurs', 'aiqengage-child'),
                        'plan_features' => "50+ Conversion Prompts\nWeekly Updates\nCommunity Access\nPriority Support",
                        'plan_badge' => __('Popular', 'aiqengage-child'),
                        'plan_is_pro' => 'yes',
                        'plan_cta_label' => __('Get Pro', 'aiqengage-child'),
                    ],
                    [
                        'plan_title' => __('Agency', 'aiqengage-child'),
                        'plan_price' => __('$99/mo', 'aiqengage-child'),
                        'plan_alt_price' => __('$999', 'aiqengage-child'),
                        'plan_description' => __('For teams and client work', 'aiqengage-child'),
                        'plan_features' => "100+ Advanced Prompts\nClient Use Rights\nWhite Label Option\nDedicated Support\nCustom Prompts",
                        'plan_cta_label' => __('Get Agency', 'aiqengage-child'),
                    ],
                ],
                'title_field' => '{{{ plan_title }}}',
            ]
        );
        
        $this->end_controls_section();

        // Style Section
        $this->start_controls_section(
            'section_style',
            [
                'label' => __('Style', 'aiqengage-child'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );
        
        $this->add_control(
            'heading_container',
            [
                'label' => __('Container', 'aiqengage-child'),
                'type' => Controls_Manager::HEADING,
            ]
        );
        
        $this->add_control(
            'alignment',
            [
                'label' => __('Alignment', 'aiqengage-child'),
                'type' => Controls_Manager::CHOOSE,
                'options' => [
                    'flex-start' => [
                        'title' => __('Left', 'aiqengage-child'),
                        'icon' => 'eicon-text-align-left',
                    ],
                    'center' => [
                        'title' => __('Center', 'aiqengage-child'),
                        'icon' => 'eicon-text-align-center',
                    ],
                    'flex-end' => [
                        'title' => __('Right', 'aiqengage-child'),
                        'icon' => 'eicon-text-align-right',
                    ],
                ],
                'default' => 'center',
                'selectors' => [
                    '{{WRAPPER}} .aiq-pricing-table' => 'justify-content: {{VALUE}};',
                ],
            ]
        );
        
        $this->add_control(
            'heading_title',
            [
                'label' => __('Title', 'aiqengage-child'),
                'type' => Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );
        
        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'title_typography',
                'selector' => '{{WRAPPER}} .aiq-pricing-table__title',
            ]
        );
        
        $this->add_control(
            'heading_price',
            [
                'label' => __('Price', 'aiqengage-child'),
                'type' => Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );
        
        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'price_typography',
                'selector' => '{{WRAPPER}} .aiq-pricing-table__price',
            ]
        );
        
        $this->add_control(
            'heading_features',
            [
                'label' => __('Features', 'aiqengage-child'),
                'type' => Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );
        
        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'features_typography',
                'selector' => '{{WRAPPER}} .aiq-pricing-table__features li',
            ]
        );
        
        $this->add_control(
            'heading_button',
            [
                'label' => __('Button', 'aiqengage-child'),
                'type' => Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );
        
        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'button_typography',
                'selector' => '{{WRAPPER}} .aiq-pricing-table__cta',
            ]
        );
        
        $this->end_controls_section();
    }

    /**
     * Render widget output on the frontend
     */
    protected function render() {
        $settings = $this->get_settings_for_display();
        if (empty($settings['plans'])) return;
        
        // Toggle functionality
        $toggle_class = $settings['show_toggle'] ? ' has-toggle' : '';
        ?>
        <div class="aiq-pricing-table<?php echo esc_attr($toggle_class); ?>">
            <?php if ($settings['show_toggle']) : ?>
            <div class="aiq-pricing-table__toggle-container">
                <div class="aiq-pricing-table__toggle">
                    <span class="aiq-pricing-table__toggle-text toggle-left active"><?php echo esc_html($settings['toggle_left_text']); ?></span>
                    <label class="aiq-pricing-table__toggle-switch">
                        <input type="checkbox" class="aiq-pricing-table__toggle-input">
                        <span class="aiq-pricing-table__toggle-slider"></span>
                    </label>
                    <span class="aiq-pricing-table__toggle-text toggle-right"><?php echo esc_html($settings['toggle_right_text']); ?></span>
                </div>
            </div>
            <?php endif; ?>
            
            <div class="aiq-pricing-table__row" role="rowgroup">
                <?php foreach ($settings['plans'] as $index => $plan) : 
                    $pro_class = !empty($plan['plan_is_pro']) ? ' is-pro' : '';
                    $this_item_class = 'elementor-repeater-item-' . $plan['_id'] . $pro_class;
                    $badge = !empty($plan['plan_badge']) ? '<div class="aiq-pricing-table__badge">' . esc_html($plan['plan_badge']) . '</div>' : '';
                    
                    // CTA link
                    $target = !empty($plan['plan_cta_url']['is_external']) ? ' target="_blank"' : '';
                    $nofollow = !empty($plan['plan_cta_url']['nofollow']) ? ' rel="nofollow"' : '';
                    $url = !empty($plan['plan_cta_url']['url']) ? $plan['plan_cta_url']['url'] : '#';
                    
                    // Pro marker
                    $pro_marker = !empty($plan['plan_is_pro']) ? '<span class="aiq-pricing-table__pro-marker">🔒</span>' : '';
                ?>
                <div class="aiq-pricing-table__col <?php echo esc_attr($this_item_class); ?>" role="cell">
                    <?php echo $badge; ?>
                    <?php echo $pro_marker; ?>
                    
                    <div class="aiq-pricing-table__title"><?php echo esc_html($plan['plan_title']); ?></div>
                    
                    <div class="aiq-pricing-table__price price-main"><?php echo esc_html($plan['plan_price']); ?></div>
                    
                    <?php if ($settings['show_toggle'] && !empty($plan['plan_alt_price'])) : ?>
                    <div class="aiq-pricing-table__price price-alt" style="display: none;"><?php echo esc_html($plan['plan_alt_price']); ?></div>
                    <?php endif; ?>
                    
                    <?php if (!empty($plan['plan_description'])) : ?>
                    <div class="aiq-pricing-table__description"><?php echo esc_html($plan['plan_description']); ?></div>
                    <?php endif; ?>
                    
                    <ul class="aiq-pricing-table__features">
                        <?php foreach (explode("\n", $plan['plan_features']) as $feature) : ?>
                        <li><?php echo esc_html(trim($feature)); ?></li>
                        <?php endforeach; ?>
                    </ul>
                    
                    <a href="<?php echo esc_url($url); ?>" class="aiq-pricing-table__cta"<?php echo $target . $nofollow; ?>>
                        <?php echo esc_html($plan['plan_cta_label']); ?>
                    </a>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
        
        <?php if ($settings['show_toggle']) : ?>
        <script>
        document.addEventListener('DOMContentLoaded', function() {
            const toggleInput = document.querySelector('.aiq-pricing-table__toggle-input');
            const toggleLeftText = document.querySelector('.aiq-pricing-table__toggle-text.toggle-left');
            const toggleRightText = document.querySelector('.aiq-pricing-table__toggle-text.toggle-right');
            const mainPrices = document.querySelectorAll('.aiq-pricing-table__price.price-main');
            const altPrices = document.querySelectorAll('.aiq-pricing-table__price.price-alt');
            
            toggleInput.addEventListener('change', function() {
                if (this.checked) {
                    toggleLeftText.classList.remove('active');
                    toggleRightText.classList.add('active');
                    mainPrices.forEach(price => price.style.display = 'none');
                    altPrices.forEach(price => price.style.display = 'block');
                } else {
                    toggleLeftText.classList.add('active');
                    toggleRightText.classList.remove('active');
                    mainPrices.forEach(price => price.style.display = 'block');
                    altPrices.forEach(price => price.style.display = 'none');
                }
            });
        });
        </script>
        <?php endif; ?>
        <?php
    }

    /**
     * Get style dependencies
     * @return array Style dependencies
     */
    public function get_style_depends() { 
        return ['aiq-widget-pricing-table']; 
    }
}
