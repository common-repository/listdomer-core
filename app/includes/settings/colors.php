<?php
// no direct access
defined('ABSPATH') || die();

class LSDRC_Settings_Colors extends LSDRC_Settings
{
    /**
     * Set colors settings section for Redux.
     * @return void
     */
    public function register()
    {
        Redux::set_section(
            $this->opt_name,
            [
                'title' => esc_html__('Colors and Styles', 'listdomer-core'),
                'id' => 'colors',
                'desc' => esc_html__('Color settings for various elements.', 'listdomer-core'),
                'customizer_width' => '400px',
                'icon' => 'el el-tint',
                'fields' => $this->get_color_fields(),
            ]
        );
    }

    /**
     * Returns the fields for the colors settings.
     * @return array Fields array.
     */
    private function get_color_fields(): array
    {
        return [
            [
                'id' => 'listdomer_body_bg_color',
                'type' => 'color',
                'title' => esc_html__('Background Color', 'listdomer-core'),
                'default' => get_theme_mod('listdomer_body_bg_color', '#e8f1ff'),
            ],
            [
                'id' => 'listdomer_second_bg_color',
                'type' => 'color',
                'title' => esc_html__('Second Background Color', 'listdomer-core'),
                'default' => get_theme_mod('listdomer_second_bg_color', '#e6f7ff'),
            ],
            [
                'id' => 'listdomer_g_color1',
                'type' => 'color',
                'title' => esc_html__('Gradient Color', 'listdomer-core'),
                'default' => get_theme_mod('listdomer_g_color1', '#33c6ff'),
                'desc' => esc_html__('Change gradient first color.', 'listdomer'),
            ],
            [
                'id' => 'listdomer_g_color2',
                'type' => 'color',
                'title' => esc_html__('Second Gradient Color', 'listdomer-core'),
                'default' => get_theme_mod('listdomer_g_color2', '#306be6'),
                'desc' => esc_html__('Change gradient second color.', 'listdomer'),
            ],
            [
                'id' => 'listdomer_g_text_color',
                'type' => 'color',
                'title' => esc_html__('Gradient Text Color', 'listdomer-core'),
                'default' => get_theme_mod('listdomer_g_text_color', '#ffffff'),
                'desc' => esc_html__('Change gradient text color.', 'listdomer'),
            ],
            [
                'id' => 'listdomer_g_active_color1',
                'type' => 'color',
                'title' => esc_html__('Gradient Active Color 1', 'listdomer-core'),
                'default' => get_theme_mod('listdomer_g_active_color1', '#0ab0fe'),
                'desc' => esc_html__('Change gradient first active color.', 'listdomer'),
            ],
            [
                'id' => 'listdomer_g_active_color2',
                'type' => 'color',
                'title' => esc_html__('Gradient Active Color 2', 'listdomer-core'),
                'default' => get_theme_mod('listdomer_g_active_color2', '#24b7ff'),
                'desc' => esc_html__('Change gradient second active color.', 'listdomer'),
            ],
            [
                'id' => 'listdomer_main_border_color',
                'type' => 'color',
                'title' => esc_html__('Border Color', 'listdomer-core'),
                'default' => get_theme_mod('listdomer_main_border_color', '#bceaff'),
            ],
            [
                'id' => 'listdomer_main_title_color',
                'type' => 'color',
                'title' => esc_html__('Title Color', 'listdomer-core'),
                'default' => get_theme_mod('listdomer_main_title_color', '#000000'),
            ],
            [
                'id' => 'listdomer_main_atc_color',
                'type' => 'color',
                'title' => esc_html__('Active Tabs Color', 'listdomer-core'),
                'default' => get_theme_mod('listdomer_main_atc_color', '#66686b'),
            ],
            [
                'id' => 'listdomer_headlines_color',
                'type' => 'color',
                'title' => esc_html__('Headline Color', 'listdomer-core'),
                'default' => get_theme_mod('listdomer_headlines_color', '#000000'),
            ],
        ];
    }
}
