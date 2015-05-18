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
    // USERS
    //////////////////////////////////////////
    public static function getUsers()
    {
        $stmt = Db::shared()->handle->prepare("SELECT * FROM person;");
        $stmt->execute();
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $rows;    
    }

    //////////////////////////////////////////
    // COUNTRY / CITIES
    //////////////////////////////////////////

    public static function getCountries()
    {
        $stmt = Db::shared()->handle->prepare("SELECT * FROM country;");
        $stmt->execute();
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $rows;
    }

    public static function getCities()
    {
        $stmt = Db::shared()->handle->prepare("SELECT * FROM city;");
        $stmt->execute();
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $rows;
    }

    public static function getCityWithId($id)
    {
        $stmt = Db::shared()->handle->prepare("SELECT * FROM city WHERE id_city=?");
        $stmt->execute(array($id));
        $row = $stmt->fetch(\PDO::FETCH_ASSOC);
        return $row;
    }

    //////////////////////////////////////////
    // ALERTS
    //////////////////////////////////////////
    public static function getAlertActivated()
    {
        $stmt = Db::shared()->handle->prepare("SELECT * FROM Alert WHERE ending IS NULL");
        $stmt->execute();
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $rows;
    }

    public static function getMostHurricanesLast10years()
    {
        $stmt = Db::shared()->handle->prepare("
            SELECT id_city FROM (
                SELECT id_city, COUNT(*) AS number
                FROM Event INNER JOIN Event_City
                ON Event.id_event = Event_City.id_event
                INNER JOIN Type
                ON Event.id_type = Type.id_type
                WHERE type.name = 'Hurricane'
                AND AGE (Event.beginning) < INTERVAL '10 years'
                GROUP BY id_city ) 
            AS City_Hurricane
            WHERE City_Hurricane.number = (SELECT MAX(number) FROM (
                SELECT id_city, COUNT(*) AS number
                FROM Event INNER JOIN Event_City
                ON Event.id_event = Event_City.id_event
                INNER JOIN Type
                ON Event.id_type = Type.id_type
                WHERE type.name = 'Hurricane'
                AND AGE (Event.beginning) < INTERVAL '10 years'
                GROUP BY id_city ) 
            AS City_Hurricane);
        ");
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return Db::getCityWithId($row['id_city']);
    }

    public static function getEventsLast10YearsCity($id_city)
    {
        $stmt = Db::shared()->handle->prepare("
            SELECT * FROM Event INNER JOIN Event_City 
            ON Event.id_event = Event_City.id_event
            INNER JOIN City
            ON Event_City.id_City = City.id_City
            WHERE AGE (Event.beginning) < INTERVAL '10 years'
            AND City.id_city = ?;
        ");
        $stmt->execute(array($id_city));
        $rows = $stmt->fetchAll(\PDO::FETCH_ASSOC);
        return $rows;
    }

    public static function getAlertUser($username)
    {
        $stmt = Db::shared()->handle->prepare("
            SELECT * FROM Event WHERE username = ?;
        ");
        $stmt->execute(array($username));
        $rows = $stmt->fetchAll(\PDO::FETCH_ASSOC);
        return $rows;
    }

    public static function getCityMostEventWithoutAlert()
    {
        $stmt = Db::shared()->handle->prepare("
            SELECT id_city FROM (
                SELECT id_city, COUNT(*) AS number
                FROM Alert INNER JOIN Alert_City
                ON Alert.id_alert = Alert_City.id_alert
                WHERE Alert.id_alert NOT IN (SELECT id_alert FROM Alert_Event)
                GROUP BY id_city)
            AS City_FalseAlert
            WHERE City_FalseAlert.number = (SELECT MAX(number) FROM (
                SELECT id_city, COUNT(*) AS number
                FROM Alert INNER JOIN Alert_City
                ON Alert.id_alert = Alert_City.id_alert
                WHERE Alert.id_alert NOT IN (SELECT id_alert FROM Alert_Event)
                GROUP BY id_city)
            AS City_FalseAlert);
        ");
        $stmt->execute();
        $row = $stmt->fetch(\PDO::FETCH_ASSOC);
        return Db::getCityWithId($row['id_city']);;   
    }

    //////////////////////////////////////////
    // EVENTS
    //////////////////////////////////////////

    public static function getEventUser($username)
    {
        $stmt = Db::shared()->handle->prepare("
            SELECT * FROM Alert WHERE username = ?;
        ");
        $stmt->execute(array($username));
        $rows = $stmt->fetchAll(\PDO::FETCH_ASSOC);
        return $rows;
    }

    //////////////////////////////////////////
    // EARTHQUAKE
    //////////////////////////////////////////

    public static function getMinEarthquake()
    {
        $stmt = Db::shared()->handle->prepare("
            SELECT MIN(richter) FROM Earthquake
            INNER JOIN Event
            ON Event.id_event = Earthquake.id_event
            WHERE AGE(Event.beginning) < INTERVAL '1 year';
        ");
        $stmt->execute();
        $row = $stmt->fetch(\PDO::FETCH_ASSOC);
        return $row;
    }

    public static function getMaxEarthquake()
    {
        $stmt = Db::shared()->handle->prepare("
            SELECT MAX(richter) FROM Earthquake
            INNER JOIN Event
            ON Event.id_event = Earthquake.id_event
            WHERE AGE(Event.beginning) < INTERVAL '1 year';
        ");
        $stmt->execute();
        $row = $stmt->fetch(\PDO::FETCH_ASSOC);
        return $row;
    }
    public static function getAvgEarthquake()
    {
        $stmt = Db::shared()->handle->prepare("
            SELECT AVG(richter) FROM Earthquake
            INNER JOIN Event
            ON Event.id_event = Earthquake.id_event
            WHERE AGE(Event.beginning) < INTERVAL '1 year';
        ");
        $stmt->execute();
        $row = $stmt->fetch(\PDO::FETCH_ASSOC);
        return $row;
    }
    public static function getMedEarthquake()
    {
        $stmt = Db::shared()->handle->prepare("
            SELECT richter as median FROM Earthquake
            INNER JOIN Event
            ON Event.id_event = Earthquake.id_event
            WHERE AGE(Event.beginning) < INTERVAL '1 year'
            ORDER BY richter
            LIMIT 1 OFFSET ((SELECT COUNT(*) FROM Earthquake) /2 );
        ");
        $stmt->execute();
        $row = $stmt->fetch(\PDO::FETCH_ASSOC);
        return $row;
    }
}

?>