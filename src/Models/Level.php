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


    public function getLevelByExperience($min_exp)
    {
        $result = $this->query($this->datasource, "SELECT * FROM levels WHERE min_exp <= :min_exp ORDER BY level desc LIMIT 1" ,['min_exp' => $min_exp]);
        return $result[0]['level'];
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
        return $array;
    }
}