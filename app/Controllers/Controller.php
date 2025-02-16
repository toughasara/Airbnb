<?php 

namespace App\Controllers;

use Twig\Environment;
use Twig\Loader\FilesystemLoader;
use App\Controllers\Front\Travler\DisplayPropertyController;
use App\Controllers\Front\Owner\AddAnnounceController;
class Controller
{

    protected $twig;
    public static $DisplayPropertyController ;
    protected static $addannounce ;
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
        if(isset($_POST['addAnnounce'])){
            $id =1;
            if(!empty($_POST["title"])||!empty($_POST["description"])||!empty($_POST["category"])||!empty(["price_per_night"])||!empty($_POST["max_guests"])||!empty($_POST["amenities"])||!empty($_POST["photos"])||!empty($_POST["city"])||!empty($_POST["country"])){
                $addObj = new AddAnnounceController;
                $addObj->addAnnounce($id,$_POST["title"],$_POST["description"],$_POST["category"],$_POST["price_per_night"],$_POST["max_guests"],$_POST["amenities"],$_POST["photos"],$_POST["address"],$_POST["city"],$_POST["country"]);
                

            }else{

                echo "fill all the inputs";

            }


        }

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
    // public function OwnerRequestsController()
    // {

    //     echo $this->twig->render('../Controllers/Front/Owner/OwnerRequestsController.php');
    //     exit;

    // }
    



}



