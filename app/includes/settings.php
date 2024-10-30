<?php
// no direct access
defined('ABSPATH') || die();

/**
 * LSDRC_Settings Class
 * Handles the Redux Framework configuration.
 */
class LSDRC_Settings extends LSDRC_Base
{
    /**
     * Option name where all the Redux data is stored.
     *
     * @var string
     */
    protected $opt_name = 'listdomer_theme_settings';

    public function init()
    {
        add_action('after_setup_theme', [$this, 'initialize']);
    }

    /**
     * Initialize Redux Framework with arguments and sections.
     */
    public function initialize()
    {
        if (!class_exists('Redux')) return;

        // Theme Object
        $theme = wp_get_theme();

        // Redux Options
        $args = [
            'opt_name' => $this->opt_name,
            'display_name' => $theme->get('Name'),
            'display_version' => $theme->get('Version'),
            'menu_type' => 'submenu',
            'allow_sub_menu' => true,
            'menu_title' => is_admin()
                ? esc_html__('Settings', 'listdomer-core')
                : esc_html__('Listdomer', 'listdomer-core'),
            'page_title' => esc_html__('Listdomer Settings', 'listdomer-core'),
            'disable_google_fonts_link' => false,
            'admin_bar' => true,
            'admin_bar_icon' => 'dashicons-admin-appearance',
            'admin_bar_priority' => 40,
            'global_variable' => '',
            'dev_mode' => false,
            'customizer' => true,
            'page_priority' => 1,
            'page_parent' => 'listdomer',
            'page_permissions' => 'manage_options',
            'menu_icon' => '',
            'last_tab' => '',
            'page_icon' => 'icon-themes',
            'page_slug' => 'listdomer-settings',
            'save_defaults' => true,
            'default_show' => true,
            'default_mark' => '',
            'show_import_export' => true,
            'transient_time' => HOUR_IN_SECONDS,
            'output' => true,
            'output_tag' => true,
            'database' => '',
            'use_cdn' => true,
            'compiler' => true,
            'flyout_submenus' => true,
            'font_display' => 'swap',
            'hints' => [
                'icon' => 'el el-question-sign',
                'icon_position' => 'right',
                'icon_color' => 'lightgray',
                'icon_size' => 'normal',
                'tip_style' => [
                    'color' => 'light',
                    'shadow' => true,
                    'rounded' => false,
                    'style' => '',
                ],
                'tip_position' => [
                    'my' => 'top left',
                    'at' => 'bottom right',
                ],
                'tip_effect' => [
                    'show' => [
                        'effect' => 'slide',
                        'duration' => '500',
                        'event' => 'mouseover',
                    ],
                    'hide' => [
                        'effect' => 'slide',
                        'duration' => '500',
                        'event' => 'click mouseleave',
                    ],
                ],
            ],
        ];

        Redux::set_args($this->opt_name, $args);

        $this->set_sections();
        add_action("redux/options/$this->opt_name/saved", [LSDR_Personalize::class, 'generate']);
    }

    /**
     * Set sections for the Redux framework.
     */
    private function set_sections()
    {
        // General Options
        (new LSDRC_Settings_General())->register();

        // Color Options
        (new LSDRC_Settings_Colors())->register();

        // Typography Options
        (new LSDRC_Settings_Typography())->register();

        // Header options
        (new LSDRC_Settings_Header())->register();

        // Footer Options
        (new LSDRC_Settings_Footer())->register();

        // Blog Options
        (new LSDRC_Settings_Blog())->register();

        // Widget Options
        (new LSDRC_Settings_Widgets())->register();

        // Sidebar Options
        (new LSDRC_Settings_Sidebars())->register();

        // Codes Options
        (new LSDRC_Settings_Codes())->register();
    }

    public static function get(string $key, $default = null)
    {
        $settings = get_option('listdomer_theme_settings');
        return $settings[$key] ?? $default;
    }
}
