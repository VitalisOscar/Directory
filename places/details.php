<?php

require __DIR__ . '/../init.php';
require __DIR__ . '/../core/logic/business/explore_businesses.php';
require __DIR__ . '/../core/logic/business/reviews.php';

$user = SessionManager::getUser();

$business = getBusinessDetail();

// Add review
if(dataPosted()){
    if(strtolower(post('action')) == 'acknowledgement'){
        if($user){
            $response = acknowledgeBusiness($business, $user);

            if(!(is_bool($response) && $response)){
                echo "<script>alert('$response');</script>";
            }else{
                echo "<script>alert('Thanks for your acknowledgement');
                window.location.href = window.location.href;</script>";
            }
        }
    }else{
        $response = addReview($business, $user, post('title'), post('review'), post('rating'));

        if(!(is_bool($response) && $response)){
            echo "<script>alert('$response');</script>";
        }else{
            redirect(url(ROUTE_BUSINESS_DETAIL, [
                'business_id' => $business->getId()
            ]));
        }
    }
}

$business = getBusinessDetail();

if($business == null){
    redirect(ROUTE_FIND_BUSINESSES);
}

$reviews = getBusinessReviews($business->getId());

$user_review = null;

if($user != null){
    $user_review = businessReviewedBy($business, $user);
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
    <title>Explore business - <?= $business->name ?></title>
    
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <link href="https://fonts.googleapis.com/css?family=Roboto:300,400,400i,500,700,900" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/simple-line-icons.css">
    <link rel="stylesheet" href="assets/css/themify-icons.css">
    <link rel="stylesheet" href="assets/css/font-awesome.min.css">
    <!-- Hover Effects -->
    <link rel="stylesheet" href="assets/css/set1.css">
    <!-- Main CSS -->
    <link rel="stylesheet" href="assets/css/style.css">
    <!-- Swipper Slider -->
    <link rel="stylesheet" href="assets/css/swiper.min.css">
    <!-- Magnific Popup CSS -->
    <link rel="stylesheet" href="assets/css/magnific-popup.css">
</head>

<body>
    <?php include __DIR__ . '/../header.php'; ?>
    
    <section class="slider h-auto align-items-center">
        <!-- <img src="images/slider.jpg" class="img-fluid" alt="#"> -->
        <div class="container">
            <div class="row d-flex justify-content-center">
                <div class="col-md-12">
                    <div class="slider-title_box">
                        <div class="row d-flex justify-content-center">
                            <div class="col-md-10 pt-3">
                                <h2 class="text-white">Business Details</h2>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>



    <div>
        <!-- Swiper -->
        <div style="z-index: 0" class="swiper-container">
            <div class="swiper-wrapper">

                <?php foreach($business->images as $image){ ?>
                <div class="swiper-slide">
                    <a href="<?= public_file($image) ?>" class="grid image-link">
                        <div class="embed-responsive embed-responsive-16by9">
                            <div class="embed-responsive-item" style="background: url(<?= public_file($image) ?>); background-size: cover; background-repeat: no-repeat; background-position: center"></div>
                        </div>
                    </a>
                </div>
                <?php } ?>

            </div>
            <!-- Add Pagination -->
            <div class="swiper-pagination swiper-pagination-white"></div>
            <!-- Add Arrows -->
            <div class="swiper-button-next swiper-button-white"></div>
            <div class="swiper-button-prev swiper-button-white"></div>
        </div>
    </div>
    
    <section class="reserve-block">
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <h5><?= $business->name ?></h5>
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
                    </p>
                    <div class="mb-1"></div>
                    <?php $acknowledgements = $business->data['total_acknowledgements']; ?>
                    <div class="d-flex align-items-center">
                        <span><?= $business->category->name ?></span>
                        <i class="fa fa-circle text-dark mx-2" style="font-size: .6em"></i>
                        <span>
                        <?= $acknowledgements == 0 ? 'No Acknowledgements':
                            ($acknowledgements.' user'.($acknowledgements == 1 ? ' knows':'s know').' this place')
                        ?>
                        </span>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="reserve-seat-block">
                        <div class="reserve-rating <?php if(($business->data['average_rating'] ?? 0) < 4){ ?> customer-rating-red<?php } ?>">
                            <span><?= number_format($business->data['average_rating'] ?? 0, 1) ?></span>
                        </div>
                        <div class="review-btn">
                            <a href="#review" data-toggle="modal" class="btn btn-outline-danger">Leave Your Review</a>
                            <?php $tr = $business->data['total_reviews'] ?? 0; ?>
                            <span><?= $tr.' review'.($tr == 1 ? '':'s') ?></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--//END RESERVE A SEAT -->
    <!--============================= BOOKING DETAILS =============================-->
    <section class="light-bg booking-details_wrap">
        <div class="container">
            <div class="row">
                <div class="col-md-8 responsive-wrap">
                    <div class="booking-checkbox_wrap">
                        <div class="booking-checkbox">
                            <h5 class="mb-3 text-left">About This Place</h5>
                            <p><?= $business->description ?></p>
                        </div>
                    </div>

                    <div class="booking-checkbox_wrap mt-4">
                        
                        <?php if(count($reviews) == 0){ ?>

                        <div class="add-listing-wrap mb-0">
                            <h5>Leave a Review</h5>
                            <p>Be the first to review <?= $business->name ?></p>

                            <div class="featured-btn-wrap">
                                <a href="#review" data-toggle="modal" class="btn btn-outline-danger"><span class="ti-plus"></span> Add Review</a>
                            </div>
                        </div>

                        <?php }else{ ?>
                        <div class="d-flex align-items-center">
                            <h5 class="text-left"><?= $tr.' review'.($tr == 1 ? '':'s') ?></h5>
                            <a href="#review" data-toggle="modal" class="ml-auto btn btn-outline-danger"><span class="ti-plus"></span> Add Review</a>
                        </div>
                        <?php } ?>

                        <?php foreach($reviews as $review){ ?>

                        <hr>

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

                        <?php } ?>
                        
                    </div>
                </div>
                <div class="col-md-4 responsive-wrap">
                    <div class="contact-info">
                        <div class="address">
                            <span class="icon-location-pin"></span>
                            <p><?= $business->address ?></p>
                        </div>
                        <div class="address">
                            <span class="icon-screen-smartphone"></span>
                            <p><?= $business->phone ?></p>
                        </div>
                        <div class="address">
                            <span class="icon-link"></span>
                            <p><?= $business->website ?></p>
                        </div>
                        <div class="address">
                            <span class="icon-clock"></span>
                            <p>Mon - Sun 09:30 am - 05:30 pm <br>
                            <span class="open-now">OPEN NOW</span></p>
                        </div>

                    </div>

                    <?php
                    if($user != null){
                    if($user->getId() != $business->user->getId()){
                    if(!businessAcknowledgedBy($business, $user)){
                    ?>
                    <div class="bg-white p-3">
                        <h6>Do you know this business or you have been there?</h6>

                        <form action="" method="post">
                            <input type="hidden" name="action" value="acknowledgement">
                            <button class="btn btn-primary btn-block">Yes, I know it</button>
                        </form>
                    </div>
                    <?php }}} ?>
                </div>
            </div>
        </div>
    </section>


    <a href="#" class="btn btn-lg btn-success chat-btn"> <i class="fa fa-comment"></i> Chat with Business</a>

    <style>
        .chat-btn{
            position: fixed;
            bottom: 0;
            right: 0;
            margin: 1rem;
            z-index: 50;
            box-shadow: 0 1rem 2rem 2rem rgba(0,0,0,.3)
        }
    </style>

    <div class="modal" id="review" data-backdrop="static">
        <div class="modal-dialog modal-sm" style="max-width: 400px">
            <div class="modal-content">

                <?php if($user == null){ ?>
                <div class="modal-body">

                    <p class="lead mt-0">
                        You need to be signed in to add a review about <?= $business->name ?>
                    </p>

                    <div>
                        <a href="<?= ROUTE_SIGNIN ?>" class="btn btn-block btn-primary">Sign In</a>
                        <button type="button" data-dismiss="modal" class="btn btn-white btn-block">Cancel</button>
                    </div>
                </div>
                <?php }else if($user->getId() == $business->user->getId()){ ?>
                <div class="modal-body">

                    <p class="lead mt-0">
                        You cannot review your own business
                    </p>

                    <div>
                        <button type="button" data-dismiss="modal" class="btn btn-white btn-block">Ok</button>
                    </div>
                </div>
                <?php }else if($user_review != null){ ?>
                <div class="modal-body">

                    <p class="lead mt-0">
                        You have already left a review about <?= $business->name ?> with a rating of <?= $user_review->rating.' star'.($user_review->rating == 1 ? '':'s') ?>
                    </p>

                    <div>
                        <button type="button" data-dismiss="modal" class="btn btn-white btn-block">Ok</button>
                    </div>
                </div>
                <?php }else{ ?>
                <div class="modal-body">

                    <p class="lead mt-0">
                        Your review will help others know what to expect from <?= $business->name ?>
                    </p>

                    <form action="" method="post">
                        <div class="form-group">
                            <label for="r_title">Title</label>
                            <input type="text" placeholder="e.g Yummy Food" id="r_title" name="title" class="form-control">
                        </div>

                        <div class="form-group">
                            <label for="r_review">Review</label>
                            <textarea placeholder="e.g I loved how the food was packed..." id="r_review" name="review" class="form-control"></textarea>
                        </div>

                        <div class="form-group">
                            <label for="r_rating">Your Rating</label>
                            <select class="form-control" name="rating" id="r_rating" required>
                                <option value="1">1 Star</option>
                                <option value="2">2 Stars</option>
                                <option value="3">3 Stars</option>
                                <option value="4">4 Stars</option>
                                <option value="5">5 Stars</option>
                            </select>
                        </div>

                        <div>
                            <button class="btn btn-primary mb-3 btn-block">Submit Review</button>
                            <button type="button" data-dismiss="modal" class="btn btn-white btn-block">Cancel</button>
                        </div>
                    </form>
                </div>
                <?php } ?>

            </div>
        </div>
    </div>



    <?php include __DIR__ . '/../footer.php'; ?>

    <script src="assets/js/jquery-3.2.1.min.js"></script>
    <script src="assets/js/popper.min.js"></script>
    <script src="assets/js/bootstrap.min.js"></script>

    <script src="assets/js/jquery.magnific-popup.js"></script>
    <!-- Swipper Slider JS -->
    <script src="assets/js/swiper.min.js"></script>

    <script>
        var swiper = new Swiper('.swiper-container', {
            slidesPerView: 3,
            slidesPerGroup: 3,
            loop: true,
            loopFillGroupWithBlank: true,
            pagination: {
                el: '.swiper-pagination',
                clickable: true,
            },
            navigation: {
                nextEl: '.swiper-button-next',
                prevEl: '.swiper-button-prev',
            },
        });
    </script>
    <script>
        if ($('.image-link').length) {
            $('.image-link').magnificPopup({
                type: 'image',
                gallery: {
                    enabled: true
                }
            });
        }
        if ($('.image-link2').length) {
            $('.image-link2').magnificPopup({
                type: 'image',
                gallery: {
                    enabled: true
                }
            });
        }
    </script>

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

