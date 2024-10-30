<?php
// no direct access
defined('ABSPATH') || die();

use Elementor\Controls_Manager;
use Elementor\Repeater;

/**
 * Elementor Testimonial Widget.
 *
 * @class LSDRC_Elementor_Testimonials
 * @version    1.0.0
 */
class LSDRC_Elementor_Testimonials extends LSDRC_Elementor_Base
{
    public function get_name()
    {
        return 'lsdrc-testimonials';
    }

    public function get_title()
    {
        return __('Testimonials', 'listdomer-core');
    }

    public function get_icon()
    {
        return 'eicon-testimonial';
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
                ],
                'default' => 'style1'
            ]
        );

        $repeater = new Repeater();
        $repeater->add_control(
            'content',
            [
                'label' => __('Content', 'listdomer-core'),
                'type' => Controls_Manager::TEXTAREA,
                'default' => __('Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut elit tellus, luctus nec ullamcorper mattis, pulvinar dapibus leo.', 'listdomer-core'),
            ]
        );

        $repeater->add_control(
            'image',
            [
                'label' => __('Image', 'listdomer-core'),
                'type' => Controls_Manager::MEDIA,
            ]
        );

        $repeater->add_control(
            'name',
            [
                'label' => __('Name', 'listdomer-core'),
                'type' => Controls_Manager::TEXT,
                'default' => __('John Smith', 'listdomer-core'),
            ]
        );

        $repeater->add_control(
            'title',
            [
                'label' => __('Title', 'listdomer-core'),
                'type' => Controls_Manager::TEXT,
                'default' => __('CEO', 'listdomer-core'),
            ]
        );

        $this->add_control(
            'slides',
            [
                'label' => __('Testimonials', 'listdomer-core'),
                'type' => Controls_Manager::REPEATER,
                'fields' => $repeater->get_controls(),
                'default' => [
                    [
                        'content' => __('Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut elit tellus, luctus nec ullamcorper mattis, pulvinar dapibus leo.', 'listdomer-core'),
                        'image' => null,
                        'name' => __('John Smith', 'listdomer-core'),
                        'title' => __('CEO', 'listdomer-core'),
                    ],
                    [
                        'content' => __('Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut elit tellus, luctus nec ullamcorper mattis, pulvinar dapibus leo.', 'listdomer-core'),
                        'image' => null,
                        'name' => __('John Smith', 'listdomer-core'),
                        'title' => __('CEO', 'listdomer-core'),
                    ],
                    [
                        'content' => __('Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut elit tellus, luctus nec ullamcorper mattis, pulvinar dapibus leo.', 'listdomer-core'),
                        'image' => null,
                        'name' => __('John Smith', 'listdomer-core'),
                        'title' => __('CEO', 'listdomer-core'),
                    ],
                    [
                        'content' => __('Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut elit tellus, luctus nec ullamcorper mattis, pulvinar dapibus leo.', 'listdomer-core'),
                        'image' => null,
                        'name' => __('John Smith', 'listdomer-core'),
                        'title' => __('CEO', 'listdomer-core'),
                    ]
                ],
                'separator' => 'after',
            ]
        );

        // Carousel Controls
        $this->add_carousel_controls();

        // End Section
        $this->end_controls_section();
    }

    protected function render()
    {
        $settings = $this->get_settings_for_display();

        $slides = isset($settings['slides']) && is_array($settings['slides']) ? $settings['slides'] : [];
        $navigation = $settings['navigation'] ?? 'dots';
        $autoplay = isset($settings['autoplay']) && $settings['autoplay'] === 'yes' ? 1 : 0;
        $loop = isset($settings['loop']) && $settings['loop'] === 'yes' ? 1 : 0;
        $count = isset($settings['count']) && trim($settings['count']) ? $settings['count'] : 1;
        $style = isset($settings['style']) && trim($settings['style']) ? $settings['style'] : 'style1';

        // No Slides Found
        if (!count($slides)) return;
        ?>
        <div id="listdomer_carousel_<?php echo esc_attr($this->get_id()); ?>"
             class="listdomer-carousel listdomer-testimonials-widget listdomer-font-m listdomer-tsw-style-<?php echo esc_attr($style); ?>"
             data-autoplay="<?php echo esc_attr($autoplay); ?>" data-count="<?php echo esc_attr($count); ?>"
             data-navigation="<?php echo esc_attr($navigation); ?>" data-loop="<?php echo esc_attr($loop); ?>">
            <?php foreach ($slides as $slide): ?>
                <?php
                $image = isset($slide['image']) && is_array($slide['image']) ? $slide['image'] : [];
                $attachment_id = $image['id'] ?? null;

                $img = ($attachment_id ? wp_get_attachment_image_src($attachment_id) : '');
                $alt = $this->get_alt($attachment_id);
                ?>
                <div class="listdomer-carousel-item">
                    <blockquote
                        class="listdomer-tsw-content"><?php echo isset($slide['content']) && trim($slide['content']) != '' ? esc_html($slide['content']) : ''; ?></blockquote>
                    <div class="listdomer-tsw-footer">
                        <?php if (is_array($img) && isset($img[0]) && trim($img[0])): ?>
                            <div class="listdomer-tsw-image">
                                <img src="<?php echo esc_url($img[0]); ?>" alt="<?php echo esc_attr($alt); ?>">
                            </div>
                        <?php endif; ?>

                        <?php if (isset($slide['name']) && trim($slide['name'])): ?>
                            <div class="listdomer-tsw-name"><?php echo esc_html($slide['name']); ?></div>
                        <?php endif; ?>

                        <?php if (isset($slide['title']) && trim($slide['title'])): ?>
                            <div class="listdomer-tsw-title"><?php echo esc_html($slide['title']); ?></div>
                        <?php endif; ?>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
        <?php
    }
}
