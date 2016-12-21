<?php
/**
 * Created by PhpStorm.
 * User: Ulukut
 * Date: 19.12.2016
 * Time: 15:46
 *
 * @author Volkan Ulukut <arthan@gmail.com>
 */

namespace Ludwig\Controllers;


class CodefighterClass extends AbstractClass
{
    protected $className = 'Codefighter';
    public function getAlgorithmsMultiplier()
    {
        return 1;
    }
    public function getPerformanceMultiplier()
    {
        return 0.5;
    }
    public function getPersistenceMultiplier()
    {
        return 2;
    }
}