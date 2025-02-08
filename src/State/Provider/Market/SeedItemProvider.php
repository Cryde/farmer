<?php

namespace App\State\Provider\Market;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProviderInterface;
use App\ApiResource\Market\Seed;
use App\Builder\Api\Market\SeedBuilder;
use App\Repository\Seed\SeedRepository;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

readonly class SeedItemProvider implements ProviderInterface
{
    public function __construct(private SeedRepository $seedRepository, private SeedBuilder $seedBuilder)
    {
    }

    public function provide(
        Operation $operation,
        array $uriVariables = [],
        array $context = []
    ): Seed {
        if (!$seed = $this->seedRepository->findOneBy(['externalId' => $uriVariables['id']])) {
            throw new NotFoundHttpException('Seed not found');
        }

        return $this->seedBuilder->build($seed);
    }
}