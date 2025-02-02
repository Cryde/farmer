<?php

namespace App\Builder\Api\Market;

use App\ApiResource\Market\Seed;
use App\Entity\Seed\Seed as SeedEntity;

class SeedBuilder
{
    public function build(SeedEntity $seedEntity): Seed
    {
        $seed = new Seed();
        $seed->id = $seedEntity->getExternalId();
        $seed->name = $seedEntity->getName();
        $seed->price = $seedEntity->getBaseCostPrice()->getAmount()->toFloat();

        return $seed;
    }
}