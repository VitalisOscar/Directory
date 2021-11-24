<?php

require __DIR__ . '/../init.php';

if(dataPosted()){
    $response = require __DIR__ . '/../core/logic/auth/signup.php';

    if(is_bool($response) && $response){
        redirect(ROUTE_USER_DASHBOARD);
    }

    echo "<script>alert('".$response."');</script>";
}

?>

<form action="" method="post">
    Name:
    <input type="text" name="name" value="<?= $_POST["name"] ?? '' ?>" required>
    <br><br>
    Phone:
    <input type="text" name="phone" value="<?= $_POST["phone"] ?? '' ?>" required>
    <br><br>
    Email:
    <input type="text" name="email" value="<?= $_POST["email"] ?? '' ?>" required>
    <br><br>
    Password:
    <input type="password" name="password" value="<?= $_POST["password"] ?? '' ?>" required>
    <br><br>
    <button>Sign Up</button>
</form>