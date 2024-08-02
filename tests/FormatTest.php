<?php

/**
 * File for Numerics format function tests.
 * @package Phrity > Util > Numerics
 */

declare(strict_types=1);

namespace Phrity\Util;

use PHPUnit\Framework\TestCase;
use Phrity\Util\Numerics;
use TypeError;

/**
 * Numerics format test class.
 */
class FormatTest extends TestCase
{
    /**
     * Set up for all tests
     */
    public function setUp(): void
    {
        error_reporting(-1);
    }

    /**
     * Test formats
     */
    public function testFormat(): void
    {
        $numerics = new Numerics();

        $this->assertEquals('0', $numerics->format(0));
        $this->assertEquals('0.00', $numerics->format(0, 2));
        $this->assertEquals('12.34', $numerics->format(12.34, 2));
        $this->assertEquals('12.35', $numerics->format(12.345678, 2));
        $this->assertEquals('-12.34', $numerics->format(-12.34, 2));
        $this->assertEquals('1234.56', $numerics->format(1234.56, 2));
        $this->assertEquals('1200', $numerics->format(1234.56, -2));
        $this->assertEquals('1234.5600000000', $numerics->format(1234.56, 10));
        $this->assertEquals('0.12345678912345678380', $numerics->format(0.123456789123456789, 20));
    }

    /**
     * Test US format
     */
    public function testEnUsFormat(): void
    {
        $numerics = new Numerics();
        $numerics->setLocale('en_US.utf-8');

        $this->assertEquals('1,234.56', $numerics->format(1234.56, 2));

        $numerics = new Numerics(null, 'en_US.utf-8');

        $this->assertEquals('1,234.56', $numerics->format(1234.56, 2));
    }

    /**
     * Test precisions
     */
    public function testPrecisions(): void
    {
        $numerics = new Numerics();
        $this->assertEquals('1234.57', $numerics->format(1234.5678, 2));

        $numerics = new Numerics(3);
        $this->assertEquals('1234.568', $numerics->format(1234.5678));

        $numerics = new Numerics();
        $this->assertEquals('1234.5678', $numerics->format(1234.5678));
    }

    /**
     * Test invalid input type on number argument
     */
    public function testInvalidNumberInput(): void
    {
        $numerics = new Numerics();
        $this->expectException(TypeError::class);
        $this->expectExceptionMessage('Argument #1 ($number) must be of type float, string given');
        $numerics->format('should fail');
    }

    /**
     * Test invalid input type on precision argument
     */
    public function testInvalidPrecisionInput(): void
    {
        $numerics = new Numerics();
        $this->expectException(TypeError::class);
        $this->expectExceptionMessage('Argument #2 ($precision) must be of type ?int, string given');
        $numerics->format(12.34, 'should fail');
    }
}
