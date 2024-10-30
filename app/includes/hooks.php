<?php
// no direct access
defined('ABSPATH') || die();

/**
 * Plugin General Hooks Class.
 *
 * @class LSDRC_Hooks
 * @version    1.0.0
 */
class LSDRC_Hooks extends LSDRC_Base
{
    /**
     * @var LSDRC_Theme
     */
    private $theme;

    /**
     * Constructor method
     */
    public function __construct()
    {
        parent::__construct();

        // Theme
        $this->theme = new LSDRC_Theme();
    }

    public function init()
    {
        // Register Actions
        $this->actions();

        // Register Filters
        $this->filters();

        // Register Widgets
        (new LSDRC_Widgets())->init();

        // Theme Settings
        (new LSDRC_Settings())->init();

        // Elementor
        (new LSDRC_Elementor())->init();

        // OCDI
        (new LSDRC_OCDI())->init();

        // Menus
        (new LSDRC_Menus())->init();
    }

    public function actions()
    {
        add_action('after_setup_theme', [$this->theme, 'register_block_style']);
        add_action('init', [$this->theme, 'register_block_pattern']);

        add_action('listdomer_header_buttons', [$this->theme, 'header_buttons']);

        // Include needed assets (CSS, JavaScript etc.) in the WordPress backend
        add_action('admin_enqueue_scripts', function ()
        {
            // Include Listdomer Core backend CSS file for WordPress
            wp_enqueue_style(
                'lsdrc-wp-backend',
                plugins_url() . '/' . LSDRC_DIRNAME . '/assets/css/wp-backend.css',
                [],
                LSDRC_VERSION
            );
        });
    }

    public function filters()
    {
        add_filter('lsd_template', [$this, 'template'], 10, 3);
        add_filter('lsdaddclm_display_verified', '__return_false');
        add_filter('lsdaddclm_claim_text', function ()
        {
            return esc_html__('Claim It Now!', 'listdom-claim');
        });
    }

    public function template($path, $tpl, $override): string
    {
        $OPath = LSDRC_ABSPATH . '/templates/' . ltrim($tpl, '/');
        if (!is_file($OPath)) return $path;

        if ($override)
        {
            // Main Theme
            $theme = get_template_directory();
            $theme_path = $theme . '/listdom/' . ltrim($tpl, '/');

            if (is_file($theme_path)) $OPath = $theme_path;

            // Child Theme
            if (is_child_theme())
            {
                $child_theme = get_stylesheet_directory();
                $child_theme_path = $child_theme . '/listdom/' . ltrim($tpl, '/');

                if (is_file($child_theme_path)) $OPath = $child_theme_path;
            }
        }

        return $OPath;
    }
}
