<?php
/**
 * FAQ Accordion Widget with Schema
 *
 * @package aiqengage-child
 * @version 1.0.0
 * @since   1.0.0
 * @author  Jason
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

/**
 * FAQ Accordion Widget with Schema.org FAQPage implementation
 */
class AIQ_FAQ_Accordion_Widget extends \Elementor\Widget_Base {

    /**
     * Widget base constructor.
     */
    public function __construct($data = [], $args = null) {
        parent::__construct($data, $args);
        add_action('wp_enqueue_scripts', [$this, 'enqueue_scripts']);
    }

    /**
     * Get widget name.
     *
     * @return string Widget name.
     */
    public function get_name() {
        return 'aiq_faq_accordion';
    }

    /**
     * Get widget title.
     *
     * @return string Widget title.
     */
    public function get_title() {
        return esc_html__('FAQ Accordion with Schema', 'aiqengage-child');
    }

    /**
     * Get widget icon.
     *
     * @return string Widget icon.
     */
    public function get_icon() {
        return 'eicon-faq';
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
     * Get widget keywords.
     *
     * @return array Widget keywords.
     */
    public function get_keywords() {
        return ['faq', 'accordion', 'question', 'answer', 'schema', 'rich snippet'];
    }

    /**
     * Get widget style dependencies.
     *
     * @return string[] CSS handles.
     */
    public function get_style_depends() {
        return [ 'aiq-faq-accordion' ];
    }

    /**
     * Get widget script dependencies.
     *
     * @return string[] JS handles.
     */
    public function get_script_depends() {
        return [ 'aiq-faq-accordion' ];
    }

    /**
     * Register widget scripts and styles
     */
    public function enqueue_scripts() {
        if (\Elementor\Plugin::$instance->preview->is_preview_mode()) {
            wp_enqueue_style(
                'aiq-faq-accordion',
                AIQENGAGE_CHILD_URL . '/assets/css/faq-accordion.css',
                [],
                filemtime(get_stylesheet_directory() . '/assets/css/faq-accordion.css')
            );

            wp_enqueue_script(
                'aiq-faq-accordion',
                AIQENGAGE_CHILD_URL . '/assets/js/faq-accordion.js',
                ['jquery'],
                filemtime(get_stylesheet_directory() . '/assets/js/faq-accordion.js'),
                true
            );
        }
    }

    /**
     * Register widget controls.
     */
    protected function register_controls() {
        $this->register_content_controls();
        $this->register_style_controls();
    }

    /**
     * Register content controls
     */
    protected function register_content_controls() {
        $this->start_controls_section(
            'content_section',
            [
                'label' => esc_html__('FAQ Items', 'aiqengage-child'),
                'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'section_title',
            [
                'label'       => esc_html__('Section Title', 'aiqengage-child'),
                'type'        => \Elementor\Controls_Manager::TEXT,
                'default'     => esc_html__('Frequently Asked Questions', 'aiqengage-child'),
                'placeholder' => esc_html__('Enter your title', 'aiqengage-child'),
                'label_block' => true,
            ]
        );

        $repeater = new \Elementor\Repeater();

        $repeater->add_control(
            'question',
            [
                'label'       => esc_html__('Question', 'aiqengage-child'),
                'type'        => \Elementor\Controls_Manager::TEXT,
                'default'     => esc_html__('FAQ Question?', 'aiqengage-child'),
                'label_block' => true,
                'dynamic'    => [
                    'active' => true,
                ],
            ]
        );

        $repeater->add_control(
            'answer',
            [
                'label'       => esc_html__('Answer', 'aiqengage-child'),
                'type'        => \Elementor\Controls_Manager::WYSIWYG,
                'default'     => esc_html__('FAQ Answer details go here. You can use formatting, lists, and links.', 'aiqengage-child'),
                'placeholder' => esc_html__('Enter your answer', 'aiqengage-child'),
                'dynamic'     => [
                    'active' => true,
                ],
            ]
        );

        $this->add_control(
            'faq_items',
            [
                'label'       => esc_html__('FAQ Items', 'aiqengage-child'),
                'type'        => \Elementor\Controls_Manager::REPEATER,
                'fields'      => $repeater->get_controls(),
                'default'     => [
                    [
                        'question' => esc_html__('What is AIQEngage?', 'aiqengage-child'),
                        'answer'   => esc_html__('AIQEngage provides Claude-Compatible Automation, Tools, and Monetization Kits for solo entrepreneurs and builders.', 'aiqengage-child'),
                    ],
                    [
                        'question' => esc_html__('How soon can I expect results?', 'aiqengage-child'),
                        'answer'   => esc_html__('Most users see initial results within 3-5 days of implementation, with significant improvements after 2-3 weeks of consistent use.', 'aiqengage-child'),
                    ],
                ],
                'title_field' => '{{{ question }}}',
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'settings_section',
            [
                'label' => esc_html__('Settings', 'aiqengage-child'),
                'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'default_open',
            [
                'label'   => esc_html__('Default Open Item', 'aiqengage-child'),
                'type'    => \Elementor\Controls_Manager::SELECT,
                'default' => 'first',
                'options' => [
                    'first'  => esc_html__('First Item', 'aiqengage-child'),
                    'all'    => esc_html__('All Items', 'aiqengage-child'),
                    'none'   => esc_html__('All Closed', 'aiqengage-child'),
                ],
            ]
        );

        $this->add_control(
            'icon_type',
            [
                'label'   => esc_html__('Icon Type', 'aiqengage-child'),
                'type'    => \Elementor\Controls_Manager::SELECT,
                'default' => 'chevron',
                'options' => [
                    'chevron' => esc_html__('Chevron', 'aiqengage-child'),
                    'plus'    => esc_html__('Plus/Minus', 'aiqengage-child'),
                    'arrow'   => esc_html__('Arrow', 'aiqengage-child'),
                    'custom'  => esc_html__('Custom Icon', 'aiqengage-child'),
                ],
            ]
        );

        $this->add_control(
            'custom_icon_closed',
            [
                'label'       => esc_html__('Custom Closed Icon', 'aiqengage-child'),
                'type'        => \Elementor\Controls_Manager::ICONS,
                'default'     => [
                    'value'   => 'fas fa-plus',
                    'library' => 'fa-solid',
                ],
                'condition'   => [
                    'icon_type' => 'custom',
                ],
            ]
        );

        $this->add_control(
            'custom_icon_open',
            [
                'label'       => esc_html__('Custom Open Icon', 'aiqengage-child'),
                'type'        => \Elementor\Controls_Manager::ICONS,
                'default'     => [
                    'value'   => 'fas fa-minus',
                    'library' => 'fa-solid',
                ],
                'condition'   => [
                    'icon_type' => 'custom',
                ],
            ]
        );

        $this->add_control(
            'schema_markup',
            [
                'label'        => esc_html__('Enable Schema Markup', 'aiqengage-child'),
                'type'         => \Elementor\Controls_Manager::SWITCHER,
                'label_on'     => esc_html__('Yes', 'aiqengage-child'),
                'label_off'    => esc_html__('No', 'aiqengage-child'),
                'return_value' => 'yes',
                'default'      => 'yes',
            ]
        );

        $this->add_control(
            'enable_search',
            [
                'label'        => esc_html__('Enable Search', 'aiqengage-child'),
                'type'         => \Elementor\Controls_Manager::SWITCHER,
                'label_on'     => esc_html__('Yes', 'aiqengage-child'),
                'label_off'    => esc_html__('No', 'aiqengage-child'),
                'return_value' => 'yes',
                'default'      => 'no',
                'separator'    => 'before',
            ]
        );

        $this->add_control(
            'search_placeholder',
            [
                'label'       => esc_html__('Search Placeholder', 'aiqengage-child'),
                'type'        => \Elementor\Controls_Manager::TEXT,
                'default'     => esc_html__('Search FAQs...', 'aiqengage-child'),
                'condition'   => [
                    'enable_search' => 'yes',
                ],
            ]
        );

        $this->add_control(
            'search_no_results',
            [
                'label'       => esc_html__('No Results Text', 'aiqengage-child'),
                'type'        => \Elementor\Controls_Manager::TEXT,
                'default'     => esc_html__('No FAQs found matching your search.', 'aiqengage-child'),
                'condition'   => [
                    'enable_search' => 'yes',
                ],
            ]
        );

        $this->end_controls_section();
    }

    /**
     * Register style controls
     */
    protected function register_style_controls() {
        $this->start_controls_section(
            'style_section',
            [
                'label' => esc_html__('Style', 'aiqengage-child'),
                'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'section_title_style',
            [
                'label'     => esc_html__('Section Title', 'aiqengage-child'),
                'type'      => \Elementor\Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name'     => 'section_title_typography',
                'selector' => '{{WRAPPER}} .aiq-faq-accordion__title',
            ]
        );

        $this->add_control(
            'section_title_color',
            [
                'label'     => esc_html__('Title Color', 'aiqengage-child'),
                'type'      => \Elementor\Controls_Manager::COLOR,
                'default'   => '#E0D6FF',
                'selectors' => [
                    '{{WRAPPER}} .aiq-faq-accordion__title' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'section_title_margin',
            [
                'label'      => esc_html__('Margin', 'aiqengage-child'),
                'type'       => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'selectors'  => [
                    '{{WRAPPER}} .aiq-faq-accordion__title' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'search_style',
            [
                'label'     => esc_html__('Search Field', 'aiqengage-child'),
                'type'      => \Elementor\Controls_Manager::HEADING,
                'separator' => 'before',
                'condition' => [
                    'enable_search' => 'yes',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name'      => 'search_typography',
                'selector'  => '{{WRAPPER}} .aiq-faq-accordion__search',
                'condition' => [
                    'enable_search' => 'yes',
                ],
            ]
        );

        $this->add_control(
            'search_text_color',
            [
                'label'     => esc_html__('Text Color', 'aiqengage-child'),
                'type'      => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .aiq-faq-accordion__search' => 'color: {{VALUE}};',
                ],
                'condition' => [
                    'enable_search' => 'yes',
                ],
            ]
        );

        $this->add_control(
            'search_background',
            [
                'label'     => esc_html__('Background Color', 'aiqengage-child'),
                'type'      => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .aiq-faq-accordion__search' => 'background-color: {{VALUE}};',
                ],
                'condition' => [
                    'enable_search' => 'yes',
                ],
            ]
        );

        $this->add_control(
            'search_border_color',
            [
                'label'     => esc_html__('Border Color', 'aiqengage-child'),
                'type'      => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .aiq-faq-accordion__search' => 'border-color: {{VALUE}};',
                ],
                'condition' => [
                    'enable_search' => 'yes',
                ],
            ]
        );

        $this->add_responsive_control(
            'search_border_radius',
            [
                'label'      => esc_html__('Border Radius', 'aiqengage-child'),
                'type'       => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors'  => [
                    '{{WRAPPER}} .aiq-faq-accordion__search' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
                'condition' => [
                    'enable_search' => 'yes',
                ],
            ]
        );

        $this->add_responsive_control(
            'search_padding',
            [
                'label'      => esc_html__('Padding', 'aiqengage-child'),
                'type'       => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'selectors'  => [
                    '{{WRAPPER}} .aiq-faq-accordion__search' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
                'condition' => [
                    'enable_search' => 'yes',
                ],
            ]
        );

        $this->add_responsive_control(
            'search_margin',
            [
                'label'      => esc_html__('Margin', 'aiqengage-child'),
                'type'       => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'selectors'  => [
                    '{{WRAPPER}} .aiq-faq-accordion__search' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
                'condition' => [
                    'enable_search' => 'yes',
                ],
            ]
        );

        $this->add_control(
            'item_style',
            [
                'label'     => esc_html__('FAQ Items', 'aiqengage-child'),
                'type'      => \Elementor\Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name'     => 'question_typography',
                'selector' => '{{WRAPPER}} .aiq-faq-accordion__question',
            ]
        );

        $this->add_control(
            'question_color',
            [
                'label'     => esc_html__('Question Color', 'aiqengage-child'),
                'type'      => \Elementor\Controls_Manager::COLOR,
                'default'   => '#E0D6FF',
                'selectors' => [
                    '{{WRAPPER}} .aiq-faq-accordion__question' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'question_hover_color',
            [
                'label'     => esc_html__('Question Hover Color', 'aiqengage-child'),
                'type'      => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .aiq-faq-accordion__question:hover' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'question_active_color',
            [
                'label'     => esc_html__('Question Active Color', 'aiqengage-child'),
                'type'      => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .aiq-faq-accordion__item.is-active .aiq-faq-accordion__question' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name'     => 'answer_typography',
                'selector' => '{{WRAPPER}} .aiq-faq-accordion__answer',
            ]
        );

        $this->add_control(
            'answer_color',
            [
                'label'     => esc_html__('Answer Color', 'aiqengage-child'),
                'type'      => \Elementor\Controls_Manager::COLOR,
                'default'   => '#E0D6FF',
                'selectors' => [
                    '{{WRAPPER}} .aiq-faq-accordion__answer' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'accent_color',
            [
                'label'     => esc_html__('Accent Color', 'aiqengage-child'),
                'type'      => \Elementor\Controls_Manager::COLOR,
                'default'   => '#9C4DFF',
                'selectors' => [
                    '{{WRAPPER}} .aiq-faq-accordion__icon' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .aiq-faq-accordion__item.is-active .aiq-faq-accordion__question' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .aiq-faq-accordion__item.is-active' => 'border-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'background_color',
            [
                'label'     => esc_html__('Item Background', 'aiqengage-child'),
                'type'      => \Elementor\Controls_Manager::COLOR,
                'default'   => '#2A1958',
                'selectors' => [
                    '{{WRAPPER}} .aiq-faq-accordion__item' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'background_hover_color',
            [
                'label'     => esc_html__('Item Hover Background', 'aiqengage-child'),
                'type'      => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .aiq-faq-accordion__item:hover' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'background_active_color',
            [
                'label'     => esc_html__('Item Active Background', 'aiqengage-child'),
                'type'      => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .aiq-faq-accordion__item.is-active' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name'     => 'item_border',
                'selector' => '{{WRAPPER}} .aiq-faq-accordion__item',
            ]
        );

        $this->add_control(
            'border_radius',
            [
                'label'      => esc_html__('Border Radius', 'aiqengage-child'),
                'type'       => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px'],
                'range'      => [
                    'px' => [
                        'min'  => 0,
                        'max'  => 50,
                        'step' => 1,
                    ],
                ],
                'default'    => [
                    'unit' => 'px',
                    'size' => 15,
                ],
                'selectors'  => [
                    '{{WRAPPER}} .aiq-faq-accordion__item' => 'border-radius: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Box_Shadow::get_type(),
            [
                'name'     => 'item_box_shadow',
                'selector' => '{{WRAPPER}} .aiq-faq-accordion__item',
            ]
        );

        $this->add_responsive_control(
            'item_padding',
            [
                'label'      => esc_html__('Padding', 'aiqengage-child'),
                'type'       => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'selectors'  => [
                    '{{WRAPPER}} .aiq-faq-accordion__item' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'question_padding',
            [
                'label'      => esc_html__('Question Padding', 'aiqengage-child'),
                'type'       => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'selectors'  => [
                    '{{WRAPPER}} .aiq-faq-accordion__question' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'answer_padding',
            [
                'label'      => esc_html__('Answer Padding', 'aiqengage-child'),
                'type'       => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'selectors'  => [
                    '{{WRAPPER}} .aiq-faq-accordion__answer' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'space_between',
            [
                'label'      => esc_html__('Space Between Items', 'aiqengage-child'),
                'type'       => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px'],
                'range'      => [
                    'px' => [
                        'min'  => 0,
                        'max'  => 50,
                        'step' => 1,
                    ],
                ],
                'default'    => [
                    'unit' => 'px',
                    'size' => 15,
                ],
                'selectors'  => [
                    '{{WRAPPER}} .aiq-faq-accordion__item:not(:last-child)' => 'margin-bottom: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'icon_style',
            [
                'label'     => esc_html__('Icon', 'aiqengage-child'),
                'type'      => \Elementor\Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );

        $this->add_responsive_control(
            'icon_size',
            [
                'label'      => esc_html__('Size', 'aiqengage-child'),
                'type'       => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px'],
                'range'      => [
                    'px' => [
                        'min'  => 10,
                        'max'  => 50,
                        'step' => 1,
                    ],
                ],
                'default'    => [
                    'unit' => 'px',
                    'size' => 16,
                ],
                'selectors'  => [
                    '{{WRAPPER}} .aiq-faq-accordion__icon' => 'font-size: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}} .aiq-faq-accordion__icon svg' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'icon_spacing',
            [
                'label'      => esc_html__('Spacing', 'aiqengage-child'),
                'type'       => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px'],
                'range'      => [
                    'px' => [
                        'min'  => 0,
                        'max'  => 30,
                        'step' => 1,
                    ],
                ],
                'default'    => [
                    'unit' => 'px',
                    'size' => 10,
                ],
                'selectors'  => [
                    '{{WRAPPER}} .aiq-faq-accordion__icon' => 'margin-left: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();
    }

    /**
     * Render FAQ Schema in the header
     *
     * @param array $settings Widget settings.
     */
    private function render_schema($settings) {
        if ('yes' !== $settings['schema_markup'] || empty($settings['faq_items'])) {
            return;
        }

        $schema = [
            '@context'   => 'https://schema.org',
            '@type'      => 'FAQPage',
            'mainEntity' => [],
        ];

        foreach ($settings['faq_items'] as $item) {
            if (empty($item['question']) || empty($item['answer'])) {
                continue;
            }

            $schema['mainEntity'][] = [
                '@type'          => 'Question',
                'name'           => wp_strip_all_tags($item['question']),
                'acceptedAnswer' => [
                    '@type' => 'Answer',
                    'text'  => wp_strip_all_tags($item['answer']),
                ],
            ];
        }

        if (!empty($schema['mainEntity'])) {
            add_action('wp_head', function() use ($schema) {
                echo '<script type="application/ld+json">' . wp_json_encode($schema, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT) . '</script>';
            }, 5);
        }
    }

    /**
     * Render icon
     *
     * @param string $type Icon type.
     * @param array $settings Widget settings.
     * @param bool $is_active Whether the item is active.
     */
    private function render_icon($type, $settings, $is_active = false) {
        if ('custom' === $type) {
            $icon = $is_active ? $settings['custom_icon_open'] : $settings['custom_icon_closed'];
            \Elementor\Icons_Manager::render_icon($icon, [
                'aria-hidden' => 'true',
                'class' => 'aiq-faq-accordion__icon aiq-faq-accordion__icon--custom'
            ]);
            return;
        }

        $icon_class = 'aiq-faq-accordion__icon aiq-faq-accordion__icon--' . $type;
        echo '<span class="' . esc_attr($icon_class) . '" aria-hidden="true"></span>';
    }

    /**
     * Render widget output on the frontend.
     */
    protected function render() {
        $settings = $this->get_settings_for_display();
        $this->render_schema($settings);
        $widget_id = $this->get_id();

        if (empty($settings['faq_items'])) {
            return;
        }
        ?>
        <div class="aiq-faq-accordion" id="aiq-faq-accordion-<?php echo esc_attr($widget_id); ?>" data-default-open="<?php echo esc_attr($settings['default_open']); ?>">
            <?php if (!empty($settings['section_title'])) : ?>
                <h2 class="aiq-faq-accordion__title"><?php echo esc_html($settings['section_title']); ?></h2>
            <?php endif; ?>

            <?php if ('yes' === $settings['enable_search']) : ?>
                <div class="aiq-faq-accordion__search-wrapper">
                    <input
                        type="text"
                        class="aiq-faq-accordion__search"
                        placeholder="<?php echo esc_attr($settings['search_placeholder']); ?>"
                        aria-label="<?php echo esc_attr__('Search FAQs', 'aiqengage-child'); ?>"
                    >
                    <div class="aiq-faq-accordion__search-no-results" style="display: none;">
                        <?php echo esc_html($settings['search_no_results']); ?>
                    </div>
                </div>
            <?php endif; ?>

            <div class="aiq-faq-accordion__items">
                <?php foreach ($settings['faq_items'] as $index => $item) :
                    if (empty($item['question'])) {
                        continue;
                    }

                    $is_first = 0 === $index;
                    $is_active = ('first' === $settings['default_open'] && $is_first) || 'all' === $settings['default_open'];
                    $item_id = 'aiq-faq-item-' . $widget_id . '-' . $index;
                    $item_class = 'aiq-faq-accordion__item';

                    if ($is_active) {
                        $item_class .= ' is-active';
                    }
                ?>
                    <div class="<?php echo esc_attr($item_class); ?>" data-question="<?php echo esc_attr(wp_strip_all_tags($item['question'])); ?>">
                        <button
                            id="<?php echo esc_attr($item_id . '-question'); ?>"
                            class="aiq-faq-accordion__question"
                            aria-expanded="<?php echo esc_attr($is_active ? 'true' : 'false'); ?>"
                            aria-controls="<?php echo esc_attr($item_id . '-answer'); ?>"
                        >
                            <span class="aiq-faq-accordion__question-text"><?php echo esc_html($item['question']); ?></span>
                            <?php $this->render_icon($settings['icon_type'], $settings, $is_active); ?>
                        </button>
                        <div
                            id="<?php echo esc_attr($item_id . '-answer'); ?>"
                            class="aiq-faq-accordion__answer"
                            aria-labelledby="<?php echo esc_attr($item_id . '-question'); ?>"
                            <?php if (!$is_active) : ?>
                                hidden
                            <?php endif; ?>
                            role="region"
                        >
                            <?php echo wp_kses_post($item['answer']); ?>
                        </div>
                    </div>
                <?php endforeach; ?>
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
        if (settings.faq_items.length === 0) {
            return;
        }
        #>
        <div class="aiq-faq-accordion" id="aiq-faq-accordion-{{ view.getID() }}" data-default-open="{{ settings.default_open }}">
            <# if (settings.section_title) { #>
                <h2 class="aiq-faq-accordion__title">{{{ settings.section_title }}}</h2>
            <# } #>

            <# if ('yes' === settings.enable_search) { #>
                <div class="aiq-faq-accordion__search-wrapper">
                    <input
                        type="text"
                        class="aiq-faq-accordion__search"
                        placeholder="{{ settings.search_placeholder }}"
                        aria-label="<?php echo esc_attr__('Search FAQs', 'aiqengage-child'); ?>"
                    >
                    <div class="aiq-faq-accordion__search-no-results" style="display: none;">
                        {{{ settings.search_no_results }}}
                    </div>
                </div>
            <# } #>

            <div class="aiq-faq-accordion__items">
                <# _.each(settings.faq_items, function(item, index) {
                    if (!item.question) {
                        return;
                    }

                    var isFirst = 0 === index;
                    var isActive = ('first' === settings.default_open && isFirst) || 'all' === settings.default_open;
                    var itemId = 'aiq-faq-item-' + view.getID() + '-' + index;
                    var itemClass = 'aiq-faq-accordion__item';

                    if (isActive) {
                        itemClass += ' is-active';
                    }
                #>
                    <div class="{{ itemClass }}" data-question="{{ _.escape(item.question) }}">
                        <button
                            id="{{ itemId }}-question"
                            class="aiq-faq-accordion__question"
                            aria-expanded="{{ isActive ? 'true' : 'false' }}"
                            aria-controls="{{ itemId }}-answer"
                        >
                            <span class="aiq-faq-accordion__question-text">{{{ item.question }}}</span>
                            <# if ('custom' === settings.icon_type) { #>
                                <span class="aiq-faq-accordion__icon aiq-faq-accordion__icon--custom elementor-icon">
                                    <# if (isActive && settings.custom_icon_open.value) { #>
                                        <i class="{{ settings.custom_icon_open.value }}" aria-hidden="true"></i>
                                    <# } else if (!isActive && settings.custom_icon_closed.value) { #>
                                        <i class="{{ settings.custom_icon_closed.value }}" aria-hidden="true"></i>
                                    <# } #>
                                </span>
                            <# } else { #>
                                <span class="aiq-faq-accordion__icon aiq-faq-accordion__icon--{{ settings.icon_type }}" aria-hidden="true"></span>
                            <# } #>
                        </button>
                        <div
                            id="{{ itemId }}-answer"
                            class="aiq-faq-accordion__answer"
                            aria-labelledby="{{ itemId }}-question"
                            <# if (!isActive) { #>hidden<# } #>
                            role="region"
                        >
                            {{{ item.answer }}}
                        </div>
                    </div>
                <# }); #>
            </div>
        </div>
        <?php
    }
}
