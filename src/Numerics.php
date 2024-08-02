<?php

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
    /** @var int $precision Default precision */
    private int|null $precision;
    /** @var int $digits Relevant digits for floats */
    private int $digits;
    /** @var array $localization Localization data */
    private array $localization;

    /**
     * Constructor for this class
     * @param int|null    $precision Default precision
     * @param string|null $locale    Default locale to use as string
     */
    public function __construct(int|null $precision = null, string|null $locale = null)
    {
        $this->precision = $precision;
        $this->digits = PHP_FLOAT_DIG;
        $this->localization = localeconv();
        if ($locale) {
            $this->setLocale($locale);
        }
    }

    /**
     * Set locale on instance, used for format and parse method
     * @param string $locale The locale to use as string
     */
    public function setLocale(string $locale): void
    {
        $original_locale = setlocale(LC_NUMERIC, 0);
        setlocale(LC_NUMERIC, $locale);
        $this->localization = localeconv();
        setlocale(LC_NUMERIC, $original_locale);
    }

    /**
     * Floor function with precision.
     * @param  float    $number    The number to apply floor to
     * @param  int|null $precision Precision to apply
     * @return float               Return floor with precision
     */
    public function floor(float $number, int|null $precision = null): float
    {
        $f = pow(10, $precision ?? $this->precision ?? 0);
        return floor($number * $f) / $f;
    }

    /**
     * Ceil function with precision.
     * @param  float    $number    The number to apply ceil to
     * @param  int|null $precision Precision to apply
     * @return float               Return ceil with precision
     */
    public function ceil(float $number, int|null $precision = null): float
    {
        $f = pow(10, $precision ?? $this->precision ?? 0);
        return ceil($number * $f) / $f;
    }

    /**
     * Round function with precision.
     * @param  float    $number    The number to apply round to
     * @param  int|null $precision Precision to apply
     * @return float               Return round with precision
     */
    public function round(float $number, int|null $precision = null): float
    {
        return round($number, $precision ?? $this->precision ?? 0);
    }

    /**
     * Random float number generator with precision.
     * @param  float      $min       Lowest result
     * @param  float|null $max       Highest result
     * @param  int|null   $precision Precision to use
     * @return float|null            Random number with precision (null if not solvable)
     */
    public function rand(float $min = 0, float|null $max = null, int|null $precision = null): float|null
    {
        $rand_max = mt_getrandmax();
        $max = is_null($max) ? $rand_max : $max;
        $precision = $precision ?? $this->precision ?? 0;

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
     * @param  float $number The number to count decimals on
     * @param  bool  $wide   If all relevant decimals should be considered
     * @return int           Number of decimals
     */
    public function precision(float $number, bool $wide = false): int
    {
        $numstr = $wide ? sprintf("%.{$this->digits}f", $number) : sprintf("%f", $number);
        $pos = strrchr(rtrim($numstr, 0), '.');
        return $pos ? max(0, strlen($pos) - 1) : 0;
    }

    /**
     * Numeric parser.
     * Identifies decimal/thousand separator from input rather than assumptions.
     * @param  int|float|string $numeric  A numeric representation to parse
     * @return float|null                 Return as float (null if parsing failed)
     */
    public function parse($numeric): float|null
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
        if (preg_match_all('/([.,])/', $numeric, $matches) > 1) {
            $numeric = str_replace($matches[1][0], '', $numeric);
            $ts_found = true;
        }

        // If there are white-spaces, it´s the thousand separator
        if (preg_match('/[ ][0-9]{3}/', $numeric) > 0) {
            $ts_found = true;
        }

        // This is the trickiest case - use locale as a final resort
        if (!$ts_found && preg_match('/^[0-9]{1,3}[,][0-9]{3}$/', $numeric) > 0) {
            $numeric = str_replace($this->localization['thousands_sep'], '', $numeric);
        }

        // Remove remaining white-spaces
        $numeric = str_replace(' ', '', $numeric);

        // Any remaining comma is a decimal separator
        return (float)str_replace(',', '.', $numeric);
    }

    /**
     * Numeric formatter.
     * @param  float    $number    The number to count decimals on
     * @param  int|null $precision Precision to use, no rounding by default
     * @return string              Numeric string
     */
    public function format(float $number, int|null $precision = null): string
    {
        $precision = $precision ?? $this->precision ?? $this->precision($number);
        return number_format(
            $this->round($number, $precision),
            $precision,
            $this->localization['decimal_point'],
            $this->localization['thousands_sep']
        );
    }
}
