<?php
/**
 * Created by PhpStorm.
 * User: Ulukut
 * Date: 26.12.2016
 * Time: 14:56
 *
 * @author Volkan Ulukut <arthan@gmail.com>
 */

namespace Ludwig\Tests\Controllers;

use Ludwig\Controllers\Interactive;

class InteractiveTest extends \PHPUnit_Framework_TestCase
{
    public function testConsolePrint()
    {
        Interactive::consolePrint("test");
        $this->expectOutputRegex("/test/s");
    }

    public function testConsoleInput()
    {
        $handler = fopen("php://memory", "w+");
        fputs($handler, "test");
        rewind($handler);
        $result = Interactive::consoleInput($handler);
        $this->assertSame("test", $result);
    }
}
