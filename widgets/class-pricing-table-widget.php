<?php
/**
 * Pricing Table Widget for Elementor
 *
 * @package aiqengage-child
 * @version 1.0.0
 * @since   1.0.0
 * @author  Jason
 */
namespace AIQEngage\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Repeater;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Border;
use Elementor\Core\Schemes\Color;
use Elementor\Core\Schemes\Typography;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Pricing_Table_Widget extends Widget_Base {

	public function get_name() {
		return 'aiq-pricing-table';
	}

	public function get_title() {
		return esc_html__( 'AIQ Advanced Pricing', 'aiqengage-child' );
	}

	public function get_icon() {
		return 'eicon-price-table';
	}

	public function get_categories() {
		return array( 'aiqengage' );
	}

	/**
	 * Get widget style dependencies.
	 *
	 * @return string[] CSS handles.
	 */
	public function get_style_depends() {
		return array( 'aiq-pricing-table' );
	}

	/**
	 * Get widget script dependencies.
	 *
	 * @return string[] JS handles.
	 */
	public function get_script_depends() {
		return array( 'aiq-pricing-table' );
	}

	public function get_keywords() {
		return array( 'pricing', 'plans', 'comparison', 'subscription', 'offer' );
	}

	protected function register_controls() {
		$this->start_controls_section(
			'section_content',
			array(
				'label' => __( 'Pricing Plans', 'aiqengage-child' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			)
		);

		// Toggle Switch
		$this->add_control(
			'enable_toggle',
			array(
				'label'              => __( 'Enable Plan Toggle', 'aiqengage-child' ),
				'type'               => Controls_Manager::SWITCHER,
				'label_on'           => __( 'Yes', 'aiqengage-child' ),
				'label_off'          => __( 'No', 'aiqengage-child' ),
				'default'            => 'yes',
				'frontend_available' => true,
			)
		);

		$this->add_control(
			'toggle_style',
			array(
				'label'     => __( 'Toggle Style', 'aiqengage-child' ),
				'type'      => Controls_Manager::SELECT,
				'default'   => 'switch',
				'options'   => array(
					'switch'    => __( 'Switch', 'aiqengage-child' ),
					'segmented' => __( 'Segmented', 'aiqengage-child' ),
					'dropdown'  => __( 'Dropdown', 'aiqengage-child' ),
				),
				'condition' => array(
					'enable_toggle' => 'yes',
				),
			)
		);

		$this->add_control(
			'toggle_labels',
			array(
				'label'       => __( 'Toggle Labels', 'aiqengage-child' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => __( 'Monthly|Annual', 'aiqengage-child' ),
				'description' => __( 'Separate with | character', 'aiqengage-child' ),
				'condition'   => array(
					'enable_toggle' => 'yes',
				),
			)
		);

		// Plans Repeater
		$repeater = new Repeater();

		$repeater->add_control(
			'plan_name',
			array(
				'label'       => __( 'Plan Name', 'aiqengage-child' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => __( 'Professional', 'aiqengage-child' ),
				'label_block' => true,
			)
		);

		$repeater->add_control(
			'is_featured',
			array(
				'label'     => __( 'Featured Plan', 'aiqengage-child' ),
				'type'      => Controls_Manager::SWITCHER,
				'label_on'  => __( 'Yes', 'aiqengage-child' ),
				'label_off' => __( 'No', 'aiqengage-child' ),
				'default'   => '',
			)
		);

		$repeater->add_control(
			'featured_badge',
			array(
				'label'     => __( 'Featured Badge', 'aiqengage-child' ),
				'type'      => Controls_Manager::TEXT,
				'default'   => __( 'Most Popular', 'aiqengage-child' ),
				'condition' => array(
					'is_featured' => 'yes',
				),
			)
		);

		// Pricing Options
		$repeater->add_control(
			'price_monthly',
			array(
				'label'       => __( 'Monthly Price', 'aiqengage-child' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => '$49',
				'description' => __( 'Enter price with currency symbol', 'aiqengage-child' ),
			)
		);

		$repeater->add_control(
			'price_yearly',
			array(
				'label'       => __( 'Yearly Price', 'aiqengage-child' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => '$399',
				'description' => __( 'Enter price with currency symbol', 'aiqengage-child' ),
			)
		);

		$repeater->add_control(
			'billing_note',
			array(
				'label'       => __( 'Billing Note', 'aiqengage-child' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => __( 'billed monthly', 'aiqengage-child' ),
				'placeholder' => __( 'e.g. billed annually', 'aiqengage-child' ),
			)
		);

		$repeater->add_control(
			'savings_badge',
			array(
				'label'       => __( 'Savings Badge', 'aiqengage-child' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => __( 'Save 30%', 'aiqengage-child' ),
				'placeholder' => __( 'e.g. Save 20%', 'aiqengage-child' ),
			)
		);

		// Features
		$repeater->add_control(
			'features',
			array(
				'label'       => __( 'Features List', 'aiqengage-child' ),
				'type'        => Controls_Manager::TEXTAREA,
				'default'     => implode(
					"\n",
					array(
						__( '50+ AI Prompts', 'aiqengage-child' ),
						__( 'Weekly Updates', 'aiqengage-child' ),
						__( 'Priority Support', 'aiqengage-child' ),
						__( 'Community Access', 'aiqengage-child' ),
					)
				),
				'description' => __( 'One feature per line', 'aiqengage-child' ),
				'rows'        => 5,
			)
		);

		// CTA Button
		$repeater->add_control(
			'cta_text',
			array(
				'label'   => __( 'Button Text', 'aiqengage-child' ),
				'type'    => Controls_Manager::TEXT,
				'default' => __( 'Get Started', 'aiqengage-child' ),
			)
		);

		$repeater->add_control(
			'cta_link',
			array(
				'label'   => __( 'Button Link', 'aiqengage-child' ),
				'type'    => Controls_Manager::URL,
				'default' => array(
					'url'         => '#',
					'is_external' => false,
					'nofollow'    => false,
				),
			)
		);

		$repeater->add_control(
			'plan_color',
			array(
				'label'     => __( 'Accent Color', 'aiqengage-child' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#7c3aed',
				'selectors' => array(
					'{{WRAPPER}} {{CURRENT_ITEM}}' => '--plan-accent: {{VALUE}};',
				),
			)
		);

		$this->add_control(
			'plans',
			array(
				'label'       => __( 'Pricing Plans', 'aiqengage-child' ),
				'type'        => Controls_Manager::REPEATER,
				'fields'      => $repeater->get_controls(),
				'default'     => array(
					array(
						'plan_name'     => __( 'Starter', 'aiqengage-child' ),
						'price_monthly' => '$29',
						'price_yearly'  => '$249',
						'savings_badge' => __( 'Save 15%', 'aiqengage-child' ),
						'features'      => implode(
							"\n",
							array(
								__( '25+ Basic Prompts', 'aiqengage-child' ),
								__( 'Monthly Updates', 'aiqengage-child' ),
								__( 'Email Support', 'aiqengage-child' ),
							)
						),
						'cta_text'      => __( 'Start Free Trial', 'aiqengage-child' ),
					),
					array(
						'plan_name'      => __( 'Professional', 'aiqengage-child' ),
						'is_featured'    => 'yes',
						'featured_badge' => __( 'Most Popular', 'aiqengage-child' ),
						'price_monthly'  => '$49',
						'price_yearly'   => '$399',
						'savings_badge'  => __( 'Save 30%', 'aiqengage-child' ),
						'features'       => implode(
							"\n",
							array(
								__( '50+ Conversion Prompts', 'aiqengage-child' ),
								__( 'Weekly Updates', 'aiqengage-child' ),
								__( 'Priority Support', 'aiqengage-child' ),
								__( 'Community Access', 'aiqengage-child' ),
							)
						),
						'cta_text'       => __( 'Get Professional', 'aiqengage-child' ),
						'plan_color'     => '#9c4dff',
					),
					array(
						'plan_name'     => __( 'Agency', 'aiqengage-child' ),
						'price_monthly' => '$99',
						'price_yearly'  => '$799',
						'savings_badge' => __( 'Save 35%', 'aiqengage-child' ),
						'features'      => implode(
							"\n",
							array(
								__( '100+ Advanced Prompts', 'aiqengage-child' ),
								__( 'Daily Updates', 'aiqengage-child' ),
								__( '24/7 Support', 'aiqengage-child' ),
								__( 'White Label Rights', 'aiqengage-child' ),
								__( 'Custom Prompt Service', 'aiqengage-child' ),
							)
						),
						'cta_text'      => __( 'Contact Sales', 'aiqengage-child' ),
					),
				),
				'title_field' => '{{{ plan_name }}}',
			)
		);

		$this->add_control(
			'columns',
			array(
				'label'   => __( 'Columns', 'aiqengage-child' ),
				'type'    => Controls_Manager::SELECT,
				'default' => '3',
				'options' => array(
					'2' => __( '2 Columns', 'aiqengage-child' ),
					'3' => __( '3 Columns', 'aiqengage-child' ),
					'4' => __( '4 Columns', 'aiqengage-child' ),
				),
			)
		);

		$this->end_controls_section();

		// Style Tab
		$this->start_controls_section(
			'section_style_general',
			array(
				'label' => __( 'General', 'aiqengage-child' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_control(
			'layout',
			array(
				'label'        => __( 'Layout', 'aiqengage-child' ),
				'type'         => Controls_Manager::SELECT,
				'default'      => 'cards',
				'options'      => array(
					'cards' => __( 'Cards', 'aiqengage-child' ),
					'table' => __( 'Table', 'aiqengage-child' ),
				),
				'prefix_class' => 'aiq-pricing-layout-',
			)
		);

		$this->add_responsive_control(
			'spacing',
			array(
				'label'     => __( 'Spacing', 'aiqengage-child' ),
				'type'      => Controls_Manager::SLIDER,
				'range'     => array(
					'px' => array(
						'min' => 0,
						'max' => 100,
					),
				),
				'default'   => array(
					'size' => 30,
				),
				'selectors' => array(
					'{{WRAPPER}} .aiq-pricing-plan' => 'margin-bottom: {{SIZE}}{{UNIT}};',
				),
			)
		);

		$this->end_controls_section();

		// Toggle Style
		$this->start_controls_section(
			'section_style_toggle',
			array(
				'label'     => __( 'Toggle', 'aiqengage-child' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => array(
					'enable_toggle' => 'yes',
				),
			)
		);

		$this->add_control(
			'toggle_alignment',
			array(
				'label'     => __( 'Alignment', 'aiqengage-child' ),
				'type'      => Controls_Manager::CHOOSE,
				'options'   => array(
					'left'   => array(
						'title' => __( 'Left', 'aiqengage-child' ),
						'icon'  => 'eicon-text-align-left',
					),
					'center' => array(
						'title' => __( 'Center', 'aiqengage-child' ),
						'icon'  => 'eicon-text-align-center',
					),
					'right'  => array(
						'title' => __( 'Right', 'aiqengage-child' ),
						'icon'  => 'eicon-text-align-right',
					),
				),
				'default'   => 'center',
				'selectors' => array(
					'{{WRAPPER}} .aiq-pricing-toggle' => 'text-align: {{VALUE}};',
				),
			)
		);

		$this->end_controls_section();

		// Plan Style
		$this->start_controls_section(
			'section_style_plan',
			array(
				'label' => __( 'Plan', 'aiqengage-child' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			array(
				'name'     => 'plan_border',
				'selector' => '{{WRAPPER}} .aiq-pricing-plan',
			)
		);

		$this->add_control(
			'plan_border_radius',
			array(
				'label'      => __( 'Border Radius', 'aiqengage-child' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} .aiq-pricing-plan' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			array(
				'name'     => 'plan_box_shadow',
				'selector' => '{{WRAPPER}} .aiq-pricing-plan',
			)
		);

		$this->end_controls_section();

		// Header Style
		$this->start_controls_section(
			'section_style_header',
			array(
				'label' => __( 'Header', 'aiqengage-child' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_control(
			'header_bg_color',
			array(
				'label'     => __( 'Background Color', 'aiqengage-child' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .aiq-pricing-header' => 'background-color: {{VALUE}};',
				),
			)
		);

		$this->add_control(
			'featured_header_bg_color',
			array(
				'label'     => __( 'Featured Background', 'aiqengage-child' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .aiq-pricing-plan.featured .aiq-pricing-header' => 'background-color: {{VALUE}};',
				),
			)
		);

		$this->end_controls_section();

		// Price Style
		$this->start_controls_section(
			'section_style_price',
			array(
				'label' => __( 'Price', 'aiqengage-child' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_control(
			'price_color',
			array(
				'label'     => __( 'Color', 'aiqengage-child' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .aiq-pricing-price' => 'color: {{VALUE}};',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'     => 'price_typography',
				'selector' => '{{WRAPPER}} .aiq-pricing-price',
				'scheme'   => Typography::TYPOGRAPHY_1,
			)
		);

		$this->end_controls_section();

		// Features Style
		$this->start_controls_section(
			'section_style_features',
			array(
				'label' => __( 'Features', 'aiqengage-child' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_control(
			'features_list_color',
			array(
				'label'     => __( 'Color', 'aiqengage-child' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .aiq-pricing-features li' => 'color: {{VALUE}};',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'     => 'features_typography',
				'selector' => '{{WRAPPER}} .aiq-pricing-features li',
				'scheme'   => Typography::TYPOGRAPHY_3,
			)
		);

		$this->end_controls_section();

		// Button Style
		$this->start_controls_section(
			'section_style_button',
			array(
				'label' => __( 'Button', 'aiqengage-child' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'     => 'button_typography',
				'selector' => '{{WRAPPER}} .aiq-pricing-cta',
				'scheme'   => Typography::TYPOGRAPHY_4,
			)
		);

		$this->add_control(
			'button_border_radius',
			array(
				'label'      => __( 'Border Radius', 'aiqengage-child' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} .aiq-pricing-cta' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->end_controls_section();

		// Badge Style
		$this->start_controls_section(
			'section_style_badge',
			array(
				'label' => __( 'Badges', 'aiqengage-child' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_control(
			'featured_badge_style',
			array(
				'label' => __( 'Featured Badge', 'aiqengage-child' ),
				'type'  => Controls_Manager::HEADING,
			)
		);

		$this->add_control(
			'featured_badge_bg_color',
			array(
				'label'     => __( 'Background Color', 'aiqengage-child' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .aiq-featured-badge' => 'background-color: {{VALUE}};',
				),
			)
		);

		$this->add_control(
			'savings_badge_style',
			array(
				'label'     => __( 'Savings Badge', 'aiqengage-child' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			)
		);

		$this->end_controls_section();
	}

	protected function render() {
		$settings      = $this->get_settings_for_display();
		$toggle_labels = explode( '|', $settings['toggle_labels'] );
		$toggle_left   = isset( $toggle_labels[0] ) ? $toggle_labels[0] : __( 'Monthly', 'aiqengage-child' );
		$toggle_right  = isset( $toggle_labels[1] ) ? $toggle_labels[1] : __( 'Annual', 'aiqengage-child' );
		$columns       = $settings['columns'];
		?>

		<div class="aiq-pricing-table aiq-pricing-columns-<?php echo esc_attr( $columns ); ?>">

			<?php if ( $settings['enable_toggle'] ) : ?>
			<div class="aiq-pricing-toggle aiq-toggle-style-<?php echo esc_attr( $settings['toggle_style'] ); ?>">
				<?php if ( $settings['toggle_style'] === 'segmented' ) : ?>
					<div class="aiq-toggle-segments">
						<button type="button" class="aiq-toggle-segment active" data-period="monthly"><?php echo esc_html( $toggle_left ); ?></button>
						<button type="button" class="aiq-toggle-segment" data-period="yearly"><?php echo esc_html( $toggle_right ); ?></button>
					</div>
				<?php elseif ( $settings['toggle_style'] === 'dropdown' ) : ?>
					<select class="aiq-toggle-dropdown">
						<option value="monthly"><?php echo esc_html( $toggle_left ); ?></option>
						<option value="yearly"><?php echo esc_html( $toggle_right ); ?></option>
					</select>
				<?php else : ?>
					<div class="aiq-toggle-switch">
						<span class="aiq-toggle-label active"><?php echo esc_html( $toggle_left ); ?></span>
						<label class="aiq-switch">
							<input type="checkbox" class="aiq-toggle-input">
							<span class="aiq-slider"></span>
						</label>
						<span class="aiq-toggle-label"><?php echo esc_html( $toggle_right ); ?></span>
					</div>
				<?php endif; ?>
			</div>
			<?php endif; ?>

			<div class="aiq-pricing-plans">
				<?php
				foreach ( $settings['plans'] as $index => $plan ) :
					$featured_class = $plan['is_featured'] ? ' featured' : '';
					$item_class     = 'elementor-repeater-item-' . $plan['_id'] . $featured_class;
					$features       = explode( "\n", $plan['features'] );

					// Badges
					$featured_badge = $plan['is_featured'] && ! empty( $plan['featured_badge'] ) ?
						'<div class="aiq-featured-badge">' . esc_html( $plan['featured_badge'] ) . '</div>' : '';

					$savings_badge = ! empty( $plan['savings_badge'] ) ?
						'<div class="aiq-savings-badge">' . esc_html( $plan['savings_badge'] ) . '</div>' : '';

					// CTA Link
					$target   = $plan['cta_link']['is_external'] ? ' target="_blank"' : '';
					$nofollow = $plan['cta_link']['nofollow'] ? ' rel="nofollow"' : '';
					$url      = $plan['cta_link']['url'] ? $plan['cta_link']['url'] : '#';
					?>
				<div class="aiq-pricing-plan <?php echo esc_attr( $item_class ); ?>">
					<?php echo $featured_badge; ?>

					<div class="aiq-pricing-header">
						<h3 class="aiq-pricing-title"><?php echo esc_html( $plan['plan_name'] ); ?></h3>
					</div>

					<div class="aiq-pricing-price-container">
						<div class="aiq-pricing-price monthly-price">
							<span class="aiq-price-amount"><?php echo esc_html( $plan['price_monthly'] ); ?></span>
							<?php if ( ! empty( $plan['billing_note'] ) ) : ?>
							<span class="aiq-billing-note"><?php echo esc_html( $plan['billing_note'] ); ?></span>
							<?php endif; ?>
						</div>

						<?php if ( $settings['enable_toggle'] ) : ?>
						<div class="aiq-pricing-price yearly-price" style="display: none;">
							<span class="aiq-price-amount"><?php echo esc_html( $plan['price_yearly'] ); ?></span>
							<?php echo $savings_badge; ?>
							<?php if ( ! empty( $plan['billing_note'] ) ) : ?>
							<span class="aiq-billing-note"><?php echo esc_html( $plan['billing_note'] ); ?></span>
							<?php endif; ?>
						</div>
						<?php endif; ?>
					</div>

					<?php if ( ! empty( $features ) ) : ?>
					<ul class="aiq-pricing-features">
						<?php foreach ( $features as $feature ) : ?>
						<li><?php echo esc_html( trim( $feature ) ); ?></li>
						<?php endforeach; ?>
					</ul>
					<?php endif; ?>

					<a href="<?php echo esc_url( $url ); ?>" class="aiq-pricing-cta"<?php echo $target . $nofollow; ?>>
						<?php echo esc_html( $plan['cta_text'] ); ?>
					</a>
				</div>
				<?php endforeach; ?>
			</div>
		</div>
		<?php
	}
}
