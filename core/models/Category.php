<?php

class Category extends Model{

    public $name;

    function __construct($data = []){
        $this->name = $data['name'] ?? null;
        $this->setId($data['id'] ?? null);
        $this->data = $data;
    }

    static function fromArray($data = []){
        return new Category($data);
    }
}
