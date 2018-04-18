<?php
/**
 * Created by PhpStorm.
 * User: sylvain
 * Date: 07/03/18
 * Time: 18:20
 */

namespace Model;


class ChambreManager extends EntityManager
{
    const TABLE = 'Chambres';


    public function __construct()
    {
        parent::__construct(self::TABLE);
    }

    public function findAll()
    {
        return $this->conn->query('SELECT * FROM ' . $this->table . ' INNER JOIN DiapoChambres ON Chambres.id  =  DiapoChambres.chambres_id ', \PDO::FETCH_ASSOC)->fetchAll();

    }

    public function delete($id)
    {
    }

    public function update($id, $data)
    {
    }

    public function insert($data)
    {
    }

}
