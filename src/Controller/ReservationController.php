<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 11/03/18
 * Time: 16:07
 */

namespace Controller;

use Controller\Calendar\Month;
use Model\ChambreManager;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\PHPMailer;
use Controller\Calendar\Reservation;
use Model\ReservationManager;
use Model\ReservationAttenteManager;

/**
 * Class ReservationController
 * @package Controller
 */
class ReservationController extends AbstractController
{


    /**
     * retourne le mois en toute lettre (ex:mars 2018)
     * @return string
     */

    public function index(int $initMonth=null, int $initYear=null)
    {
        session_start();
        $chambresManager = new ChambreManager();
        $ReservationManager = new ReservationManager();
        $ReservationAttenteManager = new ReservationAttenteManager();
        $chambres=$chambresManager->findAll();
        $errors=[];
        $valids=[];

        //preselection de la chambre

        //en arrivant en GET pour la première fois
        if (!isset($_SESSION['chambre_id'])){
            $_SESSION['chambre_id']=$chambres[0]['id'];
        }

        //en arrivant en POST par un bouton reservation
        foreach ($chambres as $chambre){
            if (isset($_POST[$chambre['id']])){
                $_SESSION['chambre_id']=$chambre['id'];
            }
        }
        //en arrivant en POST depuis la selection de chambre sur cette même page
        if (isset($_POST['chambreselect'])) {
            $_SESSION['chambre_id'] = $_POST['chambreselect'];
        }
        $data=[];
        if (isset($_POST['Book'])){

            $data['chambre_id']=$_SESSION['chambre_id'];
            //verification du remplissage des champs
            if ($_POST['dateDebut']!=""){
                $data['dateDebut']=$_POST['dateDebut'];
            }
            else {
                $errors[]="Veuillez saisir une date d'arrivée.";
            }
            if ($_POST['dateFin']!=""){
                $data['dateFin']=$_POST['dateFin'];
            }
            else {
                $errors[]="Veuillez saisir une date de départ.";
            }
            if ($_POST['nomClient']!=""){
                $data['nomClient']=$_POST['nomClient'];
            }
            else {
                $errors[]="Veuillez saisir votre nom.";
            }
            if ($_POST['prenomClient']!=""){
                $data['prenomClient']=$_POST['nomClient'];
            }
            else {
                $errors[]="Veuillez saisir votre prénom";
            }
            if ($_POST['mailClient']!=""){
                $data['mailClient']=$_POST['mailClient'];
            }
            else {
                $errors[]="Veuillez saisir votre adresse mail.";
            }
            if ($_POST['telClient']!=""){
                $data['telClient']=$_POST['telClient'];
            }
            else {
                $errors[]="Veuillez saisir votre numero de téléphone.";
            }

            //Verification des dates

            $start=new \DateTime($data['dateDebut']);
            $end=new \DateTime($data['dateFin']);
            $now = new \DateTime();
            //verification que la date d'entrée est posterieure à la date du jour
            if (strtotime($now->format('Y-m-d'))>strtotime($start->format('Y-m-d'))){
                $errors[]="La date d'arrivée que vous avez saisi se trouve dans le passé.";
            }
            //vérification de la cohérance des dates
            if (strtotime($end->format('Y-m-d'))<=strtotime($start->format('Y-m-d'))){
                $errors[] ="Les dates saisies pour votre séjour ne sont pas réalisables, pensez à vérifier le nombre nuitées.";
            }
            //verification de la disponibilité de la chambre
            if (empty($errors)) {

                if (!empty($ReservationManager->getReservationBetween($start, $end, $data['chambre_id']))&&!empty($ReservationAttenteManager->getReservationBetween($start, $end, $data['chambre_id']))) {
                    $errors[] = "La chambre n'est pas libre aux dates que vous avez sélectionné, veuillez voir les disponibilités des autres chambres(n'hésitez pas à utiliser le calendrier).";
                }
            }
            if (empty($errors)){
                $ok=$ReservationAttenteManager->insert($data);
                if ($ok){
                    $valids[]="Votre réservation a bien été prise en compte, vous serez informé par mail lorsqu'elle sera validé par le propriétaire.";
                }
                else {
                    $errors[]="Votre reservation n'as pas pu être prise en compte, assurer-vous d'avoir rempli correctement chaque champ du formulaire.";
                }
            }


        }



        //Gestion du calendrier
        $month = new Month($initMonth, $initYear);
        $start = $month->getStartingDay();
        $start = $start->format('N')==='1' ? $start : $month->getStartingDay()->modify('last monday');
        $weekDays = $month->days;
        $weeks = $month->getWeeks();
        $end = (clone $start)->modify('+'.(6+7*($weeks -1)).'days');
        $reservations = $ReservationManager->getReservationBetween($start, $end,$_SESSION['chambre_id']);
        $reservationsAttente = $ReservationAttenteManager->getReservationBetween($start, $end,$_SESSION['chambre_id']);
        $infosDays=[];

       // $newRes = (new \DateTime($Reservation['start']))->format('d.m.Y');
        for ($i =0; $i <$weeks;$i++) {
            foreach ($weekDays as $k => $day) {
                $date = (clone $start)->modify("+" . ($k + $i * 7) . "day");
                $key = $k + $i * 7;
                $infosDays[$key] = ['jourZero' => false,'date'=>$date->format('d'),'withinMonth'=>$month->withinMonth($date),'reserve'=>false];
                foreach ($reservations as $reservation) {
                    if ((strtotime($date->format('Y-m-d')) >= strtotime($reservation['dateDebut'])) && (strtotime($date->format('Y-m-d')) < strtotime($reservation['dateFin']))) {
                        $infosDays[$key]['reserve'] = true;
                    }
                }
                foreach ($reservationsAttente as $reservation) {
                    if ((strtotime($date->format('Y-m-d')) >= strtotime($reservation['dateDebut'])) && (strtotime($date->format('Y-m-d')) < strtotime($reservation['dateFin']))) {
                        $infosDays[$key]['reserve'] = true;
                    }
                }
                if ($i === 0) {
                    $infosDays[$key]['jourZero'] = true;
                }
            }
        }


        try {
            return $this->twig->render('Reservation/calendrier.html.twig',
                ['month' => $month,
                    'Reservations' => $reservations,
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
                    'errors'=>$errors,
                    'valids'=>$valids,
                    'data'=>$data

                ]);
        } catch (\Twig_Error_Loader $e) {
        } catch (\Twig_Error_Runtime $e) {
        } catch (\Twig_Error_Syntax $e) {
        }

    }


}
