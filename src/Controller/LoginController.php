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
        $adminManager=new AdminManager();
        $admin = $adminManager->findAll();

        return $this->twig->render('Login/Login.html.twig', ['admin' => $admin]);
    }

  }
