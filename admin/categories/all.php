<?php
require __DIR__ . '/../../init.php';

SessionManager::mustBeLoggedIn();

require __DIR__ . '/../../core/logic/business/categories.php';

$add_response = null;
$delete_response = null;

if(dataPosted()){
    if(strtolower(post('action')) == 'add')
        $add_response = addCategory();
    else if(strtolower(post('action')) == 'delete')
        $delete_response = deleteCategory();
}

$categories = getAdminCategories();

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
    <title>DirectoryX - Categories</title>
    
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
                                <h2 class="text-white">Categories</h2>
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
                    <a>Categories</a>
                </li>
            </ul>
        </div>
    </div>

    <section class="py-5">
        <div class="container">

            <h4 class="mb-3">Businesses Categories</h4>
            
            <div class="row">
            
                <div class="col-md-8">

                    <table class="table border table-striped">
                        <tr class="bg-primary text-white">
                            <th>Category</th>
                            <th>Businesses</th>
                            <th></th>
                        </tr>

                        <?php if(count($categories) == 0){ ?>
                            <tr>
                                <td colspan="3">
                                    No categories in the system
                                </td>
                            </tr>
                        <?php } ?>

                        <?php foreach ($categories as $category){ ?>
                            <tr>
                                <td><?= $category->name ?></td>
                                <td><?= $category->data['total_businesses'] ?? 0 ?></td>
                                <td>
                                    <a class="btn btn-primary btn-sm mr-3" href="<?= url(ROUTE_ADMIN_BUSINESSES, ['category' => $category->getId()]) ?>">View Businesses</a>
                                    
                                    <form action="" method="post" class="d-inline-block" class="delete-category">
                                        <input type="hidden" name="action" value="delete">
                                        <input type="hidden" name="category" value="<?= $category->getId() ?>">
                                        <button class="btn btn-sm btn-danger"> <i class="fa fa-trash"></i> Delete</button>
                                    </form>
                                </td>
                            </tr>
                        <?php } ?>
                    </table>

                </div>

                <div class="col-md-4">

                    <div class="card">
                        <div class="card-body">

                            <h5 class="mb-3">Add New</h5>

                            <?php if(is_string($add_response)){ ?>
                            <div class="mb-2">
                                <strong class="text-danger"><?= $add_response ?></strong>
                            </div>
                            <?php } ?>

                            <form action="" method="post">
                                <input type="hidden" name="action" value="add">

                                <div class="form-group">
                                    <label for="name">Category Name</label>
                                    <input type="text" name="name" value="<?= $_POST['name'] ?? '' ?>" class="form-control" placeholder="e.g Shopping" required>
                                </div>
                            
                                <div>
                                    <button class="btn btn-block btn-success">Save</button>
                                </div>
                            </form>

                        </div>
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