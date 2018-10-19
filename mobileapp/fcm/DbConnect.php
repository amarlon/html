<?php 
 
//Class DbConnect
class DbConnect
{
    //Variable to store database link
    private $con;
	private $conchat;
 
    //Class constructor
    function __construct()
    {
 
    }
 
    //This method will connect to the database
    function connect_maindb()
    {
        //Including the config.php file to get the database constants
        include_once dirname(__FILE__) . '/Config.php';
 
        //connecting to mysql database
        $this->con = new mysqli(DB_HOST, DB_USERNAME, DB_PASSWORD, MAIN_DB_NAME);
		$this->con->set_charset('utf8');
 
        //Checking if any error occured while connecting
        if (mysqli_connect_errno()) {
            echo "Failed to connect to MySQL: " . mysqli_connect_error();
        }
 
        //finally returning the connection link 
        return $this->con;
    }
	
	function connect_chatdb()
    {
        //Including the config.php file to get the database constants
        include_once dirname(__FILE__) . '/Config.php';
 
        //connecting to mysql database
        $this->conchat = new mysqli(DB_HOST, DB_USERNAME, DB_PASSWORD, CHAT_DB_NAME);
		//$this->conchat->set_charset('utf8');
 
        //Checking if any error occured while connecting
        if (mysqli_connect_errno()) {
            echo "Failed to connect to MySQL: " . mysqli_connect_error();
        }
 
        //finally returning the connection link 
        return $this->conchat;
    }
 
}
?>