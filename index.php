<?php

require __DIR__ . '/init.php';
require __DIR__ . '/core/logic/business/explore_businesses.php';
require __DIR__ . '/core/logic/business/categories.php';

$businesses = getRecommendedBusinesses();

$categories = getCategories();

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
    <title>DirectoryX - Find new places around you</title>
    
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
    <?php include __DIR__ . '/header.php'; ?>    

    <!-- SLIDER -->
    <section class="slider d-flex align-items-center">
        <!-- <img src="images/slider.jpg" class="img-fluid" alt="#"> -->
        <div class="container">
            <div class="row d-flex justify-content-center">
                <div class="col-md-12">
                    <div class="slider-title_box">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="slider-content_wrap">
                                    <h1>Discover great places around you</h1>
                                    <h5>Find the best places to eat, drink, and shop from our vast directory</h5>
                                </div>
                            </div>
                        </div>
                        <div class="row d-flex justify-content-center">
                            <div class="col-md-10">
                                <form class="form-wrap mt-4" action="<?= ROUTE_FIND_BUSINESSES ?>">
                                    <div class="btn-group" role="group" aria-label="Basic example">
                                    <input type="text" name="keyword" placeholder="What are your looking for?" class="btn-group1">
                                        <input type="text" name="location" placeholder="Westlands" class="btn-group2">
                                        <button type="submit" class="btn-form"><span class="icon-magnifier search-icon"></span>Discover<i class="pe-7s-angle-right"></i></button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    

    <?php if(count($businesses) > 0){ ?>
    <section class="main-block light-bg">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-5">
                    <div class="styled-heading">
                        <h3>Top Places</h3>
                    </div>
                </div>
            </div>
            <div class="row">
                <?php foreach($businesses as $business){ ?>
                <div class="col-md-4 featured-responsive">
                    <div class="featured-place-wrap">
                        <a href="<?= url(ROUTE_BUSINESS_DETAIL, ['business_id' => $business->getId()]) ?>">
                            <div class="embed-responsive embed-responsive-16by9">
                                <div class="embed-responsive-item" style="background: url(<?= public_file($business->images[0]) ?>); background-size: cover; background-repeat: no-repeat; background-position: center"></div>
                            </div>

                            <?php
                                $avg_rating = round(floatval($business->data['average_rating'] ?? 0));
                            ?>

                            <span class="featured-rating<?= $avg_rating >= 4 ? '-green':($avg_rating >= 3 ? '-orange':'') ?>">
                                <?= number_format($avg_rating, 1) ?>
                            </span>
                            <div class="featured-title-box">
                                <h6><?= $business->name ?></h6>
                                <p><?= $business->category->name ?></p> <span>• </span>
                                <!-- <p>3 Reviews</p> <span> • </span>
                                <p><span>$$$</span>$$</p> -->

                                <p>
                                    <?php for($i = 0; $i < $avg_rating; $i++){ ?>
                                    <i style="font-size: .8em" class="small fa fa-star text-danger"></i>
                                    <?php } ?>

                                    <?php for($i = 0; $i < (5 - $avg_rating); $i++){ ?>
                                    <i style="font-size: .8em" class="small fa fa-star-o"></i>
                                    <?php } ?>

                                    <?php
                                        $total_reviews = $business->data['total_reviews'] ?? 0;
                                    ?>
                                    <?= '('.$total_reviews.')' ?>
                                </p>

                                <ul>
                                    <li><span class="icon-location-pin"></span>
                                        <p><?= $business->address ?></p>
                                    </li>
                                    <li><span class="icon-screen-smartphone"></span>
                                        <p><?= $business->phone ?></p>
                                    </li>
                                    <li><span class="icon-link"></span>
                                        <p><?= $business->website ?></p>
                                    </li>

                                </ul>
                            </div>
                        </a>
                    </div>
                </div>
                <?php } ?>
            </div>
            <div class="row justify-content-center">
                <div class="col-md-4">
                    <div class="featured-btn-wrap">
                        <a href="<?= ROUTE_FIND_BUSINESSES ?>" class="btn btn-danger">VIEW ALL</a>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--END FEATURED PLACES -->
    <?php } ?>

    <!--============================= CATEGORIES =============================-->
    <section class="main-block">
        <div class="container">

            <div class="row justify-content-center">
                <div class="col-md-5">
                    <div class="styled-heading">
                        <h3>Browse Categories</h3>
                    </div>
                </div>
            </div>

            <div class="row">

                <?php foreach ($categories as $category){ ?>
                <div class="col-md-3 category-responsive">
                    <a href="<?= url(ROUTE_FIND_BUSINESSES, ['category_id' => $category->getId()]) ?>" class="category-wrap">
                        <div class="category-block">
                            <h6 class="my-0"><?= $category->name ?></h6>
                        </div>
                    </a>
                </div>
                <?php } ?>

            </div>
            
        </div>
    </section>
    <!--//END CATEGORIES -->

    <!--============================= ADD LISTING =============================-->
    <section class="main-block light-bg">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="add-listing-wrap">
                        <h2>Reach more customers</h2>
                        <p>Add your business for free and reach thousands of customers who use this platform on a daily basis</p>
                    </div>
                </div>
            </div>
            <div class="row justify-content-center">
                <div class="col-md-4">
                    <div class="featured-btn-wrap">
                        <a href="<?= ROUTE_ADD_BUSINESS ?>" class="btn btn-danger"><span class="ti-plus"></span> Add Listing</a>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--//END ADD LISTING -->
    
    <?php include __DIR__ . '/footer.php'; ?>

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
