<?php
/**
 * Created by PhpStorm.
 * User: Ulukut
 * Date: 21.12.2016
 * Time: 16:38
 *
 * @author Volkan Ulukut <arthan@gmail.com>
 */

namespace Ludwig\Models;


class Challenger extends Model
{
    private $datasource;
    private $id;
    private $name;
    private $favorite_attribute;
    private $attribute_point;
    private $experience_rewards;

    /**
     * Character constructor.
     * Initializing properties
     */
    public function __construct(IDataSource $datasource)
    {
        $this->datasource = $datasource;
        $this->tableName = "challengers";
        $this->primaryKey = "id";
    }


    /**
     * update property values with the given array
     * @param $array
     * @return void
     */
    public function arrayToProperties($array)
    {
        $this->id = isset($array['id']) ? $array['id'] : null;
        $this->name = isset($array['name']) ? $array['name'] : null;
        $this->favorite_attribute = isset($array['favorite_attribute']) ? $array['favorite_attribute'] : null;
        $this->attribute_point = isset($array['attribute_point']) ? $array['attribute_point'] : null;
        $this->experience_rewards = isset($array['experience_rewards']) ? $array['experience_rewards'] : null;
    }

    /**
     * get the model data as an array.
     * @return array;
     */
    public function toArray()
    {
        $array = array();
        if (isset($this->id))
            $array['id'] = $this->id;
        if (isset($this->name))
            $array['name'] = $this->name;
        if (isset($this->favorite_attribute))
            $array['favorite_attribute'] = $this->favorite_attribute;
        if (isset($this->attribute_point))
            $array['attribute_point'] = $this->attribute_point;
        if (isset($this->experience_rewards))
            $array['experience_rewards'] = $this->experience_rewards;
        return $array;
    }

}