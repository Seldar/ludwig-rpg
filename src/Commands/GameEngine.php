<?php
/**
 * Created by PhpStorm.
 * User: Ulukut
 * Date: 19.12.2016
 * Time: 16:47
 *
 * @author Volkan Ulukut <arthan@gmail.com>
 */

namespace Ludwig\Commands;


use Ludwig\Controllers\Interactive;
use Ludwig\Models\SQLiteDataSource;

class GameEngine
{
    private $character;
    private $datasource;

    public function __construct($argv)
    {
        $this->datasource = new SQLiteDataSource();
        $game = new StartGame($argv, $this->datasource);
        $this->character = $game->getCharacter();
        $this->initiateGame();
    }

    public function initiateGame()
    {
        $quit = false;
        while (!$quit) {
            Interactive::consolePrint("You are at google.com. You can go [e]xplore the web from here. You can google [y]ourself. You can also ctrl+[s] your progress or just [c]lose the browser and [q]uit.");
            $input = Interactive::consoleInput();
            switch ($input) {
                case "e":
                    $this->explore();
                    break;
                case "y":
                    $this->checkProfile();
                    break;
                case "s":
                    $this->save();
                    break;
                case "c":
                    $quit = true;
                    break;
                case "q":
                    $quit = true;
                    break;
                default:
                    Interactive::consolePrint("Nothing selected.");
            }
        }
    }

    public function explore()
    {

    }

    public function checkProfile()
    {
        Interactive::consolePrint('Class: ' . $this->character->class->getClassName());
        Interactive::consolePrint('Algorithms: ' . $this->character->algorithms);
        Interactive::consolePrint('Performance: ' . $this->character->performance);
        Interactive::consolePrint('Persistence: ' . $this->character->persistence);
        Interactive::consolePrint('Experience: ' . $this->character->experience);
        Interactive::consolePrint('Level: ' . $this->character->level);
    }

    public function save()
    {
        $this->character->save();
        Interactive::consolePrint('Character Saved. Your load key is "' . $this->character->key . '" use `php ludwig.php resume ' . $this->character->key . '` to resume this character');
    }

}