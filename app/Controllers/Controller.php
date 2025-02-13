<?php 

namespace App\Controllers;

use Twig\Environment;
use Twig\Loader\FilesystemLoader;
use App\Controllers\Front\Travler\DisplayPropertyController;

class Controller
{

    protected $twig;
    public static $DisplayPropertyController ;

    public function __construct()
    {

         self::$DisplayPropertyController = new DisplayPropertyController;
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

        $rows = self::$DisplayPropertyController->DisplayPropertyController();
        
        echo $this->twig->render('Front/housingoffers.twig',
        ['rows'=>$rows,
        ]);
        exit;

    }
    public function articledescription()
    {

        echo $this->twig->render('Front/articledescription.twig');
        exit;

    }   
     public function addannounce()
    {

        echo $this->twig->render('Front/owner/create_announcement.twig');
        exit;

    }
    public function dashboardowner()
    {

        echo $this->twig->render('Front/owner/owner_dashboard.twig');
        exit;

    }
    public function updateannounce()
    {

        echo $this->twig->render('Front/owner/update_announcement.twig');
        exit;

    }
    




}



