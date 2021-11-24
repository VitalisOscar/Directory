<?php

class Review extends Model{

    public $review, $title, $rating, $added_at;
    public $business, $user;

    function __construct($data = []){
        $this->review = $data['review'] ?? 'No review text';
        $this->title = $data['title'] ?? 'No review Title';
        $this->rating = $data['rating'] ?? 1;
        $this->updateDate($data['added_at'] ?? null);
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

    function updateDate($time){
        $this->added_at = explode(' ', $time)[0];
    }

    static function fromArray($data = []){
        return new Review($data);
    }
}
