<?php
namespace App\Models\Auth;


use App\Config\Database;
use App\Classes\Role; 
use App\Classes\User;
use PDO;
use PDOException;

class UserModel
{

    private $conn;

    public function __construct()
    {
        
        $db = Database::getInstance();
        $this->conn = $db->connect();

    }

    
    public function findUserByEmail($user){
        try{
            $query = 'SELECT *  FROM "user" WHERE email = :email';

            $email = $user->getEmail();
            $stmt = $this->conn->prepare($query); 
            $stmt->bindParam(":email", $email);
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
            $query = 'INSERT INTO "user" (role_id, first_name, last_name, email, password, phone_number, profile_picture, status) 
                        VALUES (:role_id, :first_name, :last_name, :email, :password, :phone_number, :profile_picture, :status)';

            $role = $user->getRole()->getId();
            $first_name = $user->getFirstName();
            $last_name = $user->getLastName();
            $email = $user->getEmail();
            $password = password_hash($user->getPassword(), PASSWORD_DEFAULT);
            $phone_number = $user->getPhoneNumber();
            $profile_picture = $user->getProfilePicture();
            $status = $user->getStatus();

            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(":role_id", $role);
            $stmt->bindParam(":first_name", $first_name);
            $stmt->bindParam(":last_name", $last_name);
            $stmt->bindParam(":email", $email);
            $stmt->bindParam(":password", $password);
            $stmt->bindParam(":phone_number", $phone_number);
            $stmt->bindParam(":profile_picture", $profile_picture);
            $stmt->bindParam(":status", $status);
            return $stmt->execute();

        } catch (PDOException $e) {
            error_log("Erreur de base de données : " . $e->getMessage());
            return false;
        }
    }




}