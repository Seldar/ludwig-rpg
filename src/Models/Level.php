<?php
/**
 * Created by PhpStorm.
 * User: Ulukut
 * Date: 19.12.2016
 * Time: 16:10
 *
 * @author Volkan Ulukut <arthan@gmail.com>
 */

namespace Ludwig\Models;


/**
 * Class Level
 *
 * @package Ludwig\Models
 */
class Level extends Model
{
    /**
     * Datasource to be used to persist data
     *
     * @var IDataSource
     */
    protected $datasource;

    /**
     * Primary key level
     *
     * @var integer
     */
    private $level;

    /**
     * Title of this level
     *
     * @var string
     */
    private $title;

    /**
     * Minimum experience required for this level
     *
     * @var int
     */
    private $min_exp;

    /**
     * Level constructor.
     * Initializing properties
     *
     * @param IDataSource $datasource
     */
    public function __construct(IDataSource $datasource)
    {
        parent::__construct($datasource);
        $this->tableName = "levels";
        $this->primaryKey = "level";
    }

    /**
     * Getter for field level
     *
     * @return int
     */
    public function getLevel()
    {
        return $this->level;
    }

    /**
     * Getter for field min_exp
     *
     * @return int
     */
    public function getMinExp()
    {
        return $this->min_exp;
    }

    /**
     * Getter for field title
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Update property values with the given array
     *
     * @param array $array Array of values to be set to properties.
     */
    public function arrayToProperties(array $array)
    {
        $this->min_exp = isset($array['min_exp']) ? $array['min_exp'] : null;
        $this->level = isset($array['level']) ? $array['level'] : null;
        $this->title = isset($array['title']) ? $array['title'] : null;
    }

    /**
     * Get the model data as an array.
     *
     * @return array
     */
    public function toArray()
    {
        $array = array();
        $array['level'] = $this->level;
        $array['min_exp'] = $this->min_exp;
        $array['title'] = $this->title;
        return $array;
    }

    /**
     * Get the level corresponding to given experience
     *
     * @param IDataSource $datasource
     * @param int $min_exp minimum experience required to be nth level
     *
     * @return Level
     */
    public static function getLevelByExperience(IDataSource $datasource, $min_exp)
    {
        $obj = new static($datasource);
        $level = $obj->query($datasource, "SELECT * FROM levels WHERE min_exp <= :min_exp ORDER BY level DESC LIMIT 1", ['min_exp' => $min_exp]);
        $obj->arrayToProperties($level[0]);
        return $obj;
    }
}