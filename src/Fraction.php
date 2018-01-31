<?php

namespace Sixteenstudio\Mathematician;

class Fraction
{

    /**
     * Create a Fraction class.
     *
     * @param mixed $topPart
     * @param mixed $bottomPart
     * @param mixed $ofNumber
     */
    public function __construct($topPart, $bottomPart, $ofNumber)
    {
        $this->topPart = (string) $topPart;
        $this->bottomPart = (string) $bottomPart;
        $this->ofNumber = (string) $ofNumber;
    }

    /**
     * The top part of the fraction.
     *
     * @var string
     */
    protected $topPart;

    /**
     * The bottom part of the fraction
     *
     * @var string
     */
    protected $bottomPart;

    /**
     * The number which this number is a fraction of.
     *
     * @var string
     */
    protected $ofNumber;

    /**
     * The calculated decimal value of this fraction.
     *
     * @var string
     */
    protected $decimalValue;

    /**
     * Whether the decimal value has an up-to-date resolution.
     *
     * @var boolean
     */
    protected $resolved = false;

    /**
     * Increase the top part in this fraction by the provided amount.
     *
     * @param mixed $increaseBy
     */
    public function increaseTopPart($increaseBy)
    {
        $this->topPart = (string) ($this->topPart + $increaseBy);
        $this->resolved = false;
    }

    /**
     * Increase the top part in this fraction by the provided amount.
     *
     * @param mixed $increaseBy
     */
    public function decreaseTopPart($increaseBy)
    {
        $this->increaseTopPart(-$increaseBy);
    }

    /**
     * Get what this is a fraction of.
     *
     * @return string
     */
    public function getOf(): string
    {
        return $this->ofNumber;
    }

    /**
     * Get the top part of the fraction.
     *
     * @return string
     */
    public function getTopPart(): string
    {
        return $this->topPart;
    }

    /**
     * Get the bottom part of the fraction.
     *
     * @return string
     */
    public function getBottomPart(): string
    {
        return $this->bottomPart;
    }

    /**
     * Resolve this fraction to a decimal value
     *
     * @return string
     */
    public function decimalValue(): string
    {
        if ( ! $this->resolved) {
            // TODO: Detect a remainder so we can accurately do part of the process, and use non-fractional multiplication
            // for the remainder parts

            $this->decimalValue = bcmul($this->ofNumber, bcdiv($this->bottomPart, $this->topPart, 20), 20);
            $this->resolved = true;
        }

        return $this->decimalValue;
    }

}