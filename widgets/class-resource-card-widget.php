<?php
/**
 * Enhanced Resource Card Widget
 *
 * @package aiqengage-child
 * @version 1.0.0
 * @since   1.0.0
 * @author  Jason
 */

if (!defined('ABSPATH')) exit;

class AIQ_Resource_Card_Widget extends \Elementor\Widget_Base {

    public function get_name() {
        return 'aiq_resource_card';
    }

    public function get_title() {
        return esc_html__('Enhanced Resource Card', 'aiqengage-child');
    }

    public function get_icon() {
        return 'eicon-download-button';
    }

    public function get_keywords() {
        return ['resource', 'download', 'card', 'asset', 'file', 'media'];
    }

    public function get_categories() {
        return ['aiqengage'];
    }

    /**
     * Get widget style dependencies.
     *
     * @return string[] CSS handles.
     */
    public function get_style_depends() {
        return [ 'aiq-resource-card' ];
    }

    /**
     * Get widget script dependencies.
     *
     * @return string[] JS handles.
     */
    public function get_script_depends() {
        return [ 'aiq-resource-card' ];
    }

    protected function register_controls() {
        $this->start_controls_section(
            'section_content',
            [
                'label' => esc_html__('Resource Content', 'aiqengage-child'),
                'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'resource_title',
            [
                'label' => esc_html__('Title', 'aiqengage-child'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => esc_html__('AI Automation Blueprint', 'aiqengage-child'),
                'label_block' => true,
                'dynamic' => [
                    'active' => true,
                ],
            ]
        );

        $this->add_control(
            'resource_description',
            [
                'label' => esc_html__('Description', 'aiqengage-child'),
                'type' => \Elementor\Controls_Manager::TEXTAREA,
                'default' => esc_html__('Step-by-step guide with proven results', 'aiqengage-child'),
                'rows' => 3,
                'dynamic' => [
                    'active' => true,
                ],
            ]
        );

        $this->add_control(
            'resource_type',
            [
                'label' => esc_html__('Resource Type', 'aiqengage-child'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => 'pdf',
                'options' => [
                    'pdf' => esc_html__('PDF', 'aiqengage-child'),
                    'zip' => esc_html__('ZIP', 'aiqengage-child'),
                    'video' => esc_html__('Video', 'aiqengage-child'),
                    'audio' => esc_html__('Audio', 'aiqengage-child'),
                    'image' => esc_html__('Images', 'aiqengage-child'),
                    'spreadsheet' => esc_html__('Spreadsheet', 'aiqengage-child'),
                    'template' => esc_html__('Template', 'aiqengage-child'),
                    'other' => esc_html__('Other', 'aiqengage-child'),
                ],
            ]
        );

        $this->add_control(
            'file_size',
            [
                'label' => esc_html__('File Size', 'aiqengage-child'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => '2.4 MB',
                'condition' => [
                    'resource_type!' => 'video',
                ],
            ]
        );

        $this->add_control(
            'resource_url',
            [
                'label' => esc_html__('Resource URL', 'aiqengage-child'),
                'type' => \Elementor\Controls_Manager::URL,
                'placeholder' => 'https://example.com/resource',
                'dynamic' => [
                    'active' => true,
                ],
            ]
        );

        $this->add_control(
            'video_embed_url',
            [
                'label' => esc_html__('Video Embed URL', 'aiqengage-child'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'placeholder' => 'https://youtube.com/embed/xyz',
                'condition' => [
                    'resource_type' => 'video',
                ],
                'dynamic' => [
                    'active' => true,
                ],
            ]
        );

        $this->add_control(
            'is_locked',
            [
                'label' => esc_html__('Requires Access', 'aiqengage-child'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => esc_html__('Yes', 'aiqengage-child'),
                'label_off' => esc_html__('No', 'aiqengage-child'),
                'return_value' => 'yes',
                'default' => 'no',
            ]
        );

        $this->add_control(
            'locked_message',
            [
                'label' => esc_html__('Locked Message', 'aiqengage-child'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => esc_html__('Upgrade to access this resource', 'aiqengage-child'),
                'condition' => [
                    'is_locked' => 'yes',
                ],
            ]
        );

        $this->add_control(
            'locked_redirect_url',
            [
                'label' => esc_html__('Upgrade URL', 'aiqengage-child'),
                'type' => \Elementor\Controls_Manager::URL,
                'placeholder' => 'https://example.com/upgrade',
                'condition' => [
                    'is_locked' => 'yes',
                ],
                'dynamic' => [
                    'active' => true,
                ],
            ]
        );

        $this->end_controls_section();

        // Visual Section
        $this->start_controls_section(
            'section_visual',
            [
                'label' => esc_html__('Visual', 'aiqengage-child'),
                'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'resource_thumbnail',
            [
                'label' => esc_html__('Thumbnail', 'aiqengage-child'),
                'type' => \Elementor\Controls_Manager::MEDIA,
                'default' => [
                    'url' => \Elementor\Utils::get_placeholder_image_src(),
                ],
                'dynamic' => [
                    'active' => true,
                ],
            ]
        );

        $this->add_control(
            'resource_icon',
            [
                'label' => esc_html__('Icon', 'aiqengage-child'),
                'type' => \Elementor\Controls_Manager::ICONS,
                'default' => [
                    'value' => 'fas fa-file-pdf',
                    'library' => 'fa-solid',
                ],
                'recommended' => [
                    'fa-solid' => [
                        'file-pdf',
                        'file-archive',
                        'file-video',
                        'file-audio',
                        'file-image',
                        'file-excel',
                        'file-alt',
                    ],
                ],
            ]
        );

        $this->add_control(
            'cta_label',
            [
                'label' => esc_html__('Button Text', 'aiqengage-child'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => esc_html__('Download Now', 'aiqengage-child'),
                'dynamic' => [
                    'active' => true,
                ],
            ]
        );

        $this->add_control(
            'locked_cta_label',
            [
                'label' => esc_html__('Locked Button Text', 'aiqengage-child'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => esc_html__('Upgrade to Access', 'aiqengage-child'),
                'condition' => [
                    'is_locked' => 'yes',
                ],
                'dynamic' => [
                    'active' => true,
                ],
            ]
        );

        $this->add_control(
            'show_downloads',
            [
                'label' => esc_html__('Show Download Count', 'aiqengage-child'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => esc_html__('Show', 'aiqengage-child'),
                'label_off' => esc_html__('Hide', 'aiqengage-child'),
                'return_value' => 'yes',
                'default' => 'yes',
            ]
        );

        $this->add_control(
            'download_count',
            [
                'label' => esc_html__('Download Count', 'aiqengage-child'),
                'type' => \Elementor\Controls_Manager::NUMBER,
                'default' => 1245,
                'condition' => [
                    'show_downloads' => 'yes',
                ],
                'dynamic' => [
                    'active' => true,
                ],
            ]
        );

        $this->end_controls_section();

        // Style Section
        $this->start_controls_section(
            'section_style',
            [
                'label' => esc_html__('Style', 'aiqengage-child'),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'card_background',
            [
                'label' => esc_html__('Background', 'aiqengage-child'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#2A1958',
                'selectors' => [
                    '{{WRAPPER}} .aiq-resource-card' => 'background-color: {{VALUE}}',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name' => 'card_border',
                'selector' => '{{WRAPPER}} .aiq-resource-card',
            ]
        );

        $this->add_control(
            'card_border_radius',
            [
                'label' => esc_html__('Border Radius', 'aiqengage-child'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors' => [
                    '{{WRAPPER}} .aiq-resource-card' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'card_box_shadow',
                'selector' => '{{WRAPPER}} .aiq-resource-card',
            ]
        );

        $this->add_control(
            'text_color',
            [
                'label' => esc_html__('Text Color', 'aiqengage-child'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#E0D6FF',
                'selectors' => [
                    '{{WRAPPER}} .aiq-resource-card__content' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'accent_color',
            [
                'label' => esc_html__('Accent Color', 'aiqengage-child'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#9C4DFF',
                'selectors' => [
                    '{{WRAPPER}} .aiq-resource-card__badge' => 'background-color: {{VALUE}}',
                    '{{WRAPPER}} .aiq-resource-card__icon' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'button_background',
            [
                'label' => esc_html__('Button Background', 'aiqengage-child'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#9C4DFF',
                'selectors' => [
                    '{{WRAPPER}} .aiq-resource-card__cta' => 'background-color: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'button_text_color',
            [
                'label' => esc_html__('Button Text Color', 'aiqengage-child'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#FFFFFF',
                'selectors' => [
                    '{{WRAPPER}} .aiq-resource-card__cta' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'locked_badge_color',
            [
                'label' => esc_html__('Locked Badge Color', 'aiqengage-child'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#FFD700',
                'selectors' => [
                    '{{WRAPPER}} .aiq-resource-card__pro-badge' => 'background-color: {{VALUE}}',
                ],
                'condition' => [
                    'is_locked' => 'yes',
                ],
            ]
        );

        $this->end_controls_section();
    }

    protected function render() {
        $settings = $this->get_settings_for_display();
        $is_locked = 'yes' === $settings['is_locked'];

        // Prepare URLs
        $resource_url = !empty($settings['resource_url']['url']) ? $settings['resource_url']['url'] : '#';
        $resource_target = !empty($settings['resource_url']['is_external']) ? ' target="_blank"' : '';
        $resource_nofollow = !empty($settings['resource_url']['nofollow']) ? ' rel="nofollow"' : '';

        $locked_url = !empty($settings['locked_redirect_url']['url']) ? $settings['locked_redirect_url']['url'] : '#';
        $locked_target = !empty($settings['locked_redirect_url']['is_external']) ? ' target="_blank"' : '';
        $locked_nofollow = !empty($settings['locked_redirect_url']['nofollow']) ? ' rel="nofollow"' : '';

        // Prepare download count
        $download_count = intval($settings['download_count']);
        $formatted_count = $download_count > 1000 ? number_format($download_count / 1000, 1) . 'k+' : $download_count;

        // Get thumbnail
        $thumbnail_url = !empty($settings['resource_thumbnail']['url']) ? $settings['resource_thumbnail']['url'] : \Elementor\Utils::get_placeholder_image_src();
        $thumbnail_id = !empty($settings['resource_thumbnail']['id']) ? $settings['resource_thumbnail']['id'] : 0;
        $alt_text = $thumbnail_id ? get_post_meta($thumbnail_id, '_wp_attachment_image_alt', true) : $settings['resource_title'];

        // Schema data
        $schema_type = $this->get_schema_type($settings['resource_type']);
        $resource_type_label = $this->get_resource_type_label($settings['resource_type']);
        ?>

        <div class="aiq-resource-card<?php echo $is_locked ? ' aiq-resource-card--locked' : ''; ?>"
             itemscope itemtype="https://schema.org/<?php echo esc_attr($schema_type); ?>">

            <?php if ($is_locked) : ?>
            <div class="aiq-resource-card__pro-badge" aria-label="<?php esc_attr_e('Premium Resource', 'aiqengage-child'); ?>">
                <span>🔒 PRO</span>
            </div>
            <?php endif; ?>

            <div class="aiq-resource-card__media">
                <?php if ('video' === $settings['resource_type'] && !empty($settings['video_embed_url'])) : ?>
                    <div class="aiq-resource-card__video" data-embed-url="<?php echo esc_url($settings['video_embed_url']); ?>">
                        <div class="aiq-resource-card__video-placeholder">
                            <img src="<?php echo esc_url($thumbnail_url); ?>" alt="<?php echo esc_attr($alt_text); ?>" itemprop="thumbnailUrl">
                            <div class="aiq-resource-card__play-button">
                                <i class="fas fa-play" aria-hidden="true"></i>
                            </div>
                        </div>
                    </div>
                <?php else : ?>
                    <div class="aiq-resource-card__thumbnail">
                        <img src="<?php echo esc_url($thumbnail_url); ?>" alt="<?php echo esc_attr($alt_text); ?>" itemprop="image">
                    </div>
                <?php endif; ?>

                <div class="aiq-resource-card__badge">
                    <?php \Elementor\Icons_Manager::render_icon($settings['resource_icon'], ['aria-hidden' => 'true']); ?>
                    <span><?php echo esc_html($resource_type_label); ?></span>
                </div>
            </div>

            <div class="aiq-resource-card__content">
                <h3 class="aiq-resource-card__title" itemprop="name"><?php echo esc_html($settings['resource_title']); ?></h3>

                <div class="aiq-resource-card__description" itemprop="description">
                    <?php echo esc_html($settings['resource_description']); ?>
                </div>

                <div class="aiq-resource-card__meta">
                    <?php if (!empty($settings['file_size']) && 'video' !== $settings['resource_type']) : ?>
                        <span class="aiq-resource-card__size" itemprop="contentSize"><?php echo esc_html($settings['file_size']); ?></span>
                    <?php endif; ?>

                    <?php if ('yes' === $settings['show_downloads']) : ?>
                        <span class="aiq-resource-card__downloads">
                            <i class="fas fa-download" aria-hidden="true"></i>
                            <?php echo esc_html($formatted_count); ?> downloads
                        </span>
                    <?php endif; ?>
                </div>

                <div class="aiq-resource-card__actions">
                    <?php if ($is_locked) : ?>
                        <a href="<?php echo esc_url($locked_url); ?>" class="aiq-resource-card__cta aiq-resource-card__cta--locked"<?php echo $locked_target . $locked_nofollow; ?>>
                            <?php echo esc_html($settings['locked_cta_label']); ?>
                        </a>
                        <?php if (!empty($settings['locked_message'])) : ?>
                            <div class="aiq-resource-card__locked-message">
                                <?php echo esc_html($settings['locked_message']); ?>
                            </div>
                        <?php endif; ?>
                    <?php else : ?>
                        <a href="<?php echo esc_url($resource_url); ?>" class="aiq-resource-card__cta"<?php echo $resource_target . $resource_nofollow; ?> itemprop="contentUrl">
                            <?php echo esc_html($settings['cta_label']); ?>
                        </a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
        <?php
    }

    private function get_schema_type($type) {
        $schema_types = [
            'pdf' => 'DigitalDocument',
            'zip' => 'SoftwareApplication',
            'video' => 'VideoObject',
            'audio' => 'AudioObject',
            'image' => 'ImageObject',
            'spreadsheet' => 'SpreadsheetDigitalDocument',
            'template' => 'DigitalDocument',
            'other' => 'DigitalDocument',
        ];
        return $schema_types[$type] ?? 'DigitalDocument';
    }

    private function get_resource_type_label($type) {
        $labels = [
            'pdf' => __('PDF', 'aiqengage-child'),
            'zip' => __('ZIP', 'aiqengage-child'),
            'video' => __('Video', 'aiqengage-child'),
            'audio' => __('Audio', 'aiqengage-child'),
            'image' => __('Images', 'aiqengage-child'),
            'spreadsheet' => __('Spreadsheet', 'aiqengage-child'),
            'template' => __('Template', 'aiqengage-child'),
            'other' => __('Resource', 'aiqengage-child'),
        ];
        return $labels[$type] ?? $labels['other'];
    }

    protected function content_template() {
        ?>
        <#
        var isLocked = 'yes' === settings.is_locked;
        var resourceTypeLabel = '';

        switch(settings.resource_type) {
            case 'pdf': resourceTypeLabel = 'PDF'; break;
            case 'zip': resourceTypeLabel = 'ZIP'; break;
            case 'video': resourceTypeLabel = 'Video'; break;
            case 'audio': resourceTypeLabel = 'Audio'; break;
            case 'image': resourceTypeLabel = 'Images'; break;
            case 'spreadsheet': resourceTypeLabel = 'Spreadsheet'; break;
            case 'template': resourceTypeLabel = 'Template'; break;
            default: resourceTypeLabel = 'Resource';
        }

        var resourceUrl = settings.resource_url.url || '#';
        var lockedUrl = settings.locked_redirect_url.url || '#';

        var downloadCount = parseInt(settings.download_count) || 0;
        var formattedCount = downloadCount > 1000 ? (downloadCount / 1000).toFixed(1) + 'k+' : downloadCount;

        var thumbnailUrl = settings.resource_thumbnail.url || elementor.imagesManager.getPlaceholderImageUrl();
        #>

        <div class="aiq-resource-card<# if (isLocked) { #> aiq-resource-card--locked<# } #>">

            <# if (isLocked) { #>
            <div class="aiq-resource-card__pro-badge" aria-label="<?php echo esc_attr__('Premium Resource', 'aiqengage-child'); ?>">
                <span>🔒 PRO</span>
            </div>
            <# } #>

            <div class="aiq-resource-card__media">
                <# if ('video' === settings.resource_type && settings.video_embed_url) { #>
                    <div class="aiq-resource-card__video" data-embed-url="{{ settings.video_embed_url }}">
                        <div class="aiq-resource-card__video-placeholder">
                            <img src="{{ thumbnailUrl }}" alt="{{ settings.resource_title }}">
                            <div class="aiq-resource-card__play-button">
                                <i class="fas fa-play" aria-hidden="true"></i>
                            </div>
                        </div>
                    </div>
                <# } else { #>
                    <div class="aiq-resource-card__thumbnail">
                        <img src="{{ thumbnailUrl }}" alt="{{ settings.resource_title }}">
                    </div>
                <# } #>

                <div class="aiq-resource-card__badge">
                    <# if (settings.resource_icon.value) { #>
                        <i class="{{ settings.resource_icon.value }}" aria-hidden="true"></i>
                    <# } #>
                    <span>{{ resourceTypeLabel }}</span>
                </div>
            </div>

            <div class="aiq-resource-card__content">
                <h3 class="aiq-resource-card__title">{{ settings.resource_title }}</h3>

                <div class="aiq-resource-card__description">
                    {{ settings.resource_description }}
                </div>

                <div class="aiq-resource-card__meta">
                    <# if (settings.file_size && 'video' !== settings.resource_type) { #>
                        <span class="aiq-resource-card__size">{{ settings.file_size }}</span>
                    <# } #>

                    <# if ('yes' === settings.show_downloads) { #>
                        <span class="aiq-resource-card__downloads">
                            <i class="fas fa-download" aria-hidden="true"></i>
                            {{ formattedCount }} downloads
                        </span>
                    <# } #>
                </div>

                <div class="aiq-resource-card__actions">
                    <# if (isLocked) { #>
                        <a href="{{ lockedUrl }}" class="aiq-resource-card__cta aiq-resource-card__cta--locked">
                            {{ settings.locked_cta_label }}
                        </a>
                        <# if (settings.locked_message) { #>
                            <div class="aiq-resource-card__locked-message">
                                {{ settings.locked_message }}
                            </div>
                        <# } #>
                    <# } else { #>
                        <a href="{{ resourceUrl }}" class="aiq-resource-card__cta">
                            {{ settings.cta_label }}
                        </a>
                    <# } #>
                </div>
            </div>
        </div>
        <?php
    }
}
