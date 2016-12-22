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

/**
 * Class SoftwizardClass
 *
 * @package Ludwig\Controllers
 */
class SoftwizardClass extends AbstractClass
{
    /**
     * The name of the character class
     *
     * @var string
     */
    protected $className = 'Softwizard';

    /**
     * Get the character class multiplier of given attribute
     *
     * @param string $attribute
     *
     * @return float
     */
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