<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 11/03/18
 * Time: 16:07
 */

namespace Controller;


use Controller\Calendar\Month;
use Model\AccueilManager;
use Model\Accueil;
use Model\ChambreManager;
use Model\DiapoChambreManager;
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
        if (!isset($_SESSION['user']) && !isset($_SESSION['password'])) {
            header('Location: /Login');
        }


        return $this->twig->render('Administration/Administration.html.twig');
    }


    public function DiapoAccueil()
    {

        $diapoManager = New DiapoAccueilManager();

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
                            $deplacementOK = move_uploaded_file($cheminEtNomTemporaire, substr($uniqueId, 1, strlen($uniqueId)));


                            //Création de l'élément dans la base de donnée

                            $ok = $diapoManager->insert(['urlImage' => $uniqueId]);
                            var_dump($ok);

                            if ($deplacementOK) {
                                $message .= "Upload OK : " . $uniqueId;
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

        foreach ($diapos as $diapo) {
            if (isset($_POST[$diapo['id']])) {
                $diapoManager->delete($diapo['id']);
                $path = substr($diapo['urlImage'], 1, strlen($diapo['urlImage']));
                unlink($path);
            }

        }

        $diapos = $diapoManager->findAll();

        return $this->twig->render('Administration/DiapoAccueilAdmin.html.twig', ['diapos' => $diapos, 'message' => $message]);
    }

    public function AdminChambres()
    {

        $chambreManager = new ChambreManager();
        $diapoChambreManager = new DiapoChambreManager();
        $diapos = $diapoChambreManager->findAll();
        $select = "";
        $chambreAModifier = [];

        $error = [];
        $valid = [];
        foreach ($diapos as $diapo) {
            if (isset($_POST[$diapo['id']])) {
                $diapoChambreManager->delete($diapo['id']);
                $path = substr($diapo['urlImage'], 1, strlen($diapo['urlImage']));
                unlink($path);
                $valid[] = "Image supprimée avec succès";
            }

        }
        $diapos = [];
        //Selection de la chambre

        if (isset($_POST['chambre'])&&$_POST['chambre']!=""){
            $select = $_POST['chambre'];
            $chambreAModifier = $chambreManager->findOneById($_POST['chambre']);
            $diapos = $diapoChambreManager->findByChambreId($_POST['chambre']);
        }

        if (isset($_POST['modifier'])){
            $data = [];
            $id = $_POST['id'];
            $data['titre'] = $_POST['titre'];
            $data['prix'] = $_POST['prix'];
            $data['texte'] = $_POST['texte'];
            $data['style'] = $_POST['style'];
            $data['salleDeBain'] = $_POST['salleDeBain'];
            $data['literie'] = $_POST['literie'];
            if (isset($_POST['PMR'])) {
                $data['accessibilite'] = 'Oui';
            } else {
                $data['accessibilite'] = 'Non';
            }
            $ok = $chambreManager->update($id,$data);
            if (!$ok){
                $error[]="La base de donnée a refusé votre requête, veuillez contacter votre support technique.";
            }
            else {
                $valid[]="Chambre modifiée avec succès";
            }

            //upload des images
            $n = count($_FILES['nouvellesDiapos']['name']);

            for ($i = 0; $i < $n; $i++) {

                // Vérifie qu'un fichier a bien été envoyé
                if (!empty($_FILES['nouvellesDiapos']['name'][$i])) {
                    // Vérification du type de fichier
                    $typeMime = mime_content_type($_FILES['nouvellesDiapos']['tmp_name'][$i]);
                    if (in_array($typeMime, ['image/jpeg', 'image/png', 'image/jpg', 'image/gif'])) {

                        // Vérification taille du fichier
                        $size = filesize($_FILES['nouvellesDiapos']['tmp_name'][$i]);

                        if ($size > 2000000) {
                            $error[] = "Le fichier ne doit pas dépasser 2Mo";
                        } else {
                            // Récupération de l'extension du fichier (fin de la chaîne) :
                            $extensionDuFichier = strrchr($_FILES['nouvellesDiapos']['name'][$i], ".");

                            // Définition d'un nom unique :
                            $uniqueId = uniqid('/assets/images/image') . $extensionDuFichier;

                            // Emplacement temporaire du fichier uploadé :
                            $cheminEtNomTemporaire = $_FILES['nouvellesDiapos']['tmp_name'][$i];

                            // Nouvel emplacement du fichier :
                            $deplacementOK = move_uploaded_file($cheminEtNomTemporaire, substr($uniqueId, 1, strlen($uniqueId)));
                            if ($deplacementOK) {
                                $ok = $diapoChambreManager->insert(['urlImage' => $uniqueId, 'chambres_id' => $id]);
                                if ($ok) {
                                    $valid[] = "Image ajoutée avec succès ";
                                } else {
                                    unlink(substr($uniqueId, 1, strlen($uniqueId)));
                                    $error[] = "Votre image n'as pas pu être enregistrée, si l'erreur persiste, veuillez contacter le service technique";
                                }
                            }

                        }
                    } else {
                        $error[] = "Format d'image non supporté (formats supportés : jpeg, jpg, png, gif)";
                    }
                }
            }
        }
        if (isset($_POST['delete'])) {
            $ok = $chambreManager->delete($_POST['id']);
            if (!$ok) {
                $error[] = "La chambre n'as pas pu être supprimée";
            } else {
                $valid[] = "La chambre a été supprimée avec succès";
            }
        }

        $chambres = $chambreManager->findAll();


        return $this->twig->render('Administration/ChambresAdmin.html.twig', [
            'select' => $select,
            'chambres' => $chambres,
            'chambreAModifier' => $chambreAModifier,
            'diapos' => $diapos,
            'errors' => $error,
            'valids' => $valid]);
    }

    public function ArticlesAccueil()
    {

        $accueilManager = new AccueilManager();
        $accueil = $accueilManager->findAll();

        $error = [];
        $valid = [];
        if (isset($_POST['modifier'])) {
            $data = [];
            $id = $_POST['id'];
            $data['titre'] = $_POST['titre'];
            $data['texte'] = $_POST['texte'];

            // Vérifie qu'un fichier a bien été envoyé
            if (!empty($_FILES['urlImage']['name'])) {
                var_dump($_FILES['urlImage']);
                // Vérification du type de fichier
                $typeMime = mime_content_type($_FILES['urlImage']['tmp_name']);
                if (in_array($typeMime, ['image/jpeg', 'image/png', 'image/jpg', 'image/gif'])) {

                    // Vérification taille du fichier
                    $size = filesize($_FILES['urlImage']['tmp_name']);

                    if ($size > 5000000) {
                        $error[] = "Le fichier ne doit pas dépasser 5Mo";
                    } else {
                        // Récupération de l'extension du fichier (fin de la chaîne) :
                        $extensionDuFichier = strrchr($_FILES['urlImage']['name'], ".");

                        // Définition d'un nom unique :
                        $uniqueId = uniqid('/assets/images/image') . $extensionDuFichier;

                        // Emplacement temporaire du fichier uploadé :
                        $cheminEtNomTemporaire = $_FILES['urlImage']['tmp_name'];

                        // Nouvel emplacement du fichier :
                        $deplacementOK = move_uploaded_file($cheminEtNomTemporaire, substr($uniqueId, 1, strlen($uniqueId)));

                        $data['urlImage'] = $uniqueId;

                    }
                } else {
                    $error[] = "Format d'image non supporté (formats supportés : jpeg, jpg, png, gif)";
                }

            } else {
                $data['urlImage'] = $_FILES['urlImage'];
            }

            $ok = $accueilManager->update($id, $data);
            if (!$ok) {
                $error[] = "La base de donnée a refusé votre requête, veuillez contacter votre support technique.";
            } else {
                $valid[] = "Article modifiée avec succès";
            }
        }

        $accueil = $accueilManager->findAll();

        return $this->twig->render('Administration/ArticlesAccueilAdmin.html.twig', ['accueil' => $accueil]);
    }

    public function NouvelleChambre(){
        $data=[];
        $error=[];
        $valid=[];
        if (isset($_POST['New'])){
            $chambreManager= new ChambreManager();
            $diapoChambreManager=new DiapoChambreManager();
            var_dump($_POST);
            $data = [];
            if ($_POST['titre']!=""){
            }
            else{
                $error[]="veuillez saisir un nom pour la chambre";
            }
            $data['titre']=$_POST['titre'];
            if ($_POST['prix']!=""){
            }
            else{
                $error[]="veuillez saisir un prix pour la chambre";
            }
            $data['prix']=$_POST['prix'];
            if ($_POST['texte']!=""){
            }
            else{
                $error[]="veuillez saisir un texte pour la chambre";
            }
            $data['texte']=$_POST['texte'];
            if ($_POST['style']!=""){
            }
            else{
                $error[]="veuillez selectionner un style pour la chambre";
            }
            $data['style']=$_POST['style'];
            if ($_POST['salleDeBain']!=""){
            }
            else{
                $error[]="veuillez selectionner un type de salle de bain pour la chambre";
            }
            $data['salleDeBain']=$_POST['salleDeBain'];
            if ($_POST['literie']!=""){
            }
            else{
                $error[]="veuillez selectionner le type de lits pour la chambre";
            }
            $data['literie']=$_POST['literie'];
            if (isset($_POST['PMR'])){
                $data['accessibilite']='Oui';
            }
            else{
                $data['accessibilite']='Non';
            }
            if(count($error)==0){

                $ok = $chambreManager->insert($data);
                if (!$ok){
                    $error[]="La base de donnée a refusé votre requête, veuillez contacter votre support technique.";
                }
                else {
                    $valid[]="Chambre ajoutée avec succès";
                    $chambres=$chambreManager->findAll();
                    $id=0;
                    foreach ($chambres as $chambre){
                        $id=max($id,$chambre['id']);
                    }
                    $n = count($_FILES['nouvellesDiapos']['name']);

                    for ($i = 0; $i < $n; $i++) {

                        // Vérifie qu'un fichier a bien été envoyé
                        if (!empty($_FILES['nouvellesDiapos']['name'][$i])) {
                            // Vérification du type de fichier
                            $typeMime = mime_content_type($_FILES['nouvellesDiapos']['tmp_name'][$i]);
                            if (in_array($typeMime, ['image/jpeg', 'image/png', 'image/jpg', 'image/gif'])) {

                                // Vérification taille du fichier
                                $size = filesize($_FILES['nouvellesDiapos']['tmp_name'][$i]);

                                if ($size > 2000000) {
                                    $error[]= "Le fichier ne doit pas dépasser 2Mo";
                                } else {
                                    // Récupération de l'extension du fichier (fin de la chaîne) :
                                    $extensionDuFichier = strrchr($_FILES['nouvellesDiapos']['name'][$i], ".");

                                    // Définition d'un nom unique :
                                    $uniqueId = uniqid('/assets/images/image') . $extensionDuFichier;

                                    // Emplacement temporaire du fichier uploadé :
                                    $cheminEtNomTemporaire = $_FILES['nouvellesDiapos']['tmp_name'][$i];

                                    // Nouvel emplacement du fichier :
                                    $deplacementOK = move_uploaded_file($cheminEtNomTemporaire, substr($uniqueId,1,strlen($uniqueId)));
                                    if ($deplacementOK) {
                                        $ok = $diapoChambreManager->insert(['urlImage' => $uniqueId,'chambres_id'=>$id]);
                                        if ($ok) {
                                            $valid[] = "Image ajoutée avec succès ";
                                        } else {
                                            unlink(substr($uniqueId,1,strlen($uniqueId)));
                                            $error[] = "Votre image n'as pas pu être enregistrée, si l'erreur persiste, veuillez contacter le service technique";
                                        }
                                    }

                                }
                            } else {
                                $error[]= "Format d'image non supporté (formats supportés : jpeg, jpg, png, gif)";
                            }
                        }
                    }
                }
            }

        }


        return $this->twig->render('Administration/NouvelleChambreAdmin.html.twig',[
            'errors'=>$error,
            'valids'=>$valid,
            'data'=>$data]);
    }

}