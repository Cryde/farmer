<?php

namespace App\Builder\Entity\Farm;
use App\Entity\Extension\Extension;
use App\Entity\Farm\Farm;
use App\Entity\Farm\FarmExtension;

class FarmExtensionEntityBuilder
{
    public function build(Farm $farm, Extension $extension, int $level, string $externalId): FarmExtension
    {
        return (new FarmExtension())
            ->setFarm($farm)
            ->setExtension($extension)
            ->setLevel($level)
            ->setExternalId($externalId)
            ;
    }
}