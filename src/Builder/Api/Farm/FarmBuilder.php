<?php

namespace App\Builder\Api\Farm;

use App\ApiResource\Farmer\Farm;
use App\Entity\Farm\Farm as FarmEntity;
use App\Factory\Transaction\MooCurrencyFactory;
use App\Repository\Farm\FarmExtensionRepository;
use App\Repository\Farm\FarmTransactionRepository;
use Brick\Money\Money;

readonly class FarmBuilder
{
    public function __construct(
        private FarmExtensionRepository $farmExtensionRepository,
        private FarmTransactionRepository $farmTransactionRepository,
    ) {
    }

    public function buildFromEntity(FarmEntity $entity): Farm
    {
        $total = $this->farmTransactionRepository->getTotalByFarm($entity);

        $farm = new Farm();
        $farm->name = $entity->getName();
        $farm->money = Money::ofMinor($total, MooCurrencyFactory::create())->getAmount()->toInt();
        $farm->extensionCount = $this->farmExtensionRepository->count(['farm' => $entity]);

        return $farm;
    }
}