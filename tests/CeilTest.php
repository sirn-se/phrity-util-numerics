<?php

/**
 * File for Numerics ceil function tests.
 * @package Phrity > Util > Numerics
 */

declare(strict_types=1);

namespace Phrity\Util;

use PHPUnit\Framework\TestCase;
use Phrity\Util\Numerics;
use TypeError;

/**
 * Numerics ceil test class.
 */
class CeilTest extends TestCase
{
    /**
     * Set up for all tests
     */
    public function setUp(): void
    {
        error_reporting(-1);
    }

    /**
     * Test ceil with precision
     */
    public function testCeilWithPrecision(): void
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
    public function testCombability(): void
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
    public function testIntegerInput(): void
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
    public function testInstance(): void
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
     */
    public function testInvalidNumberInput(): void
    {
        $numerics = new Numerics();
        $this->expectException(TypeError::class);
        $this->expectExceptionMessage('Argument #1 ($number) must be of type float, string given');
        $numerics->ceil('should fail');
    }

    /**
     * Test invalid input type on precision argument
     */
    public function testInvalidPrecisionInput(): void
    {
        $numerics = new Numerics();
        $this->expectException(TypeError::class);
        $this->expectExceptionMessage('Argument #2 ($precision) must be of type ?int, string given');
        $numerics->ceil(12.34, 'should fail');
    }
}
