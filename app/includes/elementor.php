<?php
// no direct access
defined('ABSPATH') || die();

use Elementor\Plugin;
use Elementor\Widgets_Manager;

/**
 * Plugin Elementor Class.
 *
 * @class LSDRC_Elementor
 * @version    1.0.0
 */
class LSDRC_Elementor extends LSDRC_Base
{
    public function init()
    {
        // Widgets
        add_action('elementor/widgets/register', [$this, 'widgets']);

        // Category
        add_action('elementor/init', [$this, 'category']);
    }

    public function widgets(Widgets_Manager $manager)
    {
        // Posts Widget
        $manager->register(new LSDRC_Elementor_Posts());

        // Carousel Widget
        $manager->register(new LSDRC_Elementor_Carousel());

        // Tiny Widget
        $manager->register(new LSDRC_Elementor_Tiny());

        // Testimonial Widget
        $manager->register(new LSDRC_Elementor_Testimonials());
    }

    public function category()
    {
        Plugin::$instance->elements_manager->add_category('listdomer', [
            'title' => __('Listdomer', 'listdomer-core'),
            'icon' => 'fas fa-palette',
        ]);
    }
}
