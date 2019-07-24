<?php
/**
 * File for Numerics precision function tests.
 * @package Phrity > Util > Numerics
 */
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
    public function setUp()
    {
        error_reporting(-1);
    }

    /**
     * Test precision
     */
    public function testValidPrecision()
    {
        $numerics = new Numerics();

        $this->assertEquals(0, $numerics->precision(0));
        $this->assertEquals(0, $numerics->precision(12));
        $this->assertEquals(0, $numerics->precision(12.0));
        $this->assertEquals(1, $numerics->precision(12.3));
        $this->assertEquals(1, $numerics->precision(12.30));
        $this->assertEquals(2, $numerics->precision(12.34));
        $this->assertEquals(2, $numerics->precision(12.340));
    }

    /**
     * Test invalid input type on number argument
     * @expectedException TypeError
     */
    public function testInvalidInput()
    {
        $numerics = new Numerics();
        $numerics->precision('should fail');
    }
}
