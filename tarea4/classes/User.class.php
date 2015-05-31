<?php 

require_once 'Db.class.php';

class User {
    protected $username;
    protected $name;
    protected $password;
    protected $email;
    protected $afiliacion;
    protected $id_country;

    public function __construct($data) 
    {
        $this->updateWithData($data,true);
    }
    
    public function updateWithData($data,$constructor=false)
    {
        $properties = get_class_vars(get_class());
        foreach($properties as $key => $default_value)
        {
            if(array_key_exists($key, $data))
            {
                $this->$key = $data[$key];
            }
            else if($constructor)
            {
                $this->$key = null;
            }
        }
    }

    public static function getProperties()
    {
        return array_keys(get_class_vars(get_class()));
    }

    public function getProperty($key)
    {
        if(!in_array($key, self::getProperties()))
        {
            return null;
        }
        return $this->$key;
    }

    public function setProperty($key, $value)
    {
        if(in_array($key, self::getProperties()))
        {
            $this->$key = $value;
        }
    }

    public static function userWithUsername($username)
    {
        return Db::shared()->getUserWithUsername($username);
    }

    public function save()
    {
        Db::shared()->saveUser($this);
    }

    public static function currentUser()
    {
        $username = $_SESSION['username'];
        if(!$username)
        {
            return null;
        }
        return self::userWithUsername($username);
    }

}

?>