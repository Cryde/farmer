<?php

namespace App\State\Provider\Farm;
use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProviderInterface;
use App\Builder\Api\Farm\FarmBuilder;
use App\Repository\Farm\FarmRepository;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

readonly class FarmProvider implements ProviderInterface
{
    public function __construct(
        private FarmRepository $farmRepository,
        private FarmBuilder $farmBuilder,
    )
    {
    }

    public function provide(Operation $operation, array $uriVariables = [], array $context = []): object|array|null
    {
        if (!$farm = $this->farmRepository->findOneBy(['name' => $uriVariables['name']])) {
            throw new NotFoundHttpException('Farm not found');
        }

        return $this->farmBuilder->buildFromEntity($farm);
    }
}