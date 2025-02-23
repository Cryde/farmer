<?php

namespace App\Validator\Farm;

use App\Entity\Farm\Farm;
use App\Entity\Player\Farmer;
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
        /** @var Farmer $farmer */
        $farmer = $this->security->getUser();
        /** @var Farm $farm */
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