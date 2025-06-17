// widgets/class-value-timeline-widget.php

<?php
/**
 * Value Timeline Widget
 *
 * @package AIQEngage
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Value Timeline Widget for Elementor
 */
class AIQEngage_Value_Timeline_Widget extends \Elementor\Widget_Base {

    /**
     * Get widget name.
     *
     * @return string Widget name.
     */
    public function get_name() {
        return 'aiq_value_timeline';
    }

    /**
     * Get widget title.
     *
     * @return string Widget title.
     */
    public function get_title() {
        return esc_html__( 'Value Timeline', 'aiqengage' );
    }

    /**
     * Get widget icon.
     *
     * @return string Widget icon.
     */
    public function get_icon() {
        return 'eicon-timeline';
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
     * Get widget keywords.
     *
     * @return array Widget keywords.
     */
    public function get_keywords() {
        return [ 'timeline', 'steps', 'roadmap', 'value', 'journey', 'milestones' ];
    }

    /**
     * Register widget controls.
     */
    protected function register_controls() {

        // Content Tab
        $this->start_controls_section(
            'section_timeline_content',
            [
                'label' => esc_html__( 'Timeline Content', 'aiqengage' ),
                'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'timeline_title',
            [
                'label'       => esc_html__( 'Timeline Title', 'aiqengage' ),
                'type'        => \Elementor\Controls_Manager::TEXT,
                'default'     => esc_html__( 'Our Journey', 'aiqengage' ),
                'placeholder' => esc_html__( 'Enter your timeline title', 'aiqengage' ),
                'label_block' => true,
            ]
        );

        $this->add_control(
            'timeline_description',
            [
                'label'       => esc_html__( 'Timeline Description', 'aiqengage' ),
                'type'        => \Elementor\Controls_Manager::TEXTAREA,
                'default'     => esc_html__( 'Follow our value journey from beginning to now', 'aiqengage' ),
                'placeholder' => esc_html__( 'Enter timeline description', 'aiqengage' ),
                'rows'        => 5,
            ]
        );

        $this->add_control(
            'timeline_type',
            [
                'label'   => esc_html__( 'Timeline Type', 'aiqengage' ),
                'type'    => \Elementor\Controls_Manager::SELECT,
                'default' => 'journey',
                'options' => [
                    'journey'   => esc_html__( 'Journey/History', 'aiqengage' ),
                    'roadmap'   => esc_html__( 'Roadmap/Future', 'aiqengage' ),
                    'case_study' => esc_html__( 'Case Study Progression', 'aiqengage' ),
                ],
            ]
        );

        $this->add_control(
            'timeline_orientation',
            [
                'label'   => esc_html__( 'Orientation', 'aiqengage' ),
                'type'    => \Elementor\Controls_Manager::SELECT,
                'default' => 'vertical',
                'options' => [
                    'vertical'   => esc_html__( 'Vertical', 'aiqengage' ),
                    'horizontal' => esc_html__( 'Horizontal', 'aiqengage' ),
                ],
            ]
        );

        $milestone_repeater = new \Elementor\Repeater();

        $milestone_repeater->add_control(
            'milestone_title',
            [
                'label'       => esc_html__( 'Title', 'aiqengage' ),
                'type'        => \Elementor\Controls_Manager::TEXT,
                'default'     => esc_html__( 'Milestone Title', 'aiqengage' ),
                'label_block' => true,
            ]
        );

        $milestone_repeater->add_control(
            'milestone_description',
            [
                'label'       => esc_html__( 'Description', 'aiqengage' ),
                'type'        => \Elementor\Controls_Manager::TEXTAREA,
                'default'     => esc_html__( 'Milestone description goes here. Explain the value or achievement.', 'aiqengage' ),
                'placeholder' => esc_html__( 'Enter milestone description', 'aiqengage' ),
                'rows'        => 3,
            ]
        );

        $milestone_repeater->add_control(
            'milestone_date',
            [
                'label'       => esc_html__( 'Date or Number', 'aiqengage' ),
                'type'        => \Elementor\Controls_Manager::TEXT,
                'default'     => esc_html__( 'June 2025', 'aiqengage' ),
                'placeholder' => esc_html__( 'Date, year, or number', 'aiqengage' ),
            ]
        );

        $milestone_repeater->add_control(
            'icon_type',
            [
                'label'   => esc_html__( 'Icon Type', 'aiqengage' ),
                'type'    => \Elementor\Controls_Manager::CHOOSE,
                'options' => [
                    'icon' => [
                        'title' => esc_html__( 'Icon', 'aiqengage' ),
                        'icon'  => 'eicon-star',
                    ],
                    'image' => [
                        'title' => esc_html__( 'Image', 'aiqengage' ),
                        'icon'  => 'eicon-image',
                    ],
                ],
                'default' => 'icon',
                'toggle'  => true,
            ]
        );

        $milestone_repeater->add_control(
            'milestone_icon',
            [
                'label'     => esc_html__( 'Icon', 'aiqengage' ),
                'type'      => \Elementor\Controls_Manager::ICONS,
                'default'   => [
                    'value'   => 'fas fa-star',
                    'library' => 'fa-solid',
                ],
                'condition' => [
                    'icon_type' => 'icon',
                ],
            ]
        );

        $milestone_repeater->add_control(
            'milestone_image',
            [
                'label'     => esc_html__( 'Image', 'aiqengage' ),
                'type'      => \Elementor\Controls_Manager::MEDIA,
                'default'   => [
                    'url' => \Elementor\Utils::get_placeholder_image_src(),
                ],
                'condition' => [
                    'icon_type' => 'image',
                ],
            ]
        );

        $milestone_repeater->add_control(
            'milestone_status',
            [
                'label'   => esc_html__( 'Status', 'aiqengage' ),
                'type'    => \Elementor\Controls_Manager::SELECT,
                'default' => 'completed',
                'options' => [
                    'completed' => esc_html__( 'Completed', 'aiqengage' ),
                    'active'    => esc_html__( 'Active/Current', 'aiqengage' ),
                    'upcoming'  => esc_html__( 'Upcoming', 'aiqengage' ),
                ],
            ]
        );

        $milestone_repeater->add_control(
            'milestone_badge',
            [
                'label'       => esc_html__( 'Badge Text', 'aiqengage' ),
                'type'        => \Elementor\Controls_Manager::TEXT,
                'placeholder' => esc_html__( 'Now, Pro, etc.', 'aiqengage' ),
            ]
        );

        $this->add_control(
            'milestones',
            [
                'label'       => esc_html__( 'Milestones', 'aiqengage' ),
                'type'        => \Elementor\Controls_Manager::REPEATER,
                'fields'      => $milestone_repeater->get_controls(),
                'default'     => [
                    [
                        'milestone_title'       => esc_html__( 'First Milestone', 'aiqengage' ),
                        'milestone_description' => esc_html__( 'Our journey began with a simple idea and a commitment to quality.', 'aiqengage' ),
                        'milestone_date'        => esc_html__( 'January 2025', 'aiqengage' ),
                        'milestone_status'      => 'completed',
                    ],
                    [
                        'milestone_title'       => esc_html__( 'Second Milestone', 'aiqengage' ),
                        'milestone_description' => esc_html__( 'We expanded our capabilities and reached new audiences.', 'aiqengage' ),
                        'milestone_date'        => esc_html__( 'March 2025', 'aiqengage' ),
                        'milestone_status'      => 'completed',
                    ],
                    [
                        'milestone_title'       => esc_html__( 'Current Stage', 'aiqengage' ),
                        'milestone_description' => esc_html__( 'We are now focused on innovation and scaling our impact.', 'aiqengage' ),
                        'milestone_date'        => esc_html__( 'June 2025', 'aiqengage' ),
                        'milestone_status'      => 'active',
                        'milestone_badge'       => 'Now',
                    ],
                    [
                        'milestone_title'       => esc_html__( 'Future Goal', 'aiqengage' ),
                        'milestone_description' => esc_html__( 'Our roadmap includes exciting new features and partnerships.', 'aiqengage' ),
                        'milestone_date'        => esc_html__( 'December 2025', 'aiqengage' ),
                        'milestone_status'      => 'upcoming',
                    ],
                ],
                'title_field' => '{{{ milestone_title }}}',
            ]
        );

        $this->end_controls_section();

        // Additional Options Section
        $this->start_controls_section(
            'section_additional_options',
            [
                'label' => esc_html__( 'Additional Options', 'aiqengage' ),
                'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'show_connectors',
            [
                'label'     => esc_html__( 'Show Connectors', 'aiqengage' ),
                'type'      => \Elementor\Controls_Manager::SWITCHER,
                'default'   => 'yes',
                'label_on'  => esc_html__( 'Yes', 'aiqengage' ),
                'label_off' => esc_html__( 'No', 'aiqengage' ),
            ]
        );

        $this->add_control(
            'animation_effect',
            [
                'label'   => esc_html__( 'Animation Effect', 'aiqengage' ),
                'type'    => \Elementor\Controls_Manager::SELECT,
                'default' => 'fade',
                'options' => [
                    'none'      => esc_html__( 'None', 'aiqengage' ),
                    'fade'      => esc_html__( 'Fade In', 'aiqengage' ),
                    'slide'     => esc_html__( 'Slide In', 'aiqengage' ),
                    'grow'      => esc_html__( 'Grow', 'aiqengage' ),
                    'highlight' => esc_html__( 'Highlight', 'aiqengage' ),
                ],
            ]
        );

        $this->add_control(
            'show_progress',
            [
                'label'     => esc_html__( 'Show Progress Line', 'aiqengage' ),
                'type'      => \Elementor\Controls_Manager::SWITCHER,
                'default'   => 'yes',
                'label_on'  => esc_html__( 'Yes', 'aiqengage' ),
                'label_off' => esc_html__( 'No', 'aiqengage' ),
            ]
        );

        $this->end_controls_section();

        // Style Tab - Timeline Container
        $this->start_controls_section(
            'section_timeline_style',
            [
                'label' => esc_html__( 'Timeline Container', 'aiqengage' ),
                'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_responsive_control(
            'timeline_width',
            [
                'label'      => esc_html__( 'Width', 'aiqengage' ),
                'type'       => \Elementor\Controls_Manager::SLIDER,
                'size_units' => [ 'px', '%' ],
                'range'      => [
                    'px' => [
                        'min' => 200,
                        'max' => 1200,
                    ],
                    '%'  => [
                        'min' => 10,
                        'max' => 100,
                    ],
                ],
                'default'    => [
                    'unit' => '%',
                    'size' => 100,
                ],
                'selectors'  => [
                    '{{WRAPPER}} .aiq-value-timeline' => 'width: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'timeline_padding',
            [
                'label'      => esc_html__( 'Padding', 'aiqengage' ),
                'type'       => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em', '%' ],
                'default'    => [
                    'top'    => '20',
                    'right'  => '20',
                    'bottom' => '20',
                    'left'   => '20',
                    'unit'   => 'px',
                ],
                'selectors'  => [
                    '{{WRAPPER}} .aiq-value-timeline' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Background::get_type(),
            [
                'name'     => 'timeline_background',
                'label'    => esc_html__( 'Background', 'aiqengage' ),
                'types'    => [ 'classic', 'gradient' ],
                'selector' => '{{WRAPPER}} .aiq-value-timeline',
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name'     => 'timeline_border',
                'label'    => esc_html__( 'Border', 'aiqengage' ),
                'selector' => '{{WRAPPER}} .aiq-value-timeline',
            ]
        );

        $this->add_control(
            'timeline_border_radius',
            [
                'label'      => esc_html__( 'Border Radius', 'aiqengage' ),
                'type'       => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%' ],
                'default'    => [
                    'top'    => '15',
                    'right'  => '15',
                    'bottom' => '15',
                    'left'   => '15',
                    'unit'   => 'px',
                ],
                'selectors'  => [
                    '{{WRAPPER}} .aiq-value-timeline' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Box_Shadow::get_type(),
            [
                'name'     => 'timeline_box_shadow',
                'label'    => esc_html__( 'Box Shadow', 'aiqengage' ),
                'selector' => '{{WRAPPER}} .aiq-value-timeline',
            ]
        );

        $this->end_controls_section();

        // Style Tab - Title & Description
        $this->start_controls_section(
            'section_header_style',
            [
                'label' => esc_html__( 'Title & Description', 'aiqengage' ),
                'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'title_color',
            [
                'label'     => esc_html__( 'Title Color', 'aiqengage' ),
                'type'      => \Elementor\Controls_Manager::COLOR,
                'default'   => '#E0D6FF',
                'selectors' => [
                    '{{WRAPPER}} .aiq-value-timeline__title' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name'     => 'title_typography',
                'label'    => esc_html__( 'Title Typography', 'aiqengage' ),
                'selector' => '{{WRAPPER}} .aiq-value-timeline__title',
            ]
        );

        $this->add_responsive_control(
            'title_margin',
            [
                'label'      => esc_html__( 'Title Margin', 'aiqengage' ),
                'type'       => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em', '%' ],
                'selectors'  => [
                    '{{WRAPPER}} .aiq-value-timeline__title' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'description_color',
            [
                'label'     => esc_html__( 'Description Color', 'aiqengage' ),
                'type'      => \Elementor\Controls_Manager::COLOR,
                'default'   => 'rgba(224, 214, 255, 0.8)',
                'selectors' => [
                    '{{WRAPPER}} .aiq-value-timeline__description' => 'color: {{VALUE}};',
                ],
                'separator' => 'before',
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name'     => 'description_typography',
                'label'    => esc_html__( 'Description Typography', 'aiqengage' ),
                'selector' => '{{WRAPPER}} .aiq-value-timeline__description',
            ]
        );

        $this->add_responsive_control(
            'description_margin',
            [
                'label'      => esc_html__( 'Description Margin', 'aiqengage' ),
                'type'       => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em', '%' ],
                'selectors'  => [
                    '{{WRAPPER}} .aiq-value-timeline__description' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();

        // Style Tab - Milestone Items
        $this->start_controls_section(
            'section_milestone_style',
            [
                'label' => esc_html__( 'Milestone Items', 'aiqengage' ),
                'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_responsive_control(
            'milestone_spacing',
            [
                'label'      => esc_html__( 'Spacing Between Items', 'aiqengage' ),
                'type'       => \Elementor\Controls_Manager::SLIDER,
                'size_units' => [ 'px' ],
                'range'      => [
                    'px' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                ],
                'default'    => [
                    'unit' => 'px',
                    'size' => 40,
                ],
                'selectors'  => [
                    '{{WRAPPER}} .aiq-value-timeline--vertical .aiq-value-timeline__item:not(:last-child)' => 'margin-bottom: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}} .aiq-value-timeline--horizontal .aiq-value-timeline__item:not(:last-child)' => 'margin-right: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'milestone_padding',
            [
                'label'      => esc_html__( 'Padding', 'aiqengage' ),
                'type'       => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em', '%' ],
                'selectors'  => [
                    '{{WRAPPER}} .aiq-value-timeline__item-content' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
                'default'    => [
                    'top'    => '20',
                    'right'  => '20',
                    'bottom' => '20',
                    'left'   => '20',
                    'unit'   => 'px',
                ],
            ]
        );

        $this->add_control(
            'milestone_title_color',
            [
                'label'     => esc_html__( 'Title Color', 'aiqengage' ),
                'type'      => \Elementor\Controls_Manager::COLOR,
                'default'   => '#9C4DFF',
                'selectors' => [
                    '{{WRAPPER}} .aiq-value-timeline__item-title' => 'color: {{VALUE}};',
                ],
                'separator' => 'before',
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name'     => 'milestone_title_typography',
                'label'    => esc_html__( 'Title Typography', 'aiqengage' ),
                'selector' => '{{WRAPPER}} .aiq-value-timeline__item-title',
            ]
        );

        $this->add_control(
            'milestone_description_color',
            [
                'label'     => esc_html__( 'Description Color', 'aiqengage' ),
                'type'      => \Elementor\Controls_Manager::COLOR,
                'default'   => '#E0D6FF',
                'selectors' => [
                    '{{WRAPPER}} .aiq-value-timeline__item-description' => 'color: {{VALUE}};',
                ],
                'separator' => 'before',
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name'     => 'milestone_description_typography',
                'label'    => esc_html__( 'Description Typography', 'aiqengage' ),
                'selector' => '{{WRAPPER}} .aiq-value-timeline__item-description',
            ]
        );

        $this->add_control(
            'milestone_date_color',
            [
                'label'     => esc_html__( 'Date Color', 'aiqengage' ),
                'type'      => \Elementor\Controls_Manager::COLOR,
                'default'   => 'rgba(224, 214, 255, 0.6)',
                'selectors' => [
                    '{{WRAPPER}} .aiq-value-timeline__item-date' => 'color: {{VALUE}};',
                ],
                'separator' => 'before',
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name'     => 'milestone_date_typography',
                'label'    => esc_html__( 'Date Typography', 'aiqengage' ),
                'selector' => '{{WRAPPER}} .aiq-value-timeline__item-date',
            ]
        );

        $this->add_control(
            'milestone_bg_color',
            [
                'label'     => esc_html__( 'Background Color', 'aiqengage' ),
                'type'      => \Elementor\Controls_Manager::COLOR,
                'default'   => '#2A1958',
                'selectors' => [
                    '{{WRAPPER}} .aiq-value-timeline__item-content' => 'background-color: {{VALUE}};',
                ],
                'separator' => 'before',
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name'     => 'milestone_border',
                'label'    => esc_html__( 'Border', 'aiqengage' ),
                'selector' => '{{WRAPPER}} .aiq-value-timeline__item-content',
                'default'  => [
                    'border-style' => 'solid',
                    'border-width' => 1,
                    'border-color' => 'rgba(156, 77, 255, 0.3)',
                ],
            ]
        );

        $this->add_control(
            'milestone_border_radius',
            [
                'label'      => esc_html__( 'Border Radius', 'aiqengage' ),
                'type'       => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%' ],
                'default'    => [
                    'top'    => '15',
                    'right'  => '15',
                    'bottom' => '15',
                    'left'   => '15',
                    'unit'   => 'px',
                ],
                'selectors'  => [
                    '{{WRAPPER}} .aiq-value-timeline__item-content' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Box_Shadow::get_type(),
            [
                'name'     => 'milestone_box_shadow',
                'label'    => esc_html__( 'Box Shadow', 'aiqengage' ),
                'selector' => '{{WRAPPER}} .aiq-value-timeline__item-content',
            ]
        );

        $this->end_controls_section();

        // Style Tab - Connector & Marker
        $this->start_controls_section(
            'section_connector_style',
            [
                'label' => esc_html__( 'Connector & Markers', 'aiqengage' ),
                'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'connector_color',
            [
                'label'     => esc_html__( 'Connector Color', 'aiqengage' ),
                'type'      => \Elementor\Controls_Manager::COLOR,
                'default'   => 'rgba(156, 77, 255, 0.3)',
                'selectors' => [
                    '{{WRAPPER}} .aiq-value-timeline__connector' => 'background-color: {{VALUE}};',
                ],
                'condition' => [
                    'show_connectors' => 'yes',
                ],
            ]
        );

        $this->add_control(
            'progress_color',
            [
                'label'     => esc_html__( 'Progress Color', 'aiqengage' ),
                'type'      => \Elementor\Controls_Manager::COLOR,
                'default'   => '#9C4DFF',
                'selectors' => [
                    '{{WRAPPER}} .aiq-value-timeline__progress' => 'background-color: {{VALUE}};',
                ],
                'condition' => [
                    'show_progress' => 'yes',
                ],
            ]
        );

        $this->add_responsive_control(
            'connector_width',
            [
                'label'      => esc_html__( 'Connector Width', 'aiqengage' ),
                'type'       => \Elementor\Controls_Manager::SLIDER,
                'size_units' => [ 'px' ],
                'range'      => [
                    'px' => [
                        'min' => 1,
                        'max' => 10,
                    ],
                ],
                'default'    => [
                    'unit' => 'px',
                    'size' => 2,
                ],
                'selectors'  => [
                    '{{WRAPPER}} .aiq-value-timeline--vertical .aiq-value-timeline__connector, {{WRAPPER}} .aiq-value-timeline--vertical .aiq-value-timeline__progress' => 'width: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}} .aiq-value-timeline--horizontal .aiq-value-timeline__connector, {{WRAPPER}} .aiq-value-timeline--horizontal .aiq-value-timeline__progress' => 'height: {{SIZE}}{{UNIT}};',
                ],
                'condition'  => [
                    'show_connectors' => 'yes',
                ],
            ]
        );

        $this->add_control(
            'marker_heading',
            [
                'label'     => esc_html__( 'Markers', 'aiqengage' ),
                'type'      => \Elementor\Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );

        $this->add_responsive_control(
            'marker_size',
            [
                'label'      => esc_html__( 'Marker Size', 'aiqengage' ),
                'type'       => \Elementor\Controls_Manager::SLIDER,
                'size_units' => [ 'px' ],
                'range'      => [
                    'px' => [
                        'min' => 20,
                        'max' => 80,
                    ],
                ],
                'default'    => [
                    'unit' => 'px',
                    'size' => 40,
                ],
                'selectors'  => [
                    '{{WRAPPER}} .aiq-value-timeline__marker' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'marker_background',
            [
                'label'     => esc_html__( 'Marker Background', 'aiqengage' ),
                'type'      => \Elementor\Controls_Manager::COLOR,
                'default'   => '#2A1958',
                'selectors' => [
                    '{{WRAPPER}} .aiq-value-timeline__marker' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'marker_border_color',
            [
                'label'     => esc_html__( 'Marker Border Color', 'aiqengage' ),
                'type'      => \Elementor\Controls_Manager::COLOR,
                'default'   => 'rgba(156, 77, 255, 0.3)',
                'selectors' => [
                    '{{WRAPPER}} .aiq-value-timeline__marker' => 'border-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'marker_border_width',
            [
                'label'      => esc_html__( 'Marker Border Width', 'aiqengage' ),
                'type'       => \Elementor\Controls_Manager::SLIDER,
                'size_units' => [ 'px' ],
                'range'      => [
                    'px' => [
                        'min' => 0,
                        'max' => 10,
                    ],
                ],
                'default'    => [
                    'unit' => 'px',
                    'size' => 1,
                ],
                'selectors'  => [
                    '{{WRAPPER}} .aiq-value-timeline__marker' => 'border-width: {{SIZE}}{{UNIT}}; border-style: solid;',
                ],
            ]
        );

        $this->add_control(
            'marker_border_radius',
            [
                'label'      => esc_html__( 'Marker Border Radius', 'aiqengage' ),
                'type'       => \Elementor\Controls_Manager::SLIDER,
                'size_units' => [ 'px', '%' ],
                'range'      => [
                    'px' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                    '%'  => [
                        'min' => 0,
                        'max' => 50,
                    ],
                ],
                'default'    => [
                    'unit' => '%',
                    'size' => 50,
                ],
                'selectors'  => [
                    '{{WRAPPER}} .aiq-value-timeline__marker' => 'border-radius: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'icon_color',
            [
                'label'     => esc_html__( 'Icon Color', 'aiqengage' ),
                'type'      => \Elementor\Controls_Manager::COLOR,
                'default'   => '#E0D6FF',
                'selectors' => [
                    '{{WRAPPER}} .aiq-value-timeline__marker i' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .aiq-value-timeline__marker svg' => 'fill: {{VALUE}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'icon_size',
            [
                'label'      => esc_html__( 'Icon Size', 'aiqengage' ),
                'type'       => \Elementor\Controls_Manager::SLIDER,
                'size_units' => [ 'px' ],
                'range'      => [
                    'px' => [
                        'min' => 10,
                        'max' => 50,
                    ],
                ],
                'default'    => [
                    'unit' => 'px',
                    'size' => 20,
                ],
                'selectors'  => [
                    '{{WRAPPER}} .aiq-value-timeline__marker i' => 'font-size: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}} .aiq-value-timeline__marker svg' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        // Styling for Status States
        $this->add_control(
            'status_heading',
            [
                'label'     => esc_html__( 'Status States', 'aiqengage' ),
                'type'      => \Elementor\Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );

        // Completed State
        $this->add_control(
            'completed_marker_color',
            [
                'label'     => esc_html__( 'Completed Marker Border', 'aiqengage' ),
                'type'      => \Elementor\Controls_Manager::COLOR,
                'default'   => '#9C4DFF',
                'selectors' => [
                    '{{WRAPPER}} .aiq-value-timeline__item--completed .aiq-value-timeline__marker' => 'border-color: {{VALUE}};',
                ],
            ]
        );

        // Active State
        $this->add_control(
            'active_marker_color',
            [
                'label'     => esc_html__( 'Active Marker Background', 'aiqengage' ),
                'type'      => \Elementor\Controls_Manager::COLOR,
                'default'   => '#9C4DFF',
                'selectors' => [
                    '{{WRAPPER}} .aiq-value-timeline__item--active .aiq-value-timeline__marker' => 'background-color: {{VALUE}}; border-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'active_icon_color',
            [
                'label'     => esc_html__( 'Active Icon Color', 'aiqengage' ),
                'type'      => \Elementor\Controls_Manager::COLOR,
                'default'   => '#FFFFFF',
                'selectors' => [
                    '{{WRAPPER}} .aiq-value-timeline__item--active .aiq-value-timeline__marker i' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .aiq-value-timeline__item--active .aiq-value-timeline__marker svg' => 'fill: {{VALUE}};',
                ],
            ]
        );

        // Upcoming State
        $this->add_control(
            'upcoming_marker_opacity',
            [
                'label'      => esc_html__( 'Upcoming Item Opacity', 'aiqengage' ),
                'type'       => \Elementor\Controls_Manager::SLIDER,
                'size_units' => [ '%' ],
                'range'      => [
                    '%' => [
                        'min' => 30,
                        'max' => 100,
                    ],
                ],
                'default'    => [
                    'unit' => '%',
                    'size' => 60,
                ],
                'selectors'  => [
                    '{{WRAPPER}} .aiq-value-timeline__item--upcoming' => 'opacity: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();

        // Style Tab - Badge
        $this->start_controls_section(
            'section_badge_style',
            [
                'label' => esc_html__( 'Badge', 'aiqengage' ),
                'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'badge_background',
            [
                'label'     => esc_html__( 'Background Color', 'aiqengage' ),
                'type'      => \Elementor\Controls_Manager::COLOR,
                'default'   => '#FFD700',
                'selectors' => [
                    '{{WRAPPER}} .aiq-value-timeline__badge' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'badge_text_color',
            [
                'label'     => esc_html__( 'Text Color', 'aiqengage' ),
                'type'      => \Elementor\Controls_Manager::COLOR,
                'default'   => '#1A0938',
                'selectors' => [
                    '{{WRAPPER}} .aiq-value-timeline__badge' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name'     => 'badge_typography',
                'label'    => esc_html__( 'Typography', 'aiqengage' ),
                'selector' => '{{WRAPPER}} .aiq-value-timeline__badge',
            ]
        );

        $this->add_responsive_control(
            'badge_padding',
            [
                'label'      => esc_html__( 'Padding', 'aiqengage' ),
                'type'       => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em' ],
                'default'    => [
                    'top'    => '3',
                    'right'  => '8',
                    'bottom' => '3',
                    'left'   => '8',
                    'unit'   => 'px',
                ],
                'selectors'  => [
                    '{{WRAPPER}} .aiq-value-timeline__badge' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'badge_border_radius',
            [
                'label'      => esc_html__( 'Border Radius', 'aiqengage' ),
                'type'       => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%' ],
                'default'    => [
                    'top'    => '20',
                    'right'  => '20',
                    'bottom' => '20',
                    'left'   => '20',
                    'unit'   => 'px',
                ],
                'selectors'  => [
                    '{{WRAPPER}} .aiq-value-timeline__badge' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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

        $this->add_render_attribute( 'wrapper', 'class', [
            'aiq-value-timeline',
            'aiq-value-timeline--' . $settings['timeline_orientation'],
            'aiq-value-timeline--' . $settings['timeline_type'],
        ] );

        $this->add_render_attribute( 'milestones', 'class', 'aiq-value-timeline__items' );
        $this->add_render_attribute( 'milestones', 'role', 'list' );

        // Animation class
        if ( $settings['animation_effect'] !== 'none' ) {
            $this->add_render_attribute( 'wrapper', 'class', 'aiq-value-timeline--animate-' . $settings['animation_effect'] );
            $this->add_render_attribute( 'wrapper', 'data-animation', $settings['animation_effect'] );
        }
        ?>
        <div <?php echo $this->get_render_attribute_string( 'wrapper' ); ?>>
            <?php if ( $settings['timeline_title'] || $settings['timeline_description'] ) : ?>
                <div class="aiq-value-timeline__header">
                    <?php if ( $settings['timeline_title'] ) : ?>
                        <h2 class="aiq-value-timeline__title"><?php echo esc_html( $settings['timeline_title'] ); ?></h2>
                    <?php endif; ?>

                    <?php if ( $settings['timeline_description'] ) : ?>
                        <div class="aiq-value-timeline__description"><?php echo wp_kses_post( $settings['timeline_description'] ); ?></div>
                    <?php endif; ?>
                </div>
            <?php endif; ?>

            <div <?php echo $this->get_render_attribute_string( 'milestones' ); ?>>
                <?php
                if ( $settings['show_connectors'] === 'yes' && $settings['milestones'] ) {
                    echo '<div class="aiq-value-timeline__connector-wrapper">';
                    echo '<div class="aiq-value-timeline__connector"></div>';
                    
                    if ( $settings['show_progress'] === 'yes' ) {
                        echo '<div class="aiq-value-timeline__progress"></div>';
                    }
                    
                    echo '</div>';
                }
                ?>

                <?php
                foreach ( $settings['milestones'] as $index => $item ) :
                    $milestone_key = $this->get_repeater_setting_key( 'milestone', 'milestones', $index );
                    $this->add_render_attribute( $milestone_key, 'class', [
                        'aiq-value-timeline__item',
                        'aiq-value-timeline__item--' . $item['milestone_status'],
                        'elementor-repeater-item-' . $item['_id'],
                    ] );
                    $this->add_render_attribute( $milestone_key, 'role', 'listitem' );
                    $this->add_render_attribute( $milestone_key, 'data-index', $index );
                    ?>
                    <div <?php echo $this->get_render_attribute_string( $milestone_key ); ?>>
                        <div class="aiq-value-timeline__marker" aria-hidden="true">
                            <?php if ( $item['icon_type'] === 'icon' && ! empty( $item['milestone_icon']['value'] ) ) : ?>
                                <?php \Elementor\Icons_Manager::render_icon( $item['milestone_icon'], [ 'aria-hidden' => 'true' ] ); ?>
                            <?php elseif ( $item['icon_type'] === 'image' && ! empty( $item['milestone_image']['url'] ) ) : ?>
                                <img src="<?php echo esc_url( $item['milestone_image']['url'] ); ?>" alt="<?php echo esc_attr( $item['milestone_title'] ); ?>">
                            <?php else : ?>
                                <i class="fas fa-star" aria-hidden="true"></i>
                            <?php endif; ?>
                        </div>

                        <div class="aiq-value-timeline__item-content">
                            <?php if ( ! empty( $item['milestone_badge'] ) ) : ?>
                                <div class="aiq-value-timeline__badge"><?php echo esc_html( $item['milestone_badge'] ); ?></div>
                            <?php endif; ?>

                            <?php if ( ! empty( $item['milestone_date'] ) ) : ?>
                                <div class="aiq-value-timeline__item-date"><?php echo esc_html( $item['milestone_date'] ); ?></div>
                            <?php endif; ?>

                            <?php if ( ! empty( $item['milestone_title'] ) ) : ?>
                                <h3 class="aiq-value-timeline__item-title"><?php echo esc_html( $item['milestone_title'] ); ?></h3>
                            <?php endif; ?>

                            <?php if ( ! empty( $item['milestone_description'] ) ) : ?>
                                <div class="aiq-value-timeline__item-description"><?php echo wp_kses_post( $item['milestone_description'] ); ?></div>
                            <?php endif; ?>
                        </div>
                    </div>
                <?php endforeach; ?>
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
        view.addRenderAttribute( 'wrapper', 'class', [
            'aiq-value-timeline',
            'aiq-value-timeline--' + settings.timeline_orientation,
            'aiq-value-timeline--' + settings.timeline_type
        ]);

        view.addRenderAttribute( 'milestones', 'class', 'aiq-value-timeline__items' );
        view.addRenderAttribute( 'milestones', 'role', 'list' );

        if ( settings.animation_effect !== 'none' ) {
            view.addRenderAttribute( 'wrapper', 'class', 'aiq-value-timeline--animate-' + settings.animation_effect );
            view.addRenderAttribute( 'wrapper', 'data-animation', settings.animation_effect );
        }
        #>
        <div {{{ view.getRenderAttributeString( 'wrapper' ) }}}>
            <# if ( settings.timeline_title || settings.timeline_description ) { #>
                <div class="aiq-value-timeline__header">
                    <# if ( settings.timeline_title ) { #>
                        <h2 class="aiq-value-timeline__title">{{{ settings.timeline_title }}}</h2>
                    <# } #>

                    <# if ( settings.timeline_description ) { #>
                        <div class="aiq-value-timeline__description">{{{ settings.timeline_description }}}</div>
                    <# } #>
                </div>
            <# } #>

            <div {{{ view.getRenderAttributeString( 'milestones' ) }}}>
                <# if ( settings.show_connectors === 'yes' && settings.milestones.length ) { #>
                    <div class="aiq-value-timeline__connector-wrapper">
                        <div class="aiq-value-timeline__connector"></div>
                        <# if ( settings.show_progress === 'yes' ) { #>
                            <div class="aiq-value-timeline__progress"></div>
                        <# } #>
                    </div>
                <# } #>

                <# _.each( settings.milestones, function( item, index ) { 
                    var milestoneKey = view.getRepeaterSettingKey( 'milestone', 'milestones', index );
                    view.addRenderAttribute( milestoneKey, 'class', [
                        'aiq-value-timeline__item',
                        'aiq-value-timeline__item--' + item.milestone_status,
                        'elementor-repeater-item-' + item._id
                    ]);
                    view.addRenderAttribute( milestoneKey, 'role', 'listitem' );
                    view.addRenderAttribute( milestoneKey, 'data-index', index );
                #>
                    <div {{{ view.getRenderAttributeString( milestoneKey ) }}}>
                        <div class="aiq-value-timeline__marker" aria-hidden="true">
                            <# if ( item.icon_type === 'icon' && item.milestone_icon.value ) { #>
                                <# var iconHTML = elementor.helpers.renderIcon( view, item.milestone_icon, { 'aria-hidden': true }, 'i', 'object' ); #>
                                {{{ iconHTML.value }}}
                            <# } else if ( item.icon_type === 'image' && item.milestone_image.url ) { #>
                                <img src="{{{ item.milestone_image.url }}}" alt="{{{ item.milestone_title }}}">
                            <# } else { #>
                                <i class="fas fa-star" aria-hidden="true"></i>
                            <# } #>
                        </div>

                        <div class="aiq-value-timeline__item-content">
                            <# if ( item.milestone_badge ) { #>
                                <div class="aiq-value-timeline__badge">{{{ item.milestone_badge }}}</div>
                            <# } #>

                            <# if ( item.milestone_date ) { #>
                                <div class="aiq-value-timeline__item-date">{{{ item.milestone_date }}}</div>
                            <# } #>

                            <# if ( item.milestone_title ) { #>
                                <h3 class="aiq-value-timeline__item-title">{{{ item.milestone_title }}}</h3>
                            <# } #>

                            <# if ( item.milestone_description ) { #>
                                <div class="aiq-value-timeline__item-description">{{{ item.milestone_description }}}</div>
                            <# } #>
                        </div>
                    </div>
                <# }); #>
            </div>
        </div>
        <?php
    }
}

// Register widget
\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new AIQEngage_Value_Timeline_Widget() );
