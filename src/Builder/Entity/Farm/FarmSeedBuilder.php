<?php

namespace App\Builder\Entity\Farm;
use App\Entity\Farm\Farm;
use App\Entity\Farm\FarmSeed;
use App\Entity\Seed\Seed;

class FarmSeedBuilder
{
    public function build(Farm $farm, Seed $seed, int $quantity): FarmSeed
    {
        return new FarmSeed()
            ->setRelatedFarm($farm)
            ->setSeed($seed)
            ->setQuantity($quantity)
            ;
    }
}