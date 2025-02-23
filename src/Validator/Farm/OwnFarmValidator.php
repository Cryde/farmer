<?php

namespace App\Validator\Farm;

use App\Repository\Farm\FarmRepository;
use App\Service\Farm\FarmHelper;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class OwnFarmValidator extends ConstraintValidator
{
    public function __construct(
        private readonly Security       $security,
        private readonly FarmRepository $farmRepository,
        private readonly FarmHelper     $farmHelper
    ) {
    }

    /**
     * @param OwnFarm $constraint
     */
    public function validate(mixed $value, Constraint $constraint): void
    {
        $farmer = $this->security->getUser();
        $farm = $this->farmRepository->findOneBy(['name' => $value->farm->name]);
        if (!$this->farmHelper->isFarmerFarmOwner($farmer, $farm)) {
            $this->context->buildViolation($constraint->message)
                ->setParameter('{{ value }}', $value->farm->name)
                ->atPath('farm')
                ->setCode(OwnFarm::DO_NOT_OWN_FARM_CODE)
                ->addViolation();
        }
    }
}