<?php

/**
 * Get business' reviews
 * @param int $business_id
 * @return Review[]
 */
function getBusinessReviews($business_id){
    $conn = db();
    $limit = 15;
    $page = get('page', $conn, 1);
    $offset = ($page - 1) * $limit;

    $sql = "SELECT reviews.*,
        `users`.`name` as `user_name`
        FROM reviews
        INNER JOIN `businesses` ON `businesses`.`id` = `reviews`.`business_id`
        INNER JOIN `users` ON `reviews`.`user_id` = `users`.`id`
        WHERE `reviews`.`business_id` = $business_id
        ORDER BY `reviews`.`added_at` DESC
        LIMIT $limit OFFSET $offset";

    $result = $conn->query($sql);


    $reviews = [];

    while($data = $result->fetch_assoc()){
        array_push($reviews, Review::fromArray($data));
    }

    return $reviews;
}

/**
 * Check if a business has been reviewed by a user
 * @param Business $business
 * @param User $user
 * @return null|Review
 */
function businessReviewedBy($business, $user){
    $conn = db();

    $sql = "SELECT reviews.*
        FROM reviews
        INNER JOIN `businesses` ON `businesses`.`id` = `reviews`.`business_id`
        INNER JOIN `users` ON `reviews`.`user_id` = `users`.`id`
        WHERE `reviews`.`business_id` = ".$business->getId()."
        AND `reviews`.`user_id` = ".$user->getId()."
        LIMIT 1";

    $result = $conn->query($sql);
    
    $data = $result->fetch_assoc();

    if($data == null){
        return null;
    }

    return Review::fromArray($data);
}

/**
 * Check if a business has been acknowledged by a user
 * @param Business $business
 * @param User $user
 * @return null|Acknowledgement
 */
function businessAcknowledgedBy($business, $user){
    $conn = db();

    $sql = "SELECT acknowledgements.*
        FROM acknowledgements
        INNER JOIN `businesses` ON `businesses`.`id` = `acknowledgements`.`business_id`
        INNER JOIN `users` ON `acknowledgements`.`user_id` = `users`.`id`
        WHERE `acknowledgements`.`business_id` = ".$business->getId()."
        AND `acknowledgements`.`user_id` = ".$user->getId()."
        LIMIT 1";

    $result = $conn->query($sql);
    
    $data = $result->fetch_assoc();

    if($data == null){
        return null;
    }

    return Acknowledgement::fromArray($data);
}

/**
 * Add a user's review
 * @param Business $business
 * @param User $user
 * @param string $title
 * @param string $review
 * @param int $rating
 * @return bool|string
 */
function addReview($business, $user, $title, $review, $rating){
    if(businessReviewedBy($business, $user)){
        return 'You have already reviewed this business before';
    }

    // A review is also an acknowledgement
    acknowledgeBusiness($business, $user);

    $conn = db();

    $sql = "INSERT INTO reviews (`title`, `review`, `rating`, `user_id`, `business_id`)
    VALUES('$title', '$review', $rating, ".$user->getId().",".$business->getId().")";

    return $conn->query($sql);
}

/**
 * Add a user's acknowledgement
 * @param Business $business
 * @param User $user
 * @return bool|string
 */
function acknowledgeBusiness($business, $user){
    if(businessAcknowledgedBy($business, $user)){
        return 'You have already acknowledged this business before';
    }

    $conn = db();

    $sql = "INSERT INTO acknowledgements (`user_id`, `business_id`)
    VALUES(".$user->getId().",".$business->getId().")";

    return $conn->query($sql);
}

/**
 * Get reviews by a particular user
 * @param User $user
 * @return Review[]
 */
function getUserReviews($user){
    $conn = db();
    $limit = 35;
    $page = get('page', $conn, 1);
    $offset = ($page - 1) * $limit;

    $sql = "SELECT reviews.*,
        `users`.`name` as `user_name`,
        `businesses`.`name` as `business_name`
        FROM reviews
        INNER JOIN `businesses` ON `businesses`.`id` = `reviews`.`business_id`
        INNER JOIN `users` ON `reviews`.`user_id` = `users`.`id`
        WHERE `reviews`.`user_id` = ".$user->getId()."
        ORDER BY `reviews`.`added_at` DESC
        LIMIT $limit OFFSET $offset";

    $result = $conn->query($sql);


    $reviews = [];

    while($data = $result->fetch_assoc()){
        array_push($reviews, Review::fromArray($data));
    }

    return $reviews;
}
