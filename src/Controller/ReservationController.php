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
        $month = new Month($initMonth ?? null, $initYear ?? null);
        $start = $month->getStartingDay();
        $start = $start->format('N')==='1' ? $start : $month->getStartingDay()->modify('last monday');
        $days = $month->days;
        $fullCalendar = [];
        for ($i =0; $i <$month->getWeeks();$i++):
            foreach ($month->days as $k=>$day) :
                $calendar = [];
                $date =(clone $start)->modify("+".($k + $i *7)."day");
                $calendar['withMonth']=$month->withinMonth($date);
                if ($i === 0):
                    $calendar['jourZero']= $day;
                endif;
                $calendar['jour'] = $date->format('d');
                $fullCalendar[] = $calendar;
          endforeach;
        endfor;

        return $this->twig->render('Reservation/calendrier.html.twig',
            ['month'=>$month,
                'monthTS' => $month->toString(),
                'previousMonth' => $month->previousMonth()->month,
                'previousYear' => $month->previousMonth()->year,
                'nextMonth' => $month->nextMonth()->month,
                'nextYear' => $month->nextMonth()->year,
                'weeks' => $month->getWeeks(),
                'fullCalendar' => $fullCalendar,
                'cloneStart' => clone $start,
                'daysEn'=>$daysEn,
                'days'=>$days,
            ]);

    }


    public function envoiMail()
    {
echo "envoiMail";
    }
}
