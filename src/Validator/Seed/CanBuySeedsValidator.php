<?php

namespace App\Validator\Seed;

use App\ApiResource\Market\SeedBuy;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class CanBuySeedsValidator extends ConstraintValidator
{
    /**
     * @param SeedBuy     $value
     * @param CanBuySeeds $constraint
     */
    public function validate(mixed $value, Constraint $constraint)
    {
        $mooneyRest = $value->farm->money - ($value->seed->price * $value->quantity);
        if ($mooneyRest < 0) {
            $this->context->buildViolation($constraint->notEnoughMoney)
                ->atPath('farm')
                ->setCode(CanBuySeeds::NOT_ENOUGH_MOONEY_CODE)
                ->addViolation();
        }
        $maxWarehouseSize = 1000; // for now, it's a static size, but later it will depend on the warehouse level and the quantity of things in it
        if ($value->quantity > $maxWarehouseSize) {
            $this->context->buildViolation($constraint->notEnoughSpace)
                ->atPath('quantity')
                ->setCode(CanBuySeeds::NOT_ENOUGH_SPACE_CODE)
                ->addViolation();
        }
    }
}