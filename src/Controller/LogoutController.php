<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 11/03/18
 * Time: 16:07
 */

namespace Controller;



/**
 * Class AccueilController
 * @package Controller
 */
class LogoutController extends AbstractController
{

    /**
     * @return string
     */
  public function index()
    {
        session_start();
        session_destroy();
        header('Location: /Login');

    return $this->twig->render('Logout/Logout.php', ['Logout' => $log]);
    }

  }
