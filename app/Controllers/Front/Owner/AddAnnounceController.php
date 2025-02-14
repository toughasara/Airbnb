<?php

namespace App\Controllers\Front\Owner;

use App\Models\Front\AddAnnounceModel;

class AddAnnounceController{

    public static $AddAnnounceModel;

    public function __construct()
    {

        self::$AddAnnounceModel = new AddAnnounceModel;

    }

    public function addAnnounce($id){
     

        self::$AddAnnounceModel->addAnnounce($id);
        
    }

}