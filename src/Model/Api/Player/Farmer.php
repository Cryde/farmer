<?php

namespace App\Model\Api\Player;

use ApiPlatform\Metadata\ApiProperty;
use ApiPlatform\Metadata\ApiResource;

#[ApiResource(operations: [])]
class Farmer
{
    #[ApiProperty(identifier: true)]
    public string $username;
}