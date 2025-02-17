<?php

namespace App\Core;

use App\Classes\Role; 
use App\Classes\User;
use App\Core\Controller;
use Twig\Environment;
use Twig\Loader\FilesystemLoader;

class Redirect
{
    protected $twig;

    public function __construct()
    {
        $loader = new FilesystemLoader(__DIR__ . '/../../Views');
        $this->twig = new Environment($loader, [
            'cache' => false, 
        ]);
    }
    
    public static function redirectPageHome($fiundUser)
    {
        $role = $fiundUser->getRole()->getId();
        dump($role);

        switch ($role) {
            case '3':
                echo $this->twig->render('Back/index.twig');
                break;
            case '2':
                echo $this->twig->render('Front/index.twig');
                break;
            case '1':
                echo $this->twig->render('Front/index.twig');
                break;
            default:
                echo $this->twig->render('errors/404.twig');
                break;
        }
        exit;
    }
}