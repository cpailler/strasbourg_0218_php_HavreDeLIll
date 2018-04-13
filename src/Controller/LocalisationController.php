<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 11/03/18
 * Time: 16:07
 */

namespace Controller;

//use Model\Accueil;
//use Model\AccueilManager;

/**
 * Class LocalisationController
 * @package Controller
 */
class LocalisationController extends AbstractController
{

    /**
     * @return string
     */
  public function index()
    {


        return $this->twig->render('Localisation/Localisation.html.twig'/*, ['localisation' => $local]*/);
    }

  }
