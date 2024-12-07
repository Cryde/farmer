<?php

namespace App\Service\Generator;

use App\Contract\Generator\AccessTokenGeneratorInterface;

class DummyAccessTokenGenerator implements AccessTokenGeneratorInterface
{
    public function generate(): string
    {
        return 'dummy-access-token';
    }
}