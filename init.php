<?php
// no direct access
defined('ABSPATH') || die();

/**
 * Listdomer Class.
 *
 * @version    1.0.0
 */
final class LSDRC
{
    /**
     * Version.
     *
     * @var string
     */
    public $version = '2.5.2';

    /**
     * The single instance of the class.
     *
     * @var LSDRC
     * @since 1.0.0
     */
    protected static $instance = null;

    /**
     * Main Instance.
     *
     * Ensures only one instance of plugin is loaded or can be loaded.
     *
     * @return LSDRC - Main instance.
     * @see lsdrc()
     * @since 1.0.0
     * @static
     */
    public static function instance()
    {
        // Get an instance of Class
        if (is_null(self::$instance)) self::$instance = new self();

        // Return the instance
        return self::$instance;
    }

    /**
     * Plugin Constructor.
     */
    protected function __construct()
    {
        // Define Constants
        $this->define_constants();

        // Auto Loader
        spl_autoload_register([$this, 'autoload']);

        // Initialize the Plugin
        $this->init();

        // Listdomer Core Loaded
        do_action('lsdrc_loaded');
    }

    /**
     * Define Plugin Constants.
     */
    private function define_constants()
    {
        // Absolute Path
        if (!defined('LSDRC_ABSPATH')) define('LSDRC_ABSPATH', dirname(__FILE__));

        // Plugin Base Name
        if (!defined('LSDRC_BASENAME')) define('LSDRC_BASENAME', plugin_basename(LSDRC_ABSPATH . '/listdomer-core.php'));

        // Directory Name
        if (!defined('LSDRC_DIRNAME')) define('LSDRC_DIRNAME', basename(LSDRC_ABSPATH));

        // Version
        if (!defined('LSDRC_VERSION')) define('LSDRC_VERSION', $this->version);
    }

    /**
     * Initialize the Plugin
     */
    private function init()
    {
        // Internationalization
        $i18n = new LSDRC_i18n();
        $i18n->init();

        // Actions / Filters
        $Hooks = new LSDRC_Hooks();
        $Hooks->init();
    }

    /**
     * Automatically load plugin classes whenever needed.
     * @param string $class_name
     * @return void
     */
    private function autoload(string $class_name)
    {
        $class_ex = explode('_', strtolower($class_name));

        // It's not a plugin class
        if ($class_ex[0] != 'lsdrc') return;

        // Drop 'LSDRC'
        $class_path = array_slice($class_ex, 1);

        // Create Class File Path
        $file_path = LSDRC_ABSPATH . '/app/includes/' . implode('/', $class_path) . '.php';

        // We found the class!
        if (file_exists($file_path)) require_once $file_path;
    }
}
