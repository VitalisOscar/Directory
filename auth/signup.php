<?php

require __DIR__ . '/../init.php';

$response = null;

if(dataPosted()){
    $response = require __DIR__ . '/../core/logic/auth/signup.php';

    if(is_bool($response) && $response){
        redirect(ROUTE_USER_DASHBOARD);
    }

    echo "<script>alert('".$response."');</script>";
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <base href="<?= BASE_URL ?>">
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="keywords" content="">
    <title>Log into your account</title>
    
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <link href="https://fonts.googleapis.com/css?family=Roboto:300,400,400i,500,700,900" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/simple-line-icons.css">
    <link rel="stylesheet" href="assets/css/themify-icons.css">
    <link rel="stylesheet" href="assets/css/font-awesome.min.css">
    <!-- Hover Effects -->
    <link rel="stylesheet" href="assets/css/set1.css">
    <!-- Main CSS -->
    <link rel="stylesheet" href="assets/css/style.css">
</head>

<body>
    <?php include __DIR__ . '/../header.php'; ?>
    
    <section class="slider h-auto d-flex align-items-center">
        <!-- <img src="images/slider.jpg" class="img-fluid" alt="#"> -->
        <div class="container">
            <div class="row d-flex justify-content-center">
                <div class="col-md-12">
                    <div class="slider-title_box">
                        <div class="row d-flex justify-content-center">
                            <div class="col-md-10 pt-3">
                                <h2 class="text-white">User Registration</h2>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="py-5 bg-light">
        <div class="container">

            <div class="border bg-white rounded py-4 px-4 mx-auto" style="max-width: 400px">
                <form action="" method="post">

                    <?php if(is_string($response)){ ?>
                    <div class="mb-2">
                        <strong class="text-danger"><?= $response ?></strong>
                    </div>
                    <?php } ?>

                    <div class="form-group">
                        <label for="name">Name:</label>
                        <input type="text" name="name" id="name" class="form-control" value="<?= $_POST["name"] ?? '' ?>" required>
                    </div>

                    <div class="form-group">
                        <label for="phone">Phone Number:</label>
                        <input type="tel" name="phone" id="phone" class="form-control" value="<?= $_POST["phone"] ?? '' ?>" required>
                    </div>

                    <div class="form-group">
                        <label for="email">Email:</label>
                        <input type="email" name="email" id="email" class="form-control" value="<?= $_POST["email"] ?? '' ?>" required>
                    </div>

                    <div class="form-group mb-4">
                        <label for="user_key">Password:</label>
                        <input type="password" name="password" class="form-control" id="password" value="<?= $_POST["password"] ?? '' ?>" required>
                    </div>

                    <div class="mb-4">
                        <button class="btn btn-danger btn-block">Sign Up</button>
                    </div>

                    <div class="text-center">
                        <div class="mb-2">
                            Already registered? <a href="<?= ROUTE_SIGNIN ?>">Sign In</a>
                        </div>
                    </div>
                </form>
            </div>

        </div>
    </section>

<?php include __DIR__ . '/../footer.php'; ?>

    <script src="assets/js/jquery-3.2.1.min.js"></script>
    <script src="assets/js/popper.min.js"></script>
    <script src="assets/js/bootstrap.min.js"></script>

    <script>
        $(window).scroll(function() {
            // 100 = The point you would like to fade the nav in.

            if ($(window).scrollTop() > 100) {

                $('.fixed').addClass('is-sticky');

            } else {

                $('.fixed').removeClass('is-sticky');

            };
        });
    </script>
</body>

</html>