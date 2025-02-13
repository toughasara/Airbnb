<?php

namespace App\Core;

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
        $role = $fiundUser->getRole();

        switch ($role) {
            case 'ADMIN':
                echo $this->twig->render('Back/index.twig', [
                ]);
                break;
            case 'OWNER':
                echo $this->twig->render('Front/index.twig', [
                ]);
                break;
            case 'TRAVELER':
                echo $this->twig->render('Front/index.twig', [
                ]);
                break;
            default:
                echo $this->twig->render('errors/404.twig', [
                    'message' => 'Rôle non reconnu.'
                ]);
                break;
        }
        exit;
    }
}