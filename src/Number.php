<?php

namespace Sixteenstudio\Mathematician;

class Number
{

    /**
     * Create a Number class.
     *
     * @param $value
     * @param null $fractionBottomPart
     * @param null $fractionOf
     */
    public function __construct($value, $fractionBottomPart = null, $fractionOf = null)
    {
        if ( ! is_null($fractionBottomPart) && ! is_null($fractionOf)) {
            $this->fraction = new Fraction($value, $fractionBottomPart, $fractionOf);
            $this->decimalValue = $this->fraction->decimalValue();
        } else {
            $this->decimalValue = $value;
        }
    }

    /**
     * The fraction representing this number, if this number can be represented
     * as a fraction of another number
     *
     * @var null|Fraction
     */
    protected $fraction;

    /**
     * The decimal representation of this number, even if it is a fraction.
     *
     * @var string
     */
    protected $decimalValue = "0";

    /**
     * Get the fraction representing this number.
     *
     * @return Fraction|null
     */
    public function getFraction(): Fraction
    {
        return $this->fraction;
    }

    /**
     * Check whether this number can be represented by a fraction or not.
     *
     * @return bool
     */
    public function isFraction(): bool
    {
        return ! is_null($this->fraction);
    }

    /**
     * Get the decimal value of this number.
     *
     * @return string
     */
    public function getDecimalValue(): string
    {
        return $this->decimalValue;
    }

    /**
     * Cast this instance of Number to a string.
     *
     * @return string
     */
    public function __toString(): string
    {
        return $this->getDecimalValue();
    }

}