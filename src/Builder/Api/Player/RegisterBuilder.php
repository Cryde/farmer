<?php

namespace App\Builder\Api\Player;

use App\Builder\Api\Farmer\FarmerBuilder;
use App\Entity\Player\Farmer;
use App\Model\Api\Register\Register;

readonly class RegisterBuilder
{
    public function __construct(private FarmerBuilder $farmerBuilder)
    {
    }

    public function build(Farmer $farmer, string $token): Register
    {
        $register = new Register();
        $register->farmer = $this->farmerBuilder->buildFromEntity($farmer);
        $register->token = $token;
        $register->id = $farmer->getUsername();

        return $register;
    }
}