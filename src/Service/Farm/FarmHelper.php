<?php

namespace App\Service\Farm;

use App\Entity\Farm\Farm;
use App\Entity\Player\Farmer;

class FarmHelper
{
    public function isFarmerFarmOwner(Farmer $farmer, Farm $farm): bool
    {
        return $farmer->getId() === $farm->getRelatedFarmer()->getId();
    }
}