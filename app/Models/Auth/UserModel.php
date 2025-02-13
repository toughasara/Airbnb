<?php
namespace App\Models\Auth;

use App\Config\Database;
use PDO;

class UserModele
{

    private $conn;

    public function __construct()
    {
        
        $db = Database::getInstance();
        $this->conn = $db->connect();

    }

    public function findUserByEmail($user){
        try{
            $query = "SELECT *  FROM utilisateurs WHERE email = :email";

            $stmt = $this->conn->prepare($query); 
            $stmt->bindParam(":email", $user->getEmail());
            $stmt->execute();
            
            $row = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($row) {
                return new User($row["id"],$row["role_id"],$row["first_name"],$row["last_name"],$row["email"],$row["password"],$row["phone_number"],$row["profile_picture"],$row["status"],$row["created_at"],$row["last_login"],$row["is_connected"]);
            } else {
                return null;
            }
        }
        catch (PDOException $e) {
            error_log("Erreur de base de données : " . $e->getMessage());
            return null;
        }
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