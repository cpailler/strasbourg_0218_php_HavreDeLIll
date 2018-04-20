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
        $datasorigin = [];
        $error=false;
        $select=["","","",false];
        $i=0;
        foreach ($chambres as $diapo => $data) {
            if (!isset($datasorigin[$data['chambres_id']])) {
                $i++;
                $datasorigin += [$i => array(
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

                $datasorigin[$data['chambres_id']]['urlImage']+= [$data['id'] => $data['urlImage']];

            }

        }
        $datas=$datasorigin;
        $i=0;
        if (isset($_POST['submit'])){

            $select[0]=$_POST['style'];
            $select[1]=$_POST['salleDeBain'];
            $select[2]=$_POST['literie'];
            if (isset($_POST['PMR'])){
                $select[3]=true;
            }

            $datas=[];
            foreach ($datasorigin as $data){
                if ((($_POST['style']=='')||($_POST['style']==$data['style']))&&
                    (($_POST['salleDeBain']=='')||($_POST['salleDeBain']==$data['salleDeBain']))&&
                    (($_POST['literie']=='')||($_POST['literie']==$data['literie']))&&
                    ((isset($_POST['PMR'])&&($data['accessibilite']=='Oui'))||(!isset($_POST['PMR'])))){
                    $i++;
                    $datas+=[$i=>$data];
                }
            }
            if (empty($datas)){
                $datas=$datasorigin;
                $error=true;
            }
        }


            //var_dump($datas[$data['chambres_id']]['urlImage']);

        return $this->twig->render('Chambres/Chambres.html.twig', ['chambres' => $chambres, 'datas' => $datas, 'error'=> $error, 'select'=> $select]);

    }

}
