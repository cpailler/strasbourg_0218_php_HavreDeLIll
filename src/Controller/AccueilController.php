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
use Model\DiapoAccueilManager;

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


        $diapoAccueilManager = new DiapoAccueilManager();
        $diapoAccueil = $diapoAccueilManager->findAll();


        return $this->twig->render('Accueil/Accueil.html.twig', ['accueil' => $accueil,'diapoAccueil' => $diapoAccueil]);
    }

  }

