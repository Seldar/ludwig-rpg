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
use Ludwig\Models\Challenger;
use Ludwig\Models\Character;
use Ludwig\Models\IDataSource;


/**
 * Class GameEngine
 * Main Game logic
 *
 * @package Ludwig\Commands
 */
class GameEngine extends Command
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
     * GameEngine constructor.
     *
     * @param IDataSource $datasource
     * @param resource $handle input stream resource
     * @param Character $character
     */
    public function __construct(IDataSource $datasource, $handle, Character $character)
    {
        $this->datasource = $datasource;
        $this->character = $character;
        $this->handle = $handle;
    }

    /**
     * Initiates the main game loop that runs until user quits.
     */
    public function initiateGame()
    {
        $quit = false;
        Interactive::consolePrint("Hello Ludwig. You are at google.com. You can go [e]xplore the web from here. You can google [y]ourself. You can also ctrl+[s] your progress or just [c]lose the browser and [q]uit.");
        $input = Interactive::consoleInput($this->handle);
        switch ($input) {
            case "e":
                $this->explore(rand(5, 20) / 10);
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
        if (!$quit) {
            $this->initiateGame();
        }
    }

    /**
     * Checks the datasource for challengers giving xp equal to character level.
     * Initiates Challenge
     *
     * @param float $random Random multiplier to use in challenges. Makes testing easier.
     */
    public function explore($random)
    {
        $challenger = new Challenger($this->datasource);
        $challenger->queryRandomChallenger($this->character->getLevel());
        $challenger_details = explode("@", $challenger->getName());
        Interactive::consolePrint("While googling around you clicked a link on \033[31m" . trim($challenger_details[1]) . "\033[0m and while browsing you have been challenged by : \033[32m" . trim($challenger_details[0]) . "\033[0m!");
        $this->challenge($challenger, $random);
    }

    /**
     * Calculates attribute points of both character and challenger then checks for the winner.
     * If the character wins, get xp equal to reward_experience of the challenger. Checks and
     * initiates leveling up logic.
     *
     * @param Challenger $challenger Challenger Object
     * @param float $random Random number between 0.5-2
     */
    public function challenge(Challenger $challenger, $random)
    {
        $char_attribute_point = $this->character->{"get" . ($challenger->getFavoriteAttribute())}() * $random * $this->character->getClass()->getMultiplier($challenger->getFavoriteAttribute());
        if ($char_attribute_point > $challenger->getAttributePoint()) {
            Interactive::consolePrint("You showed off some real coding skills on \033[31m" . $challenger->getFavoriteAttribute() . "\033[0m and scored: \033[37m" . $char_attribute_point . "  \033[32m" . $challenger->getName() . "\033[0m with score " . $challenger->getAttributePoint() . " was both amazed and overwhelmed! You won the challenge and gained " . $challenger->getExperienceRewards() . ' experience!');
            $leveled_up = $this->character->earnExperience($challenger->getExperienceRewards());
            if ($leveled_up) {
                $this->levelUp();
            }
        } else {
            Interactive::consolePrint("You tried your best with a score of " . $char_attribute_point . " but you couldn't outcode  \033[32m" . $challenger->getName() . "\033[0m who has a score of " . $challenger->getAttributePoint());
        }
    }

    /**
     * Levels up the character and distribute freebies to character attributes using console input.
     */
    public function levelUp()
    {
        Interactive::consolePrint("Congratulations! You leveled up. You are now known as a " . $this->character->getTitle());
        Interactive::consolePrint('Now you can improve your character with freebies. You have 5 freebies to distribute among your attributes.');
        Interactive::consolePrint('Enter how many freebies you are going to commit for each attribute (Algorithms, Performance, Persistance) seperated by comma respectively');
        do {
            if (isset($freebies)) {
                Interactive::consolePrint('Please commit points with sum of exactly 5 seperated by comma');
            }
            $line = Interactive::consoleInput($this->handle);
            $freebies = explode(",", $line);
        } while (array_sum($freebies) <> 5);

        $this->character->increaseAlgorithms($freebies[0]);
        $this->character->increasePerformance($freebies[1]);
        $this->character->increasePersistence($freebies[2]);
        Interactive::consolePrint('Your new profile looks like this:');
        $this->checkProfile();
    }

    /**
     * Save the current character progress with all attributes and experience.
     */
    public function save()
    {
        $this->character->save();
        Interactive::consolePrint('Character Saved. Your load key is "' . $this->character->getKey() . '" use `php ludwig.php resume ' . $this->character->getKey() . '` to resume this character');
    }

}