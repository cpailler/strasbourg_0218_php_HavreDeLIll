<?php
/**
 * Created by PhpStorm.
 * User: zak
 * Date: 13/04/18
 * Time: 09:54
 */

namespace Model;


class DiapoChambreManager extends EntityManager
{

    const TABLE = 'DiapoChambres';


    public function __construct()
    {
        parent::__construct(self::TABLE);
    }

    public function findByChambreId($chambresId)
    {
        $statement = $this->conn->prepare("SELECT * FROM ".$this->table." WHERE chambres_id=:id");
        $statement->bindValue('id', $chambresId, \PDO::PARAM_INT);
        $statement->execute();

        return $statement->fetchAll();
    }

}


