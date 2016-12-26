<?php
/**
 * Created by PhpStorm.
 * User: Ulukut
 * Date: 26.12.2016
 * Time: 16:32
 *
 * @author Volkan Ulukut <arthan@gmail.com>
 */

namespace Ludwig\Tests\Models;


use Ludwig\Models\SQLiteDataSource;
use Ludwig\Tests\DbCase;
use Ludwig\Models\Level;

class LevelTest extends DbCase
{
    public function testGetLevelByExperience()
    {
        $result = Level::getLevelByExperience(new SQLiteDataSource(), 150);
        $this->assertSame(4, $result->getLevel());
    }

    public function testGetterSetter()
    {
        $expected = [
            'level' => 1,
            'min_exp' => 0,
            'title' => 'Intern'
        ];
        $sutClass = new Level(new SQLiteDataSource());
        $sutClass->arrayToProperties($expected);
        $this->assertSame($expected, $sutClass->toArray());
    }

}
