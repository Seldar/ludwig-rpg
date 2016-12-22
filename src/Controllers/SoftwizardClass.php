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
    public function getMultiplier($attribute)
    {
        switch($attribute)
        {
            case "Algorithms":
                return 2;
                break;
            case "Performance":
                return 1;
                break;
            case "Persistence":
                return 0.5;
                break;
            default:
                return 1;
        }
    }
}