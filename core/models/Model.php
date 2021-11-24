<?php

abstract class Model{

    protected $id;
    public $data;

    /**
     * Get a model from an associative array
     */
    abstract static function fromArray($data = []);

    function getId(){
        return $this->id;
    }

    function setId($id){
        $this->id = $id;
    }
}
