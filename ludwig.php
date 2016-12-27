<?php
/**
 * Created by PhpStorm.
 * User: Ulukut
 * Date: 19.12.2016
 * Time: 14:27
 *
 * @author Volkan Ulukut <arthan@gmail.com>
 */

include "vendor/autoload.php";

use Ludwig\Models\SQLiteDataSource;
use Ludwig\Commands\GameEngine;
use Ludwig\Commands\StartGame;

$datasource = new SQLiteDataSource();
$startGame = new StartGame($datasource, STDIN, $argv);
$command = new GameEngine($datasource, STDIN, $startGame->getCharacter());
$command->initiateGameLoop();