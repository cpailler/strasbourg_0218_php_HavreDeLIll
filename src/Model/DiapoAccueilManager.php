<?php
/**
 * Created by PhpStorm.
 * User: zak
 * Date: 13/04/18
 * Time: 09:54
 */

namespace Model;


class DiapoAccueilManager extends EntityManager
{

    const TABLE = 'DiapoAccueil';


    public function __construct()
    {
        parent::__construct(self::TABLE);
    }

}


