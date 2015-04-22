<?php 
    require_once 'classes/database/Db.class.php';
    require_once 'function/print_table.php';

    if (isset($_POST['query']))
    {
        try 
        {
            $connexion = "pgsql:host=localhost;port=5432;dbname=grupo16;user=grupo16;password=grupo16" ;
            $db = new PDO($connexion);
        } 
        catch (PDOException $e) 
        {
            $rows = array(
                "Error!: " => $e->getMessage()
            );
            die();
        }
        try
        {
            $stmt = $db->prepare($_POST['query']);
            if ($stmt->execute())
            {
                $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
            }
            else
            {
                $rows = array(array(
                    "Error : " => "Your request failed"
                ));
            }
        }
        catch (Exception $e)
        {
            $rows = array(array(
                "Error : " => "Your request failed - " . $e->getMessage()
            ));
        }
    }
    else
    {
        $rows = array(array(
            "" => "No request launched"
        ));
    }
?>
<?php require_once 'template/head.php' ?>

<div class="row">
    <div class="col-lg-8 col-lg-offset-2">
        <h1 class="text-center">Page to test queries</h1>
        <div class="box">
            <form action="request.php" method="POST">
                <h3>Enter a query below</h3>
                <p>You can use ctrl + enter or cmd + enter to try your query</p>
                <textarea id="queryarea" name="query" class="form-control" cols="10" rows="3"></textarea>
                <button class="btn btn-primary" type="submit">Launch Query</button>
            </form>
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