<?php
/**
 * Created by PhpStorm.
 * User: sylvain
 * Date: 07/03/18
 * Time: 18:20
 */

namespace Model;


class AdminManager extends EntityManager
{
    const TABLE = 'Admin';


    public function __construct()
    {
        parent::__construct(self::TABLE);
    }

}
