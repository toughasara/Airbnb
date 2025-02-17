<?
namespace App\Controllers\Back;

use App\Controllers\ControllerAd;
use App\Models\Back\UserModel;

class UserController extends ControllerAd
{
    protected $userModel;

    public function construct()
    {
        parent::construct();
        $this->userModel = new UserModel();
    }
    public function index()
    {
        $users = $this->userModel->getAllUsers();
        $this->render('Back/users.twig', [
            'title' => 'Dashboard',
            'users' => $users

        ]);
    }
}
