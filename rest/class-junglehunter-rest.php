<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @package    junglehunter
 * @subpackage junglehunter/rest
 * @author     Halil Bahar
 */
class Junglehunter_Rest {

    /**
     * The ID of this plugin.
     * @var string
     */
    private $plugin_name;

    /**
     * The version of this plugin.
     * @var string
     */
    private $version;

    /**
     * Initialize the class and set its properties.
     *
     * @param string $plugin_name The name of this plugin.
     * @param string $version The version of this plugin.
     */
    public function __construct($plugin_name, $version) {
        $this->plugin_name = $plugin_name;
        $this->version = $version;
    }

    /**
     * Register all the routes that will face the public
     */
    public function register_routes() {
        $namespace = 'junglehunter/v1';
        register_rest_route(
            $namespace,
            '/all',
            array(
                'methods' => 'GET',
                'callback' => array($this, 'junglehunter_get_all')
            )
        );
    }

    /**
     * The function that will be called when requesting to junglehunter/v1/all
     * @return mixed
     */
    public function junglehunter_get_all() {
        return rest_ensure_response(JungleHunter_Database::junglehunter_get_all());
    }
}

