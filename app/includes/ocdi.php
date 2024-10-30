<?php
// no direct access
defined('ABSPATH') || die();

/**
 * LSDRC One Click Demo Importer Class.
 *
 * @class LSDRC_OCDI
 * @version    1.0.0
 */
class LSDRC_OCDI extends LSDRC_Base
{
    public function init()
    {
        // Demo Importer
        add_filter('ocdi/import_files', [$this, 'demos']);

        // Plugins
        add_filter('ocdi/register_plugins', [$this, 'plugins']);

        // Before Import
        add_action('ocdi/before_widgets_import', [$this, 'prepare']);

        // After Import
        add_action('ocdi/after_import', [$this, 'config'], 10);

        // Menu Setup
        add_filter('ocdi/plugin_page_setup', [$this, 'menu']);

        // Page
        add_filter('ocdi/plugin_intro_text', [$this, 'intro']);
        add_filter('ocdi/plugin_page_title', [$this, 'title']);
    }

    /**
     * Register Demos for Demo Importer
     * @return array
     */
    public function demos(): array
    {
        $content = LSDRC_ABSPATH . '/demos/demo1/content.xml';

        $pro = class_exists('LSD_Base') && LSD_Base::isPro();
        if ($pro) $content = LSDRC_ABSPATH . '/demos/demo1/content-pro.xml';

        return [
            [
                'key' => 'demo1',
                'import_file_name' => esc_html__('Listdomer Demo 1', 'listdomer-core'),
                'categories' => [esc_html__('Listing Directory', 'listdomer-core')],
                'local_import_file' => $content,
                'local_import_widget_file' => LSDRC_ABSPATH . '/demos/demo1/widgets.wie',
                'local_import_customizer_file' => LSDRC_ABSPATH . '/demos/demo1/customizer.dat',
                'import_preview_image_url' => plugins_url('demos/demo1/preview.jpg', LSDRC_BASENAME),
                'preview_url' => 'https://api.webilia.com/go/listdomer-demo',
                'logo' => LSDRC_ABSPATH . '/demos/demo1/logo.png',
            ]
        ];
    }

    public function plugins($plugins): array
    {
        return [
            [
                'name' => 'Listdom',
                'slug' => 'listdom',
                'required' => true,
                'preselected' => true,
            ],
            [
                'name' => 'Elementor',
                'slug' => 'elementor',
                'required' => true,
                'preselected' => true,
            ],
            [
                'name' => 'Frontend Dashboard',
                'slug' => 'frontend-dashboard',
                'required' => false,
                'preselected' => true,
            ],
            [
                'name' => 'Contact Form 7',
                'slug' => 'contact-form-7',
                'required' => false,
                'preselected' => true,
            ],
            [
                'name' => 'WooCommerce',
                'slug' => 'woocommerce',
                'required' => false,
                'preselected' => true,
            ],
        ];
    }

    public function prepare($demo)
    {
        $sidebars_widgets = get_option('sidebars_widgets');

        $empty_widgets = [];
        foreach ($sidebars_widgets as $sidebar => $widgets) $empty_widgets[$sidebar] = [];

        update_option('sidebars_widgets', $empty_widgets);
    }

    public function config($demo)
    {
        if ($demo['key'] === 'demo1')
        {
            // Assign Menus
            $main = get_term_by('name', 'Top Menu', 'nav_menu');
            $footer = get_term_by('name', 'Footer', 'nav_menu');

            set_theme_mod('nav_menu_locations', [
                'menu-1' => $main->term_id,
                'menu-2' => $footer->term_id,
            ]);

            // Assign front page and posts page (blog page).
            $front_page = LSDRC_Base::get_post_by_title('Home', 'page');
            $blog_page = LSDRC_Base::get_post_by_title('Blog', 'page');

            update_option('show_on_front', 'page');
            update_option('page_on_front', $front_page->ID);
            update_option('page_for_posts', $blog_page->ID);

            // Import Logo
            if (isset($demo['logo']) && trim($demo['logo']) && class_exists('LSD_IX') && class_exists('LSD_File'))
            {
                $ix = new LSD_IX();
                $logo_id = $ix->attach_by_buffer(LSD_File::read($demo['logo']), basename($demo['logo']));

                set_theme_mod('custom_logo', $logo_id);
            }
        }

        // Listdom Config
        if (class_exists('LSD_Options'))
        {
            /**
             * Listing Details
             */
            $details_page = LSD_Options::details_page();

            // Style
            $details_page['general']['style'] = 'style2';

            update_option('lsd_details_page', $details_page);

            /**
             * General Settings
             */
            $settings = LSD_Options::settings();

            // Main Font
            $settings['dply_main_font'] = 'poppins';

            // Dashboard Page
            $dashboard_page = LSDRC_Base::get_post_by_title('Dashboard', 'page');
            $settings['submission_page'] = $dashboard_page && isset($dashboard_page->ID) ? $dashboard_page->ID : null;

            update_option('lsd_settings', $settings);
        }

        // Personalized CSS
        if (class_exists('LSD_Personalize'))
        {
            LSD_Personalize::generate();
        }

        // Permalinks
        $this->permalinks();
    }

    public function permalinks()
    {
        global $wp_rewrite;

        $wp_rewrite->set_permalink_structure('/%postname%/');
        $wp_rewrite->flush_rules();
    }

    public function menu($setup)
    {
        $setup['parent_slug'] = 'admin.php';
        $setup['page_title'] = esc_html__('Demo Import', 'listdomer-core');
        $setup['menu_title'] = esc_html__('Demo Import', 'listdomer-core');
        $setup['menu_slug'] = 'listdomer';

        return $setup;
    }

    public function intro($intro)
    {
        return $intro;
    }

    public function title($title): string
    {
        return '<div class="ocdi__title-container">
			<h1 class="ocdi__title-container-title">' . esc_html__('Listdomer Demo Importer', 'listdomer-core') . '</h1>
			<a href="https://ocdi.com/user-guide/" target="_blank" rel="noopener noreferrer">
				<img class="ocdi__title-container-icon" src="' . plugins_url() . '/one-click-demo-import/assets/images/icons/question-circle.svg" alt="Questionmark icon">
			</a>
		</div>';
    }
}
