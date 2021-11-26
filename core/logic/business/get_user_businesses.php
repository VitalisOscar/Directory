<?php

/**
 * Get a user's owned businesses
 * @param User $user
 * @return Business[]
 */
function getUserOwnedBusinesses($user){
    $conn = db();
    $limit = 15;
    $page = get('page', $conn, 1);
    $offset = ($page - 1) * $limit;

    $sql = "SELECT businesses.*,
        `categories`.`name` as `category_name`,
        `users`.`name` as `user_name`,
        `users`.`phone` as `user_phone`,
        `users`.`email` as `user_email`,
        (SELECT count(*) FROM `reviews` WHERE `reviews`.`business_id` = `businesses`.`id`)
            AS `total_reviews`,
        (SELECT avg(`reviews`.`rating`) FROM `reviews` WHERE `reviews`.`business_id` = `businesses`.`id`)
            AS `average_rating`
        FROM businesses
        INNER JOIN `categories` ON `businesses`.`category_id` = `categories`.`id`
        INNER JOIN `users` ON `businesses`.`user_id` = `users`.`id`
        WHERE `businesses`.`user_id` = ".$user->getId()." LIMIT $limit OFFSET $offset";

    $result = $conn->query($sql);

    $businesses = [];

    while($data = $result->fetch_assoc()){
        array_push($businesses, Business::fromArray($data));
    }

    return $businesses;
}

/**
 * Get a single user's owned business info
 * @param User $user
 * @return Business|null
 */
function getSingleUserOwnedBusiness($user){
    $conn = db();
    $business_id = get('business_id', $conn);

    if($business_id == null){
        return null;
    }

    $sql = "SELECT businesses.*,
        `categories`.`name` as `category_name`,
        `users`.`name` as `user_name`,
        `users`.`phone` as `user_phone`,
        `users`.`email` as `user_email`,
        (SELECT count(*) FROM `reviews` WHERE `reviews`.`business_id` = `businesses`.`id`)
            AS `total_reviews`,
        (SELECT avg(`reviews`.`rating`) FROM `reviews` WHERE `reviews`.`business_id` = `businesses`.`id`)
            AS `average_rating`
        FROM businesses
        INNER JOIN `categories` ON `businesses`.`category_id` = `categories`.`id`
        INNER JOIN `users` ON `businesses`.`user_id` = `users`.`id`
        WHERE `businesses`.`user_id` = ".$user->getId().
        " AND `businesses`.`id` = $business_id LIMIT 1";

    $result = $conn->query($sql);

    $data = $result->fetch_assoc();

    return $data ? Business::fromArray($data) : null;
}
