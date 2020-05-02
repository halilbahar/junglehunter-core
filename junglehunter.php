<?php

/**
 * @link              http://example.com
 * @since             1.0.0
 * @package           Plugin_Name
 *
 * @wordpress-plugin
 * Plugin Name:       Junglehunter Core
 * Description:       This is the junglehunter logic with the API and Database
 * Version:           1.0.0
 * Author:            Halil Bahar
 * Author URI:        https://github.com/halilbahar
 */

// If this file is called directly, abort.
if (!defined('WPINC')) {
    die;
}

/**
 * Currently plugin version.
 * Start at version 1.0.0 and use SemVer - https://semver.org
 * Rename this for your plugin and update it as you release new versions.
 */
define('JUNGLEHUNTER_VERSION', '1.0.0');

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-junglehunter-activator.php
 */
function activate_junglehunter() {
    require_once plugin_dir_path(__FILE__) . 'includes/class-junglehunter-activator.php';
    Junglehunter_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-junglehunter-deactivator.php
 */
function deactivate_junglehunter() {
    require_once plugin_dir_path(__FILE__) . 'includes/class-junglehunter-deactivator.php';
    Junglehunter_Deactivator::deactivate();
}

register_activation_hook(__FILE__, 'activate_junglehunter');
register_deactivation_hook(__FILE__, 'deactivate_junglehunter');

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path(__FILE__) . 'includes/class-junglehunter.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_junglehunter() {

    $plugin = new Junglehunter();
    $plugin->run();

}

run_junglehunter();
