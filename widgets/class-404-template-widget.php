<?php
/**
 * 404 Template Widget for Elementor
 *
 * @package aiqengage-child
 * @version 1.0.0
 * @since 1.0.0
 * @author Jason
 */

defined( 'ABSPATH' ) || exit;

class AIQ_404_Template_Widget extends \Elementor\Widget_Base {

	/**
	 * Get widget name.
	 *
	 * @return string
	 */
	public function get_name() {
		return 'aiq_404_template';
	}

	/**
	 * Get widget title.
	 *
	 * @return string
	 */
	public function get_title() {
		return esc_html__( '404 / AI Lost?', 'aiqengage-child' );
	}

	/**
	 * Get widget icon.
	 *
	 * @return string
	 */
	public function get_icon() {
		return 'eicon-search';
	}

	/**
	 * Get widget categories.
	 *
	 * @return array
	 */
	public function get_categories() {
		return array( 'aiqengage' );
	}

	/**
	 * Get widget style dependencies.
	 *
	 * @return array
	 */
	public function get_style_depends() {
		return array( 'aiqengage-child-404-template' );
	}

	/**
	 * Get widget script dependencies.
	 *
	 * @return array
	 */
	public function get_script_depends() {
		return array();
	}

	/**
	 * Get widget keywords.
	 *
	 * @return array
	 */
	public function get_keywords() {
		return array( '404', 'lost', 'not found', 'error', 'mascot', 'neural', 'search' );
	}

	/**
	 * Register widget controls.
	 */
	protected function register_controls() {
		$this->register_content_controls();
		$this->register_style_controls();
	}

	/**
	 * Register content controls.
	 */
	protected function register_content_controls() {
		$this->start_controls_section(
			'section_content',
			array(
				'label' => esc_html__( 'Content', 'aiqengage-child' ),
				'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
			)
		);

		$this->add_control(
			'headline',
			array(
				'label'       => esc_html__( 'Headline', 'aiqengage-child' ),
				'type'        => \Elementor\Controls_Manager::TEXT,
				'default'     => esc_html__( 'Lost in the Neural Network?', 'aiqengage-child' ),
				'label_block' => true,
				'dynamic'     => array(
					'active' => true,
				),
			)
		);

		$this->add_control(
			'subheading',
			array(
				'label'       => esc_html__( 'Subheading', 'aiqengage-child' ),
				'type'        => \Elementor\Controls_Manager::TEXTAREA,
				'default'     => esc_html__( 'The page you\'re looking for doesn\'t exist. Perhaps our AI can help you find what you need.', 'aiqengage-child' ),
				'label_block' => true,
				'dynamic'     => array(
					'active' => true,
				),
			)
		);

		$this->add_control(
			'mascot_type',
			array(
				'label'   => esc_html__( 'Mascot Type', 'aiqengage-child' ),
				'type'    => \Elementor\Controls_Manager::SELECT,
				'default' => 'static',
				'options' => array(
					'static' => esc_html__( 'Static Image', 'aiqengage-child' ),
					'lottie' => esc_html__( 'Lottie Animation', 'aiqengage-child' ),
					'svg'    => esc_html__( 'SVG', 'aiqengage-child' ),
				),
			)
		);

		$this->add_control(
			'mascot_image',
			array(
				'label'     => esc_html__( 'Mascot Image', 'aiqengage-child' ),
				'type'      => \Elementor\Controls_Manager::MEDIA,
				'default'   => array(
					'url' => \Elementor\Utils::get_placeholder_image_src(),
				),
				'condition' => array(
					'mascot_type' => 'static',
				),
				'dynamic'   => array(
					'active' => true,
				),
			)
		);

		$this->add_control(
			'lottie_url',
			array(
				'label'       => esc_html__( 'Lottie URL', 'aiqengage-child' ),
				'type'        => \Elementor\Controls_Manager::URL,
				'placeholder' => esc_html__( 'https://example.com/animation.json', 'aiqengage-child' ),
				'description' => esc_html__( 'Enter the URL of your Lottie JSON file', 'aiqengage-child' ),
				'condition'   => array(
					'mascot_type' => 'lottie',
				),
				'dynamic'     => array(
					'active' => true,
				),
			)
		);

		$this->add_control(
			'svg_code',
			array(
				'label'     => esc_html__( 'SVG Code', 'aiqengage-child' ),
				'type'      => \Elementor\Controls_Manager::CODE,
				'language'  => 'html',
				'rows'      => 10,
				'condition' => array(
					'mascot_type' => 'svg',
				),
				'dynamic'   => array(
					'active' => true,
				),
			)
		);

		$this->add_control(
			'show_search',
			array(
				'label'        => esc_html__( 'Show Search Form', 'aiqengage-child' ),
				'type'         => \Elementor\Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Yes', 'aiqengage-child' ),
				'label_off'    => esc_html__( 'No', 'aiqengage-child' ),
				'return_value' => 'yes',
				'default'      => 'yes',
			)
		);

		$this->add_control(
			'search_placeholder',
			array(
				'label'     => esc_html__( 'Search Placeholder', 'aiqengage-child' ),
				'type'      => \Elementor\Controls_Manager::TEXT,
				'default'   => esc_html__( 'Search our knowledge base...', 'aiqengage-child' ),
				'condition' => array(
					'show_search' => 'yes',
				),
				'dynamic'   => array(
					'active' => true,
				),
			)
		);

		$this->add_control(
			'show_cta',
			array(
				'label'        => esc_html__( 'Show CTA Button', 'aiqengage-child' ),
				'type'         => \Elementor\Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Yes', 'aiqengage-child' ),
				'label_off'    => esc_html__( 'No', 'aiqengage-child' ),
				'return_value' => 'yes',
				'default'      => 'yes',
			)
		);

		$this->add_control(
			'cta_text',
			array(
				'label'     => esc_html__( 'CTA Text', 'aiqengage-child' ),
				'type'      => \Elementor\Controls_Manager::TEXT,
				'default'   => esc_html__( 'Return to Home', 'aiqengage-child' ),
				'condition' => array(
					'show_cta' => 'yes',
				),
				'dynamic'   => array(
					'active' => true,
				),
			)
		);

		$this->add_control(
			'cta_link',
			array(
				'label'       => esc_html__( 'CTA Link', 'aiqengage-child' ),
				'type'        => \Elementor\Controls_Manager::URL,
				'placeholder' => esc_url( home_url() ),
				'default'     => array(
					'url' => esc_url( home_url() ),
				),
				'condition'   => array(
					'show_cta' => 'yes',
				),
				'dynamic'     => array(
					'active' => true,
				),
			)
		);

		$this->end_controls_section();
	}

	/**
	 * Register style controls.
	 */
	protected function register_style_controls() {
		$this->start_controls_section(
			'section_style_layout',
			array(
				'label' => esc_html__( 'Layout', 'aiqengage-child' ),
				'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_responsive_control(
			'content_max_width',
			array(
				'label'      => esc_html__( 'Content Max Width', 'aiqengage-child' ),
				'type'       => \Elementor\Controls_Manager::SLIDER,
				'size_units' => array( 'px', '%' ),
				'range'      => array(
					'px' => array(
						'min' => 300,
						'max' => 1600,
					),
				),
				'default'    => array(
					'unit' => 'px',
					'size' => 1200,
				),
				'selectors'  => array(
					'{{WRAPPER}} .aiq-404-template__container' => 'max-width: {{SIZE}}{{UNIT}};',
				),
			)
		);

		$this->add_responsive_control(
			'padding',
			array(
				'label'      => esc_html__( 'Padding', 'aiqengage-child' ),
				'type'       => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', 'em', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} .aiq-404-template' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
				'default'    => array(
					'top'      => '80',
					'right'    => '20',
					'bottom'   => '80',
					'left'     => '20',
					'unit'     => 'px',
					'isLinked' => false,
				),
			)
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_style_background',
			array(
				'label' => esc_html__( 'Background', 'aiqengage-child' ),
				'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_group_control(
			\Elementor\Group_Control_Background::get_type(),
			array(
				'name'           => 'background',
				'label'          => esc_html__( 'Background', 'aiqengage-child' ),
				'types'          => array( 'classic', 'gradient' ),
				'selector'       => '{{WRAPPER}} .aiq-404-template',
				'fields_options' => array(
					'background'     => array(
						'default' => 'gradient',
					),
					'color'          => array(
						'default' => '#1A0938',
					),
					'color_b'        => array(
						'default' => '#2A1958',
					),
					'gradient_angle' => array(
						'default' => array(
							'unit' => 'deg',
							'size' => 135,
						),
					),
				),
			)
		);

		$this->add_control(
			'show_neural_pattern',
			array(
				'label'        => esc_html__( 'Show Neural Pattern', 'aiqengage-child' ),
				'type'         => \Elementor\Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Yes', 'aiqengage-child' ),
				'label_off'    => esc_html__( 'No', 'aiqengage-child' ),
				'return_value' => 'yes',
				'default'      => 'yes',
				'separator'    => 'before',
			)
		);

		$this->add_control(
			'pattern_color',
			array(
				'label'     => esc_html__( 'Pattern Color', 'aiqengage-child' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '#9C4DFF',
				'selectors' => array(
					'{{WRAPPER}} .aiq-404-template__neural-pattern' => '--pattern-color: {{VALUE}}',
				),
				'condition' => array(
					'show_neural_pattern' => 'yes',
				),
			)
		);

		$this->add_control(
			'pattern_opacity',
			array(
				'label'     => esc_html__( 'Pattern Opacity', 'aiqengage-child' ),
				'type'      => \Elementor\Controls_Manager::SLIDER,
				'range'     => array(
					'px' => array(
						'min'  => 0,
						'max'  => 1,
						'step' => 0.01,
					),
				),
				'default'   => array(
					'size' => 0.05,
				),
				'selectors' => array(
					'{{WRAPPER}} .aiq-404-template__neural-pattern' => 'opacity: {{SIZE}};',
				),
				'condition' => array(
					'show_neural_pattern' => 'yes',
				),
			)
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_style_typography',
			array(
				'label' => esc_html__( 'Typography', 'aiqengage-child' ),
				'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_control(
			'heading_style',
			array(
				'label' => esc_html__( 'Headline', 'aiqengage-child' ),
				'type'  => \Elementor\Controls_Manager::HEADING,
			)
		);

		$this->add_control(
			'headline_color',
			array(
				'label'     => esc_html__( 'Color', 'aiqengage-child' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '#E0D6FF',
				'selectors' => array(
					'{{WRAPPER}} .aiq-404-template__headline' => 'color: {{VALUE}}',
				),
			)
		);

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			array(
				'name'           => 'headline_typography',
				'label'          => esc_html__( 'Typography', 'aiqengage-child' ),
				'selector'       => '{{WRAPPER}} .aiq-404-template__headline',
				'fields_options' => array(
					'typography'  => array( 'default' => 'yes' ),
					'font_weight' => array( 'default' => '700' ),
					'font_size'   => array(
						'default' => array(
							'unit' => 'px',
							'size' => '48',
						),
					),
					'line_height' => array(
						'default' => array(
							'unit' => 'em',
							'size' => '1.2',
						),
					),
				),
			)
		);

		$this->add_responsive_control(
			'headline_margin',
			array(
				'label'      => esc_html__( 'Margin', 'aiqengage-child' ),
				'type'       => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', 'em', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} .aiq-404-template__headline' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
				'default'    => array(
					'bottom'   => '16',
					'unit'     => 'px',
					'isLinked' => false,
				),
			)
		);

		$this->add_control(
			'subheading_style',
			array(
				'label'     => esc_html__( 'Subheading', 'aiqengage-child' ),
				'type'      => \Elementor\Controls_Manager::HEADING,
				'separator' => 'before',
			)
		);

		$this->add_control(
			'subheading_color',
			array(
				'label'     => esc_html__( 'Color', 'aiqengage-child' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => 'rgba(224, 214, 255, 0.8)',
				'selectors' => array(
					'{{WRAPPER}} .aiq-404-template__subheading' => 'color: {{VALUE}}',
				),
			)
		);

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			array(
				'name'           => 'subheading_typography',
				'label'          => esc_html__( 'Typography', 'aiqengage-child' ),
				'selector'       => '{{WRAPPER}} .aiq-404-template__subheading',
				'fields_options' => array(
					'typography'  => array( 'default' => 'yes' ),
					'font_weight' => array( 'default' => '400' ),
					'font_size'   => array(
						'default' => array(
							'unit' => 'px',
							'size' => '18',
						),
					),
					'line_height' => array(
						'default' => array(
							'unit' => 'em',
							'size' => '1.6',
						),
					),
				),
			)
		);

		$this->add_responsive_control(
			'subheading_margin',
			array(
				'label'      => esc_html__( 'Margin', 'aiqengage-child' ),
				'type'       => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', 'em', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} .aiq-404-template__subheading' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
				'default'    => array(
					'bottom'   => '32',
					'unit'     => 'px',
					'isLinked' => false,
				),
			)
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_style_search',
			array(
				'label'     => esc_html__( 'Search Form', 'aiqengage-child' ),
				'tab'       => \Elementor\Controls_Manager::TAB_STYLE,
				'condition' => array(
					'show_search' => 'yes',
				),
			)
		);

		$this->add_responsive_control(
			'search_width',
			array(
				'label'      => esc_html__( 'Width', 'aiqengage-child' ),
				'type'       => \Elementor\Controls_Manager::SLIDER,
				'size_units' => array( 'px', '%' ),
				'range'      => array(
					'px' => array(
						'min' => 200,
						'max' => 800,
					),
				),
				'default'    => array(
					'unit' => 'px',
					'size' => 480,
				),
				'selectors'  => array(
					'{{WRAPPER}} .aiq-404-template__search-form' => 'width: {{SIZE}}{{UNIT}};',
				),
			)
		);

		$this->add_control(
			'search_input_style',
			array(
				'label' => esc_html__( 'Input Field', 'aiqengage-child' ),
				'type'  => \Elementor\Controls_Manager::HEADING,
			)
		);

		$this->add_control(
			'search_input_color',
			array(
				'label'     => esc_html__( 'Text Color', 'aiqengage-child' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '#E0D6FF',
				'selectors' => array(
					'{{WRAPPER}} .aiq-404-template__search-input' => 'color: {{VALUE}}',
				),
			)
		);

		$this->add_control(
			'search_input_bg',
			array(
				'label'     => esc_html__( 'Background Color', 'aiqengage-child' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => 'rgba(26, 9, 56, 0.6)',
				'selectors' => array(
					'{{WRAPPER}} .aiq-404-template__search-input' => 'background-color: {{VALUE}}',
				),
			)
		);

		$this->add_control(
			'search_input_border',
			array(
				'label'     => esc_html__( 'Border Color', 'aiqengage-child' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => 'rgba(156, 77, 255, 0.3)',
				'selectors' => array(
					'{{WRAPPER}} .aiq-404-template__search-input' => 'border-color: {{VALUE}}',
				),
			)
		);

		$this->add_control(
			'search_input_focus',
			array(
				'label'     => esc_html__( 'Focus Border Color', 'aiqengage-child' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '#9C4DFF',
				'selectors' => array(
					'{{WRAPPER}} .aiq-404-template__search-input:focus' => 'border-color: {{VALUE}}',
				),
			)
		);

		$this->add_control(
			'search_button_style',
			array(
				'label'     => esc_html__( 'Search Button', 'aiqengage-child' ),
				'type'      => \Elementor\Controls_Manager::HEADING,
				'separator' => 'before',
			)
		);

		$this->add_control(
			'search_button_color',
			array(
				'label'     => esc_html__( 'Color', 'aiqengage-child' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '#9C4DFF',
				'selectors' => array(
					'{{WRAPPER}} .aiq-404-template__search-button' => 'color: {{VALUE}}',
				),
			)
		);

		$this->add_control(
			'search_button_hover',
			array(
				'label'     => esc_html__( 'Hover Color', 'aiqengage-child' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '#E0D6FF',
				'selectors' => array(
					'{{WRAPPER}} .aiq-404-template__search-button:hover' => 'color: {{VALUE}}',
				),
			)
		);

		$this->add_responsive_control(
			'search_margin',
			array(
				'label'      => esc_html__( 'Margin', 'aiqengage-child' ),
				'type'       => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', 'em', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} .aiq-404-template__search' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
				'default'    => array(
					'bottom'   => '32',
					'unit'     => 'px',
					'isLinked' => false,
				),
			)
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_style_cta',
			array(
				'label'     => esc_html__( 'CTA Button', 'aiqengage-child' ),
				'tab'       => \Elementor\Controls_Manager::TAB_STYLE,
				'condition' => array(
					'show_cta' => 'yes',
				),
			)
		);

		$this->add_control(
			'cta_color',
			array(
				'label'     => esc_html__( 'Text Color', 'aiqengage-child' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '#FFFFFF',
				'selectors' => array(
					'{{WRAPPER}} .aiq-404-template__cta' => 'color: {{VALUE}}',
				),
			)
		);

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			array(
				'name'           => 'cta_typography',
				'label'          => esc_html__( 'Typography', 'aiqengage-child' ),
				'selector'       => '{{WRAPPER}} .aiq-404-template__cta',
				'fields_options' => array(
					'typography'  => array( 'default' => 'yes' ),
					'font_weight' => array( 'default' => '600' ),
					'font_size'   => array(
						'default' => array(
							'unit' => 'px',
							'size' => '16',
						),
					),
				),
			)
		);

		$this->add_group_control(
			\Elementor\Group_Control_Background::get_type(),
			array(
				'name'           => 'cta_background',
				'label'          => esc_html__( 'Background', 'aiqengage-child' ),
				'types'          => array( 'classic', 'gradient' ),
				'selector'       => '{{WRAPPER}} .aiq-404-template__cta',
				'fields_options' => array(
					'background' => array(
						'default' => 'gradient',
					),
					'color'      => array(
						'default' => '#9C4DFF',
					),
					'color_b'    => array(
						'default' => '#5E72E4',
					),
				),
			)
		);

		$this->add_group_control(
			\Elementor\Group_Control_Box_Shadow::get_type(),
			array(
				'name'           => 'cta_shadow',
				'label'          => esc_html__( 'Box Shadow', 'aiqengage-child' ),
				'selector'       => '{{WRAPPER}} .aiq-404-template__cta',
				'fields_options' => array(
					'box_shadow_type' => array( 'default' => 'yes' ),
					'box_shadow'      => array(
						'default' => array(
							'horizontal' => 0,
							'vertical'   => 4,
							'blur'       => 10,
							'spread'     => 0,
							'color'      => 'rgba(94, 114, 228, 0.3)',
						),
					),
				),
			)
		);

		$this->add_responsive_control(
			'cta_padding',
			array(
				'label'      => esc_html__( 'Padding', 'aiqengage-child' ),
				'type'       => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', 'em', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} .aiq-404-template__cta' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
				'default'    => array(
					'top'      => '0',
					'right'    => '24',
					'bottom'   => '0',
					'left'     => '24',
					'unit'     => 'px',
					'isLinked' => false,
				),
			)
		);

		$this->add_responsive_control(
			'cta_border_radius',
			array(
				'label'      => esc_html__( 'Border Radius', 'aiqengage-child' ),
				'type'       => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} .aiq-404-template__cta' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
				'default'    => array(
					'unit'     => 'px',
					'size'     => '8',
					'isLinked' => true,
				),
			)
		);

		$this->add_control(
			'cta_hover_animation',
			array(
				'label'   => esc_html__( 'Hover Animation', 'aiqengage-child' ),
				'type'    => \Elementor\Controls_Manager::HOVER_ANIMATION,
				'default' => 'float',
			)
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_style_mascot',
			array(
				'label' => esc_html__( 'Mascot', 'aiqengage-child' ),
				'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_responsive_control(
			'mascot_width',
			array(
				'label'      => esc_html__( 'Width', 'aiqengage-child' ),
				'type'       => \Elementor\Controls_Manager::SLIDER,
				'size_units' => array( 'px', '%' ),
				'range'      => array(
					'px' => array(
						'min' => 100,
						'max' => 600,
					),
				),
				'default'    => array(
					'unit' => 'px',
					'size' => 300,
				),
				'selectors'  => array(
					'{{WRAPPER}} .aiq-404-template__mascot' => 'width: {{SIZE}}{{UNIT}};',
				),
			)
		);

		$this->add_control(
			'mascot_animation',
			array(
				'label'   => esc_html__( 'Animation', 'aiqengage-child' ),
				'type'    => \Elementor\Controls_Manager::SELECT,
				'options' => array(
					''      => esc_html__( 'None', 'aiqengage-child' ),
					'float' => esc_html__( 'Float', 'aiqengage-child' ),
					'pulse' => esc_html__( 'Pulse', 'aiqengage-child' ),
				),
				'default' => 'float',
			)
		);

		$this->add_control(
			'mascot_animation_duration',
			array(
				'label'      => esc_html__( 'Animation Duration', 'aiqengage-child' ),
				'type'       => \Elementor\Controls_Manager::SLIDER,
				'size_units' => array( 's' ),
				'range'      => array(
					's' => array(
						'min'  => 2,
						'max'  => 10,
						'step' => 0.5,
					),
				),
				'default'    => array(
					'unit' => 's',
					'size' => 4,
				),
				'condition'  => array(
					'mascot_animation!' => '',
				),
			)
		);

		$this->add_group_control(
			\Elementor\Group_Control_Box_Shadow::get_type(),
			array(
				'name'           => 'mascot_shadow',
				'label'          => esc_html__( 'Box Shadow', 'aiqengage-child' ),
				'selector'       => '{{WRAPPER}} .aiq-404-template__mascot-image, {{WRAPPER}} .aiq-404-template__lottie, {{WRAPPER}} .aiq-404-template__svg',
				'fields_options' => array(
					'box_shadow_type' => array( 'default' => 'yes' ),
					'box_shadow'      => array(
						'default' => array(
							'horizontal' => 0,
							'vertical'   => 10,
							'blur'       => 15,
							'spread'     => 0,
							'color'      => 'rgba(0, 0, 0, 0.2)',
						),
					),
				),
			)
		);

		$this->end_controls_section();
	}

	/**
	 * Render widget output on the frontend.
	 */
	protected function render() {
		$settings = $this->get_settings_for_display();

		$this->add_render_attribute( 'wrapper', 'class', 'aiq-404-template' );
		$this->add_render_attribute( 'wrapper', 'role', 'region' );
		$this->add_render_attribute( 'wrapper', 'aria-label', esc_attr__( 'Page Not Found', 'aiqengage-child' ) );

		// CTA link attributes
		$cta_link   = $settings['cta_link']['url'] ?? home_url();
		$cta_target = ! empty( $settings['cta_link']['is_external'] ) ? '_blank' : '_self';
		$cta_rel    = ! empty( $settings['cta_link']['nofollow'] ) ? 'nofollow' : '';

		// Mascot animation class
		$mascot_animation_class = '';
		if ( ! empty( $settings['mascot_animation'] ) ) {
			$mascot_animation_class = 'aiq-animation-' . $settings['mascot_animation'];
		}

		// CTA hover animation
		$cta_animation_class = '';
		if ( ! empty( $settings['cta_hover_animation'] ) ) {
			$cta_animation_class = 'elementor-animation-' . $settings['cta_hover_animation'];
		}
		?>
		<div <?php echo $this->get_render_attribute_string( 'wrapper' ); ?>>
			<?php if ( 'yes' === $settings['show_neural_pattern'] ) : ?>
				<div class="aiq-404-template__neural-pattern"></div>
			<?php endif; ?>

			<div class="aiq-404-template__container">
				<div class="aiq-404-template__content">
					<?php if ( ! empty( $settings['headline'] ) ) : ?>
						<h1 class="aiq-404-template__headline"><?php echo esc_html( $settings['headline'] ); ?></h1>
					<?php endif; ?>

					<?php if ( ! empty( $settings['subheading'] ) ) : ?>
						<p class="aiq-404-template__subheading"><?php echo esc_html( $settings['subheading'] ); ?></p>
					<?php endif; ?>

					<?php if ( 'yes' === $settings['show_search'] ) : ?>
						<div class="aiq-404-template__search">
							<form role="search" method="get" class="aiq-404-template__search-form" action="<?php echo esc_url( home_url( '/' ) ); ?>">
								<input type="search" class="aiq-404-template__search-input" placeholder="<?php echo esc_attr( $settings['search_placeholder'] ); ?>" value="<?php echo esc_attr( get_search_query() ); ?>" name="s" aria-label="<?php esc_attr_e( 'Search', 'aiqengage-child' ); ?>">
								<button type="submit" class="aiq-404-template__search-button" aria-label="<?php esc_attr_e( 'Search', 'aiqengage-child' ); ?>">
									<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
										<path d="M11 19C15.4183 19 19 15.4183 19 11C19 6.58172 15.4183 3 11 3C6.58172 3 3 6.58172 3 11C3 15.4183 6.58172 19 11 19Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
										<path d="M21 21L16.65 16.65" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
									</svg>
								</button>
							</form>
						</div>
					<?php endif; ?>

					<?php if ( 'yes' === $settings['show_cta'] ) : ?>
						<a href="<?php echo esc_url( $cta_link ); ?>" class="aiq-404-template__cta <?php echo esc_attr( $cta_animation_class ); ?>" target="<?php echo esc_attr( $cta_target ); ?>" rel="<?php echo esc_attr( $cta_rel ); ?>">
							<?php echo esc_html( $settings['cta_text'] ); ?>
						</a>
					<?php endif; ?>
				</div>

				<div class="aiq-404-template__mascot <?php echo esc_attr( $mascot_animation_class ); ?>">
					<?php if ( 'static' === $settings['mascot_type'] && ! empty( $settings['mascot_image']['url'] ) ) : ?>
						<img src="<?php echo esc_url( $settings['mascot_image']['url'] ); ?>" alt="<?php echo esc_attr__( 'AI Assistant', 'aiqengage-child' ); ?>" class="aiq-404-template__mascot-image">
					<?php elseif ( 'lottie' === $settings['mascot_type'] && ! empty( $settings['lottie_url']['url'] ) ) : ?>
						<div class="aiq-404-template__lottie" data-lottie-url="<?php echo esc_url( $settings['lottie_url']['url'] ); ?>" data-animation-duration="<?php echo esc_attr( $settings['mascot_animation_duration']['size'] ); ?>"></div>
					<?php elseif ( 'svg' === $settings['mascot_type'] && ! empty( $settings['svg_code'] ) ) : ?>
						<div class="aiq-404-template__svg">
							<?php echo wp_kses_post( $settings['svg_code'] ); ?>
						</div>
					<?php endif; ?>
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
		view.addRenderAttribute('wrapper', 'class', 'aiq-404-template');
		view.addRenderAttribute('wrapper', 'role', 'region');
		view.addRenderAttribute('wrapper', 'aria-label', 'Page Not Found');

		// CTA link attributes
		var ctaLink = settings.cta_link.url || '<?php echo esc_url( home_url() ); ?>';
		var ctaTarget = settings.cta_link.is_external ? '_blank' : '_self';
		var ctaRel = settings.cta_link.nofollow ? 'nofollow' : '';

		// Mascot animation class
		var mascotAnimationClass = '';
		if (settings.mascot_animation) {
			mascotAnimationClass = 'aiq-animation-' + settings.mascot_animation;
		}

		// CTA hover animation
		var ctaAnimationClass = '';
		if (settings.cta_hover_animation) {
			ctaAnimationClass = 'elementor-animation-' + settings.cta_hover_animation;
		}
		#>
		<div {{{ view.getRenderAttributeString('wrapper') }}}>
			<# if ('yes' === settings.show_neural_pattern) { #>
				<div class="aiq-404-template__neural-pattern"></div>
			<# } #>

			<div class="aiq-404-template__container">
				<div class="aiq-404-template__content">
					<# if (settings.headline) { #>
						<h1 class="aiq-404-template__headline">{{{ settings.headline }}}</h1>
					<# } #>

					<# if (settings.subheading) { #>
						<p class="aiq-404-template__subheading">{{{ settings.subheading }}}</p>
					<# } #>

					<# if ('yes' === settings.show_search) { #>
						<div class="aiq-404-template__search">
							<form role="search" method="get" class="aiq-404-template__search-form" action="<?php echo esc_url( home_url( '/' ) ); ?>">
								<input type="search" class="aiq-404-template__search-input" placeholder="{{ settings.search_placeholder }}" value="<?php echo get_search_query(); ?>" name="s" aria-label="<?php esc_attr_e( 'Search', 'aiqengage-child' ); ?>">
								<button type="submit" class="aiq-404-template__search-button" aria-label="<?php esc_attr_e( 'Search', 'aiqengage-child' ); ?>">
									<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
										<path d="M11 19C15.4183 19 19 15.4183 19 11C19 6.58172 15.4183 3 11 3C6.58172 3 3 6.58172 3 11C3 15.4183 6.58172 19 11 19Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
										<path d="M21 21L16.65 16.65" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
									</svg>
								</button>
							</form>
						</div>
					<# } #>

					<# if ('yes' === settings.show_cta) { #>
						<a href="{{ ctaLink }}" class="aiq-404-template__cta {{ ctaAnimationClass }}" target="{{ ctaTarget }}" rel="{{ ctaRel }}">
							{{{ settings.cta_text }}}
						</a>
					<# } #>
				</div>

				<div class="aiq-404-template__mascot {{ mascotAnimationClass }}">
					<# if ('static' === settings.mascot_type && settings.mascot_image.url) { #>
						<img src="{{ settings.mascot_image.url }}" alt="<?php esc_attr_e( 'AI Assistant', 'aiqengage-child' ); ?>" class="aiq-404-template__mascot-image">
					<# } else if ('lottie' === settings.mascot_type && settings.lottie_url.url) { #>
						<div class="aiq-404-template__lottie" data-lottie-url="{{ settings.lottie_url.url }}" data-animation-duration="{{ settings.mascot_animation_duration.size }}"></div>
					<# } else if ('svg' === settings.mascot_type && settings.svg_code) { #>
						<div class="aiq-404-template__svg">
							{{{ settings.svg_code }}}
						</div>
					<# } #>
				</div>
			</div>
		</div>
		<?php
	}
}
