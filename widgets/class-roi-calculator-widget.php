<?php

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Core\Schemes\Color;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class AIQ_Roi_Calculator_Widget extends Widget_Base {

	public function get_name() {
		return 'roi-calculator';
	}

	public function get_title() {
		return __( 'Advanced ROI Calculator', 'aiqengage-child' );
	}

	public function get_icon() {
		return 'eicon-calculator';
	}

	public function get_categories() {
		return array( 'aiqengage' );
	}

	public function get_keywords() {
		return array( 'roi', 'calculator', 'finance', 'profit', 'investment' );
	}

	protected function register_controls() {
		$this->register_content_controls();
		$this->register_default_value_controls();
		$this->register_option_controls();
		$this->register_style_controls();
	}

	/**
	 * Register Content controls section.
	 */
	private function register_content_controls() {
		// Content Section
		$this->start_controls_section(
			'content_section',
			array(
				'label' => __( 'Content', 'aiqengage-child' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			)
		);

		$this->add_control(
			'headline',
			array(
				'label'       => __( 'Headline', 'aiqengage-child' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => __( 'AI Automation ROI Calculator', 'aiqengage-child' ),
				'label_block' => true,
			)
		);

		$this->add_control(
			'description',
			array(
				'label'   => __( 'Description', 'aiqengage-child' ),
				'type'    => Controls_Manager::TEXTAREA,
				'default' => __( 'Estimate your profit and breakeven for any automation or affiliate campaign.', 'aiqengage-child' ),
				'rows'    => 3,
			)
		);

		$this->end_controls_section();
	}

	/**
	 * Register Default Values controls section.
	 */
	private function register_default_value_controls() {
		// Input Defaults Section
		$this->start_controls_section(
			'defaults_section',
			array(
				'label' => __( 'Default Values', 'aiqengage-child' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			)
		);

		$this->add_control(
			'default_traffic',
			array(
				'label'   => __( 'Daily Traffic', 'aiqengage-child' ),
				'type'    => Controls_Manager::NUMBER,
				'min'     => 0,
				'default' => 100,
			)
		);

		$this->add_control(
			'default_conversion_rate',
			array(
				'label'   => __( 'Conversion Rate (%)', 'aiqengage-child' ),
				'type'    => Controls_Manager::NUMBER,
				'min'     => 0,
				'max'     => 100,
				'step'    => 0.1,
				'default' => 3.5,
			)
		);

		$this->add_control(
			'default_commission_rate',
			array(
				'label'   => __( 'Commission Rate (%)', 'aiqengage-child' ),
				'type'    => Controls_Manager::NUMBER,
				'min'     => 0,
				'max'     => 100,
				'step'    => 0.1,
				'default' => 30,
			)
		);

		$this->add_control(
			'default_product_price',
			array(
				'label'   => __( 'Product Price ($)', 'aiqengage-child' ),
				'type'    => Controls_Manager::NUMBER,
				'min'     => 0,
				'step'    => 0.01,
				'default' => 97,
			)
		);

		$this->add_control(
			'default_setup_cost',
			array(
				'label'   => __( 'Setup Cost ($)', 'aiqengage-child' ),
				'type'    => Controls_Manager::NUMBER,
				'min'     => 0,
				'step'    => 0.01,
				'default' => 500,
			)
		);

		$this->add_control(
			'default_monthly_cost',
			array(
				'label'   => __( 'Monthly Operating Cost ($)', 'aiqengage-child' ),
				'type'    => Controls_Manager::NUMBER,
				'min'     => 0,
				'step'    => 0.01,
				'default' => 150,
			)
		);

		$this->end_controls_section();
	}

	/**
	 * Register Calculator Options controls section.
	 */
	private function register_option_controls() {
		// Calculator Options Section
		$this->start_controls_section(
			'options_section',
			array(
				'label' => __( 'Calculator Options', 'aiqengage-child' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			)
		);

		$this->add_control(
			'show_advanced_fields',
			array(
				'label'        => __( 'Show Advanced Fields', 'aiqengage-child' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => __( 'Show', 'aiqengage-child' ),
				'label_off'    => __( 'Hide', 'aiqengage-child' ),
				'return_value' => 'yes',
				'default'      => 'no',
			)
		);

		$this->add_control(
			'enable_csv_export',
			array(
				'label'        => __( 'Enable CSV Export', 'aiqengage-child' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => __( 'Enable', 'aiqengage-child' ),
				'label_off'    => __( 'Disable', 'aiqengage-child' ),
				'return_value' => 'yes',
				'default'      => 'yes',
			)
		);

		$this->add_control(
			'enable_projections',
			array(
				'label'        => __( 'Enable Projections Chart', 'aiqengage-child' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => __( 'Enable', 'aiqengage-child' ),
				'label_off'    => __( 'Disable', 'aiqengage-child' ),
				'return_value' => 'yes',
				'default'      => 'yes',
			)
		);

		$this->add_control(
			'projection_months',
			array(
				'label'     => __( 'Projection Period (Months)', 'aiqengage-child' ),
				'type'      => Controls_Manager::NUMBER,
				'min'       => 1,
				'max'       => 24,
				'default'   => 12,
				'condition' => array(
					'enable_projections' => 'yes',
				),
			)
		);

		$this->add_control(
			'currency_symbol',
			array(
				'label'   => __( 'Currency Symbol', 'aiqengage-child' ),
				'type'    => Controls_Manager::TEXT,
				'default' => '$',
			)
		);

		$this->end_controls_section();
	}

	/**
	 * Register Style controls section.
	 */
	private function register_style_controls() {
		// Style Section
		$this->start_controls_section(
			'style_section',
			array(
				'label' => __( 'Style', 'aiqengage-child' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_control(
			'background_color',
			array(
				'label'     => __( 'Background Color', 'aiqengage-child' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#2A1958',
				'selectors' => array(
					'{{WRAPPER}} .aiq-roi-calculator' => 'background-color: {{VALUE}};',
				),
			)
		);

		$this->add_control(
			'border_color',
			array(
				'label'     => __( 'Border Color', 'aiqengage-child' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => 'rgba(156, 77, 255, 0.3)',
				'selectors' => array(
					'{{WRAPPER}} .aiq-roi-calculator' => 'border-color: {{VALUE}};',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'     => 'title_typography',
				'label'    => __( 'Title Typography', 'aiqengage-child' ),
				'selector' => '{{WRAPPER}} .aiq-roi-calculator__title',
			)
		);

		$this->add_control(
			'title_color',
			array(
				'label'     => __( 'Title Color', 'aiqengage-child' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#E0D6FF',
				'selectors' => array(
					'{{WRAPPER}} .aiq-roi-calculator__title' => 'color: {{VALUE}};',
				),
			)
		);

		$this->add_control(
			'input_background',
			array(
				'label'     => __( 'Input Background', 'aiqengage-child' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => 'rgba(26, 9, 56, 0.6)',
				'selectors' => array(
					'{{WRAPPER}} .aiq-roi-input' => 'background-color: {{VALUE}};',
				),
			)
		);

		$this->add_control(
			'input_border_color',
			array(
				'label'     => __( 'Input Border Color', 'aiqengage-child' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => 'rgba(156, 77, 255, 0.3)',
				'selectors' => array(
					'{{WRAPPER}} .aiq-roi-input' => 'border-color: {{VALUE}};',
				),
			)
		);

		$this->add_control(
			'input_text_color',
			array(
				'label'     => __( 'Input Text Color', 'aiqengage-child' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#E0D6FF',
				'selectors' => array(
					'{{WRAPPER}} .aiq-roi-input' => 'color: {{VALUE}};',
				),
			)
		);

		$this->add_control(
			'button_background',
			array(
				'label'     => __( 'Button Background', 'aiqengage-child' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#9C4DFF',
				'selectors' => array(
					'{{WRAPPER}} .aiq-roi-calculator__button' => 'background-color: {{VALUE}};',
				),
			)
		);

		$this->add_control(
			'button_text_color',
			array(
				'label'     => __( 'Button Text Color', 'aiqengage-child' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#FFFFFF',
				'selectors' => array(
					'{{WRAPPER}} .aiq-roi-calculator__button' => 'color: {{VALUE}};',
				),
			)
		);

		$this->add_control(
			'result_background',
			array(
				'label'     => __( 'Results Background', 'aiqengage-child' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => 'rgba(156, 77, 255, 0.1)',
				'selectors' => array(
					'{{WRAPPER}} .aiq-roi-result-card' => 'background-color: {{VALUE}};',
				),
			)
		);

		$this->add_control(
			'result_text_color',
			array(
				'label'     => __( 'Results Text Color', 'aiqengage-child' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#E0D6FF',
				'selectors' => array(
					'{{WRAPPER}} .aiq-roi-result-card' => 'color: {{VALUE}};',
				),
			)
		);

		$this->end_controls_section();
	}

	protected function render() {
		$settings  = $this->get_settings_for_display();
		$widget_id = 'aiq-roi-calc-' . $this->get_id();
		?>
		<section class="aiq-roi-calculator" id="<?php echo esc_attr( $widget_id ); ?>" data-widget-id="<?php echo esc_attr( $this->get_id() ); ?>">
			<div class="aiq-roi-calculator__container">
				<header class="aiq-roi-calculator__header">
					<h3 class="aiq-roi-calculator__title"><?php echo esc_html( $settings['headline'] ); ?></h3>
					<?php if ( $settings['description'] ) : ?>
						<div class="aiq-roi-calculator__desc"><?php echo esc_html( $settings['description'] ); ?></div>
					<?php endif; ?>
				</header>

				<form class="aiq-roi-calculator__form" autocomplete="off" novalidate>
					<div class="aiq-roi-calculator__input-grid">
						<?php
						$this->render_input_field(
							'traffic',
							__( 'Daily Traffic', 'aiqengage-child' ),
							'number',
							array(
								'min'   => 0,
								'step'  => 1,
								'value' => $settings['default_traffic'],
							)
						);
						?>

						<?php
						$this->render_input_field(
							'conversion',
							__( 'Conversion Rate (%)', 'aiqengage-child' ),
							'number',
							array(
								'min'   => 0,
								'max'   => 100,
								'step'  => 0.1,
								'value' => $settings['default_conversion_rate'],
							)
						);
						?>

						<?php
						$this->render_input_field(
							'commission',
							__( 'Commission Rate (%)', 'aiqengage-child' ),
							'number',
							array(
								'min'   => 0,
								'max'   => 100,
								'step'  => 0.1,
								'value' => $settings['default_commission_rate'],
							)
						);
						?>

						<?php
						$this->render_input_field(
							'price',
							__( 'Product Price (' . esc_html( $settings['currency_symbol'] ) . ')', 'aiqengage-child' ),
							'number',
							array(
								'min'   => 0,
								'step'  => 0.01,
								'value' => $settings['default_product_price'],
							)
						);
						?>

						<?php
						$this->render_input_field(
							'setup_cost',
							__( 'Setup Cost (' . esc_html( $settings['currency_symbol'] ) . ')', 'aiqengage-child' ),
							'number',
							array(
								'min'   => 0,
								'step'  => 0.01,
								'value' => $settings['default_setup_cost'],
							)
						);
						?>

						<?php
						$this->render_input_field(
							'monthly_cost',
							__( 'Monthly Cost (' . esc_html( $settings['currency_symbol'] ) . ')', 'aiqengage-child' ),
							'number',
							array(
								'min'   => 0,
								'step'  => 0.01,
								'value' => $settings['default_monthly_cost'],
							)
						);
						?>

						<?php if ( 'yes' === $settings['show_advanced_fields'] ) : ?>
							<?php
							$this->render_input_field(
								'growth_rate',
								__( 'Monthly Growth Rate (%)', 'aiqengage-child' ),
								'number',
								array(
									'min'   => -50,
									'max'   => 100,
									'step'  => 0.1,
									'value' => 5,
								)
							);
							?>

							<?php
							$this->render_input_field(
								'churn_rate',
								__( 'Monthly Churn Rate (%)', 'aiqengage-child' ),
								'number',
								array(
									'min'   => 0,
									'max'   => 100,
									'step'  => 0.1,
									'value' => 2,
								)
							);
							?>
						<?php endif; ?>
					</div>

					<div class="aiq-roi-calculator__actions">
						<button type="submit" class="aiq-roi-calculator__button">
							<?php esc_html_e( 'Calculate ROI', 'aiqengage-child' ); ?>
						</button>
						<button type="reset" class="aiq-roi-calculator__reset">
							<?php esc_html_e( 'Reset', 'aiqengage-child' ); ?>
						</button>
						<?php if ( 'yes' === $settings['enable_csv_export'] ) : ?>
							<button type="button" class="aiq-roi-calculator__export" disabled>
								<?php esc_html_e( 'Export CSV', 'aiqengage-child' ); ?>
							</button>
						<?php endif; ?>
					</div>
				</form>

				<output class="aiq-roi-calculator__results" aria-live="polite">
					<div class="aiq-roi-result-card">
						<h4><?php esc_html_e( 'Projected Results', 'aiqengage-child' ); ?></h4>
						<div class="aiq-roi-result-grid">
							<div class="aiq-roi-result-item">
								<span class="aiq-roi-result-label"><?php esc_html_e( 'Monthly Revenue:', 'aiqengage-child' ); ?></span>
								<span class="aiq-roi-result-value" data-result="monthly"><?php echo esc_html( $settings['currency_symbol'] ); ?>0</span>
							</div>
							<div class="aiq-roi-result-item">
								<span class="aiq-roi-result-label"><?php esc_html_e( 'Annual Revenue:', 'aiqengage-child' ); ?></span>
								<span class="aiq-roi-result-value" data-result="annual"><?php echo esc_html( $settings['currency_symbol'] ); ?>0</span>
							</div>
							<div class="aiq-roi-result-item">
								<span class="aiq-roi-result-label"><?php esc_html_e( 'ROI Percentage:', 'aiqengage-child' ); ?></span>
								<span class="aiq-roi-result-value" data-result="roi">0%</span>
							</div>
							<div class="aiq-roi-result-item">
								<span class="aiq-roi-result-label"><?php esc_html_e( 'Breakeven Time:', 'aiqengage-child' ); ?></span>
								<span class="aiq-roi-result-value" data-result="breakeven">-</span>
							</div>
							<div class="aiq-roi-result-item">
								<span class="aiq-roi-result-label"><?php esc_html_e( 'Net Profit (Year 1):', 'aiqengage-child' ); ?></span>
								<span class="aiq-roi-result-value" data-result="profit"><?php echo esc_html( $settings['currency_symbol'] ); ?>0</span>
							</div>
							<div class="aiq-roi-result-item">
								<span class="aiq-roi-result-label"><?php esc_html_e( 'Total Investment:', 'aiqengage-child' ); ?></span>
								<span class="aiq-roi-result-value" data-result="investment"><?php echo esc_html( $settings['currency_symbol'] ); ?>0</span>
							</div>
						</div>
					</div>

					<?php if ( 'yes' === $settings['enable_projections'] ) : ?>
						<div class="aiq-roi-projections">
							<h4><?php printf( __( '%d-Month Projections', 'aiqengage-child' ), $settings['projection_months'] ); ?></h4>
							<canvas id="aiq-roi-chart-<?php echo esc_attr( $this->get_id() ); ?>" width="400" height="200"></canvas>
						</div>
					<?php endif; ?>
				</output>
			</div>
		</section>
		<?php
	}

	protected function render_input_field( $name, $label, $type = 'number', $attrs = array() ) {
		?>
		<div class="aiq-roi-input-group">
			<label>
				<span class="aiq-roi-input-label"><?php echo esc_html( $label ); ?></span>
				<input
					type="<?php echo esc_attr( $type ); ?>"
					name="<?php echo esc_attr( $name ); ?>"
					<?php
					foreach ( $attrs as $attr => $value ) {
						printf( '%s="%s" ', esc_attr( $attr ), esc_attr( $value ) );
					}
					?>
					class="aiq-roi-input"
				>
				<?php if ( isset( $attrs['description'] ) ) : ?>
					<span class="aiq-roi-input-description"><?php echo esc_html( $attrs['description'] ); ?></span>
				<?php endif; ?>
			</label>
		</div>
		<?php
	}

	public function get_style_depends() {
		return array( 'aiq-roi-calculator' );
	}

	public function get_script_depends() {
		return array( 'aiq-roi-calculator', 'aiq-utils' );
	}
}
