<?php

class User extends Model{

    public $name, $phone, $email;
    protected $password;

    function __construct($data = []){
        $this->name = $data['name'] ?? $data['user_name'] ?? null;
        $this->email = $data['email'] ?? $data['user_email'] ?? null;
        $this->phone = $data['phone'] ?? $data['user_phone'] ?? null;
        $this->setId($data['id'] ?? $data['user_id'] ?? null);
        $this->data = $data;
    }

    function setPassword($password){
        $this->password = $password;
    }

    function changePassword($password){
        $this->password = password_hash($password, PASSWORD_DEFAULT);
    }

    static function fromArray($data = []){
        return new User($data);
    }
}
