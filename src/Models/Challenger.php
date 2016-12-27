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


/**
 * Class Challenger
 *
 * @package Ludwig\Models
 */
class Challenger extends Model
{

    /**
     * Datasource to be used to persist data
     *
     * @var IDataSource
     */
    protected $datasource;

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
     *
     * @param IDataSource $datasource
     */
    public function __construct(IDataSource $datasource)
    {
        parent::__construct($datasource);
        $this->tableName = "challengers";
        $this->primaryKey = "id";
    }

    /**
     * Update property values with the given array
     *
     * @param array $array Array of values to be set to properties.
     */
    public function arrayToProperties(array $array)
    {
        $array += array_fill_keys(['id', 'name', 'favorite_attribute', 'attribute_point', 'experience_rewards'], null);
        $this->id = $array['id'];
        $this->name = $array['name'];
        $this->favorite_attribute = $array['favorite_attribute'];
        $this->attribute_point = $array['attribute_point'];
        $this->experience_rewards = $array['experience_rewards'];
    }

    /**
     * Get the model data as an array.
     *
     * @return array
     */
    public function toArray()
    {
        $array = array();
        $array['id'] = $this->id;
        $array['name'] = $this->getName();
        $array['favorite_attribute'] = $this->favorite_attribute;
        $array['attribute_point'] = $this->attribute_point;
        $array['experience_rewards'] = $this->experience_rewards;
        return $array;
    }

    /**
     * Query database for a random challenger appropriate for the characters level
     *
     * @param int $level level of the character who is going to challenge this challenger
     *
     * @return Challenger
     */
    public function queryRandomChallenger($level)
    {
        $challenger = $this->query($this->datasource, "SELECT * FROM challengers WHERE experience_rewards = :level ORDER BY RANDOM() LIMIT 1", ["level" => $level]);
        $this->arrayToProperties($challenger[0]);
        return $this;
    }

    /**
     * Getter for name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Getter for favorite_attribute
     *
     * @return string
     */
    public function getFavoriteAttribute()
    {
        return $this->favorite_attribute;
    }

    /**
     * Getter for attribute_point
     *
     * @return int
     */
    public function getAttributePoint()
    {
        return $this->attribute_point;
    }

    /**
     * Getter for experience_rewards
     *
     * @return int
     */
    public function getExperienceRewards()
    {
        return $this->experience_rewards;
    }

}