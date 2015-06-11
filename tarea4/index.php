<?php 
// 
//    scp -r ./ grupo16@bases.ing.puc.cl:/var/www/html/grupo16/entrega4
// 
session_start();

require_once 'template/head.php' 

?>

<h1 class="text-center">
    Welcome 
    <?php 
        if (isset($_SESSION['network_username']))
        {
            echo '<strong>' . $_SESSION['network_username'] . '/' . $_SESSION['saden_username'] . '</strong> for network';
        } 
        else if (isset($_SESSION['saden_username']))
        {
            echo '<strong>' . $_SESSION['saden_username'] . '</strong>';
        }
    ?> 
    on out web interface
</h1>
<div class="row">
    <div class="col-lg-8 col-lg-offset-2">
        <div class="box">
            <h3>Simple Actions</h3>
            <ul class="list-group">
                <li class="list-group-item"><a href="users.php">Sign In</a></li>
                <li class="list-group-item"><a href="logout.php">Log Out</a></li>
                <li class="list-group-item"><a href="request.php">Write a query</a></li>
            </ul>

            <h3>Queries</h3>
            <ul class="list-group">
                <li class="list-group-item"><a href="search.php">Search</a></li>
                <li class="list-group-item"><a href="comments.php">Comment</a></li>
                <li class="list-group-item"><a href="new_event.php">Notify Event</a></li>
                <li class="list-group-item"><a href="support.php">Support</a></li>
            </ul>
        </div>
    </div>
</div>

<?php require_once 'template/script.php' ?>
<?php require_once 'template/foot.php' ?>