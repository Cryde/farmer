<?php

namespace App\Builder\Api\Farm;

use App\ApiResource\Farmer\Farm;
use App\Entity\Farm\Farm as FarmEntity;
use App\Repository\Farm\FarmExtensionRepository;
use App\Service\Farm\TransactionHelper;

readonly class FarmBuilder
{
    public function __construct(
        private FarmExtensionRepository $farmExtensionRepository,
        private TransactionHelper $transactionHelper,
    ) {
    }

    public function buildFromEntity(FarmEntity $entity): Farm
    {
        $farm = new Farm();
        $farm->name = $entity->getName();
        $farm->money = $this->transactionHelper->getTotalByFarm($entity);
        $farm->extensionCount = $this->farmExtensionRepository->count(['farm' => $entity]);

        return $farm;
    }
}