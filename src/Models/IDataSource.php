<?php
/**
 * Created by PhpStorm.
 * User: Ulukut
 * Date: 12.10.2016
 * Time: 16:02
 * @author Volkan Ulukut <arthan@gmail.com>
 */

namespace Ludwig\Models;


/**
 * Interface IDataSource
 * Interface to define a template for datasources
 * @package Simplechat\Models
 */
interface IDataSource
{
    /**
     * All DataSources should implement connect to connect the datasource.
     * @return mixed
     */
    public function connect();

    /**
     * All DataSources should implement reading from the datasource.
     * @param string $tableName
     * @param string $primaryKey
     * @param integer $primaryId
     * @return Model
     */
    public function readOne($tableName,$primaryKey, $primaryId);

    /**
     * All DataSources should implement reading with custom conditions from the datasource.
     * @param string $tableName
     * @param array $conditions
     * @return array
     */
    public function readBy($tableName, $conditions);

    /**
     * All DataSources should implement creating from the datasource.
     * @param string $tableName
     * @param array $array
     * @return mixed
     */
    public function create($tableName,$array);

    /**
     * All DataSources should implement update from the datasource.
     * @param string $tableName
     * @param string $primaryKey
     * @param array $array
     * @return mixed
     */
    public function update($tableName,$primaryKey,$array);

    public function query($query,$bindValues);
}