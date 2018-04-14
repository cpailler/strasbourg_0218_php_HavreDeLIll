<?php
/**
 * Created by PhpStorm.
<<<<<<< HEAD
 * User: zak
 * Date: 13/04/18
 * Time: 10:01
=======
 * User: sylvain
 * Date: 07/03/18
 * Time: 18:20
>>>>>>> 3ab950878902143d0d0c8d034aac26b6577b802d
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

