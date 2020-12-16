<?php

/**
 * File for Numerics round function tests.
 * @package Phrity > Util > Numerics
 */

declare(strict_types=1);

namespace Phrity\Util;

use Phrity\Util\Numerics;
use PHPUnit\Framework\TestCase;

/**
 * Numerics round test class.
 */
class RoundTest extends TestCase
{
    /**
     * Set up for all tests
     */
    public function setUp(): void
    {
        error_reporting(-1);
    }

    /**
     * Test round with precision
     */
    public function tesRoundWithPrecision(): void
    {
        $numerics = new Numerics();

        $this->assertEquals(1234.5678, $numerics->round(1234.5678, 4));
        $this->assertEquals(1234.5680, $numerics->round(1234.5678, 3));
        $this->assertEquals(1234.5700, $numerics->round(1234.5678, 2));
        $this->assertEquals(1234.6000, $numerics->round(1234.5678, 1));
        $this->assertEquals(1235.0000, $numerics->round(1234.5678, 0));
        $this->assertEquals(1240.0000, $numerics->round(1234.5678, -1));
        $this->assertEquals(1300.0000, $numerics->round(1234.5678, -2));
        $this->assertEquals(2000.0000, $numerics->round(1234.5678, -3));
        $this->assertEquals(10000.0000, $numerics->round(1234.5678, -4));
    }

    /**
     * Test round compability
     */
    public function testCombability(): void
    {
        $numerics = new Numerics();

        $this->assertEquals(round(1234.5678), $numerics->round(1234.5678));
        $this->assertEquals(round(1234.5680), $numerics->round(1234.5680));
        $this->assertEquals(round(1234.5700), $numerics->round(1234.5700));
    }

    /**
     * Test integer input
     */
    public function testIntegerInput(): void
    {
        $numerics = new Numerics();

        $this->assertEquals(1234.0, $numerics->round(1234, 4));
        $this->assertEquals(1234.0, $numerics->round(1234, 3));
        $this->assertEquals(1234.0, $numerics->round(1234, 2));
        $this->assertEquals(1234.0, $numerics->round(1234, 1));
        $this->assertEquals(1234.0, $numerics->round(1234, 0));
        $this->assertEquals(1230.0, $numerics->round(1234, -1));
        $this->assertEquals(1200.0, $numerics->round(1234, -2));
        $this->assertEquals(1000.0, $numerics->round(1234, -3));
        $this->assertEquals(0.0, $numerics->round(1234, -4));
    }

    /**
     * Test instance settings
     */
    public function testInstance(): void
    {
        $numerics = new Numerics();
        $this->assertEquals(1235.0000, $numerics->round(1234.5678));

        $numerics = new Numerics(2);
        $this->assertEquals(1234.5700, $numerics->round(1234.5678));

        $numerics = new Numerics(-2);
        $this->assertEquals(1200.0000, $numerics->round(1234.5678));
    }

    /**
     * Test invalid input type on number argument
     */
    public function testInvalidNumberInput(): void
    {
        $numerics = new Numerics();
        $this->expectException('TypeError');
        $numerics->round('should fail');
    }

    /**
     * Test invalid input type on precision argument
     */
    public function testInvalidPrecisionInput(): void
    {
        $numerics = new Numerics();
        $this->expectException('TypeError');
        $numerics->round(12.34, 'should fail');
    }
}
