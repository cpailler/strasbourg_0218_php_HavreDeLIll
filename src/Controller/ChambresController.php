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
 * Class AccueilController
 * @package Controller
 */
class ChambresController extends AbstractController
{

    /**
     * @return string
     */
  public function index()
    {


        return $this->twig->render('Chambres/Chambres.html.twig', ['chambres' => $chambre]);
    }

  }
