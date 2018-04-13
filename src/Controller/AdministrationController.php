<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 11/03/18
 * Time: 16:07
 */

namespace Controller;

use Controller\Date\Month;
use Model\ReservationManager;

/**
 * Class ReservationController
 * @package Controller
 */
class AdministrationController extends AbstractController
{


    /**
     * @return string
     */
    public function index()
    {
        //$accueilManager = new AccueilManager();
        //$accueil = $accueilManager->findAll();


        return $this->twig->render('Administration/Administration.html.twig'/*, ['accueil' => $infos]*/);
    }

}
