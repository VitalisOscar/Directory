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
