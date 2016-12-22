<?php
/**
 * Created by PhpStorm.
 * User: Ulukut
 * Date: 12.10.2016
 * Time: 17:21
 * @author Volkan Ulukut <arthan@gmail.com>
 */

namespace Ludwig\Models;


/**
 * Class Model
 * Class to define datasource entities
 * @package Simplechat\Models
 */
abstract class Model
{
    /**
     * name of the table that this model represents
     * @var string
     */
    protected $tableName;

    /**
     * primary key of the table that this model represents
     * @var string
     */
    protected $primaryKey;

    /**
     * get the table name of the model.
     * @return string
     */
    public function getTableName()
    {
        return $this->tableName;
    }

    /**
     * get the primary key of the models table.
     * @return string
     */
    public function getPrimaryKey()
    {
        return $this->primaryKey;
    }

    /**
     *  create an object and save it to datasource with an array.
     * @param array $array User array to initiate model with
     * @param IDataSource $datasource datasource to initiate with
     * @return Model
     */
    public static function createFromArray($array, IDataSource $datasource)
    {
        $obj = new static($datasource);
        $array[$obj->getPrimaryKey()] = $datasource->create($obj->getTableName(), $array);
        $obj->arrayToProperties($array);
        return $obj;
    }

    /**
     * read a row from datasource using primary key
     * @param int $id
     * @param IDataSource $datasource
     * @return Model|bool
     */
    public static function readById($id, IDataSource $datasource)
    {
        $obj = new static($datasource);
        $array = $datasource->readOne($obj->getTableName(), $obj->getPrimaryKey(), $id);
        if ($array) {
            $obj->arrayToProperties($array);
            return $obj;
        } else {
            return false;
        }

    }

    /**
     * read one or more rows using custom condition
     * @param array $conditions
     * @param IDataSource $datasource
     * @return array
     */
    public static function readBy($conditions, IDataSource $datasource)
    {
        $response = array();
        $obj = new static();
        $result = $datasource->readBy($obj->getTableName(), $conditions);
        foreach ($result as $array) {
            $obj->arrayToProperties($array);
            $response[] = clone $obj;
        }

        return $response;
    }

    /**
     * update current object in the datasource.
     * @param IDatasource $datasource
     * @return mixed
     */
    public function update(IDataSource $datasource)
    {
        return $datasource->update($this->getTableName(), $this->getPrimaryKey(), $this->toArray());
    }


    /**
     * get model properties as an array.
     * @return array
     */
    abstract public function toArray();

    /**
     * update property values with the given array
     * @param $array
     * @return void
     */
    abstract public function arrayToProperties($array);

    public static function query(IDataSource $datasource, $query, $bindValues = [])
    {
        return $datasource->query($query, $bindValues);
    }
}