<?php

namespace App\Model\Api\Register;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Get;
use App\ApiResource\Farmer\Farm;
use App\ApiResource\Farmer\Farmer;
use App\ApiResource\Player\Register as RegisterApi;
use Symfony\Component\Serializer\Attribute\Groups;
use Symfony\Component\Serializer\Attribute\Ignore;

#[ApiResource(operations: [])]
#[Get(uriTemplate: 'farmer/register/{id}', openapi: false, read: false)]
#[Groups([RegisterApi::REGISTER])]
class Register
{
    #[Ignore]
    public string $id;
    public string $token;
    public Farmer $farmer;
    /**
     * @var Farm[]
     */
    public $farms;
}