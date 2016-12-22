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
    public function getMultiplier($attribute)
    {
        switch($attribute)
        {
            case "Algorithms":
                return 1;
                break;
            case "Performance":
                return 0.5;
                break;
            case "Persistence":
                return 2;
                break;
            default:
                return 1;
        }
    }
}