<?php
/**
 * Value Proposition Widget for AIQEngage
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
        $widget_id = $this->get_id();
        
        $section_classes = ['value-proposition'];
        if ($add_neural_bg) {
            $section_classes[] = 'add-neural-bg';
        }
        
        // Add data attributes for JavaScript initialization
        $this->add_render_attribute('wrapper', 'class', $section_classes);
        $this->add_render_attribute('wrapper', 'data-widget-id', $widget_id);
        $this->add_render_attribute('wrapper', 'data-animation', $add_animation ? 'true' : 'false');
        $this->add_render_attribute('wrapper', 'data-animation-delay', $animation_delay);
        ?>
        <div <?php echo $this->get_render_attribute_string('wrapper'); ?>>
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
        <div class="{{ sectionClasses.join(' ') }}" 
             data-widget-id="{{ id }}" 
             data-animation="{{ addAnimation ? 'true' : 'false' }}" 
             data-animation-delay="{{ animationDelay }}">
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
