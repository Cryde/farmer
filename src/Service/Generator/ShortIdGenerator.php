<?php

namespace App\Service\Generator;

use App\Contract\Generator\ShortIdGeneratorInterface;
use Random\Randomizer;

class ShortIdGenerator implements ShortIdGeneratorInterface
{
    public function generateShortId(int $length = 25): string
    {
        return new Randomizer()
            ->getBytesFromString('abcdefghijklmnopqrstuvwxyz0123456789', $length);
    }
}