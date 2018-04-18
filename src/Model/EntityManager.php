<?php
/**
 * Created by PhpStorm.
 * User: sylvain
 * Date: 07/03/18
 * Time: 20:52
 */

namespace Model;


abstract class EntityManager
{
    protected $conn; //variable de connexion

    protected $table;

    public function __construct($table)
    {
        $db = new Connection();
        $this->conn = $db->getPdo();
        $this->table = $table;
    }

    /**
     * @return array
     */
    public function findAll()
    {
        return $this->conn->query('SELECT * FROM ' . $this->table, \PDO::FETCH_ASSOC)->fetchAll();
    }

    /**
     * @param $id
     * @return array
     */
    public function findOneById(int $id)
    {
        // prepared request
        $statement = $this->conn->prepare("SELECT * FROM $this->table WHERE id=:id");
        $statement->bindValue('id', $id, \PDO::PARAM_INT);
        $statement->execute();

        return $statement->fetch(\PDO::FETCH_ASSOC);
    }



    /**
     *
     */
    public function delete($id)
    {
        // prepared request
        $statement = $this->conn->prepare("DELETE FROM $this->table WHERE id=:id");
        $statement->bindValue('id', $id, \PDO::PARAM_INT);
        return $statement->execute();

    }

    /**
     *recevoir de la data sous forme de tableau avec les colonnes bien nommées...
     */
    public function insert($data)
    {   $statement = $this->conn->prepare("INSERT INTO $this->table (:columns) VALUES (:vals)");
        $columns = "";
        $values = "";
        foreach ($data as $column => $value){
            $columns .= $column.",";
            $values .= "'".$value."',";
        }
        $columns=substr($columns, 0, strlen($columns)-1);
        $values=substr($values, 0, strlen($values)-1);
        $statement->bindValue('columns', $columns, \PDO::PARAM_INT);
        $statement->bindValue('vals', $values, \PDO::PARAM_INT);
        return $statement->execute();


    }


    /**
     *
     */
    public function update($id, $data)
    {
        //TODO : Implements SQL UPDATE request
    }


}
