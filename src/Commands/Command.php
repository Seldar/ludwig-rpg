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
class Command
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
     * Prints out the attributes of current character.
     */
    public function checkProfile()
    {
        Interactive::consolePrint('Class: ' . $this->character->getClass()->getClassName());
        Interactive::consolePrint('Title: ' . $this->character->getTitle());
        Interactive::consolePrint('Algorithms: ' . $this->character->getAlgorithms());
        Interactive::consolePrint('Performance: ' . $this->character->getPerformance());
        Interactive::consolePrint('Persistence: ' . $this->character->getPersistence());
        Interactive::consolePrint('Experience: ' . $this->character->getExperience());
        Interactive::consolePrint('Level: ' . $this->character->getLevel());
    }
}