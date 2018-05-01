<?php
/**
 * Created by PhpStorm.
 * User: sylvain
 * Date: 07/03/18
 * Time: 18:20
 */

namespace Model;


class ReservationAttenteManager extends EntityManager
{
    const TABLE = 'ReservationEnAttente';


    public function __construct()
    {
        parent::__construct(self::TABLE);
    }

    public function getReservationBetween ($start, $end, $id): array {
        return $this->conn->query("SELECT * FROM ".$this->table." WHERE dateDebut<='".$end->format('Y-m-d')."' AND dateFin>'".$start->format('Y-m-d')."' AND chambre_id='".$id."';", \PDO::FETCH_ASSOC)->fetchAll();
    }

}