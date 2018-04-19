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
        $datas = [];
        $i=0;
        foreach ($chambres as $diapo => $data) {
            if (!isset($datas[$data['chambres_id']])) {
                $i++;
                $datas += [$i => array(
                    'id' => $data['chambres_id'],
                    'titre' => $data['titre'],
                    'texte' => $data['texte'],
                    'prix' => $data['prix'],
                    'style' => $data['style'],
                    'literie' => $data['literie'],
                    'accessibilite' => $data['accessibilite'],
                    'salleDeBain' => $data['salleDeBain'],
                    'urlImage' => array($data['id'] => $data['urlImage']))];

                } else {

                $datas[$data['chambres_id']]['urlImage']+= [$data['id'] => $data['urlImage']];

            }
            }

            //var_dump($datas[$data['chambres_id']]['urlImage']);

        return $this->twig->render('Chambres/Chambres.html.twig', ['chambres' => $chambres, 'datas' => $datas]);

    }

}
