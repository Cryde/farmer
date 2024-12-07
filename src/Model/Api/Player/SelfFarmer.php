<?php

namespace App\Model\Api\Player;

// Self farmer contains more information
use ApiPlatform\Metadata\ApiResource;

#[ApiResource(operations: [])]
class SelfFarmer
{
    public string $username;
    public float $credits;
}