<?php 
    
session_start();

require_once 'classes/Db.class.php';
require_once 'function/print_table.php';

$alert_activated = Db::getAlertActivated();
$cities = Db::getCities();
$users = Db::getUsers();

$options_cities = "";
foreach ($cities as $city) {
    $options_cities = $options_cities . "<option value='" . $city['id_city'] . "'>" . $city['name'] . "</option>";
}

$options_users = "";
foreach ($users as $user) {
    $options_users = $options_users . "<option value='" . $user['username'] . "'>" . $user['name'] . "</option>";
}

$city_with_most_hurricanes_last_10_years = Db::getMostHurricanesLast10years();

$city_with_most_event_without_alert = Db::getCityMostEventWithoutAlert();

?>

<?php require_once 'template/head.php'  ?>

<div class="row">
<div class="col-lg-10 col-lg-offset-1">
<div class="box">
<div class="bs-example">
    <div class="panel-group" id="accordion">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h4 class="panel-title">
                    <a data-toggle="collapse" data-parent="#accordion" href="#collapseOne">Alert activated</a>
                </h4>
            </div>
            <div id="collapseOne" class="panel-collapse collapse">
                <div class="panel-body">
                    <?php echo print_table($alert_activated); ?>
                </div>
            </div>
        </div>
        <div class="panel panel-default">
            <div class="panel-heading">
                <h4 class="panel-title">
                    <a data-toggle="collapse" data-parent="#accordion" href="#collapseTwo">Events in the last 10 years according to the city</a>
                </h4>
            </div>
            <div id="collapseTwo" class="panel-collapse collapse">
                <div class="panel-body">
                    <div class="row">
                        <div class="col-lg-4 col-lg-offset-4">
                            <form class="form" action="function/query.php" method="GET" data-query="query2">
                                <input type="hidden" value="query2" name="type">
                                <select name="id_city" id="id_city" class="form-control text-center">
                                    <?php echo $options_cities; ?>
                                </select>
                                <input class="btn btn-primary" type="submit" value="Launch Query">
                            </form>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12">
                            <div id="query2"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="panel panel-default">
            <div class="panel-heading">
                <h4 class="panel-title">
                    <a data-toggle="collapse" data-parent="#accordion" href="#collapseThree">Events and alerts connected to user</a>
                </h4>
            </div>
            <div id="collapseThree" class="panel-collapse collapse">
                <div class="panel-body">
                    <?php 
                        if (!isset($_SESSION['username'])) {
                    ?>
                            <form action="function/query.php" class="form" method="GET" data-query="query3">
                                <input type="hidden" value="query3" name="type">
                                <select name="username" id="username" class="form-control text-center">
                                    <?php echo $options_users; ?>
                                </select>
                                <input class="btn btn-primary" type="submit" value="Launch Query">
                            </form>
                            <div id="query3"></div>
                    <?php
                        }
                        else
                        {
                    ?>
                        <div id="query3">
                    <?php
                            echo '<h3>User = ' . $_SESSION['username'] . '</h3>';
                            echo '<h4>Alerts</h4>';
                            echo print_table(Db::getAlertUser($_SESSION['username']));
                            echo '<h4>Events</h4>';
                            echo print_table(Db::getEventUser($_SESSION['username']));
                    ?>
                        </div>
                    <?php } ?>
                </div>
            </div>
        </div>
        <div class="panel panel-default">
            <div class="panel-heading">
                <h4 class="panel-title">
                    <a data-toggle="collapse" data-parent="#accordion" href="#collapseFour">City with the most hurricanes in the last 10 years</a>
                </h4>
            </div>
            <div id="collapseFour" class="panel-collapse collapse">
                <div class="panel-body">
                    <?php 
                        if ($city_with_most_hurricanes_last_10_years) 
                        {
                            echo print_one($city_with_most_hurricanes_last_10_years); 
                        }
                        else
                        {
                            echo 'Nothing to show';
                        }
                    ?>
                </div>
            </div>
        </div>
        <div class="panel panel-default">
            <div class="panel-heading">
                <h4 class="panel-title">
                    <a data-toggle="collapse" data-parent="#accordion" href="#collapseFive">City that generated the greatest number of alert without event</a>
                </h4>
            </div>
            <div id="collapseFive" class="panel-collapse collapse">
                <div class="panel-body">
                    <?php 
                        if ($city_with_most_event_without_alert) 
                        {
                            echo print_one($city_with_most_event_without_alert); 
                        }
                        else
                        {
                            echo 'Nothing to show';
                        }
                    ?>
                </div>
            </div>
        </div>
        <div class="panel panel-default">
            <div class="panel-heading">
                <h4 class="panel-title">
                    <a data-toggle="collapse" data-parent="#accordion" href="#collapseSix">Statistics for the Eathrquakes</a>
                </h4>
            </div>
            <div id="collapseSix" class="panel-collapse collapse">
                <div class="panel-body">
                    <h3>Min</h3>
                    <?php 
                        $min = Db::getMinEarthquake();
                        if (isset($min['min']) && $min['min'] != '') 
                        {
                            echo print_one($min);
                        }
                        else
                        {
                            echo 'No result to show';
                        }
                    ?>
                    <h3>Max</h3>
                    <?php 
                        $max = Db::getMaxEarthquake();
                        if (isset($max['max']) && $max['max'] != '') 
                        {
                            echo print_one($max);
                        }
                        else
                        {
                            echo 'No result to show';
                        }
                    ?>
                    <h3>Avg</h3>
                    <?php 
                        $avg = Db::getAvgEarthquake();
                        if (isset($avg['avg']) && $avg['avg'] != '') 
                        {
                            echo print_one($avg);
                        }
                        else
                        {
                            echo 'No result to show';
                        }
                    ?>
                    <h3>Median</h3>
                    <?php 
                        $median = Db::getMedEarthquake();
                        if (isset($median['median']) && $median['median'] != '') 
                        {
                            echo print_one($median);
                        }
                        else
                        {
                            echo 'No result to show';
                        }
                    ?>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
</div>
</div>

<?php require_once 'template/script.php' ?>

<script src="assets/js/grupo16.js"></script>

<?php require_once 'template/foot.php' ?>
