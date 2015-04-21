<?php require_once 'classes/database/User.class.php' ?>

<?php require_once 'template/head.php' ?>

<h1 class="text-center">Users</h1>
<div class="row">
    <div class="col-lg-4 col-lg-offset-4">
        <div class="box">
            <ul class="nav nav-tabs" data-tabs="tabs">
                <li class="active"><a href="#register" data-toggle="tab">Register</a></li>
                <li><a href="#signin" data-toggle="tab">Sign In</a></li>
            </ul>
            <div id="my-tab-content" class="tab-content">
                <div class="tab-pane active" id="register">
                    <form action="register.php" method="POST">
                        <input class="form-control" type="text" placeholder="username">
                        <input class="form-control" type="text" placeholder="name">
                        <input class="form-control" type="email" placeholder="email">
                        <input class="form-control" type="password" placeholder="password">
                        <button class="btn btn-primary" type="submit">Register</button>
                    </form>
                </div>
                <div class="tab-pane" id="signin">
                    <form action="signin.php" method="POST">
                        <input class="form-control" type="text" placeholder="username">
                        <input class="form-control" type="password" placeholder="password">
                        <button class="btn btn-primary" type="submit">Sign In</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?php require_once 'template/script.php' ?>
<?php require_once 'template/foot.php' ?>
