<?php 

namespace App\Controllers;

use Twig\Environment;
use Twig\Loader\FilesystemLoader;

class ControllerAd 
{
    protected $twig;

    public function __construct()
    {
        $loader = new FilesystemLoader(__DIR__ . '/../Views'); // مجلد القوالب
        $this->twig = new Environment($loader, [
            'cache' => false,
            'debug' => true
        ]);
    }

    public function render($template, $data = [])
    {
        echo $this->twig->render($template, $data);
        exit;
    }

    public function index()
    {
        $this->render('index.twig');
    }

    public function register()
    {
        $this->render('Auth/register.twig');
    }

    public function housingoffer()
    {
        $this->render('Front/housingoffers.twig');
    }

    public function articledescription()
    {
        $this->render('Front/articledescription.twig');
    }

   
}
