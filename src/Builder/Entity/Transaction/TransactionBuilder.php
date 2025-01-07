<?php

namespace App\Builder\Entity\Transaction;

use App\Entity\Farm\Farm;
use App\Entity\Farm\FarmTransaction;
use App\Enum\Transaction\TransactionDirection;
use App\Enum\Transaction\TransactionType;
use Brick\Money\Money;

class TransactionBuilder
{
    public function buildOut(
        Farm            $farm,
        Money           $amount,
        TransactionType $transactionType,
        string          $externalId,
        string          $description,
    ): FarmTransaction {
        return (new FarmTransaction())
            ->setAmount($amount)
            ->setDirection(TransactionDirection::Out)
            ->setType($transactionType)
            ->setExternalId($externalId)
            ->setRelatedFarm($farm)
            ->setDescription($description);
    }

    public function buildIn(
        Farm            $farm,
        Money           $amount,
        TransactionType $transactionType,
        string          $externalId,
        string          $description,
    ): FarmTransaction {
        return (new FarmTransaction())
            ->setAmount($amount)
            ->setDirection(TransactionDirection::In)
            ->setType($transactionType)
            ->setExternalId($externalId)
            ->setRelatedFarm($farm)
            ->setDescription($description);
    }
}