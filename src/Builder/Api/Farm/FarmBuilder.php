<?php

namespace App\Builder\Api\Farm;

use App\ApiResource\Farmer\Farm;
use App\Entity\Farm\Farm as FarmEntity;
use App\Repository\Farm\FarmExtensionRepository;

readonly class FarmBuilder
{
    public function __construct(
        private FarmExtensionRepository $farmExtensionRepository,
    ) {
    }

    public function buildFromEntity(FarmEntity $entity): Farm
    {
        $farm = new Farm();
        $farm->name = $entity->getName();
        $farm->extensionCount = $this->farmExtensionRepository->count(['farm' => $entity]);

        return $farm;
    }
}