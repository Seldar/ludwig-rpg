<?php
/**
 * Created by PhpStorm.
 * User: Ulukut
 * Date: 26.12.2016
 * Time: 15:52
 *
 * @author Volkan Ulukut <arthan@gmail.com>
 */

namespace Ludwig\Tests\Models;


use Ludwig\Controllers\CodefighterClass;
use Ludwig\Controllers\HackerogueClass;
use Ludwig\Controllers\SoftwizardClass;
use Ludwig\Models\Character;
use Ludwig\Models\SQLiteDataSource;
use Ludwig\Tests\DbCase;

class CharacterTest extends DbCase
{
    public function testCreateCharacter()
    {
        $sutClass = new Character(new SQLiteDataSource());
        $sutClass->createCharacter(50, [7, 8, 10]);
        $this->assertSame(
            [
                50,
                12,
                13,
                15,
                3
            ],
            [
                $sutClass->getExperience(),
                $sutClass->getAlgorithms(),
                $sutClass->getPerformance(),
                $sutClass->getPersistence(),
                $sutClass->getLevel(),
            ]
        );
    }

    public function testEarnExperience()
    {
        $sutClass = new Character(new SQLiteDataSource());
        $this->assertTrue($sutClass->earnExperience(10));
        $this->assertSame(2, $sutClass->getLevel());
        $this->assertSame('Junior Developer', $sutClass->getTitle());
    }

    public function testUpdateLevel()
    {
        $sutClass = new Character(new SQLiteDataSource());
        $this->assertFalse($sutClass->updateLevel(false));
        $this->assertSame(1, $sutClass->getLevel());
        $this->assertSame('Intern', $sutClass->getTitle());
    }

    public function testGetterSetter()
    {
        $expected = [
            'key' => 1,
            'class' => 'Codefighter',
            'experience' => 100,
            'algorithms' => 16,
            'performance' => 17,
            'persistence' => 17
        ];
        $sutClass = new Character(new SQLiteDataSource());
        $sutClass->arrayToProperties($expected);
        $this->assertSame($expected, $sutClass->toArray());
    }

    public function testSetClass()
    {
        $sutClass = new Character(new SQLiteDataSource());
        $sutClass->setClass('S');
        $this->assertInstanceOf(SoftwizardClass::class,$sutClass->getClass());
        $sutClass->setClass('C');
        $this->assertInstanceOf(CodefighterClass::class,$sutClass->getClass());
        $sutClass->setClass('H');
        $this->assertInstanceOf(HackerogueClass::class,$sutClass->getClass());
        $this->assertFalse($sutClass->setClass('fail'));
    }

    public function testSave()
    {
        $db = new SQLiteDataSource();
        $sutClass = new Character($db);
        $sutClass->createCharacter(50, [7, 8, 10]);
        $sutClass->setClass('C');
        $sutClass->save();
        $this->assertRegExp('/^[a-f0-9]{32}$/i', $sutClass->getKey());
        $result = $db->readOne('characters', 'key', $sutClass->getKey());
        $this->assertSame(
            [
                0 => $sutClass->getKey(),
                'key' => $sutClass->getKey(),
                1 => 50,
                'experience' => 50,
                2 => 12,
                'algorithms' => 12,
                3 => 13,
                'performance' => 13,
                4 => 15,
                'persistence' => 15,
                5 => 'Codefighter',
                'class' => 'Codefighter'
            ], $result);
    }
}
