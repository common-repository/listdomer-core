<?php
// no direct access
defined('ABSPATH') || die();

class LSDRC_Settings_Header extends LSDRC_Settings
{
    /**
     * Set header settings section for Redux.
     * @return void
     */
    public function register()
    {
        Redux::set_section(
            $this->opt_name,
            [
                'title' => esc_html__('Header Settings', 'listdomer-core'),
                'id' => 'header_settings',
                'desc' => esc_html__('Options for configuring the header.', 'listdomer-core'),
                'customizer_width' => '400px',
                'icon' => 'el el-arrow-up',
                'fields' => $this->get_header_fields(),
            ]
        );
    }

    /**
     * Returns the fields for the header settings.
     * @return array Fields array.
     */
    private function get_header_fields(): array
    {
        return [
            // Header Type
            [
                'id' => 'listdomer_header_type',
                'type' => 'select',
                'title' => esc_html__('Header Type', 'listdomer-core'),
                'options' => LSDR_Headers::all(),
                'default' => get_theme_mod('listdomer_header_type', 'type1'),
                'desc' => esc_html__('You need listdomer pro version to see all header types.', 'listdomer-core'),
            ],
            // Dark Logo
            [
                'id' => 'listdomer_dark_logo',
                'type' => 'media',
                'title' => esc_html__('Dark Logo', 'listdomer-core'),
                'default' => get_theme_mod('listdomer_dark_logo', ''),
                'desc' => esc_html__('It used in some special header types.', 'listdomer-core'),
            ],
            // Header Background Color
            [
                'id' => 'listdomer_header_bg_color',
                'type' => 'color',
                'title' => esc_html__('Background Color', 'listdomer-core'),
                'default' => get_theme_mod('listdomer_header_bg_color', '#ffffff'),
                'desc' => esc_html__('Easily change header background color.', 'listdomer-core'),
            ],
            // Header Text Color
            [
                'id' => 'listdomer_header_text_color',
                'type' => 'color',
                'title' => esc_html__('Text Color', 'listdomer-core'),
                'default' => get_theme_mod('listdomer_header_text_color', '#000000'),
                'desc' => esc_html__('Easily change header text color.', 'listdomer-core'),
            ],
            // Language Switcher
            [
                'id' => 'listdomer_header_language_switcher',
                'type' => 'checkbox',
                'title' => esc_html__('Language Switcher', 'listdomer-core'),
                'default' => get_theme_mod('listdomer_header_language_switcher', true),
                'desc' => esc_html__('Display WPML language switcher in the header. It works only when WPML is installed and configured correctly.', 'listdomer-core'),
            ],
            // Add Listing Button
            [
                'id' => 'listdomer_header_add_listing',
                'type' => 'checkbox',
                'title' => esc_html__('Add Listing Button', 'listdomer-core'),
                'default' => get_theme_mod('listdomer_header_add_listing', true),
                'desc' => esc_html__('Links to add listing form.', 'listdomer-core'),
            ],
            // User Login/Register
            [
                'id' => 'listdomer_header_logister',
                'type' => 'checkbox',
                'title' => esc_html__('Login & Register', 'listdomer-core'),
                'default' => get_theme_mod('listdomer_header_logister', true),
                'desc' => esc_html__('Display login & register form in the header.', 'listdomer-core'),
            ],
            // Login Redirect Page
            [
                'id' => 'listdomer_login_redirect',
                'type' => 'select',
                'title' => esc_html__('Login Redirection Page', 'listdomer-core'),
                'default' => get_theme_mod('listdomer_login_redirect', true),
                'desc' => esc_html__('Redirection page after user login.', 'listdomer-core'),
                'data' => 'pages',
            ],
            // Registration Redirect Page
            [
                'id' => 'listdomer_register_redirect',
                'type' => 'select',
                'title' => esc_html__('Register Redirection Page', 'listdomer-core'),
                'default' => get_theme_mod('listdomer_register_redirect', true),
                'desc' => esc_html__('Redirection page after user registration. You can use this page to say thank you and guide the users to use your website.', 'listdomer-core'),
                'data' => 'pages',
            ],
            [
                'id' => 'listdomer_social_login_shortcode',
                'type' => 'textarea',
                'title' => esc_html__('Social Login Shortcode', 'listdomer-core'),
                'default' => get_theme_mod('listdomer_social_login_shortcode', '[nextend_social_login style="icon"]'),
                'desc' => esc_html__('You can place social login shortcodes here. Please note that you should configure the social plugin correctly otherwise you may not see anything as output.', 'listdomer-core'),
            ],
        ];
    }
}
