<?php

namespace App\State\Provider\Extension;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProviderInterface;
use App\Builder\Api\Extension\ExtensionBuilder;
use App\Entity\Extension\Extension;
use App\Repository\Extension\ExtensionRepository;

readonly class ExtensionCollectionProvider implements ProviderInterface
{
    public function __construct(
        private ExtensionRepository $extensionRepository,
        private ExtensionBuilder    $extensionBuilder
    ) {
    }

    public function provide(Operation $operation, array $uriVariables = [], array $context = []): object|array|null
    {
        return array_map(
            fn(Extension $extension) => $this->extensionBuilder->buildFromEntity($extension),
            $this->extensionRepository->findAll()
        );
    }
}