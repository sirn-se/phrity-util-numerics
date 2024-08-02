<?php

/**
 * File for Numerics mround function tests.
 * @package Phrity > Util > Numerics
 */

declare(strict_types=1);

namespace Phrity\Util;

use DomainException;
use PHPUnit\Framework\TestCase;
use Phrity\Util\Numerics;
use TypeError;

/**
 * Numerics mround test class.
 */
class MRoundTest extends TestCase
{
    /**
     * Set up for all tests
     */
    public function setUp(): void
    {
        error_reporting(-1);
    }

    /**
     * Test round with decimal multiples
     */
    public function testRoundDecimal(): void
    {
        $numerics = new Numerics();

        $this->assertEquals(456.789, $numerics->mround(456.789, 0.001));
        $this->assertEquals(456.79, $numerics->mround(456.789, 0.01));
        $this->assertEquals(456.8, $numerics->mround(456.789, 0.1));
        $this->assertEquals(457, $numerics->mround(456.789, 1));
        $this->assertEquals(460, $numerics->mround(456.789, 10));
        $this->assertEquals(500, $numerics->mround(456.789, 100));
    }

    /**
     * Test round with fractions
     */
    public function testRoundFractions(): void
    {
        $numerics = new Numerics();

        $this->assertEquals(456.75, $numerics->mround(456.789, 0.25));
        $this->assertEquals(457.5, $numerics->mround(456.789, 2.5));
        $this->assertEquals(450, $numerics->mround(456.789, 25));
        $this->assertEquals(500, $numerics->mround(456.789, 250));
    }

    /**
     * Test unresolvable
     */
    public function testInvalidMultipleOf(): void
    {
        $numerics = new Numerics();
        $this->expectException(DomainException::class);
        $this->expectExceptionMessage('Argument #2 ($multipleOf) must be a float higher than 0');
        $this->assertNull($numerics->mround(456.789, 0));
    }

    /**
     * Test invalid input type on number argument
     */
    public function testInvalidNumberInput(): void
    {
        $numerics = new Numerics();
        $this->expectException(TypeError::class);
        $this->expectExceptionMessage('Argument #1 ($number) must be of type float, string given');
        $numerics->mround('should fail', 1);
    }

    /**
     * Test invalid input type on precision argument
     */
    public function testInvalidMultipleOfInput(): void
    {
        $numerics = new Numerics();
        $this->expectException(TypeError::class);
        $this->expectExceptionMessage('Argument #2 ($multipleOf) must be of type float, string given');
        $numerics->mround(12.34, 'should fail');
    }
}
