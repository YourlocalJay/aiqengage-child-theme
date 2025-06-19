// widgets/class-comparison-matrix-widget.php

<?php
/**
 * Comparison Matrix Widget for AIQEngage.
 *
 * @package aiqengage-child
 * @version 1.0.0
 * @since 1.0.0
 * @author Jason
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Comparison Matrix Widget.
 *
 * An interactive comparison table for tools, plans, and features.
 *
 * @since 1.0.0
 */
class AIQ_Comparison_Matrix_Widget extends \Elementor\Widget_Base {

	/**
	 * Get widget name.
	 *
	 * @since 1.0.0
	 * @access public
	 * @return string Widget name.
	 */
	public function get_name() {
		return 'aiq_comparison_matrix';
	}

	/**
	 * Get widget title.
	 *
	 * @since 1.0.0
	 * @access public
	 * @return string Widget title.
	 */
	public function get_title() {
		return esc_html__( 'Comparison Matrix', 'aiqengage-child' );
	}

	/**
	 * Get widget icon.
	 *
	 * @since 1.0.0
	 * @access public
	 * @return string Widget icon.
	 */
	public function get_icon() {
		return 'eicon-table';
	}

	/**
	 * Get widget keywords.
	 *
	 * @since 1.0.0
	 * @access public
	 * @return array Widget keywords.
	 */
	public function get_keywords() {
		return array( 'comparison', 'matrix', 'table', 'features', 'tools', 'plans' );
	}

	/**
	 * Get widget categories.
	 *
	 * @since 1.0.0
	 * @access public
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
		return array( 'aiqengage-child-comparison-matrix' );
	}

	/**
	 * Get widget script dependencies.
	 *
	 * @return string[] JS handles.
	 */
	public function get_script_depends() {
		return array( 'aiqengage-child-comparison-matrix' );
	}

	/**
	 * Register widget controls.
	 *
	 * @since 1.0.0
	 * @access protected
	 */
	protected function register_controls() {

		$this->start_controls_section(
			'section_columns',
			array(
				'label' => esc_html__( 'Columns (Tools/Plans)', 'aiqengage-child' ),
				'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
			)
		);

		$repeater_columns = new \Elementor\Repeater();

		$repeater_columns->add_control(
			'column_name',
			array(
				'label'       => esc_html__( 'Name', 'aiqengage-child' ),
				'type'        => \Elementor\Controls_Manager::TEXT,
				'default'     => esc_html__( 'Tool Name', 'aiqengage-child' ),
				'label_block' => true,
			)
		);

		$repeater_columns->add_control(
			'column_logo',
			array(
				'label'   => esc_html__( 'Logo', 'aiqengage-child' ),
				'type'    => \Elementor\Controls_Manager::MEDIA,
				'default' => array(
					'url' => \Elementor\Utils::get_placeholder_image_src(),
				),
			)
		);

		$repeater_columns->add_control(
			'column_accent_color',
			array(
				'label'   => esc_html__( 'Accent Color', 'aiqengage-child' ),
				'type'    => \Elementor\Controls_Manager::COLOR,
				'default' => '#9C4DFF',
			)
		);

		$repeater_columns->add_control(
			'column_badge',
			array(
				'label'       => esc_html__( 'Badge Text', 'aiqengage-child' ),
				'type'        => \Elementor\Controls_Manager::TEXT,
				'default'     => '',
				'placeholder' => esc_html__( 'e.g. Recommended', 'aiqengage-child' ),
			)
		);

		$repeater_columns->add_control(
			'column_badge_color',
			array(
				'label'     => esc_html__( 'Badge Color', 'aiqengage-child' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '#FFD700',
				'condition' => array(
					'column_badge!' => '',
				),
			)
		);

		$repeater_columns->add_control(
			'column_description',
			array(
				'label'   => esc_html__( 'Short Description', 'aiqengage-child' ),
				'type'    => \Elementor\Controls_Manager::TEXTAREA,
				'rows'    => 3,
				'default' => '',
			)
		);

		$repeater_columns->add_control(
			'column_cta_text',
			array(
				'label'   => esc_html__( 'CTA Text', 'aiqengage-child' ),
				'type'    => \Elementor\Controls_Manager::TEXT,
				'default' => esc_html__( 'Learn More', 'aiqengage-child' ),
			)
		);

		$repeater_columns->add_control(
			'column_cta_url',
			array(
				'label'       => esc_html__( 'CTA URL', 'aiqengage-child' ),
				'type'        => \Elementor\Controls_Manager::URL,
				'placeholder' => esc_html__( 'https://your-link.com', 'aiqengage-child' ),
				'default'     => array(
					'url' => '#',
				),
			)
		);

		$this->add_control(
			'columns',
			array(
				'label'       => esc_html__( 'Columns', 'aiqengage-child' ),
				'type'        => \Elementor\Controls_Manager::REPEATER,
				'fields'      => $repeater_columns->get_controls(),
				'default'     => array(
					array(
						'column_name'         => esc_html__( 'Tool A', 'aiqengage-child' ),
						'column_accent_color' => '#9C4DFF',
					),
					array(
						'column_name'         => esc_html__( 'Tool B', 'aiqengage-child' ),
						'column_accent_color' => '#5E72E4',
					),
					array(
						'column_name'         => esc_html__( 'Tool C', 'aiqengage-child' ),
						'column_accent_color' => '#635BFF',
					),
				),
				'title_field' => '{{{ column_name }}}',
			)
		);

		$this->add_control(
			'sticky_header',
			array(
				'label'        => esc_html__( 'Sticky Header', 'aiqengage-child' ),
				'type'         => \Elementor\Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Yes', 'aiqengage-child' ),
				'label_off'    => esc_html__( 'No', 'aiqengage-child' ),
				'return_value' => 'yes',
				'default'      => 'yes',
			)
		);

		$this->add_control(
			'sticky_first_column',
			array(
				'label'        => esc_html__( 'Sticky First Column', 'aiqengage-child' ),
				'type'         => \Elementor\Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Yes', 'aiqengage-child' ),
				'label_off'    => esc_html__( 'No', 'aiqengage-child' ),
				'return_value' => 'yes',
				'default'      => 'yes',
			)
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_rows',
			array(
				'label' => esc_html__( 'Rows (Features/Metrics)', 'aiqengage-child' ),
				'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
			)
		);

		$repeater_rows = new \Elementor\Repeater();

		$repeater_rows->add_control(
			'row_name',
			array(
				'label'       => esc_html__( 'Feature Name', 'aiqengage-child' ),
				'type'        => \Elementor\Controls_Manager::TEXT,
				'default'     => esc_html__( 'Feature', 'aiqengage-child' ),
				'label_block' => true,
			)
		);

		$repeater_rows->add_control(
			'row_description',
			array(
				'label'   => esc_html__( 'Feature Description', 'aiqengage-child' ),
				'type'    => \Elementor\Controls_Manager::TEXTAREA,
				'rows'    => 3,
				'default' => '',
			)
		);

		$repeater_rows->add_control(
			'row_type',
			array(
				'label'   => esc_html__( 'Value Type', 'aiqengage-child' ),
				'type'    => \Elementor\Controls_Manager::SELECT,
				'default' => 'yes_no',
				'options' => array(
					'yes_no' => esc_html__( 'Yes/No', 'aiqengage-child' ),
					'icon'   => esc_html__( 'Icon', 'aiqengage-child' ),
					'text'   => esc_html__( 'Text', 'aiqengage-child' ),
					'number' => esc_html__( 'Number', 'aiqengage-child' ),
					'rating' => esc_html__( 'Rating', 'aiqengage-child' ),
				),
			)
		);

		$repeater_rows->add_control(
			'row_is_category',
			array(
				'label'        => esc_html__( 'Is Category Header', 'aiqengage-child' ),
				'type'         => \Elementor\Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Yes', 'aiqengage-child' ),
				'label_off'    => esc_html__( 'No', 'aiqengage-child' ),
				'return_value' => 'yes',
				'default'      => 'no',
			)
		);

		$repeater_rows->add_control(
			'row_is_highlight',
			array(
				'label'        => esc_html__( 'Highlight Row', 'aiqengage-child' ),
				'type'         => \Elementor\Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Yes', 'aiqengage-child' ),
				'label_off'    => esc_html__( 'No', 'aiqengage-child' ),
				'return_value' => 'yes',
				'default'      => 'no',
			)
		);

		$this->add_control(
			'rows',
			array(
				'label'       => esc_html__( 'Features/Rows', 'aiqengage-child' ),
				'type'        => \Elementor\Controls_Manager::REPEATER,
				'fields'      => $repeater_rows->get_controls(),
				'default'     => array(
					array(
						'row_name'        => esc_html__( 'Basic Features', 'aiqengage-child' ),
						'row_is_category' => 'yes',
					),
					array(
						'row_name' => esc_html__( 'Feature 1', 'aiqengage-child' ),
						'row_type' => 'yes_no',
					),
					array(
						'row_name' => esc_html__( 'Feature 2', 'aiqengage-child' ),
						'row_type' => 'yes_no',
					),
					array(
						'row_name'        => esc_html__( 'Advanced Features', 'aiqengage-child' ),
						'row_is_category' => 'yes',
					),
					array(
						'row_name' => esc_html__( 'Feature 3', 'aiqengage-child' ),
						'row_type' => 'yes_no',
					),
				),
				'title_field' => '{{{ row_name }}}',
			)
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_cell_values',
			array(
				'label' => esc_html__( 'Cell Values', 'aiqengage-child' ),
				'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
			)
		);

		$repeater_cells = new \Elementor\Repeater();

		$repeater_cells->add_control(
			'cell_row_index',
			array(
				'label'   => esc_html__( 'Row Index', 'aiqengage-child' ),
				'type'    => \Elementor\Controls_Manager::NUMBER,
				'min'     => 0,
				'default' => 0,
			)
		);

		$repeater_cells->add_control(
			'cell_column_index',
			array(
				'label'   => esc_html__( 'Column Index', 'aiqengage-child' ),
				'type'    => \Elementor\Controls_Manager::NUMBER,
				'min'     => 0,
				'default' => 0,
			)
		);

		$repeater_cells->add_control(
			'cell_yes_no',
			array(
				'label'        => esc_html__( 'Has Feature', 'aiqengage-child' ),
				'type'         => \Elementor\Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Yes', 'aiqengage-child' ),
				'label_off'    => esc_html__( 'No', 'aiqengage-child' ),
				'return_value' => 'yes',
				'default'      => 'yes',
				'condition'    => array(
					'cell_type' => 'yes_no',
				),
			)
		);

		$repeater_cells->add_control(
			'cell_icon',
			array(
				'label'     => esc_html__( 'Icon', 'aiqengage-child' ),
				'type'      => \Elementor\Controls_Manager::ICONS,
				'default'   => array(
					'value'   => 'fas fa-check',
					'library' => 'fa-solid',
				),
				'condition' => array(
					'cell_type' => 'icon',
				),
			)
		);

		$repeater_cells->add_control(
			'cell_text',
			array(
				'label'     => esc_html__( 'Text', 'aiqengage-child' ),
				'type'      => \Elementor\Controls_Manager::TEXT,
				'default'   => esc_html__( 'Value', 'aiqengage-child' ),
				'condition' => array(
					'cell_type' => 'text',
				),
			)
		);

		$repeater_cells->add_control(
			'cell_number',
			array(
				'label'     => esc_html__( 'Number', 'aiqengage-child' ),
				'type'      => \Elementor\Controls_Manager::NUMBER,
				'default'   => 0,
				'condition' => array(
					'cell_type' => 'number',
				),
			)
		);

		$repeater_cells->add_control(
			'cell_rating',
			array(
				'label'      => esc_html__( 'Rating', 'aiqengage-child' ),
				'type'       => \Elementor\Controls_Manager::SLIDER,
				'size_units' => array( 'px' ),
				'range'      => array(
					'px' => array(
						'min'  => 0,
						'max'  => 5,
						'step' => 0.1,
					),
				),
				'default'    => array(
					'unit' => 'px',
					'size' => 3.5,
				),
				'condition'  => array(
					'cell_type' => 'rating',
				),
			)
		);

		$this->add_control(
			'enable_dynamic_cells',
			array(
				'label'        => esc_html__( 'Enable Dynamic Cell Generation', 'aiqengage-child' ),
				'type'         => \Elementor\Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Yes', 'aiqengage-child' ),
				'label_off'    => esc_html__( 'No', 'aiqengage-child' ),
				'return_value' => 'yes',
				'default'      => 'yes',
				'description'  => esc_html__( 'Automatically generate cell controls based on rows and columns. Disable for manual cell configuration.', 'aiqengage-child' ),
			)
		);

		$this->add_control(
			'cells',
			array(
				'label'       => esc_html__( 'Cell Values (Manual)', 'aiqengage-child' ),
				'type'        => \Elementor\Controls_Manager::REPEATER,
				'fields'      => $repeater_cells->get_controls(),
				'condition'   => array(
					'enable_dynamic_cells' => '',
				),
				'title_field' => esc_html__( 'Cell [Row: {{{ cell_row_index }}} | Col: {{{ cell_column_index }}}]', 'aiqengage-child' ),
			)
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_settings',
			array(
				'label' => esc_html__( 'Settings', 'aiqengage-child' ),
				'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
			)
		);

		$this->add_control(
			'highlight_differences',
			array(
				'label'        => esc_html__( 'Highlight Differences', 'aiqengage-child' ),
				'type'         => \Elementor\Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Yes', 'aiqengage-child' ),
				'label_off'    => esc_html__( 'No', 'aiqengage-child' ),
				'return_value' => 'yes',
				'default'      => 'yes',
			)
		);

		$this->add_control(
			'show_feature_tooltips',
			array(
				'label'        => esc_html__( 'Show Feature Tooltips', 'aiqengage-child' ),
				'type'         => \Elementor\Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Yes', 'aiqengage-child' ),
				'label_off'    => esc_html__( 'No', 'aiqengage-child' ),
				'return_value' => 'yes',
				'default'      => 'yes',
			)
		);

		$this->add_control(
			'enable_sorting',
			array(
				'label'        => esc_html__( 'Enable Interactive Sorting', 'aiqengage-child' ),
				'type'         => \Elementor\Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Yes', 'aiqengage-child' ),
				'label_off'    => esc_html__( 'No', 'aiqengage-child' ),
				'return_value' => 'yes',
				'default'      => 'no',
			)
		);

		$this->add_control(
			'show_logo',
			array(
				'label'        => esc_html__( 'Show Logo', 'aiqengage-child' ),
				'type'         => \Elementor\Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Yes', 'aiqengage-child' ),
				'label_off'    => esc_html__( 'No', 'aiqengage-child' ),
				'return_value' => 'yes',
				'default'      => 'yes',
			)
		);

		$this->add_control(
			'show_cta',
			array(
				'label'        => esc_html__( 'Show CTA Buttons', 'aiqengage-child' ),
				'type'         => \Elementor\Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Yes', 'aiqengage-child' ),
				'label_off'    => esc_html__( 'No', 'aiqengage-child' ),
				'return_value' => 'yes',
				'default'      => 'yes',
			)
		);

		$this->end_controls_section();

		// Style Tabs
		$this->start_controls_section(
			'section_table_style',
			array(
				'label' => esc_html__( 'Table', 'aiqengage' ),
				'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_control(
			'table_background',
			array(
				'label'     => esc_html__( 'Table Background', 'aiqengage' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '#2A1958',
				'selectors' => array(
					'{{WRAPPER}} .aiq-comparison-matrix' => 'background-color: {{VALUE}};',
				),
			)
		);

		$this->add_group_control(
			\Elementor\Group_Control_Border::get_type(),
			array(
				'name'      => 'table_border',
				'selector'  => '{{WRAPPER}} .aiq-comparison-matrix',
				'separator' => 'before',
			)
		);

		$this->add_responsive_control(
			'table_border_radius',
			array(
				'label'      => esc_html__( 'Border Radius', 'aiqengage' ),
				'type'       => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%', 'em' ),
				'default'    => array(
					'top'      => '15',
					'right'    => '15',
					'bottom'   => '15',
					'left'     => '15',
					'unit'     => 'px',
					'isLinked' => true,
				),
				'selectors'  => array(
					'{{WRAPPER}} .aiq-comparison-matrix' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_group_control(
			\Elementor\Group_Control_Box_Shadow::get_type(),
			array(
				'name'     => 'table_box_shadow',
				'selector' => '{{WRAPPER}} .aiq-comparison-matrix',
			)
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_header_style',
			array(
				'label' => esc_html__( 'Header', 'aiqengage' ),
				'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_control(
			'header_background',
			array(
				'label'     => esc_html__( 'Header Background', 'aiqengage' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => 'rgba(26, 9, 56, 1)',
				'selectors' => array(
					'{{WRAPPER}} .aiq-comparison-matrix__header' => 'background-color: {{VALUE}};',
				),
			)
		);

		$this->add_control(
			'header_text_color',
			array(
				'label'     => esc_html__( 'Header Text Color', 'aiqengage' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '#E0D6FF',
				'selectors' => array(
					'{{WRAPPER}} .aiq-comparison-matrix__header' => 'color: {{VALUE}};',
				),
			)
		);

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			array(
				'name'     => 'header_typography',
				'selector' => '{{WRAPPER}} .aiq-comparison-matrix__header-title',
			)
		);

		$this->add_responsive_control(
			'logo_size',
			array(
				'label'      => esc_html__( 'Logo Size', 'aiqengage' ),
				'type'       => \Elementor\Controls_Manager::SLIDER,
				'size_units' => array( 'px' ),
				'range'      => array(
					'px' => array(
						'min'  => 20,
						'max'  => 150,
						'step' => 1,
					),
				),
				'default'    => array(
					'unit' => 'px',
					'size' => 64,
				),
				'selectors'  => array(
					'{{WRAPPER}} .aiq-comparison-matrix__logo' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
				),
				'condition'  => array(
					'show_logo' => 'yes',
				),
			)
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_rows_style',
			array(
				'label' => esc_html__( 'Rows', 'aiqengage' ),
				'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_control(
			'rows_background',
			array(
				'label'     => esc_html__( 'Row Background', 'aiqengage' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '#2A1958',
				'selectors' => array(
					'{{WRAPPER}} .aiq-comparison-matrix__row:not(.aiq-comparison-matrix__row--category):not(.aiq-comparison-matrix__row--highlight)' => 'background-color: {{VALUE}};',
				),
			)
		);

		$this->add_control(
			'rows_alt_background',
			array(
				'label'     => esc_html__( 'Alternate Row Background', 'aiqengage' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => 'rgba(42, 25, 88, 0.7)',
				'selectors' => array(
					'{{WRAPPER}} .aiq-comparison-matrix__row:nth-child(even):not(.aiq-comparison-matrix__row--category):not(.aiq-comparison-matrix__row--highlight)' => 'background-color: {{VALUE}};',
				),
			)
		);

		$this->add_control(
			'row_category_background',
			array(
				'label'     => esc_html__( 'Category Row Background', 'aiqengage' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => 'rgba(156, 77, 255, 0.2)',
				'selectors' => array(
					'{{WRAPPER}} .aiq-comparison-matrix__row--category' => 'background-color: {{VALUE}};',
				),
			)
		);

		$this->add_control(
			'row_highlight_background',
			array(
				'label'     => esc_html__( 'Highlight Row Background', 'aiqengage' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => 'rgba(156, 77, 255, 0.15)',
				'selectors' => array(
					'{{WRAPPER}} .aiq-comparison-matrix__row--highlight' => 'background-color: {{VALUE}};',
				),
			)
		);

		$this->add_control(
			'rows_text_color',
			array(
				'label'     => esc_html__( 'Row Text Color', 'aiqengage' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '#E0D6FF',
				'selectors' => array(
					'{{WRAPPER}} .aiq-comparison-matrix__row' => 'color: {{VALUE}};',
				),
			)
		);

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			array(
				'name'     => 'rows_typography',
				'selector' => '{{WRAPPER}} .aiq-comparison-matrix__feature',
			)
		);

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			array(
				'name'     => 'category_typography',
				'label'    => esc_html__( 'Category Typography', 'aiqengage' ),
				'selector' => '{{WRAPPER}} .aiq-comparison-matrix__row--category .aiq-comparison-matrix__feature',
			)
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_cells_style',
			array(
				'label' => esc_html__( 'Cells', 'aiqengage' ),
				'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_control(
			'cell_text_color',
			array(
				'label'     => esc_html__( 'Cell Text Color', 'aiqengage' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '#E0D6FF',
				'selectors' => array(
					'{{WRAPPER}} .aiq-comparison-matrix__cell' => 'color: {{VALUE}};',
				),
			)
		);

		$this->add_control(
			'cell_border_color',
			array(
				'label'     => esc_html__( 'Cell Border Color', 'aiqengage' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => 'rgba(156, 77, 255, 0.2)',
				'selectors' => array(
					'{{WRAPPER}} .aiq-comparison-matrix__cell' => 'border-color: {{VALUE}};',
				),
			)
		);

		$this->add_control(
			'cell_yes_color',
			array(
				'label'     => esc_html__( 'Yes Icon Color', 'aiqengage' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '#4CAF50',
				'selectors' => array(
					'{{WRAPPER}} .aiq-comparison-matrix__cell--yes' => 'color: {{VALUE}};',
				),
			)
		);

		$this->add_control(
			'cell_no_color',
			array(
				'label'     => esc_html__( 'No Icon Color', 'aiqengage' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => 'rgba(224, 214, 255, 0.4)',
				'selectors' => array(
					'{{WRAPPER}} .aiq-comparison-matrix__cell--no' => 'color: {{VALUE}};',
				),
			)
		);

		$this->add_control(
			'highlight_difference_background',
			array(
				'label'     => esc_html__( 'Highlighted Difference Background', 'aiqengage' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => 'rgba(156, 77, 255, 0.1)',
				'selectors' => array(
					'{{WRAPPER}} .aiq-comparison-matrix__cell--highlight' => 'background-color: {{VALUE}};',
				),
				'condition' => array(
					'highlight_differences' => 'yes',
				),
			)
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_badge_style',
			array(
				'label' => esc_html__( 'Badges', 'aiqengage' ),
				'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_control(
			'badge_text_color',
			array(
				'label'     => esc_html__( 'Badge Text Color', 'aiqengage' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '#1A0938',
				'selectors' => array(
					'{{WRAPPER}} .aiq-comparison-matrix__badge' => 'color: {{VALUE}};',
				),
			)
		);

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			array(
				'name'     => 'badge_typography',
				'selector' => '{{WRAPPER}} .aiq-comparison-matrix__badge',
			)
		);

		$this->add_responsive_control(
			'badge_border_radius',
			array(
				'label'      => esc_html__( 'Badge Border Radius', 'aiqengage' ),
				'type'       => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%', 'em' ),
				'default'    => array(
					'top'      => '15',
					'right'    => '15',
					'bottom'   => '15',
					'left'     => '15',
					'unit'     => 'px',
					'isLinked' => true,
				),
				'selectors'  => array(
					'{{WRAPPER}} .aiq-comparison-matrix__badge' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_cta_style',
			array(
				'label'     => esc_html__( 'CTA Buttons', 'aiqengage' ),
				'tab'       => \Elementor\Controls_Manager::TAB_STYLE,
				'condition' => array(
					'show_cta' => 'yes',
				),
			)
		);

		$this->start_controls_tabs(
			'tabs_cta_style'
		);

		$this->start_controls_tab(
			'tab_cta_normal',
			array(
				'label' => esc_html__( 'Normal', 'aiqengage' ),
			)
		);

		$this->add_control(
			'cta_text_color',
			array(
				'label'     => esc_html__( 'Text Color', 'aiqengage' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '#FFFFFF',
				'selectors' => array(
					'{{WRAPPER}} .aiq-comparison-matrix__cta' => 'color: {{VALUE}};',
				),
			)
		);

		$this->add_group_control(
			\Elementor\Group_Control_Background::get_type(),
			array(
				'name'           => 'cta_background',
				'label'          => esc_html__( 'Background', 'aiqengage' ),
				'types'          => array( 'classic', 'gradient' ),
				'exclude'        => array( 'image' ),
				'fields_options' => array(
					'background'     => array(
						'default' => 'gradient',
					),
					'color'          => array(
						'default' => '#9C4DFF',
					),
					'color_b'        => array(
						'default' => '#5E72E4',
					),
					'gradient_angle' => array(
						'default' => array(
							'unit' => 'deg',
							'size' => 90,
						),
					),
				),
				'selector'       => '{{WRAPPER}} .aiq-comparison-matrix__cta',
			)
		);

		$this->add_group_control(
			\Elementor\Group_Control_Border::get_type(),
			array(
				'name'     => 'cta_border',
				'selector' => '{{WRAPPER}} .aiq-comparison-matrix__cta',
			)
		);

		$this->add_responsive_control(
			'cta_border_radius',
			array(
				'label'      => esc_html__( 'Border Radius', 'aiqengage' ),
				'type'       => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%', 'em' ),
				'default'    => array(
					'top'      => '8',
					'right'    => '8',
					'bottom'   => '8',
					'left'     => '8',
					'unit'     => 'px',
					'isLinked' => true,
				),
				'selectors'  => array(
					'{{WRAPPER}} .aiq-comparison-matrix__cta' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_group_control(
			\Elementor\Group_Control_Box_Shadow::get_type(),
			array(
				'name'     => 'cta_box_shadow',
				'selector' => '{{WRAPPER}} .aiq-comparison-matrix__cta',
			)
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'tab_cta_hover',
			array(
				'label' => esc_html__( 'Hover', 'aiqengage' ),
			)
		);

		$this->add_control(
			'cta_hover_text_color',
			array(
				'label'     => esc_html__( 'Text Color', 'aiqengage' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '#FFFFFF',
				'selectors' => array(
					'{{WRAPPER}} .aiq-comparison-matrix__cta:hover' => 'color: {{VALUE}};',
				),
			)
		);

		$this->add_group_control(
			\Elementor\Group_Control_Background::get_type(),
			array(
				'name'           => 'cta_hover_background',
				'label'          => esc_html__( 'Background', 'aiqengage' ),
				'types'          => array( 'classic', 'gradient' ),
				'exclude'        => array( 'image' ),
				'fields_options' => array(
					'background'     => array(
						'default' => 'gradient',
					),
					'color'          => array(
						'default' => '#8946e5',
					),
					'color_b'        => array(
						'default' => '#5067cb',
					),
					'gradient_angle' => array(
						'default' => array(
							'unit' => 'deg',
							'size' => 90,
						),
					),
				),
				'selector'       => '{{WRAPPER}} .aiq-comparison-matrix__cta:hover',
			)
		);

		$this->add_group_control(
			\Elementor\Group_Control_Box_Shadow::get_type(),
			array(
				'name'           => 'cta_hover_box_shadow',
				'selector'       => '{{WRAPPER}} .aiq-comparison-matrix__cta:hover',
				'fields_options' => array(
					'box_shadow_type' => array(
						'default' => 'yes',
					),
					'box_shadow'      => array(
						'default' => array(
							'horizontal' => 0,
							'vertical'   => 6,
							'blur'       => 12,
							'spread'     => 0,
							'color'      => 'rgba(94, 114, 228, 0.4)',
						),
					),
				),
			)
		);

		$this->add_control(
			'cta_hover_transition',
			array(
				'label'     => esc_html__( 'Transition Duration', 'aiqengage' ),
				'type'      => \Elementor\Controls_Manager::SLIDER,
				'default'   => array(
					'size' => 0.3,
				),
				'range'     => array(
					'px' => array(
						'max'  => 3,
						'step' => 0.1,
					),
				),
				'selectors' => array(
					'{{WRAPPER}} .aiq-comparison-matrix__cta' => 'transition: all {{SIZE}}s;',
				),
			)
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			array(
				'name'      => 'cta_typography',
				'selector'  => '{{WRAPPER}} .aiq-comparison-matrix__cta',
				'separator' => 'before',
			)
		);

		$this->add_responsive_control(
			'cta_padding',
			array(
				'label'      => esc_html__( 'Padding', 'aiqengage' ),
				'type'       => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', 'em', '%' ),
				'default'    => array(
					'top'      => '0.9',
					'right'    => '1.6',
					'bottom'   => '0.9',
					'left'     => '1.6',
					'unit'     => 'rem',
					'isLinked' => false,
				),
				'selectors'  => array(
					'{{WRAPPER}} .aiq-comparison-matrix__cta' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->end_controls_section();
	}

	/**
	 * Render widget output on the frontend.
	 *
	 * @since 1.0.0
	 * @access protected
	 */
	protected function render() {
		$settings = $this->get_settings_for_display();
		$columns  = $settings['columns'];
		$rows     = $settings['rows'];
		$cells    = isset( $settings['cells'] ) ? $settings['cells'] : array();

		$this->add_render_attribute( 'wrapper', 'class', 'aiq-comparison-matrix-wrapper' );

		if ( 'yes' === $settings['highlight_differences'] ) {
			$this->add_render_attribute( 'wrapper', 'data-highlight-differences', 'true' );
		}

		if ( 'yes' === $settings['enable_sorting'] ) {
			$this->add_render_attribute( 'wrapper', 'data-enable-sorting', 'true' );
		}

		if ( 'yes' === $settings['sticky_header'] ) {
			$this->add_render_attribute( 'matrix', 'class', 'aiq-comparison-matrix--sticky-header' );
		}

		if ( 'yes' === $settings['sticky_first_column'] ) {
			$this->add_render_attribute( 'matrix', 'class', 'aiq-comparison-matrix--sticky-first-column' );
		}

		$this->add_render_attribute( 'matrix', 'class', 'aiq-comparison-matrix' );
		$this->add_render_attribute( 'matrix', 'role', 'table' );
		$this->add_render_attribute( 'matrix', 'aria-label', esc_html__( 'Comparison Matrix', 'aiqengage-child' ) );

		?>
		<div <?php $this->print_render_attribute_string( 'wrapper' ); ?>>
			<div <?php $this->print_render_attribute_string( 'matrix' ); ?>>

				<!-- Header Row -->
				<div class="aiq-comparison-matrix__row aiq-comparison-matrix__header" role="row">
					<div class="aiq-comparison-matrix__cell aiq-comparison-matrix__feature-header" role="columnheader">
						<?php echo esc_html__( 'Features', 'aiqengage-child' ); ?>
					</div>

					<?php foreach ( $columns as $column_index => $column ) : ?>
						<div class="aiq-comparison-matrix__cell aiq-comparison-matrix__header" role="columnheader" style="--column-accent-color: <?php echo esc_attr( $column['column_accent_color'] ); ?>">
							<?php if ( 'yes' === $settings['show_logo'] && ! empty( $column['column_logo']['url'] ) ) : ?>
								<div class="aiq-comparison-matrix__logo-container">
									<img class="aiq-comparison-matrix__logo" src="<?php echo esc_url( $column['column_logo']['url'] ); ?>" alt="<?php echo esc_attr( $column['column_name'] ); ?> logo">
								</div>
							<?php endif; ?>

							<h3 class="aiq-comparison-matrix__header-title"><?php echo esc_html( $column['column_name'] ); ?></h3>

							<?php if ( ! empty( $column['column_badge'] ) ) : ?>
								<div class="aiq-comparison-matrix__badge" style="background-color: <?php echo esc_attr( $column['column_badge_color'] ); ?>">
									<?php echo esc_html( $column['column_badge'] ); ?>
								</div>
							<?php endif; ?>

							<?php if ( ! empty( $column['column_description'] ) ) : ?>
								<div class="aiq-comparison-matrix__description">
									<?php echo esc_html( $column['column_description'] ); ?>
								</div>
							<?php endif; ?>
						</div>
					<?php endforeach; ?>
				</div>

				<!-- Rows -->
				<?php foreach ( $rows as $row_index => $row ) : ?>
					<?php
					$row_classes = array( 'aiq-comparison-matrix__row' );

					if ( 'yes' === $row['row_is_category'] ) {
						$row_classes[] = 'aiq-comparison-matrix__row--category';
					}

					if ( 'yes' === $row['row_is_highlight'] ) {
						$row_classes[] = 'aiq-comparison-matrix__row--highlight';
					}
					?>

					<div class="<?php echo esc_attr( implode( ' ', $row_classes ) ); ?>" role="row" data-row-type="<?php echo esc_attr( $row['row_type'] ); ?>">
						<div class="aiq-comparison-matrix__cell aiq-comparison-matrix__feature" role="rowheader">
							<?php echo esc_html( $row['row_name'] ); ?>

							<?php if ( ! empty( $row['row_description'] ) && 'yes' === $settings['show_feature_tooltips'] ) : ?>
								<div class="aiq-comparison-matrix__tooltip">
									<span class="aiq-comparison-matrix__tooltip-icon">?</span>
									<div class="aiq-comparison-matrix__tooltip-content">
										<?php echo esc_html( $row['row_description'] ); ?>
									</div>
								</div>
							<?php endif; ?>
						</div>

						<?php
						// Skip cells for category rows
						if ( 'yes' === $row['row_is_category'] ) {
							for ( $i = 0; $i < count( $columns ); $i++ ) {
								echo '<div class="aiq-comparison-matrix__cell aiq-comparison-matrix__cell--category" role="cell"></div>';
							}
							continue;
						}
						?>

						<?php foreach ( $columns as $column_index => $column ) : ?>
							<?php
							// Find cell value for this row and column
							$cell_value   = null;
							$cell_classes = array( 'aiq-comparison-matrix__cell' );
							$cell_style   = '';
							$cell_attrs   = '';

							// Set cell accent color based on column
							$cell_style = 'style="--column-accent-color: ' . esc_attr( $column['column_accent_color'] ) . ';"';

							// For dynamic cell generation
							if ( 'yes' === $settings['enable_dynamic_cells'] ) {
								// Generate mock cell data based on row type
								switch ( $row['row_type'] ) {
									case 'yes_no':
										// Alternating pattern for demo
										$has_feature    = ( $row_index + $column_index ) % 3 != 0;
										$cell_value     = $has_feature ?
											'<i class="fas fa-check" aria-hidden="true"></i><span class="elementor-screen-only">Yes</span>' :
											'<i class="fas fa-times" aria-hidden="true"></i><span class="elementor-screen-only">No</span>';
										$cell_classes[] = $has_feature ? 'aiq-comparison-matrix__cell--yes' : 'aiq-comparison-matrix__cell--no';
										break;

									case 'icon':
										// Use a simple icon
										$icons      = array( 'far fa-star', 'fas fa-star', 'fas fa-star-half-alt' );
										$icon       = $icons[ ( $row_index + $column_index ) % 3 ];
										$cell_value = '<i class="' . $icon . '" aria-hidden="true"></i>';
										break;

									case 'text':
										// Simple text based on position
										$texts      = array( 'Basic', 'Advanced', 'Premium', 'Limited' );
										$cell_value = $texts[ ( $row_index + $column_index ) % 4 ];
										break;

									case 'number':
										// Generate a number
										$cell_value = ( ( $row_index + 1 ) * 10 ) + ( $column_index * 5 );
										break;

									case 'rating':
										// Generate a star rating
										$rating     = min( 5, max( 1, 2.5 + ( ( $column_index - $row_index ) * 0.5 ) ) );
										$full_stars = floor( $rating );
										$half_star  = $rating - $full_stars >= 0.5;

										$cell_value = '<div class="aiq-comparison-matrix__rating" data-rating="' . $rating . '">';

										// Full stars
										for ( $i = 0; $i < $full_stars; $i++ ) {
											$cell_value .= '<i class="fas fa-star" aria-hidden="true"></i>';
										}

										// Half star if needed
										if ( $half_star ) {
											$cell_value .= '<i class="fas fa-star-half-alt" aria-hidden="true"></i>';
										}

										// Empty stars
										$empty_stars = 5 - $full_stars - ( $half_star ? 1 : 0 );
										for ( $i = 0; $i < $empty_stars; $i++ ) {
											$cell_value .= '<i class="far fa-star" aria-hidden="true"></i>';
										}

										$cell_value .= '<span class="elementor-screen-only">' . $rating . ' out of 5 stars</span>';
										$cell_value .= '</div>';
										break;
								}

								// Add highlight class for the first cell that's different in the row
								if ( 'yes' === $settings['highlight_differences'] ) {
									// This is simplified - in production you'd need a more robust mechanism
									if ( $column_index > 0 && $column_index < 3 && $row_index % 3 == 0 ) {
										$cell_classes[] = 'aiq-comparison-matrix__cell--highlight';
									}
								}
							} else {
								// For manual cell configuration (not implemented in this example)
								// You would search the cells array for the matching cell
								foreach ( $cells as $cell ) {
									if ( $cell['cell_row_index'] == $row_index && $cell['cell_column_index'] == $column_index ) {
										// Found the cell - implement your logic here
										break;
									}
								}
							}
							?>

							<div class="<?php echo esc_attr( implode( ' ', $cell_classes ) ); ?>" role="cell" <?php echo $cell_style; ?> <?php echo $cell_attrs; ?>>
								<?php echo $cell_value; ?>
							</div>
						<?php endforeach; ?>
					</div>
				<?php endforeach; ?>

				<!-- CTA Row -->
				<?php if ( 'yes' === $settings['show_cta'] ) : ?>
					<div class="aiq-comparison-matrix__row aiq-comparison-matrix__row--cta" role="row">
						<div class="aiq-comparison-matrix__cell aiq-comparison-matrix__feature" role="rowheader">
							<?php echo esc_html__( 'Choose Your Plan', 'aiqengage-child' ); ?>
						</div>

						<?php foreach ( $columns as $column_index => $column ) : ?>
							<div class="aiq-comparison-matrix__cell" role="cell" style="--column-accent-color: <?php echo esc_attr( $column['column_accent_color'] ); ?>;">
								<?php if ( ! empty( $column['column_cta_text'] ) ) : ?>
									<a href="<?php echo esc_url( $column['column_cta_url']['url'] ); ?>" class="aiq-comparison-matrix__cta" 
									<?php
									if ( $column['column_cta_url']['is_external'] ) {
										echo 'target="_blank"';}
									?>
									<?php
									if ( $column['column_cta_url']['nofollow'] ) {
										echo 'rel="nofollow"';}
									?>
>
										<?php echo esc_html( $column['column_cta_text'] ); ?>
									</a>
								<?php endif; ?>
							</div>
						<?php endforeach; ?>
					</div>
				<?php endif; ?>
			</div>
		</div>
		<?php
	}

	/**
	 * Render widget output in the editor.
	 *
	 * Written as a Backbone JavaScript template and used to generate the live preview.
	 *
	 * @since 1.0.0
	 * @access protected
	 */
	protected function content_template() {
		?>
		<#
		view.addRenderAttribute( 'wrapper', 'class', 'aiq-comparison-matrix-wrapper' );

		if ( 'yes' === settings.highlight_differences ) {
			view.addRenderAttribute( 'wrapper', 'data-highlight-differences', 'true' );
		}

		if ( 'yes' === settings.enable_sorting ) {
			view.addRenderAttribute( 'wrapper', 'data-enable-sorting', 'true' );
		}

		view.addRenderAttribute( 'matrix', 'class', 'aiq-comparison-matrix' );

		if ( 'yes' === settings.sticky_header ) {
			view.addRenderAttribute( 'matrix', 'class', 'aiq-comparison-matrix--sticky-header' );
		}

		if ( 'yes' === settings.sticky_first_column ) {
			view.addRenderAttribute( 'matrix', 'class', 'aiq-comparison-matrix--sticky-first-column' );
		}

		view.addRenderAttribute( 'matrix', 'role', 'table' );
		view.addRenderAttribute( 'matrix', 'aria-label', 'Comparison Matrix' );
		#>
		<div {{{ view.getRenderAttributeString( 'wrapper' ) }}}>
			<div {{{ view.getRenderAttributeString( 'matrix' ) }}}>

				<!-- Header Row -->
				<div class="aiq-comparison-matrix__row aiq-comparison-matrix__header" role="row">
					<div class="aiq-comparison-matrix__cell aiq-comparison-matrix__feature-header" role="columnheader">
						Features
					</div>

					<# _.each( settings.columns, function( column, column_index ) { #>
						<div class="aiq-comparison-matrix__cell aiq-comparison-matrix__header" role="columnheader" style="--column-accent-color: {{{ column.column_accent_color }}}">
							<# if ( 'yes' === settings.show_logo && column.column_logo.url ) { #>
								<div class="aiq-comparison-matrix__logo-container">
									<img class="aiq-comparison-matrix__logo" src="{{{ column.column_logo.url }}}" alt="{{{ column.column_name }}} logo">
								</div>
							<# } #>

							<h3 class="aiq-comparison-matrix__header-title">{{{ column.column_name }}}</h3>

							<# if ( column.column_badge ) { #>
								<div class="aiq-comparison-matrix__badge" style="background-color: {{{ column.column_badge_color }}}">
									{{{ column.column_badge }}}
								</div>
							<# } #>

							<# if ( column.column_description ) { #>
								<div class="aiq-comparison-matrix__description">
									{{{ column.column_description }}}
								</div>
							<# } #>
						</div>
					<# } ); #>
				</div>

				<!-- Rows -->
				<# _.each( settings.rows, function( row, row_index ) {
					var rowClasses = ['aiq-comparison-matrix__row'];

					if ( 'yes' === row.row_is_category ) {
						rowClasses.push('aiq-comparison-matrix__row--category');
					}

					if ( 'yes' === row.row_is_highlight ) {
						rowClasses.push('aiq-comparison-matrix__row--highlight');
					}
				#>
					<div class="{{ rowClasses.join(' ') }}" role="row" data-row-type="{{{ row.row_type }}}">
						<div class="aiq-comparison-matrix__cell aiq-comparison-matrix__feature" role="rowheader">
							{{{ row.row_name }}}

							<# if ( row.row_description && 'yes' === settings.show_feature_tooltips ) { #>
								<div class="aiq-comparison-matrix__tooltip">
									<span class="aiq-comparison-matrix__tooltip-icon">?</span>
									<div class="aiq-comparison-matrix__tooltip-content">
										{{{ row.row_description }}}
									</div>
								</div>
							<# } #>
						</div>

						<#
						// Skip cells for category rows
						if ( 'yes' === row.row_is_category ) {
							for ( var i = 0; i < settings.columns.length; i++ ) { #>
								<div class="aiq-comparison-matrix__cell aiq-comparison-matrix__cell--category" role="cell"></div>
							<# }
							return;
						}

						_.each( settings.columns, function( column, column_index ) {
							var cellClasses = ['aiq-comparison-matrix__cell'];
							var cellValue = '';
							var cellStyle = 'style="--column-accent-color: ' + column.column_accent_color + ';"';

							// For dynamic cell generation
							if ( 'yes' === settings.enable_dynamic_cells ) {
								// Generate mock cell data based on row type
								switch ( row.row_type ) {
									case 'yes_no':
										// Alternating pattern for demo
										var hasFeature = (row_index + column_index) % 3 != 0;
										cellValue = hasFeature ?
											'<i class="fas fa-check" aria-hidden="true"></i><span class="elementor-screen-only">Yes</span>' :
											'<i class="fas fa-times" aria-hidden="true"></i><span class="elementor-screen-only">No</span>';
										cellClasses.push(hasFeature ? 'aiq-comparison-matrix__cell--yes' : 'aiq-comparison-matrix__cell--no');
										break;

									case 'icon':
										// Use a simple icon
										var icons = ['far fa-star', 'fas fa-star', 'fas fa-star-half-alt'];
										var icon = icons[(row_index + column_index) % 3];
										cellValue = '<i class="' + icon + '" aria-hidden="true"></i>';
										break;

									case 'text':
										// Simple text based on position
										var texts = ['Basic', 'Advanced', 'Premium', 'Limited'];
										cellValue = texts[(row_index + column_index) % 4];
										break;

									case 'number':
										// Generate a number
										cellValue = ((row_index + 1) * 10) + (column_index * 5);
										break;

									case 'rating':
										// Generate a star rating
										var rating = Math.min(5, Math.max(1, 2.5 + ((column_index - row_index) * 0.5)));
										var fullStars = Math.floor(rating// Generate a star rating
										var rating = Math.min(5, Math.max(1, 2.5 + ((column_index - row_index) * 0.5)));
										var fullStars = Math.floor(rating);
										var halfStar = rating - fullStars >= 0.5;

										cellValue = '<div class="aiq-comparison-matrix__rating" data-rating="' + rating + '">';

										// Full stars
										for (var i = 0; i < fullStars; i++) {
											cellValue += '<i class="fas fa-star" aria-hidden="true"></i>';
										}

										// Half star if needed
										if (halfStar) {
											cellValue += '<i class="fas fa-star-half-alt" aria-hidden="true"></i>';
										}

										// Empty stars
										var emptyStars = 5 - fullStars - (halfStar ? 1 : 0);
										for (var i = 0; i < emptyStars; i++) {
											cellValue += '<i class="far fa-star" aria-hidden="true"></i>';
										}

										cellValue += '<span class="elementor-screen-only">' + rating + ' out of 5 stars</span>';
										cellValue += '</div>';
										break;
								}

								// Add highlight class for the first cell that's different in the row
								if ( 'yes' === settings.highlight_differences ) {
									// This is simplified - in production you'd need a more robust mechanism
									if (column_index > 0 && column_index < 3 && row_index % 3 == 0) {
										cellClasses.push('aiq-comparison-matrix__cell--highlight');
									}
								}
							} else {
								// For manual cell configuration
								// You would search the cells array for the matching cell
								// (Not implemented in the preview)
							}
						#>
							<div class="{{ cellClasses.join(' ') }}" role="cell" {{{ cellStyle }}}>
								{{{ cellValue }}}
							</div>
						<# }); #>
					</div>
				<# }); #>

				<!-- CTA Row -->
				<# if ( 'yes' === settings.show_cta ) { #>
					<div class="aiq-comparison-matrix__row aiq-comparison-matrix__row--cta" role="row">
						<div class="aiq-comparison-matrix__cell aiq-comparison-matrix__feature" role="rowheader">
							Choose Your Plan
						</div>

						<# _.each( settings.columns, function( column, column_index ) { #>
							<div class="aiq-comparison-matrix__cell" role="cell" style="--column-accent-color: {{{ column.column_accent_color }}};">
								<# if ( column.column_cta_text ) { #>
									<a href="{{{ column.column_cta_url.url }}}" class="aiq-comparison-matrix__cta" <# if ( column.column_cta_url.is_external ) { #>target="_blank"<# } #> <# if ( column.column_cta_url.nofollow ) { #>rel="nofollow"<# } #>>
										{{{ column.column_cta_text }}}
									</a>
								<# } #>
							</div>
						<# }); #>
					</div>
				<# } #>
			</div>
		</div>
		<?php
	}
}
