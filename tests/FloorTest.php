<?php

/**
 * File for Numerics floor function tests.
 * @package Phrity > Util > Numerics
 */

declare(strict_types=1);

namespace Phrity\Util;

use Phrity\Util\Numerics;
use PHPUnit\Framework\TestCase;

/**
 * Numerics floor test class.
 */
class FloorTest extends TestCase
{
    /**
     * Set up for all tests
     */
    public function setUp(): void
    {
        error_reporting(-1);
    }

    /**
     * Test floor with precision
     */
    public function testFloorWithPrecision(): void
    {
        $numerics = new Numerics();

        $this->assertEquals(1234.5678, $numerics->floor(1234.5678, 4));
        $this->assertEquals(1234.5670, $numerics->floor(1234.5678, 3));
        $this->assertEquals(1234.5600, $numerics->floor(1234.5678, 2));
        $this->assertEquals(1234.5000, $numerics->floor(1234.5678, 1));
        $this->assertEquals(1234.0000, $numerics->floor(1234.5678, 0));
        $this->assertEquals(1230.0000, $numerics->floor(1234.5678, -1));
        $this->assertEquals(1200.0000, $numerics->floor(1234.5678, -2));
        $this->assertEquals(1000.0000, $numerics->floor(1234.5678, -3));
        $this->assertEquals(0.0000, $numerics->floor(1234.5678, -4));
    }

    /**
     * Test floor compability
     */
    public function testCombability(): void
    {
        $numerics = new Numerics();

        $this->assertEquals(floor(1234.5678), $numerics->floor(1234.5678));
        $this->assertEquals(floor(1234.5680), $numerics->floor(1234.5680));
        $this->assertEquals(floor(1234.5700), $numerics->floor(1234.5700));
        $this->assertEquals(floor(1234.6000), $numerics->floor(1234.6000));
        $this->assertEquals(floor(1235.0000), $numerics->floor(1235.0000));
        $this->assertEquals(floor(1240.0000), $numerics->floor(1240.0000));
        $this->assertEquals(floor(1300.0000), $numerics->floor(1300.0000));
        $this->assertEquals(floor(1300.0000), $numerics->floor(1300.0000));
    }

    /**
     * Test integer input
     */
    public function testIntegerInput(): void
    {
        $numerics = new Numerics();

        $this->assertEquals(1234.0, $numerics->floor(1234, 4));
        $this->assertEquals(1234.0, $numerics->floor(1234, 3));
        $this->assertEquals(1234.0, $numerics->floor(1234, 2));
        $this->assertEquals(1234.0, $numerics->floor(1234, 1));
        $this->assertEquals(1234.0, $numerics->floor(1234, 0));
        $this->assertEquals(1230.0, $numerics->floor(1234, -1));
        $this->assertEquals(1200.0, $numerics->floor(1234, -2));
        $this->assertEquals(1000.0, $numerics->floor(1234, -3));
        $this->assertEquals(0.0, $numerics->floor(1234, -4));
    }

    /**
     * Test instance settings
     */
    public function testInstance(): void
    {
        $numerics = new Numerics();
        $this->assertEquals(1234.0000, $numerics->floor(1234.5678));

        $numerics = new Numerics(2);
        $this->assertEquals(1234.5600, $numerics->floor(1234.5678));

        $numerics = new Numerics(-2);
        $this->assertEquals(1200.0000, $numerics->floor(1234.5678));
    }

    /**
     * Test invalid input type on number argument
     */
    public function testInvalidNumberInput(): void
    {
        $numerics = new Numerics();
        $this->expectException('TypeError');
        $numerics->floor('should fail');
    }

    /**
     * Test invalid input type on precision argument
     */
    public function testInvalidPrecisionInput(): void
    {
        $numerics = new Numerics();
        $this->expectException('TypeError');
        $numerics->floor(12.34, 'should fail');
    }
}
