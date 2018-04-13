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
    const TABLE = '';


    public function __construct()
    {
        parent::__construct(self::TABLE);
    }

    public function findAll()
    {
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