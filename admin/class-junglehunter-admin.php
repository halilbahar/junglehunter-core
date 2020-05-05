<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 */
class Junglehunter_Admin {

    /**
     * The ID of this plugin.
     */
    private $plugin_name;

    /**
     * The version of this plugin.
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
     * Register junglehutner menu page to wordpress
     */
    public function junglehunter_add_menus() {
        add_menu_page('Junglehunter', 'Junglehunter', 'manage_options', 'junglehunter-routes');

        add_submenu_page('junglehunter-routes', 'Junglehunter Routes', 'Routes', 'manage_options', 'junglehunter-routes', array(
            $this,
            'junglehunter_routes_page_html'
        ));

        add_submenu_page('junglehunter-routes', 'Junglehunter Trails', 'Trails', 'manage_options', 'junglehunter-trails', array(
            $this,
            'junglehunter_trails_page_html'
        ));

        add_submenu_page('junglehunter-routes', 'Junglehunter Control Points', 'Control Points', 'manage_options', 'junglehunter-control-points', array(
            $this,
            'junglehunter_control_points_page_html'
        ));
    }

    public function junglehunter_enqueue_styles() {
        wp_enqueue_style($this->plugin_name . '_style', plugin_dir_url(__FILE__) . 'css/junglehunter-admin.css', array(), $this->version, 'all');
    }

    public function junglehunter_enqueue_scripts() {
        wp_enqueue_script($this->plugin_name, plugin_dir_url(__FILE__) . 'js/junglehunter-admin.js', array('jquery'), $this->version, false);
    }

    public function junglehunter_routes_page_html() {
        require_once plugin_dir_path(dirname(__FILE__)) . 'admin/partials/junglehunter-admin-routes-display.php';
    }

    public function junglehunter_trails_page_html() {
        require_once plugin_dir_path(dirname(__FILE__)) . 'admin/partials/junglehunter-admin-trails-display.php';
    }

    public function junglehunter_control_points_page_html() {
        require_once plugin_dir_path(dirname(__FILE__)) . 'admin/partials/junglehunter-admin-control-points-display.php';
    }
}
