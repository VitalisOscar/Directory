<?php

require __DIR__ . '/../init.php';
require __DIR__ . '/../core/logic/business/explore_businesses.php';

$businesses = getBusinessResults();

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
    <title>Explore places - Find new places around you</title>
    
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
                            <div class="col-md-10">
                                <form class="form-wrap mt-4" action="" method="get">
                                    <div class="btn-group" role="group" aria-label="Basic example">
                                        <input type="text" name="keyword" value="<?= get('keyword') ?>" placeholder="What are your looking for?" class="btn-group1">
                                        <input type="text" name="location" value="<?= get('location') ?>" placeholder="Westlands" class="btn-group2">
                                        <button type="submit" class="btn-form"><span class="icon-magnifier search-icon"></span>Search<i class="pe-7s-angle-right"></i></button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section>
        <div class="container">
            <div class="row">
                <div class="col-12 responsive-wrap">
                    <div class="row detail-filter-wrap">
                        <div class="col-md-4 featured-responsive">
                            <div class="detail-filter-text">
                                <p><?= count($businesses) ?> total</span></p>
                            </div>
                        </div>
                    </div>

                    <div class="row d-none">
                        <div class="col-md-8">
                            <div class="row detail-checkbox-wrap">
                                <div class="col-sm-12 col-md-6 col-lg-4 col-xl-3">

                                    <label class="custom-control custom-checkbox">
                                        <input type="checkbox" class="custom-control-input">
                                        <span class="custom-control-indicator"></span>
                                        <span class="custom-control-description">With Acknowledgements</span>
                                    </label>
                                </div>
                                <div class="col-sm-12 col-md-6 col-lg-4 col-xl-3">
                                    <label class="custom-control custom-checkbox">
                                        <input type="checkbox" class="custom-control-input">
                                        <span class="custom-control-indicator"></span>
                                        <span class="custom-control-description">Verified Businesses</span>
                                    </label>
                                </div>

                                <div class="col-sm-12 col-md-6 col-lg-4 col-xl-3">

                                    <label class="custom-control custom-checkbox">
                                        <input type="checkbox" class="custom-control-input">
                                        <span class="custom-control-indicator"></span>
                                        <span class="custom-control-description">Open Now</span>
                                    </label>
                                </div>
                                
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="detail-filter">
                                <p>Order by</p>
                                <form class="filter-dropdown" action="" method="get">
                                    <input type="hidden" name="category_id" value="<?= get('category_id') ?? ''   ?>">
                                    <select class="custom-select mb-2 mr-sm-2 mb-sm-0" id="inlineFormCustomSelect">
                                        <option value="">Default</option>
                                        <option value="latest">Recently Listed</option>
                                        <option value="oldest">Oldest Listings</option>
                                    </select>
                                </form>
                            </div>
                        </div>

                    </div>

                    <?php if(count($businesses) == 0){ ?>
                    <div class="row pt-5">
                        <div class="col-md-12 col-lg-10 mx-auto">
                            <div class="text-center">
                            Update your filters to see results
                            </div>
                        </div>
                    </div>
                    <?php }else{ ?>

                    <div class="row light-bg detail-options-wrap px-md-3 py-md-4">

                        <?php foreach($businesses as $business){ ?>
                        <div class="col-sm-6 col-md-12 col-lg-6 col-xl-6 featured-responsive">
                            <div class="shadow rounded-lg featured-place-wrap">
                                <a href="<?= url(ROUTE_BUSINESS_DETAIL, ['business_id' => $business->getId()]) ?>">
                                    
                                    <div class="row no-gutters">
                                        <div class="col-12 col-md-5 bg-light position-relative" style="background-image:url(<?= public_file($business->images[0] ?? '') ?>); background-size:cover">    
                                            <?php if($business->isOpen()){ ?>
                                                <span class="position-absolute top-0 left-0 d-inline-block bg-success text-white px-2 py-1 font-weight-500">Open</span>
                                            <?php } else { ?>
                                                <span class="position-absolute top-0 left-0 d-inline-block bg-success text-white px-2 py-1 font-weight-500">Open</span>
                                            <?php } ?>
                                            <div class="embed-responsive embed-responsive-16by9">
                                                <div class="embed-responsive-item">
                                                <!-- <img src="assets/images/featured1.jpg" class="img-fluid" alt="#"> -->
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-12 col-md-7">
                                            <div class="featured-title-box">
                                                <h6><?= $business->name ?></h6>
                                                <p><?= $business->category->name ?> </p> <span>• </span>
                                                <?php
                                                    $avg_rating = round(floatval($business->data['average_rating'] ?? 0));
                                                ?>
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
                                                    (<?= $total_reviews ?>)
                                                </p>
                                                <ul>
                                                    <li><span class="icon-location-pin"></span>
                                                        <p><?= $business->address ?></p>
                                                    </li>
                                                    <li><span class="icon-screen-smartphone"></span>
                                                        <p><?= $business->phone ?></p>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>

                                    </div>

                                </a>
                            </div>
                        </div>
                        <?php } ?>
                    </div>

                    <?php } ?>

                </div>
                
            </div>
        </div>
    </section>
    
    <section class="main-block">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="add-listing-wrap">
                        <h2>Get on this page</h2>
                        <p>Let your business be seen by lots of potential customers</p>
                    </div>
                </div>
            </div>
            <div class="row justify-content-center">
                <div class="col-md-4">
                    <div class="featured-btn-wrap">
                        <a href="<?= ROUTE_ADD_BUSINESS ?>" class="btn btn-danger"><span class="ti-plus"></span> Create Free Listing</a>
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
