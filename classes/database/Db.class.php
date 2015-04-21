<?php 
class Db {
    public $handle;
    protected $_host = "localhost";
    protected $_port = "5432";
    protected $_db = "grupo16";
    protected $_user = "grupo16";
    protected $_password = "grupo16";

    public function __construct()
    {
        try {
            $connexion = "pgsql:host=" . $this->_host . ";port=" . $this->_port . ";dbname=" . $this->_db . ";user=" . $this->_user . ";password=" . $this->_password ;
            $this->_handle = new PDO($connexion);
        } catch (PDOException $e) {
            print "Error!: " . $e->getMessage() . "<br/>";
            die();
        }
    }
}
?>