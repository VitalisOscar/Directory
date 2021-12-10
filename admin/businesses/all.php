<?php
require __DIR__ . '/../../init.php';

SessionManager::mustBeLoggedIn();

require __DIR__ . '/../../core/logic/admin/businesses.php';
require __DIR__ . '/../../core/logic/business/categories.php';

$businesses = getRegisteredBusinesses();
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
    <title>DirectoryX - Businesses</title>
    
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

    <!-- <section class="slider h-auto d-flex align-items-center">
        <div class="container">
            <div class="row d-flex justify-content-center">
                <div class="col-md-12">
                    <div class="slider-title_box">
                        <div class="row d-flex justify-content-center">
                            <div class="col-md-10 pt-3">
                                <h2 class="text-white">Listed Businesses</h2>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section> -->

    <div class="light-bg">
        <div class="container">
            <ul class="breadcrumb mb-0 px-0 light-bg">
                <li class="breadcrumb-item">
                    <a href="<?= ROUTE_ADMIN_HOME ?>">Admin Home</a>
                </li>

                <li class="breadcrumb-item active">
                    <a>Businesses</a>
                </li>
            </ul>
        </div>
    </div>

    <section class="py-5">
        <div class="container">

            <div class="row">
                <div class="col-md-12">

                    <h4 class="mb-3">Listed Businesses</h4>

                    <div>
                        <form class="mb-3 d-flex align-items-center" action="">
                            <input type="search" name="keyword" value="<?= get('keyword') ?>" class="form-control mr-3" placeholder="Search business here...">
                            
                            <select name="category" class="form-control mr-3">
                                <option value="">Any Category</option>
                                <?php foreach($categories as $category): ?>
                                <option value="<?= $category->getId() ?>" <?php if(get('category') == $category->getId()) echo ' selected'; ?>><?= $category->name ?></option>
                                <?php endforeach ?>
                            </select>

                            <select class="custom-select mb-2 mr-sm-2 mb-sm-0" name="order">
                                <option value="">Latest first</option>
                                <option value="oldest" <?php if(get('order') == 'oldest'){ ?>selected<?php } ?>>Oldest First</option>
                                <option value="ratings" <?php if(get('order') == 'ratings'){ ?>selected<?php } ?>>Top Rated</option>
                            </select>

                            <button class="btn btn-success">Search</button>
                        </form>
                    </div>

                    <div class="table-responsive">
                        <table class="table border table-striped">
                            <tr class="bg-primary text-white">
                                <th>Name</th>
                                <th>Category</th>
                                <th>Contact</th>
                                <th>Website</th>
                                <th>Rating</th>
                                <th>Owner</th>
                                <th>Added</th>
                                <th></th>
                            </tr>

                            <?php if(count($businesses) == 0){ ?>
                                <tr>
                                    <td colspan="8">
                                        No listed businesses
                                    </td>
                                </tr>
                            <?php } ?>

                            <?php foreach ($businesses as $business){ ?>
                                <tr>
                                    <td><?= $business->name ?></td>
                                    <td><?= $business->category->name ?></td>
                                    <td><?= $business->phone ?></td>
                                    <td><?= $business->website ?></td>
                                    <td>
                                        <?php
                                            $avg_rating = $business->data['average_rating'];
                                            $total_reviews = $business->data['total_reviews'];    
                                        ?>

                                        <div class="d-flex align-items-center">
                                            <?php for($i = 0; $i<round($avg_rating); $i++){ ?>
                                                <i style="font-size: .8em; margin-right: 3px" class="fa fa-star text-danger"></i>
                                            <?php } ?>

                                            <?php for($i = 0; $i<(5 - round($avg_rating)); $i++){ ?>
                                                <i style="font-size: .8em; margin-right: 3px" class="fa fa-star-o text-muted"></i>
                                            <?php } ?>

                                            &nbsp;(<?= number_format($avg_rating, 1) ?>)
                                        </div>

                                        <div>
                                            <?= $total_reviews.' review'.($total_reviews != 1 ? 's':'') ?>
                                        </div>
                                    </td>
                                    <td>
                                        <a href="<?= url(ROUTE_ADMIN_USERS, ['keyword' => $business->user->email]) ?>"><?= $business->user->name ?></a>
                                    </td>
                                    <td><?= $business->added_at ?></td>
                                    <td>
                                        <a class="btn btn-primary btn-sm" href="<?= url(ROUTE_BUSINESS_DETAIL, ['business_id' => $business->getId()]) ?>" target="_blank">View On Site <i class="fa fa-external-link"></i> </a>
                                    </td>
                                </tr>
                            <?php } ?>
                        </table>
                    </div>

                </div>

            </div>

        </div>
    </section>

    <script src="assets/js/jquery-3.2.1.min.js"></script>
    <script src="assets/js/popper.min.js"></script>
    <script src="assets/js/bootstrap.min.js"></script>
    
    <script>
        $('.delete-category').submit(function(e) {
            e.preventDefault();

            var form = e.target;

            if(confirm('Are you sure you want to delete this category?')){
                form.submit;
            }
        });
    </script>

</body>
</html>