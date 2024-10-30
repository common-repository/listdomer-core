<?php
// no direct access
defined('ABSPATH') || die();

/**
 * Listdomer Menus Class.
 *
 * @class LSDRC_Menus
 * @version    1.0.0
 */
class LSDRC_Menus extends LSDRC_Base
{
    public function init()
    {
        // Register Listdomer Menus
        add_action('admin_menu', [$this, 'register_menus'], 1);
    }

    public function register_menus()
    {
        $icon = plugins_url() . '/' . LSDRC_DIRNAME . '/assets/img/listdomer-icon.svg';

        add_menu_page(esc_html__('Listdomer', 'listdomer-core'), esc_html__('Listdomer', 'listdomer-core'), 'manage_options', 'listdomer', [$this, 'dashboard'], $icon, 59);
        add_submenu_page('listdomer', esc_html__('Documentation', 'listdomer-core'), esc_html__('Documentation', 'listdomer-core'), 'manage_options', 'https://api.webilia.com/go/listdomer-doc', null, 2);
        add_submenu_page('listdomer', esc_html__('Support', 'listdomer-core'), esc_html__('Support', 'listdomer-core'), 'manage_options', 'https://webilia.com/support/', null, 3);

        if (!is_plugin_active('listdomer-pro/listdomer-pro.php')) add_submenu_page('listdomer', esc_html__('Go Pro', 'listdomer-core'), '<span style="color: #ffd700; font-weight: bold;">' . esc_html__('Go Pro', 'listdomer-core') . '</span>', 'manage_options', 'https://api.webilia.com/go/buy-listdomer-pro', null, 1);
    }

    public function dashboard()
    {
    }
}
