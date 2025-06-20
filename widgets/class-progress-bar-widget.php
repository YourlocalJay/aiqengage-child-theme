<?php
/**
 * Enhanced Progress Bar Widget for AIQEngage
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
 * Elementor Progress Bar Widget with enhanced features and performance.
 */
class AIQ_Progress_Bar_Widget extends \Elementor\Widget_Base {

	/**
	 * Get widget name.
	 *
	 * @return string Widget name.
	 */
	public function get_name() {
		return 'aiq_progress_bar';
	}

	/**
	 * Get widget title.
	 *
	 * @return string Widget title.
	 */
	public function get_title() {
		return esc_html__( 'Reading Progress Bar', 'aiqengage-child' );
	}

	/**
	 * Get widget icon.
	 *
	 * @return string Widget icon.
	 */
	public function get_icon() {
		return 'eicon-skill-bar';
	}

	/**
	 * Get widget keywords.
	 *
	 * @return array Widget keywords.
	 */
	public function get_keywords() {
		return array( 'progress', 'reading', 'bar', 'scroll', 'engagement' );
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
	 * Get widget style dependencies.
	 *
	 * @return string[] CSS handles.
	 */
	public function get_style_depends() {
		return array( 'aiq-progress-bar' );
	}

	/**
	 * Get widget script dependencies.
	 *
	 * @return string[] JS handles.
	 */
	public function get_script_depends() {
		return array( 'aiq-progress-bar' );
	}

	/**
	 * Register widget controls with enhanced options.
	 */
	protected function register_controls() {
		// Content Section
		$this->start_controls_section(
			'section_content',
			array(
				'label' => esc_html__( 'Settings', 'aiqengage-child' ),
				'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
			)
		);

		$this->add_control(
			'bar_position',
			array(
				'label'   => esc_html__( 'Bar Position', 'aiqengage-child' ),
				'type'    => \Elementor\Controls_Manager::SELECT,
				'default' => 'top',
				'options' => array(
					'top'    => esc_html__( 'Top of Page', 'aiqengage-child' ),
					'bottom' => esc_html__( 'Bottom of Page', 'aiqengage-child' ),
					'inline' => esc_html__( 'Inline (Widget Position)', 'aiqengage-child' ),
				),
			)
		);

		$this->add_control(
			'show_percentage',
			array(
				'label'        => esc_html__( 'Show Percentage', 'aiqengage-child' ),
				'type'         => \Elementor\Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Show', 'aiqengage-child' ),
				'label_off'    => esc_html__( 'Hide', 'aiqengage-child' ),
				'return_value' => 'yes',
				'default'      => 'no',
			)
		);

		$this->add_control(
			'percentage_position',
			array(
				'label'     => esc_html__( 'Percentage Position', 'aiqengage-child' ),
				'type'      => \Elementor\Controls_Manager::SELECT,
				'default'   => 'end',
				'options'   => array(
					'start' => esc_html__( 'Start of Bar', 'aiqengage-child' ),
					'end'   => esc_html__( 'End of Bar', 'aiqengage-child' ),
					'fixed' => esc_html__( 'Fixed Right', 'aiqengage-child' ),
				),
				'condition' => array(
					'show_percentage' => 'yes',
				),
			)
		);

		$this->add_control(
			'display_condition',
			array(
				'label'   => esc_html__( 'Display On', 'aiqengage-child' ),
				'type'    => \Elementor\Controls_Manager::SELECT,
				'default' => 'posts',
				'options' => array(
					'posts'      => esc_html__( 'Posts & Pages Only', 'aiqengage-child' ),
					'everywhere' => esc_html__( 'Everywhere', 'aiqengage-child' ),
					'custom'     => esc_html__( 'Custom Conditions', 'aiqengage-child' ),
				),
			)
		);

		$this->add_control(
			'custom_conditions',
			array(
				'label'       => esc_html__( 'Custom Display Conditions', 'aiqengage-child' ),
				'type'        => \Elementor\Controls_Manager::TEXTAREA,
				'description' => esc_html__( 'Enter PHP conditional tags separated by new lines (e.g., is_front_page(), is_category())', 'aiqengage-child' ),
				'condition'   => array(
					'display_condition' => 'custom',
				),
			)
		);

		$this->add_control(
			'animation_speed',
			array(
				'label'   => esc_html__( 'Animation Speed (ms)', 'aiqengage-child' ),
				'type'    => \Elementor\Controls_Manager::NUMBER,
				'default' => 100,
				'min'     => 0,
				'max'     => 1000,
				'step'    => 10,
			)
		);

		$this->end_controls_section();

		// Style Section
		$this->start_controls_section(
			'section_style',
			array(
				'label' => esc_html__( 'Style', 'aiqengage-child' ),
				'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_control(
			'bar_color',
			array(
				'label'     => esc_html__( 'Bar Color', 'aiqengage-child' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '#9C4DFF',
				'selectors' => array(
					'{{WRAPPER}} .aiq-progress-bar__indicator' => 'background-color: {{VALUE}}',
					'{{WRAPPER}} .aiq-progress-bar__percentage' => 'background-color: {{VALUE}}',
				),
			)
		);

		$this->add_control(
			'bar_background',
			array(
				'label'     => esc_html__( 'Bar Background', 'aiqengage-child' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => 'rgba(156, 77, 255, 0.2)',
				'selectors' => array(
					'{{WRAPPER}} .aiq-progress-bar__container' => 'background-color: {{VALUE}}',
				),
			)
		);

		$this->add_control(
			'bar_height',
			array(
				'label'      => esc_html__( 'Bar Height', 'aiqengage-child' ),
				'type'       => \Elementor\Controls_Manager::SLIDER,
				'size_units' => array( 'px' ),
				'range'      => array(
					'px' => array(
						'min'  => 1,
						'max'  => 20,
						'step' => 1,
					),
				),
				'default'    => array(
					'unit' => 'px',
					'size' => 4,
				),
				'selectors'  => array(
					'{{WRAPPER}} .aiq-progress-bar__container' => 'height: {{SIZE}}{{UNIT}};',
				),
			)
		);

		$this->add_control(
			'percentage_color',
			array(
				'label'     => esc_html__( 'Percentage Text Color', 'aiqengage-child' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '#FFFFFF',
				'selectors' => array(
					'{{WRAPPER}} .aiq-progress-bar__percentage' => 'color: {{VALUE}}',
				),
				'condition' => array(
					'show_percentage' => 'yes',
				),
			)
		);

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			array(
				'name'      => 'percentage_typography',
				'selector'  => '{{WRAPPER}} .aiq-progress-bar__percentage',
				'condition' => array(
					'show_percentage' => 'yes',
				),
			)
		);

		$this->add_control(
			'percentage_padding',
			array(
				'label'      => esc_html__( 'Percentage Padding', 'aiqengage-child' ),
				'type'       => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} .aiq-progress-bar__percentage' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
				'condition'  => array(
					'show_percentage' => 'yes',
				),
			)
		);

		$this->add_control(
			'z_index',
			array(
				'label'     => esc_html__( 'Z-Index', 'aiqengage-child' ),
				'type'      => \Elementor\Controls_Manager::NUMBER,
				'default'   => 999,
				'min'       => 1,
				'max'       => 9999,
				'step'      => 1,
				'selectors' => array(
					'{{WRAPPER}} .aiq-progress-bar' => 'z-index: {{VALUE}};',
				),
				'condition' => array(
					'bar_position' => array( 'top', 'bottom' ),
				),
			)
		);

		$this->add_control(
			'fixed_position_offset',
			array(
				'label'      => esc_html__( 'Fixed Position Offset', 'aiqengage-child' ),
				'type'       => \Elementor\Controls_Manager::SLIDER,
				'size_units' => array( 'px' ),
				'range'      => array(
					'px' => array(
						'min'  => 0,
						'max'  => 100,
						'step' => 1,
					),
				),
				'default'    => array(
					'unit' => 'px',
					'size' => 0,
				),
				'selectors'  => array(
					'{{WRAPPER}} .aiq-progress-bar--top' => 'top: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .aiq-progress-bar--bottom' => 'bottom: {{SIZE}}{{UNIT}};',
				),
				'condition'  => array(
					'bar_position' => array( 'top', 'bottom' ),
				),
			)
		);

		$this->end_controls_section();
	}

	/**
	 * Check display conditions with enhanced logic.
	 */
	private function should_display() {
		$settings = $this->get_settings_for_display();

		if ( 'everywhere' === $settings['display_condition'] ) {
			return true;
		}

		if ( 'posts' === $settings['display_condition'] ) {
			return is_singular();
		}

		if ( 'custom' === $settings['display_condition'] && ! empty( $settings['custom_conditions'] ) ) {
			$conditions = array_filter( array_map( 'trim', explode( "\n", $settings['custom_conditions'] ) ) );
			foreach ( $conditions as $condition ) {
				if ( function_exists( $condition ) ) {
					if ( call_user_func( $condition ) ) {
						return true;
					}
				} elseif ( defined( $condition ) && constant( $condition ) ) {
					return true;
				}
			}
			return false;
		}

		return false;
	}

	/**
	 * Render widget output on the frontend with enhanced structure.
	 */
	protected function render() {
		if ( ! $this->should_display() ) {
			return;
		}

		$settings         = $this->get_settings_for_display();
		$position_class   = 'aiq-progress-bar--' . $settings['bar_position'];
		$percentage_class = 'aiq-progress-bar__percentage--' . ( $settings['percentage_position'] ?? 'end' );

		$this->add_render_attribute(
			'progress-bar',
			array(
				'class'                => array( 'aiq-progress-bar', $position_class ),
				'role'                 => 'progressbar',
				'aria-valuemin'        => '0',
				'aria-valuemax'        => '100',
				'aria-valuenow'        => '0',
				'data-animation-speed' => esc_attr( $settings['animation_speed'] ),
			)
		);

		if ( 'yes' === $settings['show_percentage'] ) {
			$this->add_render_attribute( 'progress-bar', 'class', 'aiq-progress-bar--has-percentage' );
		}
		?>
		<div <?php echo $this->get_render_attribute_string( 'progress-bar' ); ?>>
			<div class="aiq-progress-bar__container">
				<div class="aiq-progress-bar__indicator"></div>
			</div>
			<?php if ( 'yes' === $settings['show_percentage'] ) : ?>
				<div class="aiq-progress-bar__percentage <?php echo esc_attr( $percentage_class ); ?>">0%</div>
			<?php endif; ?>
		</div>
		<?php

		$this->enqueue_assets();
	}

	/**
	 * Enqueue required assets with dependency checks.
	 */
	private function enqueue_assets() {
		if ( ! wp_script_is( 'aiq-progress-bar', 'registered' ) ) {
			wp_register_script(
				'aiq-progress-bar',
				AIQENGAGE_CHILD_URL . '/assets/js/progress-bar.js',
				array( 'jquery', 'elementor-frontend' ),
				filemtime( get_stylesheet_directory() . '/assets/js/progress-bar.js' ),
				true
			);
		}

		if ( ! wp_style_is( 'aiq-progress-bar', 'registered' ) ) {
			wp_register_style(
				'aiq-progress-bar',
				AIQENGAGE_CHILD_URL . '/assets/css/progress-bar.css',
				array(),
				filemtime( get_stylesheet_directory() . '/assets/css/progress-bar.css' )
			);
		}

		wp_enqueue_script( 'aiq-progress-bar' );
		wp_enqueue_style( 'aiq-progress-bar' );
	}
}
