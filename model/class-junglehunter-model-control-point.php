<?php

class Junglehunter_Control_Point {

    /**
     * @var int
     */
    private $id;

    /**
     * @var string
     */
    private $name;

    /**
     * @var string
     */
    private $comment;

    /**
     * @var string
     */
    private $note;


    /**
     * @var float
     */
    private $latitude;

    /**
     * @var float
     */
    private $longitude;

    /**
     * Control_Point constructor.
     * @param int $id
     * @param string $name
     * @param string $comment
     * @param string $note
     * @param float $latitude
     * @param float $longitude
     */
    public function __construct($id, $name, $comment, $note, $latitude, $longitude) {
        $this->id = $id;
        $this->name = $name;
        $this->comment = $comment;
        $this->note = $note;
        $this->latitude = $latitude;
        $this->longitude = $longitude;
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
     * @return string
     */
    public function getComment() {
        return $this->comment;
    }

    /**
     * @param string $comment
     */
    public function setComment($comment) {
        $this->comment = $comment;
    }

    /**
     * @return string
     */
    public function getNote() {
        return $this->note;
    }

    /**
     * @param string $note
     */
    public function setNote($note) {
        $this->note = $note;
    }

    /**
     * @return float
     */
    public function getLatitude() {
        return $this->latitude;
    }

    /**
     * @param float $latitude
     */
    public function setLatitude($latitude) {
        $this->latitude = $latitude;
    }

    /**
     * @return float
     */
    public function getLongitude() {
        return $this->longitude;
    }

    /**
     * @param float $longitude
     */
    public function setLongitude($longitude) {
        $this->longitude = $longitude;
    }
}
