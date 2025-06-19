<?php
namespace AIQEngage;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class AIQ_Quiz_Widget extends Widget_Base {

	public function get_name() {
		return 'aiq-quiz';
	}

	public function get_title() {
		return esc_html__( 'Quiz', 'aiqengage-child' );
	}

	public function get_icon() {
		return 'eicon-quiz';
	}

	public function get_categories() {
		return [ 'aiqengage' ];
	}

	public function get_keywords() {
		return [ 'quiz', 'test', 'interactive', 'form', 'aiqengage' ];
	}

	public function get_style_depends() {
		return [ 'aiq-quiz-style' ];
	}

	public function get_script_depends() {
		return [ 'aiq-quiz-script' ];
	}

	/**
	 * Optional: Provide a help/documentation URL for this widget.
	 */
	public function get_help_url() {
		return 'https://docs.aiqengage.com/widgets/quiz';
	}

	protected function register_controls() {
		// Existing controls follow...

		$this->add_group_control(
			\Elementor\Group_Control_Border::get_type(),
			[
				'name'     => 'answer_selected_border',
				'selector' => '{{WRAPPER}} .aiq-quiz__answer-option.is-selected',
				'default'  => [
					'border-style'  => 'solid',
					'border-width'  => '1',
					'border-color'  => '#9C4DFF',
				],
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'answer_selected_box_shadow',
				'selector' => '{{WRAPPER}} .aiq-quiz__answer-option.is-selected',
				'default'  => [
					'box_shadow_type'    => 'yes',
					'box_shadow_blur'    => '8',
					'box_shadow_spread'  => '0',
					'box_shadow_color'   => 'rgba(156, 77, 255, 0.2)',
					'box_shadow_x'       => '0',
					'box_shadow_y'       => '2',
					'box_shadow_position'=> '',
				],
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'answer_correct_tab',
			[
				'label' => esc_html__( 'Correct', 'aiqengage-child' ),
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Background::get_type(),
			[
				'name'     => 'answer_correct_background',
				'types'    => [ 'classic', 'gradient' ],
				'selector' => '{{WRAPPER}} .aiq-quiz__answer-option.is-correct',
				'default'  => [
					'background' => 'classic',
					'color'      => 'rgba(76, 175, 80, 0.2)',
				],
			]
		);

		$this->add_control(
			'answer_correct_text_color',
			[
				'label'     => esc_html__( 'Text Color', 'aiqengage-child' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .aiq-quiz__answer-option.is-correct .aiq-quiz__answer-text' => 'color: {{VALUE}};',
				],
				'default'   => '#E0D6FF',
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Border::get_type(),
			[
				'name'     => 'answer_correct_border',
				'selector' => '{{WRAPPER}} .aiq-quiz__answer-option.is-correct',
				'default'  => [
					'border-style'  => 'solid',
					'border-width'  => '1',
					'border-color'  => '#4CAF50',
				],
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'answer_correct_box_shadow',
				'selector' => '{{WRAPPER}} .aiq-quiz__answer-option.is-correct',
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'answer_incorrect_tab',
			[
				'label' => esc_html__( 'Incorrect', 'aiqengage-child' ),
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Background::get_type(),
			[
				'name'     => 'answer_incorrect_background',
				'types'    => [ 'classic', 'gradient' ],
				'selector' => '{{WRAPPER}} .aiq-quiz__answer-option.is-incorrect',
				'default'  => [
					'background' => 'classic',
					'color'      => 'rgba(244, 67, 54, 0.2)',
				],
			]
		);

		$this->add_control(
			'answer_incorrect_text_color',
			[
				'label'     => esc_html__( 'Text Color', 'aiqengage-child' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .aiq-quiz__answer-option.is-incorrect .aiq-quiz__answer-text' => 'color: {{VALUE}};',
				],
				'default'   => '#E0D6FF',
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Border::get_type(),
			[
				'name'     => 'answer_incorrect_border',
				'selector' => '{{WRAPPER}} .aiq-quiz__answer-option.is-incorrect',
				'default'  => [
					'border-style'  => 'solid',
					'border-width'  => '1',
					'border-color'  => '#F44336',
				],
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'answer_incorrect_box_shadow',
				'selector' => '{{WRAPPER}} .aiq-quiz__answer-option.is-incorrect',
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->add_responsive_control(
			'answer_padding',
			[
				'label'      => esc_html__( 'Padding', 'aiqengage-child' ),
				'type'       => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .aiq-quiz__answer-option' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'separator'  => 'before',
				'default'    => [
					'top'      => '15',
					'right'    => '20',
					'bottom'   => '15',
					'left'     => '20',
					'unit'     => 'px',
					'isLinked' => false,
				],
			]
		);

		$this->add_responsive_control(
			'answer_margin',
			[
				'label'      => esc_html__( 'Margin', 'aiqengage-child' ),
				'type'       => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .aiq-quiz__answer-option' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'default'    => [
					'top'      => '0',
					'right'    => '0',
					'bottom'   => '10',
					'left'     => '0',
					'unit'     => 'px',
					'isLinked' => false,
				],
			]
		);

		$this->add_control(
			'answer_transition',
			[
				'label'     => esc_html__( 'Transition Duration', 'aiqengage-child' ),
				'type'      => \Elementor\Controls_Manager::SLIDER,
				'range'     => [
					'px' => [
						'min'  => 0.1,
						'max'  => 2,
						'step' => 0.1,
					],
				],
				'default'   => [
					'size' => 0.3,
				],
				'selectors' => [
					'{{WRAPPER}} .aiq-quiz__answer-option' => 'transition-duration: {{SIZE}}s',
				],
			]
		);

		$this->end_controls_section();

		// Progress Bar Style Section
		$this->start_controls_section(
			'section_progress_style',
			[
				'label'     => esc_html__( 'Progress Bar', 'aiqengage-child' ),
				'tab'       => \Elementor\Controls_Manager::TAB_STYLE,
				'condition' => [
					'show_progress_bar' => 'yes',
				],
			]
		);

		$this->add_control(
			'progress_bar_height',
			[
				'label'      => esc_html__( 'Height', 'aiqengage-child' ),
				'type'       => \Elementor\Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range'      => [
					'px' => [
						'min'  => 1,
						'max'  => 20,
						'step' => 1,
					],
				],
				'default'    => [
					'unit' => 'px',
					'size' => 6,
				],
				'selectors'  => [
					'{{WRAPPER}} .aiq-quiz__progress-bar' => 'height: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'progress_bar_border_radius',
			[
				'label'      => esc_html__( 'Border Radius', 'aiqengage-child' ),
				'type'       => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors'  => [
					'{{WRAPPER}} .aiq-quiz__progress-bar'         => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					'{{WRAPPER}} .aiq-quiz__progress-bar-fill'    => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'default'    => [
					'top'      => '3',
					'right'    => '3',
					'bottom'   => '3',
					'left'     => '3',
					'unit'     => 'px',
					'isLinked' => true,
				],
			]
		);

		$this->add_control(
			'progress_bar_background_color',
			[
				'label'     => esc_html__( 'Background Color', 'aiqengage-child' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .aiq-quiz__progress-bar' => 'background-color: {{VALUE}};',
				],
				'default'   => 'rgba(156, 77, 255, 0.2)',
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Background::get_type(),
			[
				'name'     => 'progress_bar_fill_background',
				'types'    => [ 'classic', 'gradient' ],
				'selector' => '{{WRAPPER}} .aiq-quiz__progress-bar-fill',
				'default'  => [
					'background' => 'gradient',
					'color'      => '#635BFF',
					'color_b'    => '#8E6BFF',
				],
			]
		);

		$this->add_control(
			'progress_transition_duration',
			[
				'label'     => esc_html__( 'Transition Duration', 'aiqengage-child' ),
				'type'      => \Elementor\Controls_Manager::SLIDER,
				'range'     => [
					'px' => [
						'min'  => 0.1,
						'max'  => 2,
						'step' => 0.1,
					],
				],
				'default'   => [
					'size' => 0.5,
				],
				'selectors' => [
					'{{WRAPPER}} .aiq-quiz__progress-bar-fill' => 'transition-duration: {{SIZE}}s',
				],
			]
		);

		$this->add_responsive_control(
			'progress_bar_margin',
			[
				'label'      => esc_html__( 'Margin', 'aiqengage-child' ),
				'type'       => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .aiq-quiz__progress' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'default'    => [
					'top'      => '0',
					'right'    => '0',
					'bottom'   => '20',
					'left'     => '0',
					'unit'     => 'px',
					'isLinked' => false,
				],
			]
		);

		$this->end_controls_section();

		// Feedback Style Section
		$this->start_controls_section(
			'section_feedback_style',
			[
				'label' => esc_html__( 'Answer Feedback', 'aiqengage-child' ),
				'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
				'condition' => [
					'show_explanation' => 'yes',
				],
			]
		);

		$this->add_control(
			'feedback_background_color',
			[
				'label'     => esc_html__( 'Background Color', 'aiqengage-child' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .aiq-quiz__feedback' => 'background-color: {{VALUE}};',
				],
				'default'   => 'rgba(126, 87, 194, 0.1)',
			]
		);

		$this->add_control(
			'feedback_border_color',
			[
				'label'     => esc_html__( 'Border Color', 'aiqengage-child' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .aiq-quiz__feedback' => 'border-color: {{VALUE}};',
				],
				'default'   => 'rgba(156, 77, 255, 0.3)',
			]
		);

		$this->add_control(
			'feedback_border_width',
			[
				'label'     => esc_html__( 'Border Width', 'aiqengage-child' ),
				'type'      => \Elementor\Controls_Manager::SLIDER,
				'range'     => [
					'px' => [
						'min'  => 0,
						'max'  => 10,
						'step' => 1,
					],
				],
				'default'   => [
					'size' => 1,
				],
				'selectors' => [
					'{{WRAPPER}} .aiq-quiz__feedback' => 'border-width: {{SIZE}}px; border-style: solid;',
				],
			]
		);

		$this->add_control(
			'feedback_border_radius',
			[
				'label'      => esc_html__( 'Border Radius', 'aiqengage-child' ),
				'type'       => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors'  => [
					'{{WRAPPER}} .aiq-quiz__feedback' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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

		$this->add_responsive_control(
			'feedback_padding',
			[
				'label'      => esc_html__( 'Padding', 'aiqengage-child' ),
				'type'       => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .aiq-quiz__feedback' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'default'    => [
					'top'      => '15',
					'right'    => '20',
					'bottom'   => '15',
					'left'     => '20',
					'unit'     => 'px',
					'isLinked' => false,
				],
			]
		);

		$this->add_responsive_control(
			'feedback_margin',
			[
				'label'      => esc_html__( 'Margin', 'aiqengage-child' ),
				'type'       => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .aiq-quiz__feedback' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'default'    => [
					'top'      => '10',
					'right'    => '0',
					'bottom'   => '20',
					'left'     => '0',
					'unit'     => 'px',
					'isLinked' => false,
				],
			]
		);

		$this->add_control(
			'feedback_text_color',
			[
				'label'     => esc_html__( 'Text Color', 'aiqengage-child' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .aiq-quiz__feedback' => 'color: {{VALUE}};',
				],
				'default'   => '#E0D6FF',
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name'     => 'feedback_typography',
				'selector' => '{{WRAPPER}} .aiq-quiz__feedback',
				'default'  => [
					'font_family'    => 'Inter',
					'font_size'      => '0.9rem',
					'font_weight'    => '400',
					'line_height'    => '1.5',
					'letter_spacing' => '',
					'text_transform' => '',
				],
			]
		);

		$this->end_controls_section();

		// Results Style Section
		$this->start_controls_section(
			'section_results_style',
			[
				'label' => esc_html__( 'Results', 'aiqengage-child' ),
				'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'results_background_color',
			[
				'label'     => esc_html__( 'Background Color', 'aiqengage-child' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .aiq-quiz__results' => 'background-color: {{VALUE}};',
				],
				'default'   => '#2A1958',
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Border::get_type(),
			[
				'name'     => 'results_border',
				'selector' => '{{WRAPPER}} .aiq-quiz__results',
				'default'  => [
					'border-style'  => 'solid',
					'border-width'  => '1',
					'border-color'  => 'rgba(156, 77, 255, 0.3)',
					'border-radius' => '15',
				],
			]
		);

		$this->add_responsive_control(
			'results_border_radius',
			[
				'label'      => esc_html__( 'Border Radius', 'aiqengage-child' ),
				'type'       => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors'  => [
					'{{WRAPPER}} .aiq-quiz__results' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'default'    => [
					'top'      => '15',
					'right'    => '15',
					'bottom'   => '15',
					'left'     => '15',
					'unit'     => 'px',
					'isLinked' => true,
				],
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'results_box_shadow',
				'selector' => '{{WRAPPER}} .aiq-quiz__results',
				'default'  => [
					'box_shadow_type'    => 'yes',
					'box_shadow_blur'    => '15',
					'box_shadow_spread'  => '0',
					'box_shadow_color'   => 'rgba(0, 0, 0, 0.3)',
					'box_shadow_x'       => '0',
					'box_shadow_y'       => '5',
					'box_shadow_position'=> '',
				],
			]
		);

		$this->add_responsive_control(
			'results_padding',
			[
				'label'      => esc_html__( 'Padding', 'aiqengage-child' ),
				'type'       => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .aiq-quiz__results' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'default'    => [
					'top'      => '30',
					'right'    => '30',
					'bottom'   => '30',
					'left'     => '30',
					'unit'     => 'px',
					'isLinked' => true,
				],
			]
		);

		$this->add_responsive_control(
			'results_margin',
			[
				'label'      => esc_html__( 'Margin', 'aiqengage-child' ),
				'type'       => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .aiq-quiz__results' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'default'    => [
					'top'      => '30',
					'right'    => '0',
					'bottom'   => '0',
					'left'     => '0',
					'unit'     => 'px',
					'isLinked' => false,
				],
			]
		);

		$this->add_control(
			'result_title_heading',
			[
				'label'     => esc_html__( 'Result Title', 'aiqengage-child' ),
				'type'      => \Elementor\Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_control(
			'result_title_color',
			[
				'label'     => esc_html__( 'Title Color', 'aiqengage-child' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .aiq-quiz__result-title' => 'color: {{VALUE}};',
				],
				'default'   => '#E0D6FF',
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name'     => 'result_title_typography',
				'selector' => '{{WRAPPER}} .aiq-quiz__result-title',
				'default'  => [
					'font_family'    => 'Inter',
					'font_size'      => '1.8rem',
					'font_weight'    => '700',
					'line_height'    => '1.2',
					'letter_spacing' => '',
					'text_transform' => '',
				],
			]
		);

		$this->add_responsive_control(
			'result_title_margin',
			[
				'label'      => esc_html__( 'Margin', 'aiqengage-child' ),
				'type'       => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .aiq-quiz__result-title' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'default'    => [
					'top'      => '0',
					'right'    => '0',
					'bottom'   => '15',
					'left'     => '0',
					'unit'     => 'px',
					'isLinked' => false,
				],
			]
		);

		$this->add_control(
			'result_description_heading',
			[
				'label'     => esc_html__( 'Result Description', 'aiqengage-child' ),
				'type'      => \Elementor\Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_control(
			'result_description_color',
			[
				'label'     => esc_html__( 'Description Color', 'aiqengage-child' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .aiq-quiz__result-description' => 'color: {{VALUE}};',
				],
				'default'   => '#E0D6FF',
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name'     => 'result_description_typography',
				'selector' => '{{WRAPPER}} .aiq-quiz__result-description',
				'default'  => [
					'font_family'    => 'Inter',
					'font_size'      => '1rem',
					'font_weight'    => '400',
					'line_height'    => '1.6',
					'letter_spacing' => '',
					'text_transform' => '',
				],
			]
		);

		$this->add_responsive_control(
			'result_description_margin',
			[
				'label'      => esc_html__( 'Margin', 'aiqengage-child' ),
				'type'       => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .aiq-quiz__result-description' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'default'    => [
					'top'      => '0',
					'right'    => '0',
					'bottom'   => '20',
					'left'     => '0',
					'unit'     => 'px',
					'isLinked' => false,
				],
			]
		);

		$this->add_control(
			'result_score_heading',
			[
				'label'     => esc_html__( 'Score Display', 'aiqengage-child' ),
				'type'      => \Elementor\Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_control(
			'result_score_color',
			[
				'label'     => esc_html__( 'Score Color', 'aiqengage-child' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .aiq-quiz__score' => 'color: {{VALUE}};',
				],
				'default'   => '#9C4DFF',
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name'     => 'result_score_typography',
				'selector' => '{{WRAPPER}} .aiq-quiz__score',
				'default'  => [
					'font_family'    => 'Inter',
					'font_size'      => '2rem',
					'font_weight'    => '700',
					'line_height'    => '1.2',
					'letter_spacing' => '',
					'text_transform' => '',
				],
			]
		);

		$this->add_responsive_control(
			'result_score_margin',
			[
				'label'      => esc_html__( 'Margin', 'aiqengage-child' ),
				'type'       => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .aiq-quiz__score' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'default'    => [
					'top'      => '0',
					'right'    => '0',
					'bottom'   => '20',
					'left'     => '0',
					'unit'     => 'px',
					'isLinked' => false,
				],
			]
		);

		$this->end_controls_section();

		// Lead Capture Form Style Section
		$this->start_controls_section(
			'section_form_style',
			[
				'label'     => esc_html__( 'Lead Capture Form', 'aiqengage-child' ),
				'tab'       => \Elementor\Controls_Manager::TAB_STYLE,
				'condition' => [
					'enable_lead_capture' => 'yes',
				],
			]
		);

		$this->add_control(
			'form_background_color',
			[
				'label'     => esc_html__( 'Background Color', 'aiqengage-child' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .aiq-quiz__form' => 'background-color: {{VALUE}};',
				],
				'default'   => '#2A1958',
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Border::get_type(),
			[
				'name'     => 'form_border',
				'selector' => '{{WRAPPER}} .aiq-quiz__form',
				'default'  => [
					'border-style'  => 'solid',
					'border-width'  => '1',
					'border-color'  => 'rgba(156, 77, 255, 0.3)',
					'border-radius' => '15',
				],
			]
		);

		$this->add_responsive_control(
			'form_border_radius',
			[
				'label'      => esc_html__( 'Border Radius', 'aiqengage-child' ),
				'type'       => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors'  => [
					'{{WRAPPER}} .aiq-quiz__form' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'default'    => [
					'top'      => '15',
					'right'    => '15',
					'bottom'   => '15',
					'left'     => '15',
					'unit'     => 'px',
					'isLinked' => true,
				],
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'form_box_shadow',
				'selector' => '{{WRAPPER}} .aiq-quiz__form',
				'default'  => [
					'box_shadow_type'    => 'yes',
					'box_shadow_blur'    => '15',
					'box_shadow_spread'  => '0',
					'box_shadow_color'   => 'rgba(0, 0, 0, 0.3)',
					'box_shadow_x'       => '0',
					'box_shadow_y'       => '5',
					'box_shadow_position'=> '',
				],
			]
		);

		$this->add_responsive_control(
			'form_padding',
			[
				'label'      => esc_html__( 'Padding', 'aiqengage-child' ),
				'type'       => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .aiq-quiz__form' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'default'    => [
					'top'      => '30',
					'right'    => '30',
					'bottom'   => '30',
					'left'     => '30',
					'unit'     => 'px',
					'isLinked' => true,
				],
			]
		);

		$this->add_responsive_control(
			'form_margin',
			[
				'label'      => esc_html__( 'Margin', 'aiqengage-child' ),
				'type'       => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .aiq-quiz__form' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'default'    => [
					'top'      => '0',
					'right'    => '0',
					'bottom'   => '30',
					'left'     => '0',
					'unit'     => 'px',
					'isLinked' => false,
				],
			]
		);

		$this->add_control(
			'form_title_color',
			[
				'label'     => esc_html__( 'Title Color', 'aiqengage-child' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .aiq-quiz__form-title' => 'color: {{VALUE}};',
				],
				'default'   => '#E0D6FF',
				'separator' => 'before',
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name'     => 'form_title_typography',
				'selector' => '{{WRAPPER}} .aiq-quiz__form-title',
				'default'  => [
					'font_family'    => 'Inter',
					'font_size'      => '1.5rem',
					'font_weight'    => '700',
					'line_height'    => '1.3',
					'letter_spacing' => '',
					'text_transform' => '',
				],
			]
		);

		$this->add_control(
			'form_description_color',
			[
				'label'     => esc_html__( 'Description Color', 'aiqengage-child' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .aiq-quiz__form-description' => 'color: {{VALUE}};',
				],
				'default'   => '#E0D6FF',
				'separator' => 'before',
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name'     => 'form_description_typography',
				'selector' => '{{WRAPPER}} .aiq-quiz__form-description',
				'default'  => [
					'font_family'    => 'Inter',
					'font_size'      => '1rem',
					'font_weight'    => '400',
					'line_height'    => '1.6',
					'letter_spacing' => '',
					'text_transform' => '',
				],
			]
		);

		$this->add_control(
			'form_label_color',
			[
				'label'     => esc_html__( 'Label Color', 'aiqengage-child' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .aiq-quiz__form-label' => 'color: {{VALUE}};',
				],
				'default'   => '#E0D6FF',
				'separator' => 'before',
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name'     => 'form_label_typography',
				'selector' => '{{WRAPPER}} .aiq-quiz__form-label',
				'default'  => [
					'font_family'    => 'Inter',
					'font_size'      => '0.9rem',
					'font_weight'    => '500',
					'line_height'    => '1.4',
					'letter_spacing' => '',
					'text_transform' => '',
				],
			]
		);

		$this->start_controls_tabs( 'form_input_tabs' );

		$this->start_controls_tab(
			'form_input_normal_tab',
			[
				'label' => esc_html__( 'Normal', 'aiqengage-child' ),
			]
		);

		$this->add_control(
			'form_input_background',
			[
				'label'     => esc_html__( 'Input Background', 'aiqengage-child' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .aiq-quiz__form-input' => 'background-color: {{VALUE}};',
				],
				'default'   => 'rgba(26, 9, 56, 0.6)',
			]
		);

		$this->add_control(
			'form_input_text_color',
			[
				'label'     => esc_html__( 'Input Text Color', 'aiqengage-child' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .aiq-quiz__form-input' => 'color: {{VALUE}};',
				],
				'default'   => '#E0D6FF',
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Border::get_type(),
			[
				'name'     => 'form_input_border',
				'selector' => '{{WRAPPER}} .aiq-quiz__form-input',
				'default'  => [
					'border-style'  => 'solid',
					'border-width'  => '1',
					'border-color'  => 'rgba(156, 77, 255, 0.3)',
					'border-radius' => '8',
				],
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'form_input_focus_tab',
			[
				'label' => esc_html__( 'Focus', 'aiqengage-child' ),
			]
		);

		$this->add_control(
			'form_input_focus_background',
			[
				'label'     => esc_html__( 'Input Background', 'aiqengage-child' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .aiq-quiz__form-input:focus' => 'background-color: {{VALUE}};',
				],
				'default'   => 'rgba(26, 9, 56, 0.8)',
			]
		);

		$this->add_control(
			'form_input_focus_text_color',
			[
				'label'     => esc_html__( 'Input Text Color', 'aiqengage-child' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .aiq-quiz__form-input:focus' => 'color: {{VALUE}};',
				],
				'default'   => '#E0D6FF',
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Border::get_type(),
			[
				'name'     => 'form_input_focus_border',
				'selector' => '{{WRAPPER}} .aiq-quiz__form-input:focus',
				'default'  => [
					'border-style'  => 'solid',
					'border-width'  => '1',
					'border-color'  => '#9C4DFF',
					'border-radius' => '8',
				],
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'form_input_focus_box_shadow',
				'selector' => '{{WRAPPER}} .aiq-quiz__form-input:focus',
				'default'  => [
					'box_shadow_type'    => 'yes',
					'box_shadow_blur'    => '3',
					'box_shadow_spread'  => '3',
					'box_shadow_color'   => 'rgba(156, 77, 255, 0.3)',
					'box_shadow_x'       => '0',
					'box_shadow_y'       => '0',
					'box_shadow_position'=> '',
				],
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->add_control(
			'form_input_height',
			[
				'label'      => esc_html__( 'Input Height', 'aiqengage-child' ),
				'type'       => \Elementor\Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range'      => [
					'px' => [
						'min'  => 30,
						'max'  => 80,
						'step' => 1,
					],
				],
				'default'    => [
					'unit' => 'px',
					'size' => 48,
				],
				'selectors'  => [
					'{{WRAPPER}} .aiq-quiz__form-input' => 'height: {{SIZE}}{{UNIT}};',
				],
				'separator'  => 'before',
			]
		);

		$this->add_responsive_control(
			'form_input_padding',
			[
				'label'      => esc_html__( 'Input Padding', 'aiqengage-child' ),
				'type'       => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .aiq-quiz__form-input' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'default'    => [
					'top'      => '10',
					'right'    => '15',
					'bottom'   => '10',
					'left'     => '15',
					'unit'     => 'px',
					'isLinked' => false,
				],
			]
		);

		$this->add_responsive_control(
			'form_input_margin',
			[
				'label'      => esc_html__( 'Input Margin', 'aiqengage-child' ),
				'type'       => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .aiq-quiz__form-input' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'default'    => [
					'top'      => '5',
					'right'    => '0',
					'bottom'   => '15',
					'left'     => '0',
					'unit'     => 'px',
					'isLinked' => false,
				],
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name'     => 'form_input_typography',
				'selector' => '{{WRAPPER}} .aiq-quiz__form-input',
				'default'  => [
					'font_family'    => 'Inter',
					'font_size'      => '1rem',
					'font_weight'    => '400',
					'line_height'    => '1.5',
					'letter_spacing' => '',
					'text_transform' => '',
				],
			]
		);

		$this->add_control(
			'form_privacy_color',
			[
				'label'     => esc_html__( 'Privacy Text Color', 'aiqengage-child' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .aiq-quiz__form-privacy' => 'color: {{VALUE}};',
				],
				'default'   => 'rgba(224, 214, 255, 0.7)',
				'separator' => 'before',
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name'     => 'form_privacy_typography',
				'selector' => '{{WRAPPER}} .aiq-quiz__form-privacy',
				'default'  => [
					'font_family'    => 'Inter',
					'font_size'      => '0.8rem',
					'font_weight'    => '400',
					'line_height'    => '1.4',
					'letter_spacing' => '',
					'text_transform' => '',
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
		$quiz_id = 'aiq-quiz-' . $this->get_id();

		// Load the CSS and JS
		wp_enqueue_style( 'aiq-quiz-style' );
		wp_enqueue_script( 'aiq-quiz-script' );

		// Robust fallback for settings that might not be set
		$questions = isset( $settings['questions'] ) && is_array($settings['questions']) ? $settings['questions'] : [];
		if ( isset($settings['randomize_questions']) && 'yes' === $settings['randomize_questions'] ) {
			shuffle( $questions );
		}

		$quiz_data = [
			'id'                  => $quiz_id,
			'title'               => isset($settings['quiz_title']) ? $settings['quiz_title'] : '',
			'description'         => isset($settings['quiz_description']) ? $settings['quiz_description'] : '',
			'questions'           => $questions,
			'show_progress_bar'   => isset($settings['show_progress_bar']) ? $settings['show_progress_bar'] : '',
			'show_question_numbers' => isset($settings['show_question_numbers']) ? $settings['show_question_numbers'] : '',
			'allow_retake'        => isset($settings['allow_retake']) ? $settings['allow_retake'] : '',
			'show_correct_answers' => isset($settings['show_correct_answers']) ? $settings['show_correct_answers'] : '',
			'show_explanation'    => isset($settings['show_explanation']) ? $settings['show_explanation'] : '',
			'randomize_questions' => isset($settings['randomize_questions']) ? $settings['randomize_questions'] : '',
			'randomize_answers'   => isset($settings['randomize_answers']) ? $settings['randomize_answers'] : '',
			'pass_score'          => isset($settings['pass_score']) ? $settings['pass_score'] : '',
			'result_messages'     => isset($settings['result_messages']) ? $settings['result_messages'] : [],
			'buttons'             => [
				'start'    => isset($settings['start_button_text']) ? $settings['start_button_text'] : '',
				'next'     => isset($settings['next_button_text']) ? $settings['next_button_text'] : '',
				'prev'     => isset($settings['prev_button_text']) ? $settings['prev_button_text'] : '',
				'finish'   => isset($settings['finish_button_text']) ? $settings['finish_button_text'] : '',
				'restart'  => isset($settings['restart_button_text']) ? $settings['restart_button_text'] : '',
			],
			'enable_lead_capture' => isset($settings['enable_lead_capture']) ? $settings['enable_lead_capture'] : '',
			'lead_capture_position' => isset($settings['lead_capture_position']) ? $settings['lead_capture_position'] : '',
			'lead_capture_title'  => isset($settings['lead_capture_title']) ? $settings['lead_capture_title'] : '',
			'lead_capture_description' => isset($settings['lead_capture_description']) ? $settings['lead_capture_description'] : '',
			'require_name'        => isset($settings['require_name']) ? $settings['require_name'] : '',
			'name_label'          => isset($settings['name_label']) ? $settings['name_label'] : '',
			'email_label'         => isset($settings['email_label']) ? $settings['email_label'] : '',
			'privacy_notice'      => isset($settings['privacy_notice']) ? $settings['privacy_notice'] : '',
			'submit_button_text'  => isset($settings['submit_button_text']) ? $settings['submit_button_text'] : '',
			'results_title'       => isset($settings['results_title']) ? $settings['results_title'] : '',
		];

		// Add script data
		wp_localize_script( 'aiq-quiz-script', 'aiqQuizData_' . $this->get_id(), $quiz_data );
		?>
		<div class="aiq-quiz" id="<?php echo esc_attr( $quiz_id ); ?>" data-quiz-id="<?php echo esc_attr( $this->get_id() ); ?>">
			<!-- Start Screen -->
			<div class="aiq-quiz__start-screen">
				<h2 class="aiq-quiz__title"><?php echo esc_html( isset($settings['quiz_title']) ? $settings['quiz_title'] : '' ); ?></h2>
				<p class="aiq-quiz__description"><?php echo esc_html( isset($settings['quiz_description']) ? $settings['quiz_description'] : '' ); ?></p>
				<button class="aiq-quiz__button aiq-quiz__button--primary aiq-quiz__start-button"><?php echo esc_html( isset($settings['start_button_text']) ? $settings['start_button_text'] : '' ); ?></button>
			</div>

			<!-- Quiz Container -->
			<div class="aiq-quiz__container" style="display: none;">
				<?php if ( isset($settings['show_progress_bar']) && 'yes' === $settings['show_progress_bar'] ) : ?>
				<div class="aiq-quiz__progress">
					<div class="aiq-quiz__progress-text" aria-live="polite">
						<span class="aiq-quiz__current-question">1</span>/<span class="aiq-quiz__total-questions"><?php echo count( $questions ); ?></span>
					</div>
					<div class="aiq-quiz__progress-bar" role="progressbar" aria-valuemin="0" aria-valuemax="100" aria-valuenow="0">
						<div class="aiq-quiz__progress-bar-fill" style="width: 0%;"></div>
					</div>
				</div>
				<?php endif; ?>

				<div class="aiq-quiz__questions">
					<?php foreach ( $questions as $index => $question ) :
						$question_id = 'question-' . $index;
						$is_first_question = $index === 0;
					?>
					<div class="aiq-quiz__question" id="<?php echo esc_attr( $question_id ); ?>" data-question-index="<?php echo esc_attr( $index ); ?>" <?php echo $is_first_question ? '' : 'style="display: none;"'; ?>>
						<?php if ( isset($settings['show_question_numbers']) && 'yes' === $settings['show_question_numbers'] ) : ?>
						<div class="aiq-quiz__question-number"><?php echo esc_html__( 'Question', 'aiqengage-child' ); ?> <?php echo $index + 1; ?></div>
						<?php endif; ?>

						<div class="aiq-quiz__question-text"><?php echo esc_html( isset($question['question']) ? $question['question'] : '' ); ?></div>

						<div class="aiq-quiz__answer-options" data-question-type="<?php echo esc_attr( isset($question['question_type']) ? $question['question_type'] : '' ); ?>">
							<?php
							if ( isset($question['question_type']) && 'open' === $question['question_type'] ) :
							?>
								<textarea class="aiq-quiz__form-input aiq-quiz__open-answer" rows="4" placeholder="<?php echo esc_attr__( 'Type your answer here...', 'aiqengage-child' ); ?>" aria-label="<?php echo esc_attr__( 'Answer', 'aiqengage-child' ); ?>"></textarea>
							<?php
							else :
								$options = isset($question['options']) ? explode( "\n", $question['options'] ) : [];
								if ( isset($settings['randomize_answers']) && 'yes' === $settings['randomize_answers'] ) {
									shuffle( $options );
								}

								foreach ( $options as $option_index => $option ) :
									$option = trim( $option );
									$input_id = 'answer-' . $index . '-' . $option_index;
									$input_type = (isset($question['question_type']) && 'single' === $question['question_type']) ? 'radio' : 'checkbox';
									$input_name = (isset($question['question_type']) && 'single' === $question['question_type']) ? 'question-' . $index : 'question-' . $index . '[]';
							?>
								<div class="aiq-quiz__answer-option">
									<input
										type="<?php echo esc_attr( $input_type ); ?>"
										id="<?php echo esc_attr( $input_id ); ?>"
										name="<?php echo esc_attr( $input_name ); ?>"
										value="<?php echo esc_attr( $option ); ?>"
										class="aiq-quiz__answer-input"
									/>
									<label for="<?php echo esc_attr( $input_id ); ?>" class="aiq-quiz__answer-label">
										<span class="aiq-quiz__answer-indicator"></span>
										<span class="aiq-quiz__answer-text"><?php echo esc_html( $option ); ?></span>
									</label>
								</div>
							<?php
								endforeach;
							endif;
							?>
						</div>

						<div class="aiq-quiz__feedback" style="display: none;"></div>

						<div class="aiq-quiz__navigation">
							<?php if ( $index > 0 ) : ?>
							<button class="aiq-quiz__button aiq-quiz__button--secondary aiq-quiz__prev-button"><?php echo esc_html( isset($settings['prev_button_text']) ? $settings['prev_button_text'] : '' ); ?></button>
							<?php endif; ?>

							<?php if ( $index < count( $questions ) - 1 ) : ?>
							<button class="aiq-quiz__button aiq-quiz__button--primary aiq-quiz__next-button"><?php echo esc_html( isset($settings['next_button_text']) ? $settings['next_button_text'] : '' ); ?></button>
							<?php else : ?>
							<button class="aiq-quiz__button aiq-quiz__button--primary aiq-quiz__finish-button"><?php echo esc_html( isset($settings['finish_button_text']) ? $settings['finish_button_text'] : '' ); ?></button>
							<?php endif; ?>
						</div>
					</div>
					<?php endforeach; ?>
				</div>
			</div>

			<!-- Lead Capture Form -->
			<?php if ( isset($settings['enable_lead_capture']) && 'yes' === $settings['enable_lead_capture'] ) : ?>
			<div class="aiq-quiz__form" style="display: none;">
				<h3 class="aiq-quiz__form-title"><?php echo esc_html( isset($settings['lead_capture_title']) ? $settings['lead_capture_title'] : '' ); ?></h3>
				<p class="aiq-quiz__form-description"><?php echo esc_html( isset($settings['lead_capture_description']) ? $settings['lead_capture_description'] : '' ); ?></p>

				<form class="aiq-quiz__lead-form">
					<?php if ( isset($settings['require_name']) && 'yes' === $settings['require_name'] ) : ?>
					<div class="aiq-quiz__form-group">
						<label for="<?php echo esc_attr( $quiz_id ); ?>-name" class="aiq-quiz__form-label"><?php echo esc_html( isset($settings['name_label']) ? $settings['name_label'] : '' ); ?></label>
						<input type="text" id="<?php echo esc_attr( $quiz_id ); ?>-name" name="name" class="aiq-quiz__form-input" required>
					</div>
					<?php endif; ?>

					<div class="aiq-quiz__form-group">
						<label for="<?php echo esc_attr( $quiz_id ); ?>-email" class="aiq-quiz__form-label"><?php echo esc_html( isset($settings['email_label']) ? $settings['email_label'] : '' ); ?></label>
						<input type="email" id="<?php echo esc_attr( $quiz_id ); ?>-email" name="email" class="aiq-quiz__form-input" required>
					</div>

					<p class="aiq-quiz__form-privacy"><?php echo esc_html( isset($settings['privacy_notice']) ? $settings['privacy_notice'] : '' ); ?></p>

					<button type="submit" class="aiq-quiz__button aiq-quiz__button--primary aiq-quiz__submit-button"><?php echo esc_html( isset($settings['submit_button_text']) ? $settings['submit_button_text'] : '' ); ?></button>
				</form>
			</div>
			<?php endif; ?>

			<!-- Results Screen -->
			<div class="aiq-quiz__results" style="display: none;">
				<h2 class="aiq-quiz__results-title"><?php echo esc_html( isset($settings['results_title']) ? $settings['results_title'] : '' ); ?></h2>

				<div class="aiq-quiz__score-container">
					<div class="aiq-quiz__score"></div>
					<div class="aiq-quiz__score-text"></div>
				</div>

				<div class="aiq-quiz__result-content">
					<h3 class="aiq-quiz__result-title"></h3>
					<p class="aiq-quiz__result-description"></p>
					<a href="#" class="aiq-quiz__button aiq-quiz__button--primary aiq-quiz__result-cta"></a>
				</div>

				<?php if ( isset($settings['allow_retake']) && 'yes' === $settings['allow_retake'] ) : ?>
				<button class="aiq-quiz__button aiq-quiz__button--secondary aiq-quiz__restart-button"><?php echo esc_html( isset($settings['restart_button_text']) ? $settings['restart_button_text'] : '' ); ?></button>
				<?php endif; ?>
			</div>
		</div>
		<?php
	}

	/**
	 * Must be called externally to register assets.
	 * Register scripts and styles.
	 */
	public static function register_scripts() {
		wp_register_style(
			'aiq-quiz-style',
			AIQENGAGE_CHILD_URL . '/assets/css/widgets/quiz.css',
			[],
			AIQENGAGE_CHILD_VERSION
		);

		wp_register_script(
			'aiq-quiz-script',
			AIQENGAGE_CHILD_URL . '/assets/js/quiz.js',
			['jquery'],
			AIQENGAGE_CHILD_VERSION,
			true
		);
	}
}
