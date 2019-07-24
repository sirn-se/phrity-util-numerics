<?php
/**
 * File for Numerics format function tests.
 * @package Phrity > Util > Numerics
 */
namespace Phrity\Util;

use Phrity\Util\Numerics;
use PHPUnit\Framework\TestCase;

/**
 * Numerics format test class.
 */
class FormatTest extends TestCase
{
    /**
     * Set up for all tests
     */
    public function setUp()
    {
        error_reporting(-1);
    }

    /**
     * Test formats
     */
    public function testFormat()
    {
        $numerics = new Numerics();

        $this->assertEquals('0', $numerics->format(0));
        $this->assertEquals('0.00', $numerics->format(0, 2));
        $this->assertEquals('12.34', $numerics->format(12.34, 2));
        $this->assertEquals('12.35', $numerics->format(12.345678, 2));
        $this->assertEquals('-12.34', $numerics->format(-12.34, 2));
        $this->assertEquals('1234.56', $numerics->format(1234.56, 2));
    }

    /**
     * Test swedish format
     */
    public function testSvSeFormat()
    {
        $numerics = new Numerics();
        $numerics->setLocale('sv_SE.utf8');

        $this->assertEquals('1 234,56', $numerics->format(1234.56, 2));
    }

    /**
     * Test english format
     */
    public function testEnUsFormat()
    {
        $numerics = new Numerics();
        $numerics->setLocale('en_US.utf8');

        $this->assertEquals('1,234.56', $numerics->format(1234.56, 2));
    }

    /**
     * Test invalid input type on number argument
     * @expectedException TypeError
     */
    public function testInvalidNumberInput()
    {
        $numerics = new Numerics();
        $numerics->format('should fail');
    }

    /**
     * Test invalid input type on precision argument
     * @expectedException TypeError
     */
    public function testInvalidPrecisionInput()
    {
        $numerics = new Numerics();
        $numerics->format(12.34, 'should fail');
    }
}
