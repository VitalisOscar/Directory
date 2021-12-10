<?php

class User extends Model{

    public $name, $phone, $email, $role, $registered_at;
    protected $password;

    function __construct($data = []){
        $this->name = $data['name'] ?? $data['user_name'] ?? null;
        $this->email = $data['email'] ?? $data['user_email'] ?? null;
        $this->phone = $data['phone'] ?? $data['user_phone'] ?? null;
        $this->role = $data['role'] ?? $data['user_role'] ?? null;
        $this->setId($data['id'] ?? $data['user_id'] ?? null);
        $this->updateDate($data['registered_at'] ?? null);
        $this->data = $data;
    }

    function setPassword($password){
        $this->password = $password;
    }

    function changePassword($password){
        $this->password = password_hash($password, PASSWORD_DEFAULT);
    }

    function isAdmin(){
        return strtolower($this->role) == 'admin';
    }

    function updateDate($time){
        $this->registered_at = explode(' ', $time)[0];
    }

    static function fromArray($data = []){
        return new User($data);
    }
}
