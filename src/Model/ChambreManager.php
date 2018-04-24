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
        $chambresSeules=$this->conn->query('SELECT DISTINCT * FROM ' . $this->table)->fetchAll();
        $chambres=[];
        $DiapoChambresManager= new DiapoChambreManager();
        $i=0;
        foreach ($chambresSeules as $data) {
            $i++;
            $diaposChambre=$DiapoChambresManager->findByChambreId($data['id']);
            $chambres += [$i => array(
                'id' => $data['id'],
                'titre' => $data['titre'],
                'texte' => $data['texte'],
                'prix' => $data['prix'],
                'style' => $data['style'],
                'literie' => $data['literie'],
                'accessibilite' => $data['accessibilite'],
                'salleDeBain' => $data['salleDeBain'],
                'urlImage' => $diaposChambre)];

        }
        return $chambres;

    }

}
