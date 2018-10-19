<?php

/**
 * Handling database connection
 *
 * @author Ravi Tamada
 * @link URL Tutorial link
 */
class DbConnect {

    private $conn;

    function __construct() {        
    }

    /**
     * Establishing database connection
     * @return database connection handler
     */
    function connect() {
        include_once dirname(__FILE__) . '/Config.php';

        // Connecting to mysql database
        $this->conn = new mysqli(DB_HOST, DB_USERNAME, DB_PASSWORD, DB_NAME,DB_PORT);
		$this->conn->set_charset('utf8');

        // Check for database con nection error
        if (mysqli_connect_errno()) {
            echo "Failed to connect to MySQL: " . mysqli_connect_error();
            exit;
        }

        // returing connection resource
        return $this->conn;
    }

         //Added by Bonaveture DOSSOU 10/04/2018

}

?>