<?php
namespace App\Models\Front;

use App\Config\Database;
use PDO;
class DisplayDataModele
{

    private $conn;

    public function __construct()
    {
        
        $db = Database::getInstance();
        $this->conn = $db->connect();

    }


    public function displayProperty(){
    
        $query = 'SELECT title,price_per_night,city,country from property 
        where is_validated = true ';

        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
        if(!$rows){

            return null;

        }
        else{

            return $rows;

        }

    }


}