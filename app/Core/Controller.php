<?php 

namespace App\Core\Controllers;


class HomeController
{

    public function index()
    {

        include dirname(__DIR__) . '/View/pages/home.php';

        exit;

    }

    public function register()
    {

        include './App/View/Front/Auth/register.php';

        exit;

    }



    // public function getUserById(){


    //     if (isset($_POST['userId'])) {
    //     $iduser = $_POST['userId'];
    //     }


    // // galtlik sara lmrakxiya bnt azli li sakna gdam m6 nasiraho lahlihdahom lala makayninx ma3lina:
    

    // $userModel= new usermodel();


    // $userdata =  $userModel->getUserByIdModel($iduser);



    // }


  // <form action="home" method="POST">

  //   <input type="text" name="userId" hidden value="{{id}}">

  //   <button type="submit"></button>
  // </form>



}