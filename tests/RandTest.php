<?php

/**
 * File for Numerics rand function tests.
 * @package Phrity > Util > Numerics
 */

declare(strict_types=1);

namespace Phrity\Util;

use PHPUnit\Framework\TestCase;
use Phrity\Util\Numerics;
use TypeError;

/**
 * Numerics rand test class.
 */
class RandTest extends TestCase
{
    /**
     * Set up for all tests
     */
    public function setUp(): void
    {
        error_reporting(-1);
    }

    /**
     * Test rand ranges
     */
    public function testRangeRand(): void
    {
        $numerics = new Numerics();

        $rand = $numerics->rand(0, 2);
        $this->assertGreaterThanOrEqual(0, $rand);
        $this->assertLessThanOrEqual(2, $rand);

        $rand = $numerics->rand(-1, 1);
        $this->assertGreaterThanOrEqual(-1, $rand);
        $this->assertLessThanOrEqual(1, $rand);

        $rand = $numerics->rand(0.4, 0.6, 1);
        $this->assertGreaterThanOrEqual(0.4, $rand);
        $this->assertLessThanOrEqual(0.6, $rand);

        $rand = $numerics->rand(0.04, 0.06, 2);
        $this->assertGreaterThanOrEqual(0.04, $rand);
        $this->assertLessThanOrEqual(0.06, $rand);

        $rand = $numerics->rand(-0.1, 0.1, 1);
        $this->assertGreaterThanOrEqual(-0.1, $rand);
        $this->assertLessThanOrEqual(0.1, $rand);
    }

    /**
     * Test rand max value and high precision
     */
    public function testRandMax(): void
    {
        $numerics = new Numerics();
        $rand_max = mt_getrandmax();

        $rand = $numerics->rand();
        $this->assertGreaterThanOrEqual(0, $rand);
        $this->assertLessThanOrEqual($rand_max, $rand);

        $rand = $numerics->rand(-$rand_max, 0);
        $this->assertGreaterThanOrEqual(-$rand_max, $rand);
        $this->assertLessThanOrEqual(0, $rand);

        $rand = $numerics->rand($rand_max, $rand_max * 2, 0);
        $this->assertGreaterThanOrEqual($rand_max, $rand);
        $this->assertLessThanOrEqual($rand_max * 2, $rand);
    }

    /**
     * Test rand max value and high precision
     */
    public function testLargeNumbers(): void
    {
        $numerics = new Numerics();

        $rand = $numerics->rand(0, 1234567890, 8);
        $this->assertGreaterThanOrEqual(0, $rand);
        $this->assertLessThanOrEqual(1234567890, $rand);

        $rand = $numerics->rand(0, 1234567890, 32);
        $this->assertGreaterThanOrEqual(0, $rand);
        $this->assertLessThanOrEqual(1234567890, $rand);
    }

    /**
     * Test single possible returns
     */
    public function testSingulars(): void
    {
        $numerics = new Numerics();

        $this->assertEquals(100, $numerics->rand(1, 199, -2));
        $this->assertEquals(10, $numerics->rand(1, 19, -1));
        $this->assertEquals(1, $numerics->rand(0.1, 1.9, 0));
        $this->assertEquals(0.1, $numerics->rand(0.01, 0.19, 1));
        $this->assertEquals(0.01, $numerics->rand(0.001, 0.019, 2));
    }

    /**
     * Test invalid min/max/precision combinations
     */
    public function testInvalidRange(): void
    {
        $numerics = new Numerics();

        $this->assertNull($numerics->rand(10, 9));
        $this->assertNull($numerics->rand(0.1, 0.9, 0));
        $this->assertNull($numerics->rand(0.01, 0.09, 1));
    }

    /**
     * Test invalid input type on min argument
     */
    public function testInvalidMinInput(): void
    {
        $numerics = new Numerics();
        $this->expectException(TypeError::class);
        $this->expectExceptionMessage('Argument #1 ($min) must be of type float, string given,');
        $numerics->rand('should fail', 1.2, 0);
    }

    /**
     * Test invalid input type on max argument
     */
    public function testInvalidMaxInput(): void
    {
        $numerics = new Numerics();
        $this->expectException(TypeError::class);
        $this->expectExceptionMessage('Argument #2 ($max) must be of type ?float, string given');
        $numerics->rand(1.2, 'should fail', 0);
    }

    /**
     * Test invalid input type on precision argument
     */
    public function testInvalidPrecisionInput(): void
    {
        $numerics = new Numerics();
        $this->expectException(TypeError::class);
        $this->expectExceptionMessage('Argument #3 ($precision) must be of type ?int, string given');
        $numerics->rand(1.2, null, 'should fail');
    }
}
