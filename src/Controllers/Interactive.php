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


class Interactive
{
    public static function consolePrint($text)
    {
        print($text . PHP_EOL);
    }
    public static function consoleInput()
    {
        return trim(fgets(STDIN));
    }
}