<?php

namespace App\Builder\Api\Farmer;

use App\ApiResource\Farmer\Farmer;
use App\Entity\Player\Farmer as FarmerEntity;

class FarmerBuilder
{
    public function buildFromEntity(FarmerEntity $farmerEntity): Farmer
    {
        $farmer = new Farmer();
        $farmer->username = $farmerEntity->getUsername();

        return $farmer;
    }
}