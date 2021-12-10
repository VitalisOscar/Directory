<?php

/**
 * Get all categories
 * @return Category[]
 */
function getCategories(){
    $conn = db();

    $sql = "SELECT * FROM `categories`";

    $result = $conn->query($sql);

    $categories = [];

    while($data = $result->fetch_assoc()){
        array_push($categories, Category::fromArray($data));
    }

    return $categories;
}

/**
 * Get all categories in admin panel
 * @return Category[]
 */
function getAdminCategories(){
    $conn = db();

    $sql = "SELECT `categories`.*, (SELECT count(*) FROM `businesses` WHERE `businesses`.`category_id` = `categories`.`id`) AS `total_businesses` FROM `categories`";

    $result = $conn->query($sql);

    $categories = [];

    while($data = $result->fetch_assoc()){
        array_push($categories, Category::fromArray($data));
    }

    return $categories;
}

function addCategory(){
    $conn = db();

    $name = post('name');

    if($name == null){
        return 'Provide a category name';
    }

    $sql = "SELECT * FROM `categories` WHERE lower(`name`)='".strtolower($name)."'";
    $result = $conn->query($sql);
    if($result->num_rows > 0){
        return "The category '".$name."' already exists";
    }

    $sql = "INSERT INTO `categories`(`name`) VALUES ('$name')";

    if($conn->query($sql)){
        unset($_POST['name']);
        return true;
    }

    return 'Oops. Something went wrong';
}

function deleteCategory(){
    $conn = db();

    $id = post('category');

    if($id == null){
        return 'Select a category to delete';
    }

    $sql = "DELETE FROM `categories` WHERE `id` = '$id'";

    if($conn->query($sql)){
        return true;
    }

    return 'Oops. Something went wrong';
}
