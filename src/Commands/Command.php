<?php
/**
 * Created by PhpStorm.
 * User: Ulukut
 * Date: 22.12.2016
 * Time: 13:18
 *
 * @author Volkan Ulukut <arthan@gmail.com>
 */

namespace Ludwig\Commands;

use Ludwig\Controllers\Interactive;
use Ludwig\Models\Character;
use Ludwig\Models\IDataSource;

/**
 * Class Command
 *
 * @package Ludwig\Commands
 */
abstract class Command
{
    /**
     * Holds the Character object.
     *
     * @var Character
     */
    protected $character;

    /**
     * Holds the datasource object.
     *
     * @var IDataSource
     */
    protected $datasource;

    /**
     * Holds the input resource.
     *
     * @var resource
     */
    protected $handle;

    /**
     * Prints out the attributes of current character.
     */
    protected function checkProfile()
    {
        Interactive::consolePrint('Class: ' . $this->character->getClass()->getClassName());
        Interactive::consolePrint('Title: ' . $this->character->getTitle());
        Interactive::consolePrint('Algorithms: ' . $this->character->getAlgorithms());
        Interactive::consolePrint('Performance: ' . $this->character->getPerformance());
        Interactive::consolePrint('Persistence: ' . $this->character->getPersistence());
        Interactive::consolePrint('Experience: ' . $this->character->getExperience());
        Interactive::consolePrint('Level: ' . $this->character->getLevel());
    }

    /**
     * Get Freebie distribution from user input
     *
     * @param int $freebieCount How many freebies should be distributed
     *
     * @return array
     */
    protected function getFreebieDistribution($freebieCount)
    {
        do {
            if (isset($freebies)) {
                Interactive::consolePrint('Please distribute points with sum of exactly ' . $freebieCount . ' seperated by comma');
            }
            $line = Interactive::consoleInput($this->handle);
            $freebies = explode(",", $line);
        } while (array_sum($freebies) <> $freebieCount);
        return $freebies;
    }
}