<?php

namespace App\State\Provider\Farmer;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProviderInterface;
use App\Builder\Api\Farmer\FarmerBuilder;
use App\Repository\Player\FarmerRepository;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class FarmerProvider implements ProviderInterface
{
    public function __construct(private FarmerRepository $farmerRepository, private FarmerBuilder $farmerBuilder)
    {
    }

    public function provide(Operation $operation, array $uriVariables = [], array $context = []): object|array|null
    {
        if (!$farmer = $this->farmerRepository->findOneBy(['username' => $uriVariables['username']])) {
            throw new NotFoundHttpException('Farmer not found');
        }

        return $this->farmerBuilder->buildFromEntity($farmer);
    }
}