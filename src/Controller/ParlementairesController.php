<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 11/03/18
 * Time: 16:07
 */

namespace Controller;

use Model\ParlementairesManager;
use Model\ChambreManager;

/**
 * Class AccueilController
 * @package Controller
 */
class ParlementairesController extends AbstractController
{

    /**
     * @return string
     */
  public function index()
    {
        $ParlementairesManager = new ParlementairesManager();
        $Articles =  $ParlementairesManager->findAll();

        $ChambreManager = new ChambreManager();
        $chambres = $ChambreManager->findAll();


        return $this->twig->render('Parlementaires/Parlementaires.html.twig',['Articles' => $Articles, 'chambres' => $chambres]);
    }

  }
