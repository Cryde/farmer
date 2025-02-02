<?php

namespace App\ApiResource\Market;

use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\OpenApi\Model\Operation;
use App\State\Provider\Market\SeedCollectionProvider;

#[GetCollection(
    uriTemplate: 'market/seeds',
    openapi: new Operation(tags: ['Market']),
    paginationEnabled: false,
    provider: SeedCollectionProvider::class
)]
class Seed
{
    public string $id;
    public string $name;
    public float $price;
}