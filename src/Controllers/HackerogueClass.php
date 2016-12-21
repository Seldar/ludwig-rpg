<?php
/**
 * Created by PhpStorm.
 * User: Ulukut
 * Date: 19.12.2016
 * Time: 15:44
 *
 * @author Volkan Ulukut <arthan@gmail.com>
 */

namespace Ludwig\Controllers;


class HackerogueClass extends AbstractClass
{
    protected $className = 'Hackerogue';
    public function getAlgorithmsMultiplier()
    {
        return 0.5;
    }
    public function getPerformanceMultiplier()
    {
        return 2;
    }
    public function getPersistenceMultiplier()
    {
        return 1;
    }
}