<?php
/**
 * Comparison Matrix Widget for AIQEngage
 * 
 * @package AIQEngage-Child
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

/**
 * Comparison Matrix Widget
 * Displays interactive comparison tables in AIQEngage brand style
 */
class AIQEngage_Comparison_Matrix_Widget extends \Elementor\Widget_Base {

    public function get_name() {
        return 'aiqengage-comparison-matrix';
    }

    public function get_title() {
        return __('AIQ Comparison Matrix', 'aiqengage');
    }

    public function get_icon() {
        return 'eicon-table';
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
            'matrix_title',
            [
                'label' => __('Matrix Title', 'aiqengage'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => __('Compare Similar Tools', 'aiqengage'),
            ]
        );

        $this->add_control(
            'matrix_description',
            [
                'label' => __('Description', 'aiqengage'),
                'type' => \Elementor\Controls_Manager::TEXTAREA,
                'default' => __('Compare features and benefits to find the best tool for your needs.', 'aiqengage'),
                'rows' => 3,
            ]
        );

        // Categories
        $repeater_categories = new \Elementor\Repeater();

        $repeater_categories->add_control(
            'category_name',
            [
                'label' => __('Category Name', 'aiqengage'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => __('AI Writers', 'aiqengage'),
            ]
        );

        $repeater_categories->add_control(
            'category_slug',
            [
                'label' => __('Category Slug', 'aiqengage'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => __('ai-writers', 'aiqengage'),
                'description' => __('Unique identifier, lowercase with hyphens', 'aiqengage'),
            ]
        );

        $this->add_control(
            'comparison_categories',
            [
                'label' => __('Comparison Categories', 'aiqengage'),
                'type' => \Elementor\Controls_Manager::REPEATER,
                'fields' => $repeater_categories->get_controls(),
                'default' => [
                    [
                        'category_name' => __('AI Writers', 'aiqengage'),
                        'category_slug' => __('ai-writers', 'aiqengage'),
                    ],
                    [
                        'category_name' => __('Automation', 'aiqengage'),
                        'category_slug' => __('automation', 'aiqengage'),
                    ],
                    [
                        'category_name' => __('Research', 'aiqengage'),
                        'category_slug' => __('research', 'aiqengage'),
                    ],
                ],
                'title_field' => '{{{ category_name }}}',
            ]
        );

        // Column Headers
        $repeater_columns = new \Elementor\Repeater();

        $repeater_columns->add_control(
            'column_title',
            [
                'label' => __('Column Title', 'aiqengage'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => __('Tool A', 'aiqengage'),
            ]
        );

        $repeater_columns->add_control(
            'column_image',
            [
                'label' => __('Column Image/Logo', 'aiqengage'),
                'type' => \Elementor\Controls_Manager::MEDIA,
                'default' => [
                    'url' => \Elementor\Utils::get_placeholder_image_src(),
                ],
            ]
        );

        $repeater_columns->add_control(
            'column_highlight',
            [
                'label' => __('Highlight Column', 'aiqengage'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => __('Yes', 'aiqengage'),
                'label_off' => __('No', 'aiqengage'),
                'return_value' => 'yes',
                'default' => 'no',
            ]
        );

        $repeater_columns->add_control(
            'highlight_text',
            [
                'label' => __('Highlight Label', 'aiqengage'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => __('Recommended', 'aiqengage'),
                'condition' => [
                    'column_highlight' => 'yes',
                ],
            ]
        );

        $repeater_columns->add_control(
            'column_categories',
            [
                'label' => __('Show in Categories', 'aiqengage'),
                'type' => \Elementor\Controls_Manager::SELECT2,
                'options' => [
                    'ai-writers' => __('AI Writers', 'aiqengage'),
                    'automation' => __('Automation', 'aiqengage'),
                    'research' => __('Research', 'aiqengage'),
                ],
                'multiple' => true,
                'default' => ['ai-writers'],
                'description' => __('Select which categories this column should appear in', 'aiqengage'),
            ]
        );

        $this->add_control(
            'comparison_columns',
            [
                'label' => __('Comparison Columns', 'aiqengage'),
                'type' => \Elementor\Controls_Manager::REPEATER,
                'fields' => $repeater_columns->get_controls(),
                'default' => [
                    [
                        'column_title' => __('Tool A', 'aiqengage'),
                        'column_highlight' => 'no',
                        'column_categories' => ['ai-writers'],
                    ],
                    [
                        'column_title' => __('Tool B', 'aiqengage'),
                        'column_highlight' => 'yes',
                        'highlight_text' => __('Recommended', 'aiqengage'),
                        'column_categories' => ['ai-writers'],
                    ],
                    [
                        'column_title' => __('Tool C', 'aiqengage'),
                        'column_highlight' => 'no',
                        'column_categories' => ['ai-writers'],
                    ],
                ],
                'title_field' => '{{{ column_title }}}',
            ]
        );

        // Features
        $repeater_features = new \Elementor\Repeater();

        $repeater_features->add_control(
            'feature_name',
            [
                'label' => __('Feature Name', 'aiqengage'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => __('Pricing', 'aiqengage'),
            ]
        );

        $repeater_features->add_control(
            'feature_highlight',
            [
                'label' => __('Highlight Row', 'aiqengage'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => __('Yes', 'aiqengage'),
                'label_off' => __('No', 'aiqengage'),
                'return_value' => 'yes',
                'default' => 'no',
            ]
        );

        $repeater_features->add_control(
            'feature_categories',
            [
                'label' => __('Show in Categories', 'aiqengage'),
                'type' => \Elementor\Controls_Manager::SELECT2,
                'options' => [
                    'ai-writers' => __('AI Writers', 'aiqengage'),
                    'automation' => __('Automation', 'aiqengage'),
                    'research' => __('Research', 'aiqengage'),
                ],
                'multiple' => true,
                'default' => ['ai-writers'],
                'description' => __('Select which categories this feature should appear in', 'aiqengage'),
            ]
        );

        $this->add_control(
            'comparison_features',
            [
                'label' => __('Comparison Features', 'aiqengage'),
                'type' => \Elementor\Controls_Manager::REPEATER,
                'fields' => $repeater_features->get_controls(),
                'default' => [
                    [
                        'feature_name' => __('Pricing', 'aiqengage'),
                        'feature_highlight' => 'no',
                        'feature_categories' => ['ai-writers', 'automation', 'research'],
                    ],
                    [
                        'feature_name' => __('Ease of Use', 'aiqengage'),
                        'feature_highlight' => 'no',
                        'feature_categories' => ['ai-writers', 'automation', 'research'],
                    ],
                    [
                        'feature_name' => __('Output Quality', 'aiqengage'),
                        'feature_highlight' => 'no',
                        'feature_categories' => ['ai-writers'],
                    ],
                    [
                        'feature_name' => __('AIQEngage Recommendation', 'aiqengage'),
                        'feature_highlight' => 'yes',
                        'feature_categories' => ['ai-writers', 'automation', 'research'],
                    ],
                ],
                'title_field' => '{{{ feature_name }}}',
            ]
        );

        // Feature Values
        $repeater_values = new \Elementor\Repeater();

        $repeater_values->add_control(
            'feature_id',
            [
                'label' => __('Feature ID', 'aiqengage'),
                'type' => \Elementor\Controls_Manager::NUMBER,
                'default' => 0,
                'description' => __('Corresponds to the feature index (starting from 0)', 'aiqengage'),
            ]
        );

        $repeater_values->add_control(
            'column_id',
            [
                'label' => __('Column ID', 'aiqengage'),
                'type' => \Elementor\Controls_Manager::NUMBER,
                'default' => 0,
                'description' => __('Corresponds to the column index (starting from 0)', 'aiqengage'),
            ]
        );

        $repeater_values->add_control(
            'value_text',
            [
                'label' => __('Value Text', 'aiqengage'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => __('$29/month', 'aiqengage'),
            ]
        );

        $repeater_values->add_control(
            'rating',
            [
                'label' => __('Rating (1-5)', 'aiqengage'),
                'type' => \Elementor\Controls_Manager::NUMBER,
                'min' => 0,
                'max' => 5,
                'step' => 0.5,
                'default' => 0,
                'description' => __('Leave as 0 to not show rating', 'aiqengage'),
            ]
        );

        $repeater_values->add_control(
            'value_highlight',
            [
                'label' => __('Highlight Cell', 'aiqengage'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => __('Yes', 'aiqengage'),
                'label_off' => __('No', 'aiqengage'),
                'return_value' => 'yes',
                'default' => 'no',
            ]
        );

        $this->add_control(
            'matrix_values',
            [
                'label' => __('Matrix Values', 'aiqengage'),
                'type' => \Elementor\Controls_Manager::REPEATER,
                'fields' => $repeater_values->get_controls(),
                'default' => [
                    // Tool A values
                    [
                        'feature_id' => 0, // Pricing
                        'column_id' => 0, // Tool A
                        'value_text' => __('$29/month', 'aiqengage'),
                        'rating' => 0,
                    ],
                    [
                        'feature_id' => 1, // Ease of Use
                        'column_id' => 0, // Tool A
                        'value_text' => __('Moderate', 'aiqengage'),
                        'rating' => 3,
                    ],
                    [
                        'feature_id' => 2, // Output Quality
                        'column_id' => 0, // Tool A
                        'value_text' => __('Good', 'aiqengage'),
                        'rating' => 3.5,
                    ],
                    [
                        'feature_id' => 3, // Recommendation
                        'column_id' => 0, // Tool A
                        'value_text' => __('Good for beginners', 'aiqengage'),
                        'rating' => 0,
                    ],
                    
                    // Tool B values
                    [
                        'feature_id' => 0, // Pricing
                        'column_id' => 1, // Tool B
                        'value_text' => __('$49/month', 'aiqengage'),
                        'rating' => 0,
                    ],
                    [
                        'feature_id' => 1, // Ease of Use
                        'column_id' => 1, // Tool B
                        'value_text' => __('Easy', 'aiqengage'),
                        'rating' => 4.5,
                    ],
                    [
                        'feature_id' => 2, // Output Quality
                        'column_id' => 1, // Tool B
                        'value_text' => __('Excellent', 'aiqengage'),
                        'rating' => 5,
                    ],
                    [
                        'feature_id' => 3, // Recommendation
                        'column_id' => 1, // Tool B
                        'value_text' => __('Best overall value', 'aiqengage'),
                        'rating' => 0,
                        'value_highlight' => 'yes',
                    ],
                    
                    // Tool C values
                    [
                        'feature_id' => 0, // Pricing
                        'column_id' => 2, // Tool C
                        'value_text' => __('$19/month', 'aiqengage'),
                        'rating' => 0,
                    ],
                    [
                        'feature_id' => 1, // Ease of Use
                        'column_id' => 2, // Tool C
                        'value_text' => __('Complex', 'aiqengage'),
                        'rating' => 2,
                    ],
                    [
                        'feature_id' => 2, // Output Quality
                        'column_id' => 2, // Tool C
                        'value_text' => __('Basic', 'aiqengage'),
                        'rating' => 2.5,
                    ],
                    [
                        'feature_id' => 3, // Recommendation
                        'column_id' => 2, // Tool C
                        'value_text' => __('Budget option', 'aiqengage'),
                        'rating' => 0,
                    ],
                ],
                'title_field' => '{{{ value_text }}} (Feature: {{{ feature_id }}}, Column: {{{ column_id }}})',
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
            'table_bg_color',
            [
                'label' => __('Table Background', 'aiqengage'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#1A0938',
                'selectors' => [
                    '{{WRAPPER}} .comparison-matrix-table' => 'background-color: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'header_bg_color',
            [
                'label' => __('Header Background', 'aiqengage'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => 'rgba(126, 87, 194, 0.2)',
                'selectors' => [
                    '{{WRAPPER}} .comparison-matrix-table th' => 'background-color: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'highlight_column_bg',
            [
                'label' => __('Highlighted Column Background', 'aiqengage'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => 'rgba(156, 77, 255, 0.1)',
                'selectors' => [
                    '{{WRAPPER}} .comparison-matrix-table .column-highlight' => 'background-color: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'highlight_row_bg',
            [
                'label' => __('Highlighted Row Background', 'aiqengage'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => 'rgba(126, 87, 194, 0.15)',
                'selectors' => [
                    '{{WRAPPER}} .comparison-matrix-table .row-highlight' => 'background-color: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'highlight_cell_bg',
            [
                'label' => __('Highlighted Cell Background', 'aiqengage'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => 'rgba(156, 77, 255, 0.2)',
                'selectors' => [
                    '{{WRAPPER}} .comparison-matrix-table .cell-highlight' => 'background-color: {{VALUE}} !important',
                ],
            ]
        );

        $this->add_control(
            'table_text_color',
            [
                'label' => __('Table Text Color', 'aiqengage'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#E0D6FF',
                'selectors' => [
                    '{{WRAPPER}} .comparison-matrix-table' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'table_border_color',
            [
                'label' => __('Table Border Color', 'aiqengage'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => 'rgba(156, 77, 255, 0.2)',
                'selectors' => [
                    '{{WRAPPER}} .comparison-matrix-table, {{WRAPPER}} .comparison-matrix-table th, {{WRAPPER}} .comparison-matrix-table td' => 'border-color: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'header_text_color',
            [
                'label' => __('Header Text Color', 'aiqengage'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#9C4DFF',
                'selectors' => [
                    '{{WRAPPER}} .comparison-matrix-table th' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'rating_color',
            [
                'label' => __('Rating Color', 'aiqengage'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#7F5AF0',
                'selectors' => [
                    '{{WRAPPER}} .star-rating .filled' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'rating_empty_color',
            [
                'label' => __('Rating Empty Color', 'aiqengage'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => 'rgba(127, 90, 240, 0.3)',
                'selectors' => [
                    '{{WRAPPER}} .star-rating .empty' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'tab_active_color',
            [
                'label' => __('Active Tab Color', 'aiqengage'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#9C4DFF',
                'selectors' => [
                    '{{WRAPPER}} .category-tabs .active' => 'background-color: {{VALUE}}; border-color: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'tab_inactive_color',
            [
                'label' => __('Inactive Tab Color', 'aiqengage'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => 'rgba(156, 77, 255, 0.2)',
                'selectors' => [
                    '{{WRAPPER}} .category-tabs button:not(.active)' => 'background-color: {{VALUE}}; border-color: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'table_border_radius',
            [
                'label' => __('Table Border Radius', 'aiqengage'),
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
                    '{{WRAPPER}} .comparison-matrix-table' => 'border-radius: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'table_box_shadow',
                'label' => __('Table Box Shadow', 'aiqengage'),
                'selector' => '{{WRAPPER}} .comparison-matrix-table',
            ]
        );

        $this->end_controls_section();
    }

    protected function render() {
        $settings = $this->get_settings_for_display();
        $widget_id = $this->get_id();
        $categories = $settings['comparison_categories'];
        $columns = $settings['comparison_columns'];
        $features = $settings['comparison_features'];
        $values = $settings['matrix_values'];
        
        // Create a default category if none are specified
        if (empty($categories)) {
            $categories = [
                [
                    'category_name' => __('All Tools', 'aiqengage'),
                    'category_slug' => 'all-tools',
                ]
            ];
        }
        
        // Prepare the values array for easier access
        $matrix_values = [];
        foreach ($values as $value) {
            $feature_id = $value['feature_id'];
            $column_id = $value['column_id'];
            $matrix_values[$feature_id][$column_id] = [
                'text' => $value['value_text'],
                'rating' => $value['rating'],
                'highlight' => $value['value_highlight'] === 'yes',
            ];
        }
        ?>
        <div class="comparison-matrix-container">
            <h2 class="matrix-title"><?php echo esc_html($settings['matrix_title']); ?></h2>
            <p class="matrix-description"><?php echo esc_html($settings['matrix_description']); ?></p>
            
            <?php if (count($categories) > 1): ?>
            <div class="category-tabs" role="tablist">
                <?php foreach ($categories as $index => $category): ?>
                <button id="tab-<?php echo esc_attr($category['category_slug']); ?>-<?php echo esc_attr($widget_id); ?>" 
                        class="category-tab <?php echo $index === 0 ? 'active' : ''; ?>"
                        role="tab"
                        aria-selected="<?php echo $index === 0 ? 'true' : 'false'; ?>"
                        aria-controls="panel-<?php echo esc_attr($category['category_slug']); ?>-<?php echo esc_attr($widget_id); ?>"
                        data-category="<?php echo esc_attr($category['category_slug']); ?>">
                    <?php echo esc_html($category['category_name']); ?>
                </button>
                <?php endforeach; ?>
            </div>
            <?php endif; ?>
            
            <?php foreach ($categories as $cat_index => $category): ?>
            <div id="panel-<?php echo esc_attr($category['category_slug']); ?>-<?php echo esc_attr($widget_id); ?>" 
                 class="matrix-panel <?php echo $cat_index === 0 ? 'active' : ''; ?>"
                 role="tabpanel"
                 aria-labelledby="tab-<?php echo esc_attr($category['category_slug']); ?>-<?php echo esc_attr($widget_id); ?>"
                 data-category="<?php echo esc_attr($category['category_slug']); ?>">
                
                <table class="comparison-matrix-table">
                    <thead>
                        <tr>
                            <th class="feature-column"><?php echo esc_html__('Features', 'aiqengage'); ?></th>
                            <?php foreach ($columns as $col_index => $column): 
                                // Skip columns not in this category
                                if (!empty($column['column_categories']) && 
                                    !in_array($category['category_slug'], $column['column_categories']) && 
                                    $category['category_slug'] !== 'all-tools') {
                                    continue;
                                }
                                
                                $column_class = $column['column_highlight'] === 'yes' ? 'column-highlight' : '';
                            ?>
                            <th class="<?php echo esc_attr($column_class); ?>">
                                <?php if ($column['column_highlight'] === 'yes'): ?>
                                <div class="highlight-label"><?php echo esc_html($column['highlight_text']); ?></div>
                                <?php endif; ?>
                                
                                <?php if (!empty($column['column_image']['url'])): ?>
                                <div class="column-image">
                                    <img src="<?php echo esc_url($column['column_image']['url']); ?>" 
                                         alt="<?php echo esc_attr($column['column_title']); ?>">
                                </div>
                                <?php endif; ?>
                                
                                <?php echo esc_html($column['column_title']); ?>
                            </th>
                            <?php endforeach; ?>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($features as $feat_index => $feature): 
                            // Skip features not in this category
                            if (!empty($feature['feature_categories']) && 
                                !in_array($category['category_slug'], $feature['feature_categories']) && 
                                $category['category_slug'] !== 'all-tools') {
                                continue;
                            }
                            
                            $row_class = $feature['feature_highlight'] === 'yes' ? 'row-highlight' : '';
                        ?>
                        <tr class="<?php echo esc_attr($row_class); ?>">
                            <td class="feature-name"><?php echo esc_html($feature['feature_name']); ?></td>
                            
                            <?php foreach ($columns as $col_index => $column): 
                                // Skip columns not in this category
                                if (!empty($column['column_categories']) && 
                                    !in_array($category['category_slug'], $column['column_categories']) && 
                                    $category['category_slug'] !== 'all-tools') {
                                    continue;
                                }
                                
                                $column_class = $column['column_highlight'] === 'yes' ? 'column-highlight' : '';
                                $cell_value = isset($matrix_values[$feat_index][$col_index]) ? $matrix_values[$feat_index][$col_index] : null;
                                $cell_class = $cell_value && $cell_value['highlight'] ? 'cell-highlight' : '';
                                $combined_class = $column_class . ' ' . $cell_class;
                            ?>
                            <td class="<?php echo esc_attr(trim($combined_class)); ?>">
                                <?php if ($cell_value): ?>
                                <div class="value-text"><?php echo esc_html($cell_value['text']); ?></div>
                                
                                <?php if ($cell_value['rating'] > 0): ?>
                                <div class="star-rating" aria-label="<?php echo esc_attr(sprintf(__('Rating: %s out of 5', 'aiqengage'), $cell_value['rating'])); ?>">
                                    <?php 
                                    $rating = $cell_value['rating'];
                                    for ($i = 1; $i <= 5; $i++) {
                                        if ($i <= $rating) {
                                            echo '<span class="filled">★</span>';
                                        } elseif ($i - 0.5 <= $rating) {
                                            echo '<span class="filled">★</span>';
                                        } else {
                                            echo '<span class="empty">☆</span>';
                                        }
                                    }
                                    ?>
                                </div>
                                <?php endif; ?>
                                
                                <?php else: ?>
                                <div class="value-text">—</div>
                                <?php endif; ?>
                            </td>
                            <?php endforeach; ?>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
            <?php endforeach; ?>
        </div>
        
        <script>
            jQuery(document).ready(function($) {
                const widgetId = '<?php echo esc_js($widget_id); ?>';
                
                // Tab switching functionality
                $('.elementor-element-' + widgetId + ' .category-tab').on('click', function() {
                    const category = $(this).data('category');
                    
                    // Update tab states
                    $('.elementor-element-' + widgetId + ' .category-tab').removeClass('active').attr('aria-selected', 'false');
                    $(this).addClass('active').attr('aria-selected', 'true');
                    
                    // Update panel visibility
                    $('.elementor-element-' + widgetId + ' .matrix-panel').removeClass('active');
                    $('.elementor-element-' + widgetId + ' .matrix-panel[data-category="' + category + '"]').addClass('active');
                });
                
                // Highlight rows on hover
                $('.elementor-element-' + widgetId + ' .comparison-matrix-table tr').on('mouseenter', function() {
                    $(this).addClass('hover');
                }).on('mouseleave', function() {
                    $(this).removeClass('hover');
                });
            });
        </script>
        <?php
    }
}

// Register widget if not already registered
if (!function_exists('register_comparison_matrix_widget')) {
    function register_comparison_matrix_widget($widgets_manager) {
        $widgets_manager->register(new AIQEngage_Comparison_Matrix_Widget());
    }
    add_action('elementor/widgets/register', 'register_comparison_matrix_widget');
}
