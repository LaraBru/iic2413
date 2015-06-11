<?php 

session_start();

require_once 'classes/Db.class.php';
require_once 'classes/User.class.php';

require_once 'function/post_var_defined.php';

$res = "";
var_dump($_POST);
if (isset($_POST['type'])) 
{
    if ($_POST['type'] == 'register')
    {
        if (is_user_register_post_var_defined($_POST)) 
        {
            $user_exists = User::userWithUsername($_POST['username']);
            if ($user_exists) 
            {
                $res = "username already exists";
            }
            else
            {
                $_POST['password'] = sha1($_POST['password']);
                $user = new User($_POST);
                $user->save();
                $_SESSION['username'] = $_POST['username'];
            }
        }
        else
        {
            $res = "Variables are missing";
        }
    }
    else if ($_POST['type'] == 'signin')
    {
        if (is_user_signin_post_var_defined($_POST)) {
            $user_exists = User::userWithUsername($_POST['username']);
            $_POST['password'] = sha1($_POST['password']);
            if ($user_exists)
            {
                if ($_POST['password'] == $user_exists->getProperty('password')) 
                {
                    $res = "Welcome " . $_POST['username'] . "!<br>You are now signed in.";
                    $_SESSION['username'] = $_POST['username'];
                    header('Location: index.php');
                }
                else
                {
                    $res = "password wrong";
                }
            }
            else
            {
                $res = "username does not exist";
            }
        }
        else
        {
            $res = "Variables are missing";
        }
    }
}

?>

<?php require_once 'template/head.php' ?>

<h1 class="text-center">Users</h1>
<div class="row">
    <div class="col-lg-4 col-lg-offset-4">
        <div class="box">
            <?php if (isset($_SESSION['username'])) {echo "<!--" ;} ?>
            <ul class="nav nav-tabs" data-tabs="tabs">
                <li class="active"><a href="#register" data-toggle="tab">Register</a></li>
                <li><a href="#signin" data-toggle="tab">Sign In</a></li>
            </ul>
            <div id="my-tab-content" class="tab-content">
                <div class="tab-pane active" id="register">
                    <?php require_once 'template/register_form.php' ?>
                </div>
                <div class="tab-pane" id="signin">
                    <?php require_once 'template/signin_form.php' ?>
                </div>
            </div>

            <h3><?php echo $res ?></h3>

            <?php if (isset($_SESSION['username'])) {echo "-->" ; ?>
            <?php echo "<h3>You are already signed in.</h3>";} ?>
        </div>
    </div>
</div>

<?php require_once 'template/script.php' ?>
<?php require_once 'template/foot.php' ?>
