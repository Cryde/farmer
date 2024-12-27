<?php

namespace App\Builder\Entity\Farm;
use App\Entity\Farm\Farm;
use App\Entity\Player\Farmer;

class FarmEntityBuilder
{
    public function build(Farmer $farmer, string $name): Farm
    {
        return (new Farm())
            ->setRelatedFarmer($farmer)
            ->setName($name);
    }
}