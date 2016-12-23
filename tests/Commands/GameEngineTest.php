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
use Ludwig\Models\SQLiteDataSource;
use Ludwig\Models\Character;

class GameEngineTest extends DbCase
{
    public function testInitiateGame()
    {
        $datasource = new SQLiteDataSource();
        $mockCharacter = $this->getMockBuilder(Character::class)
            ->setConstructorArgs(array($datasource))
            ->getMock();
        $handler = fopen("php://memory","w+");
        fputs($handler, "e\n");
        rewind($handler);
        $gameEngine = new GameEngine($datasource, $handler, $mockCharacter);
        $gameEngine->initiateGame();

        /*ob_start();
        ob_implicit_flush(0);
        $result = ob_get_clean();
        var_dump($result);*/
        $this->expectOutputString("hello world");
        exit;
        //fwrite(STDOUT,"q" . PHP_EOL);
    }
}
