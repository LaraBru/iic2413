<?php 

require_once 'User.class.php';

class Db 
{
    protected $_handle;
    static private $_shared = null;

    public function __construct()
    {
        try 
        {
            $connexion = "pgsql:host=localhost;port=5432;dbname=grupo16;user=grupo16;password=grupo16" ;
            $this->handle = new PDO($connexion);
        }
        catch (PDOException $e)
        {
            $e->getMessage();
            die();
        }   
    }

    public static function init()
    {
        if(!isset(self::$_shared))
        {
            self::$_shared = new Db();
        }
    }

    public static function shared()
    {
        if(!isset(self::$_shared))
        {
            self::init();
        }
        return self::$_shared;
    }

    public function saveUser($user)
    {
        $first = true;
        $bindings = array();
        $keys = User::getProperties();
        $cmd="";
        if(User::userWithUsername($user->getProperty('username'))!=null)
        {
            $cmd = "UPDATE person SET ";
            foreach($keys as $key)
            {
                if($key!='username')
                {
                    if(!$first)
                    {
                        $cmd .= ', ';
                    }
                    $cmd .= $key.'=?';
                    $bindings[] = $user->getProperty($key);
                    $first = false;
                }
            }
            $cmd .= ' WHERE username=?';
            $bindings[] = $user->getProperty('username');
        }
        else
        {
            $cmd = "INSERT INTO person (";
            $values = '';
            foreach($keys as $key)
            {
                if(!$first)
                {
                    $cmd .= ',';
                    $values .= ',';
                }
                $cmd .= $key;
                $values .= '?';
                $bindings[] = $user->getProperty($key);
                $first = false;
            }
            $cmd .= ') VALUES ('.$values.')';
        }
        $stmt = $this->handle->prepare($cmd);
        if(!$stmt->execute($bindings))
        {
            // print_r($stmt->errorInfo());
        }
    }

    public function getUserWithUsername($username)
    {
        $stmt = $this->handle->prepare("SELECT * FROM person WHERE username=?");
        $stmt->execute(array($username));
        $row = $stmt->fetch(\PDO::FETCH_ASSOC);
        if($row)
        {
            return new User($row);
        }
        return null;
    }



    //////////////////////////////////////////
    // COUNTRY
    //////////////////////////////////////////

    public static function getCountries()
    {
        $stmt = Db::shared()->handle->prepare("SELECT * FROM country;");
        $stmt->execute();
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $rows;
    }

}

?>