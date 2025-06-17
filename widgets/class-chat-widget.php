// widgets/class-chat-widget.php

<?php
/**
 * AIQEngage Chat Widget
 *
 * @package AIQEngage
 */

// If this file is called directly, abort.
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Class Chat_Widget
 */
class AIQ_Chat_Widget extends \Elementor\Widget_Base {

    /**
     * Get widget name.
     *
     * @return string Widget name.
     */
    public function get_name() {
        return 'aiq_chat_widget';
    }

    /**
     * Get widget title.
     *
     * @return string Widget title.
     */
    public function get_title() {
        return esc_html__( 'AI Chat Assistant', 'aiqengage' );
    }

    /**
     * Get widget icon.
     *
     * @return string Widget icon.
     */
    public function get_icon() {
        return 'eicon-comments';
    }

    /**
     * Get widget keywords.
     *
     * @return array Widget keywords.
     */
    public function get_keywords() {
        return [ 'chat', 'ai', 'assistant', 'help', 'guidance', 'conversation' ];
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

        // General Settings
        $this->start_controls_section(
            'section_general',
            [
                'label' => esc_html__( 'General Settings', 'aiqengage' ),
                'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'chat_title',
            [
                'label'       => esc_html__( 'Chat Title', 'aiqengage' ),
                'type'        => \Elementor\Controls_Manager::TEXT,
                'default'     => esc_html__( 'Your Personal AI Guide', 'aiqengage' ),
                'placeholder' => esc_html__( 'Enter chat title', 'aiqengage' ),
                'label_block' => true,
            ]
        );

        $this->add_control(
            'chat_subtitle',
            [
                'label'       => esc_html__( 'Chat Subtitle', 'aiqengage' ),
                'type'        => \Elementor\Controls_Manager::TEXT,
                'default'     => esc_html__( 'Let Claude help you find the perfect automation solution', 'aiqengage' ),
                'placeholder' => esc_html__( 'Enter chat subtitle', 'aiqengage' ),
                'label_block' => true,
            ]
        );

        $this->add_control(
            'layout_type',
            [
                'label'   => esc_html__( 'Layout Type', 'aiqengage' ),
                'type'    => \Elementor\Controls_Manager::SELECT,
                'default' => 'standard',
                'options' => [
                    'standard' => esc_html__( 'Standard (Full Width)', 'aiqengage' ),
                    'floating' => esc_html__( 'Floating Bubble', 'aiqengage' ),
                ],
            ]
        );

        $this->end_controls_section();

        // AI Assistant Settings
        $this->start_controls_section(
            'section_ai_assistant',
            [
                'label' => esc_html__( 'AI Assistant Settings', 'aiqengage' ),
                'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'ai_name',
            [
                'label'       => esc_html__( 'AI Assistant Name', 'aiqengage' ),
                'type'        => \Elementor\Controls_Manager::TEXT,
                'default'     => esc_html__( 'Claude', 'aiqengage' ),
                'placeholder' => esc_html__( 'Enter AI name', 'aiqengage' ),
            ]
        );

        $this->add_control(
            'ai_avatar',
            [
                'label'   => esc_html__( 'AI Avatar', 'aiqengage' ),
                'type'    => \Elementor\Controls_Manager::MEDIA,
                'default' => [
                    'url' => \Elementor\Utils::get_placeholder_image_src(),
                ],
            ]
        );

        $this->add_control(
            'greeting_message',
            [
                'label'       => esc_html__( 'Greeting Message', 'aiqengage' ),
                'type'        => \Elementor\Controls_Manager::TEXTAREA,
                'default'     => esc_html__( 'Hi! I\'m your AI guide. What are you looking to achieve with Claude?', 'aiqengage' ),
                'placeholder' => esc_html__( 'Enter greeting message', 'aiqengage' ),
                'rows'        => 5,
            ]
        );

        $this->end_controls_section();

        // Sample Messages
        $this->start_controls_section(
            'section_sample_messages',
            [
                'label' => esc_html__( 'Sample Messages', 'aiqengage' ),
                'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );

        $repeater = new \Elementor\Repeater();

        $repeater->add_control(
            'sender',
            [
                'label'   => esc_html__( 'Sender', 'aiqengage' ),
                'type'    => \Elementor\Controls_Manager::SELECT,
                'default' => 'ai',
                'options' => [
                    'ai'   => esc_html__( 'AI Assistant', 'aiqengage' ),
                    'user' => esc_html__( 'User', 'aiqengage' ),
                ],
            ]
        );

        $repeater->add_control(
            'message',
            [
                'label'       => esc_html__( 'Message', 'aiqengage' ),
                'type'        => \Elementor\Controls_Manager::TEXTAREA,
                'default'     => esc_html__( 'Sample message', 'aiqengage' ),
                'placeholder' => esc_html__( 'Enter message', 'aiqengage' ),
                'rows'        => 3,
            ]
        );

        $repeater->add_control(
            'is_quick_reply',
            [
                'label'        => esc_html__( 'Is Quick Reply Button', 'aiqengage' ),
                'type'         => \Elementor\Controls_Manager::SWITCHER,
                'label_on'     => esc_html__( 'Yes', 'aiqengage' ),
                'label_off'    => esc_html__( 'No', 'aiqengage' ),
                'return_value' => 'yes',
                'default'      => 'no',
                'condition'    => [
                    'sender' => 'ai',
                ],
            ]
        );

        $this->add_control(
            'sample_messages',
            [
                'label'       => esc_html__( 'Messages', 'aiqengage' ),
                'type'        => \Elementor\Controls_Manager::REPEATER,
                'fields'      => $repeater->get_controls(),
                'default'     => [
                    [
                        'sender'  => 'ai',
                        'message' => esc_html__( 'Hi! I\'m your AI guide. What are you looking to achieve with Claude?', 'aiqengage' ),
                    ],
                    [
                        'sender'        => 'ai',
                        'message'       => esc_html__( 'I want to generate more traffic', 'aiqengage' ),
                        'is_quick_reply' => 'yes',
                    ],
                    [
                        'sender'        => 'ai',
                        'message'       => esc_html__( 'I need help with conversions', 'aiqengage' ),
                        'is_quick_reply' => 'yes',
                    ],
                    [
                        'sender'        => 'ai',
                        'message'       => esc_html__( 'I\'m looking for content automation', 'aiqengage' ),
                        'is_quick_reply' => 'yes',
                    ],
                    [
                        'sender'        => 'ai',
                        'message'       => esc_html__( 'I want to set up affiliate systems', 'aiqengage' ),
                        'is_quick_reply' => 'yes',
                    ],
                ],
                'title_field' => '{{{ sender }}}: {{{ message }}}',
            ]
        );

        $this->end_controls_section();

        // API Integration
        $this->start_controls_section(
            'section_api_integration',
            [
                'label' => esc_html__( 'API Integration', 'aiqengage' ),
                'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'enable_api',
            [
                'label'        => esc_html__( 'Enable API Integration', 'aiqengage' ),
                'type'         => \Elementor\Controls_Manager::SWITCHER,
                'label_on'     => esc_html__( 'Yes', 'aiqengage' ),
                'label_off'    => esc_html__( 'No', 'aiqengage' ),
                'return_value' => 'yes',
                'default'      => 'no',
            ]
        );

        $this->add_control(
            'api_endpoint',
            [
                'label'       => esc_html__( 'API Endpoint URL', 'aiqengage' ),
                'type'        => \Elementor\Controls_Manager::TEXT,
                'placeholder' => esc_html__( 'https://your-api-endpoint.com/chat', 'aiqengage' ),
                'label_block' => true,
                'condition'   => [
                    'enable_api' => 'yes',
                ],
            ]
        );

        $this->add_control(
            'api_instructions',
            [
                'type'            => \Elementor\Controls_Manager::RAW_HTML,
                'raw'             => esc_html__( 'The API endpoint should accept POST requests with a JSON body containing {"message": "user message"} and return {"response": "AI response"}', 'aiqengage' ),
                'content_classes' => 'elementor-descriptor',
                'condition'       => [
                    'enable_api' => 'yes',
                ],
            ]
        );

        $this->add_control(
            'fallback_message',
            [
                'label'       => esc_html__( 'Fallback Message', 'aiqengage' ),
                'type'        => \Elementor\Controls_Manager::TEXTAREA,
                'default'     => esc_html__( 'I\'m having trouble connecting right now. Please try again later or contact support.', 'aiqengage' ),
                'placeholder' => esc_html__( 'Enter fallback message', 'aiqengage' ),
                'rows'        => 4,
                'condition'   => [
                    'enable_api' => 'yes',
                ],
            ]
        );

        $this->end_controls_section();

        // Input Settings
        $this->start_controls_section(
            'section_input_settings',
            [
                'label' => esc_html__( 'Input Settings', 'aiqengage' ),
                'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'input_placeholder',
            [
                'label'       => esc_html__( 'Input Placeholder', 'aiqengage' ),
                'type'        => \Elementor\Controls_Manager::TEXT,
                'default'     => esc_html__( 'Type your message here...', 'aiqengage' ),
                'placeholder' => esc_html__( 'Enter placeholder text', 'aiqengage' ),
            ]
        );

        $this->add_control(
            'button_text',
            [
                'label'       => esc_html__( 'Send Button Text', 'aiqengage' ),
                'type'        => \Elementor\Controls_Manager::TEXT,
                'default'     => esc_html__( 'Send', 'aiqengage' ),
                'placeholder' => esc_html__( 'Enter button text', 'aiqengage' ),
            ]
        );

        $this->add_control(
            'send_on_enter',
            [
                'label'        => esc_html__( 'Send on Enter', 'aiqengage' ),
                'type'         => \Elementor\Controls_Manager::SWITCHER,
                'label_on'     => esc_html__( 'Yes', 'aiqengage' ),
                'label_off'    => esc_html__( 'No', 'aiqengage' ),
                'return_value' => 'yes',
                'default'      => 'yes',
            ]
        );

        $this->add_control(
            'show_quick_replies',
            [
                'label'        => esc_html__( 'Show Quick Replies', 'aiqengage' ),
                'type'         => \Elementor\Controls_Manager::SWITCHER,
                'label_on'     => esc_html__( 'Yes', 'aiqengage' ),
                'label_off'    => esc_html__( 'No', 'aiqengage' ),
                'return_value' => 'yes',
                'default'      => 'yes',
            ]
        );

        $this->end_controls_section();

        // Additional Information
        $this->start_controls_section(
            'section_additional_info',
            [
                'label' => esc_html__( 'Additional Information', 'aiqengage' ),
                'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'show_privacy_notice',
            [
                'label'        => esc_html__( 'Show Privacy Notice', 'aiqengage' ),
                'type'         => \Elementor\Controls_Manager::SWITCHER,
                'label_on'     => esc_html__( 'Yes', 'aiqengage' ),
                'label_off'    => esc_html__( 'No', 'aiqengage' ),
                'return_value' => 'yes',
                'default'      => 'yes',
            ]
        );

        $this->add_control(
            'privacy_notice_text',
            [
                'label'       => esc_html__( 'Privacy Notice Text', 'aiqengage' ),
                'type'        => \Elementor\Controls_Manager::TEXTAREA,
                'default'     => esc_html__( 'This chat is for guidance only. Your conversation data is not stored.', 'aiqengage' ),
                'placeholder' => esc_html__( 'Enter privacy notice', 'aiqengage' ),
                'rows'        => 2,
                'condition'   => [
                    'show_privacy_notice' => 'yes',
                ],
            ]
        );

        $this->add_control(
            'show_human_help',
            [
                'label'        => esc_html__( 'Show Human Help Option', 'aiqengage' ),
                'type'         => \Elementor\Controls_Manager::SWITCHER,
                'label_on'     => esc_html__( 'Yes', 'aiqengage' ),
                'label_off'    => esc_html__( 'No', 'aiqengage' ),
                'return_value' => 'yes',
                'default'      => 'yes',
            ]
        );

        $this->add_control(
            'human_help_text',
            [
                'label'       => esc_html__( 'Human Help Text', 'aiqengage' ),
                'type'        => \Elementor\Controls_Manager::TEXT,
                'default'     => esc_html__( 'Need Human Help?', 'aiqengage' ),
                'placeholder' => esc_html__( 'Enter human help text', 'aiqengage' ),
                'condition'   => [
                    'show_human_help' => 'yes',
                ],
            ]
        );

        $this->add_control(
            'human_help_email',
            [
                'label'       => esc_html__( 'Contact Email', 'aiqengage' ),
                'type'        => \Elementor\Controls_Manager::TEXT,
                'default'     => esc_html__( 'support@aiqengage.com', 'aiqengage' ),
                'placeholder' => esc_html__( 'Enter contact email', 'aiqengage' ),
                'condition'   => [
                    'show_human_help' => 'yes',
                ],
            ]
        );

        $this->end_controls_section();

        // Style - Container
        $this->start_controls_section(
            'section_style_container',
            [
                'label' => esc_html__( 'Container', 'aiqengage' ),
                'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'chat_height',
            [
                'label'      => esc_html__( 'Chat Height', 'aiqengage' ),
                'type'       => \Elementor\Controls_Manager::SLIDER,
                'size_units' => [ 'px', 'vh' ],
                'range'      => [
                    'px' => [
                        'min'  => 300,
                        'max'  => 800,
                        'step' => 10,
                    ],
                    'vh' => [
                        'min'  => 30,
                        'max'  => 90,
                        'step' => 5,
                    ],
                ],
                'default'    => [
                    'unit' => 'px',
                    'size' => 500,
                ],
                'selectors'  => [
                    '{{WRAPPER}} .aiq-chat__container' => 'height: {{SIZE}}{{UNIT}};',
                ],
                'condition'  => [
                    'layout_type' => 'standard',
                ],
            ]
        );

        $this->add_control(
            'chat_max_width',
            [
                'label'      => esc_html__( 'Chat Max Width', 'aiqengage' ),
                'type'       => \Elementor\Controls_Manager::SLIDER,
                'size_units' => [ 'px', '%' ],
                'range'      => [
                    'px' => [
                        'min'  => 300,
                        'max'  => 1200,
                        'step' => 10,
                    ],
                    '%'  => [
                        'min'  => 50,
                        'max'  => 100,
                        'step' => 5,
                    ],
                ],
                'default'    => [
                    'unit' => 'px',
                    'size' => 800,
                ],
                'selectors'  => [
                    '{{WRAPPER}} .aiq-chat' => 'max-width: {{SIZE}}{{UNIT}};',
                ],
                'condition'  => [
                    'layout_type' => 'standard',
                ],
            ]
        );

        $this->add_control(
            'bubble_size',
            [
                'label'      => esc_html__( 'Bubble Size', 'aiqengage' ),
                'type'       => \Elementor\Controls_Manager::SLIDER,
                'size_units' => [ 'px' ],
                'range'      => [
                    'px' => [
                        'min'  => 40,
                        'max'  => 80,
                        'step' => 5,
                    ],
                ],
                'default'    => [
                    'unit' => 'px',
                    'size' => 60,
                ],
                'selectors'  => [
                    '{{WRAPPER}} .aiq-chat--floating .aiq-chat__bubble' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
                ],
                'condition'  => [
                    'layout_type' => 'floating',
                ],
            ]
        );

        $this->add_control(
            'chat_background',
            [
                'label'     => esc_html__( 'Chat Background', 'aiqengage' ),
                'type'      => \Elementor\Controls_Manager::COLOR,
                'default'   => '#2A1958',
                'selectors' => [
                    '{{WRAPPER}} .aiq-chat__container' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name'     => 'chat_border',
                'selector' => '{{WRAPPER}} .aiq-chat__container',
            ]
        );

        $this->add_responsive_control(
            'chat_border_radius',
            [
                'label'      => esc_html__( 'Border Radius', 'aiqengage' ),
                'type'       => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%' ],
                'default'    => [
                    'top'      => 15,
                    'right'    => 15,
                    'bottom'   => 15,
                    'left'     => 15,
                    'unit'     => 'px',
                    'isLinked' => true,
                ],
                'selectors'  => [
                    '{{WRAPPER}} .aiq-chat__container' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Box_Shadow::get_type(),
            [
                'name'     => 'chat_box_shadow',
                'selector' => '{{WRAPPER}} .aiq-chat__container',
            ]
        );

        $this->end_controls_section();

        // Style - Header
        $this->start_controls_section(
            'section_style_header',
            [
                'label' => esc_html__( 'Header', 'aiqengage' ),
                'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'header_background',
            [
                'label'     => esc_html__( 'Header Background', 'aiqengage' ),
                'type'      => \Elementor\Controls_Manager::COLOR,
                'default'   => '#1A0938',
                'selectors' => [
                    '{{WRAPPER}} .aiq-chat__header' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'header_text_color',
            [
                'label'     => esc_html__( 'Header Text Color', 'aiqengage' ),
                'type'      => \Elementor\Controls_Manager::COLOR,
                'default'   => '#E0D6FF',
                'selectors' => [
                    '{{WRAPPER}} .aiq-chat__title'    => 'color: {{VALUE}};',
                    '{{WRAPPER}} .aiq-chat__subtitle' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name'     => 'header_title_typography',
                'label'    => esc_html__( 'Title Typography', 'aiqengage' ),
                'selector' => '{{WRAPPER}} .aiq-chat__title',
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name'     => 'header_subtitle_typography',
                'label'    => esc_html__( 'Subtitle Typography', 'aiqengage' ),
                'selector' => '{{WRAPPER}} .aiq-chat__subtitle',
            ]
        );

        $this->add_responsive_control(
            'header_padding',
            [
                'label'      => esc_html__( 'Padding', 'aiqengage' ),
                'type'       => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em', '%' ],
                'default'    => [
                    'top'      => 15,
                    'right'    => 15,
                    'bottom'   => 15,
                    'left'     => 15,
                    'unit'     => 'px',
                    'isLinked' => true,
                ],
                'selectors'  => [
                    '{{WRAPPER}} .aiq-chat__header' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();

        // Style - Messages
        $this->start_controls_section(
            'section_style_messages',
            [
                'label' => esc_html__( 'Messages', 'aiqengage' ),
                'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'message_spacing',
            [
                'label'      => esc_html__( 'Message Spacing', 'aiqengage' ),
                'type'       => \Elementor\Controls_Manager::SLIDER,
                'size_units' => [ 'px' ],
                'range'      => [
                    'px' => [
                        'min'  => 5,
                        'max'  => 30,
                        'step' => 1,
                    ],
                ],
                'default'    => [
                    'unit' => 'px',
                    'size' => 15,
                ],
                'selectors'  => [
                    '{{WRAPPER}} .aiq-chat__message' => 'margin-bottom: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'message_padding',
            [
                'label'      => esc_html__( 'Message Padding', 'aiqengage' ),
                'type'       => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em' ],
                'default'    => [
                    'top'      => 10,
                    'right'    => 15,
                    'bottom'   => 10,
                    'left'     => 15,
                    'unit'     => 'px',
                    'isLinked' => false,
                ],
                'selectors'  => [
                    '{{WRAPPER}} .aiq-chat__message-bubble' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'message_border_radius',
            [
                'label'      => esc_html__( 'Message Border Radius', 'aiqengage' ),
                'type'       => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%' ],
                'default'    => [
                    'top'      => 15,
                    'right'    => 15,
                    'bottom'   => 15,
                    'left'     => 15,
                    'unit'     => 'px',
                    'isLinked' => true,
                ],
                'selectors'  => [
                    '{{WRAPPER}} .aiq-chat__message-bubble' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        // AI Message Styles
        $this->add_control(
            'ai_message_heading',
            [
                'label'     => esc_html__( 'AI Messages', 'aiqengage' ),
                'type'      => \Elementor\Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );

        $this->add_control(
            'ai_message_background',
            [
                'label'     => esc_html__( 'Background Color', 'aiqengage' ),
                'type'      => \Elementor\Controls_Manager::COLOR,
                'default'   => '#1A0938',
                'selectors' => [
                    '{{WRAPPER}} .aiq-chat__message--ai .aiq-chat__message-bubble' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'ai_message_text_color',
            [
                'label'     => esc_html__( 'Text Color', 'aiqengage' ),
                'type'      => \Elementor\Controls_Manager::COLOR,
                'default'   => '#E0D6FF',
                'selectors' => [
                    '{{WRAPPER}} .aiq-chat__message--ai .aiq-chat__message-bubble' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name'     => 'ai_message_typography',
                'label'    => esc_html__( 'Typography', 'aiqengage' ),
                'selector' => '{{WRAPPER}} .aiq-chat__message--ai .aiq-chat__message-bubble',
            ]
        );

        // User Message Styles
        $this->add_control(
            'user_message_heading',
            [
                'label'     => esc_html__( 'User Messages', 'aiqengage' ),
                'type'      => \Elementor\Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );

        $this->add_control(
            'user_message_background',
            [
                'label'     => esc_html__( 'Background Color', 'aiqengage' ),
                'type'      => \Elementor\Controls_Manager::COLOR,
                'default'   => '#9C4DFF',
                'selectors' => [
                    '{{WRAPPER}} .aiq-chat__message--user .aiq-chat__message-bubble' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'user_message_text_color',
            [
                'label'     => esc_html__( 'Text Color', 'aiqengage' ),
                'type'      => \Elementor\Controls_Manager::COLOR,
                'default'   => '#FFFFFF',
                'selectors' => [
                    '{{WRAPPER}} .aiq-chat__message--user .aiq-chat__message-bubble' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name'     => 'user_message_typography',
                'label'    => esc_html__( 'Typography', 'aiqengage' ),
                'selector' => '{{WRAPPER}} .aiq-chat__message--user .aiq-chat__message-bubble',
            ]
        );

        // Quick Reply Styles
        $this->add_control(
            'quick_reply_heading',
            [
                'label'     => esc_html__( 'Quick Reply Buttons', 'aiqengage' ),
                'type'      => \Elementor\Controls_Manager::HEADING,
                'separator' => 'before',
                'condition' => [
                    'show_quick_replies' => 'yes',
                ],
            ]
        );

        $this->add_control(
            'quick_reply_background',
            [
                'label'     => esc_html__( 'Background Color', 'aiqengage' ),
                'type'      => \Elementor\Controls_Manager::COLOR,
                'default'   => 'rgba(126, 87, 194, 0.2)',
                'selectors' => [
                    '{{WRAPPER}} .aiq-chat__quick-reply-btn' => 'background-color: {{VALUE}};',
                ],
                'condition' => [
                    'show_quick_replies' => 'yes',
                ],
            ]
        );

        $this->add_control(
            'quick_reply_text_color',
            [
                'label'     => esc_html__( 'Text Color', 'aiqengage' ),
                'type'      => \Elementor\Controls_Manager::COLOR,
                'default'   => '#E0D6FF',
                'selectors' => [
                    '{{WRAPPER}} .aiq-chat__quick-reply-btn' => 'color: {{VALUE}};',
                ],
                'condition' => [
                    'show_quick_replies' => 'yes',
                ],
            ]
        );

        $this->add_control(
            'quick_reply_border_color',
            [
                'label'     => esc_html__( 'Border Color', 'aiqengage' ),
                'type'      => \Elementor\Controls_Manager::COLOR,
                'default'   => '#9C4DFF',
                'selectors' => [
                    '{{WRAPPER}} .aiq-chat__quick-reply-btn' => 'border-color: {{VALUE}};',
                ],
                'condition' => [
                    'show_quick_replies' => 'yes',
                ],
            ]
        );

        $this->end_controls_section();

        // Style - Input Area
        $this->start_controls_section(
            'section_style_input',
            [
                'label' => esc_html__( 'Input Area', 'aiqengage' ),
                'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'input_background',
            [
                'label'     => esc_html__( 'Input Background', 'aiqengage' ),
                'type'      => \Elementor\Controls_Manager::COLOR,
                'default'   => 'rgba(26, 9, 56, 0.6)',
                'selectors' => [
                    '{{WRAPPER}} .aiq-chat__input' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'input_text_color',
            [
                'label'     => esc_html__( 'Input Text Color', 'aiqengage' ),
                'type'      => \Elementor\Controls_Manager::COLOR,
                'default'   => '#E0D6FF',
                'selectors' => [
                    '{{WRAPPER}} .aiq-chat__input'        => 'color: {{VALUE}};',
                    '{{WRAPPER}} .aiq-chat__input::placeholder' => 'color: {{VALUE}}; opacity: 0.6;',
                ],
            ]
        );

        $this->add_control(
            'input_border_color',
            [
                'label'     => esc_html__( 'Input Border Color', 'aiqengage' ),
                'type'      => \Elementor\Controls_Manager::COLOR,
                'default'   => 'rgba(156, 77, 255, 0.3)',
                'selectors' => [
                    '{{WRAPPER}} .aiq-chat__input' => 'border-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'input_focus_border_color',
            [
                'label'     => esc_html__( 'Input Focus Border Color', 'aiqengage' ),
                'type'      => \Elementor\Controls_Manager::COLOR,
                'default'   => '#9C4DFF',
                'selectors' => [
                    '{{WRAPPER}} .aiq-chat__input:focus' => 'border-color: {{VALUE}}; box-shadow: 0 0 0 3px rgba(156, 77, 255, 0.3);',
                ],
            ]
        );

        $this->add_control(
            'button_background',
            [
                'label'     => esc_html__( 'Button Background', 'aiqengage' ),
                'type'      => \Elementor\Controls_Manager::COLOR,
                'default'   => '#9C4DFF',
                'selectors' => [
                    '{{WRAPPER}} .aiq-chat__send-btn' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'button_text_color',
            [
                'label'     => esc_html__( 'Button Text Color', 'aiqengage' ),
                'type'      => \Elementor\Controls_Manager::COLOR,
                'default'   => '#FFFFFF',
                'selectors' => [
                    '{{WRAPPER}} .aiq-chat__send-btn' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'button_hover_background',
            [
                'label'     => esc_html__( 'Button Hover Background', 'aiqengage' ),
                'type'      => \Elementor\Controls_Manager::COLOR,
                'default'   => '#8E6BFF',
                'selectors' => [
                    '{{WRAPPER}} .aiq-chat__send-btn:hover' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'input_padding',
            [
                'label'      => esc_html__( 'Input Padding', 'aiqengage' ),
                'type'       => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em' ],
                'default'    => [
                    'top'      => 10,
                    'right'    => 15,
                    'bottom'   => 10,
                    'left'     => 15,
                    'unit'     => 'px',
                    'isLinked' => false,
                ],
                'selectors'  => [
                    '{{WRAPPER}} .aiq-chat__input' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'input_height',
            [
                'label'      => esc_html__( 'Input Height', 'aiqengage' ),
                'type'       => \Elementor\Controls_Manager::SLIDER,
                'size_units' => [ 'px' ],
                'range'      => [
                    'px' => [
                        'min'  => 40,
                        'max'  => 80,
                        'step' => 1,
                    ],
                ],
                'default'    => [
                    'unit' => 'px',
                    'size' => 48,
                ],
                'selectors'  => [
                    '{{WRAPPER}} .aiq-chat__input' => 'height: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'input_border_radius',
            [
                'label'      => esc_html__( 'Input Border Radius', 'aiqengage' ),
                'type'       => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%' ],
                'default'    => [
                    'top'      => 8,
                    'right'    => 8,
                    'bottom'   => 8,
                    'left'     => 8,
                    'unit'     => 'px',
                    'isLinked' => true,
                ],
                'selectors'  => [
                    '{{WRAPPER}} .aiq-chat__input' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'button_border_radius',
            [
                'label'      => esc_html__( 'Button Border Radius', 'aiqengage' ),
                'type'       => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%' ],
                'default'    => [
                    'top'      => 8,
                    'right'    => 8,
                    'bottom'   => 8,
                    'left'     => 8,
                    'unit'     => 'px',
                    'isLinked' => true,
                ],
                'selectors'  => [
                    '{{WRAPPER}} .aiq-chat__send-btn' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();

        // Style - Additional Info
        $this->start_controls_section(
            'section_style_additional_info',
            [
                'label' => esc_html__( 'Additional Information', 'aiqengage' ),
                'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'info_text_color',
            [
                'label'     => esc_html__( 'Text Color', 'aiqengage' ),
                'type'      => \Elementor\Controls_Manager::COLOR,
                'default'   => 'rgba(224, 214, 255, 0.6)',
                'selectors' => [
                    '{{WRAPPER}} .aiq-chat__privacy-notice' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .aiq-chat__human-help'     => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'info_link_color',
            [
                'label'     => esc_html__( 'Link Color', 'aiqengage' ),
                'type'      => \Elementor\Controls_Manager::COLOR,
                'default'   => '#9C4DFF',
                'selectors' => [
                    '{{WRAPPER}} .aiq-chat__human-help a' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name'     => 'info_typography',
                'label'    => esc_html__( 'Typography', 'aiqengage' ),
                'selector' => '{{WRAPPER}} .aiq-chat__privacy-notice, {{WRAPPER}} .aiq-chat__human-help',
            ]
        );

        $this->add_responsive_control(
            'info_padding',
            [
                'label'      => esc_html__( 'Padding', 'aiqengage' ),
                'type'       => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em', '%' ],
                'default'    => [
                    'top'      => 10,
                    'right'    => 15,
                    'bottom'   => 10,
                    'left'     => 15,
                    'unit'     => 'px',
                    'isLinked' => false,
                ],
                'selectors'  => [
                    '{{WRAPPER}} .aiq-chat__footer' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
        $widget_id = $this->get_id();

        // Get AI avatar URL
        $ai_avatar_url = isset( $settings['ai_avatar']['url'] ) ? $settings['ai_avatar']['url'] : \Elementor\Utils::get_placeholder_image_src();

        // Chat layout class
        $layout_class = 'standard' === $settings['layout_type'] ? 'aiq-chat--standard' : 'aiq-chat--floating';

        // Create unique ID for the chat
        $chat_id = 'aiq-chat-' . $widget_id;

        // Get quick replies from sample messages
        $quick_replies = [];
        if ( $settings['show_quick_replies'] === 'yes' && ! empty( $settings['sample_messages'] ) ) {
            foreach ( $settings['sample_messages'] as $message ) {
                if ( isset( $message['is_quick_reply'] ) && 'yes' === $message['is_quick_reply'] ) {
                    $quick_replies[] = $message['message'];
                }
            }
        }

        // Convert settings to JSON for JavaScript
        $js_settings = [
            'id'                => $chat_id,
            'aiName'            => $settings['ai_name'],
            'aiAvatar'          => $ai_avatar_url,
            'greetingMessage'   => $settings['greeting_message'],
            'enableApi'         => $settings['enable_api'],
            'apiEndpoint'       => $settings['api_endpoint'],
            'fallbackMessage'   => $settings['fallback_message'],
            'sendOnEnter'       => $settings['send_on_enter'],
            'showQuickReplies'  => $settings['show_quick_replies'],
            'quickReplies'      => $quick_replies,
            'layoutType'        => $settings['layout_type'],
        ];

        // Output HTML
        ?>
        <div class="aiq-chat <?php echo esc_attr( $layout_class ); ?>" id="<?php echo esc_attr( $chat_id ); ?>" data-settings='<?php echo esc_attr( wp_json_encode( $js_settings ) ); ?>'>
            <?php if ( 'floating' === $settings['layout_type'] ) : ?>
                <div class="aiq-chat__bubble" aria-label="<?php echo esc_attr__( 'Open chat assistant', 'aiqengage' ); ?>" role="button" tabindex="0">
                    <img src="<?php echo esc_url( $ai_avatar_url ); ?>" alt="<?php echo esc_attr( $settings['ai_name'] ); ?>" class="aiq-chat__bubble-avatar">
                </div>
            <?php endif; ?>

            <div class="aiq-chat__container" <?php echo 'floating' === $settings['layout_type'] ? 'style="display: none;"' : ''; ?>>
                <div class="aiq-chat__header">
                    <div class="aiq-chat__header-content">
                        <h3 class="aiq-chat__title"><?php echo esc_html( $settings['chat_title'] ); ?></h3>
                        <p class="aiq-chat__subtitle"><?php echo esc_html( $settings['chat_subtitle'] ); ?></p>
                    </div>
                    <?php if ( 'floating' === $settings['layout_type'] ) : ?>
                        <button type="button" class="aiq-chat__close" aria-label="<?php echo esc_attr__( 'Close chat', 'aiqengage' ); ?>">×</button>
                    <?php endif; ?>
                </div>

                <div class="aiq-chat__messages" aria-live="polite">
                    <!-- Messages will be added here by JavaScript -->
                </div>

                <div class="aiq-chat__quick-replies" style="display: none;">
                    <!-- Quick reply buttons will be added here by JavaScript -->
                </div>

                <div class="aiq-chat__input-container">
                    <div class="aiq-chat__typing-indicator" style="display: none;">
                        <span></span>
                        <span></span>
                        <span></span>
                    </div>
                    <textarea 
                        class="aiq-chat__input" 
                        placeholder="<?php echo esc_attr( $settings['input_placeholder'] ); ?>"
                        aria-label="<?php echo esc_attr__( 'Type your message', 'aiqengage' ); ?>"
                        rows="1"
                    ></textarea>
                    <button type="button" class="aiq-chat__send-btn" aria-label="<?php echo esc_attr__( 'Send message', 'aiqengage' ); ?>">
                        <?php echo esc_html( $settings['button_text'] ); ?>
                    </button>
                </div>

                <?php if ( $settings['show_privacy_notice'] === 'yes' || $settings['show_human_help'] === 'yes' ) : ?>
                    <div class="aiq-chat__footer">
                        <?php if ( $settings['show_privacy_notice'] === 'yes' ) : ?>
                            <p class="aiq-chat__privacy-notice">
                                <?php echo esc_html( $settings['privacy_notice_text'] ); ?>
                            </p>
                        <?php endif; ?>
                        
                        <?php if ( $settings['show_human_help'] === 'yes' ) : ?>
                            <p class="aiq-chat__human-help">
                                <?php echo esc_html( $settings['human_help_text'] ); ?> 
                                <a href="mailto:<?php echo esc_attr( $settings['human_help_email'] ); ?>">
                                    <?php echo esc_html( $settings['human_help_email'] ); ?>
                                </a>
                            </p>
                        <?php endif; ?>
                    </div>
                <?php endif; ?>
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
        var chatId = 'aiq-chat-' + view.getID();
        var layoutClass = 'standard' === settings.layout_type ? 'aiq-chat--standard' : 'aiq-chat--floating';
        var aiAvatarUrl = settings.ai_avatar.url ? settings.ai_avatar.url : elementorCommon.config.urls.assets + 'images/placeholder.png';
        
        // Get quick replies
        var quickReplies = [];
        if ( settings.show_quick_replies === 'yes' && settings.sample_messages.length > 0 ) {
            _.each( settings.sample_messages, function( message ) {
                if ( message.is_quick_reply === 'yes' ) {
                    quickReplies.push( message.message );
                }
            });
        }
        
        // Create settings object for JavaScript
        var jsSettings = {
            id: chatId,
            aiName: settings.ai_name,
            aiAvatar: aiAvatarUrl,
            greetingMessage: settings.greeting_message,
            enableApi: settings.enable_api,
            apiEndpoint: settings.api_endpoint,
            fallbackMessage: settings.fallback_message,
            sendOnEnter: settings.send_on_enter,
            showQuickReplies: settings.show_quick_replies,
            quickReplies: quickReplies,
            layoutType: settings.layout_type
        };
        #>
        <div class="aiq-chat {{ layoutClass }}" id="{{ chatId }}" data-settings='{{{ JSON.stringify(jsSettings) }}}'>
            <# if ( 'floating' === settings.layout_type ) { #>
                <div class="aiq-chat__bubble" aria-label="Open chat assistant" role="button" tabindex="0">
                    <img src="{{ aiAvatarUrl }}" alt="{{ settings.ai_name }}" class="aiq-chat__bubble-avatar">
                </div>
            <# } #>

            <div class="aiq-chat__container" <# if ( 'floating' === settings.layout_type ) { #>style="display: none;"<# } #>>
                <div class="aiq-chat__header">
                    <div class="aiq-chat__header-content">
                        <h3 class="aiq-chat__title">{{ settings.chat_title }}</h3>
                        <p class="aiq-chat__subtitle">{{ settings.chat_subtitle }}</p>
                    </div>
                    <# if ( 'floating' === settings.layout_type ) { #>
                        <button type="button" class="aiq-chat__close" aria-label="Close chat">×</button>
                    <# } #>
                </div>

                <div class="aiq-chat__messages" aria-live="polite">
                    <!-- Messages will be added here by JavaScript -->
                </div>

                <div class="aiq-chat__quick-replies" style="display: none;">
                    <!-- Quick reply buttons will be added here by JavaScript -->
                </div>

                <div class="aiq-chat__input-container">
                    <div class="aiq-chat__typing-indicator" style="display: none;">
                        <span></span>
                        <span></span>
                        <span></span>
                    </div>
                    <textarea 
                        class="aiq-chat__input" 
                        placeholder="{{ settings.input_placeholder }}"
                        aria-label="Type your message"
                        rows="1"
                    ></textarea>
                    <button type="button" class="aiq-chat__send-btn" aria-label="Send message">
                        {{ settings.button_text }}
                    </button>
                </div>

                <# if ( settings.show_privacy_notice === 'yes' || settings.show_human_help === 'yes' ) { #>
                    <div class="aiq-chat__footer">
                        <# if ( settings.show_privacy_notice === 'yes' ) { #>
                            <p class="aiq-chat__privacy-notice">
                                {{ settings.privacy_notice_text }}
                            </p>
                        <# } #>
                        
                        <# if ( settings.show_human_help === 'yes' ) { #>
                            <p class="aiq-chat__human-help">
                                {{ settings.human_help_text }} 
                                <a href="mailto:{{ settings.human_help_email }}">
                                    {{ settings.human_help_email }}
                                </a>
                            </p>
                        <# } #>
                    </div>
                <# } #>
            </div>
        </div>
        <?php
    }
}

// Register widget
add_action( 'elementor/widgets/register', function ( $widgets_manager ) {
    $widgets_manager->register( new AIQ_Chat_Widget() );
});
