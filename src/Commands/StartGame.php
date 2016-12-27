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

use Ludwig\Controllers\Interactive;
use Ludwig\Models\Character;
use Ludwig\Models\IDataSource;

/**
 * Class StartGame
 * Game Starting Logic
 *
 * @package Ludwig\Commands
 */
class StartGame extends Command
{

    /**
     * StartGame constructor.
     *
     * @param IDataSource $dataSource Datasource object to be used for persistence
     * @param resource $handle input stream resource
     * @param array $argv Arguments passed to console command
     */
    public function __construct(IDataSource $dataSource, $handle, array $argv)
    {
        $this->handle = $handle;
        $this->datasource = $dataSource;
        try {
            $this->executeCommand($argv);
        } catch (\Exception $e) {
            Interactive::consolePrint("**Exception**: " . $e->getMessage());
        }
    }

    /**
     * Executes command given by the user
     *
     * @param array $command
     *
     * @throws \Exception
     *
     * @return bool
     */
    private function executeCommand(array $command)
    {
        if (isset($command[1])) {
            switch ($command[1]) {
                case "new":
                    $this->newGame();
                    break;
                case "resume":
                    if (isset($command[2])) {
                        $this->resumeGame($command[2]);
                    } else {
                        throw new \Exception('Argument "saveKey" is missing');
                    }
                    break;
                default:
                    throw new \Exception('Undefined parameter: ' . $command[1]);
            }
        } else {
            $this->newGame();
        }
        return true;
    }

    /**
     * Returns Character object of the game
     *
     * @return Character
     */
    public function getCharacter()
    {
        return $this->character;
    }

    /**
     * Initiates starting a fresh game logic
     */
    private function newGame()
    {
        Interactive::consolePrint('Starting a new game...');
        Interactive::consolePrint('Welcome to Ludwig RPG. You are Ludwig a young programmer, who tries to gain experience in various parts of the internet by fighting challengers.');
        $this->prepareCharacter(new Character($this->datasource));
    }

    /**
     * Loads a character using save key.
     *
     * @param string $saveKey Save key to be used to load a character
     */
    private function resumeGame($saveKey)
    {
        try {
            $result = Character::readById($saveKey, $this->datasource);
            if ($result !== false && is_a($result, Character::class)) {
                $this->character = $result;
                Interactive::consolePrint('You successfully load your ' . $this->character->getClass()->getClassName() . ' with below stats: ');
                $this->checkProfile();
                Interactive::consolePrint('Welcome to Ludwig RPG. You are Ludwig a young programmer, who tries to gain experience in various parts of the internet by fighting challengers.');
            } else {
                throw new \Exception('The load key you\'ve entered does not exists.');
            }
        } catch (\Exception $e) {
            Interactive::consolePrint("**Exception**: " . $e->getMessage());
        }
    }

    /**
     * Prepare a new character
     *
     * @param Character $character
     */
    private function prepareCharacter(Character $character)
    {

        $character = $this->chooseClass($character);
        Interactive::consolePrint('You are now a ' . $character->getClass()->getClassName());
        Interactive::consolePrint('Now you can improve your character with freebies. You have 10 freebies to distribute among your attributes.');
        Interactive::consolePrint('Enter how many freebies you are going to commit for each attribute (Algorithms, Performance, Persistance) seperated by comma respectively');
        $character->createCharacter(0, $this->getFreebieDistribution(10));
        Interactive::consolePrint('You have successfully created your ' . $character->getClass()->getClassName() . ' with below stats: ');
        $this->character = $character;
        $this->checkProfile();
    }

    /**
     * Choose class for the character by getting user input
     *
     * @param Character $character
     *
     * @return Character
     */
    private function chooseClass(Character $character)
    {
        do {
            Interactive::consolePrint('Choose your class: ([C]odefighter, [H]ackerogue, [S]oftwizard)');
            $class = Interactive::consoleInput($this->handle);
        } while ($character->setClass($class) === false);
        return $character;
    }


}