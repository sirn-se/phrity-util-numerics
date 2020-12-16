[![Build Status](https://travis-ci.com/sirn-se/phrity-util-numerics.svg?branch=master)](https://travis-ci.com/sirn-se/phrity-util-numerics)
[![Coverage Status](https://coveralls.io/repos/github/sirn-se/phrity-util-numerics/badge.svg?branch=master)](https://coveralls.io/github/sirn-se/phrity-util-numerics?branch=master)

# Numerics utility

Utility library for numerics. Float versions of `ceil()`, `floor()` and `rand()` with precision. An open minded numeric parser, formatter, plus some additional functions.

Current version supports PHP `^7.1|^8.0`.

## Installation

Install with [Composer](https://getcomposer.org/);
```
composer require phrity/util-numerics
```

## The Numerics class

###  Class synopsis

```php
Phrity\Util\Numerics {

    /* Methods */
    public __construct(int $precision = 0)
    public ceil(number $number, int $precision = null) : float
    public floor(number $number, int $precision = null) : float
    public round(number $number, int $precision = null) : float
    public parse(mixed $numeric) : float
    public format(number $number, int $precision = null) : string
    public rand(number $min = 0, number $max = 0, int $precision = null) : float
    public precision(number $number) : int
    public setLocale(string $locale) : void
}
```

### Constructor

The constructor accepts default precision. Precision can also be negative to achive integer rounding.

```php
$numerics = new Numerics(); // Default precision is 0
$numerics = new Numerics(3); // Default precision is 3
```

### Ceil method

Round fractions up, according to precision specifier. A precision of `0` corresponds to PHP `ceil()` function. Precision can also be negative.

```php
// Precison specified on each call
$numerics = new Numerics();
$numerics->ceil(1234.5678,  2) // 1234.57
$numerics->ceil(1234.5678,  1) // 1234.60
$numerics->ceil(1234.5678,  0) // 1235.00
$numerics->ceil(1234.5678, -1) // 1240.00
$numerics->ceil(1234.5678, -2) // 1300.00

// Precison specified as default, override is possible
$numerics = new Numerics(2);
$numerics->ceil(1234.5678) // 1234.57
$numerics->ceil(1234.5678, 0) // 1235.00
```

### Floor method

Round fractions down, according to precision specifier. A precision of `0` corresponds to PHP `floor()` function. Precision can also be negative.

```php
// Precison specified on each call
$numerics = new Numerics();
$numerics->floor(1234.5678,  2) // 1234.56
$numerics->floor(1234.5678,  1) // 1234.50
$numerics->floor(1234.5678,  0) // 1234.00
$numerics->floor(1234.5678, -1) // 1230.00
$numerics->floor(1234.5678, -2) // 1200.00

// Precison specified as default, override is possible
$numerics = new Numerics(2);
$numerics->floor(1234.5678) // 1234.56
$numerics->floor(1234.5678, 0) // 1234.00
```

### Round method

Standard round, according to precision specifier. Precision can also be negative.

```php
// Precison specified on each call
$numerics = new Numerics();
$numerics->round(1234.5678,  2) // 1234.57
$numerics->round(1234.5678,  1) // 1234.60
$numerics->round(1234.5678,  0) // 1235.00
$numerics->round(1234.5678, -1) // 1230.00
$numerics->round(1234.5678, -2) // 1200.00

// Precison specified as default, override is possible
$numerics = new Numerics(2);
$numerics->round(1234.5678) // 1234.57
$numerics->round(1234.5678, 0) // 1235.00
```

### Parse method

Numeric parser. Parses number by evaluating input rather than using locale or making explicit assumtions. Returns `float`, or `null` if provided input can not be parsed.

```php
$numerics = new Numerics();

// Integer and float input
$numerics->parse(1234.56) // 1234.56
$numerics->parse(1234) // 1234.00

// String input
$numerics->parse('1234.56') // 1234.56
$numerics->parse('1234,56') // 1234.56
$numerics->parse('1 234.56') // 1234.56
$numerics->parse('1 234,56') // 1234.56
$numerics->parse('1,234.56') // 1234.56
$numerics->parse('1.234,56') // 1234.56

// Evaluated string input
$numerics->parse(' 1 234.56 ') // 1234.56
$numerics->parse('-1,234.56') // -1234.56
$numerics->parse('+1.234,56') // 1234.56
$numerics->parse('.56') // 0.56
$numerics->parse(',56') // 0.56
$numerics->parse('12.') // 12.0
$numerics->parse('12,') // 12.0

// Locale support for fringe cases
$numerics->setLocale('sv_SE');
$numerics->parse('123,456') // 123.456
$numerics->setLocale('en_US');
$numerics->parse('123,456') // 123456.0
```

### Format method

Numeric formatter. Formats numbers according to precision (rounding and padding) and locale.

```php
$numerics = new Numerics();

$numerics->setLocale('sv_SE');
$numerics->format(1234.5678, 2) // "1 234,56"
$numerics->format(1234, 2) // "1 234,00"
$numerics->format(1234.5678, 0) // "1 234"

$numerics->setLocale('en_US');
$numerics->format(1234.5678, 2) // "1,234.56"
$numerics->format(1234, 2) // "1,234.00"
$numerics->format(1234.5678, 0) // "1,234"
```

### Rand method

Float random number with precision. Precision can also be negative. Returns `float`, or `null` if impossible to generate result.

```php
// Precison specified on each call
$numerics = new Numerics();
$numerics->rand(0, 10) // 0.0 … 10.0
$numerics->rand(0, 100, 2) // 0.00 … 100.00
$numerics->rand(-100, 100, 4) // -100.0000 … 100.0000
$numerics->rand(0.01, 0.97, 4) // 0.0100 … 0.9700
$numerics->rand(9, 11, -1) // 10.0
$numerics->rand(90, 110, -2) // 100.0

// Precison specified as default, override is possible
$numerics = new Numerics(2);
$numerics->rand(0, 100) // 0.00 … 100.00
```

### Precision method

Count number of relevant decimals in a number.

```php
$numerics = new Numerics();
$numerics->precision(12) // 0
$numerics->precision(12.0) // 0
$numerics->precision(12.34) // 2
```

### setLocale method

Affects the `format()` method and fringe case in `parse()` method. If not set, current locale will be used in these methods.

```php
$numerics = new Numerics();
$numerics->setLocale('sv_SE'); // Set to Swedish
```

## Versions

| Version | PHP | |
| --- | --- | --- |
| `2.1` | `^7.1\|^8.0` |  |
| `2.0` | `^7.1 | Instanceable, `format()` method, ability to specify locale |
| `1.2` | `>=5.6 | `rand()` and `precision()` methods |
| `1.1` | `>=5.6` | `parse()` method |
| `1.0` | `>=5.6` | `ceil()` and `floor()` methods |
