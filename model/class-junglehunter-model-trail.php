<?php


class Junglehunter_Trail {

    /**
     * @var int
     */
    private $id;
    /**
     * @var string
     */
    private $name;

    /**
     * @var int
     */
    private $length;

    /**
     * @var Junglehunter_Route[]
     */
    private $control_points;

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

    /**
     * @return int
     */
    public function getId() {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId($id) {
        $this->id = $id;
    }

    /**
     * @return string
     */
    public function getName() {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName($name) {
        $this->name = $name;
    }

    /**
     * @return int
     */
    public function getLength() {
        return $this->length;
    }

    /**
     * @param int $length
     */
    public function setLength($length) {
        $this->length = $length;
    }

    /**
     * @return Junglehunter_Route[]
     */
    public function getControlPoints() {
        return $this->control_points;
    }

    /**
     * @param Junglehunter_Route[] $control_points
     */
    public function setControlPoints($control_points) {
        $this->control_points = $control_points;
    }
}
