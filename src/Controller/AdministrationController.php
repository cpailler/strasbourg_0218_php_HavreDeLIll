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

use Model\DiapoAccueilManager;

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
        session_start();
        if (!isset($_SESSION['user']) && !isset($_SESSION['password']) ) {
            header('Location: /Login');
        }


        return $this->twig->render('Administration/Administration.html.twig');
    }



    public function DiapoAccueil()
    {



        $diapoManager = New DiapoAccueilManager();
        var_dump($_POST);
        var_dump($_FILES);

        if (isset($_POST['send'])) {
            $n = count($_FILES['file']['name']);

            $message = "";

            for ($i = 0; $i < $n; $i++) {

                // Vérifie qu'un fichier a bien été envoyé
                if (!empty($_FILES['file']['name'][$i])) {
                    // Vérification du type de fichier
                    $typeMime = mime_content_type($_FILES['file']['tmp_name'][$i]);
                    if (in_array($typeMime, ['image/jpeg', 'image/png', 'image/jpg', 'image/gif'])) {

                        // Vérification taille du fichier
                        $size = filesize($_FILES['file']['tmp_name'][$i]);

                        if ($size > 2000000) {
                            $message .= "Le fichier ne doit pas dépasser 2Mo<br>";
                        } else {
                            // Récupération de l'extension du fichier (fin de la chaîne) :
                            $extensionDuFichier = strrchr($_FILES['file']['name'][$i], ".");

                            // Définition d'un nom unique :
                            $uniqueId = uniqid('/assets/images/image') . $extensionDuFichier;

                            // Emplacement temporaire du fichier uploadé :
                            $cheminEtNomTemporaire = $_FILES['file']['tmp_name'][$i];

                            // Nouvel emplacement du fichier :
                            $deplacementOK = move_uploaded_file($cheminEtNomTemporaire, substr($uniqueId,1,strlen($uniqueId)));


                            //Création de l'élément dans la base de donnée

                            $ok = $diapoManager->insert(['urlImage' => $uniqueId]);
                            var_dump($ok);

                            if ($deplacementOK) {
                                $message .= "Upload OK : " . $uniqueId ;
                            } else {
                                $message .= "Pas upload";
                            }
                        }
                    } else {
                        $message .= "Il faut un fichier jpeg";
                    }
                } else {
                    $message .= "Veuillez sélectionner un fichier";
                }
            }
        } else {
            $message = "";
        }




        $diapos = $diapoManager->findAll();





        foreach ($diapos as $diapo){
            if (isset($_POST[$diapo['id']])) {
                $diapoManager->delete($diapo['id']);
                $path = substr($diapo['urlImage'],1,strlen($diapo['urlImage']));
                unlink($path);
            }

        }

        $diapos = $diapoManager->findAll();







            return $this->twig->render('Administration/DiapoAccueilAdmin.html.twig', ['diapos' => $diapos, 'message' => $message]);
        }
    }