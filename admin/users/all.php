<?php
require __DIR__ . '/../../init.php';

SessionManager::mustBeLoggedIn();

require __DIR__ . '/../../core/logic/user/users.php';

// $add_response = null;
// $delete_response = null;

// if(dataPosted()){
//     if(strtolower(post('action')) == 'add')
//         $add_response = addCategory();
//     else if(strtolower(post('action')) == 'delete')
//         $delete_response = deleteCategory();
// }

$users = getRegisteredUsers();

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
    <title>DirectoryX - Registered Users</title>
    
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
                                <h2 class="text-white">Users</h2>
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
                    <a> Users</a>
                </li>
            </ul>
        </div>
    </div>

    <section class="py-5">
        <div class="container">

            <div class="row">
                <div class="col-md-12">

                    <h4 class="mb-3">Registered Users</h4>

                    <div>
                        <form class="mb-3 d-flex align-items-center" action="">
                            <input type="search" name="keyword" value="<?= get('keyword') ?>" class="form-control mr-3" placeholder="Name, email, phone...">
                            
                            <select name="role" class="form-control mr-3">
                                <option value="">All users</option>
                                <option value="admin" <?php if(strtolower(get('role')) == 'admin') echo ' selected'; ?>>Admin Users</option>
                                <option value="user" <?php if(strtolower(get('role')) == 'user') echo ' selected'; ?>>Regular Users</option>
                            </select>

                            <button class="btn btn-success">Search</button>
                        </form>
                    </div>

                    <div class="table-responsive">
                        <table class="table border table-striped">
                            <tr class="bg-primary text-white">
                                <th>Name</th>
                                <th>Email</th>
                                <th>Phone</th>
                                <th>Businesses</th>
                                <th>Reviews Made</th>
                                <th>Role</th>
                                <th>Date Registered</th>
                                <th></th>
                            </tr>

                            <?php if(count($users) == 0){ ?>
                                <tr>
                                    <td colspan="8">
                                        No registered users
                                    </td>
                                </tr>
                            <?php } ?>

                            <?php foreach ($users as $user){ ?>
                                <tr>
                                    <td><?= $user->name ?></td>
                                    <td><?= $user->email ?></td>
                                    <td><?= $user->phone ?></td>
                                    <td><?= $user->data['total_businesses'] ?? 0 ?></td>
                                    <td><?= $user->data['total_reviews'] ?? 0 ?></td>
                                    <td><?= $user->role ?></td>
                                    <td><?= $user->registered_at ?></td>
                                    <td>
                                        <!-- <a class="btn btn-primary btn-sm" href="<?= url(ROUTE_ADMIN_BUSINESSES, ['category' => $user->getId()]) ?>">View Businesses</a>
                                        
                                        <form action="" method="post" class="d-inline-block" class="delete-category">
                                            <input type="hidden" name="action" value="delete">
                                            <input type="hidden" name="category" value="<?= $user->getId() ?>">
                                            <button class="btn btn-sm btn-danger">Delete</button>
                                        </form> -->
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