<?php

require __DIR__ . '/../init.php';
require __DIR__ . '/../core/logic/business/explore_businesses.php';

SessionManager::mustBeLoggedIn();

$user = SessionManager::getUser();

// Business in scope
$scopeBusiness = getBusinessDetail();

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
    <title>Chats</title>
    
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
        <div class="container">
            <div class="row d-flex justify-content-center">
                <div class="col-md-12">
                    <div class="slider-title_box">
                        <div class="row d-flex justify-content-center">
                            <div class="col-md-10 pt-3">
                                <h2 class="text-white">Chats with businesses</h2>
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

                <li class="breadcrumb-item active">
                    <a>Your Chats</a>
                </li>
            </ul>
        </div>
    </div>

    <section class="py-4">
        <div class="container">

        <div id="talkjs-container" style="width: 90%; margin: 30px; height: 500px">
            <i>Loading chats...</i>
        </div>

        </div>
    </section>

    <?php include __DIR__ . '/../footer.php'; ?>

    <script src="assets/js/jquery-3.2.1.min.js"></script>
    <script src="assets/js/popper.min.js"></script>
    <script src="assets/js/bootstrap.min.js"></script>

    <script>
    (function(t,a,l,k,j,s){
    s=a.createElement('script');s.async=1;s.src="https://cdn.talkjs.com/talk.js";a.head.appendChild(s)
    ;k=t.Promise;t.Talk={v:3,ready:{then:function(f){if(k)return new k(function(r,e){l.push([f,r,e])});l
    .push([f])},catch:function(){return k&&new k()},c:l}};})(window,document,[]);
    </script>

    <script>
        Talk.ready.then(function () {
            var me = new Talk.User({
                id: 'u_<?= $user->getId() ?>',
                name: '<?= $user->name ?>',
                email: '<?= $user->email ?>',
                photoUrl: '<?= BASE_URL ?>assets/images/user.png',
            });

            window.talkSession = new Talk.Session({
                appId: '<?= TALKJS_APP_ID ?>',
                me: me,
            });

            var inbox = window.talkSession.createInbox();
            inbox.mount(document.getElementById('talkjs-container'));
        });

    </script>

    <script>
        $('.fixed').addClass('is-sticky');
    </script>
</body>

</html>
