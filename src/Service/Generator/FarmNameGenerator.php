<?php

namespace App\Service\Generator;

use App\Repository\Farm\FarmRepository;

readonly class FarmNameGenerator
{
    public function __construct(private FarmRepository $farmRepository)
    {
    }

    public function generateFarmName(string $farmerName): string
    {
        $i = 1;
        do {
            $farmName = $farmerName . '-FARM-' . $i;
        } while ($this->farmRepository->findOneBy(['name' => $farmName]) !== null);

        return $farmName;
    }
}