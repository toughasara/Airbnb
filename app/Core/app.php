<?php

namespace App\Core;

use App\Core\Router;

// require_once  '../../routes/web.php';

class App
{


    public static function run()
    {
        
        
        $requestURI = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);


        // index.php/home?id=9
        // it willbecomme ---> index.php/home

        


        $requestmethod = strtolower($_SERVER['REQUEST_METHOD']);

        // GET

        // ---------------------------


        // path = index.php/home
        // methode ==> GET,POST,PUT,PATCH,DELETE
        
        Router::matcheRoutes($requestURI, $requestmethod);
        
    }

    }