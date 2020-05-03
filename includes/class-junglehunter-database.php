<?php

class JungleHunter_Database {

    public static function junglehunter_create_tables() {
        global $wpdb;
        $prefix = $wpdb->prefix;
        $sql_route = "CREATE TABLE IF NOT EXISTS {$prefix}jh_route (
            route_name VARCHAR(100) NOT NULL,
            start VARCHAR(100) NOT NULL,
            url VARCHAR(255) NOT NULL,
            description VARCHAR(255) NOT NULL,
            CONSTRAINT PK_jh_route PRIMARY KEY (route_name)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4";

        $sql_trail = "CREATE TABLE IF NOT EXISTS {$prefix}jh_trail (
            trail_id INT(11) NOT NULL AUTO_INCREMENT,
            trail_name VARCHAR(100) NOT NULL,
            length DOUBLE NOT NULL,
            route_name VARCHAR(100) NOT NULL,
            CONSTRAINT PK_jh_trail PRIMARY KEY (trail_id),
            CONSTRAINT FK_jh_route_jh_trail FOREIGN KEY (route_name) 
                REFERENCES {$prefix}jh_route (route_name) ON DELETE CASCADE ON UPDATE CASCADE
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4";

        $sql_control_point = "CREATE TABLE IF NOT EXISTS {$prefix}jh_control_point (
            control_point_id INT(11) NOT NULL AUTO_INCREMENT,
            name VARCHAR(50) NOT NULL,
            comment VARCHAR(255) NOT NULL,
            note VARCHAR(255) NOT NULL,
            trail_id INT(11) NOT NULL,
            latitude DOUBLE NOT NULL,
            longitude DOUBLE NOT NULL,
            CONSTRAINT PK_jh_control_point PRIMARY KEY (control_point_id),
            CONSTRAINT FK_jh_trail_jh_control_point FOREIGN KEY (trail_id) 
                REFERENCES {$prefix}jh_trail (trail_id) ON DELETE CASCADE ON UPDATE CASCADE
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4";

        require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
        dbDelta($sql_route);
        dbDelta($sql_trail);
        dbDelta($sql_control_point);
    }

    public static function junglehunter_get_routes() {
        global $wpdb;
        $prefix = $wpdb->prefix;
        $sql_routes_select = "SELECT route_name, start, url, description FROM ${prefix}jh_route";
        return $wpdb->get_results($sql_routes_select);
    }

    public static function junglehunter_get_route_by_name($name) {
        global $wpdb;
        $prefix = $wpdb->prefix;
        $sql_routes_select = "SELECT route_name, start, url, description FROM ${prefix}jh_route WHERE route_name = %s";
        return $wpdb->get_row($wpdb->prepare($sql_routes_select, $name));
    }

    public static function junglehunter_insert_route($name, $start, $url, $description) {
        global $wpdb;
        $prefix = $wpdb->prefix;

        $data = array(
            'route_name' => $name,
            'start' => $start,
            'url' => $url,
            'description' => $description
        );

        $wpdb->insert("${prefix}jh_route", $data);
    }

    public static function junglehunter_delete_route($name) {
        global $wpdb;
        $prefix = $wpdb->prefix;

        return $wpdb->delete("${prefix}jh_route", array('route_name' => $name)) == 1;
    }

    public static function junglehunter_update_route($original_name, $name, $start, $url, $description) {
        global $wpdb;
        $prefix = $wpdb->prefix;

        $data = array(
            'route_name' => $name,
            'start' => $start,
            'url' => $url,
            'description' => $description
        );

        return $wpdb->update("${prefix}jh_route", $data, array('route_name' => $original_name));
    }

    public static function junglehunter_get_trails() {
        global $wpdb;
        $prefix = $wpdb->prefix;
        $sql_trails_select = "SELECT trail_id, trail_name, length, route_name FROM ${prefix}jh_trail";
        return $wpdb->get_results($sql_trails_select);
    }

    public static function junglehunter_insert_trail($name, $length, $route) {
        global $wpdb;
        $prefix = $wpdb->prefix;

        $data = array(
            'trail_name' => $name,
            'length' => $length,
            'route_name' => $route
        );

        $wpdb->insert("${prefix}jh_trail", $data);
    }
}
