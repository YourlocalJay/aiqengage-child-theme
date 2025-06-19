<?php
/**
 * AIQ Prompt Card Widget
 *
 *
 * @package aiqengage-child
 * @version 1.0.0
 * @since 1.0.0
 * @author Jason
 */

namespace AIQEngage\Widgets;

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

/**
 * Prompt Card widget for displaying prompts with copy functionality.
 */
class AIQ_Prompt_Card_Widget extends \Elementor\Widget_Base {

    /**
     * Get widget name.
     *
     * @return string Widget name.
     */
    public function get_name() {
        return 'aiq-prompt-card';
    }

    /**
     * Get widget title.
     *
     * @return string Widget title.
     */
    public function get_title() {
        return esc_html__( 'AIQ Prompt Card', 'aiqengage-child' );
    }

    /**
     * Get widget icon.
     *
     * @return string Widget icon.
     */
    public function get_icon() {
        return 'eicon-code';
    }

    /**
     * Get widget categories.
     *
     * @return array Widget categories.
     */
    public function get_categories() {
        return [ 'aiqengage' ];
    }

    /**
     * Get widget keywords.
     *
     * @return array Widget keywords.
     */
    public function get_keywords() {
        return [ 'prompt', 'code', 'copy', 'ai', 'claude' ];
    }

    /**
     * Register widget controls.
     */
    protected function register_controls() {
        // Content Section
        $this->start_controls_section(
            'section_content',
            [
                'label' => esc_html__( 'Prompt Content', 'aiqengage-child' ),
                'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'prompt_title',
            [
                'label' => esc_html__( 'Prompt Title', 'aiqengage-child' ),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => esc_html__( 'Claude Prompt', 'aiqengage-child' ),
                'placeholder' => esc_html__( 'Enter prompt title', 'aiqengage-child' ),
                'label_block' => true,
            ]
        );

        $this->add_control(
            'prompt_category',
            [
                'label' => esc_html__( 'Category', 'aiqengage-child' ),
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => 'general',
                'options' => [
                    'general' => esc_html__( 'General', 'aiqengage-child' ),
                    'reddit' => esc_html__( 'Reddit', 'aiqengage-child' ),
                    'email' => esc_html__( 'Email', 'aiqengage-child' ),
                    'content' => esc_html__( 'Content Creation', 'aiqengage-child' ),
                    'marketing' => esc_html__( 'Marketing', 'aiqengage-child' ),
                    'automation' => esc_html__( 'Automation', 'aiqengage-child' ),
                ],
            ]
        );

        $this->add_control(
            'prompt_content',
            [
                'label' => esc_html__( 'Prompt Content', 'aiqengage-child' ),
                'type' => \Elementor\Controls_Manager::TEXTAREA,
                'rows' => 10,
                'default' => esc_html__( 'Enter your Claude prompt here...', 'aiqengage-child' ),
                'placeholder' => esc_html__( 'Enter your Claude prompt here...', 'aiqengage-child' ),
            ]
        );

        $this->add_control(
            'prompt_description',
            [
                'label' => esc_html__( 'Description', 'aiqengage-child' ),
                'type' => \Elementor\Controls_Manager::TEXTAREA,
                'rows' => 3,
                'default' => esc_html__( 'Brief description of what this prompt does and how to use it.', 'aiqengage-child' ),
                'placeholder' => esc_html__( 'Enter prompt description...', 'aiqengage-child' ),
            ]
        );

        $this->add_control(
            'show_variables',
            [
                'label' => esc_html__( 'Show Variables Panel', 'aiqengage-child' ),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => esc_html__( 'Show', 'aiqengage-child' ),
                'label_off' => esc_html__( 'Hide', 'aiqengage-child' ),
                'return_value' => 'yes',
                'default' => 'yes',
            ]
        );

        $this->add_control(
            'prompt_variables',
            [
                'label' => esc_html__( 'Variables', 'aiqengage-child' ),
                'type' => \Elementor\Controls_Manager::REPEATER,
                'fields' => [
                    [
                        'name' => 'variable_name',
                        'label' => esc_html__( 'Variable Name', 'aiqengage-child' ),
                        'type' => \Elementor\Controls_Manager::TEXT,
                        'default' => esc_html__( 'VARIABLE', 'aiqengage-child' ),
                        'placeholder' => esc_html__( 'e.g., TOPIC, NICHE, etc.', 'aiqengage-child' ),
                    ],
                    [
                        'name' => 'variable_description',
                        'label' => esc_html__( 'Description', 'aiqengage-child' ),
                        'type' => \Elementor\Controls_Manager::TEXT,
                        'default' => esc_html__( 'Description of the variable', 'aiqengage-child' ),
                        'placeholder' => esc_html__( 'What this variable represents', 'aiqengage-child' ),
                    ],
                ],
                'default' => [
                    [
                        'variable_name' => 'TOPIC',
                        'variable_description' => 'The main topic or subject',
                    ],
                    [
                        'variable_name' => 'NICHE',
                        'variable_description' => 'Your specific niche or industry',
                    ],
                ],
                'title_field' => '{{{ variable_name }}}',
                'condition' => [
                    'show_variables' => 'yes',
                ],
            ]
        );

        $this->add_control(
            'expandable',
            [
                'label' => esc_html__( 'Expandable Content', 'aiqengage-child' ),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => esc_html__( 'Yes', 'aiqengage-child' ),
                'label_off' => esc_html__( 'No', 'aiqengage-child' ),
                'return_value' => 'yes',
                'default' => 'no',
            ]
        );

        $this->add_control(
            'pro_only',
            [
                'label' => esc_html__( 'Pro Only', 'aiqengage-child' ),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => esc_html__( 'Yes', 'aiqengage-child' ),
                'label_off' => esc_html__( 'No', 'aiqengage-child' ),
                'return_value' => 'yes',
                'default' => 'no',
            ]
        );

        $this->end_controls_section();

        // Style Section
        $this->start_controls_section(
            'section_style',
            [
                'label' => esc_html__( 'Card Style', 'aiqengage-child' ),
                'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'card_background',
            [
                'label' => esc_html__( 'Background Color', 'aiqengage-child' ),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#2A1958',
                'selectors' => [
                    '{{WRAPPER}} .aiq-prompt-card' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'card_border_color',
            [
                'label' => esc_html__( 'Border Color', 'aiqengage-child' ),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => 'rgba(156, 77, 255, 0.3)',
                'selectors' => [
                    '{{WRAPPER}} .aiq-prompt-card' => 'border-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'title_typography',
                'label' => esc_html__( 'Title Typography', 'aiqengage-child' ),
                'selector' => '{{WRAPPER}} .aiq-prompt-card__title',
            ]
        );

        $this->add_control(
            'title_color',
            [
                'label' => esc_html__( 'Title Color', 'aiqengage-child' ),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#9C4DFF',
                'selectors' => [
                    '{{WRAPPER}} .aiq-prompt-card__title' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'content_typography',
                'label' => esc_html__( 'Content Typography', 'aiqengage-child' ),
                'selector' => '{{WRAPPER}} .aiq-prompt-card__content',
            ]
        );

        $this->add_control(
            'content_color',
            [
                'label' => esc_html__( 'Content Color', 'aiqengage-child' ),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#E0D6FF',
                'selectors' => [
                    '{{WRAPPER}} .aiq-prompt-card__content' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'button_background',
            [
                'label' => esc_html__( 'Copy Button Background', 'aiqengage-child' ),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#9C4DFF',
                'selectors' => [
                    '{{WRAPPER}} .aiq-prompt-card__copy-btn' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'button_color',
            [
                'label' => esc_html__( 'Copy Button Text Color', 'aiqengage-child' ),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#FFFFFF',
                'selectors' => [
                    '{{WRAPPER}} .aiq-prompt-card__copy-btn' => 'color: {{VALUE}};',
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

        $card_classes = ['aiq-prompt-card'];
        if ( 'yes' === $settings['expandable'] ) {
            $card_classes[] = 'aiq-prompt-card--expandable';
        }
        if ( 'yes' === $settings['pro_only'] ) {
            $card_classes[] = 'aiq-prompt-card--pro';
        }
        ?>
        <div class="<?php echo esc_attr( implode( ' ', $card_classes ) ); ?>">
            <div class="aiq-prompt-card__header">
                <h3 class="aiq-prompt-card__title"><?php echo esc_html( $settings['prompt_title'] ); ?></h3>
                <div class="aiq-prompt-card__meta">
                    <span class="aiq-prompt-card__category"><?php echo esc_html( $settings['prompt_category'] ); ?></span>
                    <?php if ( 'yes' === $settings['pro_only'] ) : ?>
                        <span class="aiq-prompt-card__pro-badge">🔒 Pro</span>
                    <?php endif; ?>
                </div>
            </div>

            <?php if ( ! empty( $settings['prompt_description'] ) ) : ?>
                <div class="aiq-prompt-card__description">
                    <?php echo wp_kses_post( wpautop( $settings['prompt_description'] ) ); ?>
                </div>
            <?php endif; ?>

            <div class="aiq-prompt-card__content <?php echo 'yes' === $settings['expandable'] ? 'aiq-prompt-card__content--expandable' : ''; ?>">
                <pre class="aiq-prompt-card__prompt"><code><?php echo esc_html( $settings['prompt_content'] ); ?></code></pre>
                <button class="aiq-prompt-card__copy-btn" data-copy-text="<?php echo esc_attr( $settings['prompt_content'] ); ?>">
                    <span class="copy-text"><?php esc_html_e( 'Copy', 'aiqengage-child' ); ?></span>
                    <span class="copied-text" style="display: none;"><?php esc_html_e( 'Copied!', 'aiqengage-child' ); ?></span>
                </button>
            </div>

            <?php if ( 'yes' === $settings['show_variables'] && ! empty( $settings['prompt_variables'] ) ) : ?>
                <div class="aiq-prompt-card__variables">
                    <h4 class="aiq-prompt-card__variables-title"><?php esc_html_e( 'Variables', 'aiqengage-child' ); ?></h4>
                    <ul class="aiq-prompt-card__variables-list">
                        <?php foreach ( $settings['prompt_variables'] as $variable ) : ?>
                            <li class="aiq-prompt-card__variable">
                                <strong>[<?php echo esc_html( $variable['variable_name'] ); ?>]</strong> -
                                <?php echo esc_html( $variable['variable_description'] ); ?>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            <?php endif; ?>

            <?php if ( 'yes' === $settings['expandable'] ) : ?>
                <div class="aiq-prompt-card__toggle">
                    <button class="aiq-prompt-card__expand-btn">
                        <span class="expand-text"><?php esc_html_e( 'Show More', 'aiqengage-child' ); ?></span>
                        <span class="collapse-text" style="display: none;"><?php esc_html_e( 'Show Less', 'aiqengage-child' ); ?></span>
                    </button>
                </div>
            <?php endif; ?>
        </div>
        <?php
    }

    /**
     * Get script dependencies.
     */
    public function get_script_depends() {
        return [ 'aiq-prompt-card' ];
    }

    /**
     * Get style dependencies.
     */
    public function get_style_depends() {
        return [ 'aiq-prompt-card' ];
    }
}
