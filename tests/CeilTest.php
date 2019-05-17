<?php
/**
 * File for Numerics ceil function tests.
 * @package Phrity > Util > Numerics
 */
namespace Phrity\Util;

use Phrity\Util\Numerics;
use PHPUnit_Framework_TestCase;

/**
 * Numerics ceil test class.
 */
class CeilTest extends PHPUnit_Framework_TestCase
{
    /**
     * Set up for all tests
     */
    public function setUp()
    {
        error_reporting(-1);
    }

    /**
     * Test ceil with precision
     */
    public function testCeilWithPrecision()
    {
        $this->assertEquals(1234.5678, Numerics::ceil(1234.5678, 4));
        $this->assertEquals(1234.5680, Numerics::ceil(1234.5678, 3));
        $this->assertEquals(1234.5700, Numerics::ceil(1234.5678, 2));
        $this->assertEquals(1234.6000, Numerics::ceil(1234.5678, 1));
        $this->assertEquals(1235.0000, Numerics::ceil(1234.5678, 0));
        $this->assertEquals(1240.0000, Numerics::ceil(1234.5678, -1));
        $this->assertEquals(1300.0000, Numerics::ceil(1234.5678, -2));
        $this->assertEquals(2000.0000, Numerics::ceil(1234.5678, -3));
        $this->assertEquals(10000.0000, Numerics::ceil(1234.5678, -4));
    }

    /**
     * Test ceil compability
     */
    public function testCombability()
    {
        $this->assertEquals(ceil(1234.5678), Numerics::ceil(1234.5678));
        $this->assertEquals(ceil(1234.5680), Numerics::ceil(1234.5680));
        $this->assertEquals(ceil(1234.5700), Numerics::ceil(1234.5700));
        $this->assertEquals(ceil(1234.6000), Numerics::ceil(1234.6000));
        $this->assertEquals(ceil(1235.0000), Numerics::ceil(1235.0000));
        $this->assertEquals(ceil(1240.0000), Numerics::ceil(1240.0000));
        $this->assertEquals(ceil(1300.0000), Numerics::ceil(1300.0000));
        $this->assertEquals(ceil(1300.0000), Numerics::ceil(1300.0000));
    }
}
