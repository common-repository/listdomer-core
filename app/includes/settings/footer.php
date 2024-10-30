<?php
// no direct access
defined('ABSPATH') || die();

class LSDRC_Settings_Footer extends LSDRC_Settings
{
    /**
     * Set footer settings section for Redux.
     * @return void
     */
    public function register()
    {
        Redux::set_section(
            $this->opt_name,
            [
                'title' => esc_html__('Footer Settings', 'listdomer-core'),
                'id' => 'footer_settings',
                'desc' => esc_html__('Options for configuring the footer.', 'listdomer-core'),
                'customizer_width' => '400px',
                'icon' => 'el el-arrow-down',
                'fields' => $this->get_footer_fields(),
            ]
        );
    }

    /**
     * Returns the fields for the footer settings.
     * @return array Fields array.
     */
    private function get_footer_fields(): array
    {
        return [
            // Footer Type
            [
                'id' => 'listdomer_footer_type',
                'type' => 'select',
                'title' => esc_html__('Footer Type', 'listdomer-core'),
                'options' => LSDR_Footers::all(),
                'default' => get_theme_mod('listdomer_footer_type', 'type1'),
                'desc' => esc_html__('You need listdomer pro version to see all footer types.', 'listdomer-core'),
            ],
            [
                'id' => 'listdomer_footer_bg_color',
                'type' => 'color',
                'title' => esc_html__('Background Color', 'listdomer-core'),
                'default' => get_theme_mod('listdomer_footer_bg_color', '#1c1c1c'),
                'desc' => esc_html__('Easily change footer background color.', 'listdomer-core'),
            ],
            [
                'id' => 'listdomer_footer_text_color',
                'type' => 'color',
                'title' => esc_html__('Text Color', 'listdomer-core'),
                'default' => get_theme_mod('listdomer_footer_text_color', '#ffffff'),
                'desc' => esc_html__('Easily change footer text color.', 'listdomer-core'),
            ],
            [
                'id' => 'listdomer_footer_fbg_color',
                'type' => 'color',
                'title' => esc_html__('Frame Background Color', 'listdomer-core'),
                'default' => get_theme_mod('listdomer_footer_fbg_color', '#000000'),
                'desc' => esc_html__('Easily change background color of footer frame.', 'listdomer-core'),
            ],
            [
                'id' => 'listdomer_footer_active_color',
                'type' => 'color',
                'title' => esc_html__('Footer Active Color', 'listdomer-core'),
                'default' => get_theme_mod('listdomer_footer_active_color', '#747577'),
                'desc' => esc_html__('Easily change active color of footer.', 'listdomer-core'),
            ],
        ];
    }
}
