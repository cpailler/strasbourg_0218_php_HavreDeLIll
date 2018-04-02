<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 11/03/18
 * Time: 16:07
 */

namespace Controller;

use Model\Accueil;
use Model\AccueilManager;

/**
 * Class AccueilController
 * @package Controller
 */
class AccueilController extends AbstractController
{

    /**
     * @return string
     */
  public function index()
    {
        $accueilManager = new AccueilManager();
        $accueil = $accueilManager->findAll();

        return $this->twig->render('Pages/accueil.html.twig', ['accueil' => $accueil]);
    }

  }
