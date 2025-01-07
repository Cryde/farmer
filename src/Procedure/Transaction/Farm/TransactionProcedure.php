<?php

namespace App\Procedure\Transaction\Farm;

use App\Builder\Entity\Transaction\TransactionBuilder;
use App\Contract\Generator\ShortIdGeneratorInterface;
use App\Entity\Farm\Farm;
use App\Entity\Farm\FarmTransaction;
use App\Enum\Transaction\TransactionType;
use App\Factory\Transaction\MooCurrencyFactory;
use Brick\Money\Money;

readonly class TransactionProcedure
{
    public function __construct(
        private TransactionBuilder        $transactionBuilder,
        private ShortIdGeneratorInterface $shortIdGenerator,
    ) {
    }

    public function createInitialTransaction(Farm $farm, string $amount): FarmTransaction
    {
        return $this->transactionBuilder->buildIn(
            $farm,
            Money::of($amount, MooCurrencyFactory::create()),
            TransactionType::Initial,
            $this->shortIdGenerator->generateShortId(),
            'The initial amount for the farm'
        );
    }
}
