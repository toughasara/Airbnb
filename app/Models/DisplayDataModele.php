<?php
namespace App\Models;

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
    
        $query = 'SELECT title,price_per_night as price,photos as photo,city,country from property 
        where is_validated = true
        order by max_guests ;
        ';

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