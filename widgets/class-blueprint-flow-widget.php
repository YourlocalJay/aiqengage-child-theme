<?php
/**
 * Blueprint Flow Widget
 *
 * @package AIQEngage
 */

namespace AIQEngage\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Repeater;
use Elementor\Utils;

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

/**
 * Blueprint Flow Widget.
 */
class Blueprint_Flow_Widget extends Widget_Base {

    /**
     * Get widget name.
     *
     * @return string Widget name.
     */
    public function get_name() {
        return 'aiq_blueprint_flow';
    }

    /**
     * Get widget title.
     *
     * @return string Widget title.
     */
    public function get_title() {
        return esc_html__('Blueprint Flow', 'aiqengage-child');
    }

    /**
     * Get widget icon.
     *
     * @return string Widget icon.
     */
    public function get_icon() {
        return 'eicon-flow';
    }

    /**
     * Get widget keywords.
     *
     * @return array Widget keywords.
     */
    public function get_keywords() {
        return ['blueprint', 'flow', 'diagram', 'process', 'automation', 'node'];
    }

    /**
     * Get widget categories.
     *
     * @return array Widget categories.
     */
    public function get_categories() {
        return ['aiqengage'];
    }

    /**
     * Register widget controls.
     */
    protected function register_controls() {
        $this->start_controls_section(
            'section_content',
            [
                'label' => esc_html__('Blueprint Flow', 'aiqengage-child'),
                'tab' => Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'flow_title',
            [
                'label' => esc_html__('Flow Title', 'aiqengage-child'),
                'type' => Controls_Manager::TEXT,
                'default' => esc_html__('Automation Blueprint', 'aiqengage-child'),
                'label_block' => true,
            ]
        );

        $this->add_control(
            'flow_description',
            [
                'label' => esc_html__('Flow Description', 'aiqengage-child'),
                'type' => Controls_Manager::TEXTAREA,
                'default' => esc_html__('Complete process flow for your automation system.', 'aiqengage-child'),
                'label_block' => true,
            ]
        );

        $this->add_control(
            'flow_type',
            [
                'label' => esc_html__('Flow Type', 'aiqengage-child'),
                'type' => Controls_Manager::SELECT,
                'default' => 'flowchart',
                'options' => [
                    'flowchart' => esc_html__('Flowchart', 'aiqengage-child'),
                    'grid' => esc_html__('Grid', 'aiqengage-child'),
                    'timeline' => esc_html__('Timeline', 'aiqengage-child'),
                ],
            ]
        );

        $this->add_control(
            'flow_direction',
            [
                'label' => esc_html__('Flow Direction', 'aiqengage-child'),
                'type' => Controls_Manager::SELECT,
                'default' => 'horizontal',
                'options' => [
                    'horizontal' => esc_html__('Horizontal', 'aiqengage-child'),
                    'vertical' => esc_html__('Vertical', 'aiqengage-child'),
                ],
            ]
        );

        $this->add_control(
            'show_connectors',
            [
                'label' => esc_html__('Show Connectors', 'aiqengage-child'),
                'type' => Controls_Manager::SWITCHER,
                'default' => 'yes',
                'label_on' => esc_html__('Yes', 'aiqengage-child'),
                'label_off' => esc_html__('No', 'aiqengage-child'),
            ]
        );

        $this->add_control(
            'connector_style',
            [
                'label' => esc_html__('Connector Style', 'aiqengage-child'),
                'type' => Controls_Manager::SELECT,
                'default' => 'line',
                'options' => [
                    'line' => esc_html__('Line', 'aiqengage-child'),
                    'arrow' => esc_html__('Arrow', 'aiqengage-child'),
                    'dashed' => esc_html__('Dashed Line', 'aiqengage-child'),
                    'dotted' => esc_html__('Dotted Line', 'aiqengage-child'),
                ],
                'condition' => [
                    'show_connectors' => 'yes',
                ],
            ]
        );

        $repeater = new Repeater();

        $repeater->add_control(
            'node_title',
            [
                'label' => esc_html__('Node Title', 'aiqengage-child'),
                'type' => Controls_Manager::TEXT,
                'default' => esc_html__('Process Step', 'aiqengage-child'),
                'label_block' => true,
            ]
        );

        $repeater->add_control(
            'node_description',
            [
                'label' => esc_html__('Node Description', 'aiqengage-child'),
                'type' => Controls_Manager::TEXTAREA,
                'default' => esc_html__('Description of this step in the process.', 'aiqengage-child'),
                'label_block' => true,
            ]
        );

        $repeater->add_control(
            'node_icon_type',
            [
                'label' => esc_html__('Icon Type', 'aiqengage-child'),
                'type' => Controls_Manager::CHOOSE,
                'options' => [
                    'icon' => [
                        'title' => esc_html__('Icon', 'aiqengage-child'),
                        'icon' => 'eicon-star',
                    ],
                    'image' => [
                        'title' => esc_html__('Image', 'aiqengage-child'),
                        'icon' => 'eicon-image',
                    ],
                    'none' => [
                        'title' => esc_html__('None', 'aiqengage-child'),
                        'icon' => 'eicon-ban',
                    ],
                ],
                'default' => 'icon',
            ]
        );

        $repeater->add_control(
            'node_icon',
            [
                'label' => esc_html__('Icon', 'aiqengage-child'),
                'type' => Controls_Manager::ICONS,
                'default' => [
                    'value' => 'fas fa-star',
                    'library' => 'fa-solid',
                ],
                'condition' => [
                    'node_icon_type' => 'icon',
                ],
            ]
        );

        $repeater->add_control(
            'node_image',
            [
                'label' => esc_html__('Image', 'aiqengage-child'),
                'type' => Controls_Manager::MEDIA,
                'default' => [
                    'url' => Utils::get_placeholder_image_src(),
                ],
                'condition' => [
                    'node_icon_type' => 'image',
                ],
            ]
        );

        $repeater->add_control(
            'node_accent_color',
            [
                'label' => esc_html__('Accent Color', 'aiqengage-child'),
                'type' => Controls_Manager::COLOR,
                'default' => '#9C4DFF',
            ]
        );

        $repeater->add_control(
            'node_callout',
            [
                'label' => esc_html__('Callout Badge', 'aiqengage-child'),
                'type' => Controls_Manager::SELECT,
                'default' => 'none',
                'options' => [
                    'none' => esc_html__('None', 'aiqengage-child'),
                    'pro-tip' => esc_html__('Pro Tip', 'aiqengage-child'),
                    'automated' => esc_html__('Automated Step', 'aiqengage-child'),
                    'manual' => esc_html__('Manual Step', 'aiqengage-child'),
                    'critical' => esc_html__('Critical Step', 'aiqengage-child'),
                ],
            ]
        );

        $repeater->add_control(
            'node_metric',
            [
                'label' => esc_html__('Metric Label', 'aiqengage-child'),
                'type' => Controls_Manager::TEXT,
                'default' => '',
                'label_block' => true,
                'placeholder' => esc_html__('e.g. 27% conversion rate', 'aiqengage-child'),
            ]
        );

        $this->add_control(
            'nodes',
            [
                'label' => esc_html__('Flow Nodes', 'aiqengage-child'),
                'type' => Controls_Manager::REPEATER,
                'fields' => $repeater->get_controls(),
                'default' => [
                    [
                        'node_title' => esc_html__('Step 1: Research', 'aiqengage-child'),
                        'node_description' => esc_html__('Identify target audience and pain points.', 'aiqengage-child'),
                        'node_icon_type' => 'icon',
                        'node_icon' => [
                            'value' => 'fas fa-search',
                            'library' => 'fa-solid',
                        ],
                        'node_accent_color' => '#635BFF',
                        'node_callout' => 'none',
                    ],
                    [
                        'node_title' => esc_html__('Step 2: Content Creation', 'aiqengage-child'),
                        'node_description' => esc_html__('Generate AI-powered content at scale.', 'aiqengage-child'),
                        'node_icon_type' => 'icon',
                        'node_icon' => [
                            'value' => 'fas fa-edit',
                            'library' => 'fa-solid',
                        ],
                        'node_accent_color' => '#7F5AF0',
                        'node_callout' => 'automated',
                        'node_metric' => '5X faster creation',
                    ],
                    [
                        'node_title' => esc_html__('Step 3: Distribution', 'aiqengage-child'),
                        'node_description' => esc_html__('Automated publishing to multiple platforms.', 'aiqengage-child'),
                        'node_icon_type' => 'icon',
                        'node_icon' => [
                            'value' => 'fas fa-share-alt',
                            'library' => 'fa-solid',
                        ],
                        'node_accent_color' => '#8E6BFF',
                        'node_callout' => 'pro-tip',
                        'node_metric' => '72% wider reach',
                    ],
                ],
                'title_field' => '{{{ node_title }}}',
            ]
        );

        $this->end_controls_section();

        // ROI Calculator Section
        $this->start_controls_section(
            'section_roi_calculator',
            [
                'label' => esc_html__('ROI Calculator', 'aiqengage-child'),
                'tab' => Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'show_roi_calculator',
            [
                'label' => esc_html__('Show ROI Calculator', 'aiqengage-child'),
                'type' => Controls_Manager::SWITCHER,
                'default' => 'no',
                'label_on' => esc_html__('Yes', 'aiqengage-child'),
                'label_off' => esc_html__('No', 'aiqengage-child'),
            ]
        );

        $this->add_control(
            'roi_title',
            [
                'label' => esc_html__('Calculator Title', 'aiqengage-child'),
                'type' => Controls_Manager::TEXT,
                'default' => esc_html__('Calculate Your ROI', 'aiqengage-child'),
                'condition' => [
                    'show_roi_calculator' => 'yes',
                ],
            ]
        );

        $this->add_control(
            'roi_description',
            [
                'label' => esc_html__('Calculator Description', 'aiqengage-child'),
                'type' => Controls_Manager::TEXTAREA,
                'default' => esc_html__('Adjust the values below to see potential returns.', 'aiqengage-child'),
                'condition' => [
                    'show_roi_calculator' => 'yes',
                ],
            ]
        );

        $roi_fields_repeater = new Repeater();

        $roi_fields_repeater->add_control(
            'field_label',
            [
                'label' => esc_html__('Field Label', 'aiqengage-child'),
                'type' => Controls_Manager::TEXT,
                'default' => esc_html__('Input Value', 'aiqengage-child'),
            ]
        );

        $roi_fields_repeater->add_control(
            'field_type',
            [
                'label' => esc_html__('Field Type', 'aiqengage-child'),
                'type' => Controls_Manager::SELECT,
                'default' => 'number',
                'options' => [
                    'number' => esc_html__('Number', 'aiqengage-child'),
                    'slider' => esc_html__('Slider', 'aiqengage-child'),
                    'percentage' => esc_html__('Percentage', 'aiqengage-child'),
                ],
            ]
        );

        $roi_fields_repeater->add_control(
            'field_default',
            [
                'label' => esc_html__('Default Value', 'aiqengage-child'),
                'type' => Controls_Manager::NUMBER,
                'default' => 10,
            ]
        );

        $roi_fields_repeater->add_control(
            'field_min',
            [
                'label' => esc_html__('Minimum Value', 'aiqengage-child'),
                'type' => Controls_Manager::NUMBER,
                'default' => 0,
                'condition' => [
                    'field_type' => ['slider', 'percentage'],
                ],
            ]
        );

        $roi_fields_repeater->add_control(
            'field_max',
            [
                'label' => esc_html__('Maximum Value', 'aiqengage-child'),
                'type' => Controls_Manager::NUMBER,
                'default' => 100,
                'condition' => [
                    'field_type' => ['slider', 'percentage'],
                ],
            ]
        );

        $roi_fields_repeater->add_control(
            'field_step',
            [
                'label' => esc_html__('Step', 'aiqengage-child'),
                'type' => Controls_Manager::NUMBER,
                'default' => 1,
                'min' => 0.1,
                'step' => 0.1,
                'condition' => [
                    'field_type' => ['slider', 'percentage'],
                ],
            ]
        );

        $this->add_control(
            'roi_fields',
            [
                'label' => esc_html__('Calculator Fields', 'aiqengage-child'),
                'type' => Controls_Manager::REPEATER,
                'fields' => $roi_fields_repeater->get_controls(),
                'default' => [
                    [
                        'field_label' => esc_html__('Monthly Traffic', 'aiqengage-child'),
                        'field_type' => 'number',
                        'field_default' => 1000,
                    ],
                    [
                        'field_label' => esc_html__('Conversion Rate (%)', 'aiqengage-child'),
                        'field_type' => 'percentage',
                        'field_default' => 3,
                        'field_min' => 0,
                        'field_max' => 100,
                        'field_step' => 0.1,
                    ],
                    [
                        'field_label' => esc_html__('Average Order Value ($)', 'aiqengage-child'),
                        'field_type' => 'number',
                        'field_default' => 50,
                    ],
                ],
                'title_field' => '{{{ field_label }}}',
                'condition' => [
                    'show_roi_calculator' => 'yes',
                ],
            ]
        );

        $this->add_control(
            'roi_formula',
            [
                'label' => esc_html__('ROI Formula', 'aiqengage-child'),
                'type' => Controls_Manager::SELECT,
                'default' => 'traffic_conversion_value',
                'options' => [
                    'traffic_conversion_value' => esc_html__('Traffic × Conversion × Value', 'aiqengage-child'),
                    'custom' => esc_html__('Custom Formula', 'aiqengage-child'),
                ],
                'condition' => [
                    'show_roi_calculator' => 'yes',
                ],
            ]
        );

        $this->add_control(
            'roi_custom_formula',
            [
                'label' => esc_html__('Custom Formula JavaScript', 'aiqengage-child'),
                'type' => Controls_Manager::CODE,
                'language' => 'javascript',
                'rows' => 10,
                'default' => "// Access field values using fieldValues array\n// Return the calculated ROI\nreturn fieldValues[0] * (fieldValues[1] / 100) * fieldValues[2];",
                'condition' => [
                    'show_roi_calculator' => 'yes',
                    'roi_formula' => 'custom',
                ],
            ]
        );

        $this->end_controls_section();

        // Style Section - General
        $this->start_controls_section(
            'section_style_general',
            [
                'label' => esc_html__('General', 'aiqengage-child'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'flow_accent_color',
            [
                'label' => esc_html__('Flow Accent Color', 'aiqengage-child'),
                'type' => Controls_Manager::COLOR,
                'default' => '#9C4DFF',
                'selectors' => [
                    '{{WRAPPER}} .aiq-blueprint-flow' => '--flow-accent-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'flow_background_color',
            [
                'label' => esc_html__('Flow Background Color', 'aiqengage-child'),
                'type' => Controls_Manager::COLOR,
                'default' => '#2A1958',
                'selectors' => [
                    '{{WRAPPER}} .aiq-blueprint-flow' => '--flow-background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'flow_text_color',
            [
                'label' => esc_html__('Flow Text Color', 'aiqengage-child'),
                'type' => Controls_Manager::COLOR,
                'default' => '#E0D6FF',
                'selectors' => [
                    '{{WRAPPER}} .aiq-blueprint-flow' => '--flow-text-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'flow_typography',
                'label' => esc_html__('Typography', 'aiqengage-child'),
                'selector' => '{{WRAPPER}} .aiq-blueprint-flow',
            ]
        );

        $this->add_responsive_control(
            'flow_padding',
            [
                'label' => esc_html__('Padding', 'aiqengage-child'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'default' => [
                    'top' => '30',
                    'right' => '30',
                    'bottom' => '30',
                    'left' => '30',
                    'unit' => 'px',
                    'isLinked' => true,
                ],
                'selectors' => [
                    '{{WRAPPER}} .aiq-blueprint-flow' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => 'flow_border',
                'label' => esc_html__('Border', 'aiqengage-child'),
                'selector' => '{{WRAPPER}} .aiq-blueprint-flow',
            ]
        );

        $this->add_control(
            'flow_border_radius',
            [
                'label' => esc_html__('Border Radius', 'aiqengage-child'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'default' => [
                    'top' => '15',
                    'right' => '15',
                    'bottom' => '15',
                    'left' => '15',
                    'unit' => 'px',
                    'isLinked' => true,
                ],
                'selectors' => [
                    '{{WRAPPER}} .aiq-blueprint-flow' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'flow_box_shadow',
                'label' => esc_html__('Box Shadow', 'aiqengage-child'),
                'selector' => '{{WRAPPER}} .aiq-blueprint-flow',
            ]
        );

        $this->end_controls_section();

        // Style Section - Nodes
        $this->start_controls_section(
            'section_style_nodes',
            [
                'label' => esc_html__('Nodes', 'aiqengage-child'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'node_background_color',
            [
                'label' => esc_html__('Node Background Color', 'aiqengage-child'),
                'type' => Controls_Manager::COLOR,
                'default' => '#1A0938',
                'selectors' => [
                    '{{WRAPPER}} .aiq-blueprint-flow__node' => '--node-background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'node_padding',
            [
                'label' => esc_html__('Node Padding', 'aiqengage-child'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'default' => [
                    'top' => '20',
                    'right' => '20',
                    'bottom' => '20',
                    'left' => '20',
                    'unit' => 'px',
                    'isLinked' => true,
                ],
                'selectors' => [
                    '{{WRAPPER}} .aiq-blueprint-flow__node' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => 'node_border',
                'label' => esc_html__('Node Border', 'aiqengage-child'),
                'selector' => '{{WRAPPER}} .aiq-blueprint-flow__node',
            ]
        );

        $this->add_control(
            'node_border_radius',
            [
                'label' => esc_html__('Node Border Radius', 'aiqengage-child'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'default' => [
                    'top' => '10',
                    'right' => '10',
                    'bottom' => '10',
                    'left' => '10',
                    'unit' => 'px',
                    'isLinked' => true,
                ],
                'selectors' => [
                    '{{WRAPPER}} .aiq-blueprint-flow__node' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'node_box_shadow',
                'label' => esc_html__('Node Box Shadow', 'aiqengage-child'),
                'selector' => '{{WRAPPER}} .aiq-blueprint-flow__node',
            ]
        );

        $this->add_control(
            'node_spacing',
            [
                'label' => esc_html__('Node Spacing', 'aiqengage-child'),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['px'],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 100,
                        'step' => 1,
                    ],
                ],
                'default' => [
                    'unit' => 'px',
                    'size' => 30,
                ],
                'selectors' => [
                    '{{WRAPPER}} .aiq-blueprint-flow--horizontal .aiq-blueprint-flow__nodes' => 'gap: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}} .aiq-blueprint-flow--vertical .aiq-blueprint-flow__nodes' => 'gap: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'heading_node_title',
            [
                'label' => esc_html__('Node Title', 'aiqengage-child'),
                'type' => Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'node_title_typography',
                'label' => esc_html__('Typography', 'aiqengage-child'),
                'selector' => '{{WRAPPER}} .aiq-blueprint-flow__node-title',
            ]
        );

        $this->add_control(
            'node_title_color',
            [
                'label' => esc_html__('Title Color', 'aiqengage-child'),
                'type' => Controls_Manager::COLOR,
                'default' => '#E0D6FF',
                'selectors' => [
                    '{{WRAPPER}} .aiq-blueprint-flow__node-title' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'heading_node_description',
            [
                'label' => esc_html__('Node Description', 'aiqengage-child'),
                'type' => Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'node_description_typography',
                'label' => esc_html__('Typography', 'aiqengage-child'),
                'selector' => '{{WRAPPER}} .aiq-blueprint-flow__node-description',
            ]
        );

        $this->add_control(
            'node_description_color',
            [
                'label' => esc_html__('Description Color', 'aiqengage-child'),
                'type' => Controls_Manager::COLOR,
                'default' => 'rgba(224, 214, 255, 0.8)',
                'selectors' => [
                    '{{WRAPPER}} .aiq-blueprint-flow__node-description' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_section();

        // Style Section - Connectors
        $this->start_controls_section(
            'section_style_connectors',
            [
                'label' => esc_html__('Connectors', 'aiqengage-child'),
                'tab' => Controls_Manager::TAB_STYLE,
                'condition' => [
                    'show_connectors' => 'yes',
                ],
            ]
        );

        $this->add_control(
            'connector_color',
            [
                'label' => esc_html__('Connector Color', 'aiqengage-child'),
                'type' => Controls_Manager::COLOR,
                'default' => '#7F5AF0',
                'selectors' => [
                    '{{WRAPPER}} .aiq-blueprint-flow__connector' => '--connector-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'connector_width',
            [
                'label' => esc_html__('Connector Width', 'aiqengage-child'),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['px'],
                'range' => [
                    'px' => [
                        'min' => 1,
                        'max' => 10,
                        'step' => 1,
                    ],
                ],
                'default' => [
                    'unit' => 'px',
                    'size' => 2,
                ],
                'selectors' => [
                    '{{WRAPPER}} .aiq-blueprint-flow__connector' => '--connector-width: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'connector_style_options',
            [
                'label' => esc_html__('Connector Styles', 'aiqengage-child'),
                'type' => Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );

        $this->add_control(
            'connector_dash_length',
            [
                'label' => esc_html__('Dash Length', 'aiqengage-child'),
                'type' => Controls_Manager::SLIDER,
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
                    'size' => 6,
                ],
                'selectors' => [
                    '{{WRAPPER}} .aiq-blueprint-flow__connector--dashed' => '--connector-dash-length: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}} .aiq-blueprint-flow__connector--dotted' => '--connector-dash-length: {{SIZE}}{{UNIT}};',
                ],
                'condition' => [
                    'connector_style' => ['dashed', 'dotted'],
                ],
            ]
        );

        $this->add_control(
            'connector_gap_length',
            [
                'label' => esc_html__('Gap Length', 'aiqengage-child'),
                'type' => Controls_Manager::SLIDER,
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
                    'size' => 4,
                ],
                'selectors' => [
                    '{{WRAPPER}} .aiq-blueprint-flow__connector--dashed' => '--connector-gap-length: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}} .aiq-blueprint-flow__connector--dotted' => '--connector-gap-length: {{SIZE}}{{UNIT}};',
                ],
                'condition' => [
                    'connector_style' => ['dashed', 'dotted'],
                ],
            ]
        );

        $this->add_control(
            'arrow_size',
            [
                'label' => esc_html__('Arrow Size', 'aiqengage-child'),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['px'],
                'range' => [
                    'px' => [
                        'min' => 5,
                        'max' => 30,
                        'step' => 1,
                    ],
                ],
                'default' => [
                    'unit' => 'px',
                    'size' => 12,
                ],
                'selectors' => [
                    '{{WRAPPER}} .aiq-blueprint-flow__connector--arrow' => '--arrow-size: {{SIZE}}{{UNIT}};',
                ],
                'condition' => [
                    'connector_style' => 'arrow',
                ],
            ]
        );

        $this->end_controls_section();

        // Style Section - Callouts
        $this->start_controls_section(
            'section_style_callouts',
            [
                'label' => esc_html__('Callouts', 'aiqengage-child'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'callout_background_color',
            [
                'label' => esc_html__('Callout Background Color', 'aiqengage-child'),
                'type' => Controls_Manager::COLOR,
                'default' => 'rgba(126, 87, 194, 0.2)',
                'selectors' => [
                    '{{WRAPPER}} .aiq-blueprint-flow__node-callout' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'callout_text_color',
            [
                'label' => esc_html__('Callout Text Color', 'aiqengage-child'),
                'type' => Controls_Manager::COLOR,
                'default' => '#E0D6FF',
                'selectors' => [
                    '{{WRAPPER}} .aiq-blueprint-flow__node-callout' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'callout_border_color',
            [
                'label' => esc_html__('Callout Border Color', 'aiqengage-child'),
                'type' => Controls_Manager::COLOR,
                'default' => '#9C4DFF',
                'selectors' => [
                    '{{WRAPPER}} .aiq-blueprint-flow__node-callout' => 'border-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'callout_typography',
                'label' => esc_html__('Typography', 'aiqengage-child'),
                'selector' => '{{WRAPPER}} .aiq-blueprint-flow__node-callout',
            ]
        );

        $this->add_control(
            'callout_border_radius',
            [
                'label' => esc_html__('Callout Border Radius', 'aiqengage-child'),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['px', '%'],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 50,
                        'step' => 1,
                    ],
                    '%' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                ],
                'default' => [
                    'unit' => 'px',
                    'size' => 20,
                ],
                'selectors' => [
                    '{{WRAPPER}} .aiq-blueprint-flow__node-callout' => 'border-radius: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'callout_padding',
            [
                'label' => esc_html__('Callout Padding', 'aiqengage-child'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'default' => [
                    'top' => '5',
                    'right' => '10',
                    'bottom' => '5',
                    'left' => '10',
                    'unit' => 'px',
                    'isLinked' => false,
                ],
                'selectors' => [
                    '{{WRAPPER}} .aiq-blueprint-flow__node-callout' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();

        // Style Section - ROI Calculator
        $this->start_controls_section(
            'section_style_roi_calculator',
            [
                'label' => esc_html__('ROI Calculator', 'aiqengage-child'),
                'tab' => Controls_Manager::TAB_STYLE,
                'condition' => [
                    'show_roi_calculator' => 'yes',
                ],
            ]
        );

        $this->add_control(
            'calculator_background_color',
            [
                'label' => esc_html__('Calculator Background Color', 'aiqengage-child'),
                'type' => Controls_Manager::COLOR,
                'default' => '#1A0938',
                'selectors' => [
                    '{{WRAPPER}} .aiq-blueprint-flow__roi-calculator' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => 'calculator_border',
                'label' => esc_html__('Calculator Border', 'aiqengage-child'),
                'selector' => '{{WRAPPER}} .aiq-blueprint-flow__roi-calculator',
            ]
        );

        $this->add_control(
            'calculator_border_radius',
            [
                'label' => esc_html__('Calculator Border Radius', 'aiqengage-child'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'default' => [
                    'top' => '15',
                    'right' => '15',
                    'bottom' => '15',
                    'left' => '15',
                    'unit' => 'px',
                    'isLinked' => true,
                ],
                'selectors' => [
                    '{{WRAPPER}} .aiq-blueprint-flow__roi-calculator' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'calculator_padding',
            [
                'label' => esc_html__('Calculator Padding', 'aiqengage-child'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'default' => [
                    'top' => '30',
                    'right' => '30',
                    'bottom' => '30',
                    'left' => '30',
                    'unit' => 'px',
                    'isLinked' => true,
                ],
                'selectors' => [
                    '{{WRAPPER}} .aiq-blueprint-flow__roi-calculator' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'calculator_box_shadow',
                'label' => esc_html__('Calculator Box Shadow', 'aiqengage-child'),
                'selector' => '{{WRAPPER}} .aiq-blueprint-flow__roi-calculator',
            ]
        );

        $this->add_control(
            'heading_calculator_results',
            [
                'label' => esc_html__('Calculator Results', 'aiqengage-child'),
                'type' => Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );

        $this->add_control(
            'results_background_color',
            [
                'label' => esc_html__('Results Background Color', 'aiqengage-child'),
                'type' => Controls_Manager::COLOR,
                'default' => 'rgba(156, 77, 255, 0.1)',
                'selectors' => [
                    '{{WRAPPER}} .aiq-blueprint-flow__roi-result' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'results_text_color',
            [
                'label' => esc_html__('Results Text Color', 'aiqengage-child'),
                'type' => Controls_Manager::COLOR,
                'default' => '#E0D6FF',
                'selectors' => [
                    '{{WRAPPER}} .aiq-blueprint-flow__roi-result' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'results_accent_color',
            [
                'label' => esc_html__('Results Accent Color', 'aiqengage-child'),
                'type' => Controls_Manager::COLOR,
                'default' => '#9C4DFF',
                'selectors' => [
                    '{{WRAPPER}} .aiq-blueprint-flow__roi-value' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'results_typography',
                'label' => esc_html__('Typography', 'aiqengage-child'),
                'selector' => '{{WRAPPER}} .aiq-blueprint-flow__roi-result',
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'results_value_typography',
                'label' => esc_html__('Value Typography', 'aiqengage-child'),
                'selector' => '{{WRAPPER}} .aiq-blueprint-flow__roi-value',
            ]
        );

        $this->add_responsive_control(
            'results_padding',
            [
                'label' => esc_html__('Results Padding', 'aiqengage-child'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'default' => [
                    'top' => '20',
                    'right' => '20',
                    'bottom' => '20',
                    'left' => '20',
                    'unit' => 'px',
                    'isLinked' => true,
                ],
                'selectors' => [
                    '{{WRAPPER}} .aiq-blueprint-flow__roi-result' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'results_border_radius',
            [
                'label' => esc_html__('Results Border Radius', 'aiqengage-child'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'default' => [
                    'top' => '10',
                    'right' => '10',
                    'bottom' => '10',
                    'left' => '10',
                    'unit' => 'px',
                    'isLinked' => true,
                ],
                'selectors' => [
                    '{{WRAPPER}} .aiq-blueprint-flow__roi-result' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();
    }

    /**
     * Render widget output on the frontend.
     */
    protected function render() {
        $settings = $this->get_settings_for_display();
        $id_int = substr($this->get_id_int(), 0, 4);
        
        $flow_classes = [
            'aiq-blueprint-flow',
            'aiq-blueprint-flow--' . $settings['flow_type'],
            'aiq-blueprint-flow--' . $settings['flow_direction'],
        ];

        $this->add_render_attribute('wrapper', 'class', $flow_classes);
        $this->add_render_attribute('wrapper', 'role', 'flowchart');
        $this->add_render_attribute('wrapper', 'aria-label', $settings['flow_title']);
        
        // Initialize node count for labeling
        $node_count = 0;
        
        ?>
        <div <?php $this->print_render_attribute_string('wrapper'); ?>>
            <?php if (!empty($settings['flow_title']) || !empty($settings['flow_description'])) : ?>
                <div class="aiq-blueprint-flow__header">
                    <?php if (!empty($settings['flow_title'])) : ?>
                        <h2 class="aiq-blueprint-flow__title"><?php echo esc_html($settings['flow_title']); ?></h2>
                    <?php endif; ?>
                    
                    <?php if (!empty($settings['flow_description'])) : ?>
                        <div class="aiq-blueprint-flow__description"><?php echo esc_html($settings['flow_description']); ?></div>
                    <?php endif; ?>
                </div>
            <?php endif; ?>
            
            <div class="aiq-blueprint-flow__nodes" role="list">
                <?php foreach ($settings['nodes'] as $index => $node) : 
                    $node_count++;
                    $node_key = $this->get_repeater_setting_key('node', 'nodes', $index);
                    $node_title_key = $this->get_repeater_setting_key('node_title', 'nodes', $index);
                    $node_desc_key = $this->get_repeater_setting_key('node_description', 'nodes', $index);
                    
                    $this->add_render_attribute($node_key, [
                        'class' => 'aiq-blueprint-flow__node',
                        'role' => 'listitem',
                        'aria-label' => sprintf(__('Step %d: %s', 'aiqengage-child'), $node_count, $node['node_title']),
                        'data-node-id' => $id_int . $index,
                        'style' => '--node-accent:' . $node['node_accent_color'] . ';',
                        'tabindex' => '0',
                    ]);
                    
                    $this->add_render_attribute($node_title_key, [
                        'class' => 'aiq-blueprint-flow__node-title',
                        'id' => 'node-title-' . $id_int . $index,
                    ]);
                    
                    $this->add_render_attribute($node_desc_key, [
                        'class' => 'aiq-blueprint-flow__node-description',
                        'id' => 'node-desc-' . $id_int . $index,
                    ]);
                    
                    $callout_classes = [
                        'aiq-blueprint-flow__node-callout',
                    ];
                    
                    if ($node['node_callout'] !== 'none') {
                        $callout_classes[] = 'aiq-blueprint-flow__node-callout--' . $node['node_callout'];
                    }
                    ?>
                    
                    <div <?php $this->print_render_attribute_string($node_key); ?>>
                        <?php if ($node['node_callout'] !== 'none') : ?>
                            <div class="<?php echo esc_attr(implode(' ', $callout_classes)); ?>">
                                <?php 
                                switch ($node['node_callout']) {
                                    case 'pro-tip':
                                        echo esc_html__('Pro Tip', 'aiqengage-child');
                                        break;
                                    case 'automated':
                                        echo esc_html__('Automated Step', 'aiqengage-child');
                                        break;
                                    case 'manual':
                                        echo esc_html__('Manual Step', 'aiqengage-child');
                                        break;
                                    case 'critical':
                                        echo esc_html__('Critical Step', 'aiqengage-child');
                                        break;
                                }
                                ?>
                            </div>
                        <?php endif; ?>
                        
                        <?php if ($node['node_icon_type'] === 'icon' && !empty($node['node_icon']['value'])) : ?>
                            <div class="aiq-blueprint-flow__node-icon">
                                <?php \Elementor\Icons_Manager::render_icon($node['node_icon'], ['aria-hidden' => 'true']); ?>
                            </div>
                        <?php elseif ($node['node_icon_type'] === 'image' && !empty($node['node_image']['url'])) : ?>
                            <div class="aiq-blueprint-flow__node-image">
                                <img src="<?php echo esc_url($node['node_image']['url']); ?>" alt="" aria-hidden="true">
                            </div>
                        <?php endif; ?>
                        
                        <h3 <?php $this->print_render_attribute_string($node_title_key); ?>><?php echo esc_html($node['node_title']); ?></h3>
                        
                        <div <?php $this->print_render_attribute_string($node_desc_key); ?>><?php echo esc_html($node['node_description']); ?></div>
                        
                        <?php if (!empty($node['node_metric'])) : ?>
                            <div class="aiq-blueprint-flow__node-metric"><?php echo esc_html($node['node_metric']); ?></div>
                        <?php endif; ?>
                    </div>
                    
                    <?php if ($settings['show_connectors'] === 'yes' && $index < count($settings['nodes']) - 1) : 
                        $connector_classes = [
                            'aiq-blueprint-flow__connector',
                            'aiq-blueprint-flow__connector--' . $settings['connector_style'],
                        ];
                        ?>
                        <div class="<?php echo esc_attr(implode(' ', $connector_classes)); ?>" aria-hidden="true"></div>
                    <?php endif; ?>
                    
                <?php endforeach; ?>
            </div>
            
            <?php if ($settings['show_roi_calculator'] === 'yes') : ?>
                <div class="aiq-blueprint-flow__roi-calculator">
                    <?php if (!empty($settings['roi_title'])) : ?>
                        <h3 class="aiq-blueprint-flow__roi-title"><?php echo esc_html($settings['roi_title']); ?></h3>
                    <?php endif; ?>
                    
                    <?php if (!empty($settings['roi_description'])) : ?>
                        <div class="aiq-blueprint-flow__roi-description"><?php echo esc_html($settings['roi_description']); ?></div>
                    <?php endif; ?>
                    
                    <form class="aiq-blueprint-flow__roi-form" data-formula="<?php echo esc_attr($settings['roi_formula']); ?>">
                        <?php foreach ($settings['roi_fields'] as $field_index => $field) : 
                            $field_id = 'roi-field-' . $id_int . '-' . $field_index;
                            ?>
                            <div class="aiq-blueprint-flow__roi-field">
                                <label for="<?php echo esc_attr($field_id); ?>" class="aiq-blueprint-flow__roi-label"><?php echo esc_html($field['field_label']); ?></label>
                                
                                <?php if ($field['field_type'] === 'number') : ?>
                                    <input type="number" id="<?php echo esc_attr($field_id); ?>" class="aiq-blueprint-flow__roi-input" data-field-index="<?php echo esc_attr($field_index); ?>" value="<?php echo esc_attr($field['field_default']); ?>">
                                <?php elseif ($field['field_type'] === 'slider' || $field['field_type'] === 'percentage') : ?>
                                    <div class="aiq-blueprint-flow__roi-slider-container">
                                        <input type="range" id="<?php echo esc_attr($field_id); ?>" class="aiq-blueprint-flow__roi-slider" data-field-index="<?php echo esc_attr($field_index); ?>" min="<?php echo esc_attr($field['field_min']); ?>" max="<?php echo esc_attr($field['field_max']); ?>" step="<?php echo esc_attr($field['field_step']); ?>" value="<?php echo esc_attr($field['field_default']); ?>">
                                        <span class="aiq-blueprint-flow__roi-slider-value"><?php echo esc_html($field['field_default']); ?><?php echo ($field['field_type'] === 'percentage') ? '%' : ''; ?></span>
                                    </div>
                                <?php endif; ?>
                            </div>
                        <?php endforeach; ?>
                        
                        <div class="aiq-blueprint-flow__roi-result">
                            <span class="aiq-blueprint-flow__roi-result-label"><?php esc_html_e('Estimated ROI:', 'aiqengage-child'); ?></span>
                            <span class="aiq-blueprint-flow__roi-value">$0</span>
                        </div>
                        
                        <?php if ($settings['roi_formula'] === 'custom') : ?>
                            <script type="text/template" class="aiq-blueprint-flow__roi-custom-formula">
                                <?php echo $settings['roi_custom_formula']; ?>
                            </script>
                        <?php endif; ?>
                    </form>
                </div>
            <?php endif; ?>
        </div>
        <?php
    }
}
