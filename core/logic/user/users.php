<?php

function getRegisteredUsers(){
    $conn = db();

    $sql = "SELECT `users`.*,
        (SELECT count(*) FROM `businesses` WHERE `businesses`.`user_id` = `users`.`id`) AS `total_businesses`,
        (SELECT count(*) FROM `reviews` WHERE `reviews`.`user_id` = `users`.`id`) AS `total_reviews`
        FROM `users`";

    $filters = [];

    if(isset($_GET['keyword'])){
        $keyword = '%'.get('keyword').'%';
        array_push($filters, "`users`.`name` LIKE '$keyword' OR `users`.`phone` LIKE '$keyword' OR `users`.`email` LIKE '$keyword'");
    }

    if(isset($_GET['role'])){
        $role = strtolower(get('role'));

        if($role == 'admin' || $role == 'user'){
            array_push($filters, "`users`.`role` = '$role'");
        }
    }

    if(count($filters) > 0){
        $sql .= " WHERE 1";

        foreach($filters as $filter){
            $sql .= " AND (".$filter.")";
        }
    }

    $sql .= " ORDER BY role ASC, registered_at DESC";

    $result = $conn->query($sql);

    $users = [];

    while($data = $result->fetch_assoc()){
        array_push($users, User::fromArray($data));
    }

    return $users;
}
