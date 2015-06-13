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

function get_messages_localization ($city,$country)
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
    $stmt = $db->prepare("
	SELECT userNameCreador, mensaje, meGsuta, noMeGusta
	FROM mensaje 
	WHERE ciudad ILIKE ? AND pais ILIKE ?;
	");
    $stmt->execute(array($username, $password));
    $rows = $stmt->fetchAll(\PDO::FETCH_ASSOC);
    return $rows;
}

function get_comments ($idPadre)
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
    $stmt = $db->prepare("
	SELECT userNameCreador, comentario, meGsuta, noMeGusta 
	FROM Comentario 
	WHERE idParde = ?;
	");
    $stmt->execute(array($username, $password));
    $rows = $stmt->fetchAll(\PDO::FETCH_ASSOC);
    return $rows;
}



?>
