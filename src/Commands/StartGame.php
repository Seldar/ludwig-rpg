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
     * Holds the Character object.
     *
     * @var Character
     */
    protected $character;

    /**
     * Holds the input resource.
     *
     * @var resource
     */
    private $handle;

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

    /**
     * Initiates starting a fresh game logic
     */
    private function newGame()
    {
        Interactive::consolePrint('Starting a new game...');
        Interactive::consolePrint('Welcome to Ludwig RPG. You are Ludwig a young programmer, who tries to gain experience in various parts of the internet by fighting challengers.');
        $this->createCharacter();
    }

    /**
     * Loads a character using save key.
     *
     * @param string $saveKey Save key to be used to load a character
     */
    private function resumeGame($saveKey)
    {
        try {
            $this->character = Character::readById($saveKey, $this->datasource);
            if ($this->character) {
                Interactive::consolePrint('You successfully load your ' . $this->character->getClass()->getClassName() . ' with below stats: ');
                $this->checkProfile();
            } else {
                throw new \Exception('The load key you\'ve entered does not exists.');
            }
        } catch (\Exception $e) {
            Interactive::consolePrint("**Exception**: " . $e->getMessage());
            exit;
        }
    }

    /**
     * Create a fresh new character
     */
    private function createCharacter()
    {
        $character = new Character($this->datasource);
        do {
            Interactive::consolePrint('Choose your class: ([C]odefighter, [H]ackerogue, [S]oftwizard)');
            $class = Interactive::consoleInput($this->handle);
        } while (!$character->setClass($class));

        Interactive::consolePrint('You are now a ' . $character->getClass()->getClassName());
        Interactive::consolePrint('Now you can improve your character with freebies. You have 5 freebies to distribute among your attributes.');
        Interactive::consolePrint('Enter how many freebies you are going to commit for each attribute (Algorithms, Performance, Persistance) seperated by comma respectively');

        do {
            if (isset($freebies)) {
                Interactive::consolePrint('Please commit points with sum of exactly 5 seperated by comma');
            }
            $line = Interactive::consoleInput($this->handle);
            $freebies = explode(",", $line);
        } while (array_sum($freebies) <> 5);

        $character->createCharacter(0, $freebies);
        Interactive::consolePrint('You have successfully created your ' . $character->getClass()->getClassName() . ' with below stats: ');
        $this->character = $character;
        $this->checkProfile();
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
}