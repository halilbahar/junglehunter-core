<?php

/**
 * The core plugin class.
 *
 * This is used to define internationalization, admin-specific hooks, and public-facing rest hooks.
 *
 * @package    junglehunter
 * @subpackage junglehunter/includes
 * @author     Halil Bahar
 */
class Junglehunter {

    /**
     * The loader that's responsible for maintaining and registering all hooks that power the plugin.
     *
     * @var Junglehunter_Loader
     */
    protected $loader;

    /**
     * The unique identifier of this plugin.
     *
     * @var string
     */
    protected $plugin_name;

    /**
     * The current version of the plugin.
     *
     * @var string
     */
    protected $version;

    /**
     * Define the core functionality of the plugin.
     *
     * Set the plugin name and the plugin version that can be used throughout the plugin.
     * Load the dependencies, set the hooks for the admin area and the public-facing rest.
     */
    public function __construct() {
        if (defined('JUNGLEHUNTER_VERSION')) {
            $this->version = JUNGLEHUNTER_VERSION;
        } else {
            $this->version = '1.0.0';
        }
        $this->plugin_name = 'junglehunter';

        $this->load_dependencies();
        $this->define_admin_hooks();
        $this->define_rest_hooks();
    }

    /**
     * Load the required dependencies for this plugin.
     *
     * Include the following files that make up the plugin:
     *
     * - Junglehunter_Loader. Orchestrates the hooks of the plugin.
     * - Junglehunter_Admin. Defines all hooks for the admin area.
     * - Junglehunter_Rest. Defines all hooks for the endpoint.
     *
     * Create an instance of the loader which will be used to register the hooks with WordPress.
     */
    private function load_dependencies() {

        /**
         * The class responsible for orchestrating the actions and filters of the core plugin.
         */
        require_once plugin_dir_path(dirname(__FILE__)) . 'includes/class-junglehunter-loader.php';

        /**
         * The class responsible for defining all actions that occur in the admin area.
         */
        require_once plugin_dir_path(dirname(__FILE__)) . 'admin/class-junglehunter-admin.php';

        /**
         * The class responsible for defining all actions that occur in the rest endpoint.
         */
        require_once plugin_dir_path(dirname(__FILE__)) . 'rest/class-junglehunter-rest.php';

        /**
         * The class responsible for defining all actions that occur in the database
         */
        require_once plugin_dir_path(dirname(__FILE__)) . 'includes/class-junglehunter-database.php';

        $this->loader = new Junglehunter_Loader();
    }

    /**
     * Register all of the hooks related to the admin area functionality
     * of the plugin.
     *
     * @since    1.0.0
     * @access   private
     */
    private function define_admin_hooks() {
        $plugin_admin = new Junglehunter_Admin($this->get_plugin_name(), $this->get_version());

        $this->loader->add_action('admin_menu', $plugin_admin, 'junglehunter_add_menus');
        $this->loader->add_action('admin_enqueue_scripts', $plugin_admin, 'junglehunter_enqueue_styles');
        $this->loader->add_action('admin_enqueue_scripts', $plugin_admin, 'junglehunter_enqueue_scripts');
    }

    /**
     * Register all of the hooks related to the REST functionality of the plugin.
     */
    private function define_rest_hooks() {
        $plugin_rest = new JungleHunter_Rest($this->get_plugin_name(), $this->get_version());
        $this->loader->add_action('rest_api_init', $plugin_rest, 'register_routes');
    }

    /**
     * Run the loader to execute all of the hooks with WordPress.
     */
    public function run() {
        $this->loader->run();
    }

    /**
     * The name of the plugin used to uniquely identify it within the context of WordPress.
     * @return string
     */
    public function get_plugin_name() {
        return $this->plugin_name;
    }

    /**
     * The reference to the class that orchestrates the hooks with the plugin.
     * @return Junglehunter_Loader
     */
    public function get_loader() {
        return $this->loader;
    }

    /**
     * Retrieve the version number of the plugin.
     * @return string
     */
    public function get_version() {
        return $this->version;
    }
}
