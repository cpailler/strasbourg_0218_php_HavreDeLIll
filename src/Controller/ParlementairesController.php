<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 11/03/18
 * Time: 16:07
 */

namespace Controller;

use Model\ParlementairesManager;

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
        return $this->twig->render('Parlementaires/Parlementaires.html.twig');
    }

  }
