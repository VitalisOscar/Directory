<style>
    .slider.h-auto{
        min-height: auto !important;
    }

    .slider.h-auto .container{
        padding-top: 90px !important;
        padding-bottom: 40px !important;
    }
</style>

<?php
    $categories_file = __DIR__ . '/core/logic/business/categories.php';

    if(!in_array($categories_file, get_included_files())){
        require $categories_file;
    }
?>

<div class="nav-menu">
    <div class="bg transition">
        <div class="container-fluid fixed">
            <div class="row">
                <div class="col-md-12">
                    <nav class="navbar navbar-expand-lg navbar-light">
                        <a class="navbar-brand" href="<?= ROUTE_HOME ?>">DirectoryX</a>
                        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
                            <span class="icon-menu"></span>
                        </button>

                        <div class="collapse navbar-collapse justify-content-end" id="navbarNavDropdown">
                            <ul class="navbar-nav">
                                <li class="nav-item dropdown">
                                    <a class="nav-link" href="#" id="navbarDropdownMenuLink2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    Categories
                                    <span class="icon-arrow-down"></span>
                                    </a>
                                    <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                                        <?php foreach(getCategories() as $category){ ?>
                                        <a class="dropdown-item" href="<?= url(ROUTE_FIND_BUSINESSES, ['category_id' => $category->getId()]) ?>"><?= $category->name ?></a>
                                        <?php } ?>
                                    </div>
                                </li>
                                <li class="nav-item active">
                                    <a class="nav-link" href="<?= ROUTE_FIND_BUSINESSES ?>">Explore</a>
                                </li>
                                <li class="nav-item">
                                    <?php if(SessionManager::loggedIn()){ ?>
                                        <a class="nav-link" href="<?= ROUTE_USER_DASHBOARD ?>">User Area</a>
                                    <?php }else{ ?>
                                        <a class="nav-link" href="<?= ROUTE_USER_DASHBOARD ?>">Log In/Register</a>
                                    <?php } ?>
                                </li>
                                <li>
                                    <a href="<?= ROUTE_ADD_BUSINESS ?>" class="btn btn-danger top-btn"><span class="ti-plus"></span> List your Business</a>
                                </li>
                            </ul>
                        </div>
                    </nav>
                </div>
            </div>
        </div>
    </div>
</div>