<?php

namespace App\Service\Generator;

use App\Contract\Generator\ShortIdGeneratorInterface;

class ShortIdGenerator implements ShortIdGeneratorInterface
{
    public function generateShortId(int $length = 25): string
    {
        return (new \Random\Randomizer())
            ->getBytesFromString('abcdefghijklmnopqrstuvwxyz0123456789', $length);
    }
}