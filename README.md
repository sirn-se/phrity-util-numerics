[![Build Status](https://travis-ci.org/sirn-se/phrity-util-numerics.svg?branch=master)](https://travis-ci.org/sirn-se/phrity-util-numerics)
[![Coverage Status](https://coveralls.io/repos/github/sirn-se/phrity-util-numerics/badge.svg?branch=master)](https://coveralls.io/github/sirn-se/phrity-util-numerics?branch=master)

# Numerics utility

Utility library for numerics. Float versions of ceil() and floor() with precision. An open minded numeric parser.

## Ceil method

Round fractions up, according to precision specifier. A precision of `0` corresponds to PHP standard ceil() function, except it returns as float instaed of integer. Precision can also be negative.

```php
Numerics::ceil(1234.5678,  2) // -> 1234.57
Numerics::ceil(1234.5678,  1) // -> 1234.60
Numerics::ceil(1234.5678,  0) // -> 1235.00
Numerics::ceil(1234.5678, -1) // -> 1240.00
Numerics::ceil(1234.5678, -2) // -> 1300.00
```

## Floor method

Round fractions down, according to precision specifier. A precision of `0` corresponds to PHP standard floor() function, except it returns as float instaed of integer. Precision can also be negative.

```php
Numerics::floor(1234.5678,  2) // -> 1234.56
Numerics::floor(1234.5678,  1) // -> 1234.50
Numerics::floor(1234.5678,  0) // -> 1234.00
Numerics::floor(1234.5678, -1) // -> 1230.00
Numerics::floor(1234.5678, -2) // -> 1200.00
```

## Parse method

Numeric parser. Parses number by evaluating input rather than using locale or making explicit assumtions. Returns `null` if provided input can not be parsed. Always returns a float on success.

```php
// Integer and float input
Numerics::parse(1234.56) // -> 1234.56
Numerics::parse(1234) // -> 1234.00

// String input
Numerics::parse('1234.56') // -> 1234.56
Numerics::parse('1234,56') // -> 1234.56
Numerics::parse('1 234.56') // -> 1234.56
Numerics::parse('1 234,56') // -> 1234.56
Numerics::parse('1,234.56') // -> 1234.56
Numerics::parse('1.234,56') // -> 1234.56

Numerics::parse(' 1 234.56 ') // -> 1234.56
Numerics::parse('-1,234.56') // -> -1234.56
Numerics::parse('+1.234,56') // -> 1234.56
Numerics::parse('.56') // -> 0.56
Numerics::parse(',56') // -> 0.56

```
