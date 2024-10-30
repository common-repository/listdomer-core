<?php
// no direct access
defined('ABSPATH') || die();

/**
 * Plugin Widgets Class.
 *
 * @class LSDRC_Widgets
 * @version    1.0.0
 */
class LSDRC_Widgets extends LSDRC_Base
{
    public function init()
    {
        add_action('widgets_init', [$this, 'register']);
    }

    public function register()
    {
        // Contact Widget
        register_widget('LSDRC_Widgets_Contact');
    }
}
