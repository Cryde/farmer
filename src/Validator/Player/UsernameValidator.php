<?php

namespace App\Validator\Player;

use App\Service\Player\UsernameChecker;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class UsernameValidator extends ConstraintValidator
{
    public function __construct(private readonly UsernameChecker $usernameChecker)
    {
    }

    public function validate(mixed $value, Constraint $constraint): void
    {
        /* @var Username $constraint */
        if (!$this->usernameChecker->isValid($value)) {
            $this->context->buildViolation($constraint->message)
                ->setParameter('{{ value }}', $value)
                ->setCode(Username::INVALID_USERNAME_CODE)
                ->addViolation();
        }
    }
}
