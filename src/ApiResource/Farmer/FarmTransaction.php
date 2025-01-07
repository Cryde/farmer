<?php

namespace App\ApiResource\Farmer;

use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\OpenApi\Model\Operation;
use App\State\Provider\Farm\FarmTransactionProvider;
use App\State\Provider\Farm\FarmTransactionsProvider;

#[GetCollection(
    uriTemplate: 'farm/{name}/transactions',
    uriVariables: ['name'],
    openapi: new Operation(tags: ['Farm']),
    provider: FarmTransactionsProvider::class
)]
#[Get(
    uriTemplate: 'farm/transactions/{id}',
    openapi: new Operation(tags: ['Farm']),
    provider: FarmTransactionProvider::class
)]
class FarmTransaction
{
    public string $id;
    public int $amount;
    public \DateTimeImmutable $transactionDatetime;
    public string $direction;
    public string $type;
    public string $description;
}