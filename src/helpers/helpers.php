<?php

/**
 * This file defines the mathematician helper functions which take number classes and/or
 * real numbers to produce a number result. The mathematician is instantiated to be used
 * in all the helpers.
 */

// TODO: Make a facade of this rather than using it as a global variable
$globalMathematician = new \Sixteenstudio\Mathematician\Mathematician();

function math_add($leftOperand, $rightOperand, $scale): \Sixteenstudio\Mathematician\Number
{
    global $globalMathematician;

    return $globalMathematician->add($leftOperand, $rightOperand, $scale);
}

function math_sub($leftOperand, $rightOperand, $scale): \Sixteenstudio\Mathematician\Number
{
    global $globalMathematician;

    return $globalMathematician->subtract($leftOperand, $rightOperand, $scale);
}

function math_mul($leftOperand, $rightOperand, $scale): \Sixteenstudio\Mathematician\Number
{
    global $globalMathematician;

    return $globalMathematician->multiply($leftOperand, $rightOperand, $scale);
}

function math_div($leftOperand, $rightOperand, $scale): \Sixteenstudio\Mathematician\Number
{
    global $globalMathematician;

    return $globalMathematician->divide($leftOperand, $rightOperand, $scale);
}