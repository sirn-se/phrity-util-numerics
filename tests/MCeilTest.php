<?php

/**
 * File for Numerics ceil function tests.
 * @package Phrity > Util > Numerics
 */

declare(strict_types=1);

namespace Phrity\Util;

use DomainException;
use PHPUnit\Framework\TestCase;
use Phrity\Util\Numerics;
use TypeError;

/**
 * Numerics mceil test class.
 */
class MCeilTest extends TestCase
{
    /**
     * Set up for all tests
     */
    public function setUp(): void
    {
        error_reporting(-1);
    }

    /**
     * Test ceil with decimal multiples
     */
    public function testCeilDecimal(): void
    {
        $numerics = new Numerics();

        $this->assertEquals(123.123, $numerics->mceil(123.123, 0.001));
        $this->assertEquals(123.13, $numerics->mceil(123.123, 0.01));
        $this->assertEquals(123.2, $numerics->mceil(123.123, 0.1));
        $this->assertEquals(124, $numerics->mceil(123.123, 1));
        $this->assertEquals(130, $numerics->mceil(123.123, 10));
        $this->assertEquals(200, $numerics->mceil(123.123, 100));
    }

    /**
     * Test ceil with fractions
     */
    public function testCeilFractions(): void
    {
        $numerics = new Numerics();

        $this->assertEquals(123.25, $numerics->mceil(123.123, 0.25));
        $this->assertEquals(125, $numerics->mceil(123.123, 2.5));
        $this->assertEquals(125, $numerics->mceil(123.123, 25));
        $this->assertEquals(250, $numerics->mceil(123.123, 250));
    }

    /**
     * Test unresolvable
     */
    public function testInvalidMultipleOf(): void
    {
        $numerics = new Numerics();
        $this->expectException(DomainException::class);
        $this->expectExceptionMessage('Argument #2 ($multipleOf) must be a float higher than 0');
        $this->assertNull($numerics->mceil(456.789, 0));
    }

    /**
     * Test invalid input type on number argument
     */
    public function testInvalidNumberInput(): void
    {
        $numerics = new Numerics();
        $this->expectException(TypeError::class);
        $this->expectExceptionMessage('Argument #1 ($number) must be of type float, string given');
        $numerics->mceil('should fail', 1);
    }

    /**
     * Test invalid input type on multiple-by argument
     */
    public function testInvalidMultipleOfInput(): void
    {
        $numerics = new Numerics();
        $this->expectException(TypeError::class);
        $this->expectExceptionMessage('Argument #2 ($multipleOf) must be of type float, string given');
        $numerics->mceil(12.34, 'should fail');
    }
}
