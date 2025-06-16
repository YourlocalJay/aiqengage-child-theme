<?php
/**
 * Elementor Widgets for AIQEngage
 * 
 * @package AIQEngage-Child
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

/**
 * Value Proposition Widget
 * Displays feature cards in AIQEngage brand style
 */
class AIQEngage_Value_Prop_Widget extends \Elementor\Widget_Base {

    public function get_name() {
        return 'aiqengage-value-prop';
    }

    public function get_title() {
        return __('AIQ Value Proposition', 'aiqengage');
    }

    public function get_icon() {
        return 'eicon-bullet-list';
    }

    public function get_categories() {
        return ['aiqengage-elements'];
    }

    protected function register_controls() {
        // Content Tab
        $this->start_controls_section(
            'content_section',
            [
                'label' => __('Content', 'aiqengage'),
                'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'title',
            [
                'label' => __('Title', 'aiqengage'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => __('What Makes the Claude Vault Different?', 'aiqengage'),
            ]
        );
        
        $this->add_control(
            'title_alignment',
            [
                'label' => __('Title Alignment', 'aiqengage'),
                'type' => \Elementor\Controls_Manager::CHOOSE,
                'options' => [
                    'left' => [
                        'title' => __('Left', 'aiqengage'),
                        'icon' => 'eicon-text-align-left',
                    ],
                    'center' => [
                        'title' => __('Center', 'aiqengage'),
                        'icon' => 'eicon-text-align-center',
                    ],
                    'right' => [
                        'title' => __('Right', 'aiqengage'),
                        'icon' => 'eicon-text-align-right',
                    ],
                ],
                'default' => 'center',
                'toggle' => true,
                'selectors' => [
                    '{{WRAPPER}} .value-prop-title' => 'text-align: {{VALUE}};',
                ],
            ]
        );

        $repeater = new \Elementor\Repeater();

        $repeater->add_control(
            'feature_title',
            [
                'label' => __('Feature Title', 'aiqengage'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => __('Prompt Kits', 'aiqengage'),
            ]
        );

        $repeater->add_control(
            'feature_description',
            [
                'label' => __('Description', 'aiqengage'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => __('Pre-built flows for 37% faster results', 'aiqengage'),
            ]
        );

        $repeater->add_control(
            'feature_link',
            [
                'label' => __('Link', 'aiqengage'),
                'type' => \Elementor\Controls_Manager::URL,
                'placeholder' => __('https://your-link.com', 'aiqengage'),
                'show_external' => true,
                'default' => [
                    'url' => '',
                    'is_external' => false,
                    'nofollow' => false,
                ],
            ]
        );
        
        $repeater->add_control(
            'link_text',
            [
                'label' => __('Link Text', 'aiqengage'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => __('Learn More', 'aiqengage'),
                'condition' => [
                    'feature_link[url]!' => '',
                ],
            ]
        );

        $this->add_control(
            'features',
            [
                'label' => __('Features', 'aiqengage'),
                'type' => \Elementor\Controls_Manager::REPEATER,
                'fields' => $repeater->get_controls(),
                'default' => [
                    [
                        'feature_title' => __('Prompt Kits', 'aiqengage'),
                        'feature_description' => __('Pre-built flows for 37% faster results', 'aiqengage'),
                        'link_text' => __('View Kits', 'aiqengage'),
                    ],
                    [
                        'feature_title' => __('Tool Discounts', 'aiqengage'),
                        'feature_description' => __('Exclusive 40–60% partner deals', 'aiqengage'),
                        'link_text' => __('See Deals', 'aiqengage'),
                    ],
                    [
                        'feature_title' => __('Automation Systems', 'aiqengage'),
                        'feature_description' => __('Done-for-you traffic & conversion stacks', 'aiqengage'),
                        'link_text' => __('Explore Systems', 'aiqengage'),
                    ],
                ],
                'title_field' => '{{{ feature_title }}}',
            ]
        );
        
        $this->add_control(
            'columns',
            [
                'label' => __('Columns', 'aiqengage'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => '3',
                'options' => [
                    '1' => __('1', 'aiqengage'),
                    '2' => __('2', 'aiqengage'),
                    '3' => __('3', 'aiqengage'),
                    '4' => __('4', 'aiqengage'),
                ],
            ]
        );
        
        $this->add_control(
            'add_animation',
            [
                'label' => __('Add Animation', 'aiqengage'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => __('Yes', 'aiqengage'),
                'label_off' => __('No', 'aiqengage'),
                'return_value' => 'yes',
                'default' => 'yes',
            ]
        );
        
        $this->add_control(
            'add_neural_bg',
            [
                'label' => __('Add Neural Background', 'aiqengage'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => __('Yes', 'aiqengage'),
                'label_off' => __('No', 'aiqengage'),
                'return_value' => 'yes',
                'default' => 'yes',
            ]
        );

        $this->end_controls_section();

        // Style Tab
        $this->start_controls_section(
            'style_section',
            [
                'label' => __('Style', 'aiqengage'),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'title_color',
            [
                'label' => __('Title Color', 'aiqengage'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#E0D6FF',
                'selectors' => [
                    '{{WRAPPER}} .value-prop-title' => 'color: {{VALUE}}',
                ],
            ]
        );
        
        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'title_typography',
                'label' => __('Title Typography', 'aiqengage'),
                'selector' => '{{WRAPPER}} .value-prop-title',
            ]
        );

        $this->add_control(
            'card_bg_color',
            [
                'label' => __('Card Background', 'aiqengage'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#2A1958',
                'selectors' => [
                    '{{WRAPPER}} .feature-card' => 'background-color: {{VALUE}}',
                ],
            ]
        );
        
        $this->add_control(
            'card_border_color',
            [
                'label' => __('Card Border Color', 'aiqengage'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => 'rgba(156, 77, 255, 0.3)',
                'selectors' => [
                    '{{WRAPPER}} .feature-card' => 'border-color: {{VALUE}}',
                ],
            ]
        );
        
        $this->add_control(
            'feature_title_color',
            [
                'label' => __('Feature Title Color', 'aiqengage'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#9C4DFF',
                'selectors' => [
                    '{{WRAPPER}} .feature-card h3' => 'color: {{VALUE}}',
                ],
            ]
        );
        
        $this->add_control(
            'feature_text_color',
            [
            'feature_text_color',
            [
                'label' => __('Feature Text Color', 'aiqengage'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#E0D6FF',
                'selectors' => [
                    '{{WRAPPER}} .feature-card p' => 'color: {{VALUE}}',
                ],
            ]
        );
        
        $this->add_control(
            'link_color',
            [
                'label' => __('Link Color', 'aiqengage'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#9C4DFF',
                'selectors' => [
                    '{{WRAPPER}} .feature-card .card-link' => 'color: {{VALUE}}',
                ],
            ]
        );
        
        $this->add_control(
            'link_hover_color',
            [
                'label' => __('Link Hover Color', 'aiqengage'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#8E6BFF',
                'selectors' => [
                    '{{WRAPPER}} .feature-card .card-link:hover' => 'color: {{VALUE}}',
                ],
            ]
        );
        
        $this->add_control(
            'card_border_radius',
            [
                'label' => __('Card Border Radius', 'aiqengage'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px'],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 50,
                        'step' => 1,
                    ],
                ],
                'default' => [
                    'unit' => 'px',
                    'size' => 15,
                ],
                'selectors' => [
                    '{{WRAPPER}} .feature-card' => 'border-radius: {{SIZE}}{{UNIT}};',
                ],
            ]
        );
        
        $this->add_control(
            'card_padding',
            [
                'label' => __('Card Padding', 'aiqengage'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'default' => [
                    'top' => 1.5,
                    'right' => 1.5,
                    'bottom' => 1.5,
                    'left' => 1.5,
                    'unit' => 'rem',
                    'isLinked' => true,
                ],
                'selectors' => [
                    '{{WRAPPER}} .feature-card' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        
        $this->add_group_control(
            \Elementor\Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'card_box_shadow',
                'label' => __('Card Box Shadow', 'aiqengage'),
                'selector' => '{{WRAPPER}} .feature-card',
            ]
        );
        
        $this->add_control(
            'spacing_heading',
            [
                'label' => __('Spacing', 'aiqengage'),
                'type' => \Elementor\Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );
        
        $this->add_control(
            'column_gap',
            [
                'label' => __('Column Gap', 'aiqengage'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px', 'em', '%'],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 100,
                        'step' => 1,
                    ],
                    'em' => [
                        'min' => 0,
                        'max' => 10,
                        'step' => 0.1,
                    ],
                    '%' => [
                        'min' => 0,
                        'max' => 20,
                        'step' => 1,
                    ],
                ],
                'default' => [
                    'unit' => 'px',
                    'size' => 20,
                ],
                'selectors' => [
                    '{{WRAPPER}} .value-proposition-grid' => 'grid-column-gap: {{SIZE}}{{UNIT}};',
                ],
            ]
        );
        
        $this->add_control(
            'row_gap',
            [
                'label' => __('Row Gap', 'aiqengage'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px', 'em', '%'],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 100,
                        'step' => 1,
                    ],
                    'em' => [
                        'min' => 0,
                        'max' => 10,
                        'step' => 0.1,
                    ],
                    '%' => [
                        'min' => 0,
                        'max' => 20,
                        'step' => 1,
                    ],
                ],
                'default' => [
                    'unit' => 'px',
                    'size' => 30,
                ],
                'selectors' => [
                    '{{WRAPPER}} .value-proposition-grid' => 'grid-row-gap: {{SIZE}}{{UNIT}};',
                ],
            ]
        );
        
        $this->add_control(
            'title_margin_bottom',
            [
                'label' => __('Title Bottom Margin', 'aiqengage'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px', 'em', '%'],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 100,
                        'step' => 1,
                    ],
                    'em' => [
                        'min' => 0,
                        'max' => 10,
                        'step' => 0.1,
                    ],
                    '%' => [
                        'min' => 0,
                        'max' => 20,
                        'step' => 1,
                    ],
                ],
                'default' => [
                    'unit' => 'px',
                    'size' => 40,
                ],
                'selectors' => [
                    '{{WRAPPER}} .value-prop-title' => 'margin-bottom: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();
        
        // Animation Tab
        $this->start_controls_section(
            'animation_section',
            [
                'label' => __('Animation', 'aiqengage'),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
                'condition' => [
                    'add_animation' => 'yes',
                ],
            ]
        );
        
        $this->add_control(
            'animation_duration',
            [
                'label' => __('Animation Duration', 'aiqengage'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['s'],
                'range' => [
                    's' => [
                        'min' => 0.1,
                        'max' => 2,
                        'step' => 0.1,
                    ],
                ],
                'default' => [
                    'unit' => 's',
                    'size' => 0.5,
                ],
                'selectors' => [
                    '{{WRAPPER}} .feature-card.animate' => 'animation-duration: {{SIZE}}{{UNIT}};',
                ],
            ]
        );
        
        $this->add_control(
            'animation_delay',
            [
                'label' => __('Animation Delay Between Cards', 'aiqengage'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['s'],
                'range' => [
                    's' => [
                        'min' => 0,
                        'max' => 1,
                        'step' => 0.05,
                    ],
                ],
                'default' => [
                    'unit' => 's',
                    'size' => 0.15,
                ],
            ]
        );
        
        $this->end_controls_section();
    }

    protected function render() {
        $settings = $this->get_settings_for_display();
        $columns = $settings['columns'];
        $add_animation = $settings['add_animation'] === 'yes';
        $add_neural_bg = $settings['add_neural_bg'] === 'yes';
        $animation_delay = $settings['animation_delay']['size'] ?? 0.15;
        
        $section_classes = ['value-proposition'];
        if ($add_neural_bg) {
            $section_classes[] = 'add-neural-bg';
        }
        ?>
        <div class="<?php echo esc_attr(implode(' ', $section_classes)); ?>">
            <h2 class="value-prop-title"><?php echo esc_html($settings['title']); ?></h2>
            
            <div class="value-proposition-grid" style="display: grid; grid-template-columns: repeat(<?php echo esc_attr($columns); ?>, 1fr);">
                <?php 
                $delay = 0;
                foreach ($settings['features'] as $index => $feature): 
                    $card_classes = ['feature-card'];
                    if ($add_animation) {
                        $card_classes[] = 'elementor-invisible';
                        $card_style = 'animation-delay: ' . esc_attr($delay) . 's;';
                        $delay += $animation_delay;
                    } else {
                        $card_style = '';
                    }
                    
                    $this->add_render_attribute('feature-' . $index, 'class', $card_classes);
                    $this->add_render_attribute('feature-' . $index, 'style', $card_style);
                    
                    if ($add_animation) {
                        $this->add_render_attribute('feature-' . $index, 'data-animation', 'fadeInUp');
                    }
                ?>
                    <div <?php echo $this->get_render_attribute_string('feature-' . $index); ?>>
                        <h3><?php echo esc_html($feature['feature_title']); ?></h3>
                        <p><?php echo esc_html($feature['feature_description']); ?></p>
                        <?php if (!empty($feature['feature_link']['url'])): ?>
                            <a href="<?php echo esc_url($feature['feature_link']['url']); ?>" 
                               class="card-link" 
                               <?php echo $feature['feature_link']['is_external'] ? 'target="_blank"' : ''; ?>
                               <?php echo $feature['feature_link']['nofollow'] ? 'rel="nofollow"' : ''; ?>>
                                <?php echo esc_html($feature['link_text'] ?: __('Learn More', 'aiqengage')); ?>
                            </a>
                        <?php endif; ?>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
        
        <?php if ($add_animation): ?>
        <script>
            jQuery(document).ready(function($) {
                // Animation for feature cards
                const animateCards = () => {
                    $('.elementor-element-<?php echo esc_js($this->get_id()); ?> .feature-card.elementor-invisible').each(function() {
                        const $card = $(this);
                        const observer = new IntersectionObserver((entries) => {
                            entries.forEach(entry => {
                                if (entry.isIntersecting) {
                                    $card.removeClass('elementor-invisible').addClass('animate');
                                    observer.unobserve(entry.target);
                                }
                            });
                        }, { threshold: 0.1 });
                        
                        observer.observe(this);
                    });
                };
                
                // Initialize animations
                animateCards();
            });
        </script>
        <?php endif; ?>
        <?php
    }
    
    protected function content_template() {
        ?>
        <#
        var columns = settings.columns;
        var addAnimation = settings.add_animation === 'yes';
        var addNeuralBg = settings.add_neural_bg === 'yes';
        var animationDelay = settings.animation_delay ? settings.animation_delay.size : 0.15;
        
        var sectionClasses = ['value-proposition'];
        if (addNeuralBg) {
            sectionClasses.push('add-neural-bg');
        }
        #>
        <div class="{{ sectionClasses.join(' ') }}">
            <h2 class="value-prop-title">{{{ settings.title }}}</h2>
            
            <div class="value-proposition-grid" style="display: grid; grid-template-columns: repeat({{ columns }}, 1fr);">
                <# 
                var delay = 0;
                _.each(settings.features, function(feature, index) { 
                    var cardClasses = ['feature-card'];
                    var cardStyle = '';
                    
                    if (addAnimation) {
                        cardClasses.push('elementor-invisible');
                        cardStyle = 'animation-delay: ' + delay + 's;';
                        delay += animationDelay;
                    }
                #>
                    <div class="{{ cardClasses.join(' ') }}" style="{{ cardStyle }}" data-animation="fadeInUp">
                        <h3>{{{ feature.feature_title }}}</h3>
                        <p>{{{ feature.feature_description }}}</p>
                        <# if (feature.feature_link && feature.feature_link.url) { #>
                            <a href="{{ feature.feature_link.url }}" 
                               class="card-link" 
                               <# if (feature.feature_link.is_external) { #>target="_blank"<# } #>
                               <# if (feature.feature_link.nofollow) { #>rel="nofollow"<# } #>>
                                {{{ feature.link_text || 'Learn More' }}}
                            </a>
                        <# } #>
                    </div>
                <# }); #>
            </div>
        </div>
        <?php
    }
}

/**
 * Prompt Card Widget
 * Displays prompts in AIQEngage style
 */
class AIQEngage_Prompt_Card_Widget extends \Elementor\Widget_Base {

    public function get_name() {
        return 'aiqengage-prompt-card';
    }

    public function get_title() {
        return __('AIQ Prompt Card', 'aiqengage');
    }

    public function get_icon() {
        return 'eicon-code';
    }

    public function get_categories() {
        return ['aiqengage-elements'];
    }

    protected function register_controls() {
        // Content Tab
        $this->start_controls_section(
            'content_section',
            [
                'label' => __('Content', 'aiqengage'),
                'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'prompt_title',
            [
                'label' => __('Prompt Title', 'aiqengage'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => __('Reddit Authority Builder', 'aiqengage'),
            ]
        );

        $this->add_control(
            'category',
            [
                'label' => __('Category', 'aiqengage'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => __('Reddit', 'aiqengage'),
            ]
        );

        $this->add_control(
            'prompt_description',
            [
                'label' => __('Description', 'aiqengage'),
                'type' => \Elementor\Controls_Manager::TEXTAREA,
                'default' => __('Establish expertise and drive traffic with authentic contributions', 'aiqengage'),
                'rows' => 3,
            ]
        );

        $this->add_control(
            'prompt_content',
            [
                'label' => __('Prompt Content', 'aiqengage'),
                'type' => \Elementor\Controls_Manager::TEXTAREA,
                'default' => "Create 5 authentic Reddit comments for r/[SUBREDDIT] that:\n- Address common [TOPIC] problems with personal experience\n- Include specific details that show deep knowledge\n- End with actionable advice (no links)\n- Sound like a helpful community member, not a marketer\n- Range from 75-150 words each\n- Use casual language with occasional typos for authenticity",
                'rows' => 10,
            ]
        );

        $this->add_control(
            'show_results',
            [
                'label' => __('Show Results Section', 'aiqengage'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => __('Yes', 'aiqengage'),
                'label_off' => __('No', 'aiqengage'),
                'return_value' => 'yes',
                'default' => 'no',
            ]
        );

        $this->add_control(
            'results_content',
            [
                'label' => __('Results Content', 'aiqengage'),
                'type' => \Elementor\Controls_Manager::TEXTAREA,
                'default' => __('Sample output will appear here...', 'aiqengage'),
                'rows' => 6,
                'condition' => [
                    'show_results' => 'yes',
                ],
            ]
        );
        
        $this->add_control(
            'prompt_id',
            [
                'label' => __('Prompt ID (for tracking)', 'aiqengage'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => __('reddit-authority-builder', 'aiqengage'),
            ]
        );
        
        $this->add_control(
            'collapsed_by_default',
            [
                'label' => __('Collapsed By Default', 'aiqengage'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => __('Yes', 'aiqengage'),
                'label_off' => __('No', 'aiqengage'),
                'return_value' => 'yes',
                'default' => 'yes',
            ]
        );
        
        $this->add_control(
            'is_pro',
            [
                'label' => __('Pro Content', 'aiqengage'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => __('Yes', 'aiqengage'),
                'label_off' => __('No', 'aiqengage'),
                'return_value' => 'yes',
                'default' => 'no',
            ]
        );

        $this->end_controls_section();

        // Style Tab
        $this->start_controls_section(
            'style_section',
            [
                'label' => __('Style', 'aiqengage'),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'card_bg_color',
            [
                'label' => __('Card Background', 'aiqengage'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#2A1958',
                'selectors' => [
                    '{{WRAPPER}} .prompt-card' => 'background-color: {{VALUE}}',
                ],
            ]
        );
        
        $this->add_control(
            'prompt_bg_color',
            [
                'label' => __('Prompt Content Background', 'aiqengage'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#1A0938',
                'selectors' => [
                    '{{WRAPPER}} .prompt-content' => 'background-color: {{VALUE}}',
                ],
            ]
        );
        
        $this->add_control(
            'category_bg_color',
            [
                'label' => __('Category Badge Background', 'aiqengage'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => 'rgba(126, 87, 194, 0.2)',
                'selectors' => [
                    '{{WRAPPER}} .category-badge' => 'background-color: {{VALUE}}',
                ],
            ]
        );
        
        $this->add_control(
            'button_bg_color',
            [
                'label' => __('Button Background', 'aiqengage'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => 'rgba(156, 77, 255, 0.2)',
                'selectors' => [
                    '{{WRAPPER}} .toggle-button' => 'background-color: {{VALUE}}',
                ],
            ]
        );
        
        $this->add_control(
            'button_hover_bg_color',
            [
                'label' => __('Button Hover Background', 'aiqengage'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => 'rgba(156, 77, 255, 0.4)',
                'selectors' => [
                    '{{WRAPPER}} .toggle-button:hover' => 'background-color: {{VALUE}}',
                ],
            ]
        );

        $this->end_controls_section();
    }

    protected function render() {
        $settings = $this->get_settings_for_display();
        $collapsed = $settings['collapsed_by_default'] === 'yes';
        $is_pro = $settings['is_pro'] === 'yes';
        $show_results = $settings['show_results'] === 'yes';
        $prompt_id = !empty($settings['prompt_id']) ? $settings['prompt_id'] : 'prompt-' . $this->get_id();
        
        $card_attrs = [
            'class' => 'prompt-card',
            'data-prompt-id' => $prompt_id,
            'data-category' => $settings['category'],
        ];
        ?>
        <div <?php echo $this->render_html_attributes($card_attrs); ?>>
            <?php if ($is_pro): ?>
                <span class="pro-badge">Pro</span>
            <?php endif; ?>
            
            <button class="copy-button" aria-label="<?php echo esc_attr__('Copy prompt', 'aiqengage'); ?>">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M20 9H11C9.89543 9 9 9.89543 9 11V20C9 21.1046 9.89543 22 11 22H20C21.1046 22 22 21.1046 22 20V11C22 9.89543 21.1046 9 20 9Z" stroke="#E0D6FF" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    <path d="M5 15H4C3.46957 15 2.96086 14.7893 2.58579 14.4142C2.21071 14.0391 2 13.5304 2 13V4C2 3.46957 2.21071 2.96086 2.58579 2.58579C2.96086 2.21071 3.46957 2 4 2H13C13.5304 2 14.0391 2.21071 14.4142 2.58579C14.7893 2.96086 15 3.46957 15 4V5" stroke="#E0D6FF" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
            </button>
            
            <span class="category-badge"><?php echo esc_html($settings['category']); ?></span>
            <h3><?php echo esc_html($settings['prompt_title']); ?></h3>
            <p><?php echo esc_html($settings['prompt_description']); ?></p>
            
            <pre class="prompt-content <?php echo $collapsed ? 'collapsed' : ''; ?>"><?php echo esc_html($settings['prompt_content']); ?></pre>
            
            <button class="toggle-button">
                <?php echo $collapsed ? esc_html__('Show Prompt', 'aiqengage') : esc_html__('Hide Prompt', 'aiqengage'); ?>
            </button>
            
            <?php if ($show_results): ?>
                <div class="results-section" style="margin-top: 20px;">
                    <button class="toggle-button results-toggle"><?php echo esc_html__('See Results', 'aiqengage'); ?></button>
                    <div class="results-preview hidden" style="margin-top: 10px; padding: 10px; background: rgba(156, 77, 255, 0.1); border-radius: 8px;">
                        <?php echo wp_kses_post($settings['results_content']); ?>
                    </div>
                </div>
            <?php endif; ?>
        </div>
        
        <script>
            jQuery(document).ready(function($) {
                // Toggle button functionality
                $('.elementor-element-<?php echo esc_js($this->get_id()); ?> .toggle-button').on('click', function() {
                    if ($(this).hasClass('results-toggle')) {
                        const $results = $(this).next('.results-preview');
                        $results.toggleClass('hidden');
                        $(this).text($results.hasClass('hidden') ? '<?php echo esc_js(__('See Results', 'aiqengage')); ?>' : '<?php echo esc_js(__('Hide Results', 'aiqengage')); ?>');
                    } else {
                        const $content = $(this).prev('.prompt-content');
                        $content.toggleClass('collapsed');
                        $(this).text($content.hasClass('collapsed') ? '<?php echo esc_js(__('Show Prompt', 'aiqengage')); ?>' : '<?php echo esc_js(__('Hide Prompt', 'aiqengage')); ?>');
                    }
                });
                
                // Copy button functionality
                $('.elementor-element-<?php echo esc_js($this->get_id()); ?> .copy-button').on('click', function() {
                    const $card = $(this).closest('.prompt-card');
                    const promptText = $card.find('.prompt-content').text();
                    
                    if (navigator.clipboard) {
                        navigator.clipboard.writeText(promptText).then(() => {
                            const $button = $(this);
                            $button.addClass('copied');
                            setTimeout(() => {
                                $button.removeClass('copied');
                            }, 2000);
                        });
                    } else {
                        // Fallback
                        const $temp = $('<textarea>');
                        $('body').append($temp);
                        $temp.val(promptText).select();
                        document.execCommand('copy');
                        $temp.remove();
                        
                        const $button = $(this);
                        $button.addClass('copied');
                        setTimeout(() => {
                            $button.removeClass('copied');
                        }, 2000);
                    }
                });
            });
        </script>
        <?php
    }
    
    private function render_html_attributes($attributes) {
        $html = '';
        
        foreach ($attributes as $key => $value) {
            $html .= ' ' . $key . '="' . esc_attr($value) . '"';
        }
        
        return $html;
    }
}

/**
 * Metric Badge Widget
 * Displays metric badges with animation
 */
class AIQEngage_Metric_Badge_Widget extends \Elementor\Widget_Base {

    public function get_name() {
        return 'aiqengage-metric-badge';
    }

    public function get_title() {
        return __('AIQ Metric Badge', 'aiqengage');
    }

    public function get_icon() {
        return 'eicon-counter';
    }

    public function get_categories() {
        return ['aiqengage-elements'];
    }

    protected function register_controls() {
        // Content Tab
        $this->start_controls_section(
            'content_section',
            [
                'label' => __('Content', 'aiqengage'),
                'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'value',
            [
                'label' => __('Value', 'aiqengage'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => '387',
            ]
        );
        
        $this->add_control(
            'symbol',
            [
                'label' => __('Symbol', 'aiqengage'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => '%',
            ]
        );

        $this->add_control(
            'label',
            [
                'label' => __('Label', 'aiqengage'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => __('Average ROI', 'aiqengage'),
            ]
        );
        
        $this->add_control(
            'show_trend',
            [
                'label' => __('Show Trend', 'aiqengage'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => __('Yes', 'aiqengage'),
                'label_off' => __('No', 'aiqengage'),
                'return_value' => 'yes',
                'default' => 'yes',
            ]
        );
        
        $this->add_control(
            'trend_direction',
            [
                'label' => __('Trend Direction', 'aiqengage'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => 'up',
                'options' => [
                    'up' => __('Up', 'aiqengage'),
                    'down' => __('Down', 'aiqengage'),
                ],
                'condition' => [
                    'show_trend' => 'yes',
                ],
            ]
        );
        
        $this->add_control(
            'trend_value',
            [
                'label' => __('Trend Value', 'aiqengage'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => '12%',
                'condition' => [
                    'show_trend' => 'yes',
                ],
            ]
        );
        
        $this->add_control(
            'animate_counter',
            [
                'label' => __('Animate Counter', 'aiqengage'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => __('Yes', 'aiqengage'),
                'label_off' => __('No', 'aiqengage'),
                'return_value' => 'yes',
                'default' => 'yes',
            ]
        );

        $this->end_controls_section();

        // Style Tab
        $this->start_controls_section(
            'style_section',
            [
                'label' => __('Style', 'aiqengage'),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'badge_bg_color',
            [
                'label' => __('Badge Background', 'aiqengage'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#2A1958',
                'selectors' => [
                    '{{WRAPPER}} .metric-badge' => 'background-color: {{VALUE}}',
                ],
            ]
        );
        
        $this->add_control(
            'value_color',
            [
                'label' => __('Value Color', 'aiqengage'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#E0D6FF',
                'selectors' => [
                    '{{WRAPPER}} .metric-value' => 'color: {{VALUE}}',
                ],
            ]
        );
        
        $this->add_control(
            'label_color',
            [
                'label' => __('Label Color', 'aiqengage'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => 'rgba(224, 214, 255, 0.8)',
                'selectors' => [
                    '{{WRAPPER}} .metric-label' => 'color: {{VALUE}}',
                ],
            ]
        );
        
        $this->add_control(
            'up_trend_color',
            [
                'label' => __('Up Trend Color', 'aiqengage'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#4CAF50',
                'selectors' => [
                    '{{WRAPPER}} .trend-indicator.up' => 'color: {{VALUE}}',
                ],
            ]
        );
        
        $this->add_control(
            'down_trend_color',
            [
                'label' => __('Down Trend Color', 'aiqengage'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#F44336',
                'selectors' => [
                    '{{WRAPPER}} .trend-indicator.down' => 'color: {{VALUE}}',
                ],
            ]
        );
        
        $this->add_control(
            'border_radius',
            [
                'label' => __('Border Radius', 'aiqengage'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px'],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 50,
                        'step' => 1,
                    ],
                ],
                'default' => [
                    'unit' => 'px',
                    'size' => 15,
                ],
                'selectors' => [
                    '{{WRAPPER}} .metric-badge' => 'border-radius: {{SIZE}}{{UNIT}};',
                ],
            ]
        );
        
        $this->add_control(
            'padding',
            [
                'label' => __('Padding', 'aiqengage'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'default' => [
                    'top' => 1.5,
                    'right' => 1.5,
                    'bottom' => 1.5,
                    'left' => 1.5,
                    'unit' => 'rem',
                    'isLinked' => true,
                ],
                'selectors' => [
                    '{{WRAPPER}} .metric-badge' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        
        $this->add_group_control(
            \Elementor\Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'box_shadow',
                'label' => __('Box Shadow', 'aiqengage'),
                'selector' => '{{WRAPPER}} .metric-badge',
            ]
        );

        $this->end_controls_section();
    }

    protected function render() {
        $settings = $this->get_settings_for_display();
        $animate = $settings['animate_counter'] === 'yes';
        $show_trend = $settings['show_trend'] === 'yes';
        $trend_direction = $settings['trend_direction'];
        ?>
        <div class="metric-badge">
            <div class="metric-value">
                <?php if ($animate): ?>
                <span class="counter-value" data-value="<?php echo esc_attr($settings['value']); ?>">0</span>
                <?php else: ?>
                <span><?php echo esc_html($settings['value']); ?></span>
                <?php endif; ?>
                <?php if ($settings['symbol']): ?>
                <span class="value-symbol"><?php echo esc_html($settings['symbol']); ?></span>
                <?php endif; ?>
            </div>
            
            <div class="metric-label"><?php echo esc_html($settings['label']); ?></div>
            
            <?php if ($show_trend): ?>
            <div class="trend-indicator <?php echo esc_attr($trend_direction); ?>">
                <span class="trend-arrow"><?php echo $trend_direction === 'up' ? '↑' : '↓'; ?></span>
                <span class="trend-value"><?php echo esc_html($settings['trend_value']); ?></span>
            </div>
            <?php endif; ?>
        </div>
        
        <?php if ($animate): ?>
        <script>
            jQuery(document).ready(function($) {
                // Counter animation
                const $counterValue = $('.elementor-element-<?php echo esc_js($this->get_id()); ?> .counter-value');
                const finalValue = parseInt($counterValue.data('value'));
                
                const observer = new IntersectionObserver((entries) => {
                    entries.forEach(entry => {
                        if (entry.isIntersecting) {
                            // Animate counter when visible
                            $({ countNum: 0 }).animate(
                                { countNum: finalValue },
                                {
                                    duration: 1500,
                                    easing: 'swing',
                                    step: function() {
                                        $counterValue.text(Math.floor(this.countNum));
                                    },
                                    complete: function() {
                                        $counterValue.text(finalValue);
                                    }
                                }
                            );
                            
                            observer.unobserve(entry.target);
                        }
                    });
                }, { threshold: 0.1 });
                
                observer.observe($counterValue[0]);
            });
        </script>
        <?php endif; ?>
        <?php
    }
}

// Register all widgets
function register_aiqengage_widgets($widgets_manager) {
    $widgets_manager->register(new AIQEngage_Value_Prop_Widget());
    $widgets_manager->register(new AIQEngage_Prompt_Card_Widget());
    $widgets_manager->register(new AIQEngage_Metric_Badge_Widget());
}
add_action('elementor/widgets/register', 'register_aiqengage_widgets');
