<?php

namespace App\State\Processor\Player;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProcessorInterface;
use App\ApiResource\Player\Register;
use App\Model\Api\Register\Register as RegisterModel;
use App\Procedure\Player\RegistrationProcedure;
use Symfony\Component\HttpFoundation\Request;

readonly class RegisterProcessor implements ProcessorInterface
{
    public function __construct(
        private RegistrationProcedure $registrationProcedure,
    ) {
    }

    /**
     * @param Register $data
     * @param array<string, mixed>&array{request?: Request, previous_data?: mixed, resource_class?: string|null, original_data?: mixed} $context
     */
    public function process(mixed $data, Operation $operation, array $uriVariables = [], array $context = []): RegisterModel
    {
        return $this->registrationProcedure->register($data);
    }
}