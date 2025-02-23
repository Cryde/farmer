<?php

namespace App\ApiResource\Market;

use ApiPlatform\Metadata\ApiProperty;
use ApiPlatform\Metadata\Post;
use ApiPlatform\OpenApi\Model\Operation;
use App\ApiResource\Farmer\Farm;
use App\State\Processor\Market\SeedBuyProcessor;
use App\Validator\Farm\OwnFarm;
use App\Validator\Seed\CanBuySeeds;
use Symfony\Component\Validator\Constraints as Assert;

#[Post(
    uriTemplate: 'market/seeds',
    openapi: new Operation(tags: ['Market'], summary: 'Endpoint to buy seeds', description: 'Buy seeds, `quantity` must by higher than 0'),
    processor: SeedBuyProcessor::class
)]
#[Assert\Sequentially([
    new OwnFarm,
    new CanBuySeeds
])]
class SeedBuy
{
    #[ApiProperty(example: '/api/farm/FARM-ID')]
    public Farm $farm;
    #[ApiProperty(example: '/api/seeds/TOMATO')]
    public Seed $seed;
    #[ApiProperty(example: 10)]
    public int $quantity;
}