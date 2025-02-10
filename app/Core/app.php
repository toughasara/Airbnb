<?php

namespace App\Core;

use App\Core\Router;

require_once  dirname(__DIR__).'/../routes/web.php';

class App
{


    public static function run()
    {
        
        
        $requestURI = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);


        $requestmethod = strtolower($_SERVER['REQUEST_METHOD']);

        
        Router::matcheRoutes($requestURI, $requestmethod);
        
    }

    }