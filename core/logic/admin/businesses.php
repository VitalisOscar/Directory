<?php

/**
 * Get all businesses
 * @return Business[]
 */
function getRegisteredBusinesses(){
    $conn = db();
    $limit = 35;
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
        INNER JOIN `users` ON `businesses`.`user_id` = `users`.`id`";

    $filters = [];

    if(isset($_GET['keyword'])){
        $keyword = '%'.get('keyword').'%';
        array_push($filters, "`businesses`.`name` LIKE '$keyword'");
    }

    if(isset($_GET['category'])){
        $category = intval(get('category'));

        if($category != 0){
            array_push($filters, "`businesses`.`category_id` = $category");
        }
    }

    if(count($filters) > 0){
        $sql .= " WHERE 1";

        foreach($filters as $filter){
            $sql .= " AND (".$filter.")";
        }
    }

    if(isset($_GET['order'])){
        $order = strtolower(get('order'));

        if($order == 'oldest'){
            $sql .= " ORDER BY `businesses`.`added_at` ASC";
        }else if($order == 'ratings'){
            $sql .= " ORDER BY 
            (SELECT avg(`reviews`.`rating`) FROM `reviews` WHERE `reviews`.`business_id` = `businesses`.`id`) DESC,
            (SELECT count(*) FROM `reviews` WHERE `reviews`.`business_id` = `businesses`.`id`) DESC";
        }else{
            $sql .= " ORDER BY `businesses`.`added_at` DESC";
        }
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
