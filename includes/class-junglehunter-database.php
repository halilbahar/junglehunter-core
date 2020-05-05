<?php

class JungleHunter_Database {

    public static function junglehunter_create_tables() {
        global $wpdb;
        $prefix = $wpdb->prefix;
        $sql_route = "CREATE TABLE IF NOT EXISTS {$prefix}jh_route (
            route_id INT(11) NOT NULL AUTO_INCREMENT,
            route_name VARCHAR(100) NOT NULL,
            start VARCHAR(100) NOT NULL,
            url VARCHAR(255) NOT NULL,
            description VARCHAR(255) NOT NULL,
            UNIQUE(route_name),
            CONSTRAINT PK_jh_route PRIMARY KEY (route_id)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4";

        $sql_trail = "CREATE TABLE IF NOT EXISTS {$prefix}jh_trail (
            trail_id INT(11) NOT NULL AUTO_INCREMENT,
            trail_name VARCHAR(100) NOT NULL,
            length DOUBLE NOT NULL,
            route_id INT(11) NOT NULL,
            UNIQUE(trail_name),
            CONSTRAINT PK_jh_trail PRIMARY KEY (trail_id),
            CONSTRAINT FK_jh_route_jh_trail FOREIGN KEY (route_id) 
                REFERENCES {$prefix}jh_route (route_id) ON DELETE CASCADE ON UPDATE CASCADE
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4";

        $sql_control_point = "CREATE TABLE IF NOT EXISTS {$prefix}jh_control_point (
            control_point_id INT(11) NOT NULL AUTO_INCREMENT,
            control_point_name VARCHAR(50) NOT NULL,
            comment VARCHAR(255) NOT NULL,
            note VARCHAR(255) NOT NULL,
            latitude DOUBLE NOT NULL,
            longitude DOUBLE NOT NULL,
            trail_id INT(11) NOT NULL,
            UNIQUE(control_point_name),
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
        $sql_routes_select = "SELECT route_id, route_name, start, url, description FROM ${prefix}jh_route";
        return $wpdb->get_results($sql_routes_select);
    }

    public static function junglehunter_get_route_by_name($name) {
        global $wpdb;
        $prefix = $wpdb->prefix;
        $sql_routes_select = "SELECT route_id, route_name, start, url, description FROM ${prefix}jh_route WHERE route_name = %s";
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

    public static function junglehunter_delete_route($id) {
        global $wpdb;
        $prefix = $wpdb->prefix;

        return $wpdb->delete("${prefix}jh_route", array('route_id' => $id)) == 1;
    }

    public static function junglehunter_update_route($id, $name, $start, $url, $description) {
        global $wpdb;
        $prefix = $wpdb->prefix;

        $data = array(
            'route_name' => $name,
            'start' => $start,
            'url' => $url,
            'description' => $description
        );

        return $wpdb->update("${prefix}jh_route", $data, array('route_id' => $id));
    }

    public static function junglehunter_get_trails() {
        global $wpdb;
        $prefix = $wpdb->prefix;
        $trail = "${prefix}jh_trail";
        $route = "${prefix}jh_route";
        $sql_trails_select = "SELECT ${trail}.trail_id, ${trail}.trail_name, ${trail}.length,
            ${trail}.route_id, ${route}.route_name FROM ${trail}
            INNER JOIN ${route} ON ${route}.route_id = ${trail}.route_id";
        return $wpdb->get_results($sql_trails_select);
    }

    public static function junglehunter_get_trail_by_name($name) {
        global $wpdb;
        $prefix = $wpdb->prefix;
        $sql_trail_select = "SELECT trail_id, trail_name, length, route_id FROM ${prefix}jh_trail WHERE trail_name = %s";
        return $wpdb->get_row($wpdb->prepare($sql_trail_select, $name));
    }

    public static function junglehunter_insert_trail($name, $length, $route_id) {
        global $wpdb;
        $prefix = $wpdb->prefix;

        $data = array(
            'trail_name' => $name,
            'length' => $length,
            'route_id' => $route_id
        );

        $wpdb->insert("${prefix}jh_trail", $data);
    }

    public static function junglehunter_delete_trail($id) {
        global $wpdb;
        $prefix = $wpdb->prefix;

        return $wpdb->delete("${prefix}jh_trail", array('trail_id' => $id)) == 1;
    }

    public static function junglehunter_update_trail($id, $name, $length, $route_id) {
        global $wpdb;
        $prefix = $wpdb->prefix;

        $data = array(
            'trail_name' => $name,
            'length' => $length,
            'route_id' => $route_id
        );

        return $wpdb->update("${prefix}jh_trail", $data, array('trail_id' => $id));
    }

    public static function junglehunter_get_control_points() {
        global $wpdb;
        $prefix = $wpdb->prefix;
        $control_point = "${prefix}jh_control_point";
        $trail = "${prefix}jh_trail";
        $sql_trails_select = "SELECT ${control_point}.control_point_id, ${control_point}.control_point_name,
            ${control_point}.comment, ${control_point}.note, ${control_point}.latitude, ${control_point}.longitude,
            ${control_point}.trail_id, ${trail}.trail_name FROM ${control_point}
            INNER JOIN ${trail} ON ${trail}.trail_id = ${control_point}.trail_id";
        return $wpdb->get_results($sql_trails_select);
    }

    public static function junglehunter_insert_control_point($name, $comment, $note, $latitude, $longitude, $trail_id) {
        global $wpdb;
        $prefix = $wpdb->prefix;

        $data = array(
            'control_point_name' => $name,
            'comment' => $comment,
            'note' => $note,
            'latitude' => $latitude,
            'longitude' => $longitude,
            'trail_id' => $trail_id
        );

        $wpdb->insert("${prefix}jh_control_point", $data);
    }

    public static function junglehunter_delete_control_point($id) {
        global $wpdb;
        $prefix = $wpdb->prefix;

        return $wpdb->delete("${prefix}jh_control_point", array('control_point_id' => $id)) == 1;
    }

    public static function junglehunter_update_control_point($id, $name, $comment, $note, $latitude, $longitude, $trail_id) {
        global $wpdb;
        $prefix = $wpdb->prefix;

        $data = array(
            'control_point_name' => $name,
            'comment' => $comment,
            'note' => $note,
            'latitude' => $latitude,
            'longitude' => $longitude,
            'trail_id' => $trail_id
        );

        return $wpdb->update("${prefix}jh_control_point", $data, array('control_point_id' => $id));
    }
}
