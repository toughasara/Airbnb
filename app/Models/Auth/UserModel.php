<?php

namespace App\Models\Auth;

use App\Classes\User;
use App\Core\Database;
use PDO;

class UserModel{
    private $conn;

    public function __construct() {
        $db = new Database();
        $this->conn = $db->connection();
    }

    public function findUserByEmailAndPassword($email){
        try{
            $query = "SELECT *  FROM utilisateurs WHERE email = :email";

            $stmt = $this->conn->prepare($query); 
            $stmt->bindParam(":email", $email);
            $stmt->execute();
            
            $row = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($row) {
                return new Utilisateur($row["id"],$row["nom"],$row["email"],$row["password"],$row["role"],$row["status"],$row["created_at"],$row["deleted_at"]);
            } else {
                return null;
            }
        }
        catch (PDOException $e) {
            error_log("Erreur de base de données : " . $e->getMessage());
            return null;
        }
    }


    public function Registre($utilisateur){
        $name = $utilisateur->getNom();
        $email = $utilisateur->getEmail();
        $password = $utilisateur->getPassword();
        $role = $utilisateur->getRole();
        $status = $utilisateur->getStatus();

        $query = "INSERT INTO utilisateurs (nom, email, password, role, status) 
                VALUES (:nom, :email, :password, :role, :status);";
        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(':nom', $name);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':password', $password);
        $stmt->bindParam(':role', $role);
        $stmt->bindParam(':status', $status);
        $stmt->execute();
    }
}