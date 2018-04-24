<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 11/03/18
 * Time: 16:07
 */

namespace Controller;

use Controller\Calendar\Month;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\PHPMailer;
use Controller\Calendar\Reservation;
use Model\ReservationManager;

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
    public function toString (): string
    {

        $myDate=array();
        $myMonth = new Month($_GET['month'] ?? null, $_GET['year'] ?? null);
        $myDate['days']=$myMonth->days;
        $start = $myMonth->getStartingDay();
        $start = $start->format('N')==='1' ? $start : $myMonth->getStartingDay()->modify('last monday');
        $myDate['myMonth'] = $myMonth->months[$myMonth->month -1].' '.$myMonth->year;
        $myDate['nbWeeks'] =$myMonth->getWeeks();

        return $this->twig->render('Reservation/Reservation.html.twig', ['myDate' => $myDate]);
    }


    public function init(int $initMonth=null, int $initYear=null)
    {


        $ReservationManager = new ReservationManager();
        $month = new Month($initMonth ?? null, $initYear ?? null);
        $start = $month->getStartingDay();
        $start = $start->format('N')==='1' ? $start : $month->getStartingDay()->modify('last monday');
        $days = $month->days;
        $weeks = $month->getWeeks();
        $end = (clone $start)->modify('+'.(6+7*($weeks -1)).'days');
        $Reservation = $ReservationManager->getReservationBetweenByDay($start, $end);
        $ReservationForDay=[];


       // $newRes = (new \DateTime($Reservation['start']))->format('d.m.Y');


        $fullCalendar = [];
        for ($i =0; $i <$month->getWeeks();$i++):
            foreach ($month->days as $k=>$day) :
                $calendar = [];
                $date =(clone $start)->modify("+".($k + $i *7)."day");
                $ReservationForDay[] = $Reservation[$date->format('Y-m-d')] ?? [];




                $calendar['withMonth']=$month->withinMonth($date);


                if ($i === 0):
                    $calendar['jourZero']= $day;
                endif;
                $calendar['jour'] = $date->format('d');
                $fullCalendar[] = $calendar;
          endforeach;
        endfor;


        try {
            return $this->twig->render('Reservation/calendrier.html.twig',
                ['month' => $month,
                    'Reservation' => $Reservation,
                    'monthTS' => $month->toString(),
                    'previousMonth' => $month->previousMonth()->month,
                    'previousYear' => $month->previousMonth()->year,
                    'nextMonth' => $month->nextMonth()->month,
                    'nextYear' => $month->nextMonth()->year,
                    'weeks' => $month->getWeeks(),
                    'fullCalendar' => $fullCalendar,
                    'cloneStart' => clone $start,
                    'ReservationForDay'=> $ReservationForDay,
                    'days' => $days

                ]);
        } catch (\Twig_Error_Loader $e) {
        } catch (\Twig_Error_Runtime $e) {
        } catch (\Twig_Error_Syntax $e) {
        }

    }


    public function envoiMail()
    {
        $mail = new PHPMailer(true);                              // Passing `true` enables exceptions
        try {
            //Server settings
            $mail->SMTPDebug = 2;                                 // Enable verbose debug output
            $mail->isSMTP();                                      // Set mailer to use SMTP
            $mail->Host = 'smtp.gmail.com';  // Specify main and backup SMTP servers
            $mail->SMTPAuth = true;                               // Enable SMTP authentication
            $mail->Username = 'f.olivier.wilder@gmail.com';                 // SMTP username
            $mail->Password = 'olivierwild67 ';                           // SMTP password
            $mail->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
            $mail->Port = 587;                                    // TCP port to connect to

            //Recipients
            $mail->setFrom('f.olivier.wilder@gmail.com', 'Mailer');
            $mail->addAddress('f.olivier.wilder@gmail.com', 'Havre de l Ill');     // Add a recipient
            //$mail->addReplyTo($_POST['mail'], 'Information');

            //Content
            $mail->isHTML(true);                                  // Set email format to HTML
            $mail->Subject = 'Message de '.$_POST['nom'].' '.$_POST['prenom'];
            $mail->Body    = 'Message utilisateur '.$_POST['message'];
            $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

            $mail->send();
            echo 'Message envoyer';
        } catch (Exception $e) {
            echo 'Message could not be sent. Mailer Error: ', $mail->ErrorInfo;
        }
    }
}
