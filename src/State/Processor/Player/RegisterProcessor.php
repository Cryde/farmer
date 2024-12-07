<?php

namespace App\State\Processor\Player;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProcessorInterface;
use App\ApiResource\Player\Register;
use App\Procedure\Player\RegistrationProcedure;

readonly class RegisterProcessor implements ProcessorInterface
{
    public function __construct(
        private RegistrationProcedure $registrationProcedure,
    ) {
    }

    /**
     * @param Register $data
     */
    public function process(mixed $data, Operation $operation, array $uriVariables = [], array $context = [])
    {
        return $this->registrationProcedure->register($data);
    }
}