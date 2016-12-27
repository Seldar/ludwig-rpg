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
     * Datasource to be used to persist data
     *
     * @var IDataSource
     */
    protected $datasource;

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
     * Model constructor.
     * Initializing properties
     *
     * @param IDataSource $datasource
     */
    public function __construct(IDataSource $datasource)
    {
        $this->datasource = $datasource;
    }

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
        if (is_array($array)) {
            $obj->arrayToProperties($array);
            return $obj;
        } else {
            return false;
        }

    }

    /**
     * Get the model data as an array.
     *
     * @return array
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