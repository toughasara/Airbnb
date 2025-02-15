<?php


namespace App\Core;


// use App\Core\Controller;


class Router
{

    public static $Routes = [];


    public static function get($requestURI, $action)
    {

        self::$Routes['get'][$requestURI] = $action;
    }

    public static function post($requestURI, $action)
    {

        self::$Routes['post'][$requestURI] = $action;
    }


    public static function put($requestURI, $action)
    {

        self::$Routes['put'][$requestURI] = $action;
    }


    // hendler routes :
    public static function matcheRoutes($requestURI, $requestmethod){


        //  home

        $requestURI = str_replace('index.php', '', $requestURI);
        $requestURI = str_replace('Airbnb/public', '', $requestURI);
        $requestURI = trim($requestURI, '/');

        if (isset(self::$Routes[$requestmethod][$requestURI])) {

            $action = self::$Routes[$requestmethod][$requestURI];


            if (is_callable($action)) {
                return call_user_func($action);
            }


            if (is_string($action)) {
            
                // logic ;
                [$controller, $method] = explode('@', $action);
                
                $controller = "App\\Controllers\\$controller";


                if (!class_exists($controller)) {

                echo 'class not exist';

                exit;
                }


                if (!method_exists($controller, $method)) {
                echo 'method not exist';
                exit;
                }


                $objectController = new $controller();


                return $objectController->$method();


            }
        } else {

            echo "test error 404.php";
        }

    }

}
