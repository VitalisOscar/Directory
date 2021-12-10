<?php

if(isset($_POST['user_key'], $_POST['password'])){
    $user_key = post('user_key');
    $password = post('password');
    $role = strtolower(post('role') ?? 'user');

    $sql = "SELECT * FROM `users` WHERE `email` = '$user_key' OR `phone` = '$user_key' LIMIT 1";

    $conn = db();

    $result = $conn->query($sql);

    if(!$result){
        return 'Something went wrong. Please try again';
    }

    $user_data = $result->fetch_assoc();

    if($user_data == null){
        return 'Theres no user associated with the provided credential';
    }

    // Check password
    if(!password_verify($password, $user_data['password'])){
        return 'Incorrect password';
    }

    // Authenticated
    $user = User::fromArray($user_data);

    if($role == 'admin'){
        if(!$user->isAdmin()){
            return 'The account you logged in with does not have admin privileges';
        }
    }

    SessionManager::start($user);

    return true;
}

return 'Email or phone and password is required to sign in';