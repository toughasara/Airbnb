<?php 

namespace App\Models\Front;

use App\Config\Database;

class AddAnnounceModel
{
    private $conn;
    

    public function __construct(){

        $db = Database::getInstance();
        $this->conn = $db->connect();

    }
    

    public function addAnnounce($id){

      $query ="INSERT INTO property (owner_id, title, description, category, price_per_night, max_guests, amenities, photos, is_validated, address, city, country) VALUES
                (:id, 'dar zakaria', 'Un studio cosy en plein cœur de Paris proche de la Tour Eiffel.', 'Studio', 40.00, 3, 'ARRAY'['Wi-Fi', 'Cuisine équipée', 'TV']', 'ARRAY['https://example.com/photos/paris3.jpg', 'https://example.com/photos/paris4.jpg']', TRUE, '15 Rue de la Paix', 'Paris', 'France')";

    $stmt =$this->conn->prepare($query);
    $stmt->bindParam(":id",);
    $stmt->execute();
    dump("success");

}





}