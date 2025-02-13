<?php 

namespace App\Controllers\Auth;

use App\Core\Session;
use App\Core\Validator;
use App\Core\Error;
// controller pour redireger avec twig (controller)
use App\Core\view;
// faire la redirection a partir de role
use App\Core\Redirect; 

use App\Classes\User;
use App\Models\UserModel;

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

    // inscription
    public function register()
    {
        // <!-- {"web":{"client_id":"735576740631-l6ff1ajkiuij5m9lkk76visuq1l0mh0e.apps.googleusercontent.com",
        // "project_id":"airbnb-450610","auth_uri":"https://accounts.google.com/o/oauth2/auth",
        // "token_uri":"https://oauth2.googleapis.com/token",
        // "auth_provider_x509_cert_url":"https://www.googleapis.com/oauth2/v1/certs",
        // "client_secret":"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",
        // "redirect_uris":["http://localhost:85/login"]}} -->

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
                ErrorsHandling::erreurgoogle();
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

            if (!Validation::validlogin($user))
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
                ErrorsHandling::affichiererreur();
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

    // contunuer l'inscription apret google pour entrer role et mot de passe 
    public function contenuinscription()
    {

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

        $first_name = $userinfo->given_name;
        $last_name = $userinfo->family_name;
        $email = $userinfo->email;
        $password = $userinfo->id;
        $pic = $userinfo->picture;

        $user = new User(null, $first_name, $last_name, $email, $password, null, null, "active");
        $fincAccount = $this->findByEmail($user);

        if (!$fincAccount) {
            $user = [
                'first_name' => $first_name,
                'last_name' => $last_name,
                'email' => $email,
                'password' => $password,
                'pic' => $pic
            ];
            echo $this->twig->render('Auth/contenuinscri.twig', [
                'user' => $user
            ]);
        }

    }

    // public function findByEmail($user)
    // {
    //     if (!$user) {
    //         $user = new User($_POST['email'], $_POST['password']);
    //     }
    //     $result = $this->userModel->findUserByEmailPassword($user);
    //     if ($result instanceof User) {
    //         Sessions::createUserSession($result);
    //         $this->userModel->connectUser($result);
    //         Redirect::redirectAfterLogin($result);
    //     } else {
    //         ErrorsHandling::handlLoginError();
    //         return false;
    //     }
    // }




}
