<?php

namespace App\Builder\Entity\Farmer;

use App\Entity\Player\Farmer;

class FarmerEntityBuilder
{
    public function build(string $username): Farmer
    {
        return (new Farmer())
            ->setUsername($username);
    }
}