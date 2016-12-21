<?php
/**
 * Created by PhpStorm.
 * User: Ulukut
 * Date: 12.10.2016
 * Time: 16:54
 * @author Volkan Ulukut <arthan@gmail.com>
 */

namespace Ludwig\Models;


/**
 * Class SQLiteDataSource
 * Class to handle SQLite connections
 * @package Simplechat\Models
 */
class SQLiteDataSource implements IDataSource
{
    /**
     * database resource.
     * @var mixed
     */
    private $db;

    /**
     * SQLiteDataSource constructor.
     */
    public function __construct()
    {
        $this->connect();
    }

    /**
     * connecting to sqlite datasource.
     * @return void
     */
    public function connect()
    {
        $this->db = new \SQLite3('db/ludwig.db');
    }

    /**
     * Read a specific row from SQLite database and return as array.
     * @param string $tableName
     * @param string $primaryKey
     * @param integer $primaryId
     * @return array
     */
    public function readOne($tableName,$primaryKey, $primaryId)
    {
        $query = 'SELECT * FROM ' . $tableName . " WHERE " . $primaryKey . " = :" . $primaryKey;
        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':' . $primaryKey, $primaryId);
        $result = $stmt->execute();
        return $result->fetchArray();
    }

    /**
     * Read one or more rows with custom conditions from the datasource.
     * @param string $tableName
     * @param array $conditions
     * @return array
     */
    public function readBy($tableName, $conditions)
    {
        $query = 'SELECT * FROM ' . $tableName . " WHERE ";
        $queryArr = array();
        foreach($conditions as $key => $value)
        {
            $queryArr[] = $key . " = :" . $key;
        }
        $query .= implode(" AND ", $queryArr);
        $stmt = $this->db->prepare($query);
        foreach($conditions as $key => $value)
        {
            $stmt->bindValue(':' . $key, $value);
        }
        $result = $stmt->execute();
        $response = array();
        while($returnData = $result->fetchArray())
        {
            $response[] = $returnData;
        }
        return $response;
    }

    public function query($query,$bindValues)
    {
        $stmt = $this->db->prepare($query);
        foreach($bindValues as $key => $value)
        {
            $stmt->bindValue(':' . $key, $value);
        }
        $result = $stmt->execute();
        $response = array();
        while($returnData = $result->fetchArray())
        {
            $response[] = $returnData;
        }
        return $response;
    }

    /**
     * Create a new row in the database for the given table name and row data.
     * @param string $tableName
     * @param array $array
     * @return int
     */
    public function create($tableName,$array)
    {
        $query = "INSERT INTO " . $tableName . " (" . implode(",",array_keys($array)) . ") VALUES (:" . implode(",:",array_keys($array)) . ")";
        $stmt = $this->db->prepare($query);
        foreach($array as $key => $value)
        {
            $stmt->bindValue(':' . $key, $value);
        }

        $stmt->execute();
        return $this->db->lastInsertRowID();
    }

    /**
     * Update a specific row in the database for the given IModel.
     * @param string $tableName
     * @param string $primaryKey
     * @param array $array
     * @return bool
     */
    public function update($tableName,$primaryKey,$array)
    {
        $query = "UPDATE " .$tableName . " SET ";
        $queryArr = array();
        foreach($array as $key => $value)
        {
            $queryArr[] = $key . " = :" . $key;
        }
        $query .= implode(",", $queryArr) . " WHERE " . $primaryKey . " = :" . $primaryKey . "";
        $stmt = $this->db->prepare($query);
        foreach($array as $key => $value)
        {
            $stmt->bindValue(':' . $key, $value);
        }

        return is_object($stmt->execute());

    }

}