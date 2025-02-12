<?php
namespace App\Controllers\Front\Travler;


class PagesController
{

        public static $DisplayPropertyController ;

        public function __construct()
        {

            self::$DisplayPropertyController = new DisplayPropertyController;
            
        }
    public function displayAnounce(){
      
          $rows = self::$DisplayPropertyController->DisplayPropertyController();

          foreach($rows as $row ){


            
          }



    }

}