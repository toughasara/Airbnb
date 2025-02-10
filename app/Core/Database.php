<?php

namespace App\Config;

use PDO;
use PDOException;

class Database { 
    private $dbHost = "";
    private $dbUsername = ""; 
    private $dbPassword = ""; 
    private $dbName = ""; 
    
    private $conn; 
    private static $instance = null;

    private function __construct() { 
        try { 
            $this->conn = new PDO("mysql:host=".$this->dbHost.";dbname=".$this->dbName, $this->dbUsername, $this->dbPassword);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) { 
            die("Failed to connect with MySQL: " . $e->getMessage()); 
        } 
    }

    public static function getInstance() {
        if (self::$instance == null) {
            self::$instance = new Database();
        }
        return self::$instance;
    }



    public function connect() { 
        return $this->conn;
    } 
}
?>