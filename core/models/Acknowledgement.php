<?php

class Acknowledgement extends Model{

    public $business, $user;

    function __construct($data = []){
        $this->setId($data['id'] ?? null);
        $this->data = $data;

        $this->user = User::fromArray([
            'id' => $data['user_id']  ?? null,
            'name' => $data['user_name']  ?? null,
            'email' => $data['user_email']  ?? null,
            'phone' => $data['user_phone']  ?? null,
        ]);

        $this->business = Business::fromArray([
            'id' => $data['business_id']  ?? null,
            'name' => $data['business_name']  ?? null
        ]);
    }

    static function fromArray($data = []){
        return new Acknowledgement($data);
    }
}
