<?php
// no direct access
defined('ABSPATH') || die();

class LSDRC_Settings_Widgets extends LSDRC_Settings
{
    /**
     * Set widget settings section for Redux.
     * @return void
     */
    public function register()
    {
        Redux::set_section(
            $this->opt_name,
            [
                'title' => esc_html__('Widget Settings', 'listdomer-core'),
                'id' => 'widgets',
                'desc' => esc_html__('Customize the appearance of widgets.', 'listdomer-core'),
                'customizer_width' => '400px',
                'icon' => 'fas fa-cube',
                'fields' => $this->get_widget_fields(),
            ]
        );
    }

    /**
     * Returns the fields for the widget settings.
     * @return array Fields array.
     */
    private function get_widget_fields(): array
    {
        return [
            [
                'id' => 'listdomer_carousel_border_color_control',
                'type' => 'color',
                'title' => esc_html__('Carousel Border Color', 'listdomer-core'),
                'default' => get_theme_mod('listdomer_carousel_border_color_control', '#d3d9e8'),
                'desc' => esc_html__('Color of carousel border.', 'listdomer-pro'),
            ],
            [
                'id' => 'listdomer_carousel_active_color',
                'type' => 'color',
                'title' => esc_html__('Carousel Active Color', 'listdomer-core'),
                'default' => get_theme_mod('listdomer_carousel_active_color', '#33bdfc'),
                'desc' => esc_html__('Border and background color of active carousel.', 'listdomer-pro'),
            ],
            [
                'id' => 'listdomer_widget_color',
                'type' => 'color',
                'title' => esc_html__('Widget Color', 'listdomer-core'),
                'default' => get_theme_mod('listdomer_widget_color', '#7e8086'),
                'desc' => esc_html__('Color of Widgets.', 'listdomer-pro'),
            ],
            [
                'id' => 'listdomer_widget_active_color',
                'type' => 'color',
                'title' => esc_html__('Wiget Active Color', 'listdomer-core'),
                'default' => get_theme_mod('listdomer_widget_active_color', '#33bdfc'),
                'desc' => esc_html__('Color of Active Widgets.', 'listdomer-pro'),
            ],
        ];
    }
}
