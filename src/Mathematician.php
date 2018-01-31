<?php

namespace Sixteenstudio\Mathematician;

class Mathematician
{

    const OPERATION_ADDITION = 'addition';
    const OPERATION_SUBTRACTION = 'subtraction';
    const OPERATION_MULTIPLICATION = 'multiplication';
    const OPERATION_DIVISION = 'division';

    /**
     * Add left to right.
     *
     * @param mixed $leftOperand
     * @param mixed $rightOperand
     * @param mixed $scale
     *
     * @return Number
     * @throws \Exception
     */
    public function add($leftOperand, $rightOperand, $scale): Number
    {
        $operands = $this->operandsToNumbers([$leftOperand, $rightOperand]);

        return $this->applyOperation(self::OPERATION_ADDITION, $operands, $scale);
    }

    /**
     * Subtract right from left.
     *
     * @param mixed $leftOperand
     * @param mixed $rightOperand
     * @param mixed $scale
     *
     * @return Number
     * @throws \Exception
     */
    public function subtract($leftOperand, $rightOperand, $scale): Number
    {
        $operands = $this->operandsToNumbers([$leftOperand, $rightOperand]);

        return $this->applyOperation(self::OPERATION_SUBTRACTION, $operands, $scale);
    }

    /**
     * Multiply left by right.
     *
     * @param mixed $leftOperand
     * @param mixed $rightOperand
     * @param mixed $scale
     *
     * @return Number
     * @throws \Exception
     */
    public function multiply($leftOperand, $rightOperand, $scale): Number
    {
        $operands = $this->operandsToNumbers([$leftOperand, $rightOperand]);

        return $this->applyOperation(self::OPERATION_MULTIPLICATION, $operands, $scale);
    }

    /**
     * Divide left by right.
     *
     * @param mixed $leftOperand
     * @param mixed $rightOperand
     * @param mixed $scale
     *
     * @return Number
     * @throws \Exception
     */
    public function divide($leftOperand, $rightOperand, $scale): Number
    {
        $operands = $this->operandsToNumbers([$leftOperand, $rightOperand]);

        return $this->applyOperation(self::OPERATION_DIVISION, $operands, $scale);
    }

    /**
     * Apply an operation to one or more operands.
     *
     * @param string $operation
     * @param Number[] $operands
     * @param int $scale
     * @return Number
     * @throws \Exception
     */
    public function applyOperation(string $operation, array $operands, int $scale): Number
    {
        $number = null;
        // TODO: Make this function more DRY
        switch ($operation) {
            case self::OPERATION_ADDITION:
                if ($operands[0]->isFraction()
                    && $operands[1]->isFraction()
                    && $this->fractionsAreCompatible($operands[0]->getFraction(), $operands[1]->getFraction())) {
                    $number = clone $operands[0];
                    $number->getFraction()->increaseTopPart($operands[1]->getFraction()->getTopPart());
                } else {
                    $value = bcadd($operands[0]->getDecimalValue(), $operands[1]->getDecimalValue());
                    $number = new Number($value);
                }
                break;
            case self::OPERATION_SUBTRACTION:
                if ($operands[0]->isFraction()
                    && $operands[1]->isFraction()
                    && $this->fractionsAreCompatible($operands[0]->getFraction(), $operands[1]->getFraction())) {
                    $number = clone $operands[0];
                    $number->getFraction()->decreaseTopPart($operands[1]->getFraction()->getTopPart());
                } else {
                    $value = bcadd($operands[0]->getDecimalValue(), $operands[1]->getDecimalValue());
                    $number = new Number($value);
                }
                break;
            case self::OPERATION_MULTIPLICATION:
                if ($operands[0]->isFraction()
                    && $operands[1]->isFraction()
                    && $this->fractionsAreCompatible($operands[0]->getFraction(), $operands[1]->getFraction())) {
                    /** @var Fraction $fractionOne */
                    $fractionOne = $operands[0]->getFraction();

                    /** @var Fraction $fractionTwo */
                    $fractionTwo =  $operands[1]->getFraction();

                    // Get the two top parts multiplied by eachother & add the difference of this to the first top part
                    // fraction to get the new result
                    $topPartIncreaseBy = bcsub($fractionOne->getTopPart(), bcmul($fractionOne->getTopPart(), $fractionTwo->getTopPart(), 20), 0);

                    $number = clone $operands[0];
                    $number->getFraction()->increaseTopPart($topPartIncreaseBy);
                } elseif ($operands[0]->isFraction() || $operands[1]->isFraction()) {
                    /** @var Number $fractionNumber */
                    $fractionNumber = $operands[0]->isFraction() ? $operands[0] : $operands[1];
                    $multiplier = $operands[0]->isFraction() ? $operands[1] : $operands[0];
                    $newTopPart = bcmul($fractionNumber->getFraction()->getTopPart(), $multiplier, 20);

                    return new Number($newTopPart,
                        $fractionNumber->getFraction()->getBottomPart(),
                        $fractionNumber->getFraction()->getOf());
                } else {
                    $value = bcmul($operands[0]->getDecimalValue(), $operands[1]->getDecimalValue(), 20);
                    $number = new Number($value);
                }
                break;
            case self::OPERATION_DIVISION:
                // TODO: Only create fractions where recursion occurs
                // TODO (extra): Divide the value of the fraction 'ofNumber'
                // TODO (extra): Consider nesting fractions when division of an existing fraction occurs and recursion
                // occurs?
                $value = bcdiv($operands[0]->getDecimalValue(), $operands[1]->getDecimalValue());

                // Any division operation can be correctly represented by 1 over the second operand of the entire
                // decimal value of the first operand
                $number = new Number(1, $operands[1]->getDecimalValue(), $operands[0]->getDecimalValue());
                break;
        }

        if (is_null($number)) {
            throw new \Exception('Invalid mathematical operation attempted: ' . $operation);
        }

        return $number;
    }

    /**
     * Get an array of operands as Number instances.
     *
     * @param array $operands
     * @return Number[]
     */
    protected function operandsToNumbers(array $operands): array
    {
        $numberOperands = [];

        foreach ($operands as $operand) {
            if ( ! $operand instanceof Number) {
                $numberOperands[] = new Number($operand);
            } else {
                $numberOperands[] = $operand;
            }
        }

        return $numberOperands;
    }

    /**
     * Check that one fraction can be incorporated into another without having to change the
     * bottom part.
     *
     * @param Fraction $fractionOne
     * @param Fraction $fractionTwo
     * @return bool
     */
    protected function fractionsAreCompatible(Fraction $fractionOne, Fraction $fractionTwo): bool
    {
        return $fractionOne->getBottomPart() === $fractionTwo->getBottomPart();
    }

}