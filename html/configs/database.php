<?php

class Connector  {
		//MYSQL
		private $HOST = "localhost"; 	// Host name 
		private $USERNAME = "root"; 						// Mysql username 
		private $PASSWORD = "RVZ5PiclgG";								  // Mysql password 
		private $DB_NAME = "arion"; 			// Database name 


		protected $_connection;

		function __construct() {
			try {
				$DSN = "mysql:host={$this->HOST};dbname={$this->DB_NAME}";
				$connect = new PDO($DSN, $this->USERNAME, $this->PASSWORD);
				$this->_connection = $connect;
			}
			catch (Exception $e) {
				die("Couldn't connect to databse: $e->getMessage");
			}
		}
    public function connect() {
      return $this->_connection;
    }
}
// DON'T TOUCH THIS PHP TAG!!
if(basename($_SERVER["PHP_SELF"]) == "database.php"){
die("You aren't supposed to be here. Please Check your link and try again.");}
?>
