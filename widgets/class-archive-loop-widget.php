<?php
/**
 * Archive Loop Widget
 *
 * @package AIQEngage
 */

namespace AIQEngage\Widgets;

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

/**
 * Archive Loop widget.
 */
class Archive_Loop_Widget extends \Elementor\Widget_Base {

    /**
     * Get widget name.
     *
     * @return string Widget name.
     */
    public function get_name() {
        return 'archive-loop';
    }

    /**
     * Get widget title.
     *
     * @return string Widget title.
     */
    public function get_title() {
        return esc_html__( 'Archive Loop', 'aiqengage-child' );
    }

    /**
     * Get widget icon.
     *
     * @return string Widget icon.
     */
    public function get_icon() {
        return 'eicon-archive-posts';
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
        return [ 'archive', 'loop', 'posts', 'blog', 'listing' ];
    }

    /**
     * Register widget controls.
     */
    protected function register_controls() {
        // Content Section
        $this->start_controls_section(
            'section_content',
            [
                'label' => esc_html__( 'Archive Loop Settings', 'aiqengage-child' ),
                'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'post_type',
            [
                'label' => esc_html__( 'Post Type', 'aiqengage-child' ),
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => 'post',
                'options' => $this->get_post_types(),
            ]
        );

        $this->add_control(
            'posts_per_page',
            [
                'label' => esc_html__( 'Posts Per Page', 'aiqengage-child' ),
                'type' => \Elementor\Controls_Manager::NUMBER,
                'default' => 6,
                'min' => 1,
                'max' => 20,
            ]
        );

        $this->add_control(
            'layout_type',
            [
                'label' => esc_html__( 'Layout', 'aiqengage-child' ),
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => 'grid',
                'options' => [
                    'grid' => esc_html__( 'Grid', 'aiqengage-child' ),
                    'list' => esc_html__( 'List', 'aiqengage-child' ),
                    'masonry' => esc_html__( 'Masonry', 'aiqengage-child' ),
                ],
            ]
        );

        $this->add_control(
            'columns',
            [
                'label' => esc_html__( 'Columns', 'aiqengage-child' ),
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => '3',
                'options' => [
                    '1' => esc_html__( '1 Column', 'aiqengage-child' ),
                    '2' => esc_html__( '2 Columns', 'aiqengage-child' ),
                    '3' => esc_html__( '3 Columns', 'aiqengage-child' ),
                    '4' => esc_html__( '4 Columns', 'aiqengage-child' ),
                ],
                'condition' => [
                    'layout_type' => [ 'grid', 'masonry' ],
                ],
            ]
        );

        $this->add_control(
            'show_image',
            [
                'label' => esc_html__( 'Show Featured Image', 'aiqengage-child' ),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => esc_html__( 'Show', 'aiqengage-child' ),
                'label_off' => esc_html__( 'Hide', 'aiqengage-child' ),
                'return_value' => 'yes',
                'default' => 'yes',
            ]
        );

        $this->add_control(
            'image_size',
            [
                'label' => esc_html__( 'Image Size', 'aiqengage-child' ),
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => 'medium',
                'options' => [
                    'thumbnail' => esc_html__( 'Thumbnail', 'aiqengage-child' ),
                    'medium' => esc_html__( 'Medium', 'aiqengage-child' ),
                    'large' => esc_html__( 'Large', 'aiqengage-child' ),
                    'full' => esc_html__( 'Full Size', 'aiqengage-child' ),
                ],
                'condition' => [
                    'show_image' => 'yes',
                ],
            ]
        );

        $this->add_control(
            'show_title',
            [
                'label' => esc_html__( 'Show Title', 'aiqengage-child' ),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => esc_html__( 'Show', 'aiqengage-child' ),
                'label_off' => esc_html__( 'Hide', 'aiqengage-child' ),
                'return_value' => 'yes',
                'default' => 'yes',
            ]
        );

        $this->add_control(
            'title_tag',
            [
                'label' => esc_html__( 'Title HTML Tag', 'aiqengage-child' ),
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => 'h2',
                'options' => [
                    'h1' => 'H1',
                    'h2' => 'H2',
                    'h3' => 'H3',
                    'h4' => 'H4',
                    'h5' => 'H5',
                    'h6' => 'H6',
                ],
                'condition' => [
                    'show_title' => 'yes',
                ],
            ]
        );

        $this->add_control(
            'show_excerpt',
            [
                'label' => esc_html__( 'Show Excerpt', 'aiqengage-child' ),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => esc_html__( 'Show', 'aiqengage-child' ),
                'label_off' => esc_html__( 'Hide', 'aiqengage-child' ),
                'return_value' => 'yes',
                'default' => 'yes',
            ]
        );

        $this->add_control(
            'excerpt_length',
            [
                'label' => esc_html__( 'Excerpt Length (words)', 'aiqengage-child' ),
                'type' => \Elementor\Controls_Manager::NUMBER,
                'default' => 20,
                'min' => 5,
                'max' => 100,
                'condition' => [
                    'show_excerpt' => 'yes',
                ],
            ]
        );

        $this->add_control(
            'show_meta',
            [
                'label' => esc_html__( 'Show Meta Data', 'aiqengage-child' ),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => esc_html__( 'Show', 'aiqengage-child' ),
                'label_off' => esc_html__( 'Hide', 'aiqengage-child' ),
                'return_value' => 'yes',
                'default' => 'yes',
            ]
        );

        $this->add_control(
            'meta_fields',
            [
                'label' => esc_html__( 'Meta Fields', 'aiqengage-child' ),
                'type' => \Elementor\Controls_Manager::SELECT2,
                'multiple' => true,
                'default' => [ 'date', 'author' ],
                'options' => [
                    'date' => esc_html__( 'Date', 'aiqengage-child' ),
                    'author' => esc_html__( 'Author', 'aiqengage-child' ),
                    'category' => esc_html__( 'Category', 'aiqengage-child' ),
                    'tags' => esc_html__( 'Tags', 'aiqengage-child' ),
                    'comments' => esc_html__( 'Comments Count', 'aiqengage-child' ),
                ],
                'condition' => [
                    'show_meta' => 'yes',
                ],
            ]
        );

        $this->add_control(
            'show_read_more',
            [
                'label' => esc_html__( 'Show Read More Button', 'aiqengage-child' ),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => esc_html__( 'Show', 'aiqengage-child' ),
                'label_off' => esc_html__( 'Hide', 'aiqengage-child' ),
                'return_value' => 'yes',
                'default' => 'yes',
            ]
        );

        $this->add_control(
            'read_more_text',
            [
                'label' => esc_html__( 'Read More Text', 'aiqengage-child' ),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => esc_html__( 'Read More', 'aiqengage-child' ),
                'condition' => [
                    'show_read_more' => 'yes',
                ],
            ]
        );

        $this->add_control(
            'show_pagination',
            [
                'label' => esc_html__( 'Show Pagination', 'aiqengage-child' ),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => esc_html__( 'Show', 'aiqengage-child' ),
                'label_off' => esc_html__( 'Hide', 'aiqengage-child' ),
                'return_value' => 'yes',
                'default' => 'yes',
            ]
        );

        $this->end_controls_section();

        // Style Section
        $this->start_controls_section(
            'section_style',
            [
                'label' => esc_html__( 'Archive Loop Style', 'aiqengage-child' ),
                'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'card_background',
            [
                'label' => esc_html__( 'Card Background', 'aiqengage-child' ),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#2A1958',
                'selectors' => [
                    '{{WRAPPER}} .archive-loop-item' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'card_border_color',
            [
                'label' => esc_html__( 'Card Border Color', 'aiqengage-child' ),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => 'rgba(156, 77, 255, 0.3)',
                'selectors' => [
                    '{{WRAPPER}} .archive-loop-item' => 'border-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'title_typography',
                'label' => esc_html__( 'Title Typography', 'aiqengage-child' ),
                'selector' => '{{WRAPPER}} .archive-loop-item__title',
            ]
        );

        $this->add_control(
            'title_color',
            [
                'label' => esc_html__( 'Title Color', 'aiqengage-child' ),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#E0D6FF',
                'selectors' => [
                    '{{WRAPPER}} .archive-loop-item__title a' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'title_hover_color',
            [
                'label' => esc_html__( 'Title Hover Color', 'aiqengage-child' ),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#9C4DFF',
                'selectors' => [
                    '{{WRAPPER}} .archive-loop-item__title a:hover' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'content_typography',
                'label' => esc_html__( 'Content Typography', 'aiqengage-child' ),
                'selector' => '{{WRAPPER}} .archive-loop-item__excerpt',
            ]
        );

        $this->add_control(
            'content_color',
            [
                'label' => esc_html__( 'Content Color', 'aiqengage-child' ),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => 'rgba(224, 214, 255, 0.8)',
                'selectors' => [
                    '{{WRAPPER}} .archive-loop-item__excerpt' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'meta_color',
            [
                'label' => esc_html__( 'Meta Color', 'aiqengage-child' ),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => 'rgba(224, 214, 255, 0.6)',
                'selectors' => [
                    '{{WRAPPER}} .archive-loop-item__meta' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'button_background',
            [
                'label' => esc_html__( 'Button Background', 'aiqengage-child' ),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#9C4DFF',
                'selectors' => [
                    '{{WRAPPER}} .archive-loop-item__read-more' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'button_text_color',
            [
                'label' => esc_html__( 'Button Text Color', 'aiqengage-child' ),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#FFFFFF',
                'selectors' => [
                    '{{WRAPPER}} .archive-loop-item__read-more' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_section();
    }

    /**
     * Get available post types.
     *
     * @return array Post types.
     */
    private function get_post_types() {
        $post_types = get_post_types( [ 'public' => true ], 'objects' );
        $options = [];
        
        foreach ( $post_types as $post_type ) {
            $options[ $post_type->name ] = $post_type->label;
        }
        
        return $options;
    }

    /**
     * Render widget output on the frontend.
     */
    protected function render() {
        $settings = $this->get_settings_for_display();
        
        $query_args = [
            'post_type' => $settings['post_type'],
            'posts_per_page' => $settings['posts_per_page'],
            'post_status' => 'publish',
            'paged' => get_query_var( 'paged' ) ? get_query_var( 'paged' ) : 1,
        ];
        
        $query = new \WP_Query( $query_args );
        
        if ( ! $query->have_posts() ) {
            echo '<p>' . esc_html__( 'No posts found.', 'aiqengage-child' ) . '</p>';
            return;
        }
        
        $layout_class = 'archive-loop--' . $settings['layout_type'];
        if ( 'grid' === $settings['layout_type'] || 'masonry' === $settings['layout_type'] ) {
            $layout_class .= ' archive-loop--columns-' . $settings['columns'];
        }
        ?>
        <div class="aiqengage-archive-loop <?php echo esc_attr( $layout_class ); ?>">
            <div class="aiqengage-archive-loop__container">
                <?php while ( $query->have_posts() ) : $query->the_post(); ?>
                    <article class="archive-loop-item">
                        <?php if ( 'yes' === $settings['show_image'] && has_post_thumbnail() ) : ?>
                            <div class="archive-loop-item__image">
                                <a href="<?php the_permalink(); ?>">
                                    <?php the_post_thumbnail( $settings['image_size'] ); ?>
                                </a>
                            </div>
                        <?php endif; ?>
                        
                        <div class="archive-loop-item__content">
                            <?php if ( 'yes' === $settings['show_title'] ) : ?>
                                <<?php echo esc_attr( $settings['title_tag'] ); ?> class="archive-loop-item__title">
                                    <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                                </<?php echo esc_attr( $settings['title_tag'] ); ?>>
                            <?php endif; ?>
                            
                            <?php if ( 'yes' === $settings['show_meta'] && ! empty( $settings['meta_fields'] ) ) : ?>
                                <div class="archive-loop-item__meta">
                                    <?php $this->render_meta_fields( $settings['meta_fields'] ); ?>
                                </div>
                            <?php endif; ?>
                            
                            <?php if ( 'yes' === $settings['show_excerpt'] ) : ?>
                                <div class="archive-loop-item__excerpt">
                                    <?php echo wp_trim_words( get_the_excerpt(), $settings['excerpt_length'], '...' ); ?>
                                </div>
                            <?php endif; ?>
                            
                            <?php if ( 'yes' === $settings['show_read_more'] ) : ?>
                                <a href="<?php the_permalink(); ?>" class="archive-loop-item__read-more">
                                    <?php echo esc_html( $settings['read_more_text'] ); ?>
                                </a>
                            <?php endif; ?>
                        </div>
                    </article>
                <?php endwhile; ?>
            </div>
            
            <?php if ( 'yes' === $settings['show_pagination'] ) : ?>
                <div class="archive-loop-pagination">
                    <?php
                    echo paginate_links( [
                        'total' => $query->max_num_pages,
                        'current' => max( 1, get_query_var( 'paged' ) ),
                        'format' => '?paged=%#%',
                        'prev_text' => esc_html__( '« Previous', 'aiqengage-child' ),
                        'next_text' => esc_html__( 'Next »', 'aiqengage-child' ),
                    ] );
                    ?>
                </div>
            <?php endif; ?>
        </div>
        <?php
        
        wp_reset_postdata();
    }

    /**
     * Render meta fields.
     *
     * @param array $fields Meta fields to render.
     */
    private function render_meta_fields( $fields ) {
        $meta_items = [];
        
        foreach ( $fields as $field ) {
            switch ( $field ) {
                case 'date':
                    $meta_items[] = '<span class="meta-date">' . get_the_date() . '</span>';
                    break;
                case 'author':
                    $meta_items[] = '<span class="meta-author">' . esc_html__( 'By', 'aiqengage-child' ) . ' ' . get_the_author() . '</span>';
                    break;
                case 'category':
                    $categories = get_the_category_list( ', ' );
                    if ( $categories ) {
                        $meta_items[] = '<span class="meta-category">' . $categories . '</span>';
                    }
                    break;
                case 'tags':
                    $tags = get_the_tag_list( '', ', ' );
                    if ( $tags ) {
                        $meta_items[] = '<span class="meta-tags">' . $tags . '</span>';
                    }
                    break;
                case 'comments':
                    $comments_count = get_comments_number();
                    if ( $comments_count > 0 ) {
                        $meta_items[] = '<span class="meta-comments">' . sprintf( _n( '%s Comment', '%s Comments', $comments_count, 'aiqengage-child' ), $comments_count ) . '</span>';
                    }
                    break;
            }
        }
        
        echo implode( ' • ', $meta_items );
    }

    /**
     * Get style dependencies.
     */
    public function get_style_depends() {
        return [ 'aiq-archive-loop' ];
    }
}
