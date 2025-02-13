<?php

namespace App\ApiResource\Farmer;

use ApiPlatform\Metadata\ApiProperty;
use ApiPlatform\Metadata\Get;
use ApiPlatform\OpenApi\Model\Operation;
use App\ApiResource\Player\Register as RegisterApi;
use App\State\Provider\Farmer\FarmerProvider;
use Symfony\Component\Serializer\Attribute\Groups;

#[Get(
    uriTemplate: 'farmer/{username}',
    openapi: new Operation(tags: ['Farmer']),
    provider: FarmerProvider::class
)]
class Farmer
{
    #[ApiProperty(identifier: true)]
    #[Groups(RegisterApi::REGISTER)]
    public string $username;
}