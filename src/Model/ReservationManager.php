<?php
/**
 * Created by PhpStorm.
 * User: sylvain
 * Date: 07/03/18
 * Time: 18:20
 */

namespace Model;


class ReservationManager extends EntityManager
{
    const TABLE = 'Reservation';


    public function __construct()
    {
        parent::__construct(self::TABLE);
    }

    /**
     * Récupère les évènements commençant entre 2 dates
     * @param \DateTime $start
     * @param \DateTime $end
     * @return array
     */
    public function getReservationBetween ($start, $end, $id): array {
        return $this->conn->query("SELECT * FROM ".$this->table." WHERE dateDebut<='".$end->format('Y-m-d')."' AND dateFin>'".$start->format('Y-m-d')."' AND chambre_id='".$id."';", \PDO::FETCH_ASSOC)->fetchAll();
    }
    //SELECT * FROM " . $this->table."WHERE dateDebut <= '".$end->format('Y-m-d')."' AND dateFin > '".$start->format('Y-m-d')."'"

    /**
     * Récupère les évènements commençant entre 2 dates indexé par jour
     * @param \DateTime $start
     * @param \DateTime $end
     * @return array
     */
    public function getReservationBetweenByDay ( $start,  $end): array {
        $Reservations = $this->getReservationBetween($start, $end);
        $days = [];

        foreach($Reservations as $Reservation) {
            $date = $Reservation['start'];


            if (!isset($days[$date])) {
                $days[$date] = [$Reservation];
            } else {
                $days[$date][] = $Reservation;
            }
        }
        return $days;
    }

    /**
     * Récupère un évènement
     * @param int $id
     * @return Event
     * @throws \Exception
     */
    public function find (int $id): Event {
        $statement = $this->conn->query("SELECT * FROM Reservation WHERE id = $id LIMIT 1");
        $statement->setFetchMode(\PDO::FETCH_CLASS, Event::class);
        $result = $statement->fetch();
        if ($result === false) {
            throw new \Exception('Aucun résultat n\'a été trouvé');
        }
        return $result;
    }



}