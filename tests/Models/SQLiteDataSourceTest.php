<?php
/**
 * Created by PhpStorm.
 * User: Ulukut
 * Date: 26.12.2016
 * Time: 15:08
 *
 * @author Volkan Ulukut <arthan@gmail.com>
 */

namespace Ludwig\Tests\Models;


use Ludwig\Tests\DbCase;
use Ludwig\Models\SQLiteDataSource;

class SQLiteDataSourceTest extends DbCase
{

    /**
     * Test for reading a record with primary key from database
     */
    public function testReadOne()
    {
        $controller = new SQLiteDataSource();

        $result = $controller->readOne('characters', 'key', '56575ceaf426b7a4e819f74795f6dd23');
        $this->assertEquals(array(
            'key' => '56575ceaf426b7a4e819f74795f6dd23',
            'experience' => 4,
            'algorithms' => 7,
            'performance' => 7,
            'class' => 'Hackerogue',
            0 => '56575ceaf426b7a4e819f74795f6dd23',
            1 => 4,
            2 => 7,
            3 => 7,
            4 => 7,
            'persistence' => 7,
            5 => 'Hackerogue'
        ), $result);
    }

    /**
     * Test for reading a record with custom fields from database
     */
    public function testReadBy()
    {
        $controller = new SQLiteDataSource();

        $result = $controller->readBy('characters', array('class' => 'Hackerogue'));
        $this->assertEquals(array(
            'key' => '56575ceaf426b7a4e819f74795f6dd23',
            'experience' => 4,
            'algorithms' => 7,
            'performance' => 7,
            'class' => 'Hackerogue',
            0 => '56575ceaf426b7a4e819f74795f6dd23',
            1 => 4,
            2 => 7,
            3 => 7,
            4 => 7,
            'persistence' => 7,
            5 => 'Hackerogue'
        ), $result[0]);
    }

    /**
     * Test for creating a new record in the database
     */
    public function testCreate()
    {
        $controller = new SQLiteDataSource();

        $result = $controller->create('characters', array(
            'key' => 'test',
            'experience' => 4,
            'algorithms' => 7,
            'performance' => 7,
            'class' => 'Hackerogue',
            'persistence' => 7));
        $this->assertGreaterThan(0, $result);

    }

    /**
     * Test for updating a row in the database
     */
    public function testUpdate()
    {
        $controller = new SQLiteDataSource();

        $result = $controller->update('characters', 'key', (array('key' => '56575ceaf426b7a4e819f74795f6dd23', 'class' => 'Softwizard')));
        $this->assertTrue($result);
    }

    public function testQuery()
    {
        $sutClass = new SQLiteDataSource();
        $result = $sutClass->query("SELECT * FROM characters WHERE key = :key", ['key' => '56575ceaf426b7a4e819f74795f6dd23']);
        $this->assertSame(
            [
                0 => '56575ceaf426b7a4e819f74795f6dd23',
                'key' => '56575ceaf426b7a4e819f74795f6dd23',
                1 => 4,
                'experience' => 4,
                2 => 7,
                'algorithms' => 7,
                3 => 7,
                'performance' => 7,
                4 => 7,
                'persistence' => 7,
                5 => 'Hackerogue',
                'class' => 'Hackerogue'
            ], $result[0]);
    }
}
