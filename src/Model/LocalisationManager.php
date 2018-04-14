<?php
/**
 * Created by PhpStorm.
 * User: zak
 * Date: 13/04/18
 * Time: 10:19
 */

namespace Model;


class LocalisationManager extends EntityManager
{

    const TABLE = 'Localisation';


    public function __construct()
    {
        parent::__construct(self::TABLE);
    }


}