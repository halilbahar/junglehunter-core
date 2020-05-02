<?php

/**
 * Fired during plugin activation.
 *
 * This class defines all code necessary to run during the plugin's activation.
 *
 * @since      1.0.0
 * @package    junglehunter
 * @subpackage junglehunter/includes
 * @author     Halil Bahar
 */
class Junglehunter_Activator {

	/**
	 * Short Description. (use period)
	 *
	 * Long Description.
	 *
	 * @since    1.0.0
	 */
	public static function activate() {
        JungleHunter_Database::junglehunter_create_tables();
	}
}
