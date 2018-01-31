# Mathematician
A layer on top of BCMath that deals with fractional calculations

## Requirements
The BCMath PHP extension needs to be required in order for this to work.

This package has been developed for PHP 7.1^

## Usage
Instead of using standard BCMath functions such as `bcadd` and `bcsub`, use the `math_` functions provided within the package.

`math_add($leftOperand, $rightOperand, $scale): Sixteenstudio\Mathematician\Number`

`math_sub($leftOperand, $rightOperand, $scale): Sixteenstudio\Mathematician\Number`

`math_mul($leftOperand, $rightOperand, $scale): Sixteenstudio\Mathematician\Number`

`math_div($leftOperand, $rightOperand, $scale): Sixteenstudio\Mathematician\Number`

These functions return an instance of `Sixteenstudio\Mathematician\Number`, unlike BCMath which returns a string representation of the decimal result of the calculation.

This allows us to do some neat things like represent certain operations as fractions, which in turn allows us to do things like this far more accurately than the likes of standard float logic or BCMath can handle:

`(1 / 3) * 3 // Equates to 0.9999999999813`

`bcmul(bcdiv(1, 3, 20), 3, 20) // Equates to 0.99999999999999999997`

`math_mul(math_div(1, 3, 20), 3, 20) // Equates to 1.00000000000000000000`

If you'd prefer not to use the helpers, you can insantiate the `Sixteenstudio\Mathematician\Mathematician` class and use the respective functions directly like so:

```php
<?php

$mathematician = new \Sixteenstudio\Mathematician\Mathematician();

$addition = $mathematician->add(1, 5, 20);
$subtraction = $mathematician->subtract(1, 5, 20);
$multiplication = $mathematician->multiply(1, 5, 20);
$division = $mathematician->divide(1, 5, 20);
```