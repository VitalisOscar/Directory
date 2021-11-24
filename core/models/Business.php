<?php

class Business extends Model{

    public $name, $description, $address, $phone, $email, $website;
    public $images, $open_hours;
    public $user, $category;

    function __construct($data = []){
        $this->name = $data['name'] ?? null;
        $this->description = $data['description'] ?? null;
        $this->address = $data['address'] ?? null;
        $this->phone = $data['phone'] ?? null;
        $this->email = $data['email'] ?? null;
        $this->website = ($data['website'] ?? '') == '' ? 'No website added':$data['website'];
        $this->images = json_decode($data['images'] ?? "[]", true);
        $this->open_hours = json_decode($data['open_hours'] ?? "[]", true);
        $this->setId($data['id'] ?? null);
        $this->data = $data;

        $this->user = User::fromArray([
            'id' => $data['user_id']  ?? null,
            'name' => $data['user_name']  ?? null,
            'email' => $data['user_email']  ?? null,
            'phone' => $data['user_phone']  ?? null,
        ]);

        $this->category = Category::fromArray([
            'id' => $data['category_id'] ?? null,
            'name' => $data['category_name'] ?? null
        ]);
    }

    function isOpen(){
        $open_hours = $this->open_hours;
        $today = '';

        $opens_full_day = true;

        if($opens_full_day){
            return true;
        }

        $opens_at = '';
        $closes_at = '';

        $now = '';

        return ($now >= $opens_at && $now < $closes_at);
    }

    static function fromArray($data = []){
        return new Business($data);
    }
}
