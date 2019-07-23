<?php
declare(strict_types=1);

/**
 * File for Numerics utility class.
 * @package Phrity > Util > Numerics
 */
namespace Phrity\Util;

/**
 * Numerics utility class.
 * Float versions of ceil(), floor() and rand() with precision.
 * Open minded numeric parser and formatter.
 */
class Numerics
{

    private $precision;

    public function __construct(int $precision = 0)
    {
        $this->precision = $precision;
    }

    /**
     * Floor function with precision.
     * @param  number   $number    The number to apply floor to
     * @param  integer  $precision Precision to apply
     * @return float               Return floor with precision
     */
    public function floor(float $number, int $precision = null): float
    {
        $f = pow(10, $precision ?? $this->precision);
        return floor($number * $f) / $f;
    }

    /**
     * Ceil function with precision.
     * @param  number   $number    The number to apply ceil to
     * @param  integer  $precision Precision to apply
     * @return float               Return ceil with precision
     */
    public function ceil(float $number, int $precision = null): float
    {
        $f = pow(10, $precision ?? $this->precision);
        return ceil($number * $f) / $f;
    }

    /**
     * Random float number generator with precision.
     * @param  number   $min       Lowest result
     * @param  number   $max       Highest result
     * @param  integer  $precision Precision to use
     * @return float               Random number with precision (null if not solvable)
     */
    public function rand(float $min = 0, float $max = null, int $precision = null): ?float
    {
        $rand_max = mt_getrandmax();
        $max = is_null($max) ? $rand_max : $max;
        $precision = $precision ?? $this->precision;

        do {
            // Decrease precision (if neccesary) to fit rand max
            $f = pow(10, $precision);
            $real_min = ceil($min * $f);
            $real_max = floor($max * $f);
            $precision--;

            // Impossbile to get a number using provided min/max/precision combination
            if ($real_min > $real_max) {
                return null;
            }
        } while ($real_max - $real_min > $rand_max);

        return mt_rand((int)$real_min, (int)$real_max) / $f;
    }

    /**
     * Count number of relevant decimals in a number.
     * @param  number $number The number to count decimals on
     * @return int            Number of decimals
     */
    public function precision(float $number): int
    {
        $pos = strrchr((string)$number, '.');
        return $pos ? max(0, strlen($pos) - 1) : 0;
    }

    /**
     * Numeric parser.
     * Identifies decimal/thousand separator from input rather than assumptions.
     * @param  mixed $numeric  A numeric representation to parse
     * @return float           Return as float (null if parsing failed)
     */
    public function parse($numeric): ?float
    {
        $ts_found = false;

        // Already numeric type, return as float
        if (is_int($numeric) || is_float($numeric)) {
            return (float)$numeric;
        }

        // Not parsable - return null
        if (!is_string($numeric)) {
            return null;
        }

        // Trim and fix input
        $numeric = preg_replace(
            ['/^([\s+ᐩ⁺₊➕﹢＋]*)/u', '/^([-−₋⁻˗][\s]*)/u', '/[\s]*$/'],
            ['', '-', ''],
            $numeric
        );

        // Not a numeric string - return null
        if ($numeric === '') {
            return null;
        }
        if (preg_replace('/^([-]?[0-9,. ]*)$/', '', $numeric) != '') {
            return null;
        }

        // If multiple matches, it´s a thousand separator - remove
        foreach (['.', ',', ' '] as $ts_candidate) {
            if (preg_match_all("/([{$ts_candidate}])([0-9]{3}|$)/", $numeric) > 1) {
                if ($ts_found) {
                    return null; // We have multiple thousand separators - unparsable
                }
                $numeric = str_replace($ts_candidate, '', $numeric);
                $ts_found = true;
            }
        }

        // If there is a period and a comma, the first is the thousand separator - remove
        if (preg_match_all('/([.,])([0-9]{3}|$)/', $numeric, $matches) > 1) {
            $numeric = str_replace($matches[1][0], '', $numeric);
            $ts_found = true;
        }

        // If there are white-spaces, it´s the thousand separator
        if (preg_match('/[ ][0-9]{3}/', $numeric) > 0) {
            $ts_found = true;
        }

        // This is the trickiest case - use loacale as a final resort
        if (!$ts_found && preg_match('/^[0-9]{1,3}[,][0-9]{3}$/', $numeric) > 0) {
            $loc = localeconv();
            $numeric = str_replace($loc['thousands_sep'], '', $numeric);
        }

        // Remove remianing white-spaces
        $numeric = str_replace(' ', '', $numeric);

        // Any remaining comma is a decimal separator
        return (float)str_replace(',', '.', $numeric);
    }
}
