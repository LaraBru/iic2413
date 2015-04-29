<?php 

require_once 'classes/Db.class.php';

$countries = Db::getCountries();
$options = "";
foreach ($countries as $country) {
    $options = $options . "<option value='" . $country['id_country'] . "'>" . $country['name'] . "</option>";
}
?>

<div class="row">
    <div class="col-lg-12 col-lg-offset-0 col-md-4 col-md-offset-4">
        <form action="users.php" method="POST">
            <input class="form-control" type="text" placeholder="username" name="username">
            <input class="form-control" type="text" placeholder="name" name="name">
            <input class="form-control" type="email" placeholder="email" name="email">
            <input class="form-control" type="password" placeholder="password" name="password">
            <input class="form-control" type="text" placeholder="afiliacion" name="afiliacion">
            <select name="id_country" class="form-control text-center">
                <option value="0">Choose a Country</option>
                <?php echo $options; ?>
            </select>
            <input type="hidden" value="register" name="type">
            <button class="btn btn-primary" type="submit">Register</button>
        </form>
    </div>
</div>