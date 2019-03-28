<?php
/**
 * File for Numerics library class.
 * @package Phrity > Util > Numerics
 */
namespace Phrity\Util;

/**
 * Numerics utility class.
 * Provides ceil() and floor() with precision.
 */
class Numerics
{
    /**
     * Floor function with precision
     * @param  float    $number    The number to apply floor to
     * @param  integer  $precision Precision to apply
     * @return float    Return floor with precision
     */
    public static function floor($number, $precision = 0)
    {
        $f = \pow(10, $precision);
        return \floor($number * $f) / $f;
    }

    /**
     * Ceil function with precision
     * @param  float    $number    The number to apply ceil to
     * @param  integer  $precision Precision to apply
     * @return float    Return ceil with precision
     */
    public static function ceil($number, $precision = 0)
    {
        $f = \pow(10, $precision);
        return \ceil($number * $f) / $f;
    }
}
