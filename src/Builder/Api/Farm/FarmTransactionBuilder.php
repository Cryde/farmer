<?php

namespace App\Builder\Api\Farm;

use App\ApiResource\Farmer\FarmTransaction;
use App\Entity\Farm\FarmTransaction as FarmTransactionEntity;

class FarmTransactionBuilder
{
    public function build(FarmTransactionEntity $farmTransactionEntity): FarmTransaction
    {
        $farmTransaction = new FarmTransaction();
        $farmTransaction->id = $farmTransactionEntity->getExternalId();
        $farmTransaction->transactionDatetime = $farmTransactionEntity->getCreationDatetime();
        $farmTransaction->amount = $farmTransactionEntity->getAmount()->getAmount()->toInt();
        $farmTransaction->description = $farmTransactionEntity->getDescription();
        $farmTransaction->type = $farmTransactionEntity->getType()->type();
        $farmTransaction->direction = $farmTransactionEntity->getDirection()->type();

        return $farmTransaction;
    }
}