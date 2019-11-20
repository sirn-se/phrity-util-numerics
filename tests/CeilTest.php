<?php

/**
 * File for Numerics ceil function tests.
 * @package Phrity > Util > Numerics
 */

declare(strict_types=1);

namespace Phrity\Util;

use Phrity\Util\Numerics;
use PHPUnit\Framework\TestCase;

/**
 * Numerics ceil test class.
 */
class CeilTest extends TestCase
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
        $numerics = new Numerics();

        $this->assertEquals(1234.5678, $numerics->ceil(1234.5678, 4));
        $this->assertEquals(1234.5680, $numerics->ceil(1234.5678, 3));
        $this->assertEquals(1234.5700, $numerics->ceil(1234.5678, 2));
        $this->assertEquals(1234.6000, $numerics->ceil(1234.5678, 1));
        $this->assertEquals(1235.0000, $numerics->ceil(1234.5678, 0));
        $this->assertEquals(1240.0000, $numerics->ceil(1234.5678, -1));
        $this->assertEquals(1300.0000, $numerics->ceil(1234.5678, -2));
        $this->assertEquals(2000.0000, $numerics->ceil(1234.5678, -3));
        $this->assertEquals(10000.0000, $numerics->ceil(1234.5678, -4));
    }

    /**
     * Test ceil compability
     */
    public function testCombability()
    {
        $numerics = new Numerics();

        $this->assertEquals(ceil(1234.5678), $numerics->ceil(1234.5678));
        $this->assertEquals(ceil(1234.5680), $numerics->ceil(1234.5680));
        $this->assertEquals(ceil(1234.5700), $numerics->ceil(1234.5700));
        $this->assertEquals(ceil(1234.6000), $numerics->ceil(1234.6000));
        $this->assertEquals(ceil(1235.0000), $numerics->ceil(1235.0000));
        $this->assertEquals(ceil(1240.0000), $numerics->ceil(1240.0000));
        $this->assertEquals(ceil(1300.0000), $numerics->ceil(1300.0000));
        $this->assertEquals(ceil(1300.0000), $numerics->ceil(1300.0000));
    }

    /**
     * Test integer input
     */
    public function testIntegerInput()
    {
        $numerics = new Numerics();

        $this->assertEquals(1234.0, $numerics->ceil(1234, 4));
        $this->assertEquals(1234.0, $numerics->ceil(1234, 3));
        $this->assertEquals(1234.0, $numerics->ceil(1234, 2));
        $this->assertEquals(1234.0, $numerics->ceil(1234, 1));
        $this->assertEquals(1234.0, $numerics->ceil(1234, 0));
        $this->assertEquals(1240.0, $numerics->ceil(1234, -1));
        $this->assertEquals(1300.0, $numerics->ceil(1234, -2));
        $this->assertEquals(2000.0, $numerics->ceil(1234, -3));
        $this->assertEquals(10000.0, $numerics->ceil(1234, -4));
    }

    /**
     * Test instance settings
     */
    public function testInstance()
    {
        $numerics = new Numerics();
        $this->assertEquals(1235.0000, $numerics->ceil(1234.5678));

        $numerics = new Numerics(2);
        $this->assertEquals(1234.5700, $numerics->ceil(1234.5678));

        $numerics = new Numerics(-2);
        $this->assertEquals(1300.0000, $numerics->ceil(1234.5678));
    }

    /**
     * Test invalid input type on number argument
     * @expectedException TypeError
     */
    public function testInvalidNumberInput()
    {
        $numerics = new Numerics();
        $numerics->ceil('should fail');
    }

    /**
     * Test invalid input type on precision argument
     * @expectedException TypeError
     */
    public function testInvalidPrecisionInput()
    {
        $numerics = new Numerics();
        $numerics->ceil(12.34, 'should fail');
    }
}
