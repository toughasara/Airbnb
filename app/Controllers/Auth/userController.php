<?php 

namespace App\Controllers\Auth;

use App\Core\Session;
use App\Core\Validator;
use App\Core\Error;
// controller pour redireger avec twig (controller)
use App\Core\view;
// faire la redirection a partir de role
use App\Core\Redirect; 

use App\Classes\Role;
use App\Classes\User;
use App\Models\Auth\UserModel;

use Twig\Environment;
use Twig\Loader\FilesystemLoader;

use Google\Client;
use Google\Service\Oauth2 as Google_Service_Oauth2;

class userController
{

    protected $twig;
    private $userModel;

    public function __construct()
    {
        $this->userModel = new UserModel();
        $loader = new FilesystemLoader(__DIR__ . '/../../Views');
        $this->twig = new Environment($loader, [
            'cache' => false,
        ]);
    }

    // login 
    public function connectez()
    {
        $client = new Client;

        $client->setClientId("735576740631-l6ff1ajkiuij5m9lkk76visuq1l0mh0e.apps.googleusercontent.com");
        $client->setClientSecret("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");
        $client->setRedirectUri("http://localhost:85/contenuinscription");

        $client->addscope("email");
        $client->addscope("profile");

        $authUrl = $client->createAuthUrl();

        echo $this->twig->render('Auth/login.twig', [
            'authUrl' => $authUrl
        ]);
        
        // echo $this->twig->render('Auth/register.twig', $authUrl);
        exit;
    }

    // login 
    public function pagehome()
    {
        // login avec google
        if ($_SERVER['REQUEST_METHOD'] === 'Get'){

            $client = new Client;

            $client->setClientId("735576740631-l6ff1ajkiuij5m9lkk76visuq1l0mh0e.apps.googleusercontent.com");
            $client->setClientSecret("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");
            $client->setRedirectUri("http://localhost:85/contenuinscription");

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

            $oauth = new Google_Service_Oauth2($client);

            $userinfo = $oauth->userinfo->get();

            $email = $userinfo->email;

            $user = new User(null, null, null, $email, null, null, null, null);

            $fiundUser = $this->userModel->findUserByEmail($user);

            if ($fiundUser)
            {
                Redirect::redirectPageHome($fiundUser);
            } 
            else
            {
                Error::erreurgoogle();
                echo $this->twig->render('Auth/login.twig', [
                    'authUrl' => $authUrl,
                    'errors' => $_SESSION['error'] ?? null,
                ]);
                unset($_SESSION['error']); 
            }
        }
        
        // login pour formulaire
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = $_POST['email'] ?? '';
            $password = $_POST['password'] ?? '';

            $user = new User(null, null, null, $email, $password, null, null, null);

            if (!Validator::validlogin($user))
            {
                echo $this->twig->render('Auth/login.twig', [
                    'authUrl' => $authUrl,
                    'errors' => $_SESSION['error'] ?? null,
                    'email' => $email,
                ]);
                unset($_SESSION['error']);
                return;
            }

            $fiundUser = $this->userModel->findUserByEmail($user);

            if ($fiundUser && password_verify($password, $fiundUser->getPassword()))
            {
                Redirect::redirectPageHome($fiundUser);
            }
            else
            {
                Error::affichiererreur();
                echo $this->twig->render('Auth/login.twig', [
                    'authUrl' => $authUrl,
                    'errors' => $_SESSION['error'] ?? null,
                ]);
                unset($_SESSION['error']); 
            }
        } else {
            echo $this->twig->render('Auth/register.twig', [
                'authUrl' => $authUrl
            ]);
        }
    }

    // inscription via formulaire
    public function register()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $first_name = $_POST['first_name'] ?? '';
            $last_name = $_POST['last_name'] ?? '';
            $email = $_POST['email'] ?? '';
            $password = $_POST['password'] ?? '';
            $phone_number = $_POST['phone_number'] ?? '';
            $role = $_POST['role'] ?? 'TRAVELER'; // role par defeut

            $role = new Role(null, $role);
            $user = new User(null, $role, $first_name, $last_name, $email, $password, $phone_number, null, 'active');

            $fiundUser = $this->userModel->findUserByEmail($user);

            if ($fiundUser)
            {
                Error::findemail();
            }

            if (!Validator::validRegistration($user)) {
                echo $this->twig->render('Auth/register.twig', [
                    'errors' => $_SESSION['error'] ?? null,
                    'authUrl' => $authUrl
                ]);
                unset($_SESSION['error']);
                return;
            }

            if ($this->userModel->createUser($user)) {
                echo $this->twig->render('Auth/login.twig', [
                    'authUrl' => $authUrl
                ]);
            } 
            else {
                Error::affichiererreur();
                echo $this->twig->render('Auth/register.twig', [
                    'errors' => $_SESSION['error'] ?? null,
                    'authUrl' => $authUrl
                ]);
                unset($_SESSION['error']);
            }
        } else {
            $client = new Client;
            $client->setClientId("735576740631-l6ff1ajkiuij5m9lkk76visuq1l0mh0e.apps.googleusercontent.com");
            $client->setClientSecret("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");
            $client->setRedirectUri("http://localhost:85/contenuinscription");
            $client->addscope("email");
            $client->addscope("profile");
            $authUrl = $client->createAuthUrl();

            echo $this->twig->render('Auth/register.twig', [
                'authUrl' => $authUrl
            ]);
        }
    }

    // inscription via Google 
    public function contenuinscription()
    {
        $client = new Client;
        $client->setClientId("735576740631-l6ff1ajkiuij5m9lkk76visuq1l0mh0e.apps.googleusercontent.com");
        $client->setClientSecret("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");
        $client->setRedirectUri("http://localhost:85/contenuinscription");

        if (!isset($_GET["code"])) {
            die("Error: coode kayn.");
        }

        $token = $client->fetchAccessTokenWithAuthCode($_GET["code"]);

        if (isset($token['error'])) {
            die("Google OAuth Error: " . $token['error']);
        }

        if (!isset($token['access_token'])) {
            die("Error: Access token not received.");
        }

        $client->setAccessToken($token['access_token']);

        $oauth = new Google_Service_Oauth2($client);
        $userinfo = $oauth->userinfo->get();

        $first_name = $userinfo->given_name;
        $last_name = $userinfo->family_name;
        $email = $userinfo->email;

        $user = new User(null, null, $first_name, $last_name, $email, null, null, null, null);
        $fincAccount = $this->userModel->findUserByEmail($user);

        if (!$fincAccount) {
            // Stocker les données dans la session
            Session::set('google_user', [
                'first_name' => $first_name,
                'last_name' => $last_name,
                'email' => $email,
            ]);
            echo $this->twig->render('Auth/contenuinscri.twig');
        } else {
            Session::createUserSession($fincAccount);
            Redirect::redirectPageHome($fincAccount);
        }
    }

    // completer inscription via Google
    public function completeRegistration()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $googleUser = Session::get('google_user');

            $first_name = $googleUser['first_name'];
            $last_name = $googleUser['last_name'];
            $email = $googleUser['email'];

            $password = $_POST['password'] ?? '';
            $confirm_password = $_POST['confirm_password'] ?? '';
            $role_title = $_POST['role'] ?? 'TRAVELER'; // Rôle par défaut

            // Valider les données
            if ($password !== $confirm_password) {
                Error::passwordMismatch();
                echo $this->twig->render('Auth/contenuinscri.twig', [
                    'errors' => $_SESSION['error'] ?? null,
                    'user' => [
                        'first_name' => $first_name,
                        'last_name' => $last_name,
                        'email' => $email
                    ]
                ]);
                unset($_SESSION['error']);
                return;
            }

            if (Validator::validPassword($password)) {
                dump("nooo valid");
                Error::passwordinvalid();
                echo $this->twig->render('Auth/contenuinscri.twig', [
                    'errors' => $_SESSION['error'] ?? null
                ]);
                // unset($_SESSION['error']);
                return;
            }

            $role = new Role(null, $role_title);
            $fiundUser = new User(null, $role, $first_name, $last_name, $email, $password, null, null, 'active');
            
            if ($this->userModel->createUser($fiundUser)) {
                $fiundUser = $user;
                Redirect::redirectPageHome($fiundUser);
            } 
            else {
                Error::affichiererreur();
                echo $this->twig->render('Auth/contenuinscri.twig', [
                    'errors' => $_SESSION['error'] ?? null,
                ]);
                // unset($_SESSION['error']);
            }
        }
    }




}
