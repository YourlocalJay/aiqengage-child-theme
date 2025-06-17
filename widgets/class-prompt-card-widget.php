<?php
/**
 * AIQEngage Prompt Card Grid Widget
 * Version: 1.0.0
 */
namespace AIQEngage\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Repeater;

class Prompt_Card_Grid_Widget extends Widget_Base {

    public function get_name() {
        return 'aiq-prompt-card-grid';
    }

    public function get_title() {
        return __('Prompt Card Grid', 'aiqengage');
    }

    public function get_icon() {
        return 'eicon-code';
    }

    public function get_categories() {
        return ['aiqengage'];
    }

    public function get_keywords() {
        return ['prompt', 'claude', 'card', 'grid', 'ai', 'template'];
    }

    public function get_script_depends() {
        return ['aiq-prompt-card-js'];
    }

    public function get_style_depends() {
        return ['aiq-prompt-card-css'];
    }

    protected function register_controls() {
        // Content Tab
        $this->start_controls_section(
            'content_section',
            [
                'label' => __('Content', 'aiqengage'),
                'tab' => Controls_Manager::TAB_CONTENT,
            ]
        );

        $repeater = new Repeater();

        $repeater->add_control(
            'title',
            [
                'label' => __('Prompt Title', 'aiqengage'),
                'type' => Controls_Manager::TEXT,
                'default' => __('Prompt Title', 'aiqengage'),
                'label_block' => true,
            ]
        );

        $repeater->add_control(
            'category',
            [
                'label' => __('Category', 'aiqengage'),
                'type' => Controls_Manager::SELECT,
                'options' => [
                    'reddit' => __('Reddit', 'aiqengage'),
                    'email' => __('Email', 'aiqengage'),
                    'landing-page' => __('Landing Page', 'aiqengage'),
                    'youtube' => __('YouTube', 'aiqengage'),
                    'product-review' => __('Product Review', 'aiqengage'),
                    'content' => __('Content', 'aiqengage'),
                ],
                'default' => 'reddit',
            ]
        );

        $repeater->add_control(
            'description',
            [
                'label' => __('Description', 'aiqengage'),
                'type' => Controls_Manager::TEXTAREA,
                'default' => __('A brief description of what this prompt does.', 'aiqengage'),
                'rows' => 3,
            ]
        );

        $repeater->add_control(
            'prompt_content',
            [
                'label' => __('Prompt Content', 'aiqengage'),
                'type' => Controls_Manager::CODE,
                'language' => 'text',
                'rows' => 10,
                'default' => __("Create 5 authentic Reddit comments for r/[SUBREDDIT] that:\n- Address common [TOPIC] problems with personal experience\n- Include specific details that show deep knowledge\n- End with actionable advice (no links)\n- Sound like a helpful community member, not a marketer\n- Range from 75-150 words each\n- Use casual language with occasional typos for authenticity", 'aiqengage'),
            ]
        );

        $repeater->add_control(
            'is_pro',
            [
                'label' => __('Pro Content', 'aiqengage'),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => __('Yes', 'aiqengage'),
                'label_off' => __('No', 'aiqengage'),
                'return_value' => 'yes',
                'default' => 'no',
            ]
        );

        $repeater->add_control(
            'show_results',
            [
                'label' => __('Show Results Example', 'aiqengage'),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => __('Show', 'aiqengage'),
                'label_off' => __('Hide', 'aiqengage'),
                'return_value' => 'yes',
                'default' => 'no',
            ]
        );

        $repeater->add_control(
            'results_content',
            [
                'label' => __('Results Example', 'aiqengage'),
                'type' => Controls_Manager::TEXTAREA,
                'rows' => 5,
                'default' => __('Example output will appear here...', 'aiqengage'),
                'condition' => [
                    'show_results' => 'yes',
                ],
            ]
        );

        $this->add_control(
            'prompts',
            [
                'label' => __('Prompts', 'aiqengage'),
                'type' => Controls_Manager::REPEATER,
                'fields' => $repeater->get_controls(),
                'default' => [
                    [
                        'title' => __('Reddit Authority Builder', 'aiqengage'),
                        'category' => 'reddit',
                        'description' => __('Establish expertise and drive traffic with authentic contributions', 'aiqengage'),
                        'prompt_content' => __("Create 5 authentic Reddit comments for r/[SUBREDDIT] that:\n- Address common [TOPIC] problems with personal experience\n- Include specific details that show deep knowledge\n- End with actionable advice (no links)\n- Sound like a helpful community member, not a marketer\n- Range from 75-150 words each\n- Use casual language with occasional typos for authenticity", 'aiqengage'),
                        'is_pro' => 'no',
                        'show_results' => 'yes',
                        'results_content' => __('u/techguy437: "Been dealing with poor WiFi coverage for years in my 2-story house. Tried everything from expensive routers to signal boosters with mixed results. What finally worked was a mesh network system (went with TP-Link Deco after researching). Placed one unit downstairs, one upstairs and one in the dead zone. Took about 30 min to set up through the app, and now I get 200+ Mbps everywhere. The key is placement - avoid putting them near appliances or inside cabinets. If you\'re still having issues, try changing the channel settings in your router admin page. Most routers default to crowded channels."', 'aiqengage'),
                    ],
                    [
                        'title' => __('Email Welcome Sequence', 'aiqengage'),
                        'category' => 'email',
                        'description' => __('Create a warm, engaging welcome series for new subscribers', 'aiqengage'),
                        'prompt_content' => __("Write a 5-email welcome sequence for [BUSINESS_TYPE] that:\n- Introduces the brand personality and mission\n- Delivers immediate value in each email\n- Naturally builds towards a soft pitch\n- Includes subject lines with 40%+ open rates\n- Has clear, single-focus CTAs\n- Uses a conversational, friendly tone\n\nBusiness details:\n[PROVIDE_DETAILS]", 'aiqengage'),
                        'is_pro' => 'yes',
                        'show_results' => 'no',
                    ],
                ],
                'title_field' => '{{{ title }}}',
            ]
        );

        $this->add_control(
            'columns',
            [
                'label' => __('Columns', 'aiqengage'),
                'type' => Controls_Manager::SELECT,
                'options' => [
                    '1' => '1',
                    '2' => '2',
                    '3' => '3',
                    '4' => '4',
                ],
                'default' => '3',
                'selectors' => [
                    '{{WRAPPER}} .aiq-prompt-grid' => 'grid-template-columns: repeat({{VALUE}}, 1fr);',
                ],
            ]
        );

        $this->add_control(
            'pro_message',
            [
                'label' => __('Pro Message', 'aiqengage'),
                'type' => Controls_Manager::TEXT,
                'default' => __('🔒 Unlock in Vault Pro', 'aiqengage'),
                'label_block' => true,
            ]
        );

        $this->add_control(
            'pro_url',
            [
                'label' => __('Pro URL', 'aiqengage'),
                'type' => Controls_Manager::URL,
                'placeholder' => __('https://aiqengage.com/vault-pro', 'aiqengage'),
                'default' => [
                    'url' => '#',
                ],
            ]
        );

        $this->add_control(
            'enable_filter',
            [
                'label' => __('Enable Category Filter', 'aiqengage'),
                'type' => Controls_Manager::SWITCHER,
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
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'card_background',
            [
                'label' => __('Card Background', 'aiqengage'),
                'type' => Controls_Manager::COLOR,
                'default' => '#2A1958',
                'selectors' => [
                    '{{WRAPPER}} .aiq-prompt-card' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'text_color',
            [
                'label' => __('Text Color', 'aiqengage'),
                'type' => Controls_Manager::COLOR,
                'default' => '#E0D6FF',
                'selectors' => [
                    '{{WRAPPER}} .aiq-prompt-card' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .aiq-prompt-card-title' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'accent_color',
            [
                'label' => __('Accent Color', 'aiqengage'),
                'type' => Controls_Manager::COLOR,
                'default' => '#9C4DFF',
                'selectors' => [
                    '{{WRAPPER}} .aiq-prompt-card-category' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .aiq-prompt-card-toggle-btn' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .aiq-prompt-card-copy' => 'background-color: {{VALUE}};',
                    '{{WRAPPER}} .aiq-category-filter button.active' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'pro_badge_color',
            [
                'label' => __('Pro Badge Color', 'aiqengage'),
                'type' => Controls_Manager::COLOR,
                'default' => '#FFD700',
                'selectors' => [
                    '{{WRAPPER}} .aiq-prompt-pro-badge' => 'color: #1A0938; background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'title_typography',
                'label' => __('Title Typography', 'aiqengage'),
                'selector' => '{{WRAPPER}} .aiq-prompt-card-title',
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'description_typography',
                'label' => __('Description Typography', 'aiqengage'),
                'selector' => '{{WRAPPER}} .aiq-prompt-card-description',
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'prompt_typography',
                'label' => __('Prompt Typography', 'aiqengage'),
                'selector' => '{{WRAPPER}} .aiq-prompt-card-content',
                'fields_options' => [
                    'font_family' => [
                        'default' => 'Courier New',
                    ],
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => 'card_border',
                'label' => __('Card Border', 'aiqengage'),
                'selector' => '{{WRAPPER}} .aiq-prompt-card',
                'fields_options' => [
                    'border' => [
                        'default' => 'solid',
                    ],
                    'width' => [
                        'default' => [
                            'top' => 1,
                            'right' => 1,
                            'bottom' => 1,
                            'left' => 1,
                            'isLinked' => true,
                        ],
                    ],
                    'color' => [
                        'default' => 'rgba(156, 77, 255, 0.3)',
                    ],
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'card_box_shadow',
                'label' => __('Card Box Shadow', 'aiqengage'),
                'selector' => '{{WRAPPER}} .aiq-prompt-card',
            ]
        );

        $this->add_control(
            'card_border_radius',
            [
                'label' => __('Border Radius', 'aiqengage'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'default' => [
                    'top' => 15,
                    'right' => 15,
                    'bottom' => 15,
                    'left' => 15,
                    'unit' => 'px',
                    'isLinked' => true,
                ],
                'selectors' => [
                    '{{WRAPPER}} .aiq-prompt-card' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'card_padding',
            [
                'label' => __('Card Padding', 'aiqengage'),
                'type' => Controls_Manager::DIMENSIONS,
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
                    '{{WRAPPER}} .aiq-prompt-card' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'grid_gap',
            [
                'label' => __('Grid Gap', 'aiqengage'),
                'type' => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 100,
                        'step' => 1,
                    ],
                ],
                'default' => [
                    'unit' => 'px',
                    'size' => 24,
                ],
                'selectors' => [
                    '{{WRAPPER}} .aiq-prompt-grid' => 'gap: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();

        // Filter Style Tab
        $this->start_controls_section(
            'filter_style_section',
            [
                'label' => __('Filter Style', 'aiqengage'),
                'tab' => Controls_Manager::TAB_STYLE,
                'condition' => [
                    'enable_filter' => 'yes',
                ],
            ]
        );

        $this->add_control(
            'filter_spacing',
            [
                'label' => __('Filter Spacing', 'aiqengage'),
                'type' => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 100,
                        'step' => 1,
                    ],
                ],
                'default' => [
                    'unit' => 'px',
                    'size' => 40,
                ],
                'selectors' => [
                    '{{WRAPPER}} .aiq-category-filter' => 'margin-bottom: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'filter_typography',
                'label' => __('Filter Typography', 'aiqengage'),
                'selector' => '{{WRAPPER}} .aiq-category-filter button',
            ]
        );

        $this->add_control(
            'filter_button_padding',
            [
                'label' => __('Button Padding', 'aiqengage'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em'],
                'default' => [
                    'top' => 8,
                    'right' => 16,
                    'bottom' => 8,
                    'left' => 16,
                    'unit' => 'px',
                    'isLinked' => false,
                ],
                'selectors' => [
                    '{{WRAPPER}} .aiq-category-filter button' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'filter_button_radius',
            [
                'label' => __('Button Radius', 'aiqengage'),
                'type' => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 50,
                        'step' => 1,
                    ],
                ],
                'default' => [
                    'unit' => 'px',
                    'size' => 20,
                ],
                'selectors' => [
                    '{{WRAPPER}} .aiq-category-filter button' => 'border-radius: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'filter_inactive_bg',
            [
                'label' => __('Inactive Background', 'aiqengage'),
                'type' => Controls_Manager::COLOR,
                'default' => 'rgba(126, 87, 194, 0.2)',
                'selectors' => [
                    '{{WRAPPER}} .aiq-category-filter button' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'filter_inactive_color',
            [
                'label' => __('Inactive Color', 'aiqengage'),
                'type' => Controls_Manager::COLOR,
                'default' => '#E0D6FF',
                'selectors' => [
                    '{{WRAPPER}} .aiq-category-filter button' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'filter_active_color',
            [
                'label' => __('Active Color', 'aiqengage'),
                'type' => Controls_Manager::COLOR,
                'default' => '#FFFFFF',
                'selectors' => [
                    '{{WRAPPER}} .aiq-category-filter button.active' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_section();
    }

    protected function render() {
        $settings = $this->get_settings_for_display();
        $prompts = $settings['prompts'];
        
        if (empty($prompts)) {
            return;
        }

        $widget_id = $this->get_id();
        $categories = [];

        // Extract all unique categories for filter
        foreach ($prompts as $prompt) {
            if (!in_array($prompt['category'], $categories)) {
                $categories[] = $prompt['category'];
            }
        }

        // Filter
        if ($settings['enable_filter'] === 'yes' && !empty($categories)) {
            echo '<div class="aiq-category-filter">';
            echo '<button class="active" data-filter="all">' . esc_html__('All', 'aiqengage') . '</button>';
            
            foreach ($categories as $category) {
                $category_name = ucfirst(str_replace('-', ' ', $category));
                echo '<button data-filter="' . esc_attr($category) . '">' . esc_html($category_name) . '</button>';
            }
            
            echo '</div>';
        }

        // Prompt Grid
        echo '<div class="aiq-prompt-grid" id="aiq-prompt-grid-' . esc_attr($widget_id) . '">';

        foreach ($prompts as $index => $prompt) {
            $prompt_id = 'aiq-prompt-' . $widget_id . '-' . $index;
            $is_pro = $prompt['is_pro'] === 'yes';
            $show_results = $prompt['show_results'] === 'yes';
            
            echo '<div class="aiq-prompt-card" data-category="' . esc_attr($prompt['category']) . '">';
            
            // Card Header
            echo '<div class="aiq-prompt-card-header">';
            echo '<span class="aiq-prompt-card-category">' . esc_html(ucfirst(str_replace('-', ' ', $prompt['category']))) . '</span>';
            
            if ($is_pro) {
                $pro_url = $settings['pro_url']['url'] ? $settings['pro_url']['url'] : '#';
                echo '<a href="' . esc_url($pro_url) . '" class="aiq-prompt-pro-badge">🔒 PRO</a>';
            }
            
            echo '<h3 class="aiq-prompt-card-title">' . esc_html($prompt['title']) . '</h3>';
            echo '<p class="aiq-prompt-card-description">' . esc_html($prompt['description']) . '</p>';
            echo '</div>';
            
            // Prompt Content
            echo '<div class="aiq-prompt-card-body">';
            
            if ($is_pro) {
                echo '<div class="aiq-prompt-card-locked">';
                echo '<div class="aiq-prompt-card-lock-icon">🔒</div>';
                echo '<div class="aiq-prompt-card-lock-text">' . esc_html($settings['pro_message']) . '</div>';
                
                if (!empty($settings['pro_url']['url'])) {
                    echo '<a href="' . esc_url($settings['pro_url']['url']) . '" class="aiq-prompt-card-upgrade-btn">' . esc_html__('Upgrade Now', 'aiqengage') . '</a>';
                }
                
                echo '</div>';
            } else {
                echo '<div class="aiq-prompt-card-content-wrapper">';
                echo '<pre class="aiq-prompt-card-content" id="' . esc_attr($prompt_id) . '">' . esc_html($prompt['prompt_content']) . '</pre>';
                echo '<button class="aiq-prompt-card-copy" data-target="' . esc_attr($prompt_id) . '">';
                echo '<span class="aiq-copy-icon">📋</span>';
                echo '<span class="aiq-copy-text">' . esc_html__('Copy', 'aiqengage') . '</span>';
                echo '</button>';
                echo '</div>';
                
                if ($show_results) {
                    echo '<div class="aiq-prompt-card-results-toggle">';
                    echo '<button class="aiq-prompt-card-toggle-btn" data-target="results-' . esc_attr($prompt_id) . '">';
                    echo esc_html__('See Results', 'aiqengage') . ' <span class="aiq-toggle-icon">+</span>';
                    echo '</button>';
                    echo '<div class="aiq-prompt-card-results" id="results-' . esc_attr($prompt_id) . '">';
                    echo nl2br(esc_html($prompt['results_content']));
                    echo '</div>';
                    echo '</div>';
                }
            }
            
            echo '</div>'; // End card body
            echo '</div>'; // End card
        }
        
        echo '</div>'; // End grid
        
        // Add script to handle copying prompts
        echo '<script>
            document.addEventListener("DOMContentLoaded", function() {
                // Copy functionality
                document.querySelectorAll(".aiq-prompt-card-copy").forEach(function(button) {
                    button.addEventListener("click", function() {
                        const targetId = this.getAttribute("data-target");
                        const textToCopy = document.getElementById(targetId).textContent;
                        
                        navigator.clipboard.writeText(textToCopy).then(() => {
                            const originalText = this.querySelector(".aiq-copy-text").textContent;
                            this.querySelector(".aiq-copy-text").textContent = "Copied!";
                            
                            setTimeout(() => {
                                this.querySelector(".aiq-copy-text").textContent = originalText;
                            }, 2000);
                        });
                    });
                });
                
                // Toggle results
                document.querySelectorAll(".aiq-prompt-card-toggle-btn").forEach(function(button) {
                    button.addEventListener("click", function() {
                        const targetId = this.getAttribute("data-target");
                        const resultElement = document.getElementById(targetId);
                        
                        if (resultElement.classList.contains("active")) {
                            resultElement.classList.remove("active");
                            this.querySelector(".aiq-toggle-icon").textContent = "+";
                        } else {
                            resultElement.classList.add("active");
                            this.querySelector(".aiq-toggle-icon").textContent = "−";
                        }
                    });
                });
                
                // Category filter
                document.querySelectorAll(".aiq-category-filter button").forEach(function(button) {
                    button.addEventListener("click", function() {
                        const filter = this.getAttribute("data-filter");
                        const cards = document.querySelectorAll("#aiq-prompt-grid-' . esc_attr($widget_id) . ' .aiq-prompt-card");
                        
                        // Update active state
                        document.querySelectorAll(".aiq-category-filter button").forEach(btn => {
                            btn.classList.remove("active");
                        });
                        this.classList.add("active");
                        
                        // Filter cards
                        cards.forEach(card => {
                            if (filter === "all" || card.getAttribute("data-category") === filter) {
                                card.style.display = "";
                            } else {
                                card.style.display = "none";
                            }
                        });
                    });
                });
            });
        </script>';
    }
}
