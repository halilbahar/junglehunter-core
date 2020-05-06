<?php

/**
 * The model for the Trail
 *
 * @package    junglehunter
 * @subpackage junglehunter/model
 * @author     Halil Bahar
 */
class Junglehunter_Trail {

    /**
     * @var int
     */
    public $id;

    /**
     * @var string
     */
    public $name;

    /**
     * @var int
     */
    public $length;

    /**
     * @var Junglehunter_Route[]
     */
    public $control_points;

    /**
     * Junglehunter_Trail constructor.
     * @param int $id
     * @param string $name
     * @param int $length
     * @param Junglehunter_Route[] $control_points
     */
    public function __construct($id, $name, $length, array $control_points = array()) {
        $this->id = $id;
        $this->name = $name;
        $this->length = $length;
        $this->control_points = $control_points;
    }
}
