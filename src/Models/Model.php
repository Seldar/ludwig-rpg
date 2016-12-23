<?php
/**
 * Created by PhpStorm.
 * User: Ulukut
 * Date: 12.10.2016
 * Time: 17:21
 *
 * @author Volkan Ulukut <arthan@gmail.com>
 */

namespace Ludwig\Models;


/**
 * Class Model
 * Class to define datasource entities
 *
 * @package Simplechat\Models
 */
abstract class Model
{
    /**
     * Name of the table that this model represents
     *
     * @var string
     */
    protected $tableName;

    /**
     * Primary key of the table that this model represents
     *
     * @var string
     */
    protected $primaryKey;

    /**
     * Get the table name of the model.
     *
     * @return string
     */
    public function getTableName()
    {
        return $this->tableName;
    }

    /**
     * Get the primary key of the models table.
     *
     * @return string
     */
    public function getPrimaryKey()
    {
        return $this->primaryKey;
    }

    /**
     * Create an object and save it to datasource with an array.
     *
     * @param array $array User array to initiate model with
     * @param IDataSource $datasource datasource to initiate with
     *
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
     * Read a row from datasource using primary key
     *
     * @param int $id
     * @param IDataSource $datasource
     *
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
     * Read one or more rows using custom condition
     *
     * @param array $conditions
     * @param IDataSource $datasource
     *
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
     * Update current object in the datasource.
     *
     * @param IDatasource $datasource
     *
     * @return mixed
     */
    public function update(IDataSource $datasource)
    {
        return $datasource->update($this->getTableName(), $this->getPrimaryKey(), $this->toArray());
    }

    /**
     * Get the model data as an array.
     *
     * @return array;
     */
    abstract public function toArray();

    /**
     * Update property values with the given array
     *
     * @param array $array Array of values to be set to properties.
     */
    abstract public function arrayToProperties(array $array);

    /**
     * Executes a custom query on datasource
     *
     * @param IDataSource $datasource
     * @param string $query
     * @param array $bindValues
     *
     * @return mixed
     */
    public static function query(IDataSource $datasource, $query, $bindValues = [])
    {
        return $datasource->query($query, $bindValues);
    }
}