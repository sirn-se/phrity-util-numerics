<?php
/**
 * File for Numerics precision function tests.
 * @package Phrity > Util > Numerics
 */
namespace Phrity\Util;

use Phrity\Util\Numerics;
use PHPUnit_Framework_TestCase;

/**
 * Numerics precision test class.
 */
class PrecisionTest extends PHPUnit_Framework_TestCase
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
        $this->assertEquals(0, Numerics::precision(0));
        $this->assertEquals(0, Numerics::precision(12));
        $this->assertEquals(0, Numerics::precision(12.0));
        $this->assertEquals(1, Numerics::precision(12.3));
        $this->assertEquals(1, Numerics::precision(12.30));
        $this->assertEquals(2, Numerics::precision(12.34));
        $this->assertEquals(2, Numerics::precision(12.340));
    }

    /**
     * Test precision null returns
     */
    public function testInvalidPrecision()
    {
        $this->assertNull(Numerics::precision(null));
        $this->assertNull(Numerics::precision([]));
        $this->assertNull(Numerics::precision('12.34')); // Numeric but not number
    }
}
