<?php
/**
 * AIQ Prompt Card Widget
 * 
 * @package AIQEngage
 * @since 1.0.0
 */

defined( 'ABSPATH' ) || exit;

/**
 * Prompt Card Widget for Elementor
 */
class AIQ_Prompt_Card_Widget extends \Elementor\Widget_Base {

    /**
     * Widget base constructor
     */
    public function __construct( $data = [], $args = null ) {
        parent::__construct( $data, $args );
        
        // Register widget styles
        add_action( 'elementor/frontend/after_enqueue_styles', [ $this, 'enqueue_styles' ] );
        
        // Register widget scripts
        add_action( 'elementor/frontend/after_register_scripts', [ $this, 'enqueue_scripts' ] );
        
        // Editor scripts
        add_action( 'elementor/editor/after_enqueue_scripts', [ $this, 'enqueue_editor_scripts' ] );
    }

    /**
     * Get widget name
     */
    public function get_name() {
        return 'aiq_prompt_card';
    }

    /**
     * Get widget title
     */
    public function get_title() {
        return esc_html__( 'Prompt Card', 'aiqengage-child' );
    }

    /**
     * Get widget icon
     */
    public function get_icon() {
        return 'eicon-document-file';
    }

    /**
     * Get widget categories
     */
    public function get_categories() {
        return [ 'aiqengage' ];
    }

    /**
     * Get widget keywords
     */
    public function get_keywords() {
        return [ 'prompt', 'card', 'ai', 'template', 'copy', 'sample' ];
    }

    /**
     * Register widget controls
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
            'section_content',
            [
                'label' => esc_html__( 'Content', 'aiqengage-child' ),
                'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'prompt_title',
            [
                'label'       => esc_html__( 'Prompt Title', 'aiqengage-child' ),
                'type'        => \Elementor\Controls_Manager::TEXT,
                'default'     => esc_html__( 'Reddit Engagement Prompt', 'aiqengage-child' ),
                'placeholder' => esc_html__( 'Enter prompt title', 'aiqengage-child' ),
                'label_block' => true,
                'dynamic'     => [
                    'active' => true,
                ],
            ]
        );

        $this->add_control(
            'category',
            [
                'label'   => esc_html__( 'Category', 'aiqengage-child' ),
                'type'    => \Elementor\Controls_Manager::SELECT,
                'default' => 'reddit',
                'options' => $this->get_category_options(),
                'dynamic' => [
                    'active' => true,
                ],
            ]
        );

        $this->add_control(
            'custom_category',
            [
                'label'       => esc_html__( 'Custom Category Name', 'aiqengage-child' ),
                'type'        => \Elementor\Controls_Manager::TEXT,
                'placeholder' => esc_html__( 'Enter custom category name', 'aiqengage-child' ),
                'condition'   => [
                    'category' => 'custom',
                ],
                'dynamic'     => [
                    'active' => true,
                ],
            ]
        );

        $this->add_control(
            'description',
            [
                'label'       => esc_html__( 'Description', 'aiqengage-child' ),
                'type'        => \Elementor\Controls_Manager::TEXTAREA,
                'default'     => esc_html__( 'Generate engaging Reddit comments that establish authority without being promotional.', 'aiqengage-child' ),
                'placeholder' => esc_html__( 'Enter prompt description', 'aiqengage-child' ),
                'rows'        => 3,
                'dynamic'     => [
                    'active' => true,
                ],
            ]
        );

        $this->add_control(
            'prompt_body',
            [
                'label'       => esc_html__( 'Prompt Content', 'aiqengage-child' ),
                'type'        => \Elementor\Controls_Manager::TEXTAREA,
                'default'     => $this->get_default_prompt_content(),
                'placeholder' => esc_html__( 'Enter prompt content', 'aiqengage-child' ),
                'rows'        => 10,
                'dynamic'     => [
                    'active' => true,
                ],
            ]
        );

        $this->add_control(
            'show_variables',
            [
                'label'        => esc_html__( 'Show Variables Panel', 'aiqengage-child' ),
                'type'         => \Elementor\Controls_Manager::SWITCHER,
                'label_on'     => esc_html__( 'Yes', 'aiqengage-child' ),
                'label_off'    => esc_html__( 'No', 'aiqengage-child' ),
                'return_value' => 'yes',
                'default'      => 'no',
            ]
        );

        $this->add_control(
            'variables_heading',
            [
                'label'     => esc_html__( 'Variables', 'aiqengage-child' ),
                'type'      => \Elementor\Controls_Manager::HEADING,
                'separator' => 'before',
                'condition' => [
                    'show_variables' => 'yes',
                ],
            ]
        );

        $repeater = new \Elementor\Repeater();

        $repeater->add_control(
            'variable_name',
            [
                'label'       => esc_html__( 'Variable Name', 'aiqengage-child' ),
                'type'        => \Elementor\Controls_Manager::TEXT,
                'default'     => '[VARIABLE]',
                'placeholder' => esc_html__( 'Enter variable name with brackets []', 'aiqengage-child' ),
                'label_block' => true,
            ]
        );

        $repeater->add_control(
            'variable_description',
            [
                'label'       => esc_html__( 'Variable Description', 'aiqengage-child' ),
                'type'        => \Elementor\Controls_Manager::TEXT,
                'default'     => esc_html__( 'Replace with your specific value', 'aiqengage-child' ),
                'placeholder' => esc_html__( 'Enter variable description', 'aiqengage-child' ),
                'label_block' => true,
            ]
        );

        $repeater->add_control(
            'example_value',
            [
                'label'       => esc_html__( 'Example Value', 'aiqengage-child' ),
                'type'        => \Elementor\Controls_Manager::TEXT,
                'default'     => esc_html__( 'Example: productivity', 'aiqengage-child' ),
                'placeholder' => esc_html__( 'Enter example value', 'aiqengage-child' ),
                'label_block' => true,
            ]
        );

        $this->add_control(
            'variables',
            [
                'label'       => esc_html__( 'Variables List', 'aiqengage-child' ),
                'type'        => \Elementor\Controls_Manager::REPEATER,
                'fields'      => $repeater->get_controls(),
                'default'     => $this->get_default_variables(),
                'title_field' => '{{{ variable_name }}}',
                'condition'   => [
                    'show_variables' => 'yes',
                ],
            ]
        );

        $this->add_control(
            'usage_tips',
            [
                'label'       => esc_html__( 'Usage Tips', 'aiqengage-child' ),
                'type'        => \Elementor\Controls_Manager::WYSIWYG,
                'default'     => $this->get_default_usage_tips(),
                'placeholder' => esc_html__( 'Enter usage tips', 'aiqengage-child' ),
                'condition'   => [
                    'show_variables' => 'yes',
                ],
                'dynamic'     => [
                    'active' => true,
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
            'section_style',
            [
                'label' => esc_html__( 'Style', 'aiqengage-child' ),
                'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'accent_color',
            [
                'label'     => esc_html__( 'Accent Color', 'aiqengage-child' ),
                'type'      => \Elementor\Controls_Manager::COLOR,
                'default'   => '#9C4DFF',
                'selectors' => [
                    '{{WRAPPER}} .aiq-prompt-card__category' => 'border-color: {{VALUE}}; color: {{VALUE}};',
                    '{{WRAPPER}} .aiq-prompt-card__copy-btn' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .aiq-prompt-card__toggle'   => 'color: {{VALUE}};',
                    '{{WRAPPER}} .aiq-prompt-card__title'    => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'card_icon',
            [
                'label'   => esc_html__( 'Card Icon', 'aiqengage-child' ),
                'type'    => \Elementor\Controls_Manager::ICONS,
                'default' => [
                    'value'   => 'fas fa-comment-dots',
                    'library' => 'fa-solid',
                ],
            ]
        );

        $this->add_control(
            'is_pro',
            [
                'label'        => esc_html__( 'Pro/Locked Badge', 'aiqengage-child' ),
                'type'         => \Elementor\Controls_Manager::SWITCHER,
                'label_on'     => esc_html__( 'Show', 'aiqengage-child' ),
                'label_off'    => esc_html__( 'Hide', 'aiqengage-child' ),
                'return_value' => 'yes',
                'default'      => 'no',
            ]
        );

        $this->add_control(
            'expanded_by_default',
            [
                'label'        => esc_html__( 'Expanded by Default', 'aiqengage-child' ),
                'type'         => \Elementor\Controls_Manager::SWITCHER,
                'label_on'     => esc_html__( 'Yes', 'aiqengage-child' ),
                'label_off'    => esc_html__( 'No', 'aiqengage-child' ),
                'return_value' => 'yes',
                'default'      => 'no',
            ]
        );

        $this->add_control(
            'card_background',
            [
                'label'     => esc_html__( 'Card Background', 'aiqengage-child' ),
                'type'      => \Elementor\Controls_Manager::COLOR,
                'default'   => '#2A1958',
                'selectors' => [
                    '{{WRAPPER}} .aiq-prompt-card' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'text_color',
            [
                'label'     => esc_html__( 'Text Color', 'aiqengage-child' ),
                'type'      => \Elementor\Controls_Manager::COLOR,
                'default'   => '#E0D6FF',
                'selectors' => [
                    '{{WRAPPER}} .aiq-prompt-card' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name' => 'card_border',
                'selector' => '{{WRAPPER}} .aiq-prompt-card',
                'fields_options' => [
                    'border' => [
                        'default' => 'solid',
                    ],
                    'width' => [
                        'default' => [
                            'top' => '1',
                            'right' => '1',
                            'bottom' => '1',
                            'left' => '1',
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
            \Elementor\Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'card_shadow',
                'selector' => '{{WRAPPER}} .aiq-prompt-card',
                'fields_options' => [
                    'box_shadow_type' => [
                        'default' => 'yes',
                    ],
                    'box_shadow' => [
                        'default' => [
                            'horizontal' => 0,
                            'vertical' => 5,
                            'blur' => 15,
                            'spread' => 0,
                            'color' => 'rgba(0,0,0,0.3)',
                        ],
                    ],
                ],
            ]
        );

        $this->end_controls_section();
    }

    /**
     * Get default category options
     */
    protected function get_category_options() {
        return [
            'reddit'    => esc_html__( 'Reddit', 'aiqengage-child' ),
            'email'     => esc_html__( 'Email', 'aiqengage-child' ),
            'landing'   => esc_html__( 'Landing Page', 'aiqengage-child' ),
            'youtube'   => esc_html__( 'YouTube', 'aiqengage-child' ),
            'product'   => esc_html__( 'Product Review', 'aiqengage-child' ),
            'social'    => esc_html__( 'Social Media', 'aiqengage-child' ),
            'seo'       => esc_html__( 'SEO', 'aiqengage-child' ),
            'marketing' => esc_html__( 'Marketing', 'aiqengage-child' ),
            'custom'    => esc_html__( 'Custom', 'aiqengage-child' ),
        ];
    }

    /**
     * Get default prompt content
     */
    protected function get_default_prompt_content() {
        return 'Create 5 authentic Reddit comments for r/[SUBREDDIT] that:\n- Address common [TOPIC] problems with personal experience\n- Include specific details that show deep knowledge\n- End with actionable advice (no links)\n- Sound like a helpful community member, not a marketer\n- Range from 75-150 words each\n- Use casual language with occasional typos for authenticity';
    }

    /**
     * Get default variables
     */
    protected function get_default_variables() {
        return [
            [
                'variable_name'        => '[SUBREDDIT]',
                'variable_description' => 'The subreddit you want to target',
                'example_value'        => 'Example: r/productivity',
            ],
            [
                'variable_name'        => '[TOPIC]',
                'variable_description' => 'The specific topic for your comments',
                'example_value'        => 'Example: time management',
            ],
        ];
    }

    /**
     * Get default usage tips
     */
    protected function get_default_usage_tips() {
        return '<ul>
            <li>Replace [SUBREDDIT] with your target subreddit</li>
            <li>Focus on providing genuine value first</li>
            <li>Use these as templates, not exact copies</li>
        </ul>';
    }

    /**
     * Enqueue widget styles
     */
    public function enqueue_styles() {
        wp_enqueue_style(
            'aiq-prompt-card',
            get_stylesheet_directory_uri() . '/assets/css/aiq-prompt-card.css',
            [],
            filemtime( get_stylesheet_directory() . '/assets/css/aiq-prompt-card.css' )
        );
    }

    /**
     * Enqueue widget scripts
     */
    public function enqueue_scripts() {
        wp_enqueue_script(
            'aiq-prompt-card',
            get_stylesheet_directory_uri() . '/assets/js/aiq-prompt-card.js',
            [ 'jquery', 'elementor-frontend' ],
            filemtime( get_stylesheet_directory() . '/assets/js/aiq-prompt-card.js' ),
            true
        );
    }

    /**
     * Enqueue editor scripts
     */
    public function enqueue_editor_scripts() {
        wp_enqueue_script(
            'aiq-prompt-card-editor',
            get_stylesheet_directory_uri() . '/assets/js/aiq-prompt-card-editor.js',
            [ 'jquery', 'elementor-editor' ],
            filemtime( get_stylesheet_directory() . '/assets/js/aiq-prompt-card-editor.js' ),
            true
        );
    }

    /**
     * Render widget output
     */
    protected function render() {
        $settings = $this->get_settings_for_display();
        
        // Prepare attributes
        $this->add_render_attribute( 'wrapper', [
            'class' => [
                'aiq-prompt-card',
                'aiq-prompt-card--' . $this->get_id(),
            ],
            'id' => 'aiq-prompt-card-' . $this->get_id(),
            'data-widget-id' => $this->get_id(),
        ]);
        
        // Add pro class if needed
        if ( 'yes' === $settings['is_pro'] ) {
            $this->add_render_attribute( 'wrapper', 'class', 'aiq-prompt-card--pro' );
        }
        
        // Add expanded class if needed
        $expanded = 'yes' === $settings['expanded_by_default'];
        if ( $expanded ) {
            $this->add_render_attribute( 'wrapper', 'class', 'aiq-prompt-card--expanded' );
        }
        
        // Get category display name
        $category_display = $this->get_category_display_name( $settings );
        
        // Localize script data
        $this->localize_script_data();
        
        // Render the widget
        $this->render_card( $settings );
    }

    /**
     * Get category display name
     */
    protected function get_category_display_name( $settings ) {
        if ( 'custom' === $settings['category'] && ! empty( $settings['custom_category'] ) ) {
            return esc_html( $settings['custom_category'] );
        }
        
        $categories = $this->get_category_options();
        return isset( $categories[ $settings['category'] ] ) 
            ? $categories[ $settings['category'] ] 
            : esc_html__( 'General', 'aiqengage-child' );
    }

    /**
     * Localize script data
     */
    protected function localize_script_data() {
        wp_localize_script(
            'aiq-prompt-card',
            'aiqPromptCardConfig',
            [
                'ajaxUrl' => admin_url( 'admin-ajax.php' ),
                'nonce'   => wp_create_nonce( 'aiq_prompt_card_nonce' ),
                'i18n'    => [
                    'copied' => esc_html__( 'Copied to clipboard!', 'aiqengage-child' ),
                    'error'  => esc_html__( 'Failed to copy. Please try again.', 'aiqengage-child' ),
                ],
            ]
        );
    }

    /**
     * Render the card
     * 
     * @param array $settings Widget settings
     */
    protected function render_card( $settings ) {
        $category_display = $this->get_category_display_name( $settings );
        $card_id = 'aiq-prompt-card-' . $this->get_id();
        $expanded = 'yes' === $settings['expanded_by_default'];
        ?>
        <div <?php echo $this->get_render_attribute_string( 'wrapper' ); ?>>
            <?php $this->render_pro_badge( $settings ); ?>
            
            <div class="aiq-prompt-card__header">
                <?php $this->render_icon( $settings ); ?>
                
                <div class="aiq-prompt-card__title-wrapper">
                    <h3 class="aiq-prompt-card__title"><?php echo esc_html( $settings['prompt_title'] ); ?></h3>
                    <span class="aiq-prompt-card__category">
                        <?php echo esc_html( $category_display ); ?>
                    </span>
                </div>

                <div class="aiq-prompt-card__actions">
                    <?php $this->render_copy_button( $card_id ); ?>
                    <?php $this->render_toggle_button( $card_id, $expanded ); ?>
                </div>
            </div>

            <div class="aiq-prompt-card__description">
                <?php echo esc_html( $settings['description'] ); ?>
            </div>

            <div class="aiq-prompt-card__content" id="<?php echo esc_attr( $card_id ); ?>-content">
                <pre class="aiq-prompt-card__prompt"><?php echo esc_html( $settings['prompt_body'] ); ?></pre>
                
                <?php if ( 'yes' === $settings['show_variables'] && ! empty( $settings['variables'] ) ) : ?>
                    <?php $this->render_variables_section( $settings, $card_id ); ?>
                <?php endif; ?>
            </div>

            <div class="aiq-prompt-card__copied-message" aria-live="polite">
                <?php echo esc_html__( 'Copied to clipboard!', 'aiqengage-child' ); ?>
            </div>
        </div>
        <?php
    }

    /**
     * Render pro badge
     */
    protected function render_pro_badge( $settings ) {
        if ( 'yes' !== $settings['is_pro'] ) {
            return;
        }
        ?>
        <div class="aiq-prompt-card__pro-badge" aria-label="<?php echo esc_attr__( 'Pro Content', 'aiqengage-child' ); ?>">
            <span class="aiq-prompt-card__pro-badge-text">PRO</span>
            <span class="aiq-prompt-card__pro-badge-icon">🔒</span>
        </div>
        <?php
    }

    /**
     * Render icon
     */
    protected function render_icon( $settings ) {
        if ( empty( $settings['card_icon']['value'] ) ) {
            return;
        }
        ?>
        <div class="aiq-prompt-card__icon">
            <?php \Elementor\Icons_Manager::render_icon( $settings['card_icon'], [ 'aria-hidden' => 'true' ] ); ?>
        </div>
        <?php
    }

    /**
     * Render copy button
     */
    protected function render_copy_button( $card_id ) {
        ?>
        <button type="button" class="aiq-prompt-card__copy-btn" 
                aria-label="<?php echo esc_attr__( 'Copy prompt to clipboard', 'aiqengage-child' ); ?>"
                data-prompt-id="<?php echo esc_attr( $card_id ); ?>">
            <span class="aiq-prompt-card__copy-icon">
                <i class="fas fa-copy" aria-hidden="true"></i>
            </span>
            <span class="aiq-prompt-card__copy-text"><?php echo esc_html__( 'Copy', 'aiqengage-child' ); ?></span>
        </button>
        <?php
    }

    /**
     * Render toggle button
     */
    protected function render_toggle_button( $card_id, $expanded ) {
        ?>
        <button type="button" class="aiq-prompt-card__toggle" 
                aria-expanded="<?php echo $expanded ? 'true' : 'false'; ?>" 
                aria-controls="<?php echo esc_attr( $card_id ); ?>-content">
            <span class="aiq-prompt-card__toggle-text aiq-prompt-card__toggle-text--expand">
                <?php echo esc_html__( 'Show Prompt', 'aiqengage-child' ); ?>
            </span>
            <span class="aiq-prompt-card__toggle-text aiq-prompt-card__toggle-text--collapse">
                <?php echo esc_html__( 'Hide Prompt', 'aiqengage-child' ); ?>
            </span>
            <span class="aiq-prompt-card__toggle-icon">
                <i class="fas fa-chevron-down" aria-hidden="true"></i>
            </span>
        </button>
        <?php
    }

    /**
     * Render variables section
     */
    protected function render_variables_section( $settings, $card_id ) {
        ?>
        <div class="aiq-prompt-card__variables">
            <h4 class="aiq-prompt-card__variables-title"><?php echo esc_html__( 'Variables', 'aiqengage-child' ); ?></h4>
            <table class="aiq-prompt-card__variables-table">
                <thead>
                    <tr>
                        <th><?php echo esc_html__( 'Variable', 'aiqengage-child' ); ?></th>
                        <th><?php echo esc_html__( 'Description', 'aiqengage-child' ); ?></th>
                        <th><?php echo esc_html__( 'Example', 'aiqengage-child' ); ?></th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ( $settings['variables'] as $variable ) : ?>
                        <tr>
                            <td class="aiq-prompt-card__variable-name">
                                <button type="button" class="aiq-prompt-card__variable-insert" 
                                        data-variable="<?php echo esc_attr( $variable['variable_name'] ); ?>"
                                        data-prompt-id="<?php echo esc_attr( $card_id ); ?>">
                                    <?php echo esc_html( $variable['variable_name'] ); ?>
                                </button>
                            </td>
                            <td><?php echo esc_html( $variable['variable_description'] ); ?></td>
                            <td><em><?php echo esc_html( $variable['example_value'] ); ?></em></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>

            <?php if ( ! empty( $settings['usage_tips'] ) ) : ?>
                <div class="aiq-prompt-card__tips">
                    <h4 class="aiq-prompt-card__tips-title"><?php echo esc_html__( 'Usage Tips', 'aiqengage-child' ); ?></h4>
                    <div class="aiq-prompt-card__tips-content">
                        <?php echo wp_kses_post( $settings['usage_tips'] ); ?>
                    </div>
                </div>
            <?php endif; ?>
        </div>
        <?php
    }

    /**
     * Content template for editor
     */
    protected function content_template() {
        // Editor preview template - simplified version for performance
        ?>
        <#
        var categoryDisplay = settings.category === 'custom' && settings.custom_category ? settings.custom_category : settings.category;
        var cardId = 'aiq-prompt-card-' + view.getIDInt();
        var expanded = 'yes' === settings.expanded_by_default;
        #>
        <div class="aiq-prompt-card aiq-prompt-card--{{ settings.category }} <# if ( 'yes' === settings.is_pro ) { #>aiq-prompt-card--pro<# } #> <# if ( expanded ) { #>aiq-prompt-card--expanded<# } #>" id="{{ cardId }}">
            <# if ( 'yes' === settings.is_pro ) { #>
            <div class="aiq-prompt-card__pro-badge">
                <span class="aiq-prompt-card__pro-badge-text">PRO</span>
                <span class="aiq-prompt-card__pro-badge-icon">🔒</span>
            </div>
            <# } #>
            
            <div class="aiq-prompt-card__header">
                <# if ( settings.card_icon && settings.card_icon.value ) { #>
                <div class="aiq-prompt-card__icon">
                    <i class="{{ settings.card_icon.value }}"></i>
                </div>
                <# } #>
                
                <div class="aiq-prompt-card__title-wrapper">
                    <h3 class="aiq-prompt-card__title">{{{ settings.prompt_title }}}</h3>
                    <span class="aiq-prompt-card__category">{{{ categoryDisplay }}}</span>
                </div>

                <div class="aiq-prompt-card__actions">
                    <button type="button" class="aiq-prompt-card__copy-btn">
                        <i class="fas fa-copy"></i> Copy
                    </button>
                    <button type="button" class="aiq-prompt-card__toggle">
                        <span class="aiq-prompt-card__toggle-text"><?php echo esc_html__( 'Show Prompt', 'aiqengage-child' ); ?></span>
                        <i class="fas fa-chevron-down"></i>
                    </button>
                </div>
            </div>

            <div class="aiq-prompt-card__description">{{{ settings.description }}}</div>

            <div class="aiq-prompt-card__content">
                <pre class="aiq-prompt-card__prompt">{{{ settings.prompt_body }}}</pre>
            </div>
        </div>
        <?php
    }
}
