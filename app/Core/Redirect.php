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
        $loader = new FilesystemLoader(__DIR__ . '/../Views');
        $this->twig = new Environment($loader, [
            'cache' => false, 
        ]);
    }

    public function redirectPageHome($fiundUser)
    {
        $role = $fiundUser->getRole()->getId();

        switch ($role) {
            case 3:
                echo $this->twig->render('Back/dashboard.twig');
                break;
            case 2:
                echo $this->twig->render('Front/housingoffers.twig');
                break;
            case 1:
                echo $this->twig->render('Front/kray.php');
                break;
            default:
                echo $this->twig->render('errors/404.twig');
                break;
        }
        exit;
    }
}