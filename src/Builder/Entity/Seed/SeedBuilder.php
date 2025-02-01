<?php

namespace App\Builder\Entity\Seed;

use App\Entity\Seed\Seed;
use Brick\Money\Money;

class SeedBuilder
{
    public function build(
        string $name,
        string $externalId,
        Money $costPrice,
        Money $salePrice,
    ): Seed
    {
        return new Seed()
            ->setName($name)
            ->setExternalId($externalId)
            ->setBaseCostPrice($costPrice)
            ->setBaseSalePrice($salePrice);
    }
}