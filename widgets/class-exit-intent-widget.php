<?php
/**
 * Enhanced Exit Intent Modal Widget for AIQEngage
 *
 * @package aiqengage-child
 * @version 1.0.0
 * @since   1.0.0
 * @author  Jason
 * Features:
 * - Improved performance and accessibility
 * - Enhanced targeting options
 * - Better animation handling
 * - Cookie management system
 */

if (!defined('ABSPATH')) {
    exit;
}

class AIQ_Exit_Intent_Widget extends \Elementor\Widget_Base {

    public function get_name() {
        return 'aiq_exit_intent';
    }

    public function get_title() {
        return esc_html__('Exit Intent Modal', 'aiqengage-child');
    }

    public function get_icon() {
        return 'eicon-popup';
    }

    public function get_keywords() {
        return ['modal', 'popup', 'lead', 'exit', 'capture', 'form'];
    }

    public function get_categories() {
        return ['aiqengage'];
    }

    /**
     * Get widget style dependencies.
     *
     * @return string[] CSS handles.
     */
    public function get_style_depends() {
        return [ 'aiqengage-child-exit-intent' ];
    }

    /**
     * Get widget script dependencies.
     *
     * @return string[] JS handles.
     */
    public function get_script_depends() {
        return [ 'aiqengage-child-exit-intent' ];
    }

    protected function register_controls() {
        $this->register_trigger_controls();
        $this->register_content_controls();
        $this->register_modal_settings();
        $this->register_style_controls();
    }

    protected function register_trigger_controls() {
        $this->start_controls_section('section_trigger', [
            'label' => __('Trigger Settings', 'aiqengage-child'),
            'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
        ]);

        $this->add_control('trigger_type', [
            'label' => __('Trigger Type', 'aiqengage-child'),
            'type' => \Elementor\Controls_Manager::SELECT,
            'default' => 'exit_intent',
            'options' => [
                'exit_intent' => __('Exit Intent', 'aiqengage-child'),
                'time_delay' => __('Time Delay', 'aiqengage-child'),
                'scroll_depth' => __('Scroll Depth', 'aiqengage-child'),
                'manual' => __('Manual Trigger Only', 'aiqengage-child'),
                'inactivity' => __('User Inactivity', 'aiqengage-child'),
            ],
        ]);

        $this->add_control('time_delay', [
            'label' => __('Time Delay (seconds)', 'aiqengage-child'),
            'type' => \Elementor\Controls_Manager::NUMBER,
            'min' => 1,
            'max' => 300,
            'step' => 1,
            'default' => 10,
            'condition' => ['trigger_type' => ['time_delay', 'inactivity']],
        ]);

        $this->add_control('scroll_depth', [
            'label' => __('Scroll Depth (%)', 'aiqengage-child'),
            'type' => \Elementor\Controls_Manager::SLIDER,
            'size_units' => ['%'],
            'range' => ['%' => ['min' => 10, 'max' => 100, 'step' => 5]],
            'default' => ['unit' => '%', 'size' => 50],
            'condition' => ['trigger_type' => 'scroll_depth'],
        ]);

        $this->add_control('display_once', [
            'label' => __('Display Frequency', 'aiqengage-child'),
            'type' => \Elementor\Controls_Manager::SELECT,
            'default' => 'session',
            'options' => [
                'session' => __('Once Per Session', 'aiqengage-child'),
                'time' => __('Time Based', 'aiqengage-child'),
                'always' => __('Always Show', 'aiqengage-child'),
            ],
        ]);

        $this->add_control('days_to_remember', [
            'label' => __('Days Until Showing Again', 'aiqengage-child'),
            'type' => \Elementor\Controls_Manager::NUMBER,
            'min' => 1,
            'max' => 365,
            'step' => 1,
            'default' => 7,
            'condition' => ['display_once' => 'time'],
        ]);

        $this->add_control('page_targeting', [
            'label' => __('Page Targeting', 'aiqengage-child'),
            'type' => \Elementor\Controls_Manager::SELECT,
            'default' => 'all',
            'options' => [
                'all' => __('All Pages', 'aiqengage-child'),
                'specific' => __('Specific Pages', 'aiqengage-child'),
                'home' => __('Homepage Only', 'aiqengage-child'),
                'posts' => __('Blog Posts Only', 'aiqengage-child'),
                'pages' => __('Pages Only', 'aiqengage-child'),
            ],
        ]);

        $this->add_control('specific_pages', [
            'label' => __('Select Pages', 'aiqengage-child'),
            'type' => \Elementor\Controls_Manager::SELECT2,
            'multiple' => true,
            'options' => $this->get_all_pages(),
            'condition' => ['page_targeting' => 'specific'],
        ]);

        $this->add_control('exclude_mobile', [
            'label' => __('Exclude on Mobile', 'aiqengage-child'),
            'type' => \Elementor\Controls_Manager::SWITCHER,
            'label_on' => __('Yes', 'aiqengage-child'),
            'label_off' => __('No', 'aiqengage-child'),
            'return_value' => 'yes',
            'default' => 'no',
        ]);

        $this->end_controls_section();
    }

    protected function register_content_controls() {
        $this->start_controls_section('section_content', [
            'label' => __('Content', 'aiqengage-child'),
            'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
        ]);

        $this->add_control('modal_heading', [
            'label' => __('Heading', 'aiqengage-child'),
            'type' => \Elementor\Controls_Manager::TEXT,
            'default' => __('Before You Go...', 'aiqengage-child'),
            'placeholder' => __('Enter your heading', 'aiqengage-child'),
            'label_block' => true,
        ]);

        $this->add_control('modal_subheading', [
            'label' => __('Subheading', 'aiqengage-child'),
            'type' => \Elementor\Controls_Manager::TEXT,
            'default' => __('Get your free Claude automation toolkit', 'aiqengage-child'),
            'placeholder' => __('Enter your subheading', 'aiqengage-child'),
            'label_block' => true,
        ]);

        $this->add_control('content_type', [
            'label' => __('Content Type', 'aiqengage-child'),
            'type' => \Elementor\Controls_Manager::SELECT,
            'default' => 'editor',
            'options' => [
                'editor' => __('Text Editor', 'aiqengage-child'),
                'template' => __('Elementor Template', 'aiqengage-child'),
                'shortcode' => __('Shortcode', 'aiqengage-child'),
            ],
        ]);

        $this->add_control('modal_content', [
            'label' => __('Content', 'aiqengage-child'),
            'type' => \Elementor\Controls_Manager::WYSIWYG,
            'default' => __('<p>Subscribe to get exclusive access to our premium Claude prompt vault.</p>', 'aiqengage-child'),
            'condition' => ['content_type' => 'editor'],
        ]);

        $this->add_control('template_id', [
            'label' => __('Choose Template', 'aiqengage-child'),
            'type' => \Elementor\Controls_Manager::SELECT2,
            'options' => $this->get_elementor_templates(),
            'condition' => ['content_type' => 'template'],
        ]);

        $this->add_control('shortcode', [
            'label' => __('Shortcode', 'aiqengage-child'),
            'type' => \Elementor\Controls_Manager::TEXTAREA,
            'condition' => ['content_type' => 'shortcode'],
        ]);

        $this->end_controls_section();
    }

    protected function register_modal_settings() {
        $this->start_controls_section('section_modal_settings', [
            'label' => __('Modal Settings', 'aiqengage-child'),
            'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
        ]);

        $this->add_control('modal_width', [
            'label' => __('Width', 'aiqengage-child'),
            'type' => \Elementor\Controls_Manager::SLIDER,
            'size_units' => ['px', '%'],
            'range' => [
                'px' => ['min' => 300, 'max' => 1200, 'step' => 10],
                '%' => ['min' => 20, 'max' => 100, 'step' => 1],
            ],
            'default' => ['unit' => 'px', 'size' => 600],
            'selectors' => ['{{WRAPPER}} .aiq-exit-intent__modal' => 'max-width: {{SIZE}}{{UNIT}};'],
        ]);

        $this->add_control('modal_height', [
            'label' => __('Height', 'aiqengage-child'),
            'type' => \Elementor\Controls_Manager::SELECT,
            'default' => 'auto',
            'options' => [
                'auto' => __('Auto', 'aiqengage-child'),
                'custom' => __('Custom', 'aiqengage-child'),
            ],
        ]);

        $this->add_control('modal_custom_height', [
            'label' => __('Custom Height', 'aiqengage-child'),
            'type' => \Elementor\Controls_Manager::SLIDER,
            'size_units' => ['px', 'vh'],
            'range' => [
                'px' => ['min' => 200, 'max' => 1000, 'step' => 10],
                'vh' => ['min' => 20, 'max' => 100, 'step' => 1],
            ],
            'default' => ['unit' => 'px', 'size' => 400],
            'selectors' => ['{{WRAPPER}} .aiq-exit-intent__modal' => 'height: {{SIZE}}{{UNIT}};'],
            'condition' => ['modal_height' => 'custom'],
        ]);

        $this->add_control('close_on_esc', [
            'label' => __('Close on ESC Key', 'aiqengage-child'),
            'type' => \Elementor\Controls_Manager::SWITCHER,
            'label_on' => __('Yes', 'aiqengage-child'),
            'label_off' => __('No', 'aiqengage-child'),
            'return_value' => 'yes',
            'default' => 'yes',
        ]);

        $this->add_control('close_on_overlay_click', [
            'label' => __('Close on Overlay Click', 'aiqengage-child'),
            'type' => \Elementor\Controls_Manager::SWITCHER,
            'label_on' => __('Yes', 'aiqengage-child'),
            'label_off' => __('No', 'aiqengage-child'),
            'return_value' => 'yes',
            'default' => 'yes',
        ]);

        $this->add_control('show_close_button', [
            'label' => __('Show Close Button', 'aiqengage-child'),
            'type' => \Elementor\Controls_Manager::SWITCHER,
            'label_on' => __('Yes', 'aiqengage-child'),
            'label_off' => __('No', 'aiqengage-child'),
            'return_value' => 'yes',
            'default' => 'yes',
        ]);

        $this->add_control('animation', [
            'label' => __('Animation', 'aiqengage-child'),
            'type' => \Elementor\Controls_Manager::SELECT,
            'default' => 'fade-in-up',
            'options' => [
                'fade-in' => __('Fade In', 'aiqengage-child'),
                'fade-in-up' => __('Fade In Up', 'aiqengage-child'),
                'fade-in-down' => __('Fade In Down', 'aiqengage-child'),
                'zoom-in' => __('Zoom In', 'aiqengage-child'),
                'slide-in-right' => __('Slide In Right', 'aiqengage-child'),
                'slide-in-left' => __('Slide In Left', 'aiqengage-child'),
            ],
        ]);

        $this->end_controls_section();
    }

    protected function register_style_controls() {
        $this->register_modal_style();
        $this->register_overlay_style();
        $this->register_typography_style();
        $this->register_close_button_style();
    }

    protected function register_modal_style() {
        $this->start_controls_section('section_modal_style', [
            'label' => __('Modal', 'aiqengage-child'),
            'tab' => \Elementor\Controls_Manager::TAB_STYLE,
        ]);

        $this->add_group_control(\Elementor\Group_Control_Background::get_type(), [
            'name' => 'modal_background',
            'selector' => '{{WRAPPER}} .aiq-exit-intent__modal',
            'default' => ['color' => '#2A1958'],
        ]);

        $this->add_group_control(\Elementor\Group_Control_Border::get_type(), [
            'name' => 'modal_border',
            'selector' => '{{WRAPPER}} .aiq-exit-intent__modal',
        ]);

        $this->add_control('modal_border_radius', [
            'label' => __('Border Radius', 'aiqengage-child'),
            'type' => \Elementor\Controls_Manager::DIMENSIONS,
            'size_units' => ['px', '%'],
            'default' => ['top' => 15, 'right' => 15, 'bottom' => 15, 'left' => 15, 'unit' => 'px'],
            'selectors' => ['{{WRAPPER}} .aiq-exit-intent__modal' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'],
        ]);

        $this->add_group_control(\Elementor\Group_Control_Box_Shadow::get_type(), [
            'name' => 'modal_box_shadow',
            'selector' => '{{WRAPPER}} .aiq-exit-intent__modal',
        ]);

        $this->add_responsive_control('modal_padding', [
            'label' => __('Padding', 'aiqengage-child'),
            'type' => \Elementor\Controls_Manager::DIMENSIONS,
            'size_units' => ['px', 'em', '%'],
            'default' => ['top' => 30, 'right' => 30, 'bottom' => 30, 'left' => 30, 'unit' => 'px'],
            'selectors' => ['{{WRAPPER}} .aiq-exit-intent__modal' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'],
        ]);

        $this->end_controls_section();
    }

    protected function register_overlay_style() {
        $this->start_controls_section('section_overlay_style', [
            'label' => __('Overlay', 'aiqengage-child'),
            'tab' => \Elementor\Controls_Manager::TAB_STYLE,
        ]);

        $this->add_control('overlay_background_color', [
            'label' => __('Background Color', 'aiqengage-child'),
            'type' => \Elementor\Controls_Manager::COLOR,
            'default' => 'rgba(0, 0, 0, 0.8)',
            'selectors' => ['{{WRAPPER}} .aiq-exit-intent__overlay' => 'background-color: {{VALUE}};'],
        ]);

        $this->add_control('overlay_backdrop_filter', [
            'label' => __('Backdrop Filter', 'aiqengage-child'),
            'type' => \Elementor\Controls_Manager::SELECT,
            'default' => 'none',
            'options' => [
                'none' => __('None', 'aiqengage-child'),
                'blur' => __('Blur', 'aiqengage-child'),
            ],
        ]);

        $this->add_control('overlay_blur_amount', [
            'label' => __('Blur Amount', 'aiqengage-child'),
            'type' => \Elementor\Controls_Manager::SLIDER,
            'size_units' => ['px'],
            'range' => ['px' => ['min' => 1, 'max' => 20, 'step' => 1]],
            'default' => ['unit' => 'px', 'size' => 5],
            'selectors' => ['{{WRAPPER}} .aiq-exit-intent__overlay' => 'backdrop-filter: blur({{SIZE}}{{UNIT}});'],
            'condition' => ['overlay_backdrop_filter' => 'blur'],
        ]);

        $this->end_controls_section();
    }

    protected function register_typography_style() {
        $this->start_controls_section('section_typography_style', [
            'label' => __('Typography', 'aiqengage-child'),
            'tab' => \Elementor\Controls_Manager::TAB_STYLE,
        ]);

        $this->add_control('heading_color', [
            'label' => __('Heading Color', 'aiqengage-child'),
            'type' => \Elementor\Controls_Manager::COLOR,
            'default' => '#E0D6FF',
            'selectors' => ['{{WRAPPER}} .aiq-exit-intent__heading' => 'color: {{VALUE}};'],
        ]);

        $this->add_group_control(\Elementor\Group_Control_Typography::get_type(), [
            'name' => 'heading_typography',
            'selector' => '{{WRAPPER}} .aiq-exit-intent__heading',
        ]);

        $this->add_control('subheading_color', [
            'label' => __('Subheading Color', 'aiqengage-child'),
            'type' => \Elementor\Controls_Manager::COLOR,
            'default' => '#9C4DFF',
            'selectors' => ['{{WRAPPER}} .aiq-exit-intent__subheading' => 'color: {{VALUE}};'],
        ]);

        $this->add_group_control(\Elementor\Group_Control_Typography::get_type(), [
            'name' => 'subheading_typography',
            'selector' => '{{WRAPPER}} .aiq-exit-intent__subheading',
        ]);

        $this->add_control('content_color', [
            'label' => __('Content Color', 'aiqengage-child'),
            'type' => \Elementor\Controls_Manager::COLOR,
            'default' => '#E0D6FF',
            'selectors' => ['{{WRAPPER}} .aiq-exit-intent__content' => 'color: {{VALUE}};'],
            'condition' => ['content_type' => 'editor'],
        ]);

        $this->add_group_control(\Elementor\Group_Control_Typography::get_type(), [
            'name' => 'content_typography',
            'selector' => '{{WRAPPER}} .aiq-exit-intent__content',
            'condition' => ['content_type' => 'editor'],
        ]);

        $this->end_controls_section();
    }

    protected function register_close_button_style() {
        $this->start_controls_section('section_close_button_style', [
            'label' => __('Close Button', 'aiqengage-child'),
            'tab' => \Elementor\Controls_Manager::TAB_STYLE,
            'condition' => ['show_close_button' => 'yes'],
        ]);

        $this->add_control('close_button_position', [
            'label' => __('Position', 'aiqengage-child'),
            'type' => \Elementor\Controls_Manager::SELECT,
            'default' => 'outside',
            'options' => [
                'outside' => __('Outside', 'aiqengage-child'),
                'inside' => __('Inside', 'aiqengage-child'),
            ],
            'prefix_class' => 'aiq-exit-intent-close-',
        ]);

        $this->add_control('close_button_size', [
            'label' => __('Size', 'aiqengage-child'),
            'type' => \Elementor\Controls_Manager::SLIDER,
            'size_units' => ['px'],
            'range' => ['px' => ['min' => 20, 'max' => 60, 'step' => 1]],
            'default' => ['unit' => 'px', 'size' => 30],
            'selectors' => [
                '{{WRAPPER}} .aiq-exit-intent__close' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
                '{{WRAPPER}} .aiq-exit-intent__close svg' => 'width: calc({{SIZE}}{{UNIT}} - 10px); height: calc({{SIZE}}{{UNIT}} - 10px);',
            ],
        ]);

        $this->start_controls_tabs('close_button_styles');

        $this->start_controls_tab('close_button_normal', [
            'label' => __('Normal', 'aiqengage-child'),
        ]);

        $this->add_control('close_button_color', [
            'label' => __('Color', 'aiqengage-child'),
            'type' => \Elementor\Controls_Manager::COLOR,
            'default' => '#E0D6FF',
            'selectors' => ['{{WRAPPER}} .aiq-exit-intent__close svg' => 'fill: {{VALUE}};'],
        ]);

        $this->add_control('close_button_background_color', [
            'label' => __('Background Color', 'aiqengage-child'),
            'type' => \Elementor\Controls_Manager::COLOR,
            'default' => 'rgba(156, 77, 255, 0.2)',
            'selectors' => ['{{WRAPPER}} .aiq-exit-intent__close' => 'background-color: {{VALUE}};'],
        ]);

        $this->end_controls_tab();

        $this->start_controls_tab('close_button_hover', [
            'label' => __('Hover', 'aiqengage-child'),
        ]);

        $this->add_control('close_button_hover_color', [
            'label' => __('Color', 'aiqengage-child'),
            'type' => \Elementor\Controls_Manager::COLOR,
            'default' => '#FFFFFF',
            'selectors' => ['{{WRAPPER}} .aiq-exit-intent__close:hover svg' => 'fill: {{VALUE}};'],
        ]);

        $this->add_control('close_button_hover_background_color', [
            'label' => __('Background Color', 'aiqengage-child'),
            'type' => \Elementor\Controls_Manager::COLOR,
            'default' => '#9C4DFF',
            'selectors' => ['{{WRAPPER}} .aiq-exit-intent__close:hover' => 'background-color: {{VALUE}};'],
        ]);

        $this->end_controls_tab();
        $this->end_controls_tabs();

        $this->add_control('close_button_border_radius', [
            'label' => __('Border Radius', 'aiqengage-child'),
            'type' => \Elementor\Controls_Manager::DIMENSIONS,
            'size_units' => ['px', '%'],
            'default' => ['top' => 50, 'right' => 50, 'bottom' => 50, 'left' => 50, 'unit' => '%'],
            'selectors' => ['{{WRAPPER}} .aiq-exit-intent__close' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'],
            'separator' => 'before',
        ]);

        $this->end_controls_section();
    }

    private function get_all_pages() {
        $pages = get_pages();
        $options = [];

        foreach ($pages as $page) {
            $options[$page->ID] = $page->post_title;
        }

        return $options;
    }

    private function get_elementor_templates() {
        $templates = [];
        $args = [
            'post_type' => 'elementor_library',
            'posts_per_page' => -1,
        ];

        $query = new \WP_Query($args);

        if ($query->have_posts()) {
            while ($query->have_posts()) {
                $query->the_post();
                $templates[get_the_ID()] = get_the_title();
            }
        }

        wp_reset_postdata();
        return $templates;
    }

    protected function render() {
        $settings = $this->get_settings_for_display();
        $widget_id = $this->get_id();

        // Check if should display based on page targeting
        if (!$this->should_display($settings)) {
            return;
        }

        // Modal attributes
        $modal_attributes = [
            'id' => 'aiq-exit-intent-' . $widget_id,
            'class' => 'aiq-exit-intent',
            'data-trigger' => $settings['trigger_type'],
            'data-display-once' => $settings['display_once'],
            'data-days-remember' => $settings['days_to_remember'],
            'data-close-esc' => $settings['close_on_esc'],
            'data-close-overlay' => $settings['close_on_overlay_click'],
            'data-animation' => $settings['animation'],
            'data-exclude-mobile' => $settings['exclude_mobile'],
        ];

        // Add trigger-specific attributes
        if ($settings['trigger_type'] === 'time_delay' || $settings['trigger_type'] === 'inactivity') {
            $modal_attributes['data-delay'] = $settings['time_delay'];
        } elseif ($settings['trigger_type'] === 'scroll_depth') {
            $modal_attributes['data-scroll-depth'] = $settings['scroll_depth']['size'];
        }

        // Add page targeting attributes
        if ($settings['page_targeting'] === 'specific' && !empty($settings['specific_pages'])) {
            $modal_attributes['data-specific-pages'] = implode(',', $settings['specific_pages']);
        }

        // Build attributes string
        $attributes = '';
        foreach ($modal_attributes as $key => $value) {
            $attributes .= ' ' . $key . '="' . esc_attr($value) . '"';
        }
        ?>
        <div <?php echo $attributes; ?>>
            <div class="aiq-exit-intent__overlay"></div>
            <div class="aiq-exit-intent__modal aiq-exit-intent__animation-<?php echo esc_attr($settings['animation']); ?>">
                <?php if ($settings['show_close_button'] === 'yes') : ?>
                <button class="aiq-exit-intent__close" aria-label="<?php echo esc_attr__('Close', 'aiqengage-child'); ?>">
                    <svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path d="M18.3 5.71a.996.996 0 00-1.41 0L12 10.59 7.11 5.7A.996.996 0 105.7 7.11L10.59 12 5.7 16.89a.996.996 0 101.41 1.41L12 13.41l4.89 4.89a.996.996 0 101.41-1.41L13.41 12l4.89-4.89c.38-.38.38-1.02 0-1.4z"/>
                    </svg>
                </button>
                <?php endif; ?>

                <div class="aiq-exit-intent__content-wrapper">
                    <?php if (!empty($settings['modal_heading'])) : ?>
                    <h2 class="aiq-exit-intent__heading"><?php echo esc_html($settings['modal_heading']); ?></h2>
                    <?php endif; ?>

                    <?php if (!empty($settings['modal_subheading'])) : ?>
                    <h3 class="aiq-exit-intent__subheading"><?php echo esc_html($settings['modal_subheading']); ?></h3>
                    <?php endif; ?>

                    <div class="aiq-exit-intent__content">
                        <?php if ($settings['content_type'] === 'editor') : ?>
                            <?php echo wp_kses_post($settings['modal_content']); ?>
                        <?php elseif ($settings['content_type'] === 'template' && !empty($settings['template_id'])) : ?>
                            <?php echo \Elementor\Plugin::instance()->frontend->get_builder_content_for_display($settings['template_id']); ?>
                        <?php elseif ($settings['content_type'] === 'shortcode' && !empty($settings['shortcode'])) : ?>
                            <?php echo do_shortcode($settings['shortcode']); ?>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
        <?php
    }

    private function should_display($settings) {
        // Check page targeting
        switch ($settings['page_targeting']) {
            case 'home':
                if (!is_front_page() && !is_home()) return false;
                break;
            case 'posts':
                if (!is_single()) return false;
                break;
            case 'pages':
                if (!is_page()) return false;
                break;
            case 'specific':
                if (empty($settings['specific_pages']) || !is_page($settings['specific_pages'])) return false;
                break;
        }

        return true;
    }
}
