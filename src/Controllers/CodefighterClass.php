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
 * Class CodefighterClass
 *
 * @package Ludwig\Controllers
 */
class CodefighterClass extends AbstractClass
{
    /**
     * The name of the character class
     *
     * @var string
     */
    protected $className = 'Codefighter';

    /**
     * Get the character class multiplier of given attribute
     *
     * @param string $attribute
     *
     * @return float
     */
    public function getMultiplier($attribute)
    {
        switch ($attribute) {
            case "Algorithms":
                return 1;
            case "Performance":
                return 0.5;
            case "Persistence":
                return 2;
            default:
                return 1;
        }
    }
}