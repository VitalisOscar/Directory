<style>
    .slider.h-auto{
        min-height: auto !important;
    }

    .slider.h-auto .container{
        padding-top: 90px !important;
        padding-bottom: 40px !important;
    }
</style>

<div class="nav-menu" style="position: sticky">
    <div class="bg transition">
        <div class="container-fluid bg-dark">
            <div class="row">
                <div class="col-md-12">
                    <nav class="navbar navbar-expand-lg navbar-light">
                        <a class="navbar-brand" href="<?= ROUTE_HOME ?>">DirectoryX</a>
                        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
                            <span class="icon-menu"></span>
                        </button>

                        <div class="collapse navbar-collapse justify-content-end" id="navbarNavDropdown">
                            <ul class="navbar-nav">
                                <li class="nav-item active">
                                    <a class="nav-link" href="<?= ROUTE_ADMIN_CATEGORIES ?>">Categories</a>
                                </li>
                                <li class="nav-item active">
                                    <a class="nav-link" href="<?= ROUTE_ADMIN_USERS ?>">Users</a>
                                </li>
                                <li class="nav-item active">
                                    <a class="nav-link" href="<?= ROUTE_ADMIN_BUSINESSES ?>">Businesses</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="<?= ROUTE_USER_DASHBOARD ?>">User Area</a>
                                </li>
                                <li>
                                    <a href="<?= ROUTE_HOME ?>" class="btn btn-danger top-btn">Open Site</a>
                                </li>
                            </ul>
                        </div>
                    </nav>
                </div>
            </div>
        </div>
    </div>
</div>