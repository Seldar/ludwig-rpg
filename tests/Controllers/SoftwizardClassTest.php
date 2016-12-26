<?php
/**
 * Created by PhpStorm.
 * User: Ulukut
 * Date: 26.12.2016
 * Time: 14:55
 *
 * @author Volkan Ulukut <arthan@gmail.com>
 */

namespace Ludwig\Tests\Controllers;


use Ludwig\Controllers\SoftwizardClass;

class SoftwizardClassTest extends \PHPUnit_Framework_TestCase
{
    public function testGetMultiplierAlgorithms()
    {
        $sutClass = new SoftwizardClass();
        $result = $sutClass->getMultiplier("Algorithms");
        $this->assertGreaterThanOrEqual(0.5, $result);
        $this->assertLessThanOrEqual(2, $result);
    }

    public function testGetMultiplierPerformance()
    {
        $sutClass = new SoftwizardClass();
        $result = $sutClass->getMultiplier("Performance");
        $this->assertGreaterThanOrEqual(0.5, $result);
        $this->assertLessThanOrEqual(2, $result);
    }

    public function testGetMultiplierPersistence()
    {
        $sutClass = new SoftwizardClass();
        $result = $sutClass->getMultiplier("Persistence");
        $this->assertGreaterThanOrEqual(0.5, $result);
        $this->assertLessThanOrEqual(2, $result);
    }

    public function testGetClassName()
    {
        $sutClass = new SoftwizardClass();
        $result = $sutClass->getClassName();
        $this->assertSame("Softwizard", $result);
    }
}
