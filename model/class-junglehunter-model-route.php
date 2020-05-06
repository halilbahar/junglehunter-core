<?php

/**
 * The model for the Route
 *
 * @package    junglehunter
 * @subpackage junglehunter/model
 * @author     Halil Bahar
 */
class Junglehunter_Route {

    /**
     * @var int
     */
    public $id;

    /**
     * @var string
     */
    public $name;

    /**
     * @var string
     */
    public $start;

    /**
     * @var string
     */
    public $url;

    /**
     * @var string
     */
    public $description;

    /**
     * @var Junglehunter_Trail[]
     */
    public $trails;

    /**
     * Junglehunter_Route constructor.
     * @param int $id
     * @param string $name
     * @param string $start
     * @param string $url
     * @param string $description
     * @param Junglehunter_Trail[] $trails
     */
    public function __construct($id, $name, $start, $url, $description, array $trails = array()) {
        $this->id = $id;
        $this->name = $name;
        $this->start = $start;
        $this->url = $url;
        $this->description = $description;
        $this->trails = $trails;
    }
}
