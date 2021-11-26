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

        // Upload images
        $images = post_files('images');

        $paths = [];

        foreach($images as $img){
            $p = upload_file($img, 'places');
            if($p != null) array_push($paths, $p);
        }
        
        $paths = json_encode($paths);


        // Work hours
        $hours = json_encode(getWorkHours());
        
        // Create record
        $user = SessionManager::getUser();
            
        $sql = "INSERT INTO `businesses`(
            `user_id`, `name`, `address`, `category_id`, `description`,
            `images`, `email`, `phone`, `website`, `hours`) VALUES
            (".$user->getId().", '$name', '$address', $category, '$description',
            '$paths', '$email', '$phone', '$website', '$hours')";

        $result = $conn->query($sql);

        if(!$result){
            return 'Something went wrong. Please try again';
        }

        return true;
    }catch(Exception $e){
        return $e->getMessage();
    }
}

function getWorkHours(){
    $days = [
        'monday',
        'tuesday',
        'wednesday',
        'thursday',
        'friday',
        'saturday',
        'sunday',
    ];

    $work_hours = [];

    foreach($days as $day){
        $opens = post($day.'_open');
        $closes = post($day.'_close');

        if($opens == null || $closes == null){
            $work_hours[$day] = [];
        }else{
            $work_hours[$day] = [
                'opens' => $opens,
                'closes' => $closes,
            ];
        }
    }

    return $work_hours;
}

return 'Please provide all required fields';