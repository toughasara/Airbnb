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
    

    public function addAnnounce($id,$title,$description,$category,$price_per_night,$max_guests,$amenities,$photos,$address,$city,$country){

      $query ="INSERT INTO property (owner_id, title, description, category, price_per_night, max_guests, amenities, photos, address, city, country) VALUES
(:id, :title,:description,:category,:price_per_night,:max_guests,:amenities,:photos,:address,:city,:country );

";

    $stmt =$this->conn->prepare($query);
    $stmt->bindParam(":id",$id);
    $stmt->bindParam(":title",$title);
    $stmt->bindParam(":description",$description);
    $stmt->bindParam(":category",$category);
    $stmt->bindParam(":price_per_night",$price_per_night);
    $stmt->bindParam(":max_guests",$max_guests);
    $stmt->bindParam(":amenities",$amenities);
    $stmt->bindParam(":photos",$photos);
    $stmt->bindParam(":address",$address);
    $stmt->bindParam(":city",$city);
    $stmt->bindParam(":country",$country);
    $stmt->execute();
    dump("success");

}





}