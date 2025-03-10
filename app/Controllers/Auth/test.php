<?php

namespace App\Controllers;
use App\Core\Controller;
use App\Models\UserModel;
use App\Core\Sessions;
use App\Core\Redirect;
use App\Core\ErrorsHandling;
use App\Core\Validation;
use App\Classes\User;
use Dotenv\Dotenv;

use Google\Client;
use Google\Service\Oauth2 as Google_Service_Oauth2;


class AuthController extends Controller
{

    private $userModel;

    public function __construct()
    {
        $this->userModel = new userModel();
    }

    public function getLoginPage(): void
    {
        $dotenv = Dotenv::createImmutable(dirname(__DIR__) . '/../');
        $dotenv->load();
        // Google OAuth credentials
        $clientID = $_ENV['CLIENTID'];
        $clientSecret = $_ENV['CLIENTSECRET'];
        $redirectUri = $_ENV['REDIRECTURL'];

        // Create Google Client
        $client = new Client;
        $client->setClientId($clientID);
        $client->setClientSecret($clientSecret);
        $client->setRedirectUri($redirectUri);
        $client->addScope("email");
        $client->addScope("profile");

        $authUrl = $client->createAuthUrl();

        $this->view('auth/login', $authUrl);
    }

    public function getSingUpPage()
    {
        $this->view('auth/singUp');
    }



    public function postLoginPage($user = '')
    {
        if (!$user) {
            $user = new User($_POST['email'], $_POST['password']);
        }
        $result = $this->userModel->findUserByEmailPassword($user);
        if ($result instanceof User) {
            Sessions::createUserSession($result);
            $this->userModel->connectUser($result);
            Redirect::redirectAfterLogin($result);
        } else {
            ErrorsHandling::handlLoginError();
            return false;
        }
    }

    public function postSingUpPage($user = ''): void
    {
        if (!$user) {
            $user = new User($_POST['email'], $_POST['password'], $_POST['userName'], $_POST['role']);
        }
        $result = Validation::valideSingUp($user);
        if ($result) {
            $this->getLoginPage();
        }
    }

    public function postLoginWithGoogle(): void
    {
        $dotenv = Dotenv::createImmutable(dirname(__DIR__) . '/../');
        $dotenv->load();
        $clientID = $_ENV['CLIENTID'];
        $clientSecret = $_ENV['CLIENTSECRET'];
        $redirectUri = $_ENV['REDIRECTURL'];

        // Create Google Client
        $client = new Client;
        $client->setClientId($clientID);
        $client->setClientSecret($clientSecret);
        $client->setRedirectUri($redirectUri);
        $client->addScope("email");
        $client->addScope("profile");

        if (!isset($_GET["code"])) {
            die("Error: No authorization code received.");
        }

        $token = $client->fetchAccessTokenWithAuthCode($_GET["code"]);

        if (isset($token['error'])) {
            die("Google OAuth Error: " . $token['error']);
        }

        if (!isset($token['access_token'])) {
            die("Error: Access token not received.");
        }

        $client->setAccessToken($token['access_token']);

        $google_oauth = new Google_Service_Oauth2($client);

        $google_account_info = $google_oauth->userinfo->get();
        $fullName = $google_account_info->name;
        $email = $google_account_info->email;
        $password = $google_account_info->id;
        $pic = $google_account_info->picture;
        $user = new User($email, $password, $fullName, '', '', $pic);
        $ifHasAccount = $this->postLoginPage($user);
        if (!$ifHasAccount) {
            $user = [
                'fullName' => $fullName,
                'email' => $email,
                'pic' => $pic
            ];
            $this->view('auth/form', $user);
        }
    }

}