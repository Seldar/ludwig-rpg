<?php
/**
 * Created by PhpStorm.
 * User: Ulukut
 * Date: 23.12.2016
 * Time: 16:05
 *
 * @author Volkan Ulukut <arthan@gmail.com>
 */

namespace Ludwig\Tests\Commands;


use Ludwig\Commands\GameEngine;
use Ludwig\Controllers\CodefighterClass;
use Ludwig\Models\SQLiteDataSource;
use Ludwig\Models\Character;

class GameEngineTest extends DbCase
{
    public function testiIntiateGameExplore()
    {
        $datasource = new SQLiteDataSource();
        $mockCharacter = $this->getMockBuilder(Character::class)
            ->setConstructorArgs(array($datasource))
            ->getMock();
        $mockCharacter->method('getLevel')
            ->willReturn(1);
        $mockCharacter->method('getClass')
            ->willReturn(new CodefighterClass());
        $mockCharacter->method('getAlgorithms')
            ->willReturn(7);
        $mockCharacter->method('getPerformance')
            ->willReturn(7);
        $mockCharacter->method('getPersistence')
            ->willReturn(6);
        $handler = fopen("php://memory", "w+");

        fputs($handler, "e\nq\n");
        rewind($handler);
        $gameEngine = new GameEngine($datasource, $handler, $mockCharacter);
        $gameEngine->initiateGame();

        $this->expectOutputRegex("/^Hello Ludwig.*uit.*While googling.*challenged by.*You [tried|showed+].*Hello.*uit./s");

    }

    public function testiIntiateGameProfile()
    {
        $datasource = new SQLiteDataSource();
        $mockCharacter = $this->getMockBuilder(Character::class)
            ->setConstructorArgs(array($datasource))
            ->getMock();
        $mockCharacter->method('getLevel')
            ->willReturn(1);
        $mockCharacter->method('getClass')
            ->willReturn(new CodefighterClass());
        $mockCharacter->method('getAlgorithms')
            ->willReturn(7);
        $mockCharacter->method('getPerformance')
            ->willReturn(7);
        $mockCharacter->method('getPersistence')
            ->willReturn(6);
        $handler = fopen("php://memory", "w+");

        fputs($handler, "y\nq\n");
        rewind($handler);
        $gameEngine = new GameEngine($datasource, $handler, $mockCharacter);
        $gameEngine->initiateGame();

        $this->expectOutputRegex("/^Hello Ludwig.*uit.*Class: Codefighter.*Title.*Algorithms: 7.*Performance: 7.*Persistence: 6.*Experience:.*Level: 1/s");

    }

    public function testiIntiateGameSave()
    {
        $datasource = new SQLiteDataSource();
        $mockCharacter = $this->getMockBuilder(Character::class)
            ->setConstructorArgs(array($datasource))
            ->getMock();
        $mockCharacter->method('getLevel')
            ->willReturn(1);
        $mockCharacter->method('getClass')
            ->willReturn(new CodefighterClass());
        $mockCharacter->method('getAlgorithms')
            ->willReturn(7);
        $mockCharacter->method('getPerformance')
            ->willReturn(7);
        $mockCharacter->method('getPersistence')
            ->willReturn(6);
        $handler = fopen("php://memory", "w+");

        fputs($handler, "s\nq\n");
        rewind($handler);
        $gameEngine = new GameEngine($datasource, $handler, $mockCharacter);
        $gameEngine->initiateGame();

        $this->expectOutputRegex("/^Hello Ludwig.*uit.*Character Saved.*Your load key is \"\s*\".*to resume this character/s");

    }
}
