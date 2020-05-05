<?php

class Junglehunter_Route {

    /**
     * @var int
     */
    private $route_id;

    /**
     * @var string
     */
    private $route_name;

    /**
     * @var string
     */
    private $start;

    /**
     * @var string
     */
    private $url;

    /**
     * @var string
     */
    private $description;


    /**
     * @var Junglehunter_Trail[]
     */
    private $trails;

    /**
     * Junglehunter_Route constructor.
     * @param int $route_id
     * @param string $route_name
     * @param string $start
     * @param string $url
     * @param string $description
     * @param Junglehunter_Trail[] $trails
     */
    public function __construct($route_id, $route_name, $start, $url, $description, array $trails = array()) {
        $this->route_id = $route_id;
        $this->route_name = $route_name;
        $this->start = $start;
        $this->url = $url;
        $this->description = $description;
        $this->trails = $trails;
    }

    /**
     * @return mixed
     */
    public function getRouteId() {
        return $this->route_id;
    }

    /**
     * @param mixed $route_id
     */
    public function setRouteId($route_id) {
        $this->route_id = $route_id;
    }

    /**
     * @return mixed
     */
    public function getRouteName() {
        return $this->route_name;
    }

    /**
     * @param mixed $route_name
     */
    public function setRouteName($route_name) {
        $this->route_name = $route_name;
    }

    /**
     * @return mixed
     */
    public function getStart() {
        return $this->start;
    }

    /**
     * @param mixed $start
     */
    public function setStart($start) {
        $this->start = $start;
    }

    /**
     * @return mixed
     */
    public function getUrl() {
        return $this->url;
    }

    /**
     * @param mixed $url
     */
    public function setUrl($url) {
        $this->url = $url;
    }

    /**
     * @return mixed
     */
    public function getDescription() {
        return $this->description;
    }

    /**
     * @param mixed $description
     */
    public function setDescription($description) {
        $this->description = $description;
    }

    /**
     * @return mixed
     */
    public function getTrails() {
        return $this->trails;
    }

    /**
     * @param mixed $trails
     */
    public function setTrails($trails) {
        $this->trails = $trails;
    }
}
