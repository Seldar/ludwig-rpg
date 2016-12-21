<?php
/**
 * Created by PhpStorm.
 * User: Ulukut
 * Date: 19.12.2016
 * Time: 14:39
 *
 * @author Volkan Ulukut <arthan@gmail.com>
 */

namespace Ludwig\Commands;

use Ludwig\Controllers\CodefighterClass;
use Ludwig\Controllers\HackerogueClass;
use Ludwig\Controllers\SoftwizardClass;
use Ludwig\Controllers\Interactive;
use Ludwig\Models\Character;
use Ludwig\Models\IDataSource;

class StartGame
{
    private $character;
    private $dataSource;

    public function __construct($argv, IDataSource $dataSource)
    {
        $this->dataSource = $dataSource;
        try {
            if (isset($argv[1])) {
                switch ($argv[1]) {
                    case "new":
                        $this->newGame();
                        break;
                    case "resume":
                        if (isset($argv[2])) {
                            $this->resumeGame($argv[2]);
                        } else {
                            throw new \Exception('Argument "saveKey" is missing');
                        }
                        break;
                    default:
                        $this->newGame();
                }
            } else {
                $this->newGame();
            }
        } catch (\Exception $e) {
            Interactive::consolePrint("**Exception**: " . $e->getMessage());
            exit;
        }
    }

    private function newGame()
    {
        Interactive::consolePrint('Starting a new game...');
        Interactive::consolePrint('Welcome to Ludwig RPG. You are Ludwig a young programmer, who tries to gain experience in various parts of the internet by fighting challengers.');
        $this->createCharacter();
    }

    private function resumeGame($saveKey)
    {
        try {
            $this->character = Character::readById($saveKey, $this->dataSource);
            if ($this->character) {
                Interactive::consolePrint('You successfully load your ' . $this->character->class->getClassName() . ' with below stats: ');
                Interactive::consolePrint('Algorithms: ' . $this->character->algorithms);
                Interactive::consolePrint('Performance: ' . $this->character->performance);
                Interactive::consolePrint('Persistence: ' . $this->character->persistence);
                Interactive::consolePrint('Experience: ' . $this->character->experience);
                Interactive::consolePrint('Level: ' . $this->character->level);
            } else {
                throw new \Exception('The load key you\'ve entered does not exists.');
            }
        } catch (\Exception $e) {
            Interactive::consolePrint("**Exception**: " . $e->getMessage());
            exit;
        }
    }

    private function createCharacter()
    {
        Interactive::consolePrint('Choose your class: ([C]odefighter(default), [H]ackerogue, [S]oftwizard)');
        $class = Interactive::consoleInput();
        switch ($class) {
            case "H":
                $classObject = new HackerogueClass();
                break;
            case "S":
                $classObject = new SoftwizardClass();
                break;
            default:
                $classObject = new CodefighterClass();
                break;
        }

        Interactive::consolePrint('You are now a ' . $classObject->getClassName());
        Interactive::consolePrint('Now you can improve your character with freebies. You have 5 freebies to distribute among your attributes.');
        Interactive::consolePrint('Enter how many freebies you are going to commit for each attribute (Algorithms, Performance, Persistance) seperated by comma respectively');

        do {
            if(isset($freebies))
            {
                Interactive::consolePrint('Please commit points with sum of exactly 5 seperated by comma');
            }
            $line = Interactive::consoleInput();
            $freebies = explode(",", $line);
        } while (array_sum($freebies) <> 5);

        $character = new Character($this->dataSource);
        $character->createCharacter($classObject,0,$freebies);

        Interactive::consolePrint('You have successfully created your ' . $character->class->getClassName() . ' with below stats: ');
        Interactive::consolePrint('Algorithms: ' . $character->algorithms);
        Interactive::consolePrint('Performance: ' . $character->performance);
        Interactive::consolePrint('Persistence: ' . $character->persistence);
        $this->character = $character;
    }

    public function getCharacter()
    {
        return $this->character;
    }
}