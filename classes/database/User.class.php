<?php 

require_once 'Db.class.php';

class UserManager {
    protected $_table;
    protected $_username;
    protected $_name;
    protected $_password;
    protected $_email;
    protected $_affiliation;
    protected $_country;

    public function __construct($username, $name, $password, $email, $affiliation, $country)
    {
        
    }

    public static function getUsers() 
    {
        $res = array();
        $stmt = $this->$_handle->prepare("SELECT * FROM user");
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        while ($row) 
        {
            echo $row;
        }
    }
}

?>