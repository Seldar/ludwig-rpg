<?php
/**
 * Created by PhpStorm.
 * User: Ulukut
 * Date: 23.12.2016
 * Time: 16:12
 *
 * @author Volkan Ulukut <arthan@gmail.com>
 */

namespace Ludwig\Tests;


class DbCase extends \PHPUnit_Extensions_Database_TestCase
{
    /**
     * Connecting to database
     *
     * @return \PHPUnit_Extensions_Database_DB_IDatabaseConnection
     */
    public function getConnection()
    {
        $pdo = new \PDO('sqlite:db/ludwig.db');
        return $this->createDefaultDBConnection($pdo, 'db/ludwig.db');
    }

    /**
     * Creating fixture
     *
     * @return \PHPUnit_Extensions_Database_DataSet_IDataSet
     */
    public function getDataSet()
    {
        return $this->createFlatXMLDataSet('db/ludwig-seed.xml');
    }

}