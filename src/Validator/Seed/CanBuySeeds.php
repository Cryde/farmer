<?php

namespace App\Validator\Seed;


use Symfony\Component\Validator\Constraint;

#[\Attribute]
class CanBuySeeds extends Constraint
{
    public const NOT_ENOUGH_MOONEY_CODE = '5c03055b-810d-4f91-89e6-e1b2b29e0d54';
    public const NOT_ENOUGH_SPACE_CODE = 'd7422255-d2b9-47f5-827e-f841eeac7528';
    public string $notEnoughMoney = 'You don\'t have enough mooney to buy seeds.';
    public string $notEnoughSpace = 'You don\'t have enough space left in your warehouse to buy seeds.';

    public function getTargets(): string
    {
        return self::CLASS_CONSTRAINT;
    }
}