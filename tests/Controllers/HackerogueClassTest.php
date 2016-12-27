<?php
/**
 * Created by PhpStorm.
 * User: Ulukut
 * Date: 26.12.2016
 * Time: 14:54
 *
 * @author Volkan Ulukut <arthan@gmail.com>
 */

namespace Ludwig\Tests\Controllers;


use Ludwig\Controllers\HackerogueClass;

class HackerogueClassTest extends \PHPUnit_Framework_TestCase
{
    public function testGetMultiplierAlgorithms()
    {
        $sutClass = new HackerogueClass();
        $result = $sutClass->getMultiplier("Algorithms");
        $this->assertGreaterThanOrEqual(0.5, $result);
        $this->assertLessThanOrEqual(2, $result);
    }

    public function testGetMultiplierPerformance()
    {
        $sutClass = new HackerogueClass();
        $result = $sutClass->getMultiplier("Performance");
        $this->assertGreaterThanOrEqual(0.5, $result);
        $this->assertLessThanOrEqual(2, $result);
    }

    public function testGetMultiplierPersistence()
    {
        $sutClass = new HackerogueClass();
        $result = $sutClass->getMultiplier("Persistence");
        $this->assertGreaterThanOrEqual(0.5, $result);
        $this->assertLessThanOrEqual(2, $result);
    }


    public function testGetMultiplierDefault()
    {
        $sutClass = new HackerogueClass();
        $result = $sutClass->getMultiplier("test");
        $this->assertEquals(1, $result);
    }

    public function testGetClassName()
    {
        $sutClass = new HackerogueClass();
        $result = $sutClass->getClassName();
        $this->assertSame("Hackerogue", $result);
    }
}
