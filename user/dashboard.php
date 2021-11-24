<?php

require __DIR__ . '/../init.php';

SessionManager::mustBeLoggedIn();

$user = SessionManager::getUser();

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
    <title>User dashboard</title>
    
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
                                <h2 class="text-white">User Dashboard</h2>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <div class="light-bg">
        <div class="container">
            <ul class="breadcrumb mb-0 px-0 light-bg">
                <li class="breadcrumb-item">
                    <a href="<?= ROUTE_HOME ?>">Home</a>
                </li>

                <li class="breadcrumb-item active">
                    <a>Dashboard</a>
                </li>
            </ul>
        </div>
    </div>


    <section class="py-5 bg-light">
        <div class="container">

            <div class="mb-3">
             Hello <?= $user->name.' ('.$user->email.')' ?>
             <br>
             <a href="<?= ROUTE_SIGNOUT ?>">Log Out</a>
            </div>

            <p class="lead">
            We have assembled some links to get you going
            </p>

            <div class="row">
                <div class="col-md-6 col-lg-4 mb-3">
                    <div class="border p-4 rounded bg-white">
                        <h6 class="mb-3 text-danger">Your Places</h6>

                        <p class="mb-3">
                            View and manage all places you have listed on this platform
                        </p>

                        <div>
                            <a href="<?= ROUTE_USER_BUSINESSES ?>">View Places</a>
                        </div>
                    </div>
                </div>

                <div class="col-md-6 col-lg-4 mb-3">
                    <div class="border p-4 rounded bg-white">
                        <h6 class="mb-3 text-danger">List a Place</h6>

                        <p class="mb-3">
                            Add a new business place on the platform to connect with customers
                        </p>

                        <div>
                            <a href="<?= ROUTE_ADD_BUSINESS ?>">List a Place</a>
                        </div>
                    </div>
                </div>

                <div class="col-md-6 col-lg-4 mb-3">
                    <div class="border p-4 rounded bg-white">
                        <h6 class="mb-3 text-danger">Chats</h6>

                        <p class="mb-3">
                            View all your chats with customers and businesses and keep talking 
                        </p>

                        <div>
                            <a href="<?= ROUTE_ADD_BUSINESS ?>">View Chats</a>
                        </div>
                    </div>
                </div>

                <div class="col-md-6 col-lg-4 mb-3">
                    <div class="border p-4 rounded bg-white">
                        <h6 class="mb-3 text-danger">Review History</h6>

                        <p class="mb-3">
                            Check out what you have said about businesses on this platform
                        </p>

                        <div>
                            <a href="<?= ROUTE_USER_REVIEWS ?>">View Reviews</a>
                        </div>
                    </div>
                </div>
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