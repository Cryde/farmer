<?php

namespace App\Builder\Api\Player;

use App\Builder\Api\Farm\FarmBuilder;
use App\Builder\Api\Farmer\FarmerBuilder;
use App\Entity\Farm\Farm;
use App\Entity\Player\Farmer;
use App\Model\Api\Register\Register;
use App\Repository\Farm\FarmRepository;

readonly class RegisterBuilder
{
    public function __construct(
        private FarmerBuilder  $farmerBuilder,
        private FarmRepository $farmRepository,
        private FarmBuilder    $farmBuilder,
    ) {
    }

    public function build(Farmer $farmer, string $token): Register
    {
        $register = new Register();
        $register->farmer = $this->farmerBuilder->buildFromEntity($farmer);
        $register->token = $token;
        $register->id = $farmer->getUsername();
        $register->farms = array_map(
            fn (Farm $farm) => $this->farmBuilder->buildFromEntity($farm),
            $this->farmRepository->findBy(['relatedFarmer' => $farmer]),
        );

        return $register;
    }
}