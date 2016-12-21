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


abstract class AbstractClass
{
    protected $className;
    public abstract function getAlgorithmsMultiplier();
    public abstract function getPerformanceMultiplier();
    public abstract function getPersistenceMultiplier();
    public function getClassName()
    {
        return $this->className;
    }
}