<?php

namespace App\State\Provider\Market;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProviderInterface;
use App\Builder\Api\Market\SeedBuilder;
use App\Entity\Seed\Seed;
use App\Repository\Seed\SeedRepository;

readonly class SeedCollectionProvider implements ProviderInterface
{
    public function __construct(private SeedRepository $seedRepository, private SeedBuilder $seedBuilder)
    {
    }

    public function provide(Operation $operation, array $uriVariables = [], array $context = []): object|array|null
    {
        return array_map(
            fn(Seed $seed) => $this->seedBuilder->build($seed),
            $this->seedRepository->findAll()
        );
    }
}