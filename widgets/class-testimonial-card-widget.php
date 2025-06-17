// widgets/class-testimonial-card-widget.php

<?php
/**
 * Testimonial Card Widget
 *
 * @package AIQEngage
 * @subpackage Widgets
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Testimonial Card Widget
 */
class AIQ_Testimonial_Card_Widget extends \Elementor\Widget_Base {

    /**
     * Get widget name.
     *
     * @return string Widget name.
     */
    public function get_name() {
        return 'aiq_testimonial_card';
    }

    /**
     * Get widget title.
     *
     * @return string Widget title.
     */
    public function get_title() {
        return esc_html__( 'AIQ Testimonial Card', 'aiqengage-child' );
    }

    /**
     * Get widget icon.
     *
     * @return string Widget icon.
     */
    public function get_icon() {
        return 'eicon-testimonial';
    }

    /**
     * Get widget keywords.
     *
     * @return array Widget keywords.
     */
    public function get_keywords() {
        return [ 'testimonial', 'review', 'case study', 'user', 'quote', 'star' ];
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
     * Register widget controls.
     */
    protected function register_controls() {

        // Content Section
        $this->start_controls_section(
            'section_content',
            [
                'label' => esc_html__( 'Content', 'aiqengage-child' ),
                'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'testimonial_text',
            [
                'label'       => esc_html__( 'Testimonial Text', 'aiqengage-child' ),
                'type'        => \Elementor\Controls_Manager::TEXTAREA,
                'rows'        => 5,
                'default'     => esc_html__( 'The Claude Vault prompts saved me hours of testing and trial-and-error. I was able to automate my content workflow in just one afternoon.', 'aiqengage-child' ),
                'placeholder' => esc_html__( 'Enter testimonial text', 'aiqengage-child' ),
                'dynamic'     => [
                    'active' => true,
                ],
            ]
        );

        $this->add_control(
            'author_name',
            [
                'label'       => esc_html__( 'Author Name', 'aiqengage-child' ),
                'type'        => \Elementor\Controls_Manager::TEXT,
                'default'     => esc_html__( 'Sarah Johnson', 'aiqengage-child' ),
                'placeholder' => esc_html__( 'Enter author name', 'aiqengage-child' ),
                'dynamic'     => [
                    'active' => true,
                ],
            ]
        );

        $this->add_control(
            'author_title',
            [
                'label'       => esc_html__( 'Author Role/Title', 'aiqengage-child' ),
                'type'        => \Elementor\Controls_Manager::TEXT,
                'default'     => esc_html__( 'Content Creator', 'aiqengage-child' ),
                'placeholder' => esc_html__( 'Enter author role or title', 'aiqengage-child' ),
                'dynamic'     => [
                    'active' => true,
                ],
            ]
        );

        $this->add_control(
            'author_image',
            [
                'label'   => esc_html__( 'Author Image', 'aiqengage-child' ),
                'type'    => \Elementor\Controls_Manager::MEDIA,
                'default' => [
                    'url' => \Elementor\Utils::get_placeholder_image_src(),
                ],
                'dynamic' => [
                    'active' => true,
                ],
            ]
        );

        $this->add_control(
            'enable_rating',
            [
                'label'        => esc_html__( 'Enable Star Rating', 'aiqengage-child' ),
                'type'         => \Elementor\Controls_Manager::SWITCHER,
                'label_on'     => esc_html__( 'Yes', 'aiqengage-child' ),
                'label_off'    => esc_html__( 'No', 'aiqengage-child' ),
                'return_value' => 'yes',
                'default'      => 'yes',
            ]
        );

        $this->add_control(
            'star_rating',
            [
                'label'     => esc_html__( 'Star Rating', 'aiqengage-child' ),
                'type'      => \Elementor\Controls_Manager::SLIDER,
                'range'     => [
                    'px' => [
                        'min'  => 0,
                        'max'  => 5,
                        'step' => 0.5,
                    ],
                ],
                'default'   => [
                    'size' => 5,
                ],
                'condition' => [
                    'enable_rating' => 'yes',
                ],
            ]
        );

        $this->add_control(
            'enable_metric',
            [
                'label'        => esc_html__( 'Enable Highlight Metric', 'aiqengage-child' ),
                'type'         => \Elementor\Controls_Manager::SWITCHER,
                'label_on'     => esc_html__( 'Yes', 'aiqengage-child' ),
                'label_off'    => esc_html__( 'No', 'aiqengage-child' ),
                'return_value' => 'yes',
                'default'      => 'yes',
            ]
        );

        $this->add_control(
            'metric_value',
            [
                'label'       => esc_html__( 'Metric Value', 'aiqengage-child' ),
                'type'        => \Elementor\Controls_Manager::TEXT,
                'default'     => esc_html__( '317%', 'aiqengage-child' ),
                'placeholder' => esc_html__( 'e.g., 317%', 'aiqengage-child' ),
                'condition'   => [
                    'enable_metric' => 'yes',
                ],
                'dynamic'     => [
                    'active' => true,
                ],
            ]
        );

        $this->add_control(
            'metric_label',
            [
                'label'       => esc_html__( 'Metric Label', 'aiqengage-child' ),
                'type'        => \Elementor\Controls_Manager::TEXT,
                'default'     => esc_html__( 'ROI', 'aiqengage-child' ),
                'placeholder' => esc_html__( 'e.g., ROI, Growth', 'aiqengage-child' ),
                'condition'   => [
                    'enable_metric' => 'yes',
                ],
                'dynamic'     => [
                    'active' => true,
                ],
            ]
        );

        $this->end_controls_section();

        // Style Section
        $this->start_controls_section(
            'section_style',
            [
                'label' => esc_html__( 'Style', 'aiqengage-child' ),
                'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'card_style',
            [
                'label'   => esc_html__( 'Card Style', 'aiqengage-child' ),
                'type'    => \Elementor\Controls_Manager::SELECT,
                'default' => 'standard',
                'options' => [
                    'standard' => esc_html__( 'Standard', 'aiqengage-child' ),
                    'minimal'  => esc_html__( 'Minimal', 'aiqengage-child' ),
                    'bordered' => esc_html__( 'Bordered', 'aiqengage-child' ),
                ],
            ]
        );

        $this->add_control(
            'card_background',
            [
                'label'     => esc_html__( 'Card Background', 'aiqengage-child' ),
                'type'      => \Elementor\Controls_Manager::COLOR,
                'default'   => '#2A1958',
                'selectors' => [
                    '{{WRAPPER}} .aiq-testimonial-card' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'accent_color',
            [
                'label'     => esc_html__( 'Accent Color', 'aiqengage-child' ),
                'type'      => \Elementor\Controls_Manager::COLOR,
                'default'   => '#9C4DFF',
                'selectors' => [
                    '{{WRAPPER}} .aiq-testimonial-card__quote-icon' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .aiq-testimonial-card__metric'     => 'color: {{VALUE}};',
                    '{{WRAPPER}} .aiq-testimonial-card__stars'      => '--star-color: {{VALUE}};',
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
                    '{{WRAPPER}} .aiq-testimonial-card__text'       => 'color: {{VALUE}};',
                    '{{WRAPPER}} .aiq-testimonial-card__author-name' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'secondary_text_color',
            [
                'label'     => esc_html__( 'Secondary Text Color', 'aiqengage-child' ),
                'type'      => \Elementor\Controls_Manager::COLOR,
                'default'   => 'rgba(224, 214, 255, 0.8)',
                'selectors' => [
                    '{{WRAPPER}} .aiq-testimonial-card__author-title' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .aiq-testimonial-card__metric-label' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'is_pro',
            [
                'label'        => esc_html__( 'Show Pro Badge', 'aiqengage-child' ),
                'type'         => \Elementor\Controls_Manager::SWITCHER,
                'label_on'     => esc_html__( 'Yes', 'aiqengage-child' ),
                'label_off'    => esc_html__( 'No', 'aiqengage-child' ),
                'return_value' => 'yes',
                'default'      => '',
            ]
        );

        $this->end_controls_section();
    }

    /**
     * Render widget output on the frontend.
     */
    protected function render() {
        $settings = $this->get_settings_for_display();

        // Calculate classes based on settings
        $card_classes = [
            'aiq-testimonial-card',
            'aiq-testimonial-card--' . $settings['card_style'],
        ];

        if ( 'yes' === $settings['is_pro'] ) {
            $card_classes[] = 'aiq-testimonial-card--pro';
        }

        // Author image
        $image_html = '';
        if ( ! empty( $settings['author_image']['url'] ) ) {
            $this->add_render_attribute( 'image', 'src', $settings['author_image']['url'] );
            $this->add_render_attribute( 'image', 'alt', esc_attr( $settings['author_name'] ) );
            $this->add_render_attribute( 'image', 'class', 'aiq-testimonial-card__author-image' );
            $this->add_render_attribute( 'image', 'loading', 'lazy' );
            $image_html = '<img ' . $this->get_render_attribute_string( 'image' ) . '>';
        }

        // Star rating
        $stars_html = '';
        if ( 'yes' === $settings['enable_rating'] && ! empty( $settings['star_rating']['size'] ) ) {
            $rating = $settings['star_rating']['size'];
            $stars_html = '<div class="aiq-testimonial-card__stars" aria-label="' . esc_attr( sprintf( __( '%s out of 5 stars', 'aiqengage-child' ), $rating ) ) . '">';
            $stars_html .= '<div class="aiq-testimonial-card__stars-filled" style="width:' . ( $rating * 20 ) . '%"></div>';
            $stars_html .= '</div>';
        }

        // Metric
        $metric_html = '';
        if ( 'yes' === $settings['enable_metric'] && ! empty( $settings['metric_value'] ) ) {
            $metric_html = '<div class="aiq-testimonial-card__metric">';
            $metric_html .= '<span class="aiq-testimonial-card__metric-value">' . esc_html( $settings['metric_value'] ) . '</span>';
            
            if ( ! empty( $settings['metric_label'] ) ) {
                $metric_html .= '<span class="aiq-testimonial-card__metric-label">' . esc_html( $settings['metric_label'] ) . '</span>';
            }
            
            $metric_html .= '</div>';
        }

        // Pro badge
        $pro_badge = '';
        if ( 'yes' === $settings['is_pro'] ) {
            $pro_badge = '<div class="aiq-testimonial-card__pro-badge" aria-label="' . esc_attr__( 'Premium content', 'aiqengage-child' ) . '">🔒</div>';
        }
        
        ?>
        <div class="<?php echo esc_attr( implode( ' ', $card_classes ) ); ?>">
            <?php echo $pro_badge; ?>
            
            <div class="aiq-testimonial-card__quote-icon" aria-hidden="true">"</div>
            
            <div class="aiq-testimonial-card__content">
                <blockquote class="aiq-testimonial-card__text">
                    <?php echo esc_html( $settings['testimonial_text'] ); ?>
                </blockquote>
                
                <?php echo $stars_html; ?>
                
                <div class="aiq-testimonial-card__author">
                    <?php if ( $image_html ) : ?>
                        <div class="aiq-testimonial-card__author-image-wrapper">
                            <?php echo $image_html; ?>
                        </div>
                    <?php endif; ?>
                    
                    <div class="aiq-testimonial-card__author-info">
                        <div class="aiq-testimonial-card__author-name"><?php echo esc_html( $settings['author_name'] ); ?></div>
                        <?php if ( ! empty( $settings['author_title'] ) ) : ?>
                            <div class="aiq-testimonial-card__author-title"><?php echo esc_html( $settings['author_title'] ); ?></div>
                        <?php endif; ?>
                    </div>
                    
                    <?php echo $metric_html; ?>
                </div>
            </div>
        </div>
        <?php
    }
}
