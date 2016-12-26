<?php
/**
 * Created by PhpStorm.
 * User: Ulukut
 * Date: 19.12.2016
 * Time: 15:34
 *
 * @author Volkan Ulukut <arthan@gmail.com>
 */

namespace Ludwig\Controllers;


/**
 * Class AbstractClass
 * Class to define other character classes
 *
 * @package Ludwig\Controllers
 */
abstract class AbstractClass
{
    /**
     * The name of the character class
     *
     * @var string
     */
    protected $className;

    /**
     * Get the character class multiplier of given attribute
     *
     * @param string $attribute
     *
     * @return float
     */
    abstract public  function getMultiplier($attribute);

    /**
     * Returns character class name
     *
     * @return string
     */
    public function getClassName()
    {
        return $this->className;
    }
}