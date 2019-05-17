<?php
/**
 * File for Numerics parse function tests.
 * @package Phrity > Util > Numerics
 */
namespace Phrity\Util;

use Phrity\Util\Numerics;
use PHPUnit_Framework_TestCase;

/**
 * Numerics parse() test class.
 */
class ParseTest extends PHPUnit_Framework_TestCase
{
    /**
     * Set up for all tests
     */
    public function setUp()
    {
        error_reporting(-1);
    }
    
    /**
     * Test integer and float input
     */
    public function testIntegerAndFloat()
    {
        $this->assertSame(1234.56, Numerics::parse(1234.56));
        $this->assertSame(1234.00, Numerics::parse(1234));
        $this->assertSame(-1234.56, Numerics::parse(-1234.56));
        $this->assertSame(-1234.00, Numerics::parse(-1234));
    }

    /**
     * Test string input with decimals
     */
    public function testWithDecimals()
    {
        $this->assertSame(0.0, Numerics::parse('0.0'));

        $this->assertSame(1234.560, Numerics::parse('1234.560'));
        $this->assertSame(1234.560, Numerics::parse('1234,560'));
        $this->assertSame(1234.560, Numerics::parse('1 234.560'));
        $this->assertSame(1234.560, Numerics::parse('1 234,560'));
        $this->assertSame(1234.560, Numerics::parse('1,234.560'));
        $this->assertSame(1234.560, Numerics::parse('1.234,560'));

        $this->assertSame(-1234.560, Numerics::parse('-1234.560'));
        $this->assertSame(-1234.560, Numerics::parse('-1234,560'));
        $this->assertSame(-1234.560, Numerics::parse('-1 234.560'));
        $this->assertSame(-1234.560, Numerics::parse('-1 234,560'));
        $this->assertSame(-1234.560, Numerics::parse('-1,234.560'));
        $this->assertSame(-1234.560, Numerics::parse('-1.234,560'));

        $this->assertSame(1234567.890, Numerics::parse('1234567.890'));
        $this->assertSame(1234567.890, Numerics::parse('1234567,890'));
        $this->assertSame(1234567.890, Numerics::parse('1 234 567.890'));
        $this->assertSame(1234567.890, Numerics::parse('1 234 567,890'));
        $this->assertSame(1234567.890, Numerics::parse('1,234,567.890'));
        $this->assertSame(1234567.890, Numerics::parse('1.234.567,890'));

        $this->assertSame(-1234567.890, Numerics::parse('-1234567.890'));
        $this->assertSame(-1234567.890, Numerics::parse('-1234567,890'));
        $this->assertSame(-1234567.890, Numerics::parse('-1 234 567.890'));
        $this->assertSame(-1234567.890, Numerics::parse('-1 234 567,890'));
        $this->assertSame(-1234567.890, Numerics::parse('-1,234,567.890'));
        $this->assertSame(-1234567.890, Numerics::parse('-1.234.567,890'));
    }

    /**
     * Test string input without decimals
     */
    public function testWithoutDecimals()
    {
        $this->assertSame(0.0, Numerics::parse('0'));

        $this->assertSame(1234.0, Numerics::parse('1234'));
        $this->assertSame(1234.0, Numerics::parse('1234'));
        $this->assertSame(1234.0, Numerics::parse('1 234'));
        $this->assertSame(1234.0, Numerics::parse('1 234'));

        $this->assertSame(-1234.0, Numerics::parse('-1234'));
        $this->assertSame(-1234.0, Numerics::parse('-1234'));
        $this->assertSame(-1234.0, Numerics::parse('-1 234'));
        $this->assertSame(-1234.0, Numerics::parse('-1 234'));

        $this->assertSame(1234567.0, Numerics::parse('1234567'));
        $this->assertSame(1234567.0, Numerics::parse('1234567'));
        $this->assertSame(1234567.0, Numerics::parse('1 234 567'));
        $this->assertSame(1234567.0, Numerics::parse('1 234 567'));
        $this->assertSame(1234567.0, Numerics::parse('1,234,567'));
        $this->assertSame(1234567.0, Numerics::parse('1.234.567'));

        $this->assertSame(-1234567.0, Numerics::parse('-1234567'));
        $this->assertSame(-1234567.0, Numerics::parse('-1234567'));
        $this->assertSame(-1234567.0, Numerics::parse('-1 234 567'));
        $this->assertSame(-1234567.0, Numerics::parse('-1 234 567'));
        $this->assertSame(-1234567.0, Numerics::parse('-1,234,567'));
        $this->assertSame(-1234567.0, Numerics::parse('-1.234.567'));
    }

    /**
     * Test string input in malformed but parsable format
     */
    public function testApproximations()
    {
        // Missing leading zero
        $this->assertSame(0.456, Numerics::parse(',456'));
        $this->assertSame(0.456, Numerics::parse('.456'));
        $this->assertSame(-0.456, Numerics::parse('-,456'));
        $this->assertSame(-0.456, Numerics::parse('-.456'));

        // Trailing decimal separator
        $this->assertSame(456.0, Numerics::parse('456,'));
        $this->assertSame(456.0, Numerics::parse('456.'));
        $this->assertSame(1456.0, Numerics::parse('1.456,'));
        $this->assertSame(1456.0, Numerics::parse('1,456.'));

        // Additional white-spaces
        $this->assertSame(1234.560, Numerics::parse('  1234.560  '));
        $this->assertSame(-1234.560, Numerics::parse(' - 1234.56 '));
        $this->assertSame(1234.560, Numerics::parse("\t1234,56\n"));
        $this->assertSame(-1234.560, Numerics::parse("-\t1234,56\n"));

        // Non-standard minus signs
        $this->assertSame(-1234567.0, Numerics::parse('−1.234.567'));
        $this->assertSame(-1234567.0, Numerics::parse('₋1.234.567'));
        $this->assertSame(-1234567.0, Numerics::parse('⁻1.234.567'));
        $this->assertSame(-1234567.0, Numerics::parse('˗1.234.567'));

        // Plus signs
        $this->assertSame(1234567.0, Numerics::parse('+1.234.567'));
        $this->assertSame(1234567.0, Numerics::parse('+1.234.567'));
        $this->assertSame(1234567.0, Numerics::parse('+1.234.567'));
        $this->assertSame(1234567.0, Numerics::parse('ᐩ1.234.567'));
        $this->assertSame(1234567.0, Numerics::parse('⁺1.234.567'));
        $this->assertSame(1234567.0, Numerics::parse('₊1.234.567'));
        $this->assertSame(1234567.0, Numerics::parse('➕1.234.567'));
        $this->assertSame(1234567.0, Numerics::parse('﹢1.234.567'));
        $this->assertSame(1234567.0, Numerics::parse('＋1.234.567'));
    }

    /**
     * Test string input with locale based parsing
     */
    public function testLocaleSvSe()
    {
        $original = setlocale(LC_NUMERIC, 0);
        setlocale(LC_NUMERIC, 'sv_SE');

        $this->assertSame(12345.0, Numerics::parse('12 345'));
        $this->assertSame(12.345, Numerics::parse('12.345'));
        $this->assertSame(12.345, Numerics::parse('12,345'));

        setlocale(LC_NUMERIC, $original);
    }

    /**
     * Test string input with locale based parsing
     */
    public function testLocaleEnUs()
    {
        $original = setlocale(LC_NUMERIC, 0);
        setlocale(LC_NUMERIC, 'en_US');

        $this->assertSame(12345.0, Numerics::parse('12 345'));
        $this->assertSame(12.345, Numerics::parse('12.345'));

        // The following won´t work if locale is nit available
        $loc = localeconv();
        if ($loc['thousands_sep'] == ',') {
            $this->assertSame(12345.0, Numerics::parse('12,345'));
        }

        setlocale(LC_NUMERIC, $original);
    }

    /**
     * Test unparsable input
     */
    public function testUnparsable()
    {
        // Non-numeric input
        $this->assertNull(Numerics::parse(null));
        $this->assertNull(Numerics::parse([]));
        $this->assertNull(Numerics::parse(new \stdclass));

        // Mutliple separators
        $this->assertNull(Numerics::parse('1 234 567.890.123'));
        $this->assertNull(Numerics::parse('1,234,567.890.123'));
        $this->assertNull(Numerics::parse('1 234 567,890,123'));
        $this->assertNull(Numerics::parse('1.234.567,890,123'));
        $this->assertNull(Numerics::parse('1,234,567 890 123'));
        $this->assertNull(Numerics::parse('1.234.567 890 123'));
        $this->assertNull(Numerics::parse('1,234 567,890 123'));

        $this->assertNull(Numerics::parse('-1 234 567.890.123'));
        $this->assertNull(Numerics::parse('-1,234,567.890.123'));
        $this->assertNull(Numerics::parse('-1 234 567,890,123'));
        $this->assertNull(Numerics::parse('-1.234.567,890,123'));
        $this->assertNull(Numerics::parse('-1,234,567 890 123'));
        $this->assertNull(Numerics::parse('-1.234.567 890 123'));
        $this->assertNull(Numerics::parse('-1,234 567,890 123'));

        // Invalid characters
        $this->assertNull(Numerics::parse('abcd'));
        $this->assertNull(Numerics::parse('13A,56'));
        $this->assertNull(Numerics::parse('45-6'));
        $this->assertNull(Numerics::parse("\t"));
        $this->assertNull(Numerics::parse('12%'));
        $this->assertNull(Numerics::parse('±23'));
    }
}
