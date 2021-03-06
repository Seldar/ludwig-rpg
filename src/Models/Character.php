<?php
/**
 * Created by PhpStorm.
 * User: Ulukut
 * Date: 19.12.2016
 * Time: 16:01
 *
 * @author Volkan Ulukut <arthan@gmail.com>
 */

namespace Ludwig\Models;


use Ludwig\Controllers\AbstractClass;
use Ludwig\Controllers\HackerogueClass;
use Ludwig\Controllers\SoftwizardClass;
use Ludwig\Controllers\CodefighterClass;

/**
 * Class Character
 *
 * @package Ludwig\Models
 */
class Character extends Model
{
    /**
     * Datasource to be used to persist data
     *
     * @var IDataSource
     */
    protected $datasource;

    /**
     * Primary key which is used to load the character
     *
     * @var string
     */
    private $key;

    /**
     * Class object identifying Characters class
     *
     * @var AbstractClass
     */
    private $class;

    /**
     * Current Experience point of the character
     *
     * @var int
     */
    private $experience = 0;

    /**
     * Current level of the character
     *
     * @var int
     */
    private $level = 0;

    /**
     * Current title of the character
     *
     * @var string
     */
    private $title = 'Intern';

    /**
     * The value of algorithm attribute
     *
     * @var int
     */
    private $algorithms = 5;
    /**
     * The value of performance attribute
     *
     * @var int
     */
    private $performance = 5;

    /**
     * The value of persistence attribute
     *
     * @var int
     */
    private $persistence = 5;

    /**
     * Character constructor.
     * Initializing properties
     *
     * @param IDataSource $datasource
     */
    public function __construct(IDataSource $datasource)
    {
        parent::__construct($datasource);
        $this->tableName = "characters";
        $this->primaryKey = "key";
    }

    /**
     * Getter for Key
     *
     * @return string
     */
    public function getKey()
    {
        return $this->key;
    }

    /**
     * Getter for character Class
     *
     * @return AbstractClass
     */
    public function getClass()
    {
        return $this->class;
    }

    /**
     * Getter for experience
     *
     * @return int
     */
    public function getExperience()
    {
        return $this->experience;
    }

    /**
     * Getter for level
     *
     * @return int
     */
    public function getLevel()
    {
        return $this->level;
    }

    /**
     * Getter for title
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Getter for algorithms attribute
     *
     * @return int
     */
    public function getAlgorithms()
    {
        return $this->algorithms;
    }

    /**
     * Getter for performance attribute
     *
     * @return int
     */
    public function getPerformance()
    {
        return $this->performance;
    }

    /**
     * Getter for persistance attribute
     *
     * @return int
     */
    public function getPersistence()
    {
        return $this->persistence;
    }

    /**
     * Creates a new character with the given parameters
     *
     * @param int $experience
     * @param array $freebies
     */
    public function createCharacter($experience, array $freebies)
    {
        $this->experience = $experience;
        $this->increaseAttributes($freebies);
        $this->updateLevel(false);
    }

    /**
     * Increase attribute points
     *
     * @param array $freebies
     */
    public function increaseAttributes(array $freebies)
    {
        $this->algorithms += $freebies[0];
        $this->performance += $freebies[1];
        $this->persistence += $freebies[2];
    }

    /**
     * Increase experience and check for levelup
     *
     * @param int $xp
     *
     * @return bool
     */
    public function earnExperience($xp)
    {
        $this->experience += $xp;
        return $this->updateLevel(true);
    }

    /**
     * Checks if current experience triggers a level change
     * Updates level and returns true when a level up is required
     *
     * @param bool $withLevelUp Should this method trigger a level up or not
     *
     * @return bool
     */
    public function updateLevel($withLevelUp)
    {
        $leveled_up = false;
        $level = Level::getLevelByExperience($this->datasource, $this->experience);
        if ($this->level < $level->getLevel()) {
            if ($withLevelUp) {
                $leveled_up = true;
            }
            $this->level = $level->getLevel();
            $this->title = $level->getTitle();
        }
        return $leveled_up;
    }

    /**
     * Update property values with the given array
     *
     * @param array $array Array of values to be set to properties.
     */
    public function arrayToProperties(array $array)
    {
        $array += array_fill_keys(['key', 'class', 'experience', 'algorithms', 'performance', 'persistence'], null);
        $this->key = $array['key'];
        $this->setClass($array['class'][0]);
        $this->experience = $array['experience'];
        $this->algorithms = $array['algorithms'];
        $this->performance = $array['performance'];
        $this->persistence = $array['persistence'];
        $this->updateLevel(false);
    }

    /**
     * Get the model data as an array.
     *
     * @return array
     */
    public function toArray()
    {
        $array = array();
        $array['key'] = $this->key;
        $array['class'] = $this->getClass()->getClassName();
        $array['experience'] = $this->experience;
        $array['algorithms'] = $this->algorithms;
        $array['performance'] = $this->performance;
        $array['persistence'] = $this->persistence;
        return $array;
    }

    /**
     * Saves the current stats of the character into datasource with a key string to be used to load later
     */
    public function save()
    {
        $this->key = md5(microtime() . 'E' . $this->experience . 'A' . $this->algorithms . 'F' . $this->performance . 'S' . $this->persistence . 'C' . $this->getClass()->getClassName());
        $this->datasource->create($this->getTableName(), $this->toArray());
    }

    /**
     * Sets the class of the character
     *
     * @param string $classKey A character representing the class
     *
     * @return bool
     */
    public function setClass($classKey)
    {
        switch ($classKey) {
            case "H":
                $this->class = new HackerogueClass();
                return true;
            case "S":
                $this->class = new SoftwizardClass();
                return true;
            case "C":
                $this->class = new CodefighterClass();
                return true;
            default:
                return false;
        }
    }
}