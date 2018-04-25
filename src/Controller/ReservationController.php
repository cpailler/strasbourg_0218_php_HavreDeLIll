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


    public function index(int $initMonth=null, int $initYear=null)
    {


        $ReservationManager = new ReservationManager();
        $month = new Month($initMonth, $initYear);
        $start = $month->getStartingDay();
        $start = $start->format('N')==='1' ? $start : $month->getStartingDay()->modify('last monday');
        $weekDays = $month->days;
        $weeks = $month->getWeeks();
        $end = (clone $start)->modify('+'.(6+7*($weeks -1)).'days');
        $reservations = $ReservationManager->getReservationBetween($start, $end);
        $infosDays=[];

       // $newRes = (new \DateTime($Reservation['start']))->format('d.m.Y');
        $fullCalendar = [];
        for ($i =0; $i <$weeks;$i++) {
            foreach ($weekDays as $k => $day) {
                $calendar = [];
                $date = (clone $start)->modify("+" . ($k + $i * 7) . "day");
                $key = $k + $i * 7;
                $infosDays[$key] = ['jourZero' => false,'date'=>$date->format('d'),'withinMonth'=>$month->withinMonth($date),'reserve'=>false];
                foreach ($reservations as $reservation) {
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
                    'days' => $weekDays

                ]);
        } catch (\Twig_Error_Loader $e) {
        } catch (\Twig_Error_Runtime $e) {
        } catch (\Twig_Error_Syntax $e) {
        }

    }


}
