<?php
/**
 * Evergreen Countdown Widget
 *
 * @package AIQEngage
 */

namespace AIQEngage\Widgets;

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

/**
 * Evergreen Countdown widget with multiple display modes and triggers.
 */
class Evergreen_Countdown_Widget extends \Elementor\Widget_Base {

    /**
     * Get widget name.
     *
     * @return string Widget name.
     */
    public function get_name() {
        return 'evergreen-countdown';
    }

    /**
     * Get widget title.
     *
     * @return string Widget title.
     */
    public function get_title() {
        return esc_html__( 'Evergreen Countdown', 'aiqengage' );
    }

    /**
     * Get widget icon.
     *
     * @return string Widget icon.
     */
    public function get_icon() {
        return 'eicon-countdown';
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
        return [ 'countdown', 'timer', 'urgency', 'scarcity', 'evergreen' ];
    }

    /**
     * Register widget controls.
     */
    protected function register_controls() {
        // Content Section
        $this->start_controls_section(
            'section_content',
            [
                'label' => esc_html__( 'Countdown Settings', 'aiqengage' ),
                'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'countdown_type',
            [
                'label' => esc_html__( 'Countdown Type', 'aiqengage' ),
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => 'evergreen',
                'options' => [
                    'evergreen' => esc_html__( 'Evergreen (Per Visitor)', 'aiqengage' ),
                    'fixed' => esc_html__( 'Fixed Date', 'aiqengage' ),
                ],
            ]
        );

        $this->add_control(
            'duration_hours',
            [
                'label' => esc_html__( 'Duration (Hours)', 'aiqengage' ),
                'type' => \Elementor\Controls_Manager::NUMBER,
                'default' => 24,
                'min' => 1,
                'max' => 168, // 7 days
                'condition' => [
                    'countdown_type' => 'evergreen',
                ],
            ]
        );

        $this->add_control(
            'end_date',
            [
                'label' => esc_html__( 'End Date', 'aiqengage' ),
                'type' => \Elementor\Controls_Manager::DATE_TIME,
                'default' => date( 'Y-m-d H:i', strtotime( '+1 day' ) ),
                'condition' => [
                    'countdown_type' => 'fixed',
                ],
            ]
        );

        $this->add_control(
            'display_style',
            [
                'label' => esc_html__( 'Display Style', 'aiqengage' ),
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => 'inline',
                'options' => [
                    'inline' => esc_html__( 'Inline', 'aiqengage' ),
                    'modal' => esc_html__( 'Modal Popup', 'aiqengage' ),
                    'sticky' => esc_html__( 'Sticky Bar', 'aiqengage' ),
                ],
            ]
        );

        $this->add_control(
            'modal_trigger',
            [
                'label' => esc_html__( 'Modal Trigger', 'aiqengage' ),
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => 'delay',
                'options' => [
                    'immediate' => esc_html__( 'Immediate', 'aiqengage' ),
                    'delay' => esc_html__( 'After Delay', 'aiqengage' ),
                    'scroll' => esc_html__( 'On Scroll', 'aiqengage' ),
                    'exit' => esc_html__( 'Exit Intent', 'aiqengage' ),
                ],
                'condition' => [
                    'display_style' => 'modal',
                ],
            ]
        );

        $this->add_control(
            'modal_delay',
            [
                'label' => esc_html__( 'Delay (seconds)', 'aiqengage' ),
                'type' => \Elementor\Controls_Manager::NUMBER,
                'default' => 5,
                'min' => 1,
                'max' => 60,
                'condition' => [
                    'display_style' => 'modal',
                    'modal_trigger' => 'delay',
                ],
            ]
        );

        $this->add_control(
            'scroll_percentage',
            [
                'label' => esc_html__( 'Scroll Percentage', 'aiqengage' ),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'range' => [
                    '%' => [
                        'min' => 10,
                        'max' => 90,
                        'step' => 10,
                    ],
                ],
                'default' => [
                    'size' => 50,
                    'unit' => '%',
                ],
                'condition' => [
                    'display_style' => 'modal',
                    'modal_trigger' => 'scroll',
                ],
            ]
        );

        $this->add_control(
            'sticky_position',
            [
                'label' => esc_html__( 'Sticky Position', 'aiqengage' ),
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => 'top',
                'options' => [
                    'top' => esc_html__( 'Top', 'aiqengage' ),
                    'bottom' => esc_html__( 'Bottom', 'aiqengage' ),
                ],
                'condition' => [
                    'display_style' => 'sticky',
                ],
            ]
        );

        $this->end_controls_section();

        // Display Options Section
        $this->start_controls_section(
            'section_display',
            [
                'label' => esc_html__( 'Display Options', 'aiqengage' ),
                'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'headline',
            [
                'label' => esc_html__( 'Headline', 'aiqengage' ),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => esc_html__( 'Limited Time Offer!', 'aiqengage' ),
                'label_block' => true,
            ]
        );

        $this->add_control(
            'message',
            [
                'label' => esc_html__( 'Message', 'aiqengage' ),
                'type' => \Elementor\Controls_Manager::TEXTAREA,
                'default' => esc_html__( 'Don\'t miss out on this exclusive deal. Time is running out!', 'aiqengage' ),
                'rows' => 3,
            ]
        );

        $this->add_control(
            'show_days',
            [
                'label' => esc_html__( 'Show Days', 'aiqengage' ),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => esc_html__( 'Show', 'aiqengage' ),
                'label_off' => esc_html__( 'Hide', 'aiqengage' ),
                'return_value' => 'yes',
                'default' => 'yes',
            ]
        );

        $this->add_control(
            'show_hours',
            [
                'label' => esc_html__( 'Show Hours', 'aiqengage' ),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => esc_html__( 'Show', 'aiqengage' ),
                'label_off' => esc_html__( 'Hide', 'aiqengage' ),
                'return_value' => 'yes',
                'default' => 'yes',
            ]
        );

        $this->add_control(
            'show_minutes',
            [
                'label' => esc_html__( 'Show Minutes', 'aiqengage' ),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => esc_html__( 'Show', 'aiqengage' ),
                'label_off' => esc_html__( 'Hide', 'aiqengage' ),
                'return_value' => 'yes',
                'default' => 'yes',
            ]
        );

        $this->add_control(
            'show_seconds',
            [
                'label' => esc_html__( 'Show Seconds', 'aiqengage' ),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => esc_html__( 'Show', 'aiqengage' ),
                'label_off' => esc_html__( 'Hide', 'aiqengage' ),
                'return_value' => 'yes',
                'default' => 'yes',
            ]
        );

        $this->add_control(
            'show_close_button',
            [
                'label' => esc_html__( 'Show Close Button', 'aiqengage' ),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => esc_html__( 'Show', 'aiqengage' ),
                'label_off' => esc_html__( 'Hide', 'aiqengage' ),
                'return_value' => 'yes',
                'default' => 'yes',
                'condition' => [
                    'display_style!' => 'inline',
                ],
            ]
        );

        $this->add_control(
            'after_expiry',
            [
                'label' => esc_html__( 'After Expiry', 'aiqengage' ),
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => 'hide',
                'options' => [
                    'hide' => esc_html__( 'Hide Widget', 'aiqengage' ),
                    'message' => esc_html__( 'Show Message', 'aiqengage' ),
                    'redirect' => esc_html__( 'Redirect', 'aiqengage' ),
                    'opacity' => esc_html__( 'Reduce Opacity', 'aiqengage' ),
                ],
            ]
        );

        $this->add_control(
            'expiry_message',
            [
                'label' => esc_html__( 'Expiry Message', 'aiqengage' ),
                'type' => \Elementor\Controls_Manager::TEXTAREA,
                'default' => esc_html__( 'This offer has expired. Check back later for new deals!', 'aiqengage' ),
                'condition' => [
                    'after_expiry' => 'message',
                ],
            ]
        );

        $this->add_control(
            'redirect_url',
            [
                'label' => esc_html__( 'Redirect URL', 'aiqengage' ),
                'type' => \Elementor\Controls_Manager::URL,
                'placeholder' => 'https://example.com',
                'condition' => [
                    'after_expiry' => 'redirect',
                ],
            ]
        );

        $this->end_controls_section();

        // Style Section
        $this->start_controls_section(
            'section_style',
            [
                'label' => esc_html__( 'Style', 'aiqengage' ),
                'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'background_color',
            [
                'label' => esc_html__( 'Background Color', 'aiqengage' ),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#2A1958',
                'selectors' => [
                    '{{WRAPPER}} .aiq-evergreen-countdown' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'text_color',
            [
                'label' => esc_html__( 'Text Color', 'aiqengage' ),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#E0D6FF',
                'selectors' => [
                    '{{WRAPPER}} .aiq-evergreen-countdown' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'headline_typography',
                'label' => esc_html__( 'Headline Typography', 'aiqengage' ),
                'selector' => '{{WRAPPER}} .aiq-evergreen-countdown__headline',
            ]
        );

        $this->add_control(
            'headline_color',
            [
                'label' => esc_html__( 'Headline Color', 'aiqengage' ),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#E0D6FF',
                'selectors' => [
                    '{{WRAPPER}} .aiq-evergreen-countdown__headline' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'timer_background',
            [
                'label' => esc_html__( 'Timer Background', 'aiqengage' ),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#9C4DFF',
                'selectors' => [
                    '{{WRAPPER}} .aiq-countdown-unit' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'timer_text_color',
            [
                'label' => esc_html__( 'Timer Text Color', 'aiqengage' ),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#FFFFFF',
                'selectors' => [
                    '{{WRAPPER}} .aiq-countdown-unit' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'timer_typography',
                'label' => esc_html__( 'Timer Typography', 'aiqengage' ),
                'selector' => '{{WRAPPER}} .aiq-countdown-number',
            ]
        );

        $this->end_controls_section();
    }

    /**
     * Render widget output on the frontend.
     */
    protected function render() {
        $settings = $this->get_settings_for_display();
        
        $widget_id = 'aiq-countdown-' . $this->get_id();
        $cookie_id = 'aiq_countdown_' . $this->get_id();
        
        $countdown_classes = ['aiq-evergreen-countdown'];
        
        if ( 'modal' === $settings['display_style'] ) {
            $countdown_classes[] = 'aiq-evergreen-countdown--modal';
        } elseif ( 'sticky' === $settings['display_style'] ) {
            $countdown_classes[] = 'aiq-evergreen-countdown--sticky';
            $countdown_classes[] = 'aiq-evergreen-countdown--sticky-' . $settings['sticky_position'];
        }
        
        $data_attributes = [
            'data-countdown-type="' . esc_attr( $settings['countdown_type'] ) . '"',
            'data-cookie-id="' . esc_attr( $cookie_id ) . '"',
            'data-after-expiry="' . esc_attr( $settings['after_expiry'] ) . '"',
        ];
        
        if ( 'evergreen' === $settings['countdown_type'] ) {
            $data_attributes[] = 'data-duration="' . esc_attr( $settings['duration_hours'] * 3600 ) . '"';
        } else {
            $end_timestamp = strtotime( $settings['end_date'] );
            $data_attributes[] = 'data-end-date="' . esc_attr( $end_timestamp ) . '"';
        }
        
        if ( 'modal' === $settings['display_style'] ) {
            $data_attributes[] = 'data-modal-trigger="' . esc_attr( $settings['modal_trigger'] ) . '"';
            
            if ( 'delay' === $settings['modal_trigger'] ) {
                $data_attributes[] = 'data-modal-delay="' . esc_attr( $settings['modal_delay'] ) . '"';
            } elseif ( 'scroll' === $settings['modal_trigger'] ) {
                $data_attributes[] = 'data-scroll-percentage="' . esc_attr( $settings['scroll_percentage']['size'] ) . '"';
            }
        }
        
        if ( 'redirect' === $settings['after_expiry'] && ! empty( $settings['redirect_url']['url'] ) ) {
            $data_attributes[] = 'data-redirect-url="' . esc_attr( $settings['redirect_url']['url'] ) . '"';
        }
        
        ?>
        <div id="<?php echo esc_attr( $widget_id ); ?>" class="<?php echo esc_attr( implode( ' ', $countdown_classes ) ); ?>" <?php echo implode( ' ', $data_attributes ); ?>>
            <?php if ( 'modal' === $settings['display_style'] ) : ?>
                <div class="aiq-evergreen-countdown__overlay"></div>
                <div class="aiq-evergreen-countdown__modal">
            <?php endif; ?>
            
            <div class="aiq-evergreen-countdown__content">
                <?php if ( 'yes' === $settings['show_close_button'] && 'inline' !== $settings['display_style'] ) : ?>
                    <button class="aiq-evergreen-countdown__close" aria-label="<?php esc_attr_e( 'Close', 'aiqengage' ); ?>">
                        &times;
                    </button>
                <?php endif; ?>
                
                <?php if ( ! empty( $settings['headline'] ) ) : ?>
                    <h3 class="aiq-evergreen-countdown__headline"><?php echo esc_html( $settings['headline'] ); ?></h3>
                <?php endif; ?>
                
                <?php if ( ! empty( $settings['message'] ) ) : ?>
                    <div class="aiq-evergreen-countdown__message">
                        <?php echo wp_kses_post( wpautop( $settings['message'] ) ); ?>
                    </div>
                <?php endif; ?>
                
                <div class="aiq-evergreen-countdown__timer">
                    <?php if ( 'yes' === $settings['show_days'] ) : ?>
                        <div class="aiq-countdown-unit">
                            <span class="aiq-countdown-number" data-countdown-days>00</span>
                            <span class="aiq-countdown-label"><?php esc_html_e( 'Days', 'aiqengage' ); ?></span>
                        </div>
                    <?php endif; ?>
                    
                    <?php if ( 'yes' === $settings['show_hours'] ) : ?>
                        <div class="aiq-countdown-unit">
                            <span class="aiq-countdown-number" data-countdown-hours>00</span>
                            <span class="aiq-countdown-label"><?php esc_html_e( 'Hours', 'aiqengage' ); ?></span>
                        </div>
                    <?php endif; ?>
                    
                    <?php if ( 'yes' === $settings['show_minutes'] ) : ?>
                        <div class="aiq-countdown-unit">
                            <span class="aiq-countdown-number" data-countdown-minutes>00</span>
                            <span class="aiq-countdown-label"><?php esc_html_e( 'Minutes', 'aiqengage' ); ?></span>
                        </div>
                    <?php endif; ?>
                    
                    <?php if ( 'yes' === $settings['show_seconds'] ) : ?>
                        <div class="aiq-countdown-unit">
                            <span class="aiq-countdown-number" data-countdown-seconds>00</span>
                            <span class="aiq-countdown-label"><?php esc_html_e( 'Seconds', 'aiqengage' ); ?></span>
                        </div>
                    <?php endif; ?>
                </div>
                
                <!-- Screen reader announcement -->
                <div class="sr-only" aria-live="polite" aria-atomic="true"></div>
            </div>
            
            <?php if ( 'message' === $settings['after_expiry'] && ! empty( $settings['expiry_message'] ) ) : ?>
                <div class="aiq-evergreen-expired" style="display: none;">
                    <?php echo wp_kses_post( wpautop( $settings['expiry_message'] ) ); ?>
                </div>
            <?php endif; ?>
            
            <?php if ( 'modal' === $settings['display_style'] ) : ?>
                </div>
            <?php endif; ?>
        </div>
        <?php
    }

    /**
     * Get script dependencies.
     */
    public function get_script_depends() {
        return [ 'aiq-evergreen-countdown' ];
    }

    /**
     * Get style dependencies.
     */
    public function get_style_depends() {
        return [ 'aiq-evergreen-countdown' ];
    }
}
