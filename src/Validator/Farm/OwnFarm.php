<?php

namespace App\Validator\Farm;

use Symfony\Component\Validator\Constraint;

#[\Attribute]
class OwnFarm extends Constraint
{
    public const string DO_NOT_OWN_FARM_CODE = '93460b11-66b4-403f-9b0a-a96a77b5ff94';
    public string $message = 'You don\'t own the farm "{{ value }}", so you can not do actions on it.';

    public function getTargets(): string
    {
        return self::CLASS_CONSTRAINT;
    }
}