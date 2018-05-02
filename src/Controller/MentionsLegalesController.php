<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 11/03/18
 * Time: 16:07
 */

namespace Controller;




/**
 * Class MentionsLegalesController.php
 * @package Controller
 */
class MentionsLegalesController extends AbstractController
{

    /**
     * @return string
     */
    public function index()
    {



        return $this->twig->render('MentionsLegales/MentionsLegales.html.twig');
    }

}
