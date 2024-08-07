<?php

/**
 * File for Numerics parse function tests.
 * @package Phrity > Util > Numerics
 */

declare(strict_types=1);

namespace Phrity\Util;

use PHPUnit\Framework\TestCase;
use Phrity\Util\Numerics;

/**
 * Numerics parse() test class.
 */
class ParseTest extends TestCase
{
    /**
     * Set up for all tests
     */
    public function setUp(): void
    {
        error_reporting(-1);
    }

    /**
     * Test integer and float input
     */
    public function testIntegerAndFloat(): void
    {
        $numerics = new Numerics();

        $this->assertSame(1234.56, $numerics->parse(1234.56));
        $this->assertSame(1234.00, $numerics->parse(1234));
        $this->assertSame(-1234.56, $numerics->parse(-1234.56));
        $this->assertSame(-1234.00, $numerics->parse(-1234));
    }

    /**
     * Test string input with decimals
     */
    public function testWithDecimals(): void
    {
        $numerics = new Numerics();

        $this->assertSame(0.0, $numerics->parse('0.0'));

        $this->assertSame(1234.560, $numerics->parse('1234.560'));
        $this->assertSame(1234.560, $numerics->parse('1234,560'));
        $this->assertSame(1234.560, $numerics->parse('1 234.560'));
        $this->assertSame(1234.560, $numerics->parse('1 234,560'));
        $this->assertSame(1234.560, $numerics->parse('1,234.560'));
        $this->assertSame(1234.560, $numerics->parse('1.234,560'));

        $this->assertSame(-1234.560, $numerics->parse('-1234.560'));
        $this->assertSame(-1234.560, $numerics->parse('-1234,560'));
        $this->assertSame(-1234.560, $numerics->parse('-1 234.560'));
        $this->assertSame(-1234.560, $numerics->parse('-1 234,560'));
        $this->assertSame(-1234.560, $numerics->parse('-1,234.560'));
        $this->assertSame(-1234.560, $numerics->parse('-1.234,560'));

        $this->assertSame(1234567.890, $numerics->parse('1234567.890'));
        $this->assertSame(1234567.890, $numerics->parse('1234567,890'));
        $this->assertSame(1234567.890, $numerics->parse('1 234 567.890'));
        $this->assertSame(1234567.890, $numerics->parse('1 234 567,890'));
        $this->assertSame(1234567.890, $numerics->parse('1,234,567.890'));
        $this->assertSame(1234567.890, $numerics->parse('1.234.567,890'));

        $this->assertSame(-1234567.890, $numerics->parse('-1234567.890'));
        $this->assertSame(-1234567.890, $numerics->parse('-1234567,890'));
        $this->assertSame(-1234567.890, $numerics->parse('-1 234 567.890'));
        $this->assertSame(-1234567.890, $numerics->parse('-1 234 567,890'));
        $this->assertSame(-1234567.890, $numerics->parse('-1,234,567.890'));
        $this->assertSame(-1234567.890, $numerics->parse('-1.234.567,890'));

        $this->assertSame(1234.56, $numerics->parse('1,234.56'));
        $this->assertSame(1234.56, $numerics->parse('1.234,56'));
    }

    /**
     * Test string input without decimals
     */
    public function testWithoutDecimals(): void
    {
        $numerics = new Numerics();

        $this->assertSame(0.0, $numerics->parse('0'));

        $this->assertSame(1234.0, $numerics->parse('1234'));
        $this->assertSame(1234.0, $numerics->parse('1234'));
        $this->assertSame(1234.0, $numerics->parse('1 234'));
        $this->assertSame(1234.0, $numerics->parse('1 234'));

        $this->assertSame(-1234.0, $numerics->parse('-1234'));
        $this->assertSame(-1234.0, $numerics->parse('-1234'));
        $this->assertSame(-1234.0, $numerics->parse('-1 234'));
        $this->assertSame(-1234.0, $numerics->parse('-1 234'));

        $this->assertSame(1234567.0, $numerics->parse('1234567'));
        $this->assertSame(1234567.0, $numerics->parse('1234567'));
        $this->assertSame(1234567.0, $numerics->parse('1 234 567'));
        $this->assertSame(1234567.0, $numerics->parse('1 234 567'));
        $this->assertSame(1234567.0, $numerics->parse('1,234,567'));
        $this->assertSame(1234567.0, $numerics->parse('1.234.567'));

        $this->assertSame(-1234567.0, $numerics->parse('-1234567'));
        $this->assertSame(-1234567.0, $numerics->parse('-1234567'));
        $this->assertSame(-1234567.0, $numerics->parse('-1 234 567'));
        $this->assertSame(-1234567.0, $numerics->parse('-1 234 567'));
        $this->assertSame(-1234567.0, $numerics->parse('-1,234,567'));
        $this->assertSame(-1234567.0, $numerics->parse('-1.234.567'));
    }

    /**
     * Test string input in malformed but parsable format
     */
    public function testApproximations(): void
    {
        $numerics = new Numerics();

        // Missing leading zero
        $this->assertSame(0.456, $numerics->parse(',456'));
        $this->assertSame(0.456, $numerics->parse('.456'));
        $this->assertSame(-0.456, $numerics->parse('-,456'));
        $this->assertSame(-0.456, $numerics->parse('-.456'));

        // Trailing decimal separator
        $this->assertSame(456.0, $numerics->parse('456,'));
        $this->assertSame(456.0, $numerics->parse('456.'));
        $this->assertSame(1456.0, $numerics->parse('1.456,'));
        $this->assertSame(1456.0, $numerics->parse('1,456.'));

        // Additional white-spaces
        $this->assertSame(1234.560, $numerics->parse('  1234.560  '));
        $this->assertSame(-1234.560, $numerics->parse(' - 1234.56 '));
        $this->assertSame(1234.560, $numerics->parse("\t1234,56\n"));
        $this->assertSame(-1234.560, $numerics->parse("-\t1234,56\n"));

        // Non-standard minus signs
        $this->assertSame(-1234567.0, $numerics->parse('−1.234.567'));
        $this->assertSame(-1234567.0, $numerics->parse('₋1.234.567'));
        $this->assertSame(-1234567.0, $numerics->parse('⁻1.234.567'));
        $this->assertSame(-1234567.0, $numerics->parse('˗1.234.567'));

        // Plus signs
        $this->assertSame(1234567.0, $numerics->parse('+1.234.567'));
        $this->assertSame(1234567.0, $numerics->parse('+1.234.567'));
        $this->assertSame(1234567.0, $numerics->parse('+1.234.567'));
        $this->assertSame(1234567.0, $numerics->parse('ᐩ1.234.567'));
        $this->assertSame(1234567.0, $numerics->parse('⁺1.234.567'));
        $this->assertSame(1234567.0, $numerics->parse('₊1.234.567'));
        $this->assertSame(1234567.0, $numerics->parse('➕1.234.567'));
        $this->assertSame(1234567.0, $numerics->parse('﹢1.234.567'));
        $this->assertSame(1234567.0, $numerics->parse('＋1.234.567'));
    }

    /**
     * Test string input with locale based parsing
     */
    public function testLocaleSvSe(): void
    {
        $numerics = new Numerics();
        $numerics->setLocale('sv_SE.utf-8');

        $this->assertSame(12345.0, $numerics->parse('12 345'));
        $this->assertSame(12.345, $numerics->parse('12.345'));
        $this->assertSame(12.345, $numerics->parse('12,345'));

        $numerics = new Numerics(null, 'sv_SE.utf-8');

        $this->assertSame(12345.0, $numerics->parse('12 345'));
        $this->assertSame(12.345, $numerics->parse('12.345'));
        $this->assertSame(12.345, $numerics->parse('12,345'));
    }

    /**
     * Test string input with locale based parsing
     */
    public function testLocaleEnUs(): void
    {
        $numerics = new Numerics();
        $numerics->setLocale('en_US.utf-8');

        $this->assertSame(12345.0, $numerics->parse('12 345'));
        $this->assertSame(12.345, $numerics->parse('12.345'));
        $this->assertSame(12345.0, $numerics->parse('12,345'));

        $numerics = new Numerics(null, 'en_US.utf-8');

        $this->assertSame(12345.0, $numerics->parse('12 345'));
        $this->assertSame(12.345, $numerics->parse('12.345'));
        $this->assertSame(12345.0, $numerics->parse('12,345'));
    }

    /**
     * Test unparsable input
     */
    public function testUnparsable(): void
    {
        $numerics = new Numerics();

        // Non-numeric input
        $this->assertNull($numerics->parse(null));
        $this->assertNull($numerics->parse([]));
        $this->assertNull($numerics->parse(new \stdclass()));

        // Mutliple separators
        $this->assertNull($numerics->parse('1 234 567.890.123'));
        $this->assertNull($numerics->parse('1,234,567.890.123'));
        $this->assertNull($numerics->parse('1 234 567,890,123'));
        $this->assertNull($numerics->parse('1.234.567,890,123'));
        $this->assertNull($numerics->parse('1,234,567 890 123'));
        $this->assertNull($numerics->parse('1.234.567 890 123'));
        $this->assertNull($numerics->parse('1,234 567,890 123'));

        $this->assertNull($numerics->parse('-1 234 567.890.123'));
        $this->assertNull($numerics->parse('-1,234,567.890.123'));
        $this->assertNull($numerics->parse('-1 234 567,890,123'));
        $this->assertNull($numerics->parse('-1.234.567,890,123'));
        $this->assertNull($numerics->parse('-1,234,567 890 123'));
        $this->assertNull($numerics->parse('-1.234.567 890 123'));
        $this->assertNull($numerics->parse('-1,234 567,890 123'));

        // Invalid characters
        $this->assertNull($numerics->parse('abcd'));
        $this->assertNull($numerics->parse('13A,56'));
        $this->assertNull($numerics->parse('45-6'));
        $this->assertNull($numerics->parse("\t"));
        $this->assertNull($numerics->parse('12%'));
        $this->assertNull($numerics->parse('±23'));
    }
}
