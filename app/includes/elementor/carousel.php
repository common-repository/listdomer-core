<?php
// no direct access
defined('ABSPATH') || die();

use Elementor\Controls_Manager;
use Elementor\Repeater;

/**
 * Elementor Carousel Widget.
 *
 * @class LSDRC_Elementor_Carousel
 * @version    1.0.0
 */
class LSDRC_Elementor_Carousel extends LSDRC_Elementor_Base
{
    public function get_name()
    {
        return 'lsdrc-carousel';
    }

    public function get_title()
    {
        return __('Content Carousel', 'listdomer-core');
    }

    public function get_icon()
    {
        return 'eicon-slider-push';
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

        $repeater = new Repeater();
        $repeater->add_control(
            'number',
            [
                'label' => __('Number', 'listdomer-core'),
                'type' => Controls_Manager::NUMBER,
                'default' => 1,
            ]
        );

        $repeater->add_control(
            'title',
            [
                'label' => __('Title', 'listdomer-core'),
                'type' => Controls_Manager::TEXT,
                'default' => __('How it works', 'listdomer-core'),
            ]
        );

        $repeater->add_control(
            'content',
            [
                'label' => __('Content', 'listdomer-core'),
                'type' => Controls_Manager::TEXTAREA,
            ]
        );

        $this->add_control(
            'slides',
            [
                'label' => __('Slides', 'listdomer-core'),
                'type' => Controls_Manager::REPEATER,
                'fields' => $repeater->get_controls(),
                'default' => [
                    [
                        'number' => 1,
                        'title' => __('How it works', 'listdomer-core'),
                        'content' => __('Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut elit tellus, luctus nec ullamcorper mattis, pulvinar dapibus leo.', 'listdomer-core'),
                    ],
                    [
                        'number' => 2,
                        'title' => __('How it works', 'listdomer-core'),
                        'content' => __('Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut elit tellus, luctus nec ullamcorper mattis, pulvinar dapibus leo.', 'listdomer-core'),
                    ],
                    [
                        'number' => 3,
                        'title' => __('How it works', 'listdomer-core'),
                        'content' => __('Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut elit tellus, luctus nec ullamcorper mattis, pulvinar dapibus leo.', 'listdomer-core'),
                    ],
                    [
                        'number' => 4,
                        'title' => __('How it works', 'listdomer-core'),
                        'content' => __('Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut elit tellus, luctus nec ullamcorper mattis, pulvinar dapibus leo.', 'listdomer-core'),
                    ],
                    [
                        'number' => 5,
                        'title' => __('How it works', 'listdomer-core'),
                        'content' => __('Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut elit tellus, luctus nec ullamcorper mattis, pulvinar dapibus leo.', 'listdomer-core'),
                    ],
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

        // No Slides Found
        if (!count($slides)) return;
        ?>
        <div id="listdomer_carousel_<?php echo esc_attr($this->get_id()); ?>"
             class="listdomer-carousel listdomer-font-m" data-autoplay="<?php echo esc_attr($autoplay); ?>"
             data-count="<?php echo esc_attr($count); ?>" data-navigation="<?php echo esc_attr($navigation); ?>"
             data-loop="<?php echo esc_attr($loop); ?>">
            <?php foreach ($slides as $slide): ?>
                <div class="listdomer-carousel-item">
                    <div class="listdomer-carousel-number">
                        <div><?php echo isset($slide['number']) && trim($slide['number']) != '' ? esc_html($slide['number']) : ''; ?></div>
                    </div>
                    <div>
                        <h6><?php echo isset($slide['title']) && trim($slide['title']) ? esc_html($slide['title']) : ''; ?></h6>
                        <p><?php echo isset($slide['content']) && trim($slide['content']) ? esc_html($slide['content']) : ''; ?></p>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
        <?php
    }
}
