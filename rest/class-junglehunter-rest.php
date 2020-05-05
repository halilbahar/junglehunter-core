<?php

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and examples to create your REST access
 * methods. Don't forget to validate and sanatize incoming data!
 *
 * @package    junglehunter
 * @subpackage junglehunter/public
 * @author     Halil Bahar
 */
class Junglehunter_Rest {

    /**
     * The ID of this plugin.
     *
     * @since    1.0.0
     * @access   private
     * @var      string $plugin_name The ID of this plugin.
     */
    private $plugin_name;

    /**
     * The version of this plugin.
     *
     * @since    1.0.0
     * @access   private
     * @var      string $version The current version of this plugin.
     */
    private $version;

    /**
     * Initialize the class and set its properties.
     *
     * @param string $plugin_name The name of this plugin.
     * @param string $version The version of this plugin.
     * @since       1.0.0
     */
    public function __construct($plugin_name, $version) {

        $this->plugin_name = $plugin_name;
        $this->version = $version;
    }

    public function register_routes() {
        $namespace = 'junglehunter/v1';
        register_rest_route($namespace, '/all', array(
            'methods' => 'GET',
            'callback' => array($this, 'junglehunter_get_all')
        ));
    }

    public function junglehunter_get_all(\WP_REST_Request $request) {
        return rest_ensure_response(JungleHunter_Database::junglehunter_get_all());
    }
}

