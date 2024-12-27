<?php

namespace App\ApiResource\Farmer;

use ApiPlatform\Metadata\Get;
use ApiPlatform\OpenApi\Model\Operation;
use App\ApiResource\Player\Register as RegisterApi;
use App\State\Provider\Farm\FarmProvider;
use Symfony\Component\Serializer\Attribute\Groups;

#[Get(
    uriTemplate: 'farm/{name}',
    openapi: new Operation(tags: ['Farm']),
    provider: FarmProvider::class,
)]
#[Groups([RegisterApi::REGISTER])]
class Farm
{
    public string $name;
    public int $extensionCount;
    public int $size = 0;
    public float $money = 0.0;
    public float $energy = 0.0; // percent
    public float $water = 0.0; // percent
}