<?php

namespace App\Controllers\Front\Owner;

use App\Models\Front\AddAnnounceModel;

class AddAnnounceController{

    public static $AddAnnounceModel;

    public function __construct()
    {

        self::$AddAnnounceModel = new AddAnnounceModel;

    }

    public function addAnnounce($id,$title,$description,$category,$price_per_night,$max_guests,$amenities,$photos,$address,$city,$country){
     

        self::$AddAnnounceModel->addAnnounce($id,$title,$description,$category,$price_per_night,$max_guests,$amenities,$photos,$address,$city,$country);
        
    }

}