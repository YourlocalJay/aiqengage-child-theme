// widgets/class-feature-section-widget.php

<?php
/**
 * Feature Section Widget.
 *
 * @package aiqengage-child
 * @version 1.0.0
 * @since   1.0.0
 * @author  Jason
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Feature Section Widget.
 */
class AIQ_Feature_Section_Widget extends \Elementor\Widget_Base {

	/**
	 * Get widget name.
	 *
	 * @return string Widget name.
	 */
	public function get_name() {
		return 'aiq_feature_section';
	}

	/**
	 * Get widget title.
	 *
	 * @return string Widget title.
	 */
	public function get_title() {
		return esc_html__( 'AIQ Feature Section', 'aiqengage-child' );
	}

	/**
	 * Get widget icon.
	 *
	 * @return string Widget icon.
	 */
	public function get_icon() {
		return 'eicon-bullet-list';
	}

	/**
	 * Get widget keywords.
	 *
	 * @return array Widget keywords.
	 */
	public function get_keywords() {
		return array( 'feature', 'section', 'icon', 'grid', 'list', 'card', 'cta' );
	}

	/**
	 * Get widget categories.
	 *
	 * @return array Widget categories.
	 */
	public function get_categories() {
		return array( 'aiqengage' );
	}

	/**
	 * Get widget scripts dependencies.
	 *
	 * @return string[] JS handles.
	 */
	public function get_script_depends() {
		return array( 'aiqengage-child-feature-section' );
	}

	/**
	 * Get widget style dependencies.
	 *
	 * @return string[] CSS handles.
	 */
	public function get_style_depends() {
		return array( 'aiqengage-child-feature-section' );
	}

	/**
	 * Register widget controls.
	 */
	protected function register_controls() {

		// Content Section: Headline
		$this->start_controls_section(
			'section_content_headline',
			array(
				'label' => esc_html__( 'Headline', 'aiqengage-child' ),
			)
		);

		$this->add_control(
			'headline',
			array(
				'label'       => esc_html__( 'Headline', 'aiqengage-child' ),
				'type'        => \Elementor\Controls_Manager::TEXT,
				'default'     => esc_html__( 'Features & Benefits', 'aiqengage-child' ),
				'placeholder' => esc_html__( 'Enter your headline', 'aiqengage-child' ),
				'label_block' => true,
			)
		);

		$this->add_control(
			'subheadline',
			array(
				'label'       => esc_html__( 'Subheadline', 'aiqengage-child' ),
				'type'        => \Elementor\Controls_Manager::TEXTAREA,
				'default'     => esc_html__( 'Discover what makes our solution stand out', 'aiqengage-child' ),
				'placeholder' => esc_html__( 'Enter your subheadline', 'aiqengage-child' ),
				'rows'        => 3,
			)
		);

		$this->add_control(
			'headline_alignment',
			array(
				'label'     => esc_html__( 'Alignment', 'aiqengage-child' ),
				'type'      => \Elementor\Controls_Manager::CHOOSE,
				'options'   => array(
					'left'   => array(
						'title' => esc_html__( 'Left', 'aiqengage-child' ),
						'icon'  => 'eicon-text-align-left',
					),
					'center' => array(
						'title' => esc_html__( 'Center', 'aiqengage-child' ),
						'icon'  => 'eicon-text-align-center',
					),
					'right'  => array(
						'title' => esc_html__( 'Right', 'aiqengage-child' ),
						'icon'  => 'eicon-text-align-right',
					),
				),
				'default'   => 'center',
				'toggle'    => true,
				'selectors' => array(
					'{{WRAPPER}} .aiq-feature-section__header' => 'text-align: {{VALUE}};',
				),
			)
		);

		$this->end_controls_section();

		// Content Section: Features
		$this->start_controls_section(
			'section_content_features',
			array(
				'label' => esc_html__( 'Features', 'aiqengage-child' ),
			)
		);

		$this->add_control(
			'layout_type',
			array(
				'label'   => esc_html__( 'Layout', 'aiqengage-child' ),
				'type'    => \Elementor\Controls_Manager::SELECT,
				'default' => 'grid',
				'options' => array(
					'grid'       => esc_html__( 'Grid', 'aiqengage-child' ),
					'two-column' => esc_html__( 'Two Column', 'aiqengage-child' ),
				),
			)
		);

		$this->add_control(
			'display_style',
			array(
				'label'   => esc_html__( 'Display Style', 'aiqengage-child' ),
				'type'    => \Elementor\Controls_Manager::SELECT,
				'default' => 'card',
				'options' => array(
					'card'      => esc_html__( 'Card', 'aiqengage-child' ),
					'icon-list' => esc_html__( 'Icon List', 'aiqengage-child' ),
				),
			)
		);

		$this->add_control(
			'columns',
			array(
				'label'     => esc_html__( 'Columns', 'aiqengage-child' ),
				'type'      => \Elementor\Controls_Manager::SELECT,
				'default'   => '3',
				'options'   => array(
					'1' => esc_html__( '1', 'aiqengage-child' ),
					'2' => esc_html__( '2', 'aiqengage-child' ),
					'3' => esc_html__( '3', 'aiqengage-child' ),
					'4' => esc_html__( '4', 'aiqengage-child' ),
				),
				'condition' => array(
					'layout_type' => 'grid',
				),
			)
		);

		$repeater = new \Elementor\Repeater();

		$repeater->add_control(
			'feature_title',
			array(
				'label'       => esc_html__( 'Title', 'aiqengage-child' ),
				'type'        => \Elementor\Controls_Manager::TEXT,
				'default'     => esc_html__( 'Feature Title', 'aiqengage-child' ),
				'label_block' => true,
			)
		);

		$repeater->add_control(
			'feature_description',
			array(
				'label'   => esc_html__( 'Description', 'aiqengage-child' ),
				'type'    => \Elementor\Controls_Manager::TEXTAREA,
				'default' => esc_html__( 'Feature description goes here. Keep it concise and value-focused.', 'aiqengage-child' ),
				'rows'    => 4,
			)
		);

		$repeater->add_control(
			'media_type',
			array(
				'label'   => esc_html__( 'Media Type', 'aiqengage-child' ),
				'type'    => \Elementor\Controls_Manager::CHOOSE,
				'options' => array(
					'icon'  => array(
						'title' => esc_html__( 'Icon', 'aiqengage-child' ),
						'icon'  => 'eicon-favorite',
					),
					'image' => array(
						'title' => esc_html__( 'Image', 'aiqengage-child' ),
						'icon'  => 'eicon-image',
					),
				),
				'default' => 'icon',
				'toggle'  => true,
			)
		);

		$repeater->add_control(
			'feature_icon',
			array(
				'label'     => esc_html__( 'Icon', 'aiqengage-child' ),
				'type'      => \Elementor\Controls_Manager::ICONS,
				'default'   => array(
					'value'   => 'fas fa-check',
					'library' => 'fa-solid',
				),
				'condition' => array(
					'media_type' => 'icon',
				),
			)
		);

		$repeater->add_control(
			'feature_image',
			array(
				'label'     => esc_html__( 'Image', 'aiqengage-child' ),
				'type'      => \Elementor\Controls_Manager::MEDIA,
				'default'   => array(
					'url' => \Elementor\Utils::get_placeholder_image_src(),
				),
				'condition' => array(
					'media_type' => 'image',
				),
			)
		);

		$repeater->add_control(
			'feature_accent_color',
			array(
				'label'   => esc_html__( 'Accent Color', 'aiqengage-child' ),
				'type'    => \Elementor\Controls_Manager::COLOR,
				'default' => '#9C4DFF',
			)
		);

		$this->add_control(
			'features',
			array(
				'label'       => esc_html__( 'Features', 'aiqengage-child' ),
				'type'        => \Elementor\Controls_Manager::REPEATER,
				'fields'      => $repeater->get_controls(),
				'default'     => array(
					array(
						'feature_title'        => esc_html__( 'High-Converting Funnels', 'aiqengage-child' ),
						'feature_description'  => esc_html__( 'Pre-built flows optimized for Claude-based conversions with proven results.', 'aiqengage-child' ),
						'feature_accent_color' => '#9C4DFF',
					),
					array(
						'feature_title'        => esc_html__( 'Tool Discounts', 'aiqengage-child' ),
						'feature_description'  => esc_html__( 'Exclusive 40-60% partner deals on the tools you need for automation.', 'aiqengage-child' ),
						'feature_accent_color' => '#635BFF',
					),
					array(
						'feature_title'        => esc_html__( 'Automation Systems', 'aiqengage-child' ),
						'feature_description'  => esc_html__( 'Done-for-you traffic & conversion stacks that generate real revenue.', 'aiqengage-child' ),
						'feature_accent_color' => '#8E6BFF',
					),
				),
				'title_field' => '{{{ feature_title }}}',
			)
		);

		$this->end_controls_section();

		// Content Section: CTA
		$this->start_controls_section(
			'section_content_cta',
			array(
				'label' => esc_html__( 'Call to Action', 'aiqengage-child' ),
			)
		);

		$this->add_control(
			'show_cta',
			array(
				'label'     => esc_html__( 'Show CTA Button', 'aiqengage-child' ),
				'type'      => \Elementor\Controls_Manager::SWITCHER,
				'label_on'  => esc_html__( 'Yes', 'aiqengage-child' ),
				'label_off' => esc_html__( 'No', 'aiqengage-child' ),
				'default'   => 'yes',
			)
		);

		$this->add_control(
			'cta_text',
			array(
				'label'     => esc_html__( 'Button Text', 'aiqengage-child' ),
				'type'      => \Elementor\Controls_Manager::TEXT,
				'default'   => esc_html__( 'Get Started', 'aiqengage-child' ),
				'condition' => array(
					'show_cta' => 'yes',
				),
			)
		);

		$this->add_control(
			'cta_link',
			array(
				'label'       => esc_html__( 'Button Link', 'aiqengage-child' ),
				'type'        => \Elementor\Controls_Manager::URL,
				'placeholder' => esc_html__( 'https://your-link.com', 'aiqengage-child' ),
				'default'     => array(
					'url'         => '#',
					'is_external' => false,
					'nofollow'    => false,
				),
				'condition'   => array(
					'show_cta' => 'yes',
				),
			)
		);

		$this->add_control(
			'cta_style',
			array(
				'label'     => esc_html__( 'Button Style', 'aiqengage-child' ),
				'type'      => \Elementor\Controls_Manager::SELECT,
				'default'   => 'primary',
				'options'   => array(
					'primary'   => esc_html__( 'Primary', 'aiqengage-child' ),
					'secondary' => esc_html__( 'Secondary', 'aiqengage-child' ),
				),
				'condition' => array(
					'show_cta' => 'yes',
				),
			)
		);

		$this->add_control(
			'cta_alignment',
			array(
				'label'     => esc_html__( 'Button Alignment', 'aiqengage-child' ),
				'type'      => \Elementor\Controls_Manager::CHOOSE,
				'options'   => array(
					'left'   => array(
						'title' => esc_html__( 'Left', 'aiqengage-child' ),
						'icon'  => 'eicon-text-align-left',
					),
					'center' => array(
						'title' => esc_html__( 'Center', 'aiqengage-child' ),
						'icon'  => 'eicon-text-align-center',
					),
					'right'  => array(
						'title' => esc_html__( 'Right', 'aiqengage-child' ),
						'icon'  => 'eicon-text-align-right',
					),
				),
				'default'   => 'center',
				'toggle'    => true,
				'selectors' => array(
					'{{WRAPPER}} .aiq-feature-section__cta' => 'text-align: {{VALUE}};',
				),
				'condition' => array(
					'show_cta' => 'yes',
				),
			)
		);

		$this->end_controls_section();

		// Style Section: General
		$this->start_controls_section(
			'section_style_general',
			array(
				'label' => esc_html__( 'General', 'aiqengage' ),
				'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_control(
			'section_background_color',
			array(
				'label'     => esc_html__( 'Section Background', 'aiqengage' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '#1A0938',
				'selectors' => array(
					'{{WRAPPER}} .aiq-feature-section' => 'background-color: {{VALUE}}',
				),
			)
		);

		$this->add_control(
			'show_background_pattern',
			array(
				'label'     => esc_html__( 'Show Neural Pattern', 'aiqengage' ),
				'type'      => \Elementor\Controls_Manager::SWITCHER,
				'label_on'  => esc_html__( 'Yes', 'aiqengage' ),
				'label_off' => esc_html__( 'No', 'aiqengage' ),
				'default'   => 'yes',
			)
		);

		$this->add_control(
			'pattern_opacity',
			array(
				'label'      => esc_html__( 'Pattern Opacity', 'aiqengage' ),
				'type'       => \Elementor\Controls_Manager::SLIDER,
				'size_units' => array( '%' ),
				'range'      => array(
					'%' => array(
						'min'  => 1,
						'max'  => 20,
						'step' => 1,
					),
				),
				'default'    => array(
					'unit' => '%',
					'size' => 5,
				),
				'selectors'  => array(
					'{{WRAPPER}} .aiq-feature-section__pattern' => 'opacity: {{SIZE}}{{UNIT}};',
				),
				'condition'  => array(
					'show_background_pattern' => 'yes',
				),
			)
		);

		$this->add_responsive_control(
			'section_padding',
			array(
				'label'      => esc_html__( 'Padding', 'aiqengage' ),
				'type'       => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', 'em', 'rem', '%' ),
				'default'    => array(
					'top'      => '60',
					'right'    => '20',
					'bottom'   => '60',
					'left'     => '20',
					'unit'     => 'px',
					'isLinked' => false,
				),
				'selectors'  => array(
					'{{WRAPPER}} .aiq-feature-section' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_responsive_control(
			'section_margin',
			array(
				'label'      => esc_html__( 'Margin', 'aiqengage' ),
				'type'       => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', 'em', 'rem', '%' ),
				'default'    => array(
					'top'      => '0',
					'right'    => '0',
					'bottom'   => '0',
					'left'     => '0',
					'unit'     => 'px',
					'isLinked' => true,
				),
				'selectors'  => array(
					'{{WRAPPER}} .aiq-feature-section' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_control(
			'section_border_radius',
			array(
				'label'      => esc_html__( 'Border Radius', 'aiqengage' ),
				'type'       => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%' ),
				'default'    => array(
					'top'      => '0',
					'right'    => '0',
					'bottom'   => '0',
					'left'     => '0',
					'unit'     => 'px',
					'isLinked' => true,
				),
				'selectors'  => array(
					'{{WRAPPER}} .aiq-feature-section' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_group_control(
			\Elementor\Group_Control_Box_Shadow::get_type(),
			array(
				'name'     => 'section_box_shadow',
				'selector' => '{{WRAPPER}} .aiq-feature-section',
			)
		);

		$this->end_controls_section();

		// Style Section: Headline
		$this->start_controls_section(
			'section_style_headline',
			array(
				'label' => esc_html__( 'Headline', 'aiqengage' ),
				'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_responsive_control(
			'headline_spacing',
			array(
				'label'      => esc_html__( 'Spacing', 'aiqengage' ),
				'type'       => \Elementor\Controls_Manager::SLIDER,
				'size_units' => array( 'px', 'em', 'rem' ),
				'range'      => array(
					'px'  => array(
						'min'  => 0,
						'max'  => 100,
						'step' => 1,
					),
					'em'  => array(
						'min'  => 0,
						'max'  => 10,
						'step' => 0.1,
					),
					'rem' => array(
						'min'  => 0,
						'max'  => 10,
						'step' => 0.1,
					),
				),
				'default'    => array(
					'unit' => 'px',
					'size' => 60,
				),
				'selectors'  => array(
					'{{WRAPPER}} .aiq-feature-section__header' => 'margin-bottom: {{SIZE}}{{UNIT}};',
				),
			)
		);

		$this->add_control(
			'headline_color',
			array(
				'label'     => esc_html__( 'Headline Color', 'aiqengage' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '#E0D6FF',
				'selectors' => array(
					'{{WRAPPER}} .aiq-feature-section__headline' => 'color: {{VALUE}}',
				),
			)
		);

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			array(
				'name'     => 'headline_typography',
				'selector' => '{{WRAPPER}} .aiq-feature-section__headline',
				'global'   => array(
					'default' => \Elementor\Core\Kits\Documents\Tabs\Global_Typography::TYPOGRAPHY_PRIMARY,
				),
			)
		);

		$this->add_control(
			'subheadline_color',
			array(
				'label'     => esc_html__( 'Subheadline Color', 'aiqengage' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '#E0D6FF',
				'selectors' => array(
					'{{WRAPPER}} .aiq-feature-section__subheadline' => 'color: {{VALUE}}',
				),
				'separator' => 'before',
			)
		);

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			array(
				'name'     => 'subheadline_typography',
				'selector' => '{{WRAPPER}} .aiq-feature-section__subheadline',
				'global'   => array(
					'default' => \Elementor\Core\Kits\Documents\Tabs\Global_Typography::TYPOGRAPHY_TEXT,
				),
			)
		);

		$this->add_responsive_control(
			'subheadline_spacing',
			array(
				'label'      => esc_html__( 'Subheadline Top Spacing', 'aiqengage' ),
				'type'       => \Elementor\Controls_Manager::SLIDER,
				'size_units' => array( 'px', 'em', 'rem' ),
				'range'      => array(
					'px'  => array(
						'min'  => 0,
						'max'  => 50,
						'step' => 1,
					),
					'em'  => array(
						'min'  => 0,
						'max'  => 5,
						'step' => 0.1,
					),
					'rem' => array(
						'min'  => 0,
						'max'  => 5,
						'step' => 0.1,
					),
				),
				'default'    => array(
					'unit' => 'px',
					'size' => 15,
				),
				'selectors'  => array(
					'{{WRAPPER}} .aiq-feature-section__subheadline' => 'margin-top: {{SIZE}}{{UNIT}};',
				),
			)
		);

		$this->end_controls_section();

		// Style Section: Features
		$this->start_controls_section(
			'section_style_features',
			array(
				'label' => esc_html__( 'Features', 'aiqengage' ),
				'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_responsive_control(
			'features_gap',
			array(
				'label'      => esc_html__( 'Gap Between Features', 'aiqengage' ),
				'type'       => \Elementor\Controls_Manager::SLIDER,
				'size_units' => array( 'px', 'em', 'rem' ),
				'range'      => array(
					'px'  => array(
						'min'  => 0,
						'max'  => 100,
						'step' => 1,
					),
					'em'  => array(
						'min'  => 0,
						'max'  => 10,
						'step' => 0.1,
					),
					'rem' => array(
						'min'  => 0,
						'max'  => 10,
						'step' => 0.1,
					),
				),
				'default'    => array(
					'unit' => 'px',
					'size' => 30,
				),
				'selectors'  => array(
					'{{WRAPPER}} .aiq-feature-section__grid' => 'gap: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .aiq-feature-section__two-column .aiq-feature-section__column:first-child' => 'margin-right: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .aiq-feature-section__two-column .aiq-feature-section__column:last-child' => 'margin-left: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .aiq-feature-section__icon-list .aiq-feature-section__feature:not(:last-child)' => 'margin-bottom: {{SIZE}}{{UNIT}};',
				),
			)
		);

		// Card Style
		$this->add_control(
			'card_style_heading',
			array(
				'label'     => esc_html__( 'Card Style', 'aiqengage' ),
				'type'      => \Elementor\Controls_Manager::HEADING,
				'separator' => 'before',
				'condition' => array(
					'display_style' => 'card',
				),
			)
		);

		$this->add_control(
			'card_background_color',
			array(
				'label'     => esc_html__( 'Card Background', 'aiqengage' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '#2A1958',
				'selectors' => array(
					'{{WRAPPER}} .aiq-feature-section__feature--card' => 'background-color: {{VALUE}}',
				),
				'condition' => array(
					'display_style' => 'card',
				),
			)
		);

		$this->add_group_control(
			\Elementor\Group_Control_Border::get_type(),
			array(
				'name'      => 'card_border',
				'selector'  => '{{WRAPPER}} .aiq-feature-section__feature--card',
				'condition' => array(
					'display_style' => 'card',
				),
			)
		);

		$this->add_control(
			'card_border_radius',
			array(
				'label'      => esc_html__( 'Border Radius', 'aiqengage' ),
				'type'       => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%' ),
				'default'    => array(
					'top'      => '15',
					'right'    => '15',
					'bottom'   => '15',
					'left'     => '15',
					'unit'     => 'px',
					'isLinked' => true,
				),
				'selectors'  => array(
					'{{WRAPPER}} .aiq-feature-section__feature--card' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
				'condition'  => array(
					'display_style' => 'card',
				),
			)
		);

		$this->add_group_control(
			\Elementor\Group_Control_Box_Shadow::get_type(),
			array(
				'name'      => 'card_box_shadow',
				'selector'  => '{{WRAPPER}} .aiq-feature-section__feature--card',
				'condition' => array(
					'display_style' => 'card',
				),
			)
		);

		$this->add_responsive_control(
			'card_padding',
			array(
				'label'      => esc_html__( 'Padding', 'aiqengage' ),
				'type'       => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', 'em', 'rem', '%' ),
				'default'    => array(
					'top'      => '30',
					'right'    => '30',
					'bottom'   => '30',
					'left'     => '30',
					'unit'     => 'px',
					'isLinked' => true,
				),
				'selectors'  => array(
					'{{WRAPPER}} .aiq-feature-section__feature--card' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
				'condition'  => array(
					'display_style' => 'card',
				),
			)
		);

		// Icon/Image Style
		$this->add_control(
			'icon_style_heading',
			array(
				'label'     => esc_html__( 'Icon/Image Style', 'aiqengage' ),
				'type'      => \Elementor\Controls_Manager::HEADING,
				'separator' => 'before',
			)
		);

		$this->add_responsive_control(
			'icon_size',
			array(
				'label'      => esc_html__( 'Icon Size', 'aiqengage' ),
				'type'       => \Elementor\Controls_Manager::SLIDER,
				'size_units' => array( 'px', 'em', 'rem' ),
				'range'      => array(
					'px'  => array(
						'min'  => 10,
						'max'  => 100,
						'step' => 1,
					),
					'em'  => array(
						'min'  => 1,
						'max'  => 10,
						'step' => 0.1,
					),
					'rem' => array(
						'min'  => 1,
						'max'  => 10,
						'step' => 0.1,
					),
				),
				'default'    => array(
					'unit' => 'px',
					'size' => 36,
				),
				'selectors'  => array(
					'{{WRAPPER}} .aiq-feature-section__icon i' => 'font-size: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .aiq-feature-section__icon svg' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
				),
			)
		);

		$this->add_responsive_control(
			'image_width',
			array(
				'label'      => esc_html__( 'Image Width', 'aiqengage' ),
				'type'       => \Elementor\Controls_Manager::SLIDER,
				'size_units' => array( 'px', '%' ),
				'range'      => array(
					'px' => array(
						'min'  => 10,
						'max'  => 300,
						'step' => 1,
					),
					'%'  => array(
						'min'  => 10,
						'max'  => 100,
						'step' => 1,
					),
				),
				'default'    => array(
					'unit' => 'px',
					'size' => 80,
				),
				'selectors'  => array(
					'{{WRAPPER}} .aiq-feature-section__image img' => 'width: {{SIZE}}{{UNIT}};',
				),
			)
		);

		$this->add_responsive_control(
			'icon_spacing',
			array(
				'label'      => esc_html__( 'Media Spacing', 'aiqengage' ),
				'type'       => \Elementor\Controls_Manager::SLIDER,
				'size_units' => array( 'px', 'em', 'rem' ),
				'range'      => array(
					'px'  => array(
						'min'  => 0,
						'max'  => 50,
						'step' => 1,
					),
					'em'  => array(
						'min'  => 0,
						'max'  => 5,
						'step' => 0.1,
					),
					'rem' => array(
						'min'  => 0,
						'max'  => 5,
						'step' => 0.1,
					),
				),
				'default'    => array(
					'unit' => 'px',
					'size' => 20,
				),
				'selectors'  => array(
					'{{WRAPPER}} .aiq-feature-section__feature--card .aiq-feature-section__media' => 'margin-bottom: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .aiq-feature-section__feature--icon-list .aiq-feature-section__media' => 'margin-right: {{SIZE}}{{UNIT}};',
				),
			)
		);

		// Content Style
		$this->add_control(
			'content_style_heading',
			array(
				'label'     => esc_html__( 'Content Style', 'aiqengage' ),
				'type'      => \Elementor\Controls_Manager::HEADING,
				'separator' => 'before',
			)
		);

		$this->add_control(
			'feature_title_color',
			array(
				'label'     => esc_html__( 'Title Color', 'aiqengage' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '#9C4DFF',
				'selectors' => array(
					'{{WRAPPER}} .aiq-feature-section__feature-title' => 'color: {{VALUE}}',
				),
			)
		);

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			array(
				'name'     => 'feature_title_typography',
				'selector' => '{{WRAPPER}} .aiq-feature-section__feature-title',
				'global'   => array(
					'default' => \Elementor\Core\Kits\Documents\Tabs\Global_Typography::TYPOGRAPHY_SECONDARY,
				),
			)
		);

		$this->add_responsive_control(
			'feature_title_spacing',
			array(
				'label'      => esc_html__( 'Title Bottom Spacing', 'aiqengage' ),
				'type'       => \Elementor\Controls_Manager::SLIDER,
				'size_units' => array( 'px', 'em', 'rem' ),
				'range'      => array(
					'px'  => array(
						'min'  => 0,
						'max'  => 50,
						'step' => 1,
					),
					'em'  => array(
						'min'  => 0,
						'max'  => 5,
						'step' => 0.1,
					),
					'rem' => array(
						'min'  => 0,
						'max'  => 5,
						'step' => 0.1,
					),
				),
				'default'    => array(
					'unit' => 'px',
					'size' => 10,
				),
				'selectors'  => array(
					'{{WRAPPER}} .aiq-feature-section__feature-title' => 'margin-bottom: {{SIZE}}{{UNIT}};',
				),
			)
		);

		$this->add_control(
			'feature_description_color',
			array(
				'label'     => esc_html__( 'Description Color', 'aiqengage' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '#E0D6FF',
				'selectors' => array(
					'{{WRAPPER}} .aiq-feature-section__feature-description' => 'color: {{VALUE}}',
				),
				'separator' => 'before',
			)
		);

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			array(
				'name'     => 'feature_description_typography',
				'selector' => '{{WRAPPER}} .aiq-feature-section__feature-description',
				'global'   => array(
					'default' => \Elementor\Core\Kits\Documents\Tabs\Global_Typography::TYPOGRAPHY_TEXT,
				),
			)
		);

		$this->end_controls_section();

		// Style Section: CTA
		$this->start_controls_section(
			'section_style_cta',
			array(
				'label'     => esc_html__( 'Call to Action', 'aiqengage' ),
				'tab'       => \Elementor\Controls_Manager::TAB_STYLE,
				'condition' => array(
					'show_cta' => 'yes',
				),
			)
		);

		$this->add_responsive_control(
			'cta_spacing',
			array(
				'label'      => esc_html__( 'Top Spacing', 'aiqengage' ),
				'type'       => \Elementor\Controls_Manager::SLIDER,
				'size_units' => array( 'px', 'em', 'rem' ),
				'range'      => array(
					'px'  => array(
						'min'  => 0,
						'max'  => 100,
						'step' => 1,
					),
					'em'  => array(
						'min'  => 0,
						'max'  => 10,
						'step' => 0.1,
					),
					'rem' => array(
						'min'  => 0,
						'max'  => 10,
						'step' => 0.1,
					),
				),
				'default'    => array(
					'unit' => 'px',
					'size' => 50,
				),
				'selectors'  => array(
					'{{WRAPPER}} .aiq-feature-section__cta' => 'margin-top: {{SIZE}}{{UNIT}};',
				),
			)
		);

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			array(
				'name'     => 'cta_typography',
				'selector' => '{{WRAPPER}} .aiq-feature-section__cta-button',
				'global'   => array(
					'default' => \Elementor\Core\Kits\Documents\Tabs\Global_Typography::TYPOGRAPHY_ACCENT,
				),
			)
		);

		$this->add_responsive_control(
			'cta_padding',
			array(
				'label'      => esc_html__( 'Padding', 'aiqengage' ),
				'type'       => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', 'em', 'rem', '%' ),
				'default'    => array(
					'top'      => '15',
					'right'    => '30',
					'bottom'   => '15',
					'left'     => '30',
					'unit'     => 'px',
					'isLinked' => false,
				),
				'selectors'  => array(
					'{{WRAPPER}} .aiq-feature-section__cta-button' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_control(
			'cta_border_radius',
			array(
				'label'      => esc_html__( 'Border Radius', 'aiqengage' ),
				'type'       => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%' ),
				'default'    => array(
					'top'      => '8',
					'right'    => '8',
					'bottom'   => '8',
					'left'     => '8',
					'unit'     => 'px',
					'isLinked' => true,
				),
				'selectors'  => array(
					'{{WRAPPER}} .aiq-feature-section__cta-button' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->start_controls_tabs( 'cta_style_tabs' );

		$this->start_controls_tab(
			'cta_style_normal',
			array(
				'label' => esc_html__( 'Normal', 'aiqengage' ),
			)
		);

		$this->add_control(
			'primary_cta_background',
			array(
				'label'     => esc_html__( 'Primary Background', 'aiqengage' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '#9C4DFF',
				'selectors' => array(
					'{{WRAPPER}} .aiq-feature-section__cta-button--primary' => 'background-color: {{VALUE}}',
				),
			)
		);

		$this->add_control(
			'primary_cta_color',
			array(
				'label'     => esc_html__( 'Primary Text Color', 'aiqengage' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '#FFFFFF',
				'selectors' => array(
					'{{WRAPPER}} .aiq-feature-section__cta-button--primary' => 'color: {{VALUE}}',
				),
			)
		);

		$this->add_control(
			'secondary_cta_background',
			array(
				'label'     => esc_html__( 'Secondary Background', 'aiqengage' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => 'rgba(156, 77, 255, 0.1)',
				'selectors' => array(
					'{{WRAPPER}} .aiq-feature-section__cta-button--secondary' => 'background-color: {{VALUE}}',
				),
			)
		);

		$this->add_control(
			'secondary_cta_color',
			array(
				'label'     => esc_html__( 'Secondary Text Color', 'aiqengage' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '#E0D6FF',
				'selectors' => array(
					'{{WRAPPER}} .aiq-feature-section__cta-button--secondary' => 'color: {{VALUE}}',
				),
			)
		);

		$this->add_group_control(
			\Elementor\Group_Control_Border::get_type(),
			array(
				'name'     => 'secondary_cta_border',
				'selector' => '{{WRAPPER}} .aiq-feature-section__cta-button--secondary',
			)
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'cta_style_hover',
			array(
				'label' => esc_html__( 'Hover', 'aiqengage' ),
			)
		);

		$this->add_control(
			'primary_cta_background_hover',
			array(
				'label'     => esc_html__( 'Primary Background', 'aiqengage' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '#8E6BFF',
				'selectors' => array(
					'{{WRAPPER}} .aiq-feature-section__cta-button--primary:hover' => 'background-color: {{VALUE}}',
				),
			)
		);

		$this->add_control(
			'primary_cta_color_hover',
			array(
				'label'     => esc_html__( 'Primary Text Color', 'aiqengage' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '#FFFFFF',
				'selectors' => array(
					'{{WRAPPER}} .aiq-feature-section__cta-button--primary:hover' => 'color: {{VALUE}}',
				),
			)
		);

		$this->add_control(
			'secondary_cta_background_hover',
			array(
				'label'     => esc_html__( 'Secondary Background', 'aiqengage' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => 'rgba(156, 77, 255, 0.2)',
				'selectors' => array(
					'{{WRAPPER}} .aiq-feature-section__cta-button--secondary:hover' => 'background-color: {{VALUE}}',
				),
			)
		);

		$this->add_control(
			'secondary_cta_color_hover',
			array(
				'label'     => esc_html__( 'Secondary Text Color', 'aiqengage' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '#E0D6FF',
				'selectors' => array(
					'{{WRAPPER}} .aiq-feature-section__cta-button--secondary:hover' => 'color: {{VALUE}}',
				),
			)
		);

		$this->add_group_control(
			\Elementor\Group_Control_Border::get_type(),
			array(
				'name'     => 'secondary_cta_border_hover',
				'selector' => '{{WRAPPER}} .aiq-feature-section__cta-button--secondary:hover',
			)
		);

		$this->add_control(
			'cta_transition',
			array(
				'label'      => esc_html__( 'Transition Duration', 'aiqengage' ),
				'type'       => \Elementor\Controls_Manager::SLIDER,
				'size_units' => array( 's', 'ms' ),
				'range'      => array(
					'ms' => array(
						'min'  => 0,
						'max'  => 1000,
						'step' => 10,
					),
					's'  => array(
						'min'  => 0,
						'max'  => 1,
						'step' => 0.1,
					),
				),
				'default'    => array(
					'unit' => 'ms',
					'size' => 300,
				),
				'selectors'  => array(
					'{{WRAPPER}} .aiq-feature-section__cta-button' => 'transition: all {{SIZE}}{{UNIT}};',
				),
			)
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->end_controls_section();
	}

	/**
	 * Render widget output on the frontend.
	 */
	protected function render() {
		$settings = $this->get_settings_for_display();

		$this->add_render_attribute( 'wrapper', 'class', 'aiq-feature-section' );
		$this->add_render_attribute( 'wrapper', 'aria-label', esc_attr__( 'Feature Section', 'aiqengage-child' ) );

		if ( 'grid' === $settings['layout_type'] ) {
			$this->add_render_attribute(
				'features_container',
				'class',
				array(
					'aiq-feature-section__grid',
					'aiq-feature-section__grid--' . $settings['columns'] . '-col',
				)
			);
		} else {
			$this->add_render_attribute( 'features_container', 'class', 'aiq-feature-section__two-column' );
		}

		if ( 'card' === $settings['display_style'] ) {
			$this->add_render_attribute( 'features_container', 'class', 'aiq-feature-section__card-style' );
			$feature_class = 'aiq-feature-section__feature--card';
		} else {
			$this->add_render_attribute( 'features_container', 'class', 'aiq-feature-section__icon-list' );
			$feature_class = 'aiq-feature-section__feature--icon-list';
		}

		if ( 'yes' === $settings['show_cta'] ) {
			$this->add_render_attribute(
				'cta_button',
				'class',
				array(
					'aiq-feature-section__cta-button',
					'aiq-feature-section__cta-button--' . $settings['cta_style'],
				)
			);

			$this->add_link_attributes( 'cta_button', $settings['cta_link'] );
		}
		?>

		<div <?php $this->print_render_attribute_string( 'wrapper' ); ?>>
			<?php if ( 'yes' === $settings['show_background_pattern'] ) : ?>
			<div class="aiq-feature-section__pattern"></div>
			<?php endif; ?>

			<div class="aiq-feature-section__container">

				<?php if ( $settings['headline'] || $settings['subheadline'] ) : ?>
				<div class="aiq-feature-section__header">
					<?php if ( $settings['headline'] ) : ?>
						<h2 class="aiq-feature-section__headline"><?php echo esc_html( $settings['headline'] ); ?></h2>
					<?php endif; ?>

					<?php if ( $settings['subheadline'] ) : ?>
						<div class="aiq-feature-section__subheadline"><?php echo esc_html( $settings['subheadline'] ); ?></div>
					<?php endif; ?>
				</div>
				<?php endif; ?>

				<?php if ( $settings['features'] ) : ?>
				<div <?php $this->print_render_attribute_string( 'features_container' ); ?>>

					<?php if ( 'two-column' === $settings['layout_type'] ) : ?>
					<div class="aiq-feature-section__column">
					<?php endif; ?>

					<?php
					$column_count  = 0;
					$column_middle = ceil( count( $settings['features'] ) / 2 );

					foreach ( $settings['features'] as $index => $feature ) :
						++$column_count;

						if ( 'two-column' === $settings['layout_type'] && $column_count > $column_middle ) :
							echo '</div><div class="aiq-feature-section__column">';
							$column_count = 1;
						endif;

						$feature_key = $this->get_repeater_setting_key( 'feature', 'features', $index );
						$this->add_render_attribute(
							$feature_key,
							'class',
							array(
								'aiq-feature-section__feature',
								$feature_class,
							)
						);

						$title_key = $this->get_repeater_setting_key( 'feature_title', 'features', $index );
						$this->add_render_attribute( $title_key, 'class', 'aiq-feature-section__feature-title' );

						$description_key = $this->get_repeater_setting_key( 'feature_description', 'features', $index );
						$this->add_render_attribute( $description_key, 'class', 'aiq-feature-section__feature-description' );

						$media_key = $this->get_repeater_setting_key( 'media', 'features', $index );
						$this->add_render_attribute( $media_key, 'class', 'aiq-feature-section__media' );

						// Add accent color
						if ( ! empty( $feature['feature_accent_color'] ) ) {
							$this->add_render_attribute( $title_key, 'style', 'color: ' . $feature['feature_accent_color'] . ';' );

							if ( 'icon' === $feature['media_type'] ) {
								$icon_key = $this->get_repeater_setting_key( 'icon', 'features', $index );
								$this->add_render_attribute( $icon_key, 'style', 'color: ' . $feature['feature_accent_color'] . ';' );
							}
						}
						?>
						<div <?php $this->print_render_attribute_string( $feature_key ); ?>>

							<?php if ( 'icon' === $feature['media_type'] && ! empty( $feature['feature_icon']['value'] ) ) : ?>
							<div <?php $this->print_render_attribute_string( $media_key ); ?>>
								<div class="aiq-feature-section__icon" <?php $this->print_render_attribute_string( $icon_key ); ?>>
									<?php \Elementor\Icons_Manager::render_icon( $feature['feature_icon'], array( 'aria-hidden' => 'true' ) ); ?>
								</div>
							</div>
							<?php elseif ( 'image' === $feature['media_type'] && ! empty( $feature['feature_image']['url'] ) ) : ?>
							<div <?php $this->print_render_attribute_string( $media_key ); ?>>
								<div class="aiq-feature-section__image">
									<img src="<?php echo esc_url( $feature['feature_image']['url'] ); ?>" alt="<?php echo esc_attr( $feature['feature_title'] ); ?>">
								</div>
							</div>
							<?php endif; ?>

							<div class="aiq-feature-section__content">
								<?php if ( ! empty( $feature['feature_title'] ) ) : ?>
									<h3 <?php $this->print_render_attribute_string( $title_key ); ?>><?php echo esc_html( $feature['feature_title'] ); ?></h3>
								<?php endif; ?>

								<?php if ( ! empty( $feature['feature_description'] ) ) : ?>
									<div <?php $this->print_render_attribute_string( $description_key ); ?>><?php echo esc_html( $feature['feature_description'] ); ?></div>
								<?php endif; ?>
							</div>
						</div>
					<?php endforeach; ?>

					<?php if ( 'two-column' === $settings['layout_type'] ) : ?>
					</div>
					<?php endif; ?>

				</div>
				<?php endif; ?>

				<?php if ( 'yes' === $settings['show_cta'] && ! empty( $settings['cta_text'] ) ) : ?>
				<div class="aiq-feature-section__cta">
					<a <?php $this->print_render_attribute_string( 'cta_button' ); ?>>
						<?php echo esc_html( $settings['cta_text'] ); ?>
					</a>
				</div>
				<?php endif; ?>

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
		view.addRenderAttribute( 'wrapper', 'class', 'aiq-feature-section' );
		view.addRenderAttribute( 'wrapper', 'aria-label', 'Feature Section' );

		if ( 'grid' === settings.layout_type ) {
			view.addRenderAttribute( 'features_container', 'class', [
				'aiq-feature-section__grid',
				'aiq-feature-section__grid--' + settings.columns + '-col'
			] );
		} else {
			view.addRenderAttribute( 'features_container', 'class', 'aiq-feature-section__two-column' );
		}

		if ( 'card' === settings.display_style ) {
			view.addRenderAttribute( 'features_container', 'class', 'aiq-feature-section__card-style' );
			var feature_class = 'aiq-feature-section__feature--card';
		} else {
			view.addRenderAttribute( 'features_container', 'class', 'aiq-feature-section__icon-list' );
			var feature_class = 'aiq-feature-section__feature--icon-list';
		}

		if ( 'yes' === settings.show_cta ) {
			view.addRenderAttribute( 'cta_button', 'class', [
				'aiq-feature-section__cta-button',
				'aiq-feature-section__cta-button--' + settings.cta_style
			] );

			view.addRenderAttribute( 'cta_button', 'href', settings.cta_link.url );

			if ( settings.cta_link.is_external ) {
				view.addRenderAttribute( 'cta_button', 'target', '_blank' );
			}

			if ( settings.cta_link.nofollow ) {
				view.addRenderAttribute( 'cta_button', 'rel', 'nofollow' );
			}
		}
		#>

		<div {{{ view.getRenderAttributeString( 'wrapper' ) }}}>
			<# if ( 'yes' === settings.show_background_pattern ) { #>
			<div class="aiq-feature-section__pattern"></div>
			<# } #>

			<div class="aiq-feature-section__container">

				<# if ( settings.headline || settings.subheadline ) { #>
				<div class="aiq-feature-section__header">
					<# if ( settings.headline ) { #>
						<h2 class="aiq-feature-section__headline">{{{ settings.headline }}}</h2>
					<# } #>

					<# if ( settings.subheadline ) { #>
						<div class="aiq-feature-section__subheadline">{{{ settings.subheadline }}}</div>
					<# } #>
				</div>
				<# } #>

				<# if ( settings.features && settings.features.length ) { #>
				<div {{{ view.getRenderAttributeString( 'features_container' ) }}}>

					<# if ( 'two-column' === settings.layout_type ) { #>
					<div class="aiq-feature-section__column">
					<# } #>

					<#
					var column_count = 0;
					var column_middle = Math.ceil( settings.features.length / 2 );

					_.each( settings.features, function( feature, index ) {
						column_count++;

						if ( 'two-column' === settings.layout_type && column_count > column_middle ) {
							#></div><div class="aiq-feature-section__column"><#
							column_count = 1;
						}

						var feature_key = view.getRepeaterSettingKey( 'feature', 'features', index );
						view.addRenderAttribute( feature_key, 'class', [
							'aiq-feature-section__feature',
							feature_class
						] );

						var title_key = view.getRepeaterSettingKey( 'feature_title', 'features', index );
						view.addRenderAttribute( title_key, 'class', 'aiq-feature-section__feature-title' );

						var description_key = view.getRepeaterSettingKey( 'feature_description', 'features', index );
						view.addRenderAttribute( description_key, 'class', 'aiq-feature-section__feature-description' );

						var media_key = view.getRepeaterSettingKey( 'media', 'features', index );
						view.addRenderAttribute( media_key, 'class', 'aiq-feature-section__media' );

						// Add accent color
						if ( feature.feature_accent_color ) {
							view.addRenderAttribute( title_key, 'style', 'color: ' + feature.feature_accent_color + ';' );

							if ( 'icon' === feature.media_type ) {
								var icon_key = view.getRepeaterSettingKey( 'icon', 'features', index );
								view.addRenderAttribute( icon_key, 'style', 'color: ' + feature.feature_accent_color + ';' );
							}
						}
					#>
						<div {{{ view.getRenderAttributeString( feature_key ) }}}>

							<# if ( 'icon' === feature.media_type && feature.feature_icon.value ) { #>
							<div {{{ view.getRenderAttributeString( media_key ) }}}>
								<div class="aiq-feature-section__icon" {{{ view.getRenderAttributeString( icon_key ) }}}>
									<# var iconHTML = elementor.helpers.renderIcon( view, feature.feature_icon, { 'aria-hidden': true }, 'i', 'object' ); #>
									{{{ iconHTML.value }}}
								</div>
							</div>
							<# } else if ( 'image' === feature.media_type && feature.feature_image.url ) { #>
							<div {{{ view.getRenderAttributeString( media_key ) }}}>
								<div class="aiq-feature-section__image">
									<img src="{{ feature.feature_image.url }}" alt="{{ feature.feature_title }}">
								</div>
							</div>
							<# } #>

							<div class="aiq-feature-section__content">
								<# if ( feature.feature_title ) { #>
									<h3 {{{ view.getRenderAttributeString( title_key ) }}}>{{{ feature.feature_title }}}</h3>
								<# } #>

								<# if ( feature.feature_description ) { #>
									<div {{{ view.getRenderAttributeString( description_key ) }}}>{{{ feature.feature_description }}}</div>
								<# } #>
							</div>
						</div>
					<# } ); #>

					<# if ( 'two-column' === settings.layout_type ) { #>
					</div>
					<# } #>

				</div>
				<# } #>

				<# if ( 'yes' === settings
		/**
	 * Render widget output in the editor.
	 */
	protected function content_template() {
		?>
		<#
		view.addRenderAttribute( 'wrapper', 'class', 'aiq-feature-section' );
		view.addRenderAttribute( 'wrapper', 'aria-label', 'Feature Section' );

		if ( 'grid' === settings.layout_type ) {
			view.addRenderAttribute( 'features_container', 'class', [
				'aiq-feature-section__grid',
				'aiq-feature-section__grid--' + settings.columns + '-col'
			] );
		} else {
			view.addRenderAttribute( 'features_container', 'class', 'aiq-feature-section__two-column' );
		}

		if ( 'card' === settings.display_style ) {
			view.addRenderAttribute( 'features_container', 'class', 'aiq-feature-section__card-style' );
			var feature_class = 'aiq-feature-section__feature--card';
		} else {
			view.addRenderAttribute( 'features_container', 'class', 'aiq-feature-section__icon-list' );
			var feature_class = 'aiq-feature-section__feature--icon-list';
		}

		if ( 'yes' === settings.show_cta ) {
			view.addRenderAttribute( 'cta_button', 'class', [
				'aiq-feature-section__cta-button',
				'aiq-feature-section__cta-button--' + settings.cta_style
			] );

			view.addRenderAttribute( 'cta_button', 'href', settings.cta_link.url );

			if ( settings.cta_link.is_external ) {
				view.addRenderAttribute( 'cta_button', 'target', '_blank' );
			}

			if ( settings.cta_link.nofollow ) {
				view.addRenderAttribute( 'cta_button', 'rel', 'nofollow' );
			}
		}
		#>

		<div {{{ view.getRenderAttributeString( 'wrapper' ) }}}>
			<# if ( 'yes' === settings.show_background_pattern ) { #>
			<div class="aiq-feature-section__pattern"></div>
			<# } #>

			<div class="aiq-feature-section__container">

				<# if ( settings.headline || settings.subheadline ) { #>
				<div class="aiq-feature-section__header">
					<# if ( settings.headline ) { #>
						<h2 class="aiq-feature-section__headline">{{{ settings.headline }}}</h2>
					<# } #>

					<# if ( settings.subheadline ) { #>
						<div class="aiq-feature-section__subheadline">{{{ settings.subheadline }}}</div>
					<# } #>
				</div>
				<# } #>

				<# if ( settings.features && settings.features.length ) { #>
				<div {{{ view.getRenderAttributeString( 'features_container' ) }}}>

					<# if ( 'two-column' === settings.layout_type ) { #>
					<div class="aiq-feature-section__column">
					<# } #>

					<#
					var column_count = 0;
					var column_middle = Math.ceil( settings.features.length / 2 );

					_.each( settings.features, function( feature, index ) {
						column_count++;

						if ( 'two-column' === settings.layout_type && column_count > column_middle ) {
							#></div><div class="aiq-feature-section__column"><#
							column_count = 1;
						}

						var feature_key = view.getRepeaterSettingKey( 'feature', 'features', index );
						view.addRenderAttribute( feature_key, 'class', [
							'aiq-feature-section__feature',
							feature_class
						] );

						var title_key = view.getRepeaterSettingKey( 'feature_title', 'features', index );
						view.addRenderAttribute( title_key, 'class', 'aiq-feature-section__feature-title' );

						var description_key = view.getRepeaterSettingKey( 'feature_description', 'features', index );
						view.addRenderAttribute( description_key, 'class', 'aiq-feature-section__feature-description' );

						var media_key = view.getRepeaterSettingKey( 'media', 'features', index );
						view.addRenderAttribute( media_key, 'class', 'aiq-feature-section__media' );

						// Add accent color
						if ( feature.feature_accent_color ) {
							view.addRenderAttribute( title_key, 'style', 'color: ' + feature.feature_accent_color + ';' );

							if ( 'icon' === feature.media_type ) {
								var icon_key = view.getRepeaterSettingKey( 'icon', 'features', index );
								view.addRenderAttribute( icon_key, 'style', 'color: ' + feature.feature_accent_color + ';' );
							}
						}
					#>
						<div {{{ view.getRenderAttributeString( feature_key ) }}}>

							<# if ( 'icon' === feature.media_type && feature.feature_icon.value ) { #>
							<div {{{ view.getRenderAttributeString( media_key ) }}}>
								<div class="aiq-feature-section__icon" {{{ view.getRenderAttributeString( icon_key ) }}}>
									<# var iconHTML = elementor.helpers.renderIcon( view, feature.feature_icon, { 'aria-hidden': true }, 'i', 'object' ); #>
									{{{ iconHTML.value }}}
								</div>
							</div>
							<# } else if ( 'image' === feature.media_type && feature.feature_image.url ) { #>
							<div {{{ view.getRenderAttributeString( media_key ) }}}>
								<div class="aiq-feature-section__image">
									<img src="{{ feature.feature_image.url }}" alt="{{ feature.feature_title }}">
								</div>
							</div>
							<# } #>

							<div class="aiq-feature-section__content">
								<# if ( feature.feature_title ) { #>
									<h3 {{{ view.getRenderAttributeString( title_key ) }}}>{{{ feature.feature_title }}}</h3>
								<# } #>

								<# if ( feature.feature_description ) { #>
									<div {{{ view.getRenderAttributeString( description_key ) }}}>{{{ feature.feature_description }}}</div>
								<# } #>
							</div>
						</div>
					<# } ); #>

					<# if ( 'two-column' === settings.layout_type ) { #>
					</div>
					<# } #>

				</div>
				<# } #>

				<# if ( 'yes' === settings.show_cta && settings.cta_text ) { #>
				<div class="aiq-feature-section__cta">
					<a {{{ view.getRenderAttributeString( 'cta_button' ) }}}>
						{{{ settings.cta_text }}}
					</a>
				</div>
				<# } #>

			</div>
		</div>
		<?php
	}
}
