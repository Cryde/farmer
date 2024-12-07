<?php

namespace App\Contract\Generator;
interface AccessTokenGeneratorInterface
{
    public function generate(): string;
}