<?php
/**
 * Mock class and function for locale functions
 * @package Phrity > Util > Numerics
 */
namespace Phrity\Util;

/**
 * Numerics format test class.
 */
class Locale
{
    /**
     * Register mock function
     */
    public static function setReturn($function, $return)
    {
        $this->function = $return;
    }
}

function localeconv()
{
    return Locale::$localeconv;
}