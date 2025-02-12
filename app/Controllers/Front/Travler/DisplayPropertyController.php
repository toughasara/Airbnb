<?php 
namespace App\Controllers\Front\Travler ;


use App\Models\Front\DisplayDataModele;


class  DisplayPropertyController
{

    
    
    private static $DisplayDataModele ;

    public function __construct(){

        self::$DisplayDataModele = new DisplayDataModele ; 

    }
        
    public static function DisplayPropertyController(){

        $rows = self::$DisplayDataModele->displayProperty();
        return $rows;

    
        
    }

    
}
