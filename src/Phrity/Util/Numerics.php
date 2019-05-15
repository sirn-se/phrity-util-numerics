<?php
/**
 * File for Numerics library class.
 * @package Phrity > Util > Numerics
 */
namespace Phrity\Util;

/**
 * Numerics utility class.
 * Provides ceil(), floor(), rand() with precision, and a numeric parser.
 */
class Numerics
{
    /**
     * Floor function with precision.
     * @param  float    $number    The number to apply floor to
     * @param  integer  $precision Precision to apply
     * @return float               Return floor with precision
     */
    public static function floor($number, $precision = 0)
    {
        $f = pow(10, $precision);
        return floor($number * $f) / $f;
    }

    /**
     * Ceil function with precision.
     * @param  float    $number    The number to apply ceil to
     * @param  integer  $precision Precision to apply
     * @return float    Return ceil with precision
     */
    public static function ceil($number, $precision = 0)
    {
        $f = pow(10, $precision);
        return ceil($number * $f) / $f;
    }

    /**
     * Random number generator with precision.
     * @param  float    $min       Lowest result
     * @param  float    $max       Highest result
     * @param  integer  $precision Precision to apply
     * @return float               Return rand with precision
     */
    public static function rand($min = 0, $max = null, $precision = 0)
    {
        $rand_max = mt_getrandmax();
        $max = is_null($max) ? mt_getrandmax() : $max;
        
        // Decrease precision (if neccesary) to fit rand max
        do {
            $f = pow(10, $precision);
            $real_min = ceil($min * $f);
            $real_max = floor($max * $f);
            $precision--;

            // Impossbile to get a number with min/max/precision combination
            if ($real_min > $real_max) {
                return null;
            }
        } while ($real_max - $real_min > $rand_max);

        return mt_rand($real_min, $real_max) / $f;
    }

    /**
     * Get number of decimals in a number.
     * @param  float $number The number to count decimals on
     * @return int           Number of decimals
     */
    public function precision($number)
    {
        return max(0, strlen(strrchr((string)$number, '.')) - 1);
    }

    /**
     * Numeric parser.
     * Identifies decimal/thousand separator from input rather than assumptions.
     * @param  int|float|string $numeric  A numeric representation to parse
     * @return float|null                 Return as float, or null if parsing failed
     */
    public static function parse($numeric)
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

        // If there is a period and a comma, the first one is the thousand separator - remove
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
