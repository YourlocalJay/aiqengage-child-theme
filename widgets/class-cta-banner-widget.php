// widgets/class-cta-banner-widget.php

<?php
/**
 * CTA Banner Widget for AIQEngage
 * 
 * @package AIQEngage
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * CTA Banner Widget
 */
class AIQ_CTA_Banner_Widget extends \Elementor\Widget_Base {

    /**
     * Get widget name.
     *
     * @return string Widget name.
     */
    public function get_name() {
        return 'aiq_cta_banner';
    }

    /**
     * Get widget title.
     *
     * @return string Widget title.
     */
    public function get_title() {
        return esc_html__( 'CTA Banner', 'aiqengage' );
    }

    /**
     * Get widget icon.
     *
     * @return string Widget icon.
     */
    public function get_icon() {
        return 'eicon-announcement';
    }
    
    /**
     * Get widget keywords.
     *
     * @return array Widget keywords.
     */
    public function get_keywords() {
        return [ 'cta', 'banner', 'sticky', 'bar', 'call to action', 'dual button', 'gradient' ];
    }

    /**
     * Get widget categories.
     *
     * @return array Widget categories.
     */
    public function get_categories() {
        return [ 'aiqengage' ];
    }

    /**
     * Register widget controls.
     */
    protected function register_controls() {

        // Content Section
        $this->start_controls_section(
            'section_content',
            [
                'label' => esc_html__( 'Content', 'aiqengage' ),
                'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'headline',
            [
                'label'       => esc_html__( 'Headline', 'aiqengage' ),
                'type'        => \Elementor\Controls_Manager::TEXT,
                'default'     => esc_html__( 'Ready to unlock Claude\'s most trusted growth stacks?', 'aiqengage' ),
                'placeholder' => esc_html__( 'Enter your headline', 'aiqengage' ),
                'label_block' => true,
            ]
        );

        $this->add_control(
            'show_subheadline',
            [
                'label'        => esc_html__( 'Show Subheadline', 'aiqengage' ),
                'type'         => \Elementor\Controls_Manager::SWITCHER,
                'label_on'     => esc_html__( 'Yes', 'aiqengage' ),
                'label_off'    => esc_html__( 'No', 'aiqengage' ),
                'return_value' => 'yes',
                'default'      => '',
            ]
        );

        $this->add_control(
            'subheadline',
            [
                'label'       => esc_html__( 'Subheadline', 'aiqengage' ),
                'type'        => \Elementor\Controls_Manager::TEXT,
                'default'     => esc_html__( 'Get instant access to our proven automation systems', 'aiqengage' ),
                'placeholder' => esc_html__( 'Enter your subheadline', 'aiqengage' ),
                'label_block' => true,
                'condition'   => [
                    'show_subheadline' => 'yes',
                ],
            ]
        );
        
        $this->end_controls_section();

        // Primary Button Section
        $this->start_controls_section(
            'section_primary_button',
            [
                'label' => esc_html__( 'Primary Button', 'aiqengage' ),
                'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'primary_button_text',
            [
                'label'       => esc_html__( 'Button Text', 'aiqengage' ),
                'type'        => \Elementor\Controls_Manager::TEXT,
                'default'     => esc_html__( '🔓 View Vault', 'aiqengage' ),
                'placeholder' => esc_html__( 'Enter button text', 'aiqengage' ),
            ]
        );

        $this->add_control(
            'primary_button_link',
            [
                'label'       => esc_html__( 'Button Link', 'aiqengage' ),
                'type'        => \Elementor\Controls_Manager::URL,
                'placeholder' => esc_html__( 'https://your-link.com', 'aiqengage' ),
                'default'     => [
                    'url'               => '#',
                    'is_external'       => false,
                    'nofollow'          => false,
                    'custom_attributes' => '',
                ],
            ]
        );

        $this->add_control(
            'primary_button_id',
            [
                'label'       => esc_html__( 'Button ID (optional)', 'aiqengage' ),
                'type'        => \Elementor\Controls_Manager::TEXT,
                'placeholder' => esc_html__( 'button-id', 'aiqengage' ),
                'description' => esc_html__( 'Add an ID for tracking or custom styling', 'aiqengage' ),
            ]
        );

        $this->end_controls_section();

        // Secondary Button Section
        $this->start_controls_section(
            'section_secondary_button',
            [
                'label' => esc_html__( 'Secondary Button', 'aiqengage' ),
                'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'show_secondary_button',
            [
                'label'        => esc_html__( 'Show Secondary Button', 'aiqengage' ),
                'type'         => \Elementor\Controls_Manager::SWITCHER,
                'label_on'     => esc_html__( 'Yes', 'aiqengage' ),
                'label_off'    => esc_html__( 'No', 'aiqengage' ),
                'return_value' => 'yes',
                'default'      => 'yes',
            ]
        );

        $this->add_control(
            'secondary_button_text',
            [
                'label'       => esc_html__( 'Button Text', 'aiqengage' ),
                'type'        => \Elementor\Controls_Manager::TEXT,
                'default'     => esc_html__( '💡 Get Recommendations', 'aiqengage' ),
                'placeholder' => esc_html__( 'Enter button text', 'aiqengage' ),
                'condition'   => [
                    'show_secondary_button' => 'yes',
                ],
            ]
        );

        $this->add_control(
            'secondary_button_link',
            [
                'label'       => esc_html__( 'Button Link', 'aiqengage' ),
                'type'        => \Elementor\Controls_Manager::URL,
                'placeholder' => esc_html__( 'https://your-link.com', 'aiqengage' ),
                'default'     => [
                    'url'               => '#',
                    'is_external'       => false,
                    'nofollow'          => false,
                    'custom_attributes' => '',
                ],
                'condition'   => [
                    'show_secondary_button' => 'yes',
                ],
            ]
        );

        $this->add_control(
            'secondary_button_id',
            [
                'label'       => esc_html__( 'Button ID (optional)', 'aiqengage' ),
                'type'        => \Elementor\Controls_Manager::TEXT,
                'placeholder' => esc_html__( 'button-id', 'aiqengage' ),
                'description' => esc_html__( 'Add an ID for tracking or custom styling', 'aiqengage' ),
                'condition'   => [
                    'show_secondary_button' => 'yes',
                ],
            ]
        );

        $this->end_controls_section();

        // Pro Badge Section
        $this->start_controls_section(
            'section_pro_badge',
            [
                'label' => esc_html__( 'Pro Badge', 'aiqengage' ),
                'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'show_pro_badge',
            [
                'label'        => esc_html__( 'Show Pro Badge', 'aiqengage' ),
                'type'         => \Elementor\Controls_Manager::SWITCHER,
                'label_on'     => esc_html__( 'Yes', 'aiqengage' ),
                'label_off'    => esc_html__( 'No', 'aiqengage' ),
                'return_value' => 'yes',
                'default'      => '',
            ]
        );

        $this->add_control(
            'pro_badge_text',
            [
                'label'       => esc_html__( 'Badge Text', 'aiqengage' ),
                'type'        => \Elementor\Controls_Manager::TEXT,
                'default'     => esc_html__( 'PRO', 'aiqengage' ),
                'placeholder' => esc_html__( 'Enter badge text', 'aiqengage' ),
                'condition'   => [
                    'show_pro_badge' => 'yes',
                ],
            ]
        );

        $this->add_control(
            'pro_badge_icon',
            [
                'label'       => esc_html__( 'Badge Icon', 'aiqengage' ),
                'type'        => \Elementor\Controls_Manager::TEXT,
                'default'     => esc_html__( '🔒', 'aiqengage' ),
                'placeholder' => esc_html__( 'Enter emoji or icon', 'aiqengage' ),
                'condition'   => [
                    'show_pro_badge' => 'yes',
                ],
            ]
        );

        $this->end_controls_section();

        // Layout & Behavior Section
        $this->start_controls_section(
            'section_layout',
            [
                'label' => esc_html__( 'Layout & Behavior', 'aiqengage' ),
                'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'layout_type',
            [
                'label'   => esc_html__( 'Layout Type', 'aiqengage' ),
                'type'    => \Elementor\Controls_Manager::SELECT,
                'default' => 'standard',
                'options' => [
                    'standard'   => esc_html__( 'Standard (Container Width)', 'aiqengage' ),
                    'full-width' => esc_html__( 'Full Width', 'aiqengage' ),
                ],
            ]
        );

        $this->add_control(
            'make_sticky',
            [
                'label'        => esc_html__( 'Make Sticky', 'aiqengage' ),
                'type'         => \Elementor\Controls_Manager::SWITCHER,
                'label_on'     => esc_html__( 'Yes', 'aiqengage' ),
                'label_off'    => esc_html__( 'No', 'aiqengage' ),
                'return_value' => 'yes',
                'default'      => '',
            ]
        );

        $this->add_control(
            'sticky_position',
            [
                'label'     => esc_html__( 'Sticky Position', 'aiqengage' ),
                'type'      => \Elementor\Controls_Manager::SELECT,
                'default'   => 'bottom',
                'options'   => [
                    'top'    => esc_html__( 'Top', 'aiqengage' ),
                    'bottom' => esc_html__( 'Bottom', 'aiqengage' ),
                ],
                'condition' => [
                    'make_sticky' => 'yes',
                ],
            ]
        );

        $this->add_control(
            'scroll_trigger',
            [
                'label'     => esc_html__( 'Show After Scroll (%)', 'aiqengage' ),
                'type'      => \Elementor\Controls_Manager::SLIDER,
                'range'     => [
                    '%' => [
                        'min'  => 0,
                        'max'  => 100,
                        'step' => 1,
                    ],
                ],
                'default'   => [
                    'unit' => '%',
                    'size' => 45,
                ],
                'condition' => [
                    'make_sticky' => 'yes',
                ],
            ]
        );

        $this->add_control(
            'show_close_button',
            [
                'label'        => esc_html__( 'Show Close Button', 'aiqengage' ),
                'type'         => \Elementor\Controls_Manager::SWITCHER,
                'label_on'     => esc_html__( 'Yes', 'aiqengage' ),
                'label_off'    => esc_html__( 'No', 'aiqengage' ),
                'return_value' => 'yes',
                'default'      => '',
                'condition'    => [
                    'make_sticky' => 'yes',
                ],
            ]
        );

        $this->add_control(
            'close_cookie_expiry',
            [
                'label'       => esc_html__( 'Close Button Cookie Expiry (days)', 'aiqengage' ),
                'type'        => \Elementor\Controls_Manager::NUMBER,
                'min'         => 1,
                'max'         => 365,
                'step'        => 1,
                'default'     => 7,
                'description' => esc_html__( 'Number of days before showing again after close', 'aiqengage' ),
                'condition'   => [
                    'make_sticky'      => 'yes',
                    'show_close_button' => 'yes',
                ],
            ]
        );

        $this->end_controls_section();

        // Styles - General
        $this->start_controls_section(
            'section_style_general',
            [
                'label' => esc_html__( 'General', 'aiqengage' ),
                'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'background_type',
            [
                'label'   => esc_html__( 'Background Type', 'aiqengage' ),
                'type'    => \Elementor\Controls_Manager::SELECT,
                'default' => 'gradient',
                'options' => [
                    'gradient' => esc_html__( 'Gradient', 'aiqengage' ),
                    'solid'    => esc_html__( 'Solid Color', 'aiqengage' ),
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Background::get_type(),
            [
                'name'           => 'background_gradient',
                'types'          => [ 'gradient' ],
                'exclude'        => [ 'image' ],
                'selector'       => '{{WRAPPER}} .aiq-cta-banner',
                'fields_options' => [
                    'background' => [
                        'default' => 'gradient',
                    ],
                    'color' => [
                        'default' => '#2A1958',
                    ],
                    'color_b' => [
                        'default' => '#1A0938',
                    ],
                    'gradient_angle' => [
                        'default' => [
                            'unit' => 'deg',
                            'size' => 90,
                        ],
                    ],
                ],
                'condition'      => [
                    'background_type' => 'gradient',
                ],
            ]
        );

        $this->add_control(
            'background_color',
            [
                'label'     => esc_html__( 'Background Color', 'aiqengage' ),
                'type'      => \Elementor\Controls_Manager::COLOR,
                'default'   => '#1A0938',
                'selectors' => [
                    '{{WRAPPER}} .aiq-cta-banner' => 'background-color: {{VALUE}};',
                ],
                'condition' => [
                    'background_type' => 'solid',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Box_Shadow::get_type(),
            [
                'name'     => 'box_shadow',
                'selector' => '{{WRAPPER}} .aiq-cta-banner',
                'fields_options' => [
                    'box_shadow_type' => [
                        'default' => 'yes',
                    ],
                    'box_shadow' => [
                        'default' => [
                            'horizontal' => 0,
                            'vertical'   => 5,
                            'blur'       => 15,
                            'spread'     => 0,
                            'color'      => 'rgba(0, 0, 0, 0.3)',
                        ],
                    ],
                ],
            ]
        );

        $this->add_responsive_control(
            'padding',
            [
                'label'      => esc_html__( 'Padding', 'aiqengage' ),
                'type'       => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em', '%' ],
                'selectors'  => [
                    '{{WRAPPER}} .aiq-cta-banner' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
                'default'    => [
                    'top'      => '20',
                    'right'    => '20',
                    'bottom'   => '20',
                    'left'     => '20',
                    'unit'     => 'px',
                    'isLinked' => true,
                ],
            ]
        );

        $this->add_responsive_control(
            'border_radius',
            [
                'label'      => esc_html__( 'Border Radius', 'aiqengage' ),
                'type'       => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%' ],
                'selectors'  => [
                    '{{WRAPPER}} .aiq-cta-banner' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
                'default'    => [
                    'top'      => '0',
                    'right'    => '0',
                    'bottom'   => '0',
                    'left'     => '0',
                    'unit'     => 'px',
                    'isLinked' => true,
                ],
            ]
        );

        $this->add_control(
            'z_index',
            [
                'label'     => esc_html__( 'Z-Index', 'aiqengage' ),
                'type'      => \Elementor\Controls_Manager::NUMBER,
                'min'       => 0,
                'max'       => 9999,
                'step'      => 1,
                'default'   => 1000,
                'selectors' => [
                    '{{WRAPPER}} .aiq-cta-banner' => 'z-index: {{VALUE}};',
                ],
                'condition' => [
                    'make_sticky' => 'yes',
                ],
            ]
        );

        $this->end_controls_section();

        // Styles - Typography
        $this->start_controls_section(
            'section_style_typography',
            [
                'label' => esc_html__( 'Typography', 'aiqengage' ),
                'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'headline_color',
            [
                'label'     => esc_html__( 'Headline Color', 'aiqengage' ),
                'type'      => \Elementor\Controls_Manager::COLOR,
                'default'   => '#E0D6FF',
                'selectors' => [
                    '{{WRAPPER}} .aiq-cta-banner__headline' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name'     => 'headline_typography',
                'selector' => '{{WRAPPER}} .aiq-cta-banner__headline',
                'fields_options' => [
                    'typography'     => ['default' => 'yes'],
                    'font_family'    => ['default' => 'Inter'],
                    'font_size'      => ['default' => ['size' => 18, 'unit' => 'px']],
                    'font_weight'    => ['default' => '600'],
                    'line_height'    => ['default' => ['size' => 1.4, 'unit' => 'em']],
                ],
            ]
        );

        $this->add_control(
            'subheadline_color',
            [
                'label'     => esc_html__( 'Subheadline Color', 'aiqengage' ),
                'type'      => \Elementor\Controls_Manager::COLOR,
                'default'   => 'rgba(224, 214, 255, 0.8)',
                'selectors' => [
                    '{{WRAPPER}} .aiq-cta-banner__subheadline' => 'color: {{VALUE}};',
                ],
                'condition' => [
                    'show_subheadline' => 'yes',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name'      => 'subheadline_typography',
                'selector'  => '{{WRAPPER}} .aiq-cta-banner__subheadline',
                'condition' => [
                    'show_subheadline' => 'yes',
                ],
                'fields_options' => [
                    'typography'     => ['default' => 'yes'],
                    'font_family'    => ['default' => 'Inter'],
                    'font_size'      => ['default' => ['size' => 14, 'unit' => 'px']],
                    'font_weight'    => ['default' => '400'],
                    'line_height'    => ['default' => ['size' => 1.4, 'unit' => 'em']],
                ],
            ]
        );

        $this->end_controls_section();

        // Styles - Primary Button
        $this->start_controls_section(
            'section_style_primary_button',
            [
                'label' => esc_html__( 'Primary Button', 'aiqengage' ),
                'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        $this->start_controls_tabs(
            'tabs_primary_button_style'
        );

        // Normal state
        $this->start_controls_tab(
            'tab_primary_button_normal',
            [
                'label' => esc_html__( 'Normal', 'aiqengage' ),
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Background::get_type(),
            [
                'name'           => 'primary_button_background',
                'types'          => [ 'gradient', 'classic' ],
                'exclude'        => [ 'image' ],
                'selector'       => '{{WRAPPER}} .aiq-cta-banner__button--primary',
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

        $this->add_control(
            'primary_button_text_color',
            [
                'label'     => esc_html__( 'Text Color', 'aiqengage' ),
                'type'      => \Elementor\Controls_Manager::COLOR,
                'default'   => '#FFFFFF',
                'selectors' => [
                    '{{WRAPPER}} .aiq-cta-banner__button--primary' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name'     => 'primary_button_border',
                'selector' => '{{WRAPPER}} .aiq-cta-banner__button--primary',
            ]
        );

        $this->add_responsive_control(
            'primary_button_border_radius',
            [
                'label'      => esc_html__( 'Border Radius', 'aiqengage' ),
                'type'       => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%' ],
                'selectors'  => [
                    '{{WRAPPER}} .aiq-cta-banner__button--primary' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
                'default'    => [
                    'top'      => '8',
                    'right'    => '8',
                    'bottom'   => '8',
                    'left'     => '8',
                    'unit'     => 'px',
                    'isLinked' => true,
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Box_Shadow::get_type(),
            [
                'name'     => 'primary_button_box_shadow',
                'selector' => '{{WRAPPER}} .aiq-cta-banner__button--primary',
            ]
        );

        $this->end_controls_tab();

        // Hover state
        $this->start_controls_tab(
            'tab_primary_button_hover',
            [
                'label' => esc_html__( 'Hover', 'aiqengage' ),
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Background::get_type(),
            [
                'name'           => 'primary_button_background_hover',
                'types'          => [ 'gradient', 'classic' ],
                'exclude'        => [ 'image' ],
                'selector'       => '{{WRAPPER}} .aiq-cta-banner__button--primary:hover',
                'fields_options' => [
                    'background' => [
                        'default' => 'gradient',
                    ],
                    'color' => [
                        'default' => '#8c45e5',
                    ],
                    'color_b' => [
                        'default' => '#5467cd',
                    ],
                ],
            ]
        );

        $this->add_control(
            'primary_button_text_color_hover',
            [
                'label'     => esc_html__( 'Text Color', 'aiqengage' ),
                'type'      => \Elementor\Controls_Manager::COLOR,
                'default'   => '#FFFFFF',
                'selectors' => [
                    '{{WRAPPER}} .aiq-cta-banner__button--primary:hover' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Box_Shadow::get_type(),
            [
                'name'     => 'primary_button_box_shadow_hover',
                'selector' => '{{WRAPPER}} .aiq-cta-banner__button--primary:hover',
                'fields_options' => [
                    'box_shadow_type' => [
                        'default' => 'yes',
                    ],
                    'box_shadow' => [
                        'default' => [
                            'horizontal' => 0,
                            'vertical'   => 5,
                            'blur'       => 15,
                            'spread'     => 0,
                            'color'      => 'rgba(94, 114, 228, 0.4)',
                        ],
                    ],
                ],
            ]
        );

        $this->add_control(
            'primary_button_animation',
            [
                'label'   => esc_html__( 'Hover Animation', 'aiqengage' ),
                'type'    => \Elementor\Controls_Manager::SELECT,
                'default' => 'float',
                'options' => [
                    ''          => esc_html__( 'None', 'aiqengage' ),
                    'float'     => esc_html__( 'Float Up', 'aiqengage' ),
                    'pulse'     => esc_html__( 'Pulse', 'aiqengage' ),
                    'transform' => esc_html__( 'Scale', 'aiqengage' ),
                ],
            ]
        );

        $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name'     => 'primary_button_typography',
                'selector' => '{{WRAPPER}} .aiq-cta-banner__button--primary',
                'separator' => 'before',
                'fields_options' => [
                    'typography'     => ['default' => 'yes'],
                    'font_family'    => ['default' => 'Inter'],
                    'font_size'      => ['default' => ['size' => 16, 'unit' => 'px']],
                    'font_weight'    => ['default' => '600'],
                    'line_height'    => ['default' => ['size' => 1.2, 'unit' => 'em']],
                ],
            ]
        );

        $this->add_responsive_control(
            'primary_button_padding',
            [
                'label'      => esc_html__( 'Padding', 'aiqengage' ),
                'type'       => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em', '%' ],
                'selectors'  => [
                    '{{WRAPPER}} .aiq-cta-banner__button--primary' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
                'default'    => [
                    'top'      => '12',
                    'right'    => '24',
                    'bottom'   => '12',
                    'left'     => '24',
                    'unit'     => 'px',
                    'isLinked' => false,
                ],
            ]
        );

        $this->end_controls_section();

        // Styles - Secondary Button
        $this->start_controls_section(
            'section_style_secondary_button',
            [
                'label'     => esc_html__( 'Secondary Button', 'aiqengage' ),
                'tab'       => \Elementor\Controls_Manager::TAB_STYLE,
                'condition' => [
                    'show_secondary_button' => 'yes',
                ],
            ]
        );

        $this->start_controls_tabs(
            'tabs_secondary_button_style'
        );

        // Normal state
        $this->start_controls_tab(
            'tab_secondary_button_normal',
            [
                'label' => esc_html__( 'Normal', 'aiqengage' ),
            ]
        );

        $this->add_control(
            'secondary_button_background_color',
            [
                'label'     => esc_html__( 'Background Color', 'aiqengage' ),
                'type'      => \Elementor\Controls_Manager::COLOR,
                'default'   => 'rgba(156, 77, 255, 0.2)',
                'selectors' => [
                    '{{WRAPPER}} .aiq-cta-banner__button--secondary' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'secondary_button_text_color',
            [
                'label'     => esc_html__( 'Text Color', 'aiqengage' ),
                'type'      => \Elementor\Controls_Manager::COLOR,
                'default'   => '#E0D6FF',
                'selectors' => [
                    '{{WRAPPER}} .aiq-cta-banner__button--secondary' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name'     => 'secondary_button_border',
                'selector' => '{{WRAPPER}} .aiq-cta-banner__button--secondary',
                'fields_options' => [
                    'border' => [
                        'default' => 'solid',
                    ],
                    'width' => [
                        'default' => [
                            'top'    => 1,
                            'right'  => 1,
                            'bottom' => 1,
                            'left'   => 1,
                            'unit'   => 'px',
                        ],
                    ],
                    'color' => [
                        'default' => '#9C4DFF',
                    ],
                ],
            ]
        );

        $this->add_responsive_control(
            'secondary_button_border_radius',
            [
                'label'      => esc_html__( 'Border Radius', 'aiqengage' ),
                'type'       => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%' ],
                'selectors'  => [
                    '{{WRAPPER}} .aiq-cta-banner__button--secondary' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
                'default'    => [
                    'top'      => '8',
                    'right'    => '8',
                    'bottom'   => '8',
                    'left'     => '8',
                    'unit'     => 'px',
                    'isLinked' => true,
                ],
            ]
        );

        $this->end_controls_tab();

        // Hover state
        $this->start_controls_tab(
            'tab_secondary_button_hover',
            [
                'label' => esc_html__( 'Hover', 'aiqengage' ),
            ]
        );

        $this->add_control(
            'secondary_button_background_color_hover',
            [
                'label'     => esc_html__( 'Background Color', 'aiqengage' ),
                'type'      => \Elementor\Controls_Manager::COLOR,
                'default'   => 'rgba(156, 77, 255, 0.3)',
                'selectors' => [
                    '{{WRAPPER}} .aiq-cta-banner__button--secondary:hover' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'secondary_button_text_color_hover',
            [
                'label'     => esc_html__( 'Text Color', 'aiqengage' ),
                'type'      => \Elementor\Controls_Manager::COLOR,
                'default'   => '#E0D6FF',
                'selectors' => [
                    '{{WRAPPER}} .aiq-cta-banner__button--secondary:hover' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'secondary_button_border_color_hover',
            [
                'label'     => esc_html__( 'Border Color', 'aiqengage' ),
                'type'      => \Elementor\Controls_Manager::COLOR,
                'default'   => '#B673FF',
                'selectors' => [
                    '{{WRAPPER}} .aiq-cta-banner__button--secondary:hover' => 'border-color: {{VALUE}};',
                ],
                'condition' => [
                    'secondary_button_border_border!' => '',
                ],
            ]
        );

        $this->add_control(
            'secondary_button_animation',
            [
                'label'   => esc_html__( 'Hover Animation', 'aiqengage' ),
                'type'    => \Elementor\Controls_Manager::SELECT,
                'default' => 'float',
                'options' => [
                    ''          => esc_html__( 'None', 'aiqengage' ),
                    'float'     => esc_html__( 'Float Up', 'aiqengage' ),
                    'pulse'     => esc_html__( 'Pulse', 'aiqengage' ),
                    'transform' => esc_html__( 'Scale', 'aiqengage' ),
                ],
            ]
        );

        $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name'     => 'secondary_button_typography',
                'selector' => '{{WRAPPER}} .aiq-cta-banner__button--secondary',
                'separator' => 'before',
                'fields_options' => [
                    'typography'     => ['default' => 'yes'],
                    'font_family'    => ['default' => 'Inter'],
                    'font_size'      => ['default' => ['size' => 16, 'unit' => 'px']],
                    'font_weight'    => ['default' => '600'],
                    'line_height'    => ['default' => ['size' => 1.2, 'unit' => 'em']],
                ],
            ]
        );

        $this->add_responsive_control(
            'secondary_button_padding',
            [
                'label'      => esc_html__( 'Padding', 'aiqengage' ),
                'type'       => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em', '%' ],
                'selectors'  => [
                    '{{WRAPPER}} .aiq-cta-banner__button--secondary' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
                'default'    => [
                    'top'      => '12',
                    'right'    => '24',
                    'bottom'   => '12',
                    'left'     => '24',
                    'unit'     => 'px',
                    'isLinked' => false,
                ],
            ]
        );

        $this->end_controls_section();

        // Styles - Pro Badge
        $this->start_controls_section(
            'section_style_pro_badge',
            [
                'label'     => esc_html__( 'Pro Badge', 'aiqengage' ),
                'tab'       => \Elementor\Controls_Manager::TAB_STYLE,
                'condition' => [
                    'show_pro_badge' => 'yes',
                ],
            ]
        );

        $this->add_control(
            'pro_badge_background_color',
            [
                'label'     => esc_html__( 'Background Color', 'aiqengage' ),
                'type'      => \Elementor\Controls_Manager::COLOR,
                'default'   => '#FFD700',
                'selectors' => [
                    '{{WRAPPER}} .aiq-cta-banner__pro-badge' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'pro_badge_text_color',
            [
                'label'     => esc_html__( 'Text Color', 'aiqengage' ),
                'type'      => \Elementor\Controls_Manager::COLOR,
                'default'   => '#1A0938',
                'selectors' => [
                    '{{WRAPPER}} .aiq-cta-banner__pro-badge' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name'     => 'pro_badge_typography',
                'selector' => '{{WRAPPER}} .aiq-cta-banner__pro-badge',
                'fields_options' => [
                    'typography'     => ['default' => 'yes'],
                    'font_family'    => ['default' => 'Inter'],
                    'font_size'      => ['default' => ['size' => 12, 'unit' => 'px']],
                    'font_weight'    => ['default' => '700'],
                    'line_height'    => ['default' => ['size' => 1, 'unit' => 'em']],
                ],
            ]
        );

        $this->add_responsive_control(
            'pro_badge_border_radius',
            [
                'label'      => esc_html__( 'Border Radius', 'aiqengage' ),
                'type'       => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%' ],
                'selectors'  => [
                    '{{WRAPPER}} .aiq-cta-banner__pro-badge' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
                'default'    => [
                    'top'      => '12',
                    'right'    => '12',
                    'bottom'   => '12',
                    'left'     => '12',
                    'unit'     => 'px',
                    'isLinked' => true,
                ],
            ]
        );

        $this->add_responsive_control(
            'pro_badge_padding',
            [
                'label'      => esc_html__( 'Padding', 'aiqengage' ),
                'type'       => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em', '%' ],
                'selectors'  => [
                    '{{WRAPPER}} .aiq-cta-banner__pro-badge' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
                'default'    => [
                    'top'      => '4',
                    'right'    => '8',
                    'bottom'   => '4',
                    'left'     => '8',
                    'unit'     => 'px',
                    'isLinked' => false,
                ],
            ]
        );

        $this->add_responsive_control(
            'pro_badge_margin',
            [
                'label'      => esc_html__( 'Margin', 'aiqengage' ),
                'type'       => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em', '%' ],
                'selectors'  => [
                    '{{WRAPPER}} .aiq-cta-banner__pro-badge' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
                'default'    => [
                    'top'      => '0',
                    'right'    => '0',
                    'bottom'   => '0',
                    'left'     => '10',
                    'unit'     => 'px',
                    'isLinked' => false,
                ],
            ]
        );

        $this->end_controls_section();

        // Styles - Layout
        $this->start_controls_section(
            'section_style_layout',
            [
                'label' => esc_html__( 'Layout', 'aiqengage' ),
                'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_responsive_control(
            'content_alignment',
            [
                'label'     => esc_html__( 'Content Alignment', 'aiqengage' ),
                'type'      => \Elementor\Controls_Manager::CHOOSE,
                'options'   => [
                    'flex-start'    => [
                        'title' => esc_html__( 'Left', 'aiqengage' ),
                        'icon'  => 'eicon-text-align-left',
                    ],
                    'center' => [
                        'title' => esc_html__( 'Center', 'aiqengage' ),
                        'icon'  => 'eicon-text-align-center',
                    ],
                    'flex-end' => [
                        'title' => esc_html__( 'Right', 'aiqengage' ),
                        'icon'  => 'eicon-text-align-right',
                    ],
                ],
                'default'   => 'center',
                'selectors' => [
                    '{{WRAPPER}} .aiq-cta-banner__content' => 'align-items: {{VALUE}};',
                    '{{WRAPPER}} .aiq-cta-banner__buttons' => 'justify-content: {{VALUE}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'content_text_alignment',
            [
                'label'     => esc_html__( 'Text Alignment', 'aiqengage' ),
                'type'      => \Elementor\Controls_Manager::CHOOSE,
                'options'   => [
                    'left'    => [
                        'title' => esc_html__( 'Left', 'aiqengage' ),
                        'icon'  => 'eicon-text-align-left',
                    ],
                    'center' => [
                        'title' => esc_html__( 'Center', 'aiqengage' ),
                        'icon'  => 'eicon-text-align-center',
                    ],
                    'right' => [
                        'title' => esc_html__( 'Right', 'aiqengage' ),
                        'icon'  => 'eicon-text-align-right',
                    ],
                ],
                'default'   => 'center',
                'selectors' => [
                    '{{WRAPPER}} .aiq-cta-banner__headline' => 'text-align: {{VALUE}};',
                    '{{WRAPPER}} .aiq-cta-banner__subheadline' => 'text-align: {{VALUE}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'layout_direction',
            [
                'label'     => esc_html__( 'Layout Direction', 'aiqengage' ),
                'type'      => \Elementor\Controls_Manager::SELECT,
                'default'   => 'column',
                'options'   => [
                    'column'         => esc_html__( 'Vertical', 'aiqengage' ),
                    'row'            => esc_html__( 'Horizontal', 'aiqengage' ),
                ],
                'selectors' => [
                    '{{WRAPPER}} .aiq-cta-banner' => 'flex-direction: {{VALUE}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'horizontal_layout_alignment',
            [
                'label'     => esc_html__( 'Horizontal Layout Alignment', 'aiqengage' ),
                'type'      => \Elementor\Controls_Manager::CHOOSE,
                'options'   => [
                    'flex-start'    => [
                        'title' => esc_html__( 'Start', 'aiqengage' ),
                        'icon'  => 'eicon-h-align-left',
                    ],
                    'center' => [
                        'title' => esc_html__( 'Center', 'aiqengage' ),
                        'icon'  => 'eicon-h-align-center',
                    ],
                    'flex-end' => [
                        'title' => esc_html__( 'End', 'aiqengage' ),
                        'icon'  => 'eicon-h-align-right',
                    ],
                    'space-between' => [
                        'title' => esc_html__( 'Space Between', 'aiqengage' ),
                        'icon'  => 'eicon-h-align-stretch',
                    ],
                ],
                'default'   => 'space-between',
                'selectors' => [
                    '{{WRAPPER}} .aiq-cta-banner' => 'justify-content: {{VALUE}};',
                ],
                'condition' => [
                    'layout_direction' => 'row',
                ],
            ]
        );

        $this->add_responsive_control(
            'vertical_layout_alignment',
            [
                'label'     => esc_html__( 'Vertical Layout Alignment', 'aiqengage' ),
                'type'      => \Elementor\Controls_Manager::CHOOSE,
                'options'   => [
                    'flex-start'    => [
                        'title' => esc_html__( 'Start', 'aiqengage' ),
                        'icon'  => 'eicon-v-align-top',
                    ],
                    'center' => [
                        'title' => esc_html__( 'Center', 'aiqengage' ),
                        'icon'  => 'eicon-v-align-middle',
                    ],
                    'flex-end' => [
                        'title' => esc_html__( 'End', 'aiqengage' ),
                        'icon'  => 'eicon-v-align-bottom',
                    ],
                ],
                'default'   => 'center',
                'selectors' => [
                    '{{WRAPPER}} .aiq-cta-banner' => 'align-items: {{VALUE}};',
                ],
                'condition' => [
                    'layout_direction' => 'row',
                ],
            ]
        );

        $this->add_responsive_control(
            'content_spacing',
            [
                'label'     => esc_html__( 'Content Spacing', 'aiqengage' ),
                'type'      => \Elementor\Controls_Manager::SLIDER,
                'range'     => [
                    'px' => [
                        'min'  => 0,
                        'max'  => 100,
                        'step' => 1,
                    ],
                ],
                'default'   => [
                    'unit' => 'px',
                    'size' => 15,
                ],
                'selectors' => [
                    '{{WRAPPER}} .aiq-cta-banner__headline' => 'margin-bottom: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}} .aiq-cta-banner__subheadline' => 'margin-bottom: {{SIZE}}{{UNIT}};',
                ],
                'condition' => [
                    'layout_direction' => 'column',
                ],
            ]
        );

        $this->add_responsive_control(
            'horizontal_content_width',
            [
                'label'     => esc_html__( 'Content Width (%)', 'aiqengage' ),
                'type'      => \Elementor\Controls_Manager::SLIDER,
                'range'     => [
                    '%' => [
                        'min'  => 10,
                        'max'  => 90,
                        'step' => 5,
                    ],
                ],
                'default'   => [
                    'unit' => '%',
                    'size' => 40,
                ],
                'selectors' => [
                    '{{WRAPPER}} .aiq-cta-banner__content' => 'width: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}} .aiq-cta-banner__buttons' => 'width: calc(100% - {{SIZE}}{{UNIT}});',
                ],
                'condition' => [
                    'layout_direction' => 'row',
                ],
            ]
        );

        $this->add_responsive_control(
            'button_spacing',
            [
                'label'     => esc_html__( 'Button Spacing', 'aiqengage' ),
                'type'      => \Elementor\Controls_Manager::SLIDER,
                'range'     => [
                    'px' => [
                        'min'  => 0,
                        'max'  => 50,
                        'step' => 1,
                    ],
                ],
                'default'   => [
                    'unit' => 'px',
                    'size' => 10,
                ],
                'selectors' => [
                    '{{WRAPPER}} .aiq-cta-banner__button:not(:last-child)' => 'margin-right: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}} .aiq-cta-banner__buttons--vertical .aiq-cta-banner__button:not(:last-child)' => 'margin-right: 0; margin-bottom: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'button_layout',
            [
                'label'     => esc_html__( 'Button Layout', 'aiqengage' ),
                'type'      => \Elementor\Controls_Manager::SELECT,
                'default'   => 'horizontal',
                'options'   => [
                    'horizontal' => esc_html__( 'Horizontal', 'aiqengage' ),
                    'vertical'   => esc_html__( 'Vertical', 'aiqengage' ),
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

        // Classes
        $banner_classes = ['aiq-cta-banner'];
        $buttons_classes = ['aiq-cta-banner__buttons'];
        
        if ($settings['make_sticky'] === 'yes') {
            $banner_classes[] = 'aiq-cta-banner--sticky';
            $banner_classes[] = 'aiq-cta-banner--sticky-' . $settings['sticky_position'];
        }
        
        if ($settings['layout_type'] === 'full-width') {
            $banner_classes[] = 'aiq-cta-banner--full-width';
        }

        if ($settings['button_layout'] === 'vertical') {
            $buttons_classes[] = 'aiq-cta-banner__buttons--vertical';
        }

        // Get button animations
        $primary_btn_animation = !empty($settings['primary_button_animation']) ? 'aiq-cta-banner__button--animate-' . $settings['primary_button_animation'] : '';
        $secondary_btn_animation = !empty($settings['secondary_button_animation']) ? 'aiq-cta-banner__button--animate-' . $settings['secondary_button_animation'] : '';
        
        // Generate unique ID for the banner
        $banner_id = 'aiq-cta-banner-' . $this->get_id();
        
        // Prepare data attributes for sticky functionality
        $data_attributes = '';
        if ($settings['make_sticky'] === 'yes') {
            $data_attributes .= ' data-sticky-position="' . esc_attr($settings['sticky_position']) . '"';
            $data_attributes .= ' data-scroll-trigger="' . esc_attr($settings['scroll_trigger']['size']) . '"';
            
            if ($settings['show_close_button'] === 'yes') {
                $data_attributes .= ' data-cookie-expiry="' . esc_attr($settings['close_cookie_expiry']) . '"';
            }
        }
        
        // Start output
        ?>
        <div id="<?php echo esc_attr($banner_id); ?>" class="<?php echo esc_attr(implode(' ', $banner_classes)); ?>"<?php echo $data_attributes; ?>>
            <div class="aiq-cta-banner__content">
                <?php if (!empty($settings['headline'])) : ?>
                    <h3 class="aiq-cta-banner__headline"><?php echo esc_html($settings['headline']); ?></h3>
                <?php endif; ?>
                
                <?php if ($settings['show_subheadline'] === 'yes' && !empty($settings['subheadline'])) : ?>
                    <div class="aiq-cta-banner__subheadline"><?php echo esc_html($settings['subheadline']); ?></div>
                <?php endif; ?>
            </div>
            
            <div class="<?php echo esc_attr(implode(' ', $buttons_classes)); ?>">
                <?php 
                // Primary button
                if (!empty($settings['primary_button_text'])) :
                    $this->render_button(
                        $settings['primary_button_text'], 
                        $settings['primary_button_link'], 
                        'primary', 
                        $settings['primary_button_id'],
                        $primary_btn_animation
                    );
                endif;
                
                // Secondary button
                if ($settings['show_secondary_button'] === 'yes' && !empty($settings['secondary_button_text'])) :
                    $this->render_button(
                        $settings['secondary_button_text'], 
                        $settings['secondary_button_link'], 
                        'secondary',
                        $settings['secondary_button_id'],
                        $secondary_btn_animation
                    );
                endif;
                
                // Pro badge
                if ($settings['show_pro_badge'] === 'yes' && !empty($settings['pro_badge_text'])) : ?>
                    <span class="aiq-cta-banner__pro-badge">
                        <?php if (!empty($settings['pro_badge_icon'])) : ?>
                            <span class="aiq-cta-banner__pro-badge-icon"><?php echo esc_html($settings['pro_badge_icon']); ?></span>
                        <?php endif; ?>
                        <?php echo esc_html($settings['pro_badge_text']); ?>
                    </span>
                <?php endif; ?>
            </div>
            
            <?php if ($settings['make_sticky'] === 'yes' && $settings['show_close_button'] === 'yes') : ?>
                <button class="aiq-cta-banner__close" aria-label="<?php echo esc_attr__('Close banner', 'aiqengage'); ?>">
                    <svg width="14" height="14" viewBox="0 0 14 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M13 1L1 13M1 1L13 13" stroke="#E0D6FF" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                </button>
            <?php endif; ?>
        </div>
        <?php
    }
    
    /**
     * Render button HTML
     */
    private function render_button($text, $link_settings, $style, $button_id = '', $animation_class = '') {
        $button_classes = [
            'aiq-cta-banner__button',
            'aiq-cta-banner__button--' . $style
        ];
        
        if (!empty($animation_class)) {
            $button_classes[] = $animation_class;
        }
        
        $button_attributes = '';
        if (!empty($button_id)) {
            $button_attributes .= ' id="' . esc_attr($button_id) . '"';
        }
        
        if (empty($link_settings['url'])) {
            $link_settings['url'] = '#';
        }
        
        $target = $link_settings['is_external'] ? ' target="_blank"' : '';
        $nofollow = $link_settings['nofollow'] ? ' rel="nofollow"' : '';
        $custom_attributes = !empty($link_settings['custom_attributes']) ? ' ' . $link_settings['custom_attributes'] : '';
        
        echo '<a href="' . esc_url($link_settings['url']) . '"' . $target . $nofollow . $custom_attributes . ' class="' . esc_attr(implode(' ', $button_classes)) . '"' . $button_attributes . '>' . esc_html($text) . '</a>';
    }
}
