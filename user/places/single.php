<?php

require __DIR__ . '/../../init.php';
require __DIR__ . '/../../core/logic/business/get_user_businesses.php';
require __DIR__ . '/../../core/logic/business/reviews.php';
require __DIR__ . '/../../core/logic/business/categories.php';

SessionManager::mustBeLoggedIn();

$user = SessionManager::getUser();

$business = getSingleUserOwnedBusiness($user);

if($business == null){
    redirect(ROUTE_USER_BUSINESSES);
}


$section = get('section');

if($section != 'details' && $section != 'reviews'){
    $section = 'details';
}

$reviews = [];

if($section == 'reviews'){
    $reviews = getBusinessReviews($business->getId());
}


$response = null;

if(dataPosted()){
    $response = require __DIR__ . '/../../core/logic/business/edit_business.php';

    if(is_bool($response) && $response){
        
    }else{
        echo "<script>alert('".$response."');</script>";
    }
}

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
    <title>Business Info - <?= $business->name ?></title>
    
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
    <?php include __DIR__ . '/../../header.php'; ?>
    
    <section class="slider h-auto d-flex align-items-center">
        <!-- <img src="images/slider.jpg" class="img-fluid" alt="#"> -->
        <div class="container">
            <div class="row d-flex justify-content-center">
                <div class="col-md-12">
                    <div class="slider-title_box">
                        <div class="row d-flex justify-content-center">
                            <div class="col-md-10 pt-3">
                                <h2 class="text-white"><?= $business->name ?></h2>
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

                <li class="breadcrumb-item">
                    <a href="<?= ROUTE_USER_BUSINESSES ?>">My Places</a>
                </li>

                <li class="breadcrumb-item active">
                    <a><?= $business->name ?></a>
                </li>
            </ul>
        </div>
    </div>

    <section class="py-5">
        <div class="container">

            <div class="nav nav-pills">
                <a href="<?= url(ROUTE_SINGLE_USER_BUSINESS, ['business_id' => $business->getId()]) ?>" class="nav-link<?= $section == 'details' ? ' active':'' ?>">Details</a>
                <a href="<?= url(ROUTE_SINGLE_USER_BUSINESS_REVIEWS, ['business_id' => $business->getId()]) ?>" class="nav-link<?= $section == 'reviews' ? ' active':'' ?>">Reviews</a>
            </div>

            <hr class="mb-4">

            <?php if($section == 'reviews'){ ?>
            <div>

                <?php if(count($reviews) == 0){ ?>
                <div class="row py-5">
                    <div class="col-md-12 col-lg-10 mx-auto">
                        <div class="text-center mb-4">
                        There are no reviews yet
                        </div>
                        <div class="add-listing-wrap">
                            <p class="">
                                When users review this business, you will be able to see the reviews here
                            </p>
                        </div>
                    </div>
                </div>
                <div class="row justify-content-center">
                    <div class="col-md-4">
                        <div class="featured-btn-wrap">
                            <a href="<?= ROUTE_USER_BUSINESSES ?>" class="btn btn-danger"><span class="ti-search"></span> View Other Places</a>
                        </div>
                    </div>
                </div>

                <?php }else{ ?>

                    <div class="row">
                    <?php foreach($reviews as $review){ ?>

                    <div class="col-lg-6">
                        <div class="customer-review_wrap">
                            <div class="customer-img">
                                <img style="height:40px" src="assets/images/user.png" class="img-fluid" alt="#">
                                <p><?= $review->user->name ?></p>
                            </div>
                            <div class="customer-content-wrap">
                                <div class="customer-content">
                                    <div class="customer-review">
                                        <h6><?= $review->title ?></h6>

                                        <?php for($i = 0; $i < $review->rating; $i++){ ?>
                                        <span></span>
                                        <?php } ?>

                                        <?php for($i = 0; $i < (5 - $review->rating); $i++){ ?>
                                        <span class="round-icon-blank"></span>
                                        <?php } ?>
                                        <p><?= $review->added_at ?></p>
                                    </div>
                                    <div class="customer-rating<?php if($review->rating < 4){ ?> customer-rating-red<?php } ?>"><?= number_format($review->rating, 1) ?></div>
                                </div>
                                <p class="customer-text">
                                <?= $review->review ?>
                                </p>
                            </div>
                        </div>

                        <hr>
                    </div>

                    <?php } ?>

                    </div>

                <?php } ?>


            </div>
            <?php }else{ ?>

            <form action="" class="col-lg-10 mx-auto" method="post" enctype="multipart/form-data">

                <div class="mb-3">
                    <i>Fields marked with * are required</i>
                </div>

                <?php if(is_string($response)){ ?>
                <div class="mb-3">
                    <strong class="text-danger"><?= $response ?></strong>
                </div>
                <?php } ?>

                <div class="form-row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="name" class="mb-0">Business Name:*</label>
                            <input type="text" class="form-control" name="name" id="name" value="<?= $_POST["name"] ?? $business->name ?>" required>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="category" class="mb-0">Select Category:*</label>
                            <select name="category" class="form-control" id="category" required>
                                <?php foreach($categories as $category){ ?>
                                <option value="<?= $category->getId() ?>" <?php if($category->getId() == post('category') || $category->getId() == $business->category->getId()){ ?> selected<?php } ?>><?= $category->name ?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="phone" class="mb-0">Contact Phone:*</label>
                            <input type="tel" class="form-control" name="phone" id="phone" value="<?= $_POST["phone"] ?? $business->phone ?>" required>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="email" class="mb-0">Contact Email:*</label>
                            <input type="email" class="form-control" name="email" id="email" value="<?= $_POST["email"] ?? $business->email ?>" required>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="address" class="mb-0">Business Address:*</label>
                            <input type="text" class="form-control" name="address" id="address" value="<?= $_POST["address"] ?? $business->address ?>" required>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="website" class="mb-0">Website:</label>
                            <input type="text" class="form-control" name="website" id="website" value="<?= $_POST["website"] ?? $business->data['website'] ?? '' ?>">
                        </div>
                    </div>

                    <div class="col-12">
                        <div class="form-group">
                            <label for="description" class="mb-0">Description:*</label>
                            <textarea name="description" class="form-control" id="description" required><?= $_POST["description"] ?? $business->description ?></textarea>
                        </div>
                    </div>


                    <!-- <div class="col-12">
                        <h4>Business Hours</h4> -->

                        <!-- <?php foreach ($days as $key=>$day){ ?>
                            <div class="d-flex mb-3">
                                <label><?= $day ?></label>
                                <select name="<?= $key ?>[opens]" class="form-control">
                                    <option value="">Opens At</option>
                                    <?php for($i = 0; $i < 24; $i++){ ?>
                                        <option value="<?= $i ?>"<?php if($_POST[$key.'[opens]'] == $i){ ?> selected<?php } ?>>
                                            <?= ($i > 12 ? (($i-12).':00 PM'):($i == 12 ? '12:00 Noon':($i.':00 AM'))) ?>
                                        </option>
                                    <?php } ?>
                                </select>

                                <select name="<?= $key ?>[closes]" class="form-control">
                                    <option value="">Closes At</option>
                                    <?php for($i = 0; $i < 24; $i++){ ?>
                                        <option value="<?= $i ?>"<?php if($_POST[$key.'[closes]'] == $i){ ?> selected<?php } ?>>
                                            <?= ($i > 12 ? (($i-12).':00 PM'):($i == 12 ? '12:00 Noon':($i.':00 AM'))) ?>
                                        </option>
                                    <?php } ?>
                                </select>
                            </div>
                        <?php } ?>
                    </div> -->

                    <div class="col-12">
                        <button class="btn btn-success btn-lg">
                            Update
                        </button>
                    </div>
                </div>

            </form>

            <?php } ?>

        </div>
    </section>

    <?php include __DIR__ . '/../../footer.php'; ?>

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
