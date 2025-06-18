<?php
/**
 * Enhanced Progress Bar Widget for AIQEngage
 *
 * @package AIQEngage
 */

if (!defined('ABSPATH')) {
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
        return esc_html__('Reading Progress Bar', 'aiqengage');
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
        return ['progress', 'reading', 'bar', 'scroll', 'engagement'];
    }

    /**
     * Get widget categories.
     *
     * @return array Widget categories.
     */
    public function get_categories() {
        return ['aiqengage'];
    }

    /**
     * Register widget controls with enhanced options.
     */
    protected function register_controls() {
        // Content Section
        $this->start_controls_section(
            'section_content',
            [
                'label' => esc_html__('Settings', 'aiqengage'),
                'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'bar_position',
            [
                'label'   => esc_html__('Bar Position', 'aiqengage'),
                'type'    => \Elementor\Controls_Manager::SELECT,
                'default' => 'top',
                'options' => [
                    'top'    => esc_html__('Top of Page', 'aiqengage'),
                    'bottom' => esc_html__('Bottom of Page', 'aiqengage'),
                    'inline' => esc_html__('Inline (Widget Position)', 'aiqengage'),
                ],
            ]
        );

        $this->add_control(
            'show_percentage',
            [
                'label'        => esc_html__('Show Percentage', 'aiqengage'),
                'type'         => \Elementor\Controls_Manager::SWITCHER,
                'label_on'     => esc_html__('Show', 'aiqengage'),
                'label_off'    => esc_html__('Hide', 'aiqengage'),
                'return_value' => 'yes',
                'default'      => 'no',
            ]
        );

        $this->add_control(
            'percentage_position',
            [
                'label'     => esc_html__('Percentage Position', 'aiqengage'),
                'type'      => \Elementor\Controls_Manager::SELECT,
                'default'   => 'end',
                'options'   => [
                    'start' => esc_html__('Start of Bar', 'aiqengage'),
                    'end'   => esc_html__('End of Bar', 'aiqengage'),
                    'fixed' => esc_html__('Fixed Right', 'aiqengage'),
                ],
                'condition' => [
                    'show_percentage' => 'yes',
                ],
            ]
        );

        $this->add_control(
            'display_condition',
            [
                'label'   => esc_html__('Display On', 'aiqengage'),
                'type'    => \Elementor\Controls_Manager::SELECT,
                'default' => 'posts',
                'options' => [
                    'posts'      => esc_html__('Posts & Pages Only', 'aiqengage'),
                    'everywhere' => esc_html__('Everywhere', 'aiqengage'),
                    'custom'     => esc_html__('Custom Conditions', 'aiqengage'),
                ],
            ]
        );

        $this->add_control(
            'custom_conditions',
            [
                'label'       => esc_html__('Custom Display Conditions', 'aiqengage'),
                'type'        => \Elementor\Controls_Manager::TEXTAREA,
                'description' => esc_html__('Enter PHP conditional tags separated by new lines (e.g., is_front_page(), is_category())', 'aiqengage'),
                'condition'   => [
                    'display_condition' => 'custom',
                ],
            ]
        );

        $this->add_control(
            'animation_speed',
            [
                'label'   => esc_html__('Animation Speed (ms)', 'aiqengage'),
                'type'    => \Elementor\Controls_Manager::NUMBER,
                'default' => 100,
                'min'     => 0,
                'max'     => 1000,
                'step'    => 10,
            ]
        );

        $this->end_controls_section();

        // Style Section
        $this->start_controls_section(
            'section_style',
            [
                'label' => esc_html__('Style', 'aiqengage'),
                'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'bar_color',
            [
                'label'     => esc_html__('Bar Color', 'aiqengage'),
                'type'      => \Elementor\Controls_Manager::COLOR,
                'default'   => '#9C4DFF',
                'selectors' => [
                    '{{WRAPPER}} .aiq-progress-bar__indicator' => 'background-color: {{VALUE}}',
                    '{{WRAPPER}} .aiq-progress-bar__percentage' => 'background-color: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'bar_background',
            [
                'label'     => esc_html__('Bar Background', 'aiqengage'),
                'type'      => \Elementor\Controls_Manager::COLOR,
                'default'   => 'rgba(156, 77, 255, 0.2)',
                'selectors' => [
                    '{{WRAPPER}} .aiq-progress-bar__container' => 'background-color: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'bar_height',
            [
                'label'      => esc_html__('Bar Height', 'aiqengage'),
                'type'       => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px'],
                'range'      => [
                    'px' => [
                        'min'  => 1,
                        'max'  => 20,
                        'step' => 1,
                    ],
                ],
                'default'    => [
                    'unit' => 'px',
                    'size' => 4,
                ],
                'selectors'  => [
                    '{{WRAPPER}} .aiq-progress-bar__container' => 'height: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'percentage_color',
            [
                'label'     => esc_html__('Percentage Text Color', 'aiqengage'),
                'type'      => \Elementor\Controls_Manager::COLOR,
                'default'   => '#FFFFFF',
                'selectors' => [
                    '{{WRAPPER}} .aiq-progress-bar__percentage' => 'color: {{VALUE}}',
                ],
                'condition' => [
                    'show_percentage' => 'yes',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name'      => 'percentage_typography',
                'selector'  => '{{WRAPPER}} .aiq-progress-bar__percentage',
                'condition' => [
                    'show_percentage' => 'yes',
                ],
            ]
        );

        $this->add_control(
            'percentage_padding',
            [
                'label'      => esc_html__('Percentage Padding', 'aiqengage'),
                'type'       => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors' => [
                    '{{WRAPPER}} .aiq-progress-bar__percentage' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
                'condition'  => [
                    'show_percentage' => 'yes',
                ],
            ]
        );

        $this->add_control(
            'z_index',
            [
                'label'     => esc_html__('Z-Index', 'aiqengage'),
                'type'      => \Elementor\Controls_Manager::NUMBER,
                'default'   => 999,
                'min'       => 1,
                'max'       => 9999,
                'step'      => 1,
                'selectors' => [
                    '{{WRAPPER}} .aiq-progress-bar' => 'z-index: {{VALUE}};',
                ],
                'condition' => [
                    'bar_position' => ['top', 'bottom'],
                ],
            ]
        );

        $this->add_control(
            'fixed_position_offset',
            [
                'label'      => esc_html__('Fixed Position Offset', 'aiqengage'),
                'type'       => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px'],
                'range'      => [
                    'px' => [
                        'min'  => 0,
                        'max'  => 100,
                        'step' => 1,
                    ],
                ],
                'default'    => [
                    'unit' => 'px',
                    'size' => 0,
                ],
                'selectors'  => [
                    '{{WRAPPER}} .aiq-progress-bar--top' => 'top: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}} .aiq-progress-bar--bottom' => 'bottom: {{SIZE}}{{UNIT}};',
                ],
                'condition' => [
                    'bar_position' => ['top', 'bottom'],
                ],
            ]
        );

        $this->end_controls_section();
    }

    /**
     * Check display conditions with enhanced logic.
     */
    private function should_display() {
        $settings = $this->get_settings_for_display();

        if ('everywhere' === $settings['display_condition']) {
            return true;
        }

        if ('posts' === $settings['display_condition']) {
            return is_singular();
        }

        if ('custom' === $settings['display_condition'] && !empty($settings['custom_conditions'])) {
            $conditions = array_filter(array_map('trim', explode("\n", $settings['custom_conditions'])));
            foreach ($conditions as $condition) {
                if (function_exists($condition) {
                    if (call_user_func($condition)) {
                        return true;
                    }
                } elseif (defined($condition) && constant($condition)) {
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
        if (!$this->should_display()) {
            return;
        }

        $settings = $this->get_settings_for_display();
        $position_class = 'aiq-progress-bar--' . $settings['bar_position'];
        $percentage_class = 'aiq-progress-bar__percentage--' . ($settings['percentage_position'] ?? 'end');
        
        $this->add_render_attribute('progress-bar', [
            'class' => ['aiq-progress-bar', $position_class],
            'role' => 'progressbar',
            'aria-valuemin' => '0',
            'aria-valuemax' => '100',
            'aria-valuenow' => '0',
            'data-animation-speed' => esc_attr($settings['animation_speed']),
        ]);
        
        if ('yes' === $settings['show_percentage']) {
            $this->add_render_attribute('progress-bar', 'class', 'aiq-progress-bar--has-percentage');
        }
        ?>
        <div <?php echo $this->get_render_attribute_string('progress-bar'); ?>>
            <div class="aiq-progress-bar__container">
                <div class="aiq-progress-bar__indicator"></div>
            </div>
            <?php if ('yes' === $settings['show_percentage']) : ?>
                <div class="aiq-progress-bar__percentage <?php echo esc_attr($percentage_class); ?>">0%</div>
            <?php endif; ?>
        </div>
        <?php
        
        $this->enqueue_assets();
    }

    /**
     * Enqueue required assets with dependency checks.
     */
    private function enqueue_assets() {
        if (!wp_script_is('aiq-progress-bar', 'registered')) {
            wp_register_script(
                'aiq-progress-bar',
                get_stylesheet_directory_uri() . '/assets/js/progress-bar.js',
                ['jquery', 'elementor-frontend'],
                filemtime(get_stylesheet_directory() . '/assets/js/progress-bar.js'),
                true
            );
        }
        
        if (!wp_style_is('aiq-progress-bar', 'registered')) {
            wp_register_style(
                'aiq-progress-bar',
                get_stylesheet_directory_uri() . '/assets/css/progress-bar.css',
                [],
                filemtime(get_stylesheet_directory() . '/assets/css/progress-bar.css')
            );
        }
        
        wp_enqueue_script('aiq-progress-bar');
        wp_enqueue_style('aiq-progress-bar');
    }
}
