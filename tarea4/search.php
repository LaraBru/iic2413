<?php 
    
session_start();
require_once 'classes/Db.class.php';
require_once 'function/print_table.php';

$cities = Db::getCities();
$countries = Db::getCountries();
$users = Db::getUsers();
$types = Db::getTypes();

$options_cities = "";
foreach ($cities as $city) {
    $options_cities = $options_cities . "<option value='" . $city['id_city'] . "'>" . $city['name'] . "</option>";
}
$options_countries = "";
foreach ($countries as $country) {
    $options_countries = $options_countries . "<option value='" . $country['id_country'] . "'>" . $country['name'] . "</option>";
}
$options_users = "";
foreach ($users as $user) {
    $options_users = $options_users . "<option value='" . $user['username'] . "'>" . $user['name'] . "</option>";
}
$options_types = "";
foreach ($types as $type) {
    $options_types = $options_types . "<option value='" . $type['username'] . "'>" . $type['name'] . "</option>";
}

$active_alerts = Db::getAllActiveAlerts();

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
                    <a data-toggle="collapse" data-parent="#accordion" href="#collapseOne">Events and alerts according to a city</a>
                </h4>
            </div>
            <div id="collapseOne" class="panel-collapse collapse">
                <div class="panel-body">
                    <div class="row">
                        <div class="col-lg-4 col-lg-offset-4">
                            <form class="form" action="function/query.php" method="GET" data-query="query1">
                                <input type="hidden" value="query1" name="type">
                                <select name="id_city" id="id_city" class="form-control text-center">
                                    <?php echo $options_cities; ?>
                                </select>
                                <input class="btn btn-primary" type="submit" value="Launch Query">
                            </form>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12">
                            <div id="query1"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="panel panel-default">
            <div class="panel-heading">
                <h4 class="panel-title">
                    <a data-toggle="collapse" data-parent="#accordion" href="#collapseTwo">Events and alerts according to a country</a>
                </h4>
            </div>
            <div id="collapseTwo" class="panel-collapse collapse">
                <div class="panel-body">
                    <div class="row">
                        <div class="col-lg-4 col-lg-offset-4">
                            <form class="form" action="function/query.php" method="GET" data-query="query2">
                                <input type="hidden" value="query2" name="type">
                                <select name="id_country" id="id_country" class="form-control text-center">
                                    <?php echo $options_countries; ?>
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
                    <a data-toggle="collapse" data-parent="#accordion" href="#collapseThree">Events and alerts at a given date</a>
                </h4>
            </div>
            <div id="collapseThree" class="panel-collapse collapse">
                <div class="panel-body">
                    <div class="row">
                        <div class="col-lg-4 col-lg-offset-4">
                            <form class="form" action="function/query.php" method="GET" data-query="query3">
                                <input type="hidden" value="query3" name="type">
                                <input type="date" name="date">
                                <input class="btn btn-primary" type="submit" value="Launch Query">
                            </form>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12">
                            <div id="query3"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="panel panel-default">
            <div class="panel-heading">
                <h4 class="panel-title">
                    <a data-toggle="collapse" data-parent="#accordion" href="#collapseFour">Active alerts and associated events</a>
                </h4>
            </div>
            <div id="collapseFour" class="panel-collapse collapse">
                <div class="panel-body">
                    <?php 
                        if ($active_alerts) 
                        {
                            echo print_one($active_alerts); 
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
                    <a data-toggle="collapse" data-parent="#accordion" href="#collapseFive">Events and alerts according to a city and a type</a>
                </h4>
            </div>
            <div id="collapseFive" class="panel-collapse collapse">
                <div class="panel-body">
                    <div class="row">
                        <div class="col-lg-4 col-lg-offset-4">
                            <form class="form" action="function/query.php" method="GET" data-query="query4">
                                <input type="hidden" value="query4" name="type">
                                <select name="id_city" id="id_city" class="form-control text-center">
                                    <?php echo $options_cities; ?>
                                </select>
                                <select name="id_type" id="id_type" class="form-control text-center">
                                    <?php echo $options_types; ?>
                                </select>
                                <input class="btn btn-primary" type="submit" value="Launch Query">
                            </form>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12">
                            <div id="query4"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="panel panel-default">
            <div class="panel-heading">
                <h4 class="panel-title">
                    <a data-toggle="collapse" data-parent="#accordion" href="#collapseSix">Events and alerts according to a country and a type</a>
                </h4>
            </div>
            <div id="collapseSix" class="panel-collapse collapse">
                <div class="panel-body">
                    <div class="row">
                        <div class="col-lg-4 col-lg-offset-4">
                            <form class="form" action="function/query.php" method="GET" data-query="query5">
                                <input type="hidden" value="query5" name="type">
                                <select name="id_country" id="id_country" class="form-control text-center">
                                    <?php echo $options_countries; ?>
                                </select>
                                <select name="id_type" id="id_type" class="form-control text-center">
                                    <?php echo $options_types; ?>
                                </select>
                                <input class="btn btn-primary" type="submit" value="Launch Query">
                            </form>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12">
                            <div id="query5"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="panel panel-default">
            <div class="panel-heading">
                <h4 class="panel-title">
                    <a data-toggle="collapse" data-parent="#accordion" href="#collapseSeven">Events and alerts at a given date according to a type</a>
                </h4>
            </div>
            <div id="collapseEight" class="panel-collapse collapse">
                <div class="panel-body">
                    <div class="row">
                        <div class="col-lg-4 col-lg-offset-4">
                            <form class="form" action="function/query.php" method="GET" data-query="query6">
                                <input type="hidden" value="query6" name="type">
                                <input type="date" name="date">
                                <select name="id_type" id="id_type" class="form-control text-center">
                                    <?php echo $options_types; ?>
                                </select>
                                <input class="btn btn-primary" type="submit" value="Launch Query">
                            </form>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12">
                            <div id="query6"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="panel panel-default">
            <div class="panel-heading">
                <h4 class="panel-title">
                    <a data-toggle="collapse" data-parent="#accordion" href="#collapseEight">Active alerts and associated events according to a type</a>
                </h4>
            </div>
            <div id="collapseEight" class="panel-collapse collapse">
                <div class="panel-body">
                    <div class="row">
                        <div class="col-lg-4 col-lg-offset-4">
                            <form class="form" action="function/query.php" method="GET" data-query="query7">
                                <input type="hidden" value="query7" name="type">
                                <select name="id_type" id="id_type" class="form-control text-center">
                                    <?php echo $options_types; ?>
                                </select>
                                <input class="btn btn-primary" type="submit" value="Launch Query">
                            </form>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12">
                            <div id="query7"></div>
                        </div>
                    </div>
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
