<?php

/**
 * File for Numerics precision function tests.
 * @package Phrity > Util > Numerics
 */

declare(strict_types=1);

namespace Phrity\Util;

use Phrity\Util\Numerics;
use PHPUnit\Framework\TestCase;

/**
 * Numerics precision test class.
 */
class PrecisionTest extends TestCase
{
    /**
     * Set up for all tests
     */
    public function setUp(): void
    {
        error_reporting(-1);
    }

    /**
     * Test precision
     */
    public function testValidPrecision(): void
    {
        $numerics = new Numerics();

        $this->assertEquals(0, $numerics->precision(0));
        $this->assertEquals(0, $numerics->precision(12));
        $this->assertEquals(0, $numerics->precision(12.0));
        $this->assertEquals(1, $numerics->precision(12.3));
        $this->assertEquals(1, $numerics->precision(12.30));
        $this->assertEquals(2, $numerics->precision(12.34));
        $this->assertEquals(2, $numerics->precision(12.340));
        $this->assertEquals(6, $numerics->precision(0.123456789123456789));
        $this->assertEquals(15, $numerics->precision(0.123456789123456789, true));
        $this->assertEquals(0, $numerics->precision(1.0E+25));
    }

    /**
     * Test invalid input type on number argument
     */
    public function testInvalidInput(): void
    {
        $numerics = new Numerics();
        $this->expectException('TypeError');
        $numerics->precision('should fail');
    }
}
