<?php
// no direct access
defined('ABSPATH') || die();

class LSDRC_Settings_Typography extends LSDRC_Settings
{
    /**
     * Set typography settings section for Redux.
     * @return void
     */
    public function register()
    {
        Redux::set_section(
            $this->opt_name,
            [
                'title' => esc_html__('Typography', 'listdomer-core'),
                'id' => 'typography',
                'icon' => 'el el-font',
                'fields' => $this->get_typography_fields(),
            ]
        );
    }

    /**
     * Returns the fields for the typography settings.
     * @return array Fields array.
     */
    private function get_typography_fields(): array
    {
        return [
            [
                'id' => 'listdomer_main_font',
                'type' => 'typography',
                'title' => esc_html__('Main Font', 'listdomer-core'),
                'subtitle' => esc_html__('Specify the main font properties.', 'listdomer-core'),
                'desc' => esc_html__('You can choose one of Google fonts.', 'listdomer-core'),
                'google' => true,
                'font_family_clear' => false,
                'default' => [
                    'font-size' => '16px',
                    'font-family' => get_theme_mod('listdomer_main_font', 'Poppins'),
                    'font-style' => '400',
                    'line-height' => '24px',
                ],
                'output' => ['p'],
                'color' => false,
            ],
        ];
    }
}
