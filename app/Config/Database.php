<?php 
namespace App\Config;

use Dotenv\Dotenv;
use PDO;
use PDOException;

class Database { 

    private $conn; 
    private static $instance = null;

    private function __construct() { 
        // Load environment variables

        $dotenv = Dotenv::createImmutable(__DIR__ . '/../../');
        $dotenv->load();
        try { 
            $this->conn = new PDO("pgsql:host=".$_ENV['LOCALHOST'].";port=".$_ENV['DB_PORT'].";dbname=". $_ENV['DATABASE'], $_ENV['USER'], $_ENV['USER_PASSWORD']);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            // echo "ttttttttttttttttttttttttttt";
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