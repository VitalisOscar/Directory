<?php

if(isset($_POST['name'], $_POST['email'], $_POST['phone'], $_POST['password'])){
    $conn = db();

    $name = post('name', $conn);
    $email = post('email', $conn);
    $phone = post('phone', $conn);
    $password = post('password', $conn);

    if($name == null || $email == null || $phone == null || $password == null){
        return 'Name, email, phone and password fields are all required';
    }

    // Check if email is in use
    $email_sql = "SELECT * FROM `users` WHERE `email` = '$email' LIMIT 1";
    $result = $conn->query($email_sql);

    if(mysqli_num_rows($result) > 0){
        return 'The email is already associated to another account';
    }

    // Check if phone is in use
    $phone_sql = "SELECT * FROM `users` WHERE `phone` = '$phone' LIMIT 1";
    $result = $conn->query($phone_sql);

    if(mysqli_num_rows($result) > 0){
        return 'The phone number is already associated to another account';
    }

    // Create record
    $password = password_hash($password, PASSWORD_DEFAULT);

    $sql = "INSERT INTO `users`(`name`, `email`, `phone`, `password`) VALUES
        ('$name', '$email', '$phone', '$password')";

    $result = $conn->query($sql);

    if(!$result){
        return 'Something went wrong. Please try again';
    }

    // Session
    $user = User::fromArray($data);
    
    SessionManager::start($user);

    return true;
}

return 'Name, email, phone and password fields are all required';