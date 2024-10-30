<?php
/**
 * Plugin Name: Listdomer Core
 * Plugin URI: https://api.webilia.com/go/listdomer
 * Description: Core Features of Listdomer Theme
 * Version: 2.5.2
 * Author: Webilia
 * Author URI: https://webilia.com/
 * Requires at least: 4.0.0
 * Tested up to: 6.7
 *
 * Text Domain: listdomer-core
 * Domain Path: /i18n/languages/
 */

// Do not init the plugin if current theme is not listdomer
if (wp_get_theme()->get_template() === 'listdomer')
{
    // Init the Plugin
    require_once 'init.php';

    LSDRC::instance();
}
