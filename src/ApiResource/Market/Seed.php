<?php

namespace App\ApiResource\Market;

use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\OpenApi\Model\Operation;
use App\State\Provider\Market\SeedCollectionProvider;
use App\State\Provider\Market\SeedItemProvider;

#[GetCollection(
    uriTemplate: 'market/seeds',
    openapi: new Operation(tags: ['Market'], summary: 'Endpoint to list seeds and their price'),
    paginationEnabled: false,
    provider: SeedCollectionProvider::class
)]
#[Get(
    uriTemplate: 'seeds/{id}',
    openapi: new Operation(tags: ['Seed']),
    provider: SeedItemProvider::class
)]
class Seed
{
    public string $id;
    public string $name;
    public float $price;
    // todo available quantity ?
}