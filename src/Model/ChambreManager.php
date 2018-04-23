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
        $DiaposChambres=$this->conn->query('SELECT DISTINCT * FROM ' . $this->table . ' INNER JOIN DiapoChambres ON Chambres.id  =  DiapoChambres .chambres_id', \PDO::FETCH_ASSOC)->fetchAll();
        $chambres=[];
        $i=0;
        foreach ($DiaposChambres as $diapo => $data) {
            if (!isset($chambres[$data['chambres_id']])) {
                $i++;
                $chambres += [$i => array(
                    'id' => $data['chambres_id'],
                    'titre' => $data['titre'],
                    'texte' => $data['texte'],
                    'prix' => $data['prix'],
                    'style' => $data['style'],
                    'literie' => $data['literie'],
                    'accessibilite' => $data['accessibilite'],
                    'salleDeBain' => $data['salleDeBain'],
                    'urlImage' => array($data['id'] => $data['urlImage']))];

            } else {

                $chambres[$data['chambres_id']]['urlImage']+= [$data['id'] => $data['urlImage']];

            }

        }
        return $chambres;

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
