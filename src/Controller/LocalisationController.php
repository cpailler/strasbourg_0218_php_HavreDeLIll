<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 11/03/18
 * Time: 16:07
 */

namespace Controller;


use Model\LocalisationManager;

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
        $LocalisationManager = new LocalisationManager();
        $Local = $LocalisationManager->findAll();


        return $this->twig->render('Localisation/Localisation.html.twig', ['Local' => $Local[0]]);
    }

  }
