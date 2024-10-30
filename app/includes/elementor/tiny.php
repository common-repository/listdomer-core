<?php
// no direct access
defined('ABSPATH') || die();

use Elementor\Controls_Manager;

/**
 * Elementor Tiny Widget.
 *
 * @class LSDRC_Elementor_Tiny
 * @version    1.0.0
 */
class LSDRC_Elementor_Tiny extends LSDRC_Elementor_Base
{
    public function get_name()
    {
        return 'lsdrc-tiny';
    }

    public function get_title()
    {
        return __('Tiny Image', 'listdomer-core');
    }

    public function get_icon()
    {
        return 'eicon-image';
    }

    public function get_categories()
    {
        return ['listdomer'];
    }

    protected function register_controls()
    {
        // Start Section
        $this->start_controls_section(
            'lsdrc_content_section',
            [
                'label' => __('Content', 'listdomer-core'),
                'tab' => Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'style',
            [
                'label' => __('Style', 'listdomer-core'),
                'type' => Controls_Manager::SELECT2,
                'options' => [
                    'style1' => __('Style 1', 'listdomer-core'),
                    'style2' => __('Style 2', 'listdomer-core'),
                    'style3' => __('Style 3', 'listdomer-core'),
                ],
                'default' => 'style1'
            ]
        );

        $this->add_control(
            'image',
            [
                'label' => __('Image', 'listdomer-core'),
                'type' => Controls_Manager::MEDIA,
            ]
        );

        $this->add_control(
            'title',
            [
                'label' => __('Title', 'listdomer-core'),
                'type' => Controls_Manager::TEXT,
                'default' => __('97%', 'listdomer-core'),
            ]
        );

        $this->add_control(
            'subtitle',
            [
                'label' => __('Subtitle', 'listdomer-core'),
                'type' => Controls_Manager::TEXTAREA,
                'default' => __('Happy Clients', 'listdomer-core'),
            ]
        );

        $this->add_control(
            'icon',
            [
                'label' => __('Icon', 'listdomer-core'),
                'type' => Controls_Manager::ICONS,
            ]
        );

        $this->add_control(
            'video',
            [
                'label' => __('Video', 'listdomer-core'),
                'type' => Controls_Manager::URL,
                'description' => __("If you insert video URL, it will show instead of the icon.", 'listdomer-core')
            ]
        );

        // End Section
        $this->end_controls_section();
    }

    protected function render()
    {
        $settings = $this->get_settings_for_display();

        $image = isset($settings['image']) && is_array($settings['image']) ? $settings['image'] : [];
        $attachment_id = ($image['id'] ?? null);

        $img = ($attachment_id ? wp_get_attachment_image_src($attachment_id, [400, 400]) : '');
        $alt = $this->get_alt($attachment_id);

        $icon = isset($settings['icon']) && is_array($settings['icon']) ? $settings['icon'] : [];
        $i = isset($icon['value']) && trim($icon['value']) ? $icon['value'] : '';

        $video = isset($settings['video']) && is_array($settings['video']) ? $settings['video'] : [];
        $url = isset($video['url']) && trim($video['url']) ? $video['url'] : '';
        $blank = isset($video['is_external']) && $video['is_external'] == 'on';
        $nofollow = isset($video['nofollow']) && $video['nofollow'] == 'on';

        $title = isset($settings['title']) && trim($settings['title']) ? $settings['title'] : '';
        $subtitle = isset($settings['subtitle']) && trim($settings['subtitle']) ? $settings['subtitle'] : '';
        $style = isset($settings['style']) && trim($settings['style']) ? $settings['style'] : 'style1';

        $method = (trim($url) ? 'video' : 'icon');
        ?>
        <div class="listdomer-tiny-widget listdomer-tw-style-<?php echo esc_attr($style); ?>">

            <?php if (is_array($img) && isset($img[0]) && trim($img[0])): ?>
                <div class="listdomer-tw-image">
                    <img src="<?php echo esc_url($img[0]); ?>" alt="<?php echo esc_attr($alt); ?>">
                </div>
            <?php endif; ?>

            <div class="listdomer-tw-stat">
                <?php if ($method == 'icon' && trim($i)): ?>
                    <div class="listdomer-tw-icon"><i class="<?php echo esc_attr($i); ?>"></i></div>
                <?php endif; ?>

                <h5><?php echo esc_html($title); ?></h5>
                <h6><?php echo esc_html($subtitle); ?></h6>
                <?php if ($method == 'video' && trim($url)): ?>
                    <div class="listdomer-tw-video">
                        <a href="<?php echo esc_url($url); ?>" <?php echo($blank ? 'target="_blank"' : ''); ?> <?php echo($nofollow ? 'rel="nofollow"' : ''); ?>>
                            <i class="fas fa-play"></i>
                        </a>
                    </div>
                <?php endif; ?>
            </div>

        </div>
        <?php
    }
}
