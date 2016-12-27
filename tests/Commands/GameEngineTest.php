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
use Ludwig\Models\Challenger;
use Ludwig\Models\IDataSource;
use Ludwig\Models\SQLiteDataSource;
use Ludwig\Models\Character;
use Ludwig\Tests\DbCase;

class GameEngineTest extends DbCase
{
    public function testiIntiateGame()
    {
        $datasource = new SQLiteDataSource();
        $handler = fopen("php://memory", "w+");
        $mockCharacter = $this->getMockedCharacter($datasource);
        $mockGameEngine = $this->getMockBuilder(GameEngine::class)
            ->setConstructorArgs(array($datasource, $handler, $mockCharacter))
            ->setMethods(array('explore','checkProfile','save'))
            ->getMock();
        $mockGameEngine->expects($this->any())->method('checkProfile');
        fputs($handler, "test\ne\n2,2,1\ny\ns\nc\n");
        rewind($handler);

        $mockGameEngine->initiateGameLoop();

        $this->expectOutputRegex("/^Hello Ludwig.*Nothing selected..*Hello Ludwig.*Hello Ludwig.*Hello Ludwig.*/s");
    }
    public function testExplore()
    {
        $datasource = new SQLiteDataSource();
        $mockCharacter = $this->getMockedCharacter($datasource);
        $handler = fopen("php://memory", "w+");
        fputs($handler, "2,2,1\n");
        rewind($handler);
        $mockGameEngine = $this->getMockBuilder(GameEngine::class)
            ->setConstructorArgs(array($datasource, $handler, $mockCharacter))
            ->setMethods(array('challenge'))
            ->getMock();

        $this->invokeMethod($mockGameEngine,"explore",[1]);

        $this->expectOutputRegex("/^While googling.*challenged by.*/s");

    }

    public function testChallenge()
    {
        $datasource = new SQLiteDataSource();
        $mockCharacter = $this->getMockedCharacter($datasource);
        $handler = fopen("php://memory", "w+");
        fputs($handler, "2,2,1\n");
        rewind($handler);
        $mockChallenger = $this->getMockBuilder(Challenger::class)
            ->setConstructorArgs(array($datasource))
            ->getMock();
        $mockChallenger->method('getFavoriteAttribute')
            ->willReturn('Persistence');
        $mockChallenger->method('getAttributePoint')
            ->willReturn(5);
        $mockChallenger->method('getName')
            ->willReturn("Sebastian Bergmann @ phpunit.de");
        $mockChallenger->method('getExperienceRewards')
            ->willReturn(1);

        $gameEngine = new GameEngine($datasource, $handler, $mockCharacter);
        $this->invokeMethod($gameEngine,"challenge",[$mockChallenger, 1]);

        $this->expectOutputRegex("/^You [tried|showed+].*/s");

    }

    public function testCheckProfile()
    {
        $datasource = new SQLiteDataSource();
        $mockCharacter = $this->getMockedCharacter($datasource);
        $handler = fopen("php://memory", "w+");

        $gameEngine = new GameEngine($datasource, $handler, $mockCharacter);
        $this->invokeMethod($gameEngine,"checkProfile");

        $this->expectOutputRegex("/^Class: Codefighter.*Title.*Algorithms: 7.*Performance: 7.*Persistence: 6.*Experience:.*Level: 1/s");

    }

    public function testSave()
    {
        $datasource = new SQLiteDataSource();
        $mockCharacter = $this->getMockedCharacter($datasource);
        $handler = fopen("php://memory", "w+");

        $gameEngine = new GameEngine($datasource, $handler, $mockCharacter);
        $this->invokeMethod($gameEngine,"save");

        $this->expectOutputRegex("/^Character Saved.*Your load key is \"\s*\".*to resume this character/s");

    }

    public function testLevelUp()
    {
        $datasource = new SQLiteDataSource();
        $mockCharacter = $this->getMockedCharacter($datasource);
        $handler = fopen("php://memory", "w+");
        fputs($handler, "2,2,2\n2,2,1\n");
        rewind($handler);
        $this->expectOutputRegex("/^Congratulations!.*Please distribute points.*Your new profile looks like this:/s");
        $mockGameEngine = $this->getMockBuilder(GameEngine::class)
            ->setConstructorArgs(array($datasource, $handler, $mockCharacter))
            ->setMethods(array('checkProfile'))
            ->getMock();
        $mockGameEngine->expects($this->once())->method('checkProfile');
        $this->invokeMethod($mockGameEngine,"levelUp");
    }

    public function getMockedCharacter(IDataSource $datasource)
    {
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
        $mockCharacter->method('earnExperience')
            ->willReturn(1);
        return $mockCharacter;
    }

    /**
     * Call protected/private method of a class.
     *
     * @param object &$object    Instantiated object that we will run method on.
     * @param string $methodName Method name to call
     * @param array  $parameters Array of parameters to pass into method.
     *
     * @return mixed Method return.
     */
    public function invokeMethod(&$object, $methodName, array $parameters = array())
    {
        $reflection = new \ReflectionClass(get_class($object));
        $method = $reflection->getMethod($methodName);
        $method->setAccessible(true);

        return $method->invokeArgs($object, $parameters);
    }
}
