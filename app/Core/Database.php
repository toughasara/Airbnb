<?php 
namespace App\Config;

use PDO;
use PDOException;

class Database { 
    private $dbHost;
    private $dbUsername; 
    private $dbPassword; 
    private $dbName; 
    private $conn; 
    private static $instance = null;

    private function __construct() { 
        // Load environment variables
        $this->dbHost = $_ENV['LOCALHOST'];
        $this->dbUsername = $_ENV['USER'];
        $this->dbPassword = $_ENV['USER_PASSWORD'];
        $this->dbName = $_ENV['DATABASE'];

        try { 
            $this->conn = new PDO("pgsql:host=".$this->dbHost.";dbname=".$this->dbName, $this->dbUsername, $this->dbPassword);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) { 
            die("Failed to connect with PostgreSQL: " . $e->getMessage()); 
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