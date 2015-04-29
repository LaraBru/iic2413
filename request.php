<?php 
    require_once 'classes/database/Db.class.php';
    
    require_once 'function/print_table.php';
    require_once 'function/launch_query.php';

?>
<?php require_once 'template/head.php' ?>

<div class="row">
    <div class="col-lg-12">
        <h1 class="text-center">Page to test queries</h1>
        <div class="box">
            <div class="row">
                <div class="col-lg-8 col-lg-offset-2">
                    <form action="request.php" method="POST">
                        <h3>Enter a query below</h3>
                        <p>You can use ctrl + enter or cmd + enter to try your query</p>
                        <textarea id="queryarea" name="query" class="form-control" cols="10" rows="3"></textarea>
                        <button class="btn btn-primary" type="submit">Launch Query</button>
                    </form>
                </div>
            </div>
            <div class="query_result">
                <h3>Results</h3>
<?php 
    print_table($rows);

    if (isset($_POST['query']))
    {
        echo '<p>the query was : ' . $_POST['query'] . '</p>';
    }
?>
            </div>
        </div>
    </div>
</div>

<?php require_once 'template/script.php' ?>
<script src="assets/js/grupo16.js"></script>
<?php require_once 'template/foot.php' ?>
