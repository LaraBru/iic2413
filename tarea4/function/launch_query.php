<?php 
    if (isset($_POST['query']))
    {
        try 
        {
            $connexion = "pgsql:host=localhost;port=5432;dbname=grupo16;user=grupo16;password=grupo16" ;
            $db = new PDO($connexion);
        }
        catch (PDOException $e) 
        {
            $rows = array(array(
                "Error !" => $e->getMessage()
            ));
            die();
        }
        $stmt = $db->prepare($_POST['query']);
        if(!$stmt)
        {
            $rows = array(array(
                "Error !" => $db->errorInfo()[2]
            ));
        }
        else
        {
            if(!$stmt->execute())
            {
                $rows = array(array(
                    "Error !" => $db->errorInfo()[2]
                ));
            }
            else
            {
                $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
            }
        }
    }
    else
    {
        $rows = array(array(
            "" => "No request launched"
        ));
    }
?>
