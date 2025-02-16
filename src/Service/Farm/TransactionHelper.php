<?php

namespace App\Service\Farm;
use App\Entity\Farm\Farm;
use App\Factory\Transaction\MooCurrencyFactory;
use App\Repository\Farm\FarmTransactionRepository;
use Brick\Money\Money;

readonly class TransactionHelper
{
    public function __construct(private FarmTransactionRepository $farmTransactionRepository,)
    {
    }

    public function getTotalByFarm(Farm $farm): int
    {
        // later we could cache this
        return Money::ofMinor(
            $this->farmTransactionRepository->getTotalByFarm($farm),
            MooCurrencyFactory::create()
        )->getAmount()->toInt();
    }
}