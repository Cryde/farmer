<?php

namespace App\Service\Generator;

use App\Contract\Generator\ShortIdGeneratorInterface;

class DummyShortIdGenerator implements ShortIdGeneratorInterface
{
    private int $counter = 1;

    public function generateShortId(int $length = 5): string
    {
        return str_repeat((string)++$this->counter, $length);
    }
}