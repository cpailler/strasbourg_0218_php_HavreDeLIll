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
use Model\ReservationAttenteManager;
use Model\ReservationManager;
use Model\LocalisationManager;
use Model\ParlementairesManager;
use Model\DiapoAccueilManager;

/**
 * Class ReservationController
 * @package Controller
 */
class AdministrationController extends AbstractController
{
    /**
     *creation cookies
     */
    private function ConnectionCheck(){
    session_start();
    if (!isset($_SESSION['user']) && !isset($_COOKIE['user'])){
        header('Location: /Login');
    }


}

    public function index()
    {
        $this->ConnectionCheck();


        return $this->twig->render('Administration/Administration.html.twig');
    }

    public function DiapoAccueil()
    {
        $this->ConnectionCheck();

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
        $this->ConnectionCheck();

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
        $this->ConnectionCheck();

        $accueilManager = new AccueilManager();

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

                        if ($deplacementOK){
                            $data['urlImage'] = $uniqueId;
                        }
                        else{
                            $error[]="Erreur inconnue : Votre fichier n'as pas pu être enregistré";
                        }

                    }
                } else {
                    $error[] = "Format d'image non supporté (formats supportés : jpeg, jpg, png, gif)";
                }

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

    public function LocalisationAdmin(){

        $this->ConnectionCheck();

        $LocalisationManager = new LocalisationManager();
        $error=[];
        $valid=[];
        if (isset($_POST['modifierLoc'])) {
            $data = [];
            $id = 1;
            $data['numPortable'] = $_POST['numPortable'];
            $data['numFixe'] = $_POST['numFixe'];
            $data['texte'] = $_POST['texte'];
            $adminModifier = $LocalisationManager->update($id, $data);
            if (!$adminModifier) {
                $error[] = "La base de donnée a refusé votre requête, veuillez contacter votre support technique.";
            } else {
                $valid[] = "modifications ont été effectuées";

            }
        }

        $adminLoc=$LocalisationManager->findAll();


        return $this->twig->render('Administration/LocalisationAdmin.html.twig',[
            'adminLoc'=> $adminLoc,
            'error'=>$error,
            'valid'=>$valid
        ]);
    }

    public function NouvelleChambre(){

        $this->ConnectionCheck();

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

    public function ParlementairesAdmin()
    {
        $this->ConnectionCheck();

        $ParlementairesManager = new ParlementairesManager();

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

                        if ($deplacementOK){
                            $data['urlImage'] = $uniqueId;
                        }
                        else{
                            $error[]="Erreur inconnue : Votre fichier n'as pas pu être enregistré";
                        }

                    }
                } else {
                    $error[] = "Format d'image non supporté (formats supportés : jpeg, jpg, png, gif)";
                }

            }

            $ok = $ParlementairesManager->update($id, $data);
            if (!$ok) {
                $error[] = "La base de donnée a refusé votre requête, veuillez contacter votre support technique.";
            } else {
                $valid[] = "Article modifiée avec succès";
            }
        }

        $articles =  $ParlementairesManager->findAll();

        return $this->twig->render('Administration/ParlementairesAdmin.html.twig', ['articles' => $articles]);
    }

    public function ReservationEnAttente(){
        $this->ConnectionCheck();
        $reservationsEnAttentesManager = new ReservationAttenteManager();
        $reservationsManager = new ReservationManager();
        $chambresManager = new ChambreManager();
        $valids=[];
        $errors=[];
        if(!empty($_POST)){
            foreach ($_POST as $key=>$value){
                if ($value=='Valider'){
                    $resa = $reservationsEnAttentesManager->findOneById($key);
                    var_dump($resa);
                    array_shift($resa);
                    var_dump($resa);
                    $ok = $reservationsManager->insert($resa);
                    if ($ok){
                        $valids[]='chambre validée';
                        $mail = new GestionMailController();
                        $reservationsEnAttentesManager->delete($key);
                        $mail->envoiMailValidation($resa);
                    }
                    else {
                        $errors[]='Une erreur s\'est produite lors de la validation';
                    }
                }
                elseif ($value=='Refuser'){
                    $resa = $reservationsEnAttentesManager->findOneById($key);
                    $reservationsEnAttentesManager->delete($key);
                    $mail = new GestionMailController();
                    $mail->envoiMailRefus($resa);
                }

            }
        }




        $chambres = $chambresManager->findAll();
        $resas = $reservationsEnAttentesManager->findAll();
        foreach ($chambres as $chambre){
            foreach($resas as &$resa){
                if ($resa['chambre_id']==$chambre['id']){
                    $resa['chambre_titre']=$chambre['titre'];
                }
            }
        }


        return $this->twig->render('Administration/ReservationsEnAttenteAdmin.html.twig', ['resas' => $resas, 'errors' => $errors, 'valids' => $valids]);
    }

    public function CalendrierAdmin(int $initMonth=null, int $initYear=null){
        $this->ConnectionCheck();
        $reservationsManager = new ReservationManager();
        $chambresManager = new ChambreManager();
        $chambres = $chambresManager->findAll();
        $valids=[];
        $errors=[];

        //en arrivant en GET pour la première fois
        if (!isset($_SESSION['chambre_id'])){
            $_SESSION['chambre_id']="";
        }
        //en arrivant en POST depuis la selection de chambre sur cette même page
        if (isset($_POST['chambreselect'])) {
            $_SESSION['chambre_id'] = $_POST['chambreselect'];
        }

        //suppression de la réservation si necessaire
        if (isset($_POST['Annuler'])){
            $ok = $reservationsManager->delete($_POST['idAnnulation']);
            if($ok){
                $valids[]= 'réservation annulée avec succès';
            }
            else {
                $errors[]= 'Une erreur s\'est produite lors de l\'annulation de la réservation, si le problème persiste veuillez contacter le service technique';
            }
        }

        //Gestion du calendrier
        $month = new Month($initMonth, $initYear);
        $start = $month->getStartingDay();
        $start = $start->format('N')==='1' ? $start : $month->getStartingDay()->modify('last monday');
        $weekDays = $month->days;
        $weeks = $month->getWeeks();
        $end = (clone $start)->modify('+'.(6+7*($weeks -1)).'days');
        if ($_SESSION['chambre_id']==""){
            $reservations = $reservationsManager->getAllReservationBetween($start, $end);
        }
        else{
            $reservations = $reservationsManager->getReservationBetween($start, $end,$_SESSION['chambre_id']);
        }
        $infosDays=[];

       // $newRes = (new \DateTime($Reservation['start']))->format('d.m.Y');
        for ($i =0; $i <$weeks;$i++) {
            foreach ($weekDays as $k => $day) {
                $date = (clone $start)->modify("+" . ($k + $i * 7) . "day");
                if (isset($_POST[$date->format('Y-m-d')])){
                    $detailsResas[$date->format('Y-m-d')]=[];
                }
                $key = $k + $i * 7;
                $infosDays[$key] = ['jourZero' => false,'fullDate'=>$date->format('Y-m-d'),'date'=>$date->format('d'),'withinMonth'=>$month->withinMonth($date),'reserve'=>false];
                foreach ($reservations as $reservation) {
                    if ((strtotime($date->format('Y-m-d')) >= strtotime($reservation['dateDebut'])) && (strtotime($date->format('Y-m-d')) < strtotime($reservation['dateFin']))) {
                        $infosDays[$key]['reserve'] = true;
                        if (isset($detailsResas[$date->format('Y-m-d')])){
                            $detailsResas[$date->format('Y-m-d')][]=$reservation;
                        }
                    }

                }
                if ($i === 0) {
                    $infosDays[$key]['jourZero'] = true;
                }
            }
        }
        if (!isset($detailsResas)){
            $detailsResas=[];
        }
        else {
            foreach ($detailsResas as &$resas){
                foreach($resas as &$resa){
                    foreach ($chambres as $chambre){
                        if ($resa['chambre_id']==$chambre['id']){
                            $resa['chambre_titre']=$chambre['titre'];
                        }
                    }
                }
            }

        }

        return $this->twig->render('Administration/CalendrierAdmin.html.twig',
            ['errors' => $errors,
                'month' => $month,
                'valids' => $valids,
                'monthTS' => $month->toString(),
                'previousMonth' => $month->previousMonth()->month,
                'previousYear' => $month->previousMonth()->year,
                'nextMonth' => $month->nextMonth()->month,
                'nextYear' => $month->nextMonth()->year,
                'weeks' => $month->getWeeks(),
                'infosDays' => $infosDays,
                'cloneStart' => clone $start,
                'days' => $weekDays,
                'chambres'=> $chambres,
                'select'=>$_SESSION['chambre_id'],
                'detailsResas' => $detailsResas
            ]);
    }

    public function BloquerChambre(){
        $this->ConnectionCheck();
        $chambresManager = new ChambreManager();
        $chambres = $chambresManager->findAll();
        $valids=[];
        $errors=[];
        $warnings=[];
        $select="";
        $data=[];



        //Action du formulaire de bloquage de chambre
        if (isset($_POST['Bloquer'])){

            $ReservationManager =new ReservationManager();
            $ReservationAttenteManager =new ReservationAttenteManager();

            if ($_POST['chambre']!=""){
                $select=$_POST['chambre'];
                $data['chambre_id']=$_POST['chambre'];
            }
            else {
                $errors[] = 'Veuillez sélectionner la chambre à bloquer';
            }
            if (isset($_POST['dateDebut'])&&isset($_POST['dateFin'])){
                $data['dateDebut']=$_POST['dateDebut'];
                $data['dateFin']=$_POST['dateFin'];

            }
            else {
                $errors[] = 'Veuillez saisir les dates du bloquage';
            }


            //Verification des dates
            if (isset($data['dateDebut'])&&isset($data['dateFin'])){
                $start=new \DateTime($data['dateDebut']);
                $end=new \DateTime($data['dateFin']);

                //vérification de la cohérance des dates
                if (strtotime($end->format('Y-m-d'))<=strtotime($start->format('Y-m-d'))){
                    $errors[] ="Les dates saisies pour votre le bloquage ne sont pas réalisables, vérifiez que la date de fin soit postérieure à la date de début.";
                }
                //verification de la disponibilité de la chambre

                if (empty($errors)) {
                    if (!empty($ReservationManager->getReservationBetween($start, $end, $data['chambre_id']))&&!empty($ReservationAttenteManager->getReservationBetween($start, $end, $data['chambre_id']))) {
                        $warnings[] = "Attention, il existe des réservations pour la chambre bloquée pendant la période bloquée";
                    }
                }
            }

            if (empty($errors)){
                $data['nomClient'] = 'Admin';
                $data['prenomClient'] = 'Admin';
                $data['mailClient'] = 'f.olivier.wilder@gmail.com';
                $data['telClient'] = '0000000000';
                $ok=$ReservationManager->insert($data);
                if ($ok){
                    $valids[]="Le bloquage de la chambre a bien été pris en compte.";
                }
                else {
                    $errors[]="Une erreur s'est produite lors de l'enregistrement de votre demande, si le problème persisite veuillez contacter le support technique";
                }
            }


        }



        return $this->twig->render('Administration/BloquerChambreAdmin.html.twig', ['chambres' => $chambres,'select' => $select,'data' => $data, 'errors' => $errors, 'valids' => $valids, 'warnings' => $warnings]);
    }



}