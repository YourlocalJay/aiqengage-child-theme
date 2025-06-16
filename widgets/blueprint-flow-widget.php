<?php
/**
 * Blueprint Flow Widget for AIQEngage
 * 
 * @package AIQEngage-Child
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

/**
 * Blueprint Flow Widget
 * Displays interactive workflow diagrams in AIQEngage brand style
 */
class AIQEngage_Blueprint_Flow_Widget extends \Elementor\Widget_Base {

    public function get_name() {
        return 'aiqengage-blueprint-flow';
    }

    public function get_title() {
        return __('AIQ Blueprint Flow', 'aiqengage');
    }

    public function get_icon() {
        return 'eicon-flow';
    }

    public function get_categories() {
        return ['aiqengage-elements'];
    }

    protected function register_controls() {
        // Content Tab
        $this->start_controls_section(
            'content_section',
            [
                'label' => __('Content', 'aiqengage'),
                'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'blueprint_title',
            [
                'label' => __('Blueprint Title', 'aiqengage'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => __('Reddit-to-Revenue Automation System', 'aiqengage'),
            ]
        );

        $this->add_control(
            'blueprint_description',
            [
                'label' => __('Description', 'aiqengage'),
                'type' => \Elementor\Controls_Manager::TEXTAREA,
                'default' => __('Complete system that generates $500-5000/month with minimal management', 'aiqengage'),
                'rows' => 3,
            ]
        );

        $this->add_control(
            'flow_content',
            [
                'label' => __('Flow Diagram Content', 'aiqengage'),
                'type' => \Elementor\Controls_Manager::TEXTAREA,
                'default' => "┌─────────────────┐     ┌──────────────────┐     ┌─────────────────┐\n│ REDDIT COMMENT  │ ──► │  VAULT OPT-IN    │ ──► │  EMAIL SERIES   │\n│ • Find rising   │     │ • Landing page   │     │ • Welcome+PDF   │\n│ • Add value     │     │ • Lead magnet    │     │ • Value emails  │\n│ • Soft mention  │     │ • Email capture  │     │ • Soft pitches  │\n└─────────────────┘     └──────────────────┘     └─────────────────┘\n         │                       │                         │\n         ▼                       ▼                         ▼\n    127 clicks              67 signups               31% open rate\n                                                           │\n                                                           ▼\n                                              ┌─────────────────────┐\n                                              │   AFFILIATE CTA     │\n                                              │ • Product reviews   │\n                                              │ • Limited offers    │\n                                              │ • Recurring comm    │\n                                              └─────────────────────┘\n                                                           │\n                                                           ▼\n                                                    $517.40 / 5 days",
                'rows' => 15,
            ]
        );

        $repeater = new \Elementor\Repeater();

        $repeater->add_control(
            'node_title',
            [
                'label' => __('Node Title', 'aiqengage'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => __('Reddit Comment', 'aiqengage'),
            ]
        );

        $repeater->add_control(
            'node_description',
            [
                'label' => __('Node Description', 'aiqengage'),
                'type' => \Elementor\Controls_Manager::TEXTAREA,
                'default' => __('Find rising posts, add value, soft mention', 'aiqengage'),
                'rows' => 3,
            ]
        );

        $repeater->add_control(
            'node_metric',
            [
                'label' => __('Node Metric', 'aiqengage'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => __('127 clicks', 'aiqengage'),
            ]
        );

        $repeater->add_control(
            'node_color',
            [
                'label' => __('Node Color', 'aiqengage'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#2A1958',
            ]
        );

        $this->add_control(
            'interactive_nodes',
            [
                'label' => __('Interactive Nodes', 'aiqengage'),
                'type' => \Elementor\Controls_Manager::REPEATER,
                'fields' => $repeater->get_controls(),
                'title_field' => '{{{ node_title }}}',
                'default' => [
                    [
                        'node_title' => __('Reddit Comment', 'aiqengage'),
                        'node_description' => __('Find rising posts, add value, soft mention', 'aiqengage'),
                        'node_metric' => __('127 clicks', 'aiqengage'),
                    ],
                    [
                        'node_title' => __('Vault Opt-In', 'aiqengage'),
                        'node_description' => __('Landing page, lead magnet, email capture', 'aiqengage'),
                        'node_metric' => __('67 signups', 'aiqengage'),
                    ],
                    [
                        'node_title' => __('Email Series', 'aiqengage'),
                        'node_description' => __('Welcome+PDF, value emails, soft pitches', 'aiqengage'),
                        'node_metric' => __('31% open rate', 'aiqengage'),
                    ],
                    [
                        'node_title' => __('Affiliate CTA', 'aiqengage'),
                        'node_description' => __('Product reviews, limited offers, recurring comm', 'aiqengage'),
                        'node_metric' => __('$517.40 / 5 days', 'aiqengage'),
                    ],
                ],
            ]
        );

        $this->add_control(
            'show_roi_calculator',
            [
                'label' => __('Show ROI Calculator', 'aiqengage'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => __('Yes', 'aiqengage'),
                'label_off' => __('No', 'aiqengage'),
                'return_value' => 'yes',
                'default' => 'yes',
            ]
        );

        $this->end_controls_section();

        // Style Tab
        $this->start_controls_section(
            'style_section',
            [
                'label' => __('Style', 'aiqengage'),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'diagram_bg_color',
            [
                'label' => __('Diagram Background', 'aiqengage'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#1A0938',
                'selectors' => [
                    '{{WRAPPER}} .blueprint-flow-diagram' => 'background-color: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'diagram_text_color',
            [
                'label' => __('Diagram Text', 'aiqengage'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#E0D6FF',
                'selectors' => [
                    '{{WRAPPER}} .blueprint-flow-diagram pre' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'node_border_color',
            [
                'label' => __('Node Border Color', 'aiqengage'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => 'rgba(156, 77, 255, 0.3)',
                'selectors' => [
                    '{{WRAPPER}} .interactive-node' => 'border-color: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'node_title_color',
            [
                'label' => __('Node Title Color', 'aiqengage'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#9C4DFF',
                'selectors' => [
                    '{{WRAPPER}} .node-title' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'node_text_color',
            [
                'label' => __('Node Text Color', 'aiqengage'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#E0D6FF',
                'selectors' => [
                    '{{WRAPPER}} .node-description' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'metric_color',
            [
                'label' => __('Metric Color', 'aiqengage'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#7F5AF0',
                'selectors' => [
                    '{{WRAPPER}} .node-metric' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'diagram_border_radius',
            [
                'label' => __('Diagram Border Radius', 'aiqengage'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px'],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 50,
                        'step' => 1,
                    ],
                ],
                'default' => [
                    'unit' => 'px',
                    'size' => 15,
                ],
                'selectors' => [
                    '{{WRAPPER}} .blueprint-flow-diagram' => 'border-radius: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'diagram_padding',
            [
                'label' => __('Diagram Padding', 'aiqengage'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'default' => [
                    'top' => 1.5,
                    'right' => 1.5,
                    'bottom' => 1.5,
                    'left' => 1.5,
                    'unit' => 'rem',
                    'isLinked' => true,
                ],
                'selectors' => [
                    '{{WRAPPER}} .blueprint-flow-diagram' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'diagram_box_shadow',
                'label' => __('Diagram Box Shadow', 'aiqengage'),
                'selector' => '{{WRAPPER}} .blueprint-flow-diagram',
            ]
        );

        $this->end_controls_section();
        
        // Calculator Tab
        $this->start_controls_section(
            'calculator_section',
            [
                'label' => __('ROI Calculator', 'aiqengage'),
                'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
                'condition' => [
                    'show_roi_calculator' => 'yes',
                ],
            ]
        );

        $this->add_control(
            'calculator_title',
            [
                'label' => __('Calculator Title', 'aiqengage'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => __('Simulate Your Results', 'aiqengage'),
            ]
        );

        $this->add_control(
            'traffic_label',
            [
                'label' => __('Traffic Input Label', 'aiqengage'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => __('Monthly Traffic', 'aiqengage'),
            ]
        );

        $this->add_control(
            'conversion_label',
            [
                'label' => __('Conversion Rate Label', 'aiqengage'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => __('Conversion Rate (%)', 'aiqengage'),
            ]
        );

        $this->add_control(
            'revenue_label',
            [
                'label' => __('Revenue Label', 'aiqengage'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => __('Average Revenue per Customer ($)', 'aiqengage'),
            ]
        );

        $this->add_control(
            'default_traffic',
            [
                'label' => __('Default Traffic Value', 'aiqengage'),
                'type' => \Elementor\Controls_Manager::NUMBER,
                'default' => 1000,
                'min' => 0,
                'max' => 100000,
                'step' => 100,
            ]
        );

        $this->add_control(
            'default_conversion',
            [
                'label' => __('Default Conversion Rate', 'aiqengage'),
                'type' => \Elementor\Controls_Manager::NUMBER,
                'default' => 3,
                'min' => 0,
                'max' => 100,
                'step' => 0.1,
            ]
        );

        $this->add_control(
            'default_revenue',
            [
                'label' => __('Default Revenue Value', 'aiqengage'),
                'type' => \Elementor\Controls_Manager::NUMBER,
                'default' => 30,
                'min' => 0,
                'max' => 10000,
                'step' => 1,
            ]
        );

        $this->add_control(
            'calculator_description',
            [
                'label' => __('Calculator Description', 'aiqengage'),
                'type' => \Elementor\Controls_Manager::TEXTAREA,
                'default' => __('Adjust the values below to estimate potential revenue from this automation system.', 'aiqengage'),
                'rows' => 3,
            ]
        );

        $this->end_controls_section();
    }

    protected function render() {
        $settings = $this->get_settings_for_display();
        $show_roi_calculator = $settings['show_roi_calculator'] === 'yes';
        $widget_id = $this->get_id();
        ?>
        <div class="blueprint-flow-container">
            <h2 class="blueprint-title"><?php echo esc_html($settings['blueprint_title']); ?></h2>
            <p class="blueprint-description"><?php echo esc_html($settings['blueprint_description']); ?></p>
            
            <div class="blueprint-flow-diagram">
                <pre><?php echo esc_html($settings['flow_content']); ?></pre>
            </div>
            
            <?php if (!empty($settings['interactive_nodes'])): ?>
            <div class="interactive-nodes">
                <?php foreach ($settings['interactive_nodes'] as $index => $node): ?>
                <div class="interactive-node" data-node-index="<?php echo esc_attr($index); ?>" 
                     style="background-color: <?php echo esc_attr($node['node_color']); ?>">
                    <h3 class="node-title"><?php echo esc_html($node['node_title']); ?></h3>
                    <p class="node-description"><?php echo esc_html($node['node_description']); ?></p>
                    <div class="node-metric"><?php echo esc_html($node['node_metric']); ?></div>
                </div>
                <?php endforeach; ?>
            </div>
            <?php endif; ?>
            
            <?php if ($show_roi_calculator): ?>
            <div class="roi-calculator" id="roi-calculator-<?php echo esc_attr($widget_id); ?>">
                <h3><?php echo esc_html($settings['calculator_title']); ?></h3>
                <p><?php echo esc_html($settings['calculator_description']); ?></p>
                
                <div class="calculator-inputs">
                    <div class="input-group">
                        <label for="traffic-input-<?php echo esc_attr($widget_id); ?>"><?php echo esc_html($settings['traffic_label']); ?></label>
                        <input type="number" id="traffic-input-<?php echo esc_attr($widget_id); ?>" 
                               min="0" step="100" value="<?php echo esc_attr($settings['default_traffic']); ?>">
                    </div>
                    
                    <div class="input-group">
                        <label for="conversion-input-<?php echo esc_attr($widget_id); ?>"><?php echo esc_html($settings['conversion_label']); ?></label>
                        <input type="number" id="conversion-input-<?php echo esc_attr($widget_id); ?>" 
                               min="0" max="100" step="0.1" value="<?php echo esc_attr($settings['default_conversion']); ?>">
                    </div>
                    
                    <div class="input-group">
                        <label for="revenue-input-<?php echo esc_attr($widget_id); ?>"><?php echo esc_html($settings['revenue_label']); ?></label>
                        <input type="number" id="revenue-input-<?php echo esc_attr($widget_id); ?>" 
                               min="0" step="1" value="<?php echo esc_attr($settings['default_revenue']); ?>">
                    </div>
                </div>
                
                <div class="calculator-results">
                    <div class="result-card">
                        <div class="result-label">Monthly Customers</div>
                        <div class="result-value" id="customers-result-<?php echo esc_attr($widget_id); ?>">0</div>
                    </div>
                    
                    <div class="result-card">
                        <div class="result-label">Monthly Revenue</div>
                        <div class="result-value" id="revenue-result-<?php echo esc_attr($widget_id); ?>">$0</div>
                    </div>
                    
                    <div class="result-card">
                        <div class="result-label">Annual Revenue</div>
                        <div class="result-value" id="annual-result-<?php echo esc_attr($widget_id); ?>">$0</div>
                    </div>
                </div>
            </div>
            
            <script>
                jQuery(document).ready(function($) {
                    const widgetId = '<?php echo esc_js($widget_id); ?>';
                    const $trafficInput = $('#traffic-input-' + widgetId);
                    const $conversionInput = $('#conversion-input-' + widgetId);
                    const $revenueInput = $('#revenue-input-' + widgetId);
                    const $customersResult = $('#customers-result-' + widgetId);
                    const $revenueResult = $('#revenue-result-' + widgetId);
                    const $annualResult = $('#annual-result-' + widgetId);
                    
                    function calculateROI() {
                        const traffic = parseFloat($trafficInput.val()) || 0;
                        const conversionRate = parseFloat($conversionInput.val()) || 0;
                        const revenue = parseFloat($revenueInput.val()) || 0;
                        
                        const customers = Math.round(traffic * (conversionRate / 100));
                        const monthlyRevenue = customers * revenue;
                        const annualRevenue = monthlyRevenue * 12;
                        
                        $customersResult.text(customers);
                        $revenueResult.text('$' + monthlyRevenue.toLocaleString('en-US', {maximumFractionDigits: 2}));
                        $annualResult.text('$' + annualRevenue.toLocaleString('en-US', {maximumFractionDigits: 2}));
                    }
                    
                    // Calculate initial values
                    calculateROI();
                    
                    // Recalculate on input change
                    $trafficInput.on('input', calculateROI);
                    $conversionInput.on('input', calculateROI);
                    $revenueInput.on('input', calculateROI);
                    
                    // Make nodes interactive
                    $('.interactive-node').on('click', function() {
                        $('.interactive-node').removeClass('active');
                        $(this).addClass('active');
                    });
                });
            </script>
            <?php endif; ?>
        </div>
        <?php
    }
}

// Register widget if not already registered
if (!function_exists('register_blueprint_flow_widget')) {
    function register_blueprint_flow_widget($widgets_manager) {
        $widgets_manager->register(new AIQEngage_Blueprint_Flow_Widget());
    }
    add_action('elementor/widgets/register', 'register_blueprint_flow_widget');
}
