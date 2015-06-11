<?php 

session_start();

require_once 'classes/Db.class.php';
require_once 'classes/User.class.php';
require_once 'function/network.php';
require_once 'function/post_var_defined.php';

$res = "";

if (isset($_POST['type'])) 
{
    if ($_POST['type'] == 'network')
    {
        if (is_user_signin_var_defined($_POST)) 
        {
            $user_exists = verif_network_user($_POST['username'], $_POST['password']);
            if ($user_exists) 
            {
                $pass = sha1($_POST['password']);
                $usern = 'NETWORKUSER_' . $_POST['username'];
                $name = $user_exists['nombre'];
                $email = $user_exists['email'];
                $affiliation = 'None';
                $id_country = 0;
                $user_array = array(
                    'username' => $usern,
                    'name' => $name,
                    'password' => $pass,
                    'email' => $email,
                    'afiliation' => $affiliation,
                    'id_country' => $id_country
                );
                $user_saden = new User($user_array);
                $user_saden->save();
                var_dump($user_saden);
                var_dump($user_array);
                $_SESSION['saden_username'] = $usern;
                $_SESSION['network_username'] = $_POST['username'];
            }
            else
            {
                $res = "wrong password or username";
            }
        }
        else
        {
            $res = "Variables are missing";
        }
    }
    else if ($_POST['type'] == 'saden')
    {
        if (is_user_signin_var_defined($_POST)) 
        {
            $user_exists = User::userWithUsername($_POST['username']);
            $_POST['password'] = sha1($_POST['password']);
            if ($user_exists)
            {
                if ($_POST['password'] == $user_exists->getProperty('password')) 
                {
                    $res = "Welcome " . $_POST['username'] . "!<br>You are now signed in.";
                    $_SESSION['saden_username'] = $_POST['username'];
                    header('Location: index.php');
                }
                else
                {
                    $res = "wrong password";
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
            
            <?php 
                if (isset($_SESSION['saden_username']) || isset($_SESSION['network_username'])) 
                {
                    echo "<!--" ;
                } 
            ?>
            
            <ul class="nav nav-tabs" data-tabs="tabs">
                <li class="active"><a href="#saden" data-toggle="tab">Saden</a></li>
                <li><a href="#network" data-toggle="tab">Queltehue</a></li>
            </ul>
            <div id="my-tab-content" class="tab-content">
                <div class="tab-pane active" id="saden">
                    <?php require 'template/signin_form_saden.php' ?>
                </div>
                <div class="tab-pane" id="network">
                    <?php require 'template/signin_form_network.php' ?>
                </div>
            </div>

            <h3><?php echo $res ?></h3>

            <?php 
                if (isset($_SESSION['saden_username']) || isset($_SESSION['network_username'])) 
                {
                    echo "-->" ;
                    echo "<h3>You are signed in.</h3>";
                } 
            ?>
        </div>
    </div>
</div>

<?php require_once 'template/script.php' ?>
<?php require_once 'template/foot.php' ?>
