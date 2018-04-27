<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 11/03/18
 * Time: 16:07
 */

namespace Controller;

//use Model\Login;
//use Model\LoginManager;
use Model\AdminManager;

/**
 * Class AccueilController
 * @package Controller
 */
class LoginController extends AbstractController
{

    /**
     * @return string
     */
    public function index()
    {
        $adminManager = new AdminManager();
        $admin = $adminManager->findAll();

        session_start ();
        // on enregistre les paramètres de notre client comme variables de session ($login et $pwd)
       $mdp = md5($_POST['password']);

        if (isset($_POST['user'])&& isset($_POST['password'])) {
            $_SESSION['user'] = $_POST['user'];
            $_SESSION['password'] = $mdp;


        }
        $_SESSION['name'] = $admin['0']['name'];
        $_SESSION['pwd'] = $admin['0']['password'];

// mot de passe = olivier67
        $errors = [];
        if ($_SERVER["REQUEST_METHOD"] === 'POST') {

            if (!isset($_POST['user']) || $_POST['user']=='') {
                $errors['user'] = "Veuillez saisir votre nom d'utilisateur";
            }

            if (!isset($_POST['password']) || empty($mdp)) {
                $errors['password'] = "Veuillez saisir votre mot de passe";
            }

            elseif ($_POST['user'] != $admin['0']['name'] && $mdp != $admin['0']['password']) {
                $errors['login'] = "Votre mot de passe ou votre nom d'utilisateur est incorrect";
            }
            elseif ($_POST['user'] === $admin['0']['name'] && $mdp === $admin['0']['password'] ) {
                header('Location: /Administration');
            }
        }
        return $this->twig->render('Login/Login.html.twig', ['admin' => $admin, 'errors' => $errors]);


    }
}