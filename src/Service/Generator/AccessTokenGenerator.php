<?php

namespace App\Service\Generator;

use App\Contract\Generator\AccessTokenGeneratorInterface;

class AccessTokenGenerator implements AccessTokenGeneratorInterface
{
    public function generate(): string
    {
        return bin2hex(random_bytes(50));
    }
}