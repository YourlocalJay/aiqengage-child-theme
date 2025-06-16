<?php
/**
 * Enhanced Resource Card Widget
 * 
 * @package AIQEngage
 */

if (!defined('ABSPATH')) exit;

class AIQ_Resource_Card_Widget extends \Elementor\Widget_Base {

    public function get_name() {
        return 'aiq_resource_card';
    }

    public function get_title() {
        return __('Enhanced Resource Card', 'aiqengage');
    }

    public function get_icon() {
        return 'eicon-download-button';
    }

    public function get_keywords() {
        return ['resource', 'download', 'card', 'asset', 'file', 'media'];
    }

    public function get_categories() {
        return ['aiqengage', 'content'];
    }

    protected function register_controls() {
        $this->start_controls_section(
            'section_content',
            [
                'label' => __('Resource Content', 'aiqengage'),
                'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'resource_title',
            [
                'label' => __('Title', 'aiqengage'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => __('AI Automation Blueprint', 'aiqengage'),
                'label_block' => true,
                'dynamic' => [
                    'active' => true,
                ],
            ]
        );

        $this->add_control(
            'resource_description',
            [
                'label' => __('Description', 'aiqengage'),
                'type' => \Elementor\Controls_Manager::TEXTAREA,
                'default' => __('Step-by-step guide with proven results', 'aiqengage'),
                'rows' => 3,
                'dynamic' => [
                    'active' => true,
                ],
            ]
        );

        $this->add_control(
            'resource_type',
            [
                'label' => __('Resource Type', 'aiqengage'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => 'pdf',
                'options' => [
                    'pdf' => __('PDF', 'aiqengage'),
                    'zip' => __('ZIP', 'aiqengage'),
                    'video' => __('Video', 'aiqengage'),
                    'audio' => __('Audio', 'aiqengage'),
                    'image' => __('Images', 'aiqengage'),
                    'spreadsheet' => __('Spreadsheet', 'aiqengage'),
                    'template' => __('Template', 'aiqengage'),
                    'other' => __('Other', 'aiqengage'),
                ],
            ]
        );

        $this->add_control(
            'file_size',
            [
                'label' => __('File Size', 'aiqengage'),
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
                'label' => __('Resource URL', 'aiqengage'),
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
                'label' => __('Video Embed URL', 'aiqengage'),
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
                'label' => __('Requires Access', 'aiqengage'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => __('Yes', 'aiqengage'),
                'label_off' => __('No', 'aiqengage'),
                'return_value' => 'yes',
                'default' => 'no',
            ]
        );

        $this->add_control(
            'locked_message',
            [
                'label' => __('Locked Message', 'aiqengage'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => __('Upgrade to access this resource', 'aiqengage'),
                'condition' => [
                    'is_locked' => 'yes',
                ],
            ]
        );

        $this->add_control(
            'locked_redirect_url',
            [
                'label' => __('Upgrade URL', 'aiqengage'),
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
                'label' => __('Visual', 'aiqengage'),
                'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'resource_thumbnail',
            [
                'label' => __('Thumbnail', 'aiqengage'),
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
                'label' => __('Icon', 'aiqengage'),
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
                'label' => __('Button Text', 'aiqengage'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => __('Download Now', 'aiqengage'),
                'dynamic' => [
                    'active' => true,
                ],
            ]
        );

        $this->add_control(
            'locked_cta_label',
            [
                'label' => __('Locked Button Text', 'aiqengage'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => __('Upgrade to Access', 'aiqengage'),
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
                'label' => __('Show Download Count', 'aiqengage'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => __('Show', 'aiqengage'),
                'label_off' => __('Hide', 'aiqengage'),
                'return_value' => 'yes',
                'default' => 'yes',
            ]
        );

        $this->add_control(
            'download_count',
            [
                'label' => __('Download Count', 'aiqengage'),
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
                'label' => __('Style', 'aiqengage'),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'card_background',
            [
                'label' => __('Background', 'aiqengage'),
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
                'label' => __('Border Radius', 'aiqengage'),
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
                'label' => __('Text Color', 'aiqengage'),
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
                'label' => __('Accent Color', 'aiqengage'),
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
                'label' => __('Button Background', 'aiqengage'),
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
                'label' => __('Button Text Color', 'aiqengage'),
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
                'label' => __('Locked Badge Color', 'aiqengage'),
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
            <div class="aiq-resource-card__pro-badge" aria-label="<?php esc_attr_e('Premium Resource', 'aiqengage'); ?>">
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
            'pdf' => __('PDF', 'aiqengage'),
            'zip' => __('ZIP', 'aiqengage'),
            'video' => __('Video', 'aiqengage'),
            'audio' => __('Audio', 'aiqengage'),
            'image' => __('Images', 'aiqengage'),
            'spreadsheet' => __('Spreadsheet', 'aiqengage'),
            'template' => __('Template', 'aiqengage'),
            'other' => __('Resource', 'aiqengage'),
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
            <div class="aiq-resource-card__pro-badge" aria-label="Premium Resource">
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
