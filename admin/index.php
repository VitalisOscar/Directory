<?php
require __DIR__ . '/../init.php';

SessionManager::mustBeLoggedIn();

$user = SessionManager::getUser();

$sqls = [
    'total_users' => "SELECT count(*) AS `total_users` FROM `users`",
    'total_categories' => "SELECT count(*) AS `total_categories` FROM `categories`",
    'total_reviews' => "SELECT count(*) AS `total_reviews` FROM `reviews`",
    'total_businesses' => "SELECT count(*) AS `total_businesses` FROM `businesses`"
];

$stats = [];

$conn = db();

foreach($sqls as $key => $sql){
    $result = $conn->query($sql);
    $row = $result->fetch_assoc();

    $stats[$key] = $row[$key] ?? 0;
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
    <title>DirectoryX - Admin Panel</title>
    
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

    <!-- <section class="slider h-auto d-flex align-items-center">
        <div class="container">
            <div class="row d-flex justify-content-center">
                <div class="col-md-12">
                    <div class="slider-title_box">
                        <div class="row d-flex justify-content-center">
                            <div class="col-md-10 pt-3">
                                <h2 class="text-white">Admin Home</h2>
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
                <li class="breadcrumb-item active">
                    <a>Admin Home</a>
                </li>
            </ul>
        </div>
    </div>

    <section class="py-5">
        <div class="container">

            <div class="mb-3">
                Hello <?= $user->name.' ('.$user->email.')' ?>. This section is meant for site administration
                - <a href="<?= ROUTE_SIGNOUT ?>" class="ml-1">Log Out</a>
            </div>

            <div class="row mb-5">

                <div class="col-12 col-sm-6 col-lg-3">
                    <div class="card">
                        <div>
                            <div class="p-3 d-flex align-items-center bg-primary rounded-top">
                                <h6 class="mb-0 text-white">Categories</h6>
                                <span class="rounded-circle text-white ml-auto d-inline-flex align-items-center justify-content-center" style="height: 35px; width: 35px">
                                    <i class="fa fa-building" style="font-size: 1.5em"></i>
                                </span>
                            </div>

                            <div class="px-3 py-3 d-flex align-items-center">
                                <span style="font-size: 2em">
                                    <?= $stats['total_categories'] ?? 0 ?>
                                </span>

                                <a href="<?= ROUTE_ADMIN_CATEGORIES ?>" class="ml-auto">View All <i class="fa fa-arrow-right"></i></a>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-12 col-sm-6 col-lg-3">
                    <div class="card">
                        <div>
                            <div class="p-3 d-flex align-items-center bg-success rounded-top">
                                <h6 class="mb-0 text-white">Users</h6>
                                <span class="rounded-circle text-white bg-success ml-auto d-inline-flex align-items-center justify-content-center" style="height: 35px; width: 35px">
                                    <i class="fa fa-user" style="font-size: 1.5em"></i>
                                </span>
                            </div>

                            <div class="px-3 py-3 d-flex align-items-center">
                                <span style="font-size: 2em">
                                <?= $stats['total_users'] ?? 0 ?>
                                </span>

                                <a href="<?= ROUTE_ADMIN_USERS ?>" class="ml-auto">View All <i class="fa fa-arrow-right"></i></a>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-12 col-sm-6 col-lg-3">
                    <div class="card">
                        <div>
                            <div class="p-3 d-flex align-items-center bg-danger rounded-top">
                                <h6 class="mb-0 text-white">Businesses</h6>
                                <span class="rounded-circle text-white ml-auto d-inline-flex align-items-center justify-content-center" style="height: 35px; width: 35px">
                                    <i class="fa fa-building" style="font-size: 1.5em"></i>
                                </span>
                            </div>

                            <div class="px-3 py-3 d-flex align-items-center">
                                <span style="font-size: 2em">
                                <?= $stats['total_businesses'] ?? 0 ?>
                                </span>

                                <a href="<?= ROUTE_ADMIN_BUSINESSES ?>" class="ml-auto">View All <i class="fa fa-arrow-right"></i></a>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-12 col-sm-6 col-lg-3">
                    <div class="card">
                        <div>
                            <div class="p-3 d-flex align-items-center bg-warning rounded-top">
                                <h6 class="mb-0 text-white">Reviews Made</h6>
                                <span class="rounded-circle text-white ml-auto d-inline-flex align-items-center justify-content-center" style="height: 35px; width: 35px">
                                    <i class="fa fa-edit" style="font-size: 1.5em"></i>
                                </span>
                            </div>

                            <div class="px-3 py-3 d-flex align-items-center">
                                <span style="font-size: 2em">
                                <?= $stats['total_reviews'] ?? 0 ?>
                                </span>

                                <a href="<?= url(ROUTE_ADMIN_BUSINESSES, ['order' => 'ratings']) ?>" class="ml-auto">View Businesses <i class="fa fa-arrow-right"></i></a>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

            <div class="row">
                
                <div class="col-md-5 col-lg-4">
                    <ul class="list-group">
                        <li class="list-group-item bg-primary text-white">
                            <h6 class="mb-0">Useful Shortcuts</h6>
                        </li>
                        <li class="list-group-item">
                            <a href="<?= url(ROUTE_HOME) ?>">Visit Main Site</a>
                        </li>

                        <li class="list-group-item">
                            <a href="<?= url(ROUTE_ADMIN_USERS, ['role' => 'admin']) ?>">View Admin Users</a>
                        </li>
                        
                        <li class="list-group-item">
                            <a href="<?= url(ROUTE_ADMIN_CATEGORIES) ?>">View Categories/Add New</a>
                        </li>

                        <li class="list-group-item">
                            <a href="<?= url(ROUTE_ADMIN_BUSINESSES, ['order' => 'latest']) ?>">Recent Business Listings</a>
                        </li>

                        <li class="list-group-item">
                            <a href="<?= url(ROUTE_USER_DASHBOARD) ?>">Open Personal Dashboard</a>
                        </li>
                    </ul>
                </div>

            </div>

        </div>
    </section>

</body>
</html>