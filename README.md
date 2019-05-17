[![Build Status](https://travis-ci.org/sirn-se/phrity-util-numerics.svg?branch=master)](https://travis-ci.org/sirn-se/phrity-util-numerics)
[![Coverage Status](https://coveralls.io/repos/github/sirn-se/phrity-util-numerics/badge.svg?branch=master)](https://coveralls.io/github/sirn-se/phrity-util-numerics?branch=master)

# Numerics utility

Utility library for numerics. Float versions of `ceil()`, `floor()` and `rand()` with precision. An open minded numeric parser plus additional functions.

Current version supports PHP `5.6` and `7.*`.

## Installation

Install with [Composer](https://getcomposer.org/);
```
composer require phrity/util-numerics
```

## Ceil method

Round fractions up, according to precision specifier. A precision of `0` corresponds to PHP `ceil()` function, except it returns `float` instead of `integer`. Precision can also be negative.

```php
// Definition
public static function ceil(float $number, int $precision = 0) : float

// Examples
Numerics::ceil(1234.5678,  2) // 1234.57
Numerics::ceil(1234.5678,  1) // 1234.60
Numerics::ceil(1234.5678,  0) // 1235.00
Numerics::ceil(1234.5678, -1) // 1240.00
Numerics::ceil(1234.5678, -2) // 1300.00
```

## Floor method

Round fractions down, according to precision specifier. A precision of `0` corresponds to PHP `floor()` function, except it returns `float` instead of `integer`. Precision can also be negative.

```php
// Definition
public static function floor(float $number, int $precision = 0) : float

// Examples
Numerics::floor(1234.5678,  2) // 1234.56
Numerics::floor(1234.5678,  1) // 1234.50
Numerics::floor(1234.5678,  0) // 1234.00
Numerics::floor(1234.5678, -1) // 1230.00
Numerics::floor(1234.5678, -2) // 1200.00
```

## Rand method

Float random number with precision. Precision can also be negative. Returns `float`, or `null` if impossible to generate result.

```php
// Definition
public static function rand(float $min, float $max, int $precision = 0) : float

// Examples
Numerics::rand(0, 10) // 0.0 … 10.0
Numerics::rand(0, 100, 2) // 0.00 … 100.00
Numerics::rand(-100, 100, 4) // -100.0000 … 100.0000
Numerics::rand(0.01, 0.97, 4) // 0.0100 … 0.9700
Numerics::rand(9, 11, -1) // 10.0
Numerics::rand(90, 110, -2) // 100.0
```

## Parse method

Numeric parser. Parses number by evaluating input rather than using locale or making explicit assumtions. Returns `float`, or `null` if provided input can not be parsed.

```php
// Definition
public static function parse(mixed $numeric) : float

// Examples - integer and float input
Numerics::parse(1234.56) // 1234.56
Numerics::parse(1234) // 1234.00

// Examples - string input
Numerics::parse('1234.56') // 1234.56
Numerics::parse('1234,56') // 1234.56
Numerics::parse('1 234.56') // 1234.56
Numerics::parse('1 234,56') // 1234.56
Numerics::parse('1,234.56') // 1234.56
Numerics::parse('1.234,56') // 1234.56

// Examples - string input
Numerics::parse(' 1 234.56 ') // 1234.56
Numerics::parse('-1,234.56') // -1234.56
Numerics::parse('+1.234,56') // 1234.56
Numerics::parse('.56') // 0.56
Numerics::parse(',56') // 0.56
```

## Precision method

Count number of relevant decimals in a number.

```php
// Definition
public static function precision(float $number) : int

// Examples
Numerics::precision(12) // 0
Numerics::precision(12.0) // 0
Numerics::precision(12.34) // 2
```

## Versions

* `1.0` - `ceil()` and `floor()` methods
* `1.1` - `parse()` method
* `1.2` - `rand()` and `precision()` methods