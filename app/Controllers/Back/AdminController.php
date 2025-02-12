<?php 

namespace App\Controllers\Back;

class AdminController{
  
    public function dashboard()
    {

        include __DIR__. '/../../Views/Back/dashboard.php';

        exit;

    }
    public function getAllUsers() {
        $userModel = new UserModel();
        $users = $userModel->getAllUsers();
        $this->view('admin/proprelated/users', ['users' => $users]);
    }
    public function getAllAnnonces() {
        $annonces = $this->annonceModel->getAllAnnonces();
        $this->view('admin/proprelated/annonces', ['annonces' => $annonces]);
    }
   


}



?>

