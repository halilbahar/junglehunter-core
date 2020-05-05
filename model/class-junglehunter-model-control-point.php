<?php

class Junglehunter_Control_Point {

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
    public $comment;

    /**
     * @var string
     */
    public $note;

    /**
     * @var float
     */
    public $latitude;

    /**
     * @var float
     */
    public $longitude;

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
}
