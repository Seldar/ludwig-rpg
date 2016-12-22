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

class Character extends Model
{
    private $datasource;
    private $key;
    private $class;
    private $experience = 0;
    private $level = 0;
    private $title = 'Intern';
    private $algorithms = 5;
    private $performance = 5;
    private $persistence = 5;

    /**
     * Character constructor.
     * Initializing properties
     */
    public function __construct(IDataSource $datasource)
    {
        $this->datasource = $datasource;
        $this->tableName = "characters";
        $this->primaryKey = "key";
    }

    /**
     * @return string
     */
    public function getKey()
    {
        return $this->key;
    }

    /**
     * @return AbstractClass
     */
    public function getClass()
    {
        return $this->class;
    }

    /**
     * @return int
     */
    public function getExperience()
    {
        return $this->experience;
    }

    /**
     * @return int
     */
    public function getLevel()
    {
        return $this->level;
    }

    /**
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @return int
     */
    public function getAlgorithms()
    {
        return $this->algorithms;
    }

    /**
     * @return int
     */
    public function getPerformance()
    {
        return $this->performance;
    }

    /**
     * @return int
     */
    public function getPersistence()
    {
        return $this->persistence;
    }

    public function createCharacter(AbstractClass $class, $experience, $freebies)
    {
        $this->class = $class;
        $this->experience = $experience;
        $this->algorithms += $freebies[0];
        $this->performance += $freebies[1];
        $this->persistence += $freebies[2];
        $this->updateLevel(false);
    }

    public function increaseAlgorithms($point)
    {
        $this->algorithms += $point;
    }

    public function increasePerformance($point)
    {
        $this->performance += $point;
    }

    public function increasePersistence($point)
    {
        $this->persistence += $point;
    }

    public function earnExperience($xp)
    {
        $this->experience += $xp;
        return $this->updateLevel(true);
    }

    public function updateLevel($withLevelUp)
    {
        $leveled_up = false;
        $level = Level::getLevelByExperience($this->datasource,$this->experience);
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
     * update property values with the given array
     * @param $array
     * @return void
     */
    public function arrayToProperties($array)
    {
        $this->key = isset($array['key']) ? $array['key'] : null;
        if (isset($array['class'])) {
            switch ($array['class']) {
                case "Hackerogue":
                    $this->class = new HackerogueClass();
                    break;
                case "Softwizard":
                    $this->class = new SoftwizardClass();
                    break;
                default:
                    $this->class = new CodefighterClass();
                    break;
            }
        } else {
            $this->class = null;
        }
        $this->experience = isset($array['experience']) ? $array['experience'] : null;
        $this->algorithms = isset($array['algorithms']) ? $array['algorithms'] : null;
        $this->performance = isset($array['performance']) ? $array['performance'] : null;
        $this->persistence = isset($array['persistence']) ? $array['persistence'] : null;
        $this->updateLevel(false);
    }

    /**
     * get the model data as an array.
     * @return array;
     */
    public function toArray()
    {
        $array = array();
        if (isset($this->key))
            $array['key'] = $this->key;
        if (isset($this->class))
            $array['class'] = $this->getClass()->getClassName();
        if (isset($this->experience))
            $array['experience'] = $this->experience;
        if (isset($this->algorithms))
            $array['algorithms'] = $this->algorithms;
        if (isset($this->performance))
            $array['performance'] = $this->performance;
        if (isset($this->persistence))
            $array['persistence'] = $this->persistence;
        return $array;
    }

    public function save()
    {
        $this->key = md5(microtime() . 'E' . $this->experience . 'A' . $this->algorithms . 'F' . $this->performance . 'S' . $this->persistence . 'C' . $this->getClass()->getClassName());
        $this->datasource->create($this->getTableName(), $this->toArray());
    }

    public function setClass($classKey)
    {
        switch ($classKey) {
            case "H":
                $this->class = new HackerogueClass();
                break;
            case "S":
                $this->class = new SoftwizardClass();
                break;
            default:
                $this->class = new CodefighterClass();
                break;
        }
    }
}