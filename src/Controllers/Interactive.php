<?php
/**
 * Created by PhpStorm.
 * User: Ulukut
 * Date: 19.12.2016
 * Time: 16:25
 *
 * @author Volkan Ulukut <arthan@gmail.com>
 */

namespace Ludwig\Controllers;


/**
 * Class Interactive
 * Class to handle input&output from and to the console
 *
 * @package Ludwig\Controllers
 */
class Interactive
{
    /**
     * Prints out to the console with appropriate EOL.
     *
     * @param string $text Text to output
     */
    public static function consolePrint($text)
    {
        print($text . PHP_EOL);
    }

    /**
     * Reads the standard input and returns it.
     *
     * @param resource $handle input stream resource
     *
     * @return string
     */
    public static function consoleInput($handle)
    {
        return trim(fgets($handle));
    }
}