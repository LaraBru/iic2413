<?php 

function verif_network_user($username, $password)
{
    try 
    {
        $db = new PDO("pgsql:dbname=grupo13;host=localhost;port=5432;user=grupo13;password=grupo13");
    }
    catch (PDOException $e)
    {
        $e->getMessages();
        die();   
    }

    $stmt = $db->prepare("SELECT * FROM usuario WHERE username=? AND password=?");
    $stmt->execute(array($username, $password));
    $row = $stmt->fetch(\PDO::FETCH_ASSOC);
    return $row;
}



?>