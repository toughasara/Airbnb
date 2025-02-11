<?php 

namespace App\Controllers;

use Twig\Environment;
use Twig\Loader\FilesystemLoader;

class Controller
{

    protected $twig;

    public function __construct()
    {
        $loader = new FilesystemLoader(__DIR__ . '/../Views');
        $this->twig = new Environment($loader, [
            'cache' => false,
        ]);
    }
    
    public function index()
    {
                
        echo $this->twig->render('index.twig');
        exit;

    }

    public function register()
    {

        echo $this->twig->render('Auth/register.twig');
        exit;

    }
    public function housingoffer()
    {

        echo $this->twig->render('Front/');
        exit;

    }





}


