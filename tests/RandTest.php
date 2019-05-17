<?php
/**
 * File for Numerics rand function tests.
 * @package Phrity > Util > Numerics
 */
namespace Phrity\Util;

use Phrity\Util\Numerics;
use PHPUnit_Framework_TestCase;

/**
 * Numerics rand test class.
 */
class RandTest extends PHPUnit_Framework_TestCase
{
    /**
     * Set up for all tests
     */
    public function setUp()
    {
        error_reporting(-1);
    }

    /**
     * Test rand ranges
     */
    public function testRangeRand()
    {
        $rand = Numerics::rand(0, 2);
        $this->assertGreaterThanOrEqual(0, $rand);
        $this->assertLessThanOrEqual(2, $rand);

        $rand = Numerics::rand(-1, 1);
        $this->assertGreaterThanOrEqual(-1, $rand);
        $this->assertLessThanOrEqual(1, $rand);

        $rand = Numerics::rand(0.4, 0.6, 1);
        $this->assertGreaterThanOrEqual(0.4, $rand);
        $this->assertLessThanOrEqual(0.6, $rand);

        $rand = Numerics::rand(0.04, 0.06, 2);
        $this->assertGreaterThanOrEqual(0.04, $rand);
        $this->assertLessThanOrEqual(0.06, $rand);

        $rand = Numerics::rand(-0.1, 0.1, 1);
        $this->assertGreaterThanOrEqual(-0.1, $rand);
        $this->assertLessThanOrEqual(0.1, $rand);
    }

    /**
     * Test rand max value and high precision
     */
    public function testRandMax()
    {
        $rand_max = mt_getrandmax();

        $rand = Numerics::rand();
        $this->assertGreaterThanOrEqual(0, $rand);
        $this->assertLessThanOrEqual($rand_max, $rand);

        $rand = Numerics::rand(-$rand_max, 0);
        $this->assertGreaterThanOrEqual(-$rand_max, $rand);
        $this->assertLessThanOrEqual(0, $rand);

        $rand = Numerics::rand($rand_max, $rand_max * 2, 0);
        $this->assertGreaterThanOrEqual($rand_max, $rand);
        $this->assertLessThanOrEqual($rand_max * 2, $rand);
    }

    /**
     * Test rand max value and high precision
     */
    public function testLargeNumbers()
    {
        $rand = Numerics::rand(0, 1234567890, 8);
        $this->assertGreaterThanOrEqual(0, $rand);
        $this->assertLessThanOrEqual(1234567890, $rand);

        $rand = Numerics::rand(0, 1234567890, 32);
        $this->assertGreaterThanOrEqual(0, $rand);
        $this->assertLessThanOrEqual(1234567890, $rand);
    }
    
    /**
     * Test single possible returns
     */
    public function testSingulars()
    {
        $this->assertEquals(100, Numerics::rand(1, 199, -2));
        $this->assertEquals(10, Numerics::rand(1, 19, -1));
        $this->assertEquals(1, Numerics::rand(0.1, 1.9, 0));
        $this->assertEquals(0.1, Numerics::rand(0.01, 0.19, 1));
        $this->assertEquals(0.01, Numerics::rand(0.001, 0.019, 2));
    }

    /**
     * Test invalid min/max/precision combinations
     */
    public function testInvalidRange()
    {
        $this->assertNull(Numerics::rand(10, 9));
        $this->assertNull(Numerics::rand(0.1, 0.9, 0));
        $this->assertNull(Numerics::rand(0.01, 0.09, 1));
    }
}
