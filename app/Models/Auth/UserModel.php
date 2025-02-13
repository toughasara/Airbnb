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
            $query = "SELECT *  FROM user WHERE email = :email";

            $stmt = $this->conn->prepare($query); 
            $stmt->bindParam(":email", $user->getEmail());
            $stmt->execute();
            
            $row = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($row) {
                $role = new Role($row["role_id"], '');
                return new User($row["id"], $role,$row["first_name"],$row["last_name"],$row["email"],$row["password"],$row["phone_number"],$row["profile_picture"],$row["status"],$row["created_at"],$row["last_login"],$row["is_connected"]);
            } else {
                return null;
            }
        }
        catch (PDOException $e) {
            error_log("Erreur de base de données : " . $e->getMessage());
            return null;
        }
    }

    public function createUser($user)
    {
        try {
            $query = "INSERT INTO user (role_id, first_name, last_name, email, password, phone_number, profile_picture, status) 
                        VALUES (:role_id, :first_name, :last_name, :email, :password, :phone_number, :profile_picture, :status)";

            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(":role_id", $user->getRole()->getId());
            $stmt->bindParam(":first_name", $user->getFirstName());
            $stmt->bindParam(":last_name", $user->getLastName());
            $stmt->bindParam(":email", $user->getEmail());
            $stmt->bindParam(":password", password_hash($user->getPassword(), PASSWORD_DEFAULT));
            $stmt->bindParam(":phone_number", $user->getPhoneNumber());
            $stmt->bindParam(":profile_picture", $user->getProfilePicture());
            $stmt->bindParam(":status", $user->getStatus());
            return $stmt->execute();

        } catch (PDOException $e) {
            error_log("Erreur de base de données : " . $e->getMessage());
            return false;
        }
    }




}