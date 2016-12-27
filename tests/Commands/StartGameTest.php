<?php
/**
 * Created by PhpStorm.
 * User: Ulukut
 * Date: 26.12.2016
 * Time: 13:16
 *
 * @author Volkan Ulukut <arthan@gmail.com>
 */

namespace Ludwig\Tests\Commands;


use Ludwig\Commands\StartGame;
use Ludwig\Models\Character;
use Ludwig\Models\SQLiteDataSource;
use Ludwig\Tests\DbCase;

class StartGameTest extends DbCase
{
    public function testNewGameWithoutArgument()
    {
        $datasource = new SQLiteDataSource();
        $handler = fopen("php://memory", "w+");
        fputs($handler, "C\n2,2,1\nq\n");
        rewind($handler);

        new StartGame($datasource, $handler, ['']);

        $this->expectOutputRegex("/^Starting a new game.*Welcome to Ludwig.*Choose.*You are now.*Enter how many.*" .
            "You have successfully.*Class: [A-Za-z]+.*Title: [A-Za-z]+.*Algorithms: \d+.*Performance: \d+.*" .
            "Persistence: \d+.*Experience: \d+.*Level: \d+.*/s");
    }

    public function testNewGameWithArgument()
    {
        $datasource = new SQLiteDataSource();
        $handler = fopen("php://memory", "w+");
        fputs($handler, "C\n2,2,1\nq\n");
        rewind($handler);

        new StartGame($datasource, $handler, ['', 'new']);

        $this->expectOutputRegex("/^Starting a new game.*Welcome to Ludwig.*Choose.*You are now.*Enter how many.*" .
            "You have successfully.*Class: [A-Za-z]+.*Title: [A-Za-z]+.*Algorithms: \d+.*Performance: \d+.*" .
            "Persistence: \d+.*Experience: \d+.*Level: \d+.*/s");
    }

    public function testNewGameWithDefault()
    {
        $datasource = new SQLiteDataSource();
        $handler = fopen("php://memory", "w+");
        fputs($handler, "C\n2,2,1\nq\n");
        rewind($handler);

        new StartGame($datasource, $handler, ['', 'test']);

        $this->expectOutputRegex("/^Starting a new game.*Welcome to Ludwig.*Choose.*You are now.*Enter how many.*" .
            "You have successfully.*Class: [A-Za-z]+.*Title: [A-Za-z]+.*Algorithms: \d+.*Performance: \d+.*" .
            "Persistence: \d+.*Experience: \d+.*Level: \d+.*/s");
    }

    public function testResumeGame()
    {
        $datasource = new SQLiteDataSource();
        $handler = fopen("php://memory", "w+");
        fputs($handler, "C\n2,2,1\nq\n");
        rewind($handler);

        new StartGame($datasource, $handler, ['', 'resume', '56575ceaf426b7a4e819f74795f6dd23']);

        $this->expectOutputRegex("/^You successfully load your.*Class: [A-Za-z]+.*Title: [A-Za-z]+" .
            ".*Algorithms: 7.*Performance: 7.*Persistence: 7.*Experience: \d+.*Level: \d+.*/s");
    }

    public function testResumeGameArgumentException()
    {
        $datasource = new SQLiteDataSource();
        $handler = fopen("php://memory", "w+");
        fputs($handler, "C\n2,2,1\nq\n");
        rewind($handler);

        new StartGame($datasource, $handler, ['', 'resume']);

        $this->expectOutputRegex("/Exception/s");

    }

    public function testResumeGameKeyException()
    {
        $datasource = new SQLiteDataSource();
        $handler = fopen("php://memory", "w+");
        fputs($handler, "C\n2,2,1\nq\n");
        rewind($handler);

        new StartGame($datasource, $handler, ['', 'resume', 'test']);

        $this->expectOutputRegex("/Exception/s");
    }

    public function testGetCharachter()
    {
        $this->setOutputCallback(function () {
        });
        $datasource = new SQLiteDataSource();
        $handler = fopen("php://memory", "w+");
        fputs($handler, "C\n2,2,1\nq\n");
        rewind($handler);

        $startGame = new StartGame($datasource, $handler, ['', 'resume', '56575ceaf426b7a4e819f74795f6dd23']);

        $this->assertInstanceOf(Character::class, $startGame->getCharacter());

    }
}
