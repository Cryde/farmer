<?php

namespace App\Contract\Generator;
interface ShortIdGeneratorInterface
{
    public function generateShortId(int $length = 25): string;
}