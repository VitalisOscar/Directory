<?php

if(isset(
    $_POST['name'], $_POST['description'], $_POST['address'],
    $_POST['email'], $_POST['phone'], $_POST['category']
)){
    try{

        $conn = db();

        $name = post('name', $conn);
        $category = post('category', $conn);
        $description = post('description', $conn);
        $address = post('address', $conn);
        $email = post('email', $conn);
        $phone = post('phone', $conn);
        $website = post('website', $conn);

        if($name == null || $email == null || $phone == null || $category == null || $description == null || $address == null){
            return 'Please fill in all required fields';
        }
        
        // Create record
        $user = SessionManager::getUser();

        $business_id = get('business_id');
            
        $sql = "UPDATE `businesses` SET
            `name` = '$name', `address` = '$address', `category_id` = '$category',
            `description` = '$description', `email` = '$email', `phone` = '$phone',
            `website` = '$website' WHERE `id` = $business_id AND `user_id` = ".$user->getId();
// return $sql;
        $result = $conn->query($sql);

        if(!$result){
            return 'Something went wrong. Please try again';
        }

        return true;
    }catch(Exception $e){
        return $e->getMessage();
    }
}

return 'Please provide all required fields';