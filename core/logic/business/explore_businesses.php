<?php

use Carbon\Carbon;

/**
 * Get business list
 * @return Business[]
 */
function getBusinessResults(){
    $conn = db();
    $limit = 15;
    $page = get('page', $conn, 1);
    $offset = ($page - 1) * $limit;

    $sql = "SELECT businesses.*,
        `categories`.`name` as `category_name`,
        `users`.`name` as `user_name`,
        `users`.`phone` as `user_phone`,
        `users`.`email` as `user_email`,
        (SELECT count(*) FROM `acknowledgements` WHERE `acknowledgements`.`business_id` = `businesses`.`id`)
            AS `total_acknowledgements`,
        (SELECT count(*) FROM `reviews` WHERE `reviews`.`business_id` = `businesses`.`id`)
            AS `total_reviews`,
        (SELECT avg(`reviews`.`rating`) FROM `reviews` WHERE `reviews`.`business_id` = `businesses`.`id`)
            AS `average_rating`
        FROM businesses
        INNER JOIN `categories` ON `businesses`.`category_id` = `categories`.`id`
        INNER JOIN `users` ON `businesses`.`user_id` = `users`.`id`";

    // Filters
    $filters = [];

    $category_id = intval(get('category_id') ?? 0);
    if($category_id != 0){
        array_push($filters, "`businesses`.`category_id` = $category_id");
    }

    $location = get('location');
    if($location != null){
        array_push($filters, "`businesses`.`address` LIKE '%$location%'");
    }

    $keyword = get('keyword');
    if($keyword != null){
        array_push($filters,"(`businesses`.`name` LIKE '%$keyword%'
            OR `businesses`.`address` LIKE '%$keyword%')");
    }

    $open = get('open');
    if($open != null){
        $now = Carbon::now();

        $day = strtolower($now->dayName);
        $now = $now->hour;

        array_push($filters,"(
            (json_extract(`hours`, '$.$day.opens') <= $now AND
            json_extract(`hours`, '$.$day.closes') > $now) OR
            (json_extract(`hours`, '$.$day.opens') <= $now AND
            json_extract(`hours`, '$.$day.closes') = 0 AND
            (json_extract(`hours`, '$.$day.closes') + 24) > $now)
        )");
    }

    $known = get('known');
    if($known != null){
        array_push($filters,"(EXISTS(SELECT `reviews`.* FROM `reviews`
            WHERE `reviews`.`business_id` = `businesses`.`id`)
            OR EXISTS(SELECT `acknowledgements`.* FROM `acknowledgements`
            WHERE `acknowledgements`.`business_id` = `businesses`.`id`))");
    }

    if(count($filters) > 0){
        $sql .= " WHERE ".implode(" AND ", $filters);
    }

    // Ordering
    $order = get('order');

    if($order == 'ratings'){
        $sql .= " ORDER BY 
        (SELECT avg(`reviews`.`rating`) FROM `reviews` WHERE `reviews`.`business_id` = `businesses`.`id`) DESC,
        (SELECT count(*) FROM `reviews` WHERE `reviews`.`business_id` = `businesses`.`id`) DESC";
    }else if($order == 'oldest'){
        $sql .= " ORDER BY `businesses`.`added_at` ASC";
    }else{
        $sql .= " ORDER BY `businesses`.`added_at` DESC";
    }

    $sql .= " LIMIT $limit OFFSET $offset";

    $result = $conn->query($sql);

    $businesses = [];

    while($data = $result->fetch_assoc()){
        array_push($businesses, Business::fromArray($data));
    }

    return $businesses;
}

/**
 * Get recommended business list
 * @return Business[]
 */
function getRecommendedBusinesses(){
    $conn = db();
    $limit = 3;
    $page = get('page', $conn, 1);
    $offset = ($page - 1) * $limit;

    $sql = "SELECT businesses.*,
        `categories`.`name` as `category_name`,
        `users`.`name` as `user_name`,
        `users`.`phone` as `user_phone`,
        `users`.`email` as `user_email`,
        (SELECT count(*) FROM `acknowledgements` WHERE `acknowledgements`.`business_id` = `businesses`.`id`)
            AS `total_acknowledgements`,
        (SELECT count(*) FROM `reviews` WHERE `reviews`.`business_id` = `businesses`.`id`)
            AS `total_reviews`,
        (SELECT avg(`reviews`.`rating`) FROM `reviews` WHERE `reviews`.`business_id` = `businesses`.`id`)
            AS `average_rating`
        FROM businesses
        INNER JOIN `categories` ON `businesses`.`category_id` = `categories`.`id`
        INNER JOIN `users` ON `businesses`.`user_id` = `users`.`id`
        ORDER BY
        (SELECT avg(`reviews`.`rating`) FROM `reviews` WHERE `reviews`.`business_id` = `businesses`.`id`) DESC,
        (SELECT count(*) FROM `reviews` WHERE `reviews`.`business_id` = `businesses`.`id`) DESC,
        (SELECT count(*) FROM `acknowledgements` WHERE `acknowledgements`.`business_id` = `businesses`.`id`) DESC
        LIMIT $limit OFFSET $offset";

    $result = $conn->query($sql);

    $businesses = [];

    while($data = $result->fetch_assoc()){
        array_push($businesses, Business::fromArray($data));
    }

    return $businesses;
}

/**
 * Get a single business detail
 * @return Business|null
 */
function getBusinessDetail(){
    $conn = db();
    $business_id = intval(get('business_id', $conn));

    if($business_id == 0){
        return null;
    }

    $sql = "SELECT businesses.*,
        `categories`.`name` as `category_name`,
        `users`.`name` as `user_name`,
        `users`.`phone` as `user_phone`,
        `users`.`email` as `user_email`,
        (SELECT count(*) FROM `acknowledgements` WHERE `acknowledgements`.`business_id` = `businesses`.`id`)
            AS `total_acknowledgements`,
        (SELECT count(*) FROM `reviews` WHERE `reviews`.`business_id` = `businesses`.`id`)
            AS `total_reviews`,
        (SELECT avg(`reviews`.`rating`) FROM `reviews` WHERE `reviews`.`business_id` = `businesses`.`id`)
            AS `average_rating`
        FROM businesses
        INNER JOIN `categories` ON `businesses`.`category_id` = `categories`.`id`
        INNER JOIN `users` ON `businesses`.`user_id` = `users`.`id`
        WHERE `businesses`.`id` = $business_id LIMIT 1";

    $result = $conn->query($sql);

    $data = $result->fetch_assoc();

    return $data ? Business::fromArray($data) : null;
}
