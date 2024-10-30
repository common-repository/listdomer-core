<?php
// no direct access
defined('ABSPATH') || die();

class LSDRC_Settings_Sidebars extends LSDRC_Settings
{
    /**
     * Set sidebar settings section for Redux.
     * @return void
     */
    public function register()
    {
        Redux::set_section(
            $this->opt_name,
            [
                'title' => esc_html__('Sidebars', 'listdomer-core'),
                'id' => 'sidebar',
                'desc' => esc_html__('Sidebar settings for various elements.', 'listdomer-core'),
                'customizer_width' => '400px',
                'icon' => 'fas fa-columns',
                'fields' => $this->get_sidebar_fields(),
            ]
        );
    }

    /**
     * Returns the fields for the sidebar settings.
     * @return array Fields array.
     */
    private function get_sidebar_fields(): array
    {
        return [
            [
                'id' => 'listdomer_sidebar_input_color',
                'type' => 'color',
                'title' => esc_html__('Input Color', 'listdomer-core'),
                'default' => get_theme_mod('listdomer_sidebar_input_color', '#a4a8b5'),
            ],
            [
                'id' => 'listdomer_sidebar_text_color',
                'type' => 'color',
                'title' => esc_html__('Text Color', 'listdomer-core'),
                'default' => get_theme_mod('listdomer_sidebar_text_color', '#3a3b40'),
            ],
            [
                'id' => 'listdomer_sidebar_a_color',
                'type' => 'color',
                'title' => esc_html__('A Tag Color', 'listdomer-core'),
                'default' => get_theme_mod('listdomer_sidebar_a_color', '#8d919c'),
            ],
            [
                'id' => 'listdomer_sidebar_border_color',
                'type' => 'color',
                'title' => esc_html__('Border Color', 'listdomer-core'),
                'default' => get_theme_mod('listdomer_sidebar_border_color', '#ececec'),
            ],
        ];
    }
}

