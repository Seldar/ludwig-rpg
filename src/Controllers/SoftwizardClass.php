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


class SoftwizardClass extends AbstractClass
{
    protected $className = 'Softwizard';
    public function getAlgorithmsMultiplier()
    {
        return 2.0;
    }
    public function getPerformanceMultiplier()
    {
        return 1;
    }
    public function getPersistenceMultiplier()
    {
        return 0.5;
    }
}