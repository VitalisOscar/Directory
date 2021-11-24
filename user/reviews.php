<?php

require __DIR__ . '/../init.php';
require __DIR__ . '/../core/logic/business/reviews.php';

SessionManager::mustBeLoggedIn();

$user = SessionManager::getUser();

$reviews = getUserReviews($user);

// var_dump($businesses);
// return;
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
    <title>Your review history</title>
    
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
                                <h2 class="text-white">Review history</h2>
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

                <li class="breadcrumb-item">
                    <a href="<?= ROUTE_USER_DASHBOARD ?>">Dashboard</a>
                </li>

                <li class="breadcrumb-item active">
                    <a>Review History</a>
                </li>
            </ul>
        </div>
    </div>

    <section class="py-5 light-bg">
        <div class="container">


            <?php if(count($reviews) > 0){ ?>

            <p class="lead mb-2">
                Here are the reviews you have left about businesses on this platform
            </p>

            <div class="row py-md-4">

                <?php foreach($reviews as $review){ ?>
                <div class="col-md-6">
                    <div class="d-flex align-items-center bg-white border p-3 rounded">
                        <div style="height: 60px !important" class="d-flex mr-4 align-items-center customer-rating<?php if($review->rating < 4){ ?> customer-rating-red<?php } ?>"><?= number_format($review->rating, 1) ?></div>

                        <div class="customer-content-wra">
                            <div class="customer-content">
                                <div class="customer-review">
                                    <h6><?= $review->title ?> - <small><?= $review->added_at ?></small></h6>
                                </div>
                            </div>
                            <p class="mb-2">
                            <?= $review->review ?>
                            </p>

                            <div>
                                Review for <a href="<?= url(ROUTE_BUSINESS_DETAIL, ['business_id' => $review->business->getId()]) ?>" target="_blank"><?= $review->business->name ?></a>
                            </div>
                        </div>
                    </div>
                </div>
                <?php } ?>
            </div>

            <?php }else{ ?>
            <div class="row py-5">
                <div class="col-md-12 col-lg-10 mx-auto">
                    <div class="text-center mb-4">
                    There are no reviews yet
                    </div>
                    <div class="add-listing-wrap">
                        <h2>Why leave reviews?</h2>
                        <p class="text-left">
                            When you review businesses correctly, it helps us improve the legitimacy of listings and show users better recommendations and results
                        </p>
                    </div>
                </div>
            </div>
            <div class="row justify-content-center">
                <div class="col-md-4">
                    <div class="featured-btn-wrap">
                        <a href="<?= ROUTE_FIND_BUSINESSES ?>" class="btn btn-danger"><span class="ti-search"></span> Explore Businesses</a>
                    </div>
                </div>
            </div>

            <?php } ?>

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
