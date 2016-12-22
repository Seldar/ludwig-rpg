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


class Level extends Model
{
    private $datasource;

    /**
     * primary key level
     * @var integer
     */
    private $level;

    /**
     * title of this level
     * @var string
     */
    private $title;

    /**
     * minimum experience required for this level
     * @var string
     */
    private $min_exp;

    /**
     * Level constructor.
     * Initializing properties
     */
    public function __construct(IDataSource $datasource)
    {
        $this->datasource = $datasource;
        $this->tableName = "levels";
        $this->primaryKey = "level";
    }

    /**
     * getter for field name
     * @return string
     */
    public function getLevel()
    {
        return $this->level;
    }

    /**
     * getter for field userId
     * @return string
     */
    public function getMinExp()
    {
        return $this->min_exp;
    }

    /**
     * getter for field title
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }


    public static function getLevelByExperience(IDataSource $datasource, $min_exp)
    {
        $obj = new static($datasource);
        $level = $obj->query($datasource, "SELECT * FROM levels WHERE min_exp <= :min_exp ORDER BY level desc LIMIT 1" ,['min_exp' => $min_exp]);
        $obj->arrayToProperties($level[0]);
        return $obj;
    }

    /**
     * update property values with the given array
     * @param $array
     * @return void
     */
    public function arrayToProperties($array)
    {
        $this->min_exp =  isset($array['min_exp']) ? $array['min_exp'] : null;
        $this->level =  isset($array['level']) ? $array['level'] : null;
        $this->title =  isset($array['title']) ? $array['title'] : null;
    }

    /**
     * get the model data as an array.
     * @return array;
     */
    public function toArray()
    {
        $array = array();
        if(isset($this->level))
            $array['level'] = $this->level;
        if(isset($this->min_exp))
            $array['min_exp'] = $this->min_exp;
        if(isset($this->title))
            $array['title'] = $this->title;
        return $array;
    }
}