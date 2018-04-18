<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 11/03/18
 * Time: 16:07
 */

namespace Controller;

use Model\ChambreManager;

/**
 * Class AccueilController
 * @package Controller
 */
class ChambreController extends AbstractController
{

    /**
     * @return string
     */
  public function index()
    {
        $chambreManager = new ChambreManager();
        $chambres = $chambreManager->findAll();
        var_dump($chambres);

        




    return $this->twig->render('Chambres/Chambres.html.twig'/*, ['chambres' => $chambres]*/);

    }

  }
