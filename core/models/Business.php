<?php

use Carbon\Carbon;

class Business extends Model{

    public $name, $description, $address, $phone, $email, $website;
    public $images, $hours;
    public $user, $category;

    function __construct($data = []){
        $this->name = $data['name'] ?? null;
        $this->description = $data['description'] ?? null;
        $this->address = $data['address'] ?? null;
        $this->phone = $data['phone'] ?? null;
        $this->email = $data['email'] ?? null;
        $this->website = ($data['website'] ?? '') == '' ? 'No website added':$data['website'];
        $this->images = json_decode($data['images'] ?? "[]", true);
        $this->hours = json_decode($data['hours'] ?? "[]", true);
        $this->setId($data['id'] ?? null);
        $this->data = $data;
        $this->updateDate($data['added_at'] ?? null);

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
        $hours = $this->hours;
        $now = Carbon::now();

        $key = strtolower($now->dayName);

        // check if closed today
        if(!isset($hours[$key]) || $hours[$key] == []){
            return false;
        }

        $opens_at = $hours[$key]['opens'] ?? 8;
        $closes_at = $hours[$key]['closes'] ?? 18;
        if($closes_at == 0) $closes_at = 24;

        $now = $now->hour;

        return ($now >= $opens_at && $now < $closes_at);
    }

    function getTodayHours(){
        $hours = $this->hours;
        $now = Carbon::now();
        $day = $now->dayName;

        $key = strtolower($now->dayName);

        // check if closed today
        if(!isset($hours[$key]) || $hours[$key] == []){
            return $day.' - Closed';
        }

        $opens_at = $hours[$key]['opens'] ?? 8;
        $closes_at = $hours[$key]['closes'] ?? 18;

        return $day.
            ' ('.$now->setTime($opens_at, 0)->format('H:i').
            ' to '.
            $now->setTime($closes_at, 0)->format('H:i').
            ')';
    }

    function getOpensAt($key){
        $hours = $this->hours;

        if(!isset($hours[$key]) || $hours[$key] == []){
            return null;
        }

        return $hours[$key]['opens'];
    }

    function getClosesAt($key){
        $hours = $this->hours;

        if(!isset($hours[$key]) || $hours[$key] == []){
            return null;
        }

        return $hours[$key]['closes'];
    }

    function updateDate($time){
        $this->added_at = explode(' ', $time)[0];
    }

    static function fromArray($data = []){
        return new Business($data);
    }
}
