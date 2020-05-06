<?php

/**
 * Fired during plugin activation.
 *
 * This class defines all code necessary to run during the plugin's activation.
 *
 * @package    junglehunter
 * @subpackage junglehunter/includes
 * @author     Halil Bahar
 */
class Junglehunter_Activator {

	/**
	 * Creates the database tables if they do not exist
	 */
	public static function activate() {
        JungleHunter_Database::junglehunter_create_tables();
	}
}
