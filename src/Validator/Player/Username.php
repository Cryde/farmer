<?php

namespace App\Validator\Player;

use Symfony\Component\Validator\Constraint;

#[\Attribute(\Attribute::TARGET_PROPERTY)]
class Username extends Constraint
{
    public const INVALID_USERNAME_CODE = 'ba537051-1e30-41a2-a416-fe5491bcf354';
    public string $message = 'This username "{{ value }}" is not valid.';
}
