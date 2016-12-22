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

    /**
     * Datasource to be used to persist data
     *
     * @var IDataSource
     */
    private $datasource;

    /**
     * Primary id of the challenger model
     *
     * @var integer
     */
    private $id;

    /**
     * Name of the challenger
     *
     * @var string
     */
    private $name;

    /**
     * Attribute to be used when challenging this challenger
     *
     * @var string
     */
    private $favorite_attribute;

    /**
     * Attribute point of this challenger
     *
     * @var integer
     */
    private $attribute_point;

    /**
     * Experience to be awarded when this challenger is defeated
     *
     * @var integer
     */
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
     * Update property values with the given array
     *
     * @param array $array Array of values to be set to properties.
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
     * Get the model data as an array.
     *
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