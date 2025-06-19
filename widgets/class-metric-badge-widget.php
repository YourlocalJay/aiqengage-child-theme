<?php
/**
 * Metric Badge Widget for Elementor
 *
 * @package aiqengage-child
 * @since 1.0.0
 * @version 1.0.0
 * @since   1.0.0
 * @author  Jason
 */

namespace AIQEngage\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Core\Schemes\Color;
use Elementor\Core\Schemes\Typography;

defined( 'ABSPATH' ) || exit;

/**
 * Class Metric_Badge_Widget
 *
 * Elementor widget that displays a metric badge with optional counter animation and trend indicators.
 */
class Metric_Badge_Widget extends Widget_Base {

    /**
     * Widget base constructor.
     *
     * @param array $data Widget data.
     * @param array $args Widget arguments.
     */
    public function __construct( $data = [], $args = null ) {
        parent::__construct( $data, $args );

        // Register widget scripts and styles
        wp_register_script(
            'aiq-metric-badge',
            AIQENGAGE_CHILD_URL . '/assets/js/widgets/metric-badge.js',
            ['jquery', 'elementor-frontend'],
            AIQENGAGE_CHILD_VERSION,
            true
        );

        wp_register_style(
            'aiq-metric-badge',
            AIQENGAGE_CHILD_URL . '/assets/css/widgets/metric-badge.css',
            [],
            AIQENGAGE_CHILD_VERSION
        );
    }

    /**
     * Get script dependencies.
     *
     * @return array
     */
    public function get_script_depends() {
        return ['aiq-metric-badge'];
    }

    /**
     * Get style dependencies.
     *
     * @return array
     */
    public function get_style_depends() {
        return ['aiq-metric-badge'];
    }

    /**
     * Get widget name.
     *
     * @return string
     */
    public function get_name() {
        return 'aiq_metric_badge';
    }

    /**
     * Get widget title.
     *
     * @return string
     */
    public function get_title() {
        return esc_html__( 'Metric Badge', 'aiqengage-child' );
    }

    /**
     * Get widget icon.
     *
     * @return string
     */
    public function get_icon() {
        return 'eicon-number-field';
    }

    /**
     * Get widget categories.
     *
     * @return array
     */
    public function get_categories() {
        return ['aiqengage'];
    }

    /**
     * Get widget keywords.
     *
     * @return array
     */
    public function get_keywords() {
        return ['metric', 'badge', 'stat', 'counter', 'trend', 'kpi'];
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
            [
                'label' => esc_html__( 'Content', 'aiqengage-child' ),
                'tab' => Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'metric_label',
            [
                'label' => esc_html__( 'Label', 'aiqengage-child' ),
                'type' => Controls_Manager::TEXT,
                'default' => esc_html__( 'ROI', 'aiqengage-child' ),
                'placeholder' => esc_html__( 'Enter metric label', 'aiqengage-child' ),
                'label_block' => true,
                'dynamic' => [
                    'active' => true,
                ],
            ]
        );

        $this->add_control(
            'metric_value',
            [
                'label' => esc_html__( 'Value', 'aiqengage-child' ),
                'type' => Controls_Manager::TEXT,
                'default' => '387%',
                'placeholder' => esc_html__( 'Enter metric value', 'aiqengage-child' ),
                'label_block' => true,
                'dynamic' => [
                    'active' => true,
                ],
            ]
        );

        $this->add_control(
            'enable_counter',
            [
                'label' => esc_html__( 'Animated Counter', 'aiqengage-child' ),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => esc_html__( 'Yes', 'aiqengage-child' ),
                'label_off' => esc_html__( 'No', 'aiqengage-child' ),
                'return_value' => 'yes',
                'default' => 'yes',
                'description' => esc_html__( 'Animate numeric values from zero to the target value', 'aiqengage-child' ),
            ]
        );

        $this->add_control(
            'counter_speed',
            [
                'label' => esc_html__( 'Animation Duration (ms)', 'aiqengage-child' ),
                'type' => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'min' => 500,
                        'max' => 5000,
                        'step' => 100,
                    ],
                ],
                'default' => [
                    'size' => 2000,
                ],
                'condition' => [
                    'enable_counter' => 'yes',
                ],
            ]
        );

        $this->add_control(
            'trend_indicator',
            [
                'label' => esc_html__( 'Trend Indicator', 'aiqengage-child' ),
                'type' => Controls_Manager::SELECT,
                'default' => 'up',
                'options' => [
                    'up' => esc_html__( 'Up (Positive)', 'aiqengage-child' ),
                    'down' => esc_html__( 'Down (Negative)', 'aiqengage-child' ),
                    'neutral' => esc_html__( 'Neutral', 'aiqengage-child' ),
                    'none' => esc_html__( 'None', 'aiqengage-child' ),
                ],
            ]
        );

        $this->add_control(
            'supporting_text',
            [
                'label' => esc_html__( 'Description', 'aiqengage-child' ),
                'type' => Controls_Manager::TEXT,
                'default' => esc_html__( 'Average across all users', 'aiqengage-child' ),
                'placeholder' => esc_html__( 'Enter supporting text', 'aiqengage-child' ),
                'label_block' => true,
                'dynamic' => [
                    'active' => true,
                ],
            ]
        );

        $this->end_controls_section();
    }

    /**
     * Register style controls.
     */
    protected function register_style_controls() {
        $this->register_badge_style_controls();
        $this->register_trend_style_controls();
    }

    /**
     * Register badge style controls.
     */
    protected function register_badge_style_controls() {
        $this->start_controls_section(
            'section_badge_style',
            [
                'label' => esc_html__( 'Badge', 'aiqengage-child' ),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'badge_shape',
            [
                'label' => esc_html__( 'Shape', 'aiqengage-child' ),
                'type' => Controls_Manager::SELECT,
                'default' => 'pill',
                'options' => [
                    'pill' => esc_html__( 'Pill', 'aiqengage-child' ),
                    'circle' => esc_html__( 'Circle', 'aiqengage-child' ),
                    'square' => esc_html__( 'Square', 'aiqengage-child' ),
                ],
                'prefix_class' => 'aiq-metric-badge--',
            ]
        );

        $this->add_control(
            'badge_background',
            [
                'label' => esc_html__( 'Background Color', 'aiqengage-child' ),
                'type' => Controls_Manager::COLOR,
                'default' => '#2A1958',
                'selectors' => [
                    '{{WRAPPER}} .aiq-metric-badge' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'badge_border_color',
            [
                'label' => esc_html__( 'Border Color', 'aiqengage-child' ),
                'type' => Controls_Manager::COLOR,
                'default' => 'rgba(156, 77, 255, 0.3)',
                'selectors' => [
                    '{{WRAPPER}} .aiq-metric-badge' => 'border-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'badge_border_width',
            [
                'label' => esc_html__( 'Border Width', 'aiqengage-child' ),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['px'],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 10,
                    ],
                ],
                'default' => [
                    'size' => 1,
                ],
                'selectors' => [
                    '{{WRAPPER}} .aiq-metric-badge' => 'border-width: {{SIZE}}{{UNIT}}; border-style: solid;',
                ],
            ]
        );

        $this->add_responsive_control(
            'badge_padding',
            [
                'label' => esc_html__( 'Padding', 'aiqengage-child' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'default' => [
                    'top' => '20',
                    'right' => '25',
                    'bottom' => '20',
                    'left' => '25',
                    'unit' => 'px',
                    'isLinked' => false,
                ],
                'selectors' => [
                    '{{WRAPPER}} .aiq-metric-badge' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'badge_border_radius',
            [
                'label' => esc_html__( 'Border Radius', 'aiqengage-child' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'default' => [
                    'top' => '15',
                    'right' => '15',
                    'bottom' => '15',
                    'left' => '15',
                    'unit' => 'px',
                    'isLinked' => true,
                ],
                'selectors' => [
                    '{{WRAPPER}} .aiq-metric-badge' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
                'condition' => [
                    'badge_shape!' => 'circle',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'badge_box_shadow',
                'selector' => '{{WRAPPER}} .aiq-metric-badge',
                'default' => [
                    'horizontal' => 0,
                    'vertical' => 5,
                    'blur' => 15,
                    'spread' => 0,
                    'color' => 'rgba(0, 0, 0, 0.3)',
                ],
            ]
        );

        $this->add_control(
            'value_heading',
            [
                'label' => esc_html__( 'Value', 'aiqengage-child' ),
                'type' => Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );

        $this->add_control(
            'metric_value_color',
            [
                'label' => esc_html__( 'Color', 'aiqengage-child' ),
                'type' => Controls_Manager::COLOR,
                'default' => '#E0D6FF',
                'selectors' => [
                    '{{WRAPPER}} .aiq-metric-badge__value' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'value_typography',
                'label' => esc_html__( 'Typography', 'aiqengage-child' ),
                'selector' => '{{WRAPPER}} .aiq-metric-badge__value',
                'scheme' => Typography::TYPOGRAPHY_1,
                'fields_options' => [
                    'font_size' => [
                        'default' => [
                            'unit' => 'rem',
                            'size' => '2',
                        ],
                    ],
                    'font_weight' => [
                        'default' => '700',
                    ],
                ],
            ]
        );

        $this->add_control(
            'label_heading',
            [
                'label' => esc_html__( 'Label', 'aiqengage-child' ),
                'type' => Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );

        $this->add_control(
            'metric_label_color',
            [
                'label' => esc_html__( 'Color', 'aiqengage-child' ),
                'type' => Controls_Manager::COLOR,
                'default' => '#9C4DFF',
                'selectors' => [
                    '{{WRAPPER}} .aiq-metric-badge__label' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'label_typography',
                'label' => esc_html__( 'Typography', 'aiqengage-child' ),
                'selector' => '{{WRAPPER}} .aiq-metric-badge__label',
                'scheme' => Typography::TYPOGRAPHY_2,
                'fields_options' => [
                    'font_size' => [
                        'default' => [
                            'unit' => 'rem',
                            'size' => '0.875',
                        ],
                    ],
                    'font_weight' => [
                        'default' => '600',
                    ],
                ],
            ]
        );

        $this->add_control(
            'description_heading',
            [
                'label' => esc_html__( 'Description', 'aiqengage-child' ),
                'type' => Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );

        $this->add_control(
            'supporting_text_color',
            [
                'label' => esc_html__( 'Color', 'aiqengage-child' ),
                'type' => Controls_Manager::COLOR,
                'default' => 'rgba(224, 214, 255, 0.8)',
                'selectors' => [
                    '{{WRAPPER}} .aiq-metric-badge__supporting-text' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'supporting_typography',
                'label' => esc_html__( 'Typography', 'aiqengage-child' ),
                'selector' => '{{WRAPPER}} .aiq-metric-badge__supporting-text',
                'scheme' => Typography::TYPOGRAPHY_3,
                'fields_options' => [
                    'font_size' => [
                        'default' => [
                            'unit' => 'rem',
                            'size' => '0.75',
                        ],
                    ],
                    'font_weight' => [
                        'default' => '400',
                    ],
                ],
            ]
        );

        $this->end_controls_section();
    }

    /**
     * Register trend indicator style controls.
     */
    protected function register_trend_style_controls() {
        $this->start_controls_section(
            'section_trend_style',
            [
                'label' => esc_html__( 'Trend Indicator', 'aiqengage-child' ),
                'tab' => Controls_Manager::TAB_STYLE,
                'condition' => [
                    'trend_indicator!' => 'none',
                ],
            ]
        );

        $this->add_control(
            'trend_up_color',
            [
                'label' => esc_html__( 'Up Trend Color', 'aiqengage-child' ),
                'type' => Controls_Manager::COLOR,
                'default' => '#4CAF50',
                'selectors' => [
                    '{{WRAPPER}} .aiq-metric-badge__trend--up' => 'color: {{VALUE}};',
                ],
                'condition' => [
                    'trend_indicator' => 'up',
                ],
            ]
        );

        $this->add_control(
            'trend_down_color',
            [
                'label' => esc_html__( 'Down Trend Color', 'aiqengage-child' ),
                'type' => Controls_Manager::COLOR,
                'default' => '#F44336',
                'selectors' => [
                    '{{WRAPPER}} .aiq-metric-badge__trend--down' => 'color: {{VALUE}};',
                ],
                'condition' => [
                    'trend_indicator' => 'down',
                ],
            ]
        );

        $this->add_control(
            'trend_neutral_color',
            [
                'label' => esc_html__( 'Neutral Trend Color', 'aiqengage-child' ),
                'type' => Controls_Manager::COLOR,
                'default' => '#FFC107',
                'selectors' => [
                    '{{WRAPPER}} .aiq-metric-badge__trend--neutral' => 'color: {{VALUE}};',
                ],
                'condition' => [
                    'trend_indicator' => 'neutral',
                ],
            ]
        );

        $this->add_responsive_control(
            'trend_size',
            [
                'label' => esc_html__( 'Size', 'aiqengage-child' ),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['px'],
                'range' => [
                    'px' => [
                        'min' => 10,
                        'max' => 50,
                        'step' => 1,
                    ],
                ],
                'default' => [
                    'unit' => 'px',
                    'size' => 16,
                ],
                'selectors' => [
                    '{{WRAPPER}} .aiq-metric-badge__trend' => 'font-size: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'trend_spacing',
            [
                'label' => esc_html__( 'Spacing', 'aiqengage-child' ),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['px'],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 30,
                        'step' => 1,
                    ],
                ],
                'default' => [
                    'unit' => 'px',
                    'size' => 8,
                ],
                'selectors' => [
                    '{{WRAPPER}} .aiq-metric-badge__trend' => 'margin-left: {{SIZE}}{{UNIT}};',
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

        // Prepare trend icon
        $trend_icon = '';
        $trend_class = '';

        switch ($settings['trend_indicator']) {
            case 'up':
                $trend_icon = '<i class="fas fa-arrow-up" aria-hidden="true"></i>';
                $trend_class = 'aiq-metric-badge__trend--up';
                break;
            case 'down':
                $trend_icon = '<i class="fas fa-arrow-down" aria-hidden="true"></i>';
                $trend_class = 'aiq-metric-badge__trend--down';
                break;
            case 'neutral':
                $trend_icon = '<i class="fas fa-minus" aria-hidden="true"></i>';
                $trend_class = 'aiq-metric-badge__trend--neutral';
                break;
        }

        // Counter data attributes
        $counter_data = '';
        $aria_live = 'off';

        if ('yes' === $settings['enable_counter']) {
            // Clean value for counter (numbers only)
            $clean_value = preg_replace('/[^0-9.]/', '', $settings['metric_value']);
            $has_percent = strpos($settings['metric_value'], '%') !== false;
            $suffix = $has_percent ? '%' : '';

            // Check if value contains only numbers and can be animated
            $is_numeric = is_numeric($clean_value);

            if ($is_numeric) {
                $counter_data = sprintf(
                    ' data-counter="true" data-value="%s" data-suffix="%s" data-duration="%d"',
                    esc_attr($clean_value),
                    esc_attr($suffix),
                    absint($settings['counter_speed']['size'])
                );
                $aria_live = 'polite';
            }
        }

        // Value ID for ARIA
        $value_id = 'metric-value-' . $this->get_id();

        // Allow filtering of the badge classes
        $badge_classes = apply_filters('aiq_metric_badge_classes', ['aiq-metric-badge']);
        ?>
        <div class="<?php echo esc_attr(implode(' ', $badge_classes)); ?>"<?php echo $counter_data; ?>>
            <div class="aiq-metric-badge__inner">
                <?php if (!empty($settings['metric_label']) || 'none' !== $settings['trend_indicator']) : ?>
                <div class="aiq-metric-badge__header">
                    <?php if (!empty($settings['metric_label'])) : ?>
                        <div class="aiq-metric-badge__label"><?php echo esc_html($settings['metric_label']); ?></div>
                    <?php endif; ?>

                    <?php if ('none' !== $settings['trend_indicator']) : ?>
                        <div class="aiq-metric-badge__trend <?php echo esc_attr($trend_class); ?>" aria-hidden="true">
                            <?php echo $trend_icon; ?>
                        </div>
                    <?php endif; ?>
                </div>
                <?php endif; ?>

                <div id="<?php echo esc_attr($value_id); ?>" class="aiq-metric-badge__value" aria-live="<?php echo esc_attr($aria_live); ?>">
                    <?php echo esc_html($settings['metric_value']); ?>
                </div>

                <?php if (!empty($settings['supporting_text'])) : ?>
                    <div class="aiq-metric-badge__supporting-text"><?php echo esc_html($settings['supporting_text']); ?></div>
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
        // Prepare trend icon
        var trendIcon = '';
        var trendClass = '';

        switch(settings.trend_indicator) {
            case 'up':
                trendIcon = '<i class="fas fa-arrow-up" aria-hidden="true"></i>';
                trendClass = 'aiq-metric-badge__trend--up';
                break;
            case 'down':
                trendIcon = '<i class="fas fa-arrow-down" aria-hidden="true"></i>';
                trendClass = 'aiq-metric-badge__trend--down';
                break;
            case 'neutral':
                trendIcon = '<i class="fas fa-minus" aria-hidden="true"></i>';
                trendClass = 'aiq-metric-badge__trend--neutral';
                break;
        }

        // Value ID for ARIA
        var valueId = 'metric-value-' + view.getID();
        #>

        <div class="aiq-metric-badge aiq-metric-badge--{{ settings.badge_shape }}">
            <div class="aiq-metric-badge__inner">
                <# if(settings.metric_label || 'none' !== settings.trend_indicator) { #>
                <div class="aiq-metric-badge__header">
                    <# if(settings.metric_label) { #>
                        <div class="aiq-metric-badge__label">{{{ settings.metric_label }}}</div>
                    <# } #>

                    <# if('none' !== settings.trend_indicator) { #>
                        <div class="aiq-metric-badge__trend {{ trendClass }}" aria-hidden="true">
                            {{{ trendIcon }}}
                        </div>
                    <# } #>
                </div>
                <# } #>

                <div id="{{ valueId }}" class="aiq-metric-badge__value">
                    {{{ settings.metric_value }}}
                </div>

                <# if(settings.supporting_text) { #>
                    <div class="aiq-metric-badge__supporting-text">{{{ settings.supporting_text }}}</div>
                <# } #>
            </div>
        </div>
        <?php
    }
}
