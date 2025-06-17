<?php
/**
 * Tool Card Widget for AIQEngage
 *
 * @package AIQEngage
 */

// Exit if accessed directly.
if (!defined('ABSPATH')) {
    exit;
}

/**
 * Tool Card Widget
 */
class AIQ_Tool_Card_Widget extends \Elementor\Widget_Base {

    /**
     * Get widget name.
     *
     * @return string Widget name.
     */
    public function get_name() {
        return 'aiq_tool_card';
    }

    /**
     * Get widget title.
     *
     * @return string Widget title.
     */
    public function get_title() {
        return esc_html__('Tool Card', 'aiqengage');
    }

    /**
     * Get widget icon.
     *
     * @return string Widget icon.
     */
    public function get_icon() {
        return 'eicon-star-rating';
    }

    /**
     * Get widget keywords.
     *
     * @return array Widget keywords.
     */
    public function get_keywords() {
        return ['tool', 'affiliate', 'offer', 'card', 'review'];
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
     * Get category colors.
     *
     * @return array Category colors.
     */
    private function get_category_colors() {
        return [
            'writer'      => '#9C4DFF',
            'automation'  => '#635BFF',
            'research'    => '#7F5AF0',
            'design'      => '#8E6BFF',
            'analytics'   => '#5E72E4',
            'productivity' => '#A0AEC0',
            'other'       => '#4A5568',
        ];
    }

    /**
     * Register widget controls.
     */
    protected function register_controls() {
        $this->register_content_controls();
        $this->register_style_controls();
    }

    /**
     * Register content controls
     */
    protected function register_content_controls() {
        $this->start_controls_section(
            'section_content',
            [
                'label' => esc_html__('Tool Content', 'aiqengage'),
                'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'tool_name',
            [
                'label'       => esc_html__('Tool Name', 'aiqengage'),
                'type'        => \Elementor\Controls_Manager::TEXT,
                'default'     => esc_html__('Tool Name', 'aiqengage'),
                'placeholder' => esc_html__('Enter tool name', 'aiqengage'),
                'label_block' => true,
                'dynamic'     => [
                    'active' => true,
                ],
            ]
        );

        $this->add_control(
            'tool_description',
            [
                'label'       => esc_html__('Description', 'aiqengage'),
                'type'        => \Elementor\Controls_Manager::TEXTAREA,
                'default'     => esc_html__('Short description of this tool and how it helps with Claude automation.', 'aiqengage'),
                'placeholder' => esc_html__('Enter tool description', 'aiqengage'),
                'rows'        => 3,
                'dynamic'     => [
                    'active' => true,
                ],
            ]
        );

        $this->add_control(
            'tool_category',
            [
                'label'   => esc_html__('Tool Category', 'aiqengage'),
                'type'    => \Elementor\Controls_Manager::SELECT,
                'default' => 'writer',
                'options' => [
                    'writer'       => esc_html__('AI Writer', 'aiqengage'),
                    'automation'   => esc_html__('Automation', 'aiqengage'),
                    'research'     => esc_html__('Research', 'aiqengage'),
                    'design'       => esc_html__('Design', 'aiqengage'),
                    'analytics'    => esc_html__('Analytics', 'aiqengage'),
                    'productivity' => esc_html__('Productivity', 'aiqengage'),
                    'other'        => esc_html__('Other', 'aiqengage'),
                ],
            ]
        );

        $this->add_control(
            'tool_logo',
            [
                'label'   => esc_html__('Tool Logo', 'aiqengage'),
                'type'    => \Elementor\Controls_Manager::MEDIA,
                'default' => [
                    'url' => \Elementor\Utils::get_placeholder_image_src(),
                ],
                'dynamic' => [
                    'active' => true,
                ],
            ]
        );

        $this->add_control(
            'show_discount',
            [
                'label'        => esc_html__('Show Discount Badge', 'aiqengage'),
                'type'         => \Elementor\Controls_Manager::SWITCHER,
                'label_on'     => esc_html__('Yes', 'aiqengage'),
                'label_off'    => esc_html__('No', 'aiqengage'),
                'return_value' => 'yes',
                'default'      => 'no',
            ]
        );

        $this->add_control(
            'discount_text',
            [
                'label'       => esc_html__('Discount Text', 'aiqengage'),
                'type'        => \Elementor\Controls_Manager::TEXT,
                'default'     => esc_html__('40% OFF', 'aiqengage'),
                'placeholder' => esc_html__('E.g. 40% OFF', 'aiqengage'),
                'condition'   => [
                    'show_discount' => 'yes',
                ],
                'dynamic'     => [
                    'active' => true,
                ],
            ]
        );

        $this->add_control(
            'show_rating',
            [
                'label'        => esc_html__('Show Rating', 'aiqengage'),
                'type'         => \Elementor\Controls_Manager::SWITCHER,
                'label_on'     => esc_html__('Yes', 'aiqengage'),
                'label_off'    => esc_html__('No', 'aiqengage'),
                'return_value' => 'yes',
                'default'      => 'yes',
            ]
        );

        $this->add_control(
            'rating',
            [
                'label'     => esc_html__('Rating', 'aiqengage'),
                'type'      => \Elementor\Controls_Manager::SLIDER,
                'range'     => [
                    'px' => [
                        'min'  => 1,
                        'max'  => 5,
                        'step' => 0.1,
                    ],
                ],
                'default'   => [
                    'size' => 4.5,
                ],
                'condition' => [
                    'show_rating' => 'yes',
                ],
            ]
        );

        $this->add_control(
            'show_verified',
            [
                'label'        => esc_html__('Show Verified Badge', 'aiqengage'),
                'type'         => \Elementor\Controls_Manager::SWITCHER,
                'label_on'     => esc_html__('Yes', 'aiqengage'),
                'label_off'    => esc_html__('No', 'aiqengage'),
                'return_value' => 'yes',
                'default'      => 'yes',
            ]
        );

        $this->add_control(
            'original_price',
            [
                'label'       => esc_html__('Original Price', 'aiqengage'),
                'type'        => \Elementor\Controls_Manager::TEXT,
                'default'     => esc_html__('$99/mo', 'aiqengage'),
                'placeholder' => esc_html__('E.g. $99/mo', 'aiqengage'),
                'condition'   => [
                    'show_discount' => 'yes',
                ],
                'dynamic'     => [
                    'active' => true,
                ],
            ]
        );

        $this->add_control(
            'discount_price',
            [
                'label'       => esc_html__('Discount Price', 'aiqengage'),
                'type'        => \Elementor\Controls_Manager::TEXT,
                'default'     => esc_html__('$59/mo', 'aiqengage'),
                'placeholder' => esc_html__('E.g. $59/mo', 'aiqengage'),
                'dynamic'     => [
                    'active' => true,
                ],
            ]
        );

        $this->add_control(
            'button_text',
            [
                'label'       => esc_html__('Button Text', 'aiqengage'),
                'type'        => \Elementor\Controls_Manager::TEXT,
                'default'     => esc_html__('Get Deal', 'aiqengage'),
                'placeholder' => esc_html__('Enter button text', 'aiqengage'),
                'dynamic'     => [
                    'active' => true,
                ],
            ]
        );

        $this->add_control(
            'button_link',
            [
                'label'       => esc_html__('Button Link', 'aiqengage'),
                'type'        => \Elementor\Controls_Manager::URL,
                'placeholder' => esc_html__('https://your-affiliate-link.com', 'aiqengage'),
                'default'     => [
                    'url'               => '#',
                    'is_external'       => true,
                    'nofollow'          => true,
                    'custom_attributes' => '',
                ],
                'dynamic'     => [
                    'active' => true,
                ],
            ]
        );

        $this->add_control(
            'tracking_id',
            [
                'label'       => esc_html__('Tracking ID', 'aiqengage'),
                'type'        => \Elementor\Controls_Manager::TEXT,
                'default'     => esc_html__('TOOLKIT_V3_CLAUDE', 'aiqengage'),
                'placeholder' => esc_html__('Enter tracking ID', 'aiqengage'),
                'description' => esc_html__('For analytics tracking', 'aiqengage'),
                'dynamic'     => [
                    'active' => true,
                ],
            ]
        );

        $this->end_controls_section();
    }

    /**
     * Register style controls
     */
    protected function register_style_controls() {
        $this->register_card_style_controls();
        $this->register_typography_controls();
        $this->register_button_style_controls();
        $this->register_badge_style_controls();
    }

    /**
     * Register card style controls
     */
    protected function register_card_style_controls() {
        $this->start_controls_section(
            'section_style',
            [
                'label' => esc_html__('Card Style', 'aiqengage'),
                'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'card_style',
            [
                'label'   => esc_html__('Card Style', 'aiqengage'),
                'type'    => \Elementor\Controls_Manager::SELECT,
                'default' => 'grid',
                'options' => [
                    'grid' => esc_html__('Grid Item', 'aiqengage'),
                    'list' => esc_html__('List Item', 'aiqengage'),
                ],
            ]
        );

        $this->add_control(
            'background_color',
            [
                'label'     => esc_html__('Background Color', 'aiqengage'),
                'type'      => \Elementor\Controls_Manager::COLOR,
                'default'   => '#2A1958',
                'selectors' => [
                    '{{WRAPPER}} .aiq-tool-card' => 'background-color: {{VALUE}}',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name'     => 'border',
                'selector' => '{{WRAPPER}} .aiq-tool-card',
                'default'  => [
                    'color'  => 'rgba(156, 77, 255, 0.3)',
                    'width'  => 1,
                    'style'  => 'solid',
                ],
            ]
        );

        $this->add_responsive_control(
            'border_radius',
            [
                'label'      => esc_html__('Border Radius', 'aiqengage'),
                'type'       => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'default'    => [
                    'top'    => 15,
                    'right'  => 15,
                    'bottom' => 15,
                    'left'   => 15,
                    'unit'   => 'px',
                ],
                'selectors'  => [
                    '{{WRAPPER}} .aiq-tool-card' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Box_Shadow::get_type(),
            [
                'name'     => 'box_shadow',
                'selector' => '{{WRAPPER}} .aiq-tool-card',
            ]
        );

        $this->add_responsive_control(
            'padding',
            [
                'label'      => esc_html__('Padding', 'aiqengage'),
                'type'       => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'default'    => [
                    'top'    => 24,
                    'right'  => 24,
                    'bottom' => 24,
                    'left'   => 24,
                    'unit'   => 'px',
                ],
                'selectors'  => [
                    '{{WRAPPER}} .aiq-tool-card' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'logo_style',
            [
                'label'     => esc_html__('Logo', 'aiqengage'),
                'type'      => \Elementor\Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );

        $this->add_responsive_control(
            'logo_size',
            [
                'label'      => esc_html__('Size', 'aiqengage'),
                'type'       => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px'],
                'range'      => [
                    'px' => [
                        'min'  => 40,
                        'max'  => 120,
                        'step' => 1,
                    ],
                ],
                'default'    => [
                    'unit' => 'px',
                    'size' => 64,
                ],
                'selectors'  => [
                    '{{WRAPPER}} .aiq-tool-card__logo' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'logo_spacing',
            [
                'label'      => esc_html__('Spacing', 'aiqengage'),
                'type'       => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors'  => [
                    '{{WRAPPER}} .aiq-tool-card__logo-wrapper' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();
    }

    /**
     * Register typography controls
     */
    protected function register_typography_controls() {
        $this->start_controls_section(
            'section_typography',
            [
                'label' => esc_html__('Typography', 'aiqengage'),
                'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'title_style',
            [
                'label'     => esc_html__('Title', 'aiqengage'),
                'type'      => \Elementor\Controls_Manager::HEADING,
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name'     => 'title_typography',
                'selector' => '{{WRAPPER}} .aiq-tool-card__title',
            ]
        );

        $this->add_control(
            'title_color',
            [
                'label'     => esc_html__('Color', 'aiqengage'),
                'type'      => \Elementor\Controls_Manager::COLOR,
                'default'   => '#E0D6FF',
                'selectors' => [
                    '{{WRAPPER}} .aiq-tool-card__title' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_responsive_control(
            'title_spacing',
            [
                'label'      => esc_html__('Spacing', 'aiqengage'),
                'type'       => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors'  => [
                    '{{WRAPPER}} .aiq-tool-card__title' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'description_style',
            [
                'label'     => esc_html__('Description', 'aiqengage'),
                'type'      => \Elementor\Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name'     => 'description_typography',
                'selector' => '{{WRAPPER}} .aiq-tool-card__description',
            ]
        );

        $this->add_control(
            'description_color',
            [
                'label'     => esc_html__('Color', 'aiqengage'),
                'type'      => \Elementor\Controls_Manager::COLOR,
                'default'   => 'rgba(224, 214, 255, 0.8)',
                'selectors' => [
                    '{{WRAPPER}} .aiq-tool-card__description' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_responsive_control(
            'description_spacing',
            [
                'label'      => esc_html__('Spacing', 'aiqengage'),
                'type'       => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors'  => [
                    '{{WRAPPER}} .aiq-tool-card__description' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'price_style',
            [
                'label'     => esc_html__('Price', 'aiqengage'),
                'type'      => \Elementor\Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name'     => 'price_typography',
                'selector' => '{{WRAPPER}} .aiq-tool-card__price-current',
            ]
        );

        $this->add_control(
            'price_color',
            [
                'label'     => esc_html__('Current Price Color', 'aiqengage'),
                'type'      => \Elementor\Controls_Manager::COLOR,
                'default'   => '#E0D6FF',
                'selectors' => [
                    '{{WRAPPER}} .aiq-tool-card__price-current' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'original_price_color',
            [
                'label'     => esc_html__('Original Price Color', 'aiqengage'),
                'type'      => \Elementor\Controls_Manager::COLOR,
                'default'   => 'rgba(224, 214, 255, 0.6)',
                'selectors' => [
                    '{{WRAPPER}} .aiq-tool-card__price-original' => 'color: {{VALUE}}; text-decoration: line-through;',
                ],
                'condition' => [
                    'show_discount' => 'yes',
                ],
            ]
        );

        $this->add_responsive_control(
            'price_spacing',
            [
                'label'      => esc_html__('Spacing', 'aiqengage'),
                'type'       => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors'  => [
                    '{{WRAPPER}} .aiq-tool-card__price' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'category_style',
            [
                'label'     => esc_html__('Category', 'aiqengage'),
                'type'      => \Elementor\Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name'     => 'category_typography',
                'selector' => '{{WRAPPER}} .aiq-tool-card__category',
            ]
        );

        $this->add_control(
            'category_text_color',
            [
                'label'     => esc_html__('Text Color', 'aiqengage'),
                'type'      => \Elementor\Controls_Manager::COLOR,
                'default'   => '#FFFFFF',
                'selectors' => [
                    '{{WRAPPER}} .aiq-tool-card__category' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'category_background_color',
            [
                'label'     => esc_html__('Background Color', 'aiqengage'),
                'type'      => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .aiq-tool-card__category' => 'background-color: var(--category-color)',
                ],
            ]
        );

        $this->add_responsive_control(
            'category_padding',
            [
                'label'      => esc_html__('Padding', 'aiqengage'),
                'type'       => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'default'    => [
                    'top'    => 2,
                    'right'  => 8,
                    'bottom' => 2,
                    'left'   => 8,
                    'unit'   => 'px',
                ],
                'selectors'  => [
                    '{{WRAPPER}} .aiq-tool-card__category' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'category_border_radius',
            [
                'label'      => esc_html__('Border Radius', 'aiqengage'),
                'type'       => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'default'    => [
                    'top'    => 4,
                    'right'  => 4,
                    'bottom' => 4,
                    'left'   => 4,
                    'unit'   => 'px',
                ],
                'selectors'  => [
                    '{{WRAPPER}} .aiq-tool-card__category' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'rating_style',
            [
                'label'     => esc_html__('Rating', 'aiqengage'),
                'type'      => \Elementor\Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );

        $this->add_control(
            'star_color',
            [
                'label'     => esc_html__('Star Color', 'aiqengage'),
                'type'      => \Elementor\Controls_Manager::COLOR,
                'default'   => '#FFD700',
                'selectors' => [
                    '{{WRAPPER}} .aiq-tool-card__star--full' => 'color: {{VALUE}}',
                    '{{WRAPPER}} .aiq-tool-card__star--half' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'empty_star_color',
            [
                'label'     => esc_html__('Empty Star Color', 'aiqengage'),
                'type'      => \Elementor\Controls_Manager::COLOR,
                'default'   => 'rgba(255, 215, 0, 0.3)',
                'selectors' => [
                    '{{WRAPPER}} .aiq-tool-card__star--empty' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'rating_text_color',
            [
                'label'     => esc_html__('Text Color', 'aiqengage'),
                'type'      => \Elementor\Controls_Manager::COLOR,
                'default'   => 'rgba(224, 214, 255, 0.8)',
                'selectors' => [
                    '{{WRAPPER}} .aiq-tool-card__rating-text' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_responsive_control(
            'rating_spacing',
            [
                'label'      => esc_html__('Spacing', 'aiqengage'),
                'type'       => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors'  => [
                    '{{WRAPPER}} .aiq-tool-card__rating' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();
    }

    /**
     * Register button style controls
     */
    protected function register_button_style_controls() {
        $this->start_controls_section(
            'section_button_style',
            [
                'label' => esc_html__('Button Style', 'aiqengage'),
                'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name'     => 'button_typography',
                'selector' => '{{WRAPPER}} .aiq-tool-card__button',
            ]
        );

        $this->start_controls_tabs('button_style_tabs');

        $this->start_controls_tab(
            'button_normal_tab',
            [
                'label' => esc_html__('Normal', 'aiqengage'),
            ]
        );

        $this->add_control(
            'button_text_color',
            [
                'label'     => esc_html__('Text Color', 'aiqengage'),
                'type'      => \Elementor\Controls_Manager::COLOR,
                'default'   => '#FFFFFF',
                'selectors' => [
                    '{{WRAPPER}} .aiq-tool-card__button' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Background::get_type(),
            [
                'name'     => 'button_background',
                'types'    => ['gradient'],
                'selector' => '{{WRAPPER}} .aiq-tool-card__button',
                'fields_options' => [
                    'background' => [
                        'default' => 'gradient',
                    ],
                    'color' => [
                        'default' => '#9C4DFF',
                    ],
                    'color_b' => [
                        'default' => '#5E72E4',
                    ],
                    'gradient_angle' => [
                        'default' => [
                            'unit' => 'deg',
                            'size' => 90,
                        ],
                    ],
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name'     => 'button_border',
                'selector' => '{{WRAPPER}} .aiq-tool-card__button',
            ]
        );

        $this->add_responsive_control(
            'button_border_radius',
            [
                'label'      => esc_html__('Border Radius', 'aiqengage'),
                'type'       => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'default'    => [
                    'top'    => 8,
                    'right'  => 8,
                    'bottom' => 8,
                    'left'   => 8,
                    'unit'   => 'px',
                ],
                'selectors'  => [
                    '{{WRAPPER}} .aiq-tool-card__button' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Box_Shadow::get_type(),
            [
                'name'     => 'button_box_shadow',
                'selector' => '{{WRAPPER}} .aiq-tool-card__button',
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'button_hover_tab',
            [
                'label' => esc_html__('Hover', 'aiqengage'),
            ]
        );

        $this->add_control(
            'button_hover_text_color',
            [
                'label'     => esc_html__('Text Color', 'aiqengage'),
                'type'      => \Elementor\Controls_Manager::COLOR,
                'default'   => '#FFFFFF',
                'selectors' => [
                    '{{WRAPPER}} .aiq-tool-card__button:hover' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Background::get_type(),
            [
                'name'     => 'button_hover_background',
                'types'    => ['gradient'],
                'selector' => '{{WRAPPER}} .aiq-tool-card__button:hover',
                'fields_options' => [
                    'background' => [
                        'default' => 'gradient',
                    ],
                    'color' => [
                        'default' => '#8040FF',
                    ],
                    'color_b' => [
                        'default' => '#4C5FCD',
                    ],
                    'gradient_angle' => [
                        'default' => [
                            'unit' => 'deg',
                            'size' => 90,
                        ],
                    ],
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Box_Shadow::get_type(),
            [
                'name'     => 'button_hover_box_shadow',
                'selector' => '{{WRAPPER}} .aiq-tool-card__button:hover',
                'fields_options' => [
                    'box_shadow_type' => [
                        'default' => 'yes',
                    ],
                    'box_shadow' => [
                        'default' => [
                            'horizontal' => 0,
                            'vertical' => 5,
                            'blur' => 15,
                            'spread' => 0,
                            'color' => 'rgba(94, 114, 228, 0.4)',
                        ],
                    ],
                ],
            ]
        );

        $this->add_control(
            'button_hover_transform',
            [
                'label'     => esc_html__('Transform', 'aiqengage'),
                'type'      => \Elementor\Controls_Manager::SELECT,
                'default'   => 'translateY(-2px)',
                'options'   => [
                    'none'             => esc_html__('None', 'aiqengage'),
                    'translateY(-2px)' => esc_html__('Move Up', 'aiqengage'),
                    'scale(1.05)'      => esc_html__('Scale Up', 'aiqengage'),
                    'scale(0.98)'      => esc_html__('Scale Down', 'aiqengage'),
                ],
                'selectors' => [
                    '{{WRAPPER}} .aiq-tool-card__button:hover' => 'transform: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'button_hover_transition',
            [
                'label'     => esc_html__('Transition Duration', 'aiqengage'),
                'type'      => \Elementor\Controls_Manager::SLIDER,
                'range'     => [
                    'px' => [
                        'min'  => 0.1,
                        'max'  => 1,
                        'step' => 0.1,
                    ],
                ],
                'default'   => [
                    'size' => 0.3,
                ],
                'selectors' => [
                    '{{WRAPPER}} .aiq-tool-card__button' => 'transition: all {{SIZE}}s;',
                ],
            ]
        );

        $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->add_responsive_control(
            'button_padding',
            [
                'label'      => esc_html__('Padding', 'aiqengage'),
                'type'       => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'default'    => [
                    'top'    => 14,
                    'right'  => 26,
                    'bottom' => 14,
                    'left'   => 26,
                    'unit'   => 'px',
                ],
                'selectors'  => [
                    '{{WRAPPER}} .aiq-tool-card__button' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
                'separator'  => 'before',
            ]
        );

        $this->add_responsive_control(
            'button_margin',
            [
                'label'      => esc_html__('Margin', 'aiqengage'),
                'type'       => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors'  => [
                    '{{WRAPPER}} .aiq-tool-card__button' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();
    }

    /**
     * Register badge style controls
     */
    protected function register_badge_style_controls() {
        $this->start_controls_section(
            'section_badge_style',
            [
                'label'     => esc_html__('Badge Style', 'aiqengage'),
                'tab'       => \Elementor\Controls_Manager::TAB_STYLE,
                'condition' => [
                    'show_discount' => 'yes',
                ],
            ]
        );

        $this->add_control(
            'badge_background_color',
            [
                'label'     => esc_html__('Badge Background', 'aiqengage'),
                'type'      => \Elementor\Controls_Manager::COLOR,
                'default'   => '#9C4DFF',
                'selectors' => [
                    '{{WRAPPER}} .aiq-tool-card__badge' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'badge_text_color',
            [
                'label'     => esc_html__('Badge Text Color', 'aiqengage'),
                'type'      => \Elementor\Controls_Manager::COLOR,
                'default'   => '#FFFFFF',
                'selectors' => [
                    '{{WRAPPER}} .aiq-tool-card__badge' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name'     => 'badge_typography',
                'selector' => '{{WRAPPER}} .aiq-tool-card__badge',
            ]
        );

        $this->add_responsive_control(
            'badge_border_radius',
            [
                'label'      => esc_html__('Border Radius', 'aiqengage'),
                'type'       => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'default'    => [
                    'top'    => 20,
                    'right'  => 20,
                    'bottom' => 20,
                    'left'   => 20,
                    'unit'   => 'px',
                ],
                'selectors'  => [
                    '{{WRAPPER}} .aiq-tool-card__badge' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'badge_padding',
            [
                'label'      => esc_html__('Padding', 'aiqengage'),
                'type'       => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'default'    => [
                    'top'    => 4,
                    'right'  => 12,
                    'bottom' => 4,
                    'left'   => 12,
                    'unit'   => 'px',
                ],
                'selectors'  => [
                    '{{WRAPPER}} .aiq-tool-card__badge' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'badge_margin',
            [
                'label'      => esc_html__('Margin', 'aiqengage'),
                'type'       => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors'  => [
                    '{{WRAPPER}} .aiq-tool-card__badge' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'badge_position',
            [
                'label'     => esc_html__('Position', 'aiqengage'),
                'type'      => \Elementor\Controls_Manager::SELECT,
                'default'   => 'absolute',
                'options'   => [
                    'absolute' => esc_html__('Absolute', 'aiqengage'),
                    'static'   => esc_html__('Static', 'aiqengage'),
                ],
                'selectors' => [
                    '{{WRAPPER}} .aiq-tool-card__badge' => 'position: {{VALUE}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'badge_top',
            [
                'label'      => esc_html__('Top Position', 'aiqengage'),
                'type'       => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px', '%'],
                'range'      => [
                    'px' => [
                        'min'  => -50,
                        'max'  => 50,
                        'step' => 1,
                    ],
                    '%' => [
                        'min'  => -100,
                        'max'  => 100,
                        'step' => 1,
                    ],
                ],
                'default'    => [
                    'unit' => 'px',
                    'size' => 10,
                ],
                'selectors'  => [
                    '{{WRAPPER}} .aiq-tool-card__badge' => 'top: {{SIZE}}{{UNIT}};',
                ],
                'condition' => [
                    'badge_position' => 'absolute',
                ],
            ]
        );

        $this->add_responsive_control(
            'badge_right',
            [
                'label'      => esc_html__('Right Position', 'aiqengage'),
                'type'       => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px', '%'],
                'range'      => [
                    'px' => [
                        'min'  => -50,
                        'max'  => 50,
                        'step' => 1,
                    ],
                    '%' => [
                        'min'  => -100,
                        'max'  => 100,
                        'step' => 1,
                    ],
                ],
                'default'    => [
                    'unit' => 'px',
                    'size' => 10,
                ],
                'selectors'  => [
                    '{{WRAPPER}} .aiq-tool-card__badge' => 'right: {{SIZE}}{{UNIT}};',
                ],
                'condition' => [
                    'badge_position' => 'absolute',
                ],
            ]
        );

        $this->add_control(
            'badge_rotation',
            [
                'label'      => esc_html__('Rotation', 'aiqengage'),
                'type'       => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['deg'],
                'range'      => [
                    'deg' => [
                        'min'  => -45,
                        'max'  => 45,
                        'step' => 1,
                    ],
                ],
                'selectors'  => [
                    '{{WRAPPER}} .aiq-tool-card__badge' => 'transform: rotate({{SIZE}}deg);',
                ],
            ]
        );

        $this->end_controls_section();
    }

    /**
     * Render stars for rating.
     *
     * @param float $rating The rating to display.
     * @return string HTML output for stars.
     */
    private function render_stars($rating) {
        $output = '<div class="aiq-tool-card__rating">';
        
        // Full stars
        $full_stars = floor($rating);
        for ($i = 0; $i < $full_stars; $i++) {
            $output .= '<span class="aiq-tool-card__star aiq-tool-card__star--full">★</span>';
        }
        
        // Half star
        if ($rating - $full_stars >= 0.5) {
            $output .= '<span class="aiq-tool-card__star aiq-tool-card__star--half">★</span>';
            $partial_stars = 1;
        } else {
            $partial_stars = 0;
        }
        
        // Empty stars
        $empty_stars = 5 - $full_stars - $partial_stars;
        for ($i = 0; $i < $empty_stars; $i++) {
            $output .= '<span class="aiq-tool-card__star aiq-tool-card__star--empty">★</span>';
        }
        
        // Display numeric rating
        $output .= '<span class="aiq-tool-card__rating-text">' . number_format($rating, 1) . '</span>';
        
        $output .= '</div>';
        
        return $output;
    }

    /**
     * Render verified badge.
     *
     * @return string HTML output for verified badge.
     */
    private function render_verified_badge() {
        return '<span class="aiq-tool-card__verified" aria-label="' . esc_attr__('Verified Tool', 'aiqengage') . '">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M9 12L11 14L15 10M21 12C21 16.9706 16.9706 21 12 21C7.02944 21 3 16.9706 3 12C3 7.02944 7.02944 3 12 3C16.9706 3 21 7.02944 21 12Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
            <span>' . esc_html__('Verified', 'aiqengage') . '</span>
        </span>';
    }

    /**
     * Get category badge color.
     *
     * @param string $category The tool category.
     * @return string CSS color value.
     */
    private function get_category_badge_color($category) {
        $colors = $this->get_category_colors();
        return isset($colors[$category]) ? $colors[$category] : $colors['other'];
    }

    /**
     * Render widget output on the frontend.
     */
    protected function render() {
        $settings = $this->get_settings_for_display();
        
        // Get category color
        $category_color = $this->get_category_badge_color($settings['tool_category']);
        
        // Define CSS classes
        $card_classes = ['aiq-tool-card'];
        if ('list' === $settings['card_style']) {
            $card_classes[] = 'aiq-tool-card--list';
        } else {
            $card_classes[] = 'aiq-tool-card--grid';
        }
        
        $card_classes = implode(' ', $card_classes);
        
        // Add tracking ID to button link if set
        $url = $settings['button_link']['url'];
        if (!empty($settings['tracking_id']) && strpos($url, '?') !== false) {
            $url .= '&tid=' . urlencode($settings['tracking_id']);
        } elseif (!empty($settings['tracking_id'])) {
            $url .= '?tid=' . urlencode($settings['tracking_id']);
        }
        
        // Link attributes
        $link_attributes = 'href="' . esc_url($url) . '"';
        
        if ($settings['button_link']['is_external']) {
            $link_attributes .= ' target="_blank"';
        }
        
        if ($settings['button_link']['nofollow']) {
            $link_attributes .= ' rel="nofollow"';
        }
        
        if (!empty($settings['button_link']['custom_attributes'])) {
            $link_attributes .= ' ' . $settings['button_link']['custom_attributes'];
        }
        
        $link_attributes .= ' aria-label="' . esc_attr(sprintf(__('Get %s deal', 'aiqengage'), $settings['tool_name'])) . '"';

        // Image alt text
        $image_alt = '';
        if (!empty($settings['tool_logo']['id'])) {
            $image_alt = get_post_meta($settings['tool_logo']['id'], '_wp_attachment_image_alt', true);
        }
        if (empty($image_alt)) {
            $image_alt = $settings['tool_name'] . ' ' . __('logo', 'aiqengage');
        }
        
        // Start output
        ?>
        <div class="<?php echo esc_attr($card_classes); ?>" data-category="<?php echo esc_attr($settings['tool_category']); ?>">
            
            <?php if ('yes' === $settings['show_discount'] && !empty($settings['discount_text'])) : ?>
            <div class="aiq-tool-card__badge">
                <?php echo esc_html($settings['discount_text']); ?>
            </div>
            <?php endif; ?>
            
            <div class="aiq-tool-card__logo-wrapper">
                <?php 
                // Use Elementor's image rendering for better performance
                \Elementor\Group_Control_Image_Size::print_attachment_image_html($settings, 'tool_logo', 'tool_logo');
                ?>
            </div>
            
            <div class="aiq-tool-card__content">
                <div class="aiq-tool-card__header">
                    <h3 class="aiq-tool-card__title"><?php echo esc_html($settings['tool_name']); ?></h3>
                    
                    <div class="aiq-tool-card__meta">
                        <span class="aiq-tool-card__category" style="--category-color: <?php echo esc_attr($category_color); ?>">
                            <?php echo esc_html($settings['tool_category']); ?>
                        </span>
                        
                        <?php if ('yes' === $settings['show_verified']) : ?>
                            <?php echo wp_kses_post($this->render_verified_badge()); ?>
                        <?php endif; ?>
                    </div>
                </div>
                
                <?php if ('yes' === $settings['show_rating']) : ?>
                    <?php echo wp_kses_post($this->render_stars($settings['rating']['size'])); ?>
                <?php endif; ?>
                
                <div class="aiq-tool-card__description">
                    <?php echo esc_html($settings['tool_description']); ?>
                </div>
                
                <div class="aiq-tool-card__footer">
                    <div class="aiq-tool-card__price">
                        <?php if ('yes' === $settings['show_discount'] && !empty($settings['original_price'])) : ?>
                            <span class="aiq-tool-card__price-original"><?php echo esc_html($settings['original_price']); ?></span>
                        <?php endif; ?>
                        
                        <span class="aiq-tool-card__price-current"><?php echo esc_html($settings['discount_price']); ?></span>
                    </div>
                    
                    <a class="aiq-tool-card__button" <?php echo $link_attributes; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- Already escaped above ?> data-tracking-id="<?php echo esc_attr($settings['tracking_id']); ?>">
                        <?php echo esc_html($settings['button_text']); ?>
                    </a>
                </div>
            </div>
        </div>
        <?php
    }

    /**
     * Render widget output in the editor.
     */
    protected function content_template() {
        ?>
        <#
        // Get category color
        function getCategoryColor(category) {
            const colors = {
                'writer': '#9C4DFF',
                'automation': '#635BFF',
                'research': '#7F5AF0',
                'design': '#8E6BFF',
                'analytics': '#5E72E4',
                'productivity': '#A0AEC0',
                'other': '#4A5568'
            };
            return colors[category] || colors['other'];
        }
        
        // Render stars
        function renderStars(rating) {
            let output = '<div class="aiq-tool-card__rating">';
            
            // Full stars
            const fullStars = Math.floor(rating);
            for (let i = 0; i < fullStars; i++) {
                output += '<span class="aiq-tool-card__star aiq-tool-card__star--full">★</span>';
            }
            
            // Half star
            let partialStars = 0;
            if (rating - fullStars >= 0.5) {
                output += '<span class="aiq-tool-card__star aiq-tool-card__star--half">★</span>';
                partialStars = 1;
            }
            
            // Empty stars
            const emptyStars = 5 - fullStars - partialStars;
            for (let i = 0; i < emptyStars; i++) {
                output += '<span class="aiq-tool-card__star aiq-tool-card__star--empty">★</span>';
            }
            
            // Display numeric rating
            output += '<span class="aiq-tool-card__rating-text">' + rating.toFixed(1) + '</span>';
            
            output += '</div>';
            
            return output;
        }
        
        // Render verified badge
        function renderVerifiedBadge() {
            return '<span class="aiq-tool-card__verified" aria-label="Verified Tool">' +
                '<svg width="16" height="16" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">' +
                '<path d="M9 12L11 14L15 10M21 12C21 16.9706 16.9706 21 12 21C7.02944 21 3 16.9706 3 12C3 7.02944 7.02944 3 12 3C16.9706 3 21 7.02944 21 12Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>' +
                '</svg>' +
                '<span>Verified</span>' +
            '</span>';
        }
        
        // Define CSS classes
        let cardClasses = ['aiq-tool-card'];
        if (settings.card_style === 'list') {
            cardClasses.push('aiq-tool-card--list');
        } else {
            cardClasses.push('aiq-tool-card--grid');
        }
        
        // Get category color
        const categoryColor = getCategoryColor(settings.tool_category);
        
        // URL with tracking
        let url = settings.button_link.url;
        if (settings.tracking_id) {
            if (url.indexOf('?') !== -1) {
                url += '&tid=' + encodeURIComponent(settings.tracking_id);
            } else {
                url += '?tid=' + encodeURIComponent(settings.tracking_id);
            }
        }
        
        // Link attributes
        let target = settings.button_link.is_external ? ' target="_blank"' : '';
        let nofollow = settings.button_link.nofollow ? ' rel="nofollow"' : '';
        let custom = settings.button_link.custom_attributes ? ' ' + settings.button_link.custom_attributes : '';
        let ariaLabel = ' aria-label="Get ' + settings.tool_name + ' deal"';
        
        // Image alt text
        let imageAlt = settings.tool_name + ' logo';
        #>
        
        <div class="{{ cardClasses.join(' ') }}" data-category="{{ settings.tool_category }}">
            
            <# if (settings.show_discount === 'yes' && settings.discount_text) { #>
            <div class="aiq-tool-card__badge">
                {{ settings.discount_text }}
            </div>
            <# } #>
            
            <div class="aiq-tool-card__logo-wrapper">
                <#
                var image = {
                    id: settings.tool_logo.id,
                    url: settings.tool_logo.url,
                    size: settings.tool_logo_size,
                    dimension: settings.tool_logo_custom_dimension,
                    model: view.getEditModel()
                };
                var image_url = elementor.imagesManager.getImageUrl( image );
                #>
                <img src="{{ image_url }}" alt="{{ imageAlt }}" class="aiq-tool-card__logo">
            </div>
            
            <div class="aiq-tool-card__content">
                <div class="aiq-tool-card__header">
                    <h3 class="aiq-tool-card__title">{{{ settings.tool_name }}}</h3>
                    
                    <div class="aiq-tool-card__meta">
                        <span class="aiq-tool-card__category" style="--category-color: {{ categoryColor }}">
                            {{ settings.tool_category }}
                        </span>
                        
                        <# if (settings.show_verified === 'yes') { #>
                            {{{ renderVerifiedBadge() }}}
                        <# } #>
                    </div>
                </div>
                
                <# if (settings.show_rating === 'yes') { #>
                    {{{ renderStars(settings.rating.size) }}}
                <# } #>
                
                <div class="aiq-tool-card__description">
                    {{{ settings.tool_description }}}
                </div>
                
                <div class="aiq-tool-card__footer">
                    <div class="aiq-tool-card__price">
                        <# if (settings.show_discount === 'yes' && settings.original_price) { #>
                            <span class="aiq-tool-card__price-original">{{{ settings.original_price }}}</span>
                        <# } #>
                        
                        <span class="aiq-tool-card__price-current">{{{ settings.discount_price }}}</span>
                    </div>
                    
                    <a class="aiq-tool-card__button" href="{{ url }}"{{ target }}{{ nofollow }}{{ custom }}{{ ariaLabel }} data-tracking-id="{{ settings.tracking_id }}">
                        {{{ settings.button_text }}}
                    </a>
                </div>
            </div>
        </div>
        <?php
    }
}

// Register widget
function register_aiq_tool_card_widget($widgets_manager) {
    $widgets_manager->register(new AIQ_Tool_Card_Widget());
}
add_action('elementor/widgets/register', 'register_aiq_tool_card_widget');
