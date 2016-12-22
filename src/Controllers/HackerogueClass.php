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

/**
 * Class HackerogueClass
 *
 * @package Ludwig\Controllers
 */
class HackerogueClass extends AbstractClass
{
    /**
     * The name of the character class
     *
     * @var string
     */
    protected $className = 'Hackerogue';

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
                return 0.5;
                break;
            case "Performance":
                return 2;
                break;
            case "Persistence":
                return 1;
                break;
            default:
                return 1;
        }
    }
}