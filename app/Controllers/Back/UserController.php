<?
namespace App\Controllers\Back;

use App\Controllers\Controller;
use App\Models\Back\UserModel;

class UserController extends Controller
{
    protected $userModel;

    public function __construct()
    {
        parent::__construct();
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
